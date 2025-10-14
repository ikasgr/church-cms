<?php

namespace App\Controllers;

use App\Models\PageModel;
use App\Models\BannerModel;
use App\Models\LinkModel;
use App\Models\FaqModel;

class AdminKonten extends BaseController
{
    protected $pageModel;
    protected $bannerModel;
    protected $linkModel;
    protected $faqModel;

    public function __construct()
    {
        $this->pageModel = new PageModel();
        $this->bannerModel = new BannerModel();
        $this->linkModel = new LinkModel();
        $this->faqModel = new FaqModel();

        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/admin/login');
        }
    }

    // Pages Management
    public function pages()
    {
        $data = [
            'title' => 'Halaman Statis',
            'pages' => $this->pageModel->orderBy('order_position', 'ASC')->findAll()
        ];

        return view('admin/konten/pages/index', $data);
    }

    public function pageCreate()
    {
        $data = [
            'title' => 'Tambah Halaman'
        ];

        if ($this->request->getMethod() === 'POST') {
            $rules = [
                'title' => 'required|min_length[3]|max_length[255]',
                'content' => 'required',
            ];

            if ($this->validate($rules)) {
                $insertData = [
                    'title' => $this->request->getPost('title'),
                    'slug' => url_title($this->request->getPost('title'), '-', true),
                    'content' => $this->request->getPost('content'),
                    'template' => $this->request->getPost('template') ?: 'default',
                    'is_published' => $this->request->getPost('is_published') ? 1 : 0,
                    'meta_keywords' => $this->request->getPost('meta_keywords'),
                    'meta_description' => $this->request->getPost('meta_description'),
                    'order_position' => $this->request->getPost('order_position') ?: 0,
                ];

                $this->pageModel->insert($insertData);
                session()->setFlashdata('success', 'Halaman berhasil ditambahkan');
                return redirect()->to('/admin/konten/pages');
            } else {
                $data['validation'] = $this->validator;
            }
        }

        return view('admin/konten/pages/create', $data);
    }

    public function pageEdit($id)
    {
        $page = $this->pageModel->find($id);
        if (!$page) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = [
            'title' => 'Edit Halaman',
            'page' => $page
        ];

        if ($this->request->getMethod() === 'POST') {
            $rules = [
                'title' => 'required|min_length[3]|max_length[255]',
                'content' => 'required',
            ];

            if ($this->validate($rules)) {
                $updateData = [
                    'title' => $this->request->getPost('title'),
                    'slug' => url_title($this->request->getPost('title'), '-', true),
                    'content' => $this->request->getPost('content'),
                    'template' => $this->request->getPost('template') ?: 'default',
                    'is_published' => $this->request->getPost('is_published') ? 1 : 0,
                    'meta_keywords' => $this->request->getPost('meta_keywords'),
                    'meta_description' => $this->request->getPost('meta_description'),
                    'order_position' => $this->request->getPost('order_position') ?: 0,
                ];

                $this->pageModel->update($id, $updateData);
                session()->setFlashdata('success', 'Halaman berhasil diperbarui');
                return redirect()->to('/admin/konten/pages');
            } else {
                $data['validation'] = $this->validator;
            }
        }

        return view('admin/konten/pages/edit', $data);
    }

    public function pageDelete($id)
    {
        $this->pageModel->delete($id);
        session()->setFlashdata('success', 'Halaman berhasil dihapus');
        return redirect()->to('/admin/konten/pages');
    }

    // Banners Management
    public function banners()
    {
        $data = [
            'title' => 'Banner',
            'banners' => $this->bannerModel->orderBy('order_position', 'ASC')->findAll()
        ];

        return view('admin/konten/banners/index', $data);
    }

    public function bannerCreate()
    {
        $data = [
            'title' => 'Tambah Banner'
        ];

        if ($this->request->getMethod() === 'POST') {
            $rules = [
                'title' => 'required|min_length[3]|max_length[255]',
                'position' => 'required|in_list[home_slider,sidebar,header,footer]',
            ];

            if ($this->validate($rules)) {
                $insertData = [
                    'title' => $this->request->getPost('title'),
                    'description' => $this->request->getPost('description'),
                    'link' => $this->request->getPost('link'),
                    'position' => $this->request->getPost('position'),
                    'is_active' => $this->request->getPost('is_active') ? 1 : 0,
                    'start_date' => $this->request->getPost('start_date') ?: date('Y-m-d'),
                    'end_date' => $this->request->getPost('end_date') ?: date('Y-m-d', strtotime('+1 year')),
                    'order_position' => $this->request->getPost('order_position') ?: 0,
                ];

                // Handle image upload
                $imageFile = $this->request->getFile('image');
                if ($imageFile && $imageFile->isValid() && !$imageFile->hasMoved()) {
                    $newName = $imageFile->getRandomName();
                    $imageFile->move('uploads/banners', $newName);
                    $insertData['image'] = $newName;
                }

                $this->bannerModel->insert($insertData);
                session()->setFlashdata('success', 'Banner berhasil ditambahkan');
                return redirect()->to('/admin/konten/banners');
            } else {
                $data['validation'] = $this->validator;
            }
        }

        return view('admin/konten/banners/create', $data);
    }

    public function bannerEdit($id)
    {
        $banner = $this->bannerModel->find($id);
        if (!$banner) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = [
            'title' => 'Edit Banner',
            'banner' => $banner
        ];

        if ($this->request->getMethod() === 'POST') {
            $rules = [
                'title' => 'required|min_length[3]|max_length[255]',
                'position' => 'required|in_list[home_slider,sidebar,header,footer]',
            ];

            if ($this->validate($rules)) {
                $updateData = [
                    'title' => $this->request->getPost('title'),
                    'description' => $this->request->getPost('description'),
                    'link' => $this->request->getPost('link'),
                    'position' => $this->request->getPost('position'),
                    'is_active' => $this->request->getPost('is_active') ? 1 : 0,
                    'start_date' => $this->request->getPost('start_date'),
                    'end_date' => $this->request->getPost('end_date'),
                    'order_position' => $this->request->getPost('order_position') ?: 0,
                ];

                // Handle image upload
                $imageFile = $this->request->getFile('image');
                if ($imageFile && $imageFile->isValid() && !$imageFile->hasMoved()) {
                    $newName = $imageFile->getRandomName();
                    $imageFile->move('uploads/banners', $newName);
                    $updateData['image'] = $newName;
                }

                $this->bannerModel->update($id, $updateData);
                session()->setFlashdata('success', 'Banner berhasil diperbarui');
                return redirect()->to('/admin/konten/banners');
            } else {
                $data['validation'] = $this->validator;
            }
        }

        return view('admin/konten/banners/edit', $data);
    }

    public function bannerDelete($id)
    {
        $this->bannerModel->delete($id);
        session()->setFlashdata('success', 'Banner berhasil dihapus');
        return redirect()->to('/admin/konten/banners');
    }

    // Links Management
    public function links()
    {
        $data = [
            'title' => 'Link Terkait',
            'links' => $this->linkModel->orderBy('order_position', 'ASC')->findAll()
        ];

        return view('admin/konten/links/index', $data);
    }

    public function linkCreate()
    {
        $data = [
            'title' => 'Tambah Link'
        ];

        if ($this->request->getMethod() === 'POST') {
            $rules = [
                'title' => 'required|min_length[3]|max_length[255]',
                'url' => 'required|valid_url',
            ];

            if ($this->validate($rules)) {
                $insertData = [
                    'title' => $this->request->getPost('title'),
                    'url' => $this->request->getPost('url'),
                    'description' => $this->request->getPost('description'),
                    'icon' => $this->request->getPost('icon'),
                    'category' => $this->request->getPost('category'),
                    'is_active' => $this->request->getPost('is_active') ? 1 : 0,
                    'order_position' => $this->request->getPost('order_position') ?: 0,
                ];

                $this->linkModel->insert($insertData);
                session()->setFlashdata('success', 'Link berhasil ditambahkan');
                return redirect()->to('/admin/konten/links');
            } else {
                $data['validation'] = $this->validator;
            }
        }

        return view('admin/konten/links/create', $data);
    }

    public function linkEdit($id)
    {
        $link = $this->linkModel->find($id);
        if (!$link) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = [
            'title' => 'Edit Link',
            'link' => $link
        ];

        if ($this->request->getMethod() === 'POST') {
            $rules = [
                'title' => 'required|min_length[3]|max_length[255]',
                'url' => 'required|valid_url',
            ];

            if ($this->validate($rules)) {
                $updateData = [
                    'title' => $this->request->getPost('title'),
                    'url' => $this->request->getPost('url'),
                    'description' => $this->request->getPost('description'),
                    'icon' => $this->request->getPost('icon'),
                    'category' => $this->request->getPost('category'),
                    'is_active' => $this->request->getPost('is_active') ? 1 : 0,
                    'order_position' => $this->request->getPost('order_position') ?: 0,
                ];

                $this->linkModel->update($id, $updateData);
                session()->setFlashdata('success', 'Link berhasil diperbarui');
                return redirect()->to('/admin/konten/links');
            } else {
                $data['validation'] = $this->validator;
            }
        }

        return view('admin/konten/links/edit', $data);
    }

    public function linkDelete($id)
    {
        $this->linkModel->delete($id);
        session()->setFlashdata('success', 'Link berhasil dihapus');
        return redirect()->to('/admin/konten/links');
    }

    // FAQ Management
    public function faq()
    {
        $data = [
            'title' => 'Tanya Jawab (FAQ)',
            'faq' => $this->faqModel->orderBy('order_position', 'ASC')->findAll()
        ];

        return view('admin/konten/faq/index', $data);
    }

    public function faqCreate()
    {
        $data = [
            'title' => 'Tambah FAQ'
        ];

        if ($this->request->getMethod() === 'POST') {
            $rules = [
                'question' => 'required|min_length[3]',
                'answer' => 'required',
            ];

            if ($this->validate($rules)) {
                $insertData = [
                    'question' => $this->request->getPost('question'),
                    'answer' => $this->request->getPost('answer'),
                    'category' => $this->request->getPost('category'),
                    'is_published' => $this->request->getPost('is_published') ? 1 : 0,
                    'order_position' => $this->request->getPost('order_position') ?: 0,
                ];

                $this->faqModel->insert($insertData);
                session()->setFlashdata('success', 'FAQ berhasil ditambahkan');
                return redirect()->to('/admin/konten/faq');
            } else {
                $data['validation'] = $this->validator;
            }
        }

        return view('admin/konten/faq/create', $data);
    }

    public function faqEdit($id)
    {
        $faq = $this->faqModel->find($id);
        if (!$faq) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = [
            'title' => 'Edit FAQ',
            'faq' => $faq
        ];

        if ($this->request->getMethod() === 'POST') {
            $rules = [
                'question' => 'required|min_length[3]',
                'answer' => 'required',
            ];

            if ($this->validate($rules)) {
                $updateData = [
                    'question' => $this->request->getPost('question'),
                    'answer' => $this->request->getPost('answer'),
                    'category' => $this->request->getPost('category'),
                    'is_published' => $this->request->getPost('is_published') ? 1 : 0,
                    'order_position' => $this->request->getPost('order_position') ?: 0,
                ];

                $this->faqModel->update($id, $updateData);
                session()->setFlashdata('success', 'FAQ berhasil diperbarui');
                return redirect()->to('/admin/konten/faq');
            } else {
                $data['validation'] = $this->validator;
            }
        }

        return view('admin/konten/faq/edit', $data);
    }

    public function faqDelete($id)
    {
        $this->faqModel->delete($id);
        session()->setFlashdata('success', 'FAQ berhasil dihapus');
        return redirect()->to('/admin/konten/faq');
    }
}
