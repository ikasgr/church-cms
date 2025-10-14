<?php

namespace App\Controllers;

use App\Models\RegistrationModel;

class AdminPendaftaran extends BaseController
{
    protected $registrationModel;

    public function __construct()
    {
        $this->registrationModel = new RegistrationModel();

        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/admin/login');
        }
    }

    public function index()
    {
        $type = $this->request->getGet('type');
        $status = $this->request->getGet('status');
        $builder = $this->registrationModel;

        if ($type) {
            $builder->where('type', $type);
        }

        if ($status) {
            $builder->where('status', $status);
        }

        $data = [
            'title' => 'Pendaftaran Online',
            'registrations' => $builder->orderBy('created_at', 'DESC')->findAll(),
            'type' => $type,
            'status' => $status
        ];

        return view('admin/pendaftaran/index', $data);
    }

    // Baptis Registration
    public function baptisCreate()
    {
        $data = ['title' => 'Pendaftaran Baptis'];

        if ($this->request->getMethod() === 'POST') {
            $rules = [
                'full_name' => 'required|min_length[3]',
                'birth_date' => 'required|valid_date',
                'phone' => 'required',
            ];

            if ($this->validate($rules)) {
                $insertData = [
                    'type' => 'baptis',
                    'full_name' => $this->request->getPost('full_name'),
                    'birth_place' => $this->request->getPost('birth_place'),
                    'birth_date' => $this->request->getPost('birth_date'),
                    'gender' => $this->request->getPost('gender'),
                    'address' => $this->request->getPost('address'),
                    'phone' => $this->request->getPost('phone'),
                    'email' => $this->request->getPost('email'),
                    'parent_name' => $this->request->getPost('parent_name'),
                    'parent_phone' => $this->request->getPost('parent_phone'),
                    'preferred_date' => $this->request->getPost('preferred_date'),
                    'notes' => $this->request->getPost('notes'),
                    'status' => 'pending',
                ];

                // Handle document upload
                $docFile = $this->request->getFile('document');
                if ($docFile && $docFile->isValid() && !$docFile->hasMoved()) {
                    $newName = 'baptis_' . time() . '_' . $docFile->getRandomName();
                    $docFile->move('uploads/pendaftaran/baptis', $newName);
                    $insertData['document_path'] = $newName;
                }

                $this->registrationModel->insert($insertData);
                session()->setFlashdata('success', 'Pendaftaran baptis berhasil ditambahkan');
                return redirect()->to('/admin/pendaftaran?type=baptis');
            } else {
                $data['validation'] = $this->validator;
            }
        }

        return view('admin/pendaftaran/baptis/create', $data);
    }

    // Sidi Registration
    public function sidiCreate()
    {
        $data = ['title' => 'Pendaftaran Sidi'];

        if ($this->request->getMethod() === 'POST') {
            $rules = [
                'full_name' => 'required|min_length[3]',
                'birth_date' => 'required|valid_date',
                'phone' => 'required',
            ];

            if ($this->validate($rules)) {
                $insertData = [
                    'type' => 'sidi',
                    'full_name' => $this->request->getPost('full_name'),
                    'birth_place' => $this->request->getPost('birth_place'),
                    'birth_date' => $this->request->getPost('birth_date'),
                    'gender' => $this->request->getPost('gender'),
                    'address' => $this->request->getPost('address'),
                    'phone' => $this->request->getPost('phone'),
                    'email' => $this->request->getPost('email'),
                    'baptism_place' => $this->request->getPost('baptism_place'),
                    'baptism_date' => $this->request->getPost('baptism_date'),
                    'preferred_date' => $this->request->getPost('preferred_date'),
                    'notes' => $this->request->getPost('notes'),
                    'status' => 'pending',
                ];

                // Handle document upload
                $docFile = $this->request->getFile('document');
                if ($docFile && $docFile->isValid() && !$docFile->hasMoved()) {
                    $newName = 'sidi_' . time() . '_' . $docFile->getRandomName();
                    $docFile->move('uploads/pendaftaran/sidi', $newName);
                    $insertData['document_path'] = $newName;
                }

                $this->registrationModel->insert($insertData);
                session()->setFlashdata('success', 'Pendaftaran sidi berhasil ditambahkan');
                return redirect()->to('/admin/pendaftaran?type=sidi');
            } else {
                $data['validation'] = $this->validator;
            }
        }

        return view('admin/pendaftaran/sidi/create', $data);
    }

    // Nikah Registration
    public function nikahCreate()
    {
        $data = ['title' => 'Pendaftaran Nikah'];

        if ($this->request->getMethod() === 'POST') {
            $rules = [
                'full_name' => 'required|min_length[3]',
                'partner_name' => 'required|min_length[3]',
                'phone' => 'required',
            ];

            if ($this->validate($rules)) {
                $insertData = [
                    'type' => 'nikah',
                    'full_name' => $this->request->getPost('full_name'),
                    'birth_place' => $this->request->getPost('birth_place'),
                    'birth_date' => $this->request->getPost('birth_date'),
                    'gender' => $this->request->getPost('gender'),
                    'address' => $this->request->getPost('address'),
                    'phone' => $this->request->getPost('phone'),
                    'email' => $this->request->getPost('email'),
                    'partner_name' => $this->request->getPost('partner_name'),
                    'partner_birth_place' => $this->request->getPost('partner_birth_place'),
                    'partner_birth_date' => $this->request->getPost('partner_birth_date'),
                    'partner_address' => $this->request->getPost('partner_address'),
                    'partner_phone' => $this->request->getPost('partner_phone'),
                    'preferred_date' => $this->request->getPost('preferred_date'),
                    'notes' => $this->request->getPost('notes'),
                    'status' => 'pending',
                ];

                // Handle document upload
                $docFile = $this->request->getFile('document');
                if ($docFile && $docFile->isValid() && !$docFile->hasMoved()) {
                    $newName = 'nikah_' . time() . '_' . $docFile->getRandomName();
                    $docFile->move('uploads/pendaftaran/nikah', $newName);
                    $insertData['document_path'] = $newName;
                }

                $this->registrationModel->insert($insertData);
                session()->setFlashdata('success', 'Pendaftaran nikah berhasil ditambahkan');
                return redirect()->to('/admin/pendaftaran?type=nikah');
            } else {
                $data['validation'] = $this->validator;
            }
        }

        return view('admin/pendaftaran/nikah/create', $data);
    }

    public function view($id)
    {
        $registration = $this->registrationModel->find($id);
        if (!$registration) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = [
            'title' => 'Detail Pendaftaran',
            'registration' => $registration
        ];

        return view('admin/pendaftaran/view', $data);
    }

    public function approve($id)
    {
        $data = [
            'title' => 'Setujui Pendaftaran',
            'registration' => $this->registrationModel->find($id)
        ];

        if ($this->request->getMethod() === 'POST') {
            $notes = $this->request->getPost('admin_notes');
            $userId = session()->get('userId');

            $this->registrationModel->approve($id, $userId, $notes);
            session()->setFlashdata('success', 'Pendaftaran berhasil disetujui');
            return redirect()->to('/admin/pendaftaran');
        }

        return view('admin/pendaftaran/approve', $data);
    }

    public function reject($id)
    {
        $data = [
            'title' => 'Tolak Pendaftaran',
            'registration' => $this->registrationModel->find($id)
        ];

        if ($this->request->getMethod() === 'POST') {
            $notes = $this->request->getPost('admin_notes');
            $userId = session()->get('userId');

            $this->registrationModel->reject($id, $userId, $notes);
            session()->setFlashdata('success', 'Pendaftaran ditolak');
            return redirect()->to('/admin/pendaftaran');
        }

        return view('admin/pendaftaran/reject', $data);
    }

    public function delete($id)
    {
        $this->registrationModel->delete($id);
        session()->setFlashdata('success', 'Pendaftaran berhasil dihapus');
        return redirect()->to('/admin/pendaftaran');
    }

    public function export()
    {
        $type = $this->request->getGet('type');
        $builder = $this->registrationModel;

        if ($type) {
            $builder->where('type', $type);
        }

        $registrations = $builder->orderBy('created_at', 'DESC')->findAll();

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=pendaftaran_' . ($type ?: 'semua') . '_' . date('Y-m-d') . '.csv');

        $output = fopen('php://output', 'w');

        // Header
        fputcsv($output, ['Tipe', 'Nama Lengkap', 'Tempat Lahir', 'Tanggal Lahir', 'Jenis Kelamin', 'Alamat', 'Telepon', 'Email', 'Tanggal Diinginkan', 'Status', 'Tanggal Daftar']);

        // Data
        foreach ($registrations as $r) {
            fputcsv($output, [
                $r['type'],
                $r['full_name'],
                $r['birth_place'],
                $r['birth_date'],
                $r['gender'],
                $r['address'],
                $r['phone'],
                $r['email'],
                $r['preferred_date'],
                $r['status'],
                $r['created_at']
            ]);
        }

        fclose($output);
        exit;
    }
}
