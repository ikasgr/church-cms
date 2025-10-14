<?php

namespace App\Controllers;

use App\Models\SurveyModel;
use App\Models\SurveyQuestionModel;
use App\Models\SurveyResponseModel;
use App\Models\FeedbackModel;
use App\Models\GuestbookModel;

class AdminInteraksi extends BaseController
{
    protected $surveyModel;
    protected $questionModel;
    protected $responseModel;
    protected $feedbackModel;
    protected $guestbookModel;

    public function __construct()
    {
        $this->surveyModel = new SurveyModel();
        $this->questionModel = new SurveyQuestionModel();
        $this->responseModel = new SurveyResponseModel();
        $this->feedbackModel = new FeedbackModel();
        $this->guestbookModel = new GuestbookModel();

        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/admin/login');
        }
    }

    // Survey Management
    public function surveys()
    {
        $data = [
            'title' => 'Survei & Jajak Pendapat',
            'surveys' => $this->surveyModel->orderBy('created_at', 'DESC')->findAll()
        ];

        return view('admin/interaksi/surveys/index', $data);
    }

    public function surveyCreate()
    {
        $data = [
            'title' => 'Tambah Survei'
        ];

        if ($this->request->getMethod() === 'POST') {
            $rules = [
                'title' => 'required|min_length[3]|max_length[255]',
                'type' => 'required|in_list[survey,poll]',
                'start_date' => 'required|valid_date',
                'end_date' => 'required|valid_date',
            ];

            if ($this->validate($rules)) {
                $insertData = [
                    'title' => $this->request->getPost('title'),
                    'description' => $this->request->getPost('description'),
                    'type' => $this->request->getPost('type'),
                    'start_date' => $this->request->getPost('start_date'),
                    'end_date' => $this->request->getPost('end_date'),
                    'is_active' => $this->request->getPost('is_active') ? 1 : 0,
                    'is_anonymous' => $this->request->getPost('is_anonymous') ? 1 : 0,
                    'max_responses' => $this->request->getPost('max_responses'),
                    'created_by' => session()->get('userId'),
                ];

                $this->surveyModel->insert($insertData);
                session()->setFlashdata('success', 'Survei berhasil ditambahkan');
                return redirect()->to('/admin/interaksi/surveys');
            } else {
                $data['validation'] = $this->validator;
            }
        }

        return view('admin/interaksi/surveys/create', $data);
    }

    public function surveyEdit($id)
    {
        $survey = $this->surveyModel->find($id);
        if (!$survey) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = [
            'title' => 'Edit Survei',
            'survey' => $survey
        ];

        if ($this->request->getMethod() === 'POST') {
            $rules = [
                'title' => 'required|min_length[3]|max_length[255]',
                'type' => 'required|in_list[survey,poll]',
                'start_date' => 'required|valid_date',
                'end_date' => 'required|valid_date',
            ];

            if ($this->validate($rules)) {
                $updateData = [
                    'title' => $this->request->getPost('title'),
                    'description' => $this->request->getPost('description'),
                    'type' => $this->request->getPost('type'),
                    'start_date' => $this->request->getPost('start_date'),
                    'end_date' => $this->request->getPost('end_date'),
                    'is_active' => $this->request->getPost('is_active') ? 1 : 0,
                    'is_anonymous' => $this->request->getPost('is_anonymous') ? 1 : 0,
                    'max_responses' => $this->request->getPost('max_responses'),
                ];

                $this->surveyModel->update($id, $updateData);
                session()->setFlashdata('success', 'Survei berhasil diperbarui');
                return redirect()->to('/admin/interaksi/surveys');
            } else {
                $data['validation'] = $this->validator;
            }
        }

        return view('admin/interaksi/surveys/edit', $data);
    }

    public function surveyQuestions($surveyId)
    {
        $survey = $this->surveyModel->find($surveyId);
        if (!$survey) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = [
            'title' => 'Pertanyaan Survei',
            'survey' => $survey,
            'questions' => $this->questionModel->where('survey_id', $surveyId)->orderBy('order_position', 'ASC')->findAll()
        ];

        return view('admin/interaksi/surveys/questions', $data);
    }

    public function surveyResults($surveyId)
    {
        $survey = $this->surveyModel->find($surveyId);
        if (!$survey) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $questions = $this->questionModel->where('survey_id', $surveyId)->orderBy('order_position', 'ASC')->findAll();
        $results = [];

        foreach ($questions as $question) {
            $responses = $this->responseModel->getAnswerStatistics($question['id']);
            $results[$question['id']] = [
                'question' => $question,
                'responses' => $responses,
                'total' => array_sum(array_column($responses, 'count'))
            ];
        }

        $data = [
            'title' => 'Hasil Survei',
            'survey' => $survey,
            'results' => $results,
            'totalResponses' => $this->surveyModel->getResponseCount($surveyId)
        ];

        return view('admin/interaksi/surveys/results', $data);
    }

    public function surveyDelete($id)
    {
        $this->surveyModel->delete($id);
        session()->setFlashdata('success', 'Survei berhasil dihapus');
        return redirect()->to('/admin/interaksi/surveys');
    }

    // Feedback Management
    public function feedback()
    {
        $status = $this->request->getGet('status');
        $type = $this->request->getGet('type');
        $builder = $this->feedbackModel;

        if ($status) {
            $builder->where('status', $status);
        }

        if ($type) {
            $builder->where('type', $type);
        }

        $data = [
            'title' => 'Masukan & Saran',
            'feedback' => $builder->orderBy('created_at', 'DESC')->findAll(),
            'status' => $status,
            'type' => $type
        ];

        return view('admin/interaksi/feedback/index', $data);
    }

    public function feedbackView($id)
    {
        $feedback = $this->feedbackModel->find($id);
        if (!$feedback) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // Mark as read
        if ($feedback['status'] == 'new') {
            $this->feedbackModel->markAsRead($id);
        }

        $data = [
            'title' => 'Detail Masukan',
            'feedback' => $feedback
        ];

        return view('admin/interaksi/feedback/view', $data);
    }

    public function feedbackRespond($id)
    {
        if ($this->request->getMethod() === 'POST') {
            $response = $this->request->getPost('response');
            $userId = session()->get('userId');

            $this->feedbackModel->respond($id, $response, $userId);
            session()->setFlashdata('success', 'Tanggapan berhasil dikirim');
        }

        return redirect()->to('/admin/interaksi/feedback/view/' . $id);
    }

    public function feedbackDelete($id)
    {
        $this->feedbackModel->delete($id);
        session()->setFlashdata('success', 'Masukan berhasil dihapus');
        return redirect()->to('/admin/interaksi/feedback');
    }

    // Guestbook Management
    public function guestbook()
    {
        $data = [
            'title' => 'Buku Tamu',
            'guestbook' => $this->guestbookModel->orderBy('created_at', 'DESC')->findAll()
        ];

        return view('admin/interaksi/guestbook/index', $data);
    }

    public function guestbookView($id)
    {
        $entry = $this->guestbookModel->find($id);
        if (!$entry) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = [
            'title' => 'Detail Buku Tamu',
            'entry' => $entry
        ];

        return view('admin/interaksi/guestbook/view', $data);
    }

    public function guestbookApprove($id)
    {
        $userId = session()->get('userId');
        $this->guestbookModel->approve($id, $userId);
        session()->setFlashdata('success', 'Buku tamu berhasil disetujui');
        return redirect()->to('/admin/interaksi/guestbook');
    }

    public function guestbookDelete($id)
    {
        $this->guestbookModel->delete($id);
        session()->setFlashdata('success', 'Buku tamu berhasil dihapus');
        return redirect()->to('/admin/interaksi/guestbook');
    }
}
