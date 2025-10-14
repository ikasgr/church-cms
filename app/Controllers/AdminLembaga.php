<?php

namespace App\Controllers;

use App\Models\ChurchProfileModel;
use App\Models\MajelisModel;
use App\Models\GreetingModel;

class AdminLembaga extends BaseController
{
    protected $churchProfileModel;
    protected $majelisModel;
    protected $greetingModel;

    public function __construct()
    {
        $this->churchProfileModel = new ChurchProfileModel();
        $this->majelisModel = new MajelisModel();
        $this->greetingModel = new GreetingModel();

        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/admin/login');
        }
    }

    // Church Profile Management
    public function profile()
    {
        $profile = $this->churchProfileModel->getProfile();

        $data = [
            'title' => 'Profil Gereja',
            'profile' => $profile
        ];

        if ($this->request->getMethod() === 'POST') {
            $rules = [
                'church_name' => 'required|min_length[3]|max_length[255]',
                'email' => 'permit_empty|valid_email',
                'website' => 'permit_empty|valid_url',
                'social_facebook' => 'permit_empty|valid_url',
                'social_instagram' => 'permit_empty|valid_url',
                'social_youtube' => 'permit_empty|valid_url',
                'social_twitter' => 'permit_empty|valid_url',
            ];

            if ($this->validate($rules)) {
                $updateData = [
                    'church_name' => $this->request->getPost('church_name'),
                    'tagline' => $this->request->getPost('tagline'),
                    'address' => $this->request->getPost('address'),
                    'phone' => $this->request->getPost('phone'),
                    'email' => $this->request->getPost('email'),
                    'website' => $this->request->getPost('website'),
                    'history' => $this->request->getPost('history'),
                    'vision' => $this->request->getPost('vision'),
                    'mission' => $this->request->getPost('mission'),
                    'organizational_structure' => $this->request->getPost('organizational_structure'),
                    'social_facebook' => $this->request->getPost('social_facebook'),
                    'social_instagram' => $this->request->getPost('social_instagram'),
                    'social_youtube' => $this->request->getPost('social_youtube'),
                    'social_twitter' => $this->request->getPost('social_twitter'),
                ];

                // Handle logo upload
                $logoFile = $this->request->getFile('logo');
                if ($logoFile && $logoFile->isValid() && !$logoFile->hasMoved()) {
                    $newName = $logoFile->getRandomName();
                    $logoFile->move('uploads/logo', $newName);
                    $updateData['logo'] = $newName;
                }

                if ($profile) {
                    $this->churchProfileModel->update($profile['id'], $updateData);
                } else {
                    $this->churchProfileModel->insert($updateData);
                }

                session()->setFlashdata('success', 'Profil gereja berhasil diperbarui');
                return redirect()->to('/admin/lembaga/profile');
            } else {
                $data['validation'] = $this->validator;
            }
        }

        return view('admin/lembaga/profile', $data);
    }

    // Majelis Management
    public function majelis()
    {
        $data = [
            'title' => 'Data Majelis',
            'majelis' => $this->majelisModel->orderBy('order_position', 'ASC')->findAll()
        ];

        return view('admin/lembaga/majelis/index', $data);
    }

    public function majelisCreate()
    {
        $data = [
            'title' => 'Tambah Majelis'
        ];

        if ($this->request->getMethod() === 'POST') {
            $rules = [
                'name' => 'required|min_length[3]|max_length[255]',
                'position' => 'required|max_length[100]',
                'email' => 'permit_empty|valid_email',
            ];

            if ($this->validate($rules)) {
                $insertData = [
                    'name' => $this->request->getPost('name'),
                    'position' => $this->request->getPost('position'),
                    'phone' => $this->request->getPost('phone'),
                    'email' => $this->request->getPost('email'),
                    'bio' => $this->request->getPost('bio'),
                    'order_position' => $this->request->getPost('order_position') ?: 0,
                    'is_active' => $this->request->getPost('is_active') ? 1 : 0,
                ];

                // Handle photo upload
                $photoFile = $this->request->getFile('photo');
                if ($photoFile && $photoFile->isValid() && !$photoFile->hasMoved()) {
                    $newName = $photoFile->getRandomName();
                    $photoFile->move('uploads/majelis', $newName);
                    $insertData['photo'] = $newName;
                }

                $this->majelisModel->insert($insertData);
                session()->setFlashdata('success', 'Majelis berhasil ditambahkan');
                return redirect()->to('/admin/lembaga/majelis');
            } else {
                $data['validation'] = $this->validator;
            }
        }

        return view('admin/lembaga/majelis/create', $data);
    }

    public function majelisEdit($id)
    {
        $majelis = $this->majelisModel->find($id);
        if (!$majelis) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = [
            'title' => 'Edit Majelis',
            'majelis' => $majelis
        ];

        if ($this->request->getMethod() === 'POST') {
            $rules = [
                'name' => 'required|min_length[3]|max_length[255]',
                'position' => 'required|max_length[100]',
                'email' => 'permit_empty|valid_email',
            ];

            if ($this->validate($rules)) {
                $updateData = [
                    'name' => $this->request->getPost('name'),
                    'position' => $this->request->getPost('position'),
                    'phone' => $this->request->getPost('phone'),
                    'email' => $this->request->getPost('email'),
                    'bio' => $this->request->getPost('bio'),
                    'order_position' => $this->request->getPost('order_position') ?: 0,
                    'is_active' => $this->request->getPost('is_active') ? 1 : 0,
                ];

                // Handle photo upload
                $photoFile = $this->request->getFile('photo');
                if ($photoFile && $photoFile->isValid() && !$photoFile->hasMoved()) {
                    $newName = $photoFile->getRandomName();
                    $photoFile->move('uploads/majelis', $newName);
                    $updateData['photo'] = $newName;
                }

                $this->majelisModel->update($id, $updateData);
                session()->setFlashdata('success', 'Majelis berhasil diperbarui');
                return redirect()->to('/admin/lembaga/majelis');
            } else {
                $data['validation'] = $this->validator;
            }
        }

        return view('admin/lembaga/majelis/edit', $data);
    }

    public function majelisDelete($id)
    {
        $this->majelisModel->delete($id);
        session()->setFlashdata('success', 'Majelis berhasil dihapus');
        return redirect()->to('/admin/lembaga/majelis');
    }

    // Greeting Management
    public function greeting()
    {
        $data = [
            'title' => 'Sambutan Ketua Majelis',
            'greetings' => $this->greetingModel->orderBy('created_at', 'DESC')->findAll()
        ];

        return view('admin/lembaga/greeting/index', $data);
    }

    public function greetingCreate()
    {
        $data = [
            'title' => 'Tambah Sambutan'
        ];

        if ($this->request->getMethod() === 'POST') {
            $rules = [
                'title' => 'required|min_length[3]|max_length[255]',
                'content' => 'required',
                'author_name' => 'required|max_length[255]',
                'author_position' => 'required|max_length[100]',
            ];

            if ($this->validate($rules)) {
                $insertData = [
                    'title' => $this->request->getPost('title'),
                    'content' => $this->request->getPost('content'),
                    'author_name' => $this->request->getPost('author_name'),
                    'author_position' => $this->request->getPost('author_position'),
                    'is_active' => $this->request->getPost('is_active') ? 1 : 0,
                ];

                // Handle author photo upload
                $photoFile = $this->request->getFile('author_photo');
                if ($photoFile && $photoFile->isValid() && !$photoFile->hasMoved()) {
                    $newName = $photoFile->getRandomName();
                    $photoFile->move('uploads/greeting', $newName);
                    $insertData['author_photo'] = $newName;
                }

                $this->greetingModel->insert($insertData);
                session()->setFlashdata('success', 'Sambutan berhasil ditambahkan');
                return redirect()->to('/admin/lembaga/greeting');
            } else {
                $data['validation'] = $this->validator;
            }
        }

        return view('admin/lembaga/greeting/create', $data);
    }

    public function greetingEdit($id)
    {
        $greeting = $this->greetingModel->find($id);
        if (!$greeting) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = [
            'title' => 'Edit Sambutan',
            'greeting' => $greeting
        ];

        if ($this->request->getMethod() === 'POST') {
            $rules = [
                'title' => 'required|min_length[3]|max_length[255]',
                'content' => 'required',
                'author_name' => 'required|max_length[255]',
                'author_position' => 'required|max_length[100]',
            ];

            if ($this->validate($rules)) {
                $updateData = [
                    'title' => $this->request->getPost('title'),
                    'content' => $this->request->getPost('content'),
                    'author_name' => $this->request->getPost('author_name'),
                    'author_position' => $this->request->getPost('author_position'),
                    'is_active' => $this->request->getPost('is_active') ? 1 : 0,
                ];

                // Handle author photo upload
                $photoFile = $this->request->getFile('author_photo');
                if ($photoFile && $photoFile->isValid() && !$photoFile->hasMoved()) {
                    $newName = $photoFile->getRandomName();
                    $photoFile->move('uploads/greeting', $newName);
                    $updateData['author_photo'] = $newName;
                }

                $this->greetingModel->update($id, $updateData);
                session()->setFlashdata('success', 'Sambutan berhasil diperbarui');
                return redirect()->to('/admin/lembaga/greeting');
            } else {
                $data['validation'] = $this->validator;
            }
        }

        return view('admin/lembaga/greeting/edit', $data);
    }

    public function greetingDelete($id)
    {
        $this->greetingModel->delete($id);
        session()->setFlashdata('success', 'Sambutan berhasil dihapus');
        return redirect()->to('/admin/lembaga/greeting');
    }

    public function greetingToggle($id)
    {
        $greeting = $this->greetingModel->find($id);
        if ($greeting) {
            $this->greetingModel->update($id, ['is_active' => !$greeting['is_active']]);
            session()->setFlashdata('success', 'Status sambutan berhasil diubah');
        }
        return redirect()->to('/admin/lembaga/greeting');
    }
}
