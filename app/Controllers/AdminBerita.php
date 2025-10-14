<?php

namespace App\Controllers;

use App\Models\NewsModel;

class AdminBerita extends BaseController
{
    protected $newsModel;

    public function __construct()
    {
        $this->newsModel = new NewsModel();

        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/admin/login');
        }
    }

    public function index()
    {
        $category = $this->request->getGet('category');
        $builder = $this->newsModel;

        if ($category) {
            $builder->where('category', $category);
        }

        $data = [
            'title' => 'Berita & Warta Jemaat',
            'news' => $builder->orderBy('created_at', 'DESC')->findAll(),
            'category' => $category
        ];

        return view('admin/berita/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Berita'
        ];

        if ($this->request->getMethod() === 'POST') {
            $rules = [
                'title' => 'required|min_length[3]|max_length[255]',
                'category' => 'required|in_list[artikel,pengumuman,renungan,agenda]',
                'content' => 'required',
            ];

            if ($this->validate($rules)) {
                $insertData = [
                    'title' => $this->request->getPost('title'),
                    'slug' => url_title($this->request->getPost('title'), '-', true),
                    'category' => $this->request->getPost('category'),
                    'content' => $this->request->getPost('content'),
                    'excerpt' => $this->request->getPost('excerpt'),
                    'author_id' => session()->get('userId'),
                    'is_published' => $this->request->getPost('is_published') ? 1 : 0,
                    'published_at' => $this->request->getPost('is_published') ? date('Y-m-d H:i:s') : null,
                    'meta_keywords' => $this->request->getPost('meta_keywords'),
                    'meta_description' => $this->request->getPost('meta_description'),
                ];

                // Handle featured image upload
                $imageFile = $this->request->getFile('featured_image');
                if ($imageFile && $imageFile->isValid() && !$imageFile->hasMoved()) {
                    $newName = $imageFile->getRandomName();
                    $imageFile->move('uploads/news', $newName);
                    $insertData['featured_image'] = $newName;
                }

                $this->newsModel->insert($insertData);
                session()->setFlashdata('success', 'Berita berhasil ditambahkan');
                return redirect()->to('/admin/berita');
            } else {
                $data['validation'] = $this->validator;
            }
        }

        return view('admin/berita/create', $data);
    }

    public function edit($id)
    {
        $news = $this->newsModel->find($id);
        if (!$news) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = [
            'title' => 'Edit Berita',
            'news' => $news
        ];

        if ($this->request->getMethod() === 'POST') {
            $rules = [
                'title' => 'required|min_length[3]|max_length[255]',
                'category' => 'required|in_list[artikel,pengumuman,renungan,agenda]',
                'content' => 'required',
            ];

            if ($this->validate($rules)) {
                $updateData = [
                    'title' => $this->request->getPost('title'),
                    'slug' => url_title($this->request->getPost('title'), '-', true),
                    'category' => $this->request->getPost('category'),
                    'content' => $this->request->getPost('content'),
                    'excerpt' => $this->request->getPost('excerpt'),
                    'is_published' => $this->request->getPost('is_published') ? 1 : 0,
                    'meta_keywords' => $this->request->getPost('meta_keywords'),
                    'meta_description' => $this->request->getPost('meta_description'),
                ];

                if ($this->request->getPost('is_published') && !$news['is_published']) {
                    $updateData['published_at'] = date('Y-m-d H:i:s');
                }

                // Handle featured image upload
                $imageFile = $this->request->getFile('featured_image');
                if ($imageFile && $imageFile->isValid() && !$imageFile->hasMoved()) {
                    $newName = $imageFile->getRandomName();
                    $imageFile->move('uploads/news', $newName);
                    $updateData['featured_image'] = $newName;
                }

                $this->newsModel->update($id, $updateData);
                session()->setFlashdata('success', 'Berita berhasil diperbarui');
                return redirect()->to('/admin/berita');
            } else {
                $data['validation'] = $this->validator;
            }
        }

        return view('admin/berita/edit', $data);
    }

    public function view($id)
    {
        $news = $this->newsModel->find($id);
        if (!$news) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = [
            'title' => 'Detail Berita',
            'news' => $news
        ];

        return view('admin/berita/view', $data);
    }

    public function delete($id)
    {
        $this->newsModel->delete($id);
        session()->setFlashdata('success', 'Berita berhasil dihapus');
        return redirect()->to('/admin/berita');
    }

    public function togglePublish($id)
    {
        $news = $this->newsModel->find($id);
        if ($news) {
            $updateData = [
                'is_published' => !$news['is_published']
            ];
            
            if (!$news['is_published']) {
                $updateData['published_at'] = date('Y-m-d H:i:s');
            }
            
            $this->newsModel->update($id, $updateData);
            session()->setFlashdata('success', 'Status publikasi berhasil diubah');
        }
        return redirect()->to('/admin/berita');
    }
}
