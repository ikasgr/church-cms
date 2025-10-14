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
