<?php

namespace App\Controllers;

use App\Models\JemaatModel;
use App\Models\FamilyModel;

class AdminJemaat extends BaseController
{
    protected $jemaatModel;
    protected $familyModel;

    public function __construct()
    {
        $this->jemaatModel = new JemaatModel();
        $this->familyModel = new FamilyModel();

        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/admin/login');
        }
    }

    // Jemaat Management
    public function index()
    {
        $perPage = 20;
        $keyword = $this->request->getGet('keyword');
        $wilayah = $this->request->getGet('wilayah');
        $status = $this->request->getGet('status');

        $builder = $this->jemaatModel;

        if ($keyword) {
            $builder->like('full_name', $keyword)
                   ->orLike('no_induk', $keyword)
                   ->orLike('email', $keyword);
        }

        if ($wilayah) {
            $builder->where('wilayah', $wilayah);
        }

        if ($status) {
            $builder->where('status', $status);
        }

        $data = [
            'title' => 'Data Jemaat',
            'jemaat' => $builder->orderBy('full_name', 'ASC')->paginate($perPage),
            'pager' => $builder->pager,
            'keyword' => $keyword,
            'wilayah' => $wilayah,
            'status' => $status,
            'wilayah_list' => $this->jemaatModel->select('wilayah')->distinct()->findAll()
        ];

        return view('admin/jemaat/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Jemaat',
            'families' => $this->familyModel->orderBy('family_name', 'ASC')->findAll()
        ];

        if ($this->request->getMethod() === 'POST') {
            $rules = [
                'no_induk' => 'required|is_unique[jemaat.no_induk]',
                'full_name' => 'required|min_length[3]|max_length[255]',
                'gender' => 'required|in_list[L,P]',
                'birth_date' => 'permit_empty|valid_date',
                'email' => 'permit_empty|valid_email',
            ];

            if ($this->validate($rules)) {
                $insertData = [
                    'family_id' => $this->request->getPost('family_id'),
                    'no_induk' => $this->request->getPost('no_induk'),
                    'full_name' => $this->request->getPost('full_name'),
                    'gender' => $this->request->getPost('gender'),
                    'birth_place' => $this->request->getPost('birth_place'),
                    'birth_date' => $this->request->getPost('birth_date'),
                    'address' => $this->request->getPost('address'),
                    'wilayah' => $this->request->getPost('wilayah'),
                    'phone' => $this->request->getPost('phone'),
                    'email' => $this->request->getPost('email'),
                    'baptis_date' => $this->request->getPost('baptis_date'),
                    'baptis_place' => $this->request->getPost('baptis_place'),
                    'sidi_date' => $this->request->getPost('sidi_date'),
                    'sidi_place' => $this->request->getPost('sidi_place'),
                    'marriage_date' => $this->request->getPost('marriage_date'),
                    'marriage_place' => $this->request->getPost('marriage_place'),
                    'spouse_name' => $this->request->getPost('spouse_name'),
                    'status' => $this->request->getPost('status') ?: 'aktif',
                    'notes' => $this->request->getPost('notes'),
                ];

                // Handle photo upload
                $photoFile = $this->request->getFile('photo');
                if ($photoFile && $photoFile->isValid() && !$photoFile->hasMoved()) {
                    $newName = $photoFile->getRandomName();
                    $photoFile->move('uploads/jemaat', $newName);
                    $insertData['photo'] = $newName;
                }

                $this->jemaatModel->insert($insertData);
                session()->setFlashdata('success', 'Jemaat berhasil ditambahkan');
                return redirect()->to('/admin/jemaat');
            } else {
                $data['validation'] = $this->validator;
            }
        }

        return view('admin/jemaat/create', $data);
    }

    public function edit($id)
    {
        $jemaat = $this->jemaatModel->find($id);
        if (!$jemaat) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = [
            'title' => 'Edit Jemaat',
            'jemaat' => $jemaat,
            'families' => $this->familyModel->orderBy('family_name', 'ASC')->findAll()
        ];

        if ($this->request->getMethod() === 'POST') {
            $rules = [
                'no_induk' => 'required|is_unique[jemaat.no_induk,id,' . $id . ']',
                'full_name' => 'required|min_length[3]|max_length[255]',
                'gender' => 'required|in_list[L,P]',
                'birth_date' => 'permit_empty|valid_date',
                'email' => 'permit_empty|valid_email',
            ];

            if ($this->validate($rules)) {
                $updateData = [
                    'family_id' => $this->request->getPost('family_id'),
                    'no_induk' => $this->request->getPost('no_induk'),
                    'full_name' => $this->request->getPost('full_name'),
                    'gender' => $this->request->getPost('gender'),
                    'birth_place' => $this->request->getPost('birth_place'),
                    'birth_date' => $this->request->getPost('birth_date'),
                    'address' => $this->request->getPost('address'),
                    'wilayah' => $this->request->getPost('wilayah'),
                    'phone' => $this->request->getPost('phone'),
                    'email' => $this->request->getPost('email'),
                    'baptis_date' => $this->request->getPost('baptis_date'),
                    'baptis_place' => $this->request->getPost('baptis_place'),
                    'sidi_date' => $this->request->getPost('sidi_date'),
                    'sidi_place' => $this->request->getPost('sidi_place'),
                    'marriage_date' => $this->request->getPost('marriage_date'),
                    'marriage_place' => $this->request->getPost('marriage_place'),
                    'spouse_name' => $this->request->getPost('spouse_name'),
                    'status' => $this->request->getPost('status'),
                    'notes' => $this->request->getPost('notes'),
                ];

                // Handle photo upload
                $photoFile = $this->request->getFile('photo');
                if ($photoFile && $photoFile->isValid() && !$photoFile->hasMoved()) {
                    $newName = $photoFile->getRandomName();
                    $photoFile->move('uploads/jemaat', $newName);
                    $updateData['photo'] = $newName;
                }

                $this->jemaatModel->update($id, $updateData);
                session()->setFlashdata('success', 'Jemaat berhasil diperbarui');
                return redirect()->to('/admin/jemaat');
            } else {
                $data['validation'] = $this->validator;
            }
        }

        return view('admin/jemaat/edit', $data);
    }

    public function view($id)
    {
        $jemaat = $this->jemaatModel->find($id);
        if (!$jemaat) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $family = null;
        if ($jemaat['family_id']) {
            $family = $this->familyModel->find($jemaat['family_id']);
        }

        $data = [
            'title' => 'Detail Jemaat',
            'jemaat' => $jemaat,
            'family' => $family
        ];

        return view('admin/jemaat/view', $data);
    }

    public function delete($id)
    {
        $this->jemaatModel->delete($id);
        session()->setFlashdata('success', 'Jemaat berhasil dihapus');
        return redirect()->to('/admin/jemaat');
    }

    // Family Management
    public function families()
    {
        $data = [
            'title' => 'Data Keluarga',
            'families' => $this->familyModel->orderBy('family_name', 'ASC')->findAll()
        ];

        return view('admin/jemaat/families/index', $data);
    }

    public function familyCreate()
    {
        $data = [
            'title' => 'Tambah Keluarga'
        ];

        if ($this->request->getMethod() === 'POST') {
            $rules = [
                'family_name' => 'required|min_length[3]|max_length[255]',
                'head_of_family' => 'required|max_length[255]',
            ];

            if ($this->validate($rules)) {
                $insertData = [
                    'family_name' => $this->request->getPost('family_name'),
                    'head_of_family' => $this->request->getPost('head_of_family'),
                    'address' => $this->request->getPost('address'),
                    'wilayah' => $this->request->getPost('wilayah'),
                    'phone' => $this->request->getPost('phone'),
                    'notes' => $this->request->getPost('notes'),
                ];

                $this->familyModel->insert($insertData);
                session()->setFlashdata('success', 'Keluarga berhasil ditambahkan');
                return redirect()->to('/admin/jemaat/families');
            } else {
                $data['validation'] = $this->validator;
            }
        }

        return view('admin/jemaat/families/create', $data);
    }

    public function familyEdit($id)
    {
        $family = $this->familyModel->find($id);
        if (!$family) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = [
            'title' => 'Edit Keluarga',
            'family' => $family
        ];

        if ($this->request->getMethod() === 'POST') {
            $rules = [
                'family_name' => 'required|min_length[3]|max_length[255]',
                'head_of_family' => 'required|max_length[255]',
            ];

            if ($this->validate($rules)) {
                $updateData = [
                    'family_name' => $this->request->getPost('family_name'),
                    'head_of_family' => $this->request->getPost('head_of_family'),
                    'address' => $this->request->getPost('address'),
                    'wilayah' => $this->request->getPost('wilayah'),
                    'phone' => $this->request->getPost('phone'),
                    'notes' => $this->request->getPost('notes'),
                ];

                $this->familyModel->update($id, $updateData);
                session()->setFlashdata('success', 'Keluarga berhasil diperbarui');
                return redirect()->to('/admin/jemaat/families');
            } else {
                $data['validation'] = $this->validator;
            }
        }

        return view('admin/jemaat/families/edit', $data);
    }

    public function familyView($id)
    {
        $family = $this->familyModel->find($id);
        if (!$family) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $members = $this->jemaatModel->where('family_id', $id)->findAll();

        $data = [
            'title' => 'Detail Keluarga',
            'family' => $family,
            'members' => $members
        ];

        return view('admin/jemaat/families/view', $data);
    }

    public function familyDelete($id)
    {
        $this->familyModel->delete($id);
        session()->setFlashdata('success', 'Keluarga berhasil dihapus');
        return redirect()->to('/admin/jemaat/families');
    }

    // Export functionality
    public function export()
    {
        // Export to CSV
        $jemaat = $this->jemaatModel->findAll();
        
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=data_jemaat_' . date('Y-m-d') . '.csv');
        
        $output = fopen('php://output', 'w');
        
        // Header
        fputcsv($output, ['No Induk', 'Nama Lengkap', 'Jenis Kelamin', 'Tempat Lahir', 'Tanggal Lahir', 'Alamat', 'Wilayah', 'Telepon', 'Email', 'Status']);
        
        // Data
        foreach ($jemaat as $j) {
            fputcsv($output, [
                $j['no_induk'],
                $j['full_name'],
                $j['gender'],
                $j['birth_place'],
                $j['birth_date'],
                $j['address'],
                $j['wilayah'],
                $j['phone'],
                $j['email'],
                $j['status']
            ]);
        }
        
        fclose($output);
        exit;
    }
}
