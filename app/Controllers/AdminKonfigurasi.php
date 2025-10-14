<?php

namespace App\Controllers;

use App\Models\SettingModel;
use App\Models\UserModel;
use App\Models\MenuModel;

class AdminKonfigurasi extends BaseController
{
    protected $settingModel;
    protected $userModel;
    protected $menuModel;

    public function __construct()
    {
        $this->settingModel = new SettingModel();
        $this->userModel = new UserModel();
        $this->menuModel = new MenuModel();

        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/admin/login');
        }
    }

    // Settings Management
    public function settings()
    {
        $group = $this->request->getGet('group') ?: 'general';
        
        $data = [
            'title' => 'Pengaturan',
            'settings' => $this->settingModel->where('group', $group)->findAll(),
            'group' => $group
        ];

        if ($this->request->getMethod() === 'POST') {
            $postData = $this->request->getPost();
            
            foreach ($postData as $key => $value) {
                if ($key !== 'csrf_test_name') {
                    $setting = $this->settingModel->where('key', $key)->first();
                    if ($setting) {
                        $this->settingModel->setSetting($key, $value, $setting['type'], $setting['group']);
                    }
                }
            }

            session()->setFlashdata('success', 'Pengaturan berhasil disimpan');
            return redirect()->to('/admin/konfigurasi/settings?group=' . $group);
        }

        return view('admin/konfigurasi/settings', $data);
    }

    public function settingCreate()
    {
        $data = [
            'title' => 'Tambah Pengaturan'
        ];

        if ($this->request->getMethod() === 'POST') {
            $rules = [
                'key' => 'required|is_unique[settings.key]',
                'value' => 'required',
                'type' => 'required|in_list[text,textarea,number,boolean,json]',
            ];

            if ($this->validate($rules)) {
                $insertData = [
                    'key' => $this->request->getPost('key'),
                    'value' => $this->request->getPost('value'),
                    'type' => $this->request->getPost('type'),
                    'group' => $this->request->getPost('group') ?: 'general',
                    'description' => $this->request->getPost('description'),
                ];

                $this->settingModel->insert($insertData);
                session()->setFlashdata('success', 'Pengaturan berhasil ditambahkan');
                return redirect()->to('/admin/konfigurasi/settings');
            } else {
                $data['validation'] = $this->validator;
            }
        }

        return view('admin/konfigurasi/settings_create', $data);
    }

    public function settingEdit($id)
    {
        $setting = $this->settingModel->find($id);
        if (!$setting) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = [
            'title' => 'Edit Pengaturan',
            'setting' => $setting
        ];

        if ($this->request->getMethod() === 'POST') {
            $rules = [
                'key' => 'required|is_unique[settings.key,id,' . $id . ']',
                'value' => 'required',
                'type' => 'required|in_list[text,textarea,number,boolean,json]',
            ];

            if ($this->validate($rules)) {
                $updateData = [
                    'key' => $this->request->getPost('key'),
                    'value' => $this->request->getPost('value'),
                    'type' => $this->request->getPost('type'),
                    'group' => $this->request->getPost('group') ?: 'general',
                    'description' => $this->request->getPost('description'),
                ];

                $this->settingModel->update($id, $updateData);
                session()->setFlashdata('success', 'Pengaturan berhasil diperbarui');
                return redirect()->to('/admin/konfigurasi/settings');
            } else {
                $data['validation'] = $this->validator;
            }
        }

        return view('admin/konfigurasi/settings_edit', $data);
    }

    public function settingDelete($id)
    {
        $this->settingModel->delete($id);
        session()->setFlashdata('success', 'Pengaturan berhasil dihapus');
        return redirect()->to('/admin/konfigurasi/settings');
    }

    // User Management
    public function users()
    {
        $data = [
            'title' => 'Manajemen User',
            'users' => $this->userModel->orderBy('created_at', 'DESC')->findAll()
        ];

        return view('admin/konfigurasi/users/index', $data);
    }

    public function userCreate()
    {
        $data = [
            'title' => 'Tambah User'
        ];

        if ($this->request->getMethod() === 'POST') {
            $rules = [
                'username' => 'required|min_length[3]|max_length[50]|is_unique[users.username]',
                'email' => 'required|valid_email|is_unique[users.email]',
                'password' => 'required|min_length[6]',
                'confirm_password' => 'required|matches[password]',
                'full_name' => 'required|min_length[3]|max_length[255]',
                'role' => 'required|in_list[admin,editor,viewer]',
            ];

            if ($this->validate($rules)) {
                $insertData = [
                    'username' => $this->request->getPost('username'),
                    'email' => $this->request->getPost('email'),
                    'password' => $this->request->getPost('password'),
                    'full_name' => $this->request->getPost('full_name'),
                    'role' => $this->request->getPost('role'),
                    'is_active' => $this->request->getPost('is_active') ? 1 : 0,
                ];

                $this->userModel->insert($insertData);
                session()->setFlashdata('success', 'User berhasil ditambahkan');
                return redirect()->to('/admin/konfigurasi/users');
            } else {
                $data['validation'] = $this->validator;
            }
        }

        return view('admin/konfigurasi/users/create', $data);
    }

    public function userEdit($id)
    {
        $user = $this->userModel->find($id);
        if (!$user) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = [
            'title' => 'Edit User',
            'user' => $user
        ];

        if ($this->request->getMethod() === 'POST') {
            $rules = [
                'username' => 'required|min_length[3]|max_length[50]|is_unique[users.username,id,' . $id . ']',
                'email' => 'required|valid_email|is_unique[users.email,id,' . $id . ']',
                'full_name' => 'required|min_length[3]|max_length[255]',
                'role' => 'required|in_list[admin,editor,viewer]',
            ];

            if ($this->request->getPost('password')) {
                $rules['password'] = 'required|min_length[6]';
                $rules['confirm_password'] = 'required|matches[password]';
            }

            if ($this->validate($rules)) {
                $updateData = [
                    'username' => $this->request->getPost('username'),
                    'email' => $this->request->getPost('email'),
                    'full_name' => $this->request->getPost('full_name'),
                    'role' => $this->request->getPost('role'),
                    'is_active' => $this->request->getPost('is_active') ? 1 : 0,
                ];

                if ($this->request->getPost('password')) {
                    $updateData['password'] = $this->request->getPost('password');
                }

                $this->userModel->update($id, $updateData);
                session()->setFlashdata('success', 'User berhasil diperbarui');
                return redirect()->to('/admin/konfigurasi/users');
            } else {
                $data['validation'] = $this->validator;
            }
        }

        return view('admin/konfigurasi/users/edit', $data);
    }

    public function userDelete($id)
    {
        // Prevent deleting own account
        if ($id == session()->get('userId')) {
            session()->setFlashdata('error', 'Tidak dapat menghapus akun sendiri');
            return redirect()->to('/admin/konfigurasi/users');
        }

        $this->userModel->delete($id);
        session()->setFlashdata('success', 'User berhasil dihapus');
        return redirect()->to('/admin/konfigurasi/users');
    }

    public function userToggleActive($id)
    {
        $user = $this->userModel->find($id);
        if ($user) {
            $this->userModel->update($id, ['is_active' => !$user['is_active']]);
            session()->setFlashdata('success', 'Status user berhasil diubah');
        }
        return redirect()->to('/admin/konfigurasi/users');
    }

    // Menu Management
    public function menus()
    {
        $position = $this->request->getGet('position') ?: 'header';
        
        $data = [
            'title' => 'Pengaturan Menu',
            'menus' => $this->menuModel->where('position', $position)->orderBy('order_position', 'ASC')->findAll(),
            'position' => $position
        ];

        return view('admin/konfigurasi/menus/index', $data);
    }

    public function menuCreate()
    {
        $data = [
            'title' => 'Tambah Menu',
            'menus' => $this->menuModel->where('parent_id', null)->findAll()
        ];

        if ($this->request->getMethod() === 'POST') {
            $rules = [
                'title' => 'required|min_length[2]|max_length[100]',
                'position' => 'required|in_list[header,footer,sidebar]',
            ];

            if ($this->validate($rules)) {
                $insertData = [
                    'parent_id' => $this->request->getPost('parent_id') ?: null,
                    'title' => $this->request->getPost('title'),
                    'url' => $this->request->getPost('url'),
                    'icon' => $this->request->getPost('icon'),
                    'position' => $this->request->getPost('position'),
                    'is_active' => $this->request->getPost('is_active') ? 1 : 0,
                    'order_position' => $this->request->getPost('order_position') ?: 0,
                    'target' => $this->request->getPost('target') ?: '_self',
                ];

                $this->menuModel->insert($insertData);
                session()->setFlashdata('success', 'Menu berhasil ditambahkan');
                return redirect()->to('/admin/konfigurasi/menus');
            } else {
                $data['validation'] = $this->validator;
            }
        }

        return view('admin/konfigurasi/menus/create', $data);
    }

    public function menuEdit($id)
    {
        $menu = $this->menuModel->find($id);
        if (!$menu) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = [
            'title' => 'Edit Menu',
            'menu' => $menu,
            'menus' => $this->menuModel->where('parent_id', null)->where('id !=', $id)->findAll()
        ];

        if ($this->request->getMethod() === 'POST') {
            $rules = [
                'title' => 'required|min_length[2]|max_length[100]',
                'position' => 'required|in_list[header,footer,sidebar]',
            ];

            if ($this->validate($rules)) {
                $updateData = [
                    'parent_id' => $this->request->getPost('parent_id') ?: null,
                    'title' => $this->request->getPost('title'),
                    'url' => $this->request->getPost('url'),
                    'icon' => $this->request->getPost('icon'),
                    'position' => $this->request->getPost('position'),
                    'is_active' => $this->request->getPost('is_active') ? 1 : 0,
                    'order_position' => $this->request->getPost('order_position') ?: 0,
                    'target' => $this->request->getPost('target') ?: '_self',
                ];

                $this->menuModel->update($id, $updateData);
                session()->setFlashdata('success', 'Menu berhasil diperbarui');
                return redirect()->to('/admin/konfigurasi/menus');
            } else {
                $data['validation'] = $this->validator;
            }
        }

        return view('admin/konfigurasi/menus/edit', $data);
    }

    public function menuDelete($id)
    {
        $this->menuModel->delete($id);
        session()->setFlashdata('success', 'Menu berhasil dihapus');
        return redirect()->to('/admin/konfigurasi/menus');
    }

    // Module Settings
    public function modules()
    {
        $modules = [
            'lembaga' => ['name' => 'Lembaga', 'enabled' => true],
            'jemaat' => ['name' => 'Jemaat', 'enabled' => true],
            'ibadah' => ['name' => 'Ibadah & Kegiatan', 'enabled' => true],
            'keuangan' => ['name' => 'Keuangan', 'enabled' => true],
            'berita' => ['name' => 'Berita & Warta', 'enabled' => true],
            'galeri' => ['name' => 'Galeri', 'enabled' => true],
            'interaksi' => ['name' => 'Interaksi', 'enabled' => true],
            'pendaftaran' => ['name' => 'Pendaftaran Online', 'enabled' => true],
            'konten' => ['name' => 'Konten', 'enabled' => true],
        ];

        $data = [
            'title' => 'Pengaturan Modul',
            'modules' => $modules
        ];

        return view('admin/konfigurasi/modules', $data);
    }

    // Theme Settings
    public function theme()
    {
        $data = [
            'title' => 'Pengaturan Tema'
        ];

        if ($this->request->getMethod() === 'POST') {
            $themeSettings = [
                'primary_color' => $this->request->getPost('primary_color'),
                'secondary_color' => $this->request->getPost('secondary_color'),
                'font_family' => $this->request->getPost('font_family'),
                'layout' => $this->request->getPost('layout'),
            ];

            foreach ($themeSettings as $key => $value) {
                $this->settingModel->setSetting('theme_' . $key, $value, 'text', 'theme');
            }

            // Handle logo upload
            $logoFile = $this->request->getFile('logo');
            if ($logoFile && $logoFile->isValid() && !$logoFile->hasMoved()) {
                $newName = $logoFile->getRandomName();
                $logoFile->move('uploads/theme', $newName);
                $this->settingModel->setSetting('theme_logo', $newName, 'text', 'theme');
            }

            session()->setFlashdata('success', 'Pengaturan tema berhasil disimpan');
            return redirect()->to('/admin/konfigurasi/theme');
        }

        $data['theme'] = $this->settingModel->getByGroup('theme');
        return view('admin/konfigurasi/theme', $data);
    }
}
