<?php

namespace App\Controllers;

use App\Models\SettingModel;
use App\Models\UserModel;
use App\Models\MenuModel;
use App\Models\SellerModel;
use Config\Database;

class AdminKonfigurasi extends BaseController
{
    protected $settingModel;
    protected $userModel;
    protected $menuModel;
    protected $sellerModel;

    public function __construct()
    {
        $this->settingModel = new SettingModel();
        $this->userModel = new UserModel();
        $this->menuModel = new MenuModel();
        $this->sellerModel = new SellerModel();

        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/admin/login');
        }
    }

    // Settings Management
    public function settings()
    {
        $groups = ['identitas', 'konten', 'medsos', 'notif', 'utility'];
        $activeTab = $this->request->getGet('tab') ?: 'identitas';

        if ($this->request->getMethod() === 'POST') {
            $postData = $this->request->getPost();
            $activeTab = $postData['active_tab'] ?? $activeTab;

            unset($postData['csrf_test_name'], $postData['active_tab']);

            foreach ($postData as $key => $value) {
                $setting = $this->settingModel->where('key', $key)->first();
                $type = $setting['type'] ?? $this->inferSettingType($key, $value);
                $group = $setting['group'] ?? (in_array($activeTab, $groups, true) ? $activeTab : 'general');

                if ($type === 'boolean') {
                    $value = in_array($value, ['1', 1, true, 'true', 'yes', 'on'], true) ? 1 : 0;
                }

                $this->settingModel->setSetting($key, $value, $type, $group);
            }

            $fileFields = [
                'site_logo' => 'identitas',
                'site_icon' => 'identitas',
            ];

            foreach ($fileFields as $field => $groupKey) {
                $file = $this->request->getFile($field);

                if (!$file || !$file->isValid() || $file->hasMoved()) {
                    continue;
                }

                $directory = FCPATH . 'uploads/settings';

                if (!is_dir($directory)) {
                    mkdir($directory, 0775, true);
                }

                $existing = $this->settingModel->where('key', $field)->first();

                if ($existing && !empty($existing['value'])) {
                    $existingPath = $directory . '/' . $existing['value'];
                    if (is_file($existingPath)) {
                        @unlink($existingPath);
                    }
                }

                $newName = $file->getRandomName();
                $file->move($directory, $newName);

                $this->settingModel->setSetting($field, $newName, 'text', $groupKey);
            }

            session()->setFlashdata('success', 'Pengaturan berhasil disimpan');
            return redirect()->to('/admin/konfigurasi/settings?tab=' . $activeTab);
        }

        $settingsByGroup = [];
        foreach ($groups as $groupKey) {
            $settingsByGroup[$groupKey] = $this->settingModel
                ->where('group', $groupKey)
                ->orderBy('id', 'ASC')
                ->findAll();
        }

        if (!in_array($activeTab, $groups, true)) {
            $activeTab = 'identitas';
        }

        $data = [
            'title' => 'Pengaturan Sistem',
            'settings' => $settingsByGroup,
            'activeTab' => $activeTab,
        ];

        return view('admin/konfigurasi/settings', $data);
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
        $availableSellers = $this->sellerModel
            ->select('id, business_name, owner_name, status')
            ->where('user_id', null)
            ->orderBy('business_name', 'ASC')
            ->findAll();

        $data = [
            'title' => 'Tambah User',
            'sellers' => $availableSellers,
        ];

        if ($this->request->getMethod() === 'POST') {
            $role = $this->request->getPost('role');

            $rules = [
                'username' => 'required|min_length[3]|max_length[50]|is_unique[users.username]',
                'email' => 'required|valid_email|is_unique[users.email]',
                'password' => 'required|min_length[6]',
                'confirm_password' => 'required|matches[password]',
                'full_name' => 'required|min_length[3]|max_length[255]',
                'role' => 'required|in_list[admin,editor,viewer,seller]',
            ];

            if ($role === 'seller') {
                $rules['seller_id'] = 'required|is_natural_no_zero';
            }

            $validation = \Config\Services::validation();
            $validation->setRules($rules);

            if (!$validation->withRequest($this->request)->run()) {
                return redirect()->back()->withInput()->with('validation', $validation);
            }

            if ($role === 'seller') {
                $sellerId = (int) $this->request->getPost('seller_id');
                $seller = $this->sellerModel->find($sellerId);

                if (!$seller) {
                    $validation->setError('seller_id', 'Pelapak tidak ditemukan.');
                    return redirect()->back()->withInput()->with('validation', $validation);
                }

                if (!empty($seller['user_id'])) {
                    $validation->setError('seller_id', 'Pelapak ini sudah terhubung dengan akun lain.');
                    return redirect()->back()->withInput()->with('validation', $validation);
                }
            }

            $insertData = [
                'username' => $this->request->getPost('username'),
                'email' => $this->request->getPost('email'),
                'password' => $this->request->getPost('password'),
                'full_name' => $this->request->getPost('full_name'),
                'role' => $role,
                'is_active' => $this->request->getPost('is_active') ? 1 : 0,
            ];

            $this->userModel->insert($insertData);
            $userId = $this->userModel->getInsertID();

            if ($role === 'seller') {
                $sellerId = (int) $this->request->getPost('seller_id');
                $this->sellerModel->update($sellerId, ['user_id' => $userId, 'status' => $this->request->getPost('seller_status') ?? $this->sellerModel->find($sellerId)['status']]);
            }

            session()->setFlashdata('success', 'User berhasil ditambahkan');
            return redirect()->to('/admin/konfigurasi/users');
        }

        if (session()->has('validation')) {
            $data['validation'] = session('validation');
        }

        return view('admin/konfigurasi/users/create', $data);
    }

    public function userEdit($id)
    {
        $user = $this->userModel->find($id);
        if (!$user) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $currentSeller = $this->sellerModel->where('user_id', $id)->first();

        $availableSellers = $this->sellerModel
            ->select('id, business_name, owner_name, status, user_id')
            ->groupStart()
                ->where('user_id', null)
                ->orWhere('id', $currentSeller['id'] ?? 0)
            ->groupEnd()
            ->orderBy('business_name', 'ASC')
            ->findAll();

        $data = [
            'title' => 'Edit User',
            'user' => $user,
            'sellers' => $availableSellers,
            'currentSeller' => $currentSeller,
        ];

        if ($this->request->getMethod() === 'POST') {
            $role = $this->request->getPost('role');

            $rules = [
                'username' => 'required|min_length[3]|max_length[50]|is_unique[users.username,id,' . $id . ']',
                'email' => 'required|valid_email|is_unique[users.email,id,' . $id . ']',
                'full_name' => 'required|min_length[3]|max_length[255]',
                'role' => 'required|in_list[admin,editor,viewer,seller]',
            ];

            if ($this->request->getPost('password')) {
                $rules['password'] = 'required|min_length[6]';
                $rules['confirm_password'] = 'required|matches[password]';
            }

            if ($role === 'seller') {
                $rules['seller_id'] = 'required|is_natural_no_zero';
            }

            $validation = \Config\Services::validation();
            $validation->setRules($rules);

            if (!$validation->withRequest($this->request)->run()) {
                return redirect()->back()->withInput()->with('validation', $validation);
            }

            $sellerId = $this->request->getPost('seller_id');

            if ($role === 'seller') {
                $seller = $sellerId ? $this->sellerModel->find($sellerId) : null;

                if (!$seller) {
                    $validation->setError('seller_id', 'Pelapak tidak ditemukan.');
                    return redirect()->back()->withInput()->with('validation', $validation);
                }

                if (!empty($seller['user_id']) && (int) $seller['user_id'] !== (int) $id) {
                    $validation->setError('seller_id', 'Pelapak ini sudah terhubung dengan akun lain.');
                    return redirect()->back()->withInput()->with('validation', $validation);
                }
            }

            $updateData = [
                'username' => $this->request->getPost('username'),
                'email' => $this->request->getPost('email'),
                'full_name' => $this->request->getPost('full_name'),
                'role' => $role,
                'is_active' => $this->request->getPost('is_active') ? 1 : 0,
            ];

            if ($this->request->getPost('password')) {
                $updateData['password'] = $this->request->getPost('password');
            }

            $this->userModel->update($id, $updateData);

            // Handle seller linkage updates
            if ($role === 'seller') {
                $seller = $this->sellerModel->find($sellerId);

                if ($currentSeller && (int) $currentSeller['id'] !== (int) $seller['id']) {
                    $this->sellerModel->update($currentSeller['id'], ['user_id' => null]);
                }

                $this->sellerModel->update($seller['id'], ['user_id' => $id]);
            } elseif ($currentSeller) {
                $this->sellerModel->update($currentSeller['id'], ['user_id' => null]);
            }

            session()->setFlashdata('success', 'User berhasil diperbarui');
            return redirect()->to('/admin/konfigurasi/users');
        }

        if (session()->has('validation')) {
            $data['validation'] = session('validation');
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

    private function inferSettingType(string $key, $value): string
    {
        if (is_array($value)) {
            return 'json';
        }

        $booleanValues = ['1', '0', 1, 0, true, false, 'true', 'false', 'yes', 'no', 'on', 'off'];
        if (in_array($value, $booleanValues, true)) {
            return 'boolean';
        }

        if (is_numeric($value)) {
            return 'number';
        }

        return (strlen((string) $value) > 255) ? 'textarea' : 'text';
    }

    public function backupDatabase()
    {
        $method = strtolower($this->request->getMethod());

        if (!in_array($method, ['get', 'post'], true)) {
            return redirect()->to('/admin/konfigurasi/settings?tab=utility');
        }

        try {
            $db = Database::connect();
            $tables = $db->listTables();

            if (empty($tables)) {
                session()->setFlashdata('error', 'Tidak ada tabel yang ditemukan untuk dicadangkan.');
                return redirect()->to('/admin/konfigurasi/settings?tab=utility');
            }

            $lineBreak = PHP_EOL;
            $backupSql = '-- Church CMS Database Backup' . $lineBreak;
            $backupSql .= '-- Generated at: ' . date('Y-m-d H:i:s') . $lineBreak . $lineBreak;

            foreach ($tables as $table) {
                $tableName = str_replace('`', '``', $table);

                $backupSql .= 'DROP TABLE IF EXISTS `' . $tableName . '`;' . $lineBreak;

                $createQuery = $db->query('SHOW CREATE TABLE `' . $tableName . '`');
                $createRow = $createQuery->getRowArray();
                if (isset($createRow['Create Table'])) {
                    $backupSql .= $createRow['Create Table'] . ';' . $lineBreak . $lineBreak;
                }

                $dataQuery = $db->query('SELECT * FROM `' . $tableName . '`');
                foreach ($dataQuery->getResultArray() as $row) {
                    $columns = array_map(static function ($column) {
                        return '`' . str_replace('`', '``', $column) . '`';
                    }, array_keys($row));
                    $values = array_map(static function ($value) use ($db) {
                        return $db->escape($value);
                    }, array_values($row));

                    $backupSql .= 'INSERT INTO `' . $tableName . '` (' . implode(', ', $columns) . ') VALUES (' . implode(', ', $values) . ');' . $lineBreak;
                }

                $backupSql .= $lineBreak;
            }

            $fileName = 'backup-' . date('Ymd-His') . '.sql';

            return $this->response
                ->setHeader('Content-Type', 'application/sql')
                ->setHeader('Content-Disposition', 'attachment; filename="' . $fileName . '"')
                ->setBody($backupSql);
        } catch (\Throwable $exception) {
            log_message('error', 'Database backup gagal: ' . $exception->getMessage());
            session()->setFlashdata('error', 'Backup database gagal dibuat.');
            return redirect()->to('/admin/konfigurasi/settings?tab=utility');
        }
    }
}
