<?php

namespace App\Controllers;

use App\Models\IbadahModel;
use App\Models\KegiatanModel;
use App\Models\KegiatanRegistrationModel;

class AdminIbadah extends BaseController
{
    protected $ibadahModel;
    protected $kegiatanModel;
    protected $registrationModel;

    public function __construct()
    {
        $this->ibadahModel = new IbadahModel();
        $this->kegiatanModel = new KegiatanModel();
        $this->registrationModel = new KegiatanRegistrationModel();

        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/admin/login');
        }
    }

    // Ibadah Schedule Management
    public function index()
    {
        $data = [
            'title' => 'Jadwal Ibadah',
            'ibadah' => $this->ibadahModel->orderBy('day_of_week', 'ASC')->orderBy('time', 'ASC')->findAll()
        ];

        return view('admin/ibadah/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Jadwal Ibadah'
        ];

        if ($this->request->getMethod() === 'POST') {
            $rules = [
                'title' => 'required|min_length[3]|max_length[255]',
                'day_of_week' => 'required|in_list[0,1,2,3,4,5,6]',
                'time' => 'required',
            ];

            if ($this->validate($rules)) {
                $insertData = [
                    'title' => $this->request->getPost('title'),
                    'description' => $this->request->getPost('description'),
                    'day_of_week' => $this->request->getPost('day_of_week'),
                    'time' => $this->request->getPost('time'),
                    'location' => $this->request->getPost('location'),
                    'minister' => $this->request->getPost('minister'),
                    'is_active' => $this->request->getPost('is_active') ? 1 : 0,
                ];

                $this->ibadahModel->insert($insertData);
                session()->setFlashdata('success', 'Jadwal ibadah berhasil ditambahkan');
                return redirect()->to('/admin/ibadah');
            } else {
                $data['validation'] = $this->validator;
            }
        }

        return view('admin/ibadah/create', $data);
    }

    public function edit($id)
    {
        $ibadah = $this->ibadahModel->find($id);
        if (!$ibadah) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = [
            'title' => 'Edit Jadwal Ibadah',
            'ibadah' => $ibadah
        ];

        if ($this->request->getMethod() === 'POST') {
            $rules = [
                'title' => 'required|min_length[3]|max_length[255]',
                'day_of_week' => 'required|in_list[0,1,2,3,4,5,6]',
                'time' => 'required',
            ];

            if ($this->validate($rules)) {
                $updateData = [
                    'title' => $this->request->getPost('title'),
                    'description' => $this->request->getPost('description'),
                    'day_of_week' => $this->request->getPost('day_of_week'),
                    'time' => $this->request->getPost('time'),
                    'location' => $this->request->getPost('location'),
                    'minister' => $this->request->getPost('minister'),
                    'is_active' => $this->request->getPost('is_active') ? 1 : 0,
                ];

                $this->ibadahModel->update($id, $updateData);
                session()->setFlashdata('success', 'Jadwal ibadah berhasil diperbarui');
                return redirect()->to('/admin/ibadah');
            } else {
                $data['validation'] = $this->validator;
            }
        }

        return view('admin/ibadah/edit', $data);
    }

    public function delete($id)
    {
        $this->ibadahModel->delete($id);
        session()->setFlashdata('success', 'Jadwal ibadah berhasil dihapus');
        return redirect()->to('/admin/ibadah');
    }

    // Kegiatan Management
    public function kegiatan()
    {
        $category = $this->request->getGet('category');
        $builder = $this->kegiatanModel;

        if ($category) {
            $builder->where('category', $category);
        }

        $data = [
            'title' => 'Kegiatan Gereja',
            'kegiatan' => $builder->orderBy('date_start', 'DESC')->findAll(),
            'category' => $category
        ];

        return view('admin/ibadah/kegiatan/index', $data);
    }

    public function kegiatanCreate()
    {
        $data = [
            'title' => 'Tambah Kegiatan'
        ];

        if ($this->request->getMethod() === 'POST') {
            $rules = [
                'title' => 'required|min_length[3]|max_length[255]',
                'category' => 'required',
                'date_start' => 'required|valid_date',
            ];

            if ($this->validate($rules)) {
                $insertData = [
                    'title' => $this->request->getPost('title'),
                    'slug' => url_title($this->request->getPost('title'), '-', true),
                    'description' => $this->request->getPost('description'),
                    'category' => $this->request->getPost('category'),
                    'date_start' => $this->request->getPost('date_start'),
                    'date_end' => $this->request->getPost('date_end'),
                    'time_start' => $this->request->getPost('time_start'),
                    'time_end' => $this->request->getPost('time_end'),
                    'location' => $this->request->getPost('location'),
                    'organizer' => $this->request->getPost('organizer'),
                    'contact_person' => $this->request->getPost('contact_person'),
                    'contact_phone' => $this->request->getPost('contact_phone'),
                    'max_participants' => $this->request->getPost('max_participants'),
                    'registration_required' => $this->request->getPost('registration_required') ? 1 : 0,
                    'is_published' => $this->request->getPost('is_published') ? 1 : 0,
                ];

                // Handle image upload
                $imageFile = $this->request->getFile('image');
                if ($imageFile && $imageFile->isValid() && !$imageFile->hasMoved()) {
                    $newName = $imageFile->getRandomName();
                    $imageFile->move('uploads/kegiatan', $newName);
                    $insertData['image'] = $newName;
                }

                $this->kegiatanModel->insert($insertData);
                session()->setFlashdata('success', 'Kegiatan berhasil ditambahkan');
                return redirect()->to('/admin/ibadah/kegiatan');
            } else {
                $data['validation'] = $this->validator;
            }
        }

        return view('admin/ibadah/kegiatan/create', $data);
    }

    public function kegiatanEdit($id)
    {
        $kegiatan = $this->kegiatanModel->find($id);
        if (!$kegiatan) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = [
            'title' => 'Edit Kegiatan',
            'kegiatan' => $kegiatan
        ];

        if ($this->request->getMethod() === 'POST') {
            $rules = [
                'title' => 'required|min_length[3]|max_length[255]',
                'category' => 'required',
                'date_start' => 'required|valid_date',
            ];

            if ($this->validate($rules)) {
                $updateData = [
                    'title' => $this->request->getPost('title'),
                    'slug' => url_title($this->request->getPost('title'), '-', true),
                    'description' => $this->request->getPost('description'),
                    'category' => $this->request->getPost('category'),
                    'date_start' => $this->request->getPost('date_start'),
                    'date_end' => $this->request->getPost('date_end'),
                    'time_start' => $this->request->getPost('time_start'),
                    'time_end' => $this->request->getPost('time_end'),
                    'location' => $this->request->getPost('location'),
                    'organizer' => $this->request->getPost('organizer'),
                    'contact_person' => $this->request->getPost('contact_person'),
                    'contact_phone' => $this->request->getPost('contact_phone'),
                    'max_participants' => $this->request->getPost('max_participants'),
                    'registration_required' => $this->request->getPost('registration_required') ? 1 : 0,
                    'is_published' => $this->request->getPost('is_published') ? 1 : 0,
                ];

                // Handle image upload
                $imageFile = $this->request->getFile('image');
                if ($imageFile && $imageFile->isValid() && !$imageFile->hasMoved()) {
                    $newName = $imageFile->getRandomName();
                    $imageFile->move('uploads/kegiatan', $newName);
                    $updateData['image'] = $newName;
                }

                $this->kegiatanModel->update($id, $updateData);
                session()->setFlashdata('success', 'Kegiatan berhasil diperbarui');
                return redirect()->to('/admin/ibadah/kegiatan');
            } else {
                $data['validation'] = $this->validator;
            }
        }

        return view('admin/ibadah/kegiatan/edit', $data);
    }

    public function kegiatanView($id)
    {
        $kegiatan = $this->kegiatanModel->find($id);
        if (!$kegiatan) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $registrations = $this->registrationModel->where('kegiatan_id', $id)->findAll();

        $data = [
            'title' => 'Detail Kegiatan',
            'kegiatan' => $kegiatan,
            'registrations' => $registrations,
            'total_registered' => count($registrations)
        ];

        return view('admin/ibadah/kegiatan/view', $data);
    }

    public function kegiatanDelete($id)
    {
        $this->kegiatanModel->delete($id);
        session()->setFlashdata('success', 'Kegiatan berhasil dihapus');
        return redirect()->to('/admin/ibadah/kegiatan');
    }

    // Registration Management
    public function registrations($kegiatanId)
    {
        $kegiatan = $this->kegiatanModel->find($kegiatanId);
        if (!$kegiatan) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = [
            'title' => 'Pendaftaran Kegiatan',
            'kegiatan' => $kegiatan,
            'registrations' => $this->registrationModel->where('kegiatan_id', $kegiatanId)->findAll()
        ];

        return view('admin/ibadah/kegiatan/registrations', $data);
    }

    public function registrationApprove($id)
    {
        $this->registrationModel->update($id, ['status' => 'approved']);
        session()->setFlashdata('success', 'Pendaftaran berhasil disetujui');
        return redirect()->back();
    }

    public function registrationReject($id)
    {
        $this->registrationModel->update($id, ['status' => 'rejected']);
        session()->setFlashdata('success', 'Pendaftaran ditolak');
        return redirect()->back();
    }
}
