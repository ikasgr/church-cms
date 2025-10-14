<?php

namespace App\Controllers;

use App\Models\GalleryModel;

class AdminGaleri extends BaseController
{
    protected $galleryModel;

    public function __construct()
    {
        $this->galleryModel = new GalleryModel();

        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/admin/login');
        }
    }

    public function index()
    {
        $type = $this->request->getGet('type');
        $category = $this->request->getGet('category');
        $builder = $this->galleryModel;

        if ($type) {
            $builder->where('type', $type);
        }

        if ($category) {
            $builder->where('category', $category);
        }

        $data = [
            'title' => 'Galeri',
            'gallery' => $builder->orderBy('event_date', 'DESC')->findAll(),
            'type' => $type,
            'category' => $category
        ];

        return view('admin/galeri/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Galeri'
        ];

        if ($this->request->getMethod() === 'POST') {
            $rules = [
                'title' => 'required|min_length[3]|max_length[255]',
                'type' => 'required|in_list[photo,video]',
            ];

            if ($this->validate($rules)) {
                $insertData = [
                    'title' => $this->request->getPost('title'),
                    'description' => $this->request->getPost('description'),
                    'type' => $this->request->getPost('type'),
                    'category' => $this->request->getPost('category'),
                    'event_date' => $this->request->getPost('event_date'),
                    'is_published' => $this->request->getPost('is_published') ? 1 : 0,
                    'order_position' => $this->request->getPost('order_position') ?: 0,
                ];

                $type = $this->request->getPost('type');

                if ($type == 'photo') {
                    // Handle photo upload
                    $photoFile = $this->request->getFile('file_path');
                    if ($photoFile && $photoFile->isValid() && !$photoFile->hasMoved()) {
                        $newName = $photoFile->getRandomName();
                        $photoFile->move('uploads/gallery/photos', $newName);
                        $insertData['file_path'] = $newName;
                        
                        // Create thumbnail
                        $image = \Config\Services::image()
                            ->withFile('uploads/gallery/photos/' . $newName)
                            ->fit(300, 300, 'center')
                            ->save('uploads/gallery/thumbnails/' . $newName);
                        $insertData['thumbnail'] = $newName;
                    }
                } else {
                    // Video URL
                    $insertData['video_url'] = $this->request->getPost('video_url');
                    
                    // Handle thumbnail upload for video
                    $thumbnailFile = $this->request->getFile('thumbnail');
                    if ($thumbnailFile && $thumbnailFile->isValid() && !$thumbnailFile->hasMoved()) {
                        $newName = $thumbnailFile->getRandomName();
                        $thumbnailFile->move('uploads/gallery/thumbnails', $newName);
                        $insertData['thumbnail'] = $newName;
                    }
                }

                $this->galleryModel->insert($insertData);
                session()->setFlashdata('success', 'Galeri berhasil ditambahkan');
                return redirect()->to('/admin/galeri');
            } else {
                $data['validation'] = $this->validator;
            }
        }

        return view('admin/galeri/create', $data);
    }

    public function edit($id)
    {
        $gallery = $this->galleryModel->find($id);
        if (!$gallery) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = [
            'title' => 'Edit Galeri',
            'gallery' => $gallery
        ];

        if ($this->request->getMethod() === 'POST') {
            $rules = [
                'title' => 'required|min_length[3]|max_length[255]',
                'type' => 'required|in_list[photo,video]',
            ];

            if ($this->validate($rules)) {
                $updateData = [
                    'title' => $this->request->getPost('title'),
                    'description' => $this->request->getPost('description'),
                    'type' => $this->request->getPost('type'),
                    'category' => $this->request->getPost('category'),
                    'event_date' => $this->request->getPost('event_date'),
                    'is_published' => $this->request->getPost('is_published') ? 1 : 0,
                    'order_position' => $this->request->getPost('order_position') ?: 0,
                ];

                $type = $this->request->getPost('type');

                if ($type == 'photo') {
                    // Handle photo upload
                    $photoFile = $this->request->getFile('file_path');
                    if ($photoFile && $photoFile->isValid() && !$photoFile->hasMoved()) {
                        $newName = $photoFile->getRandomName();
                        $photoFile->move('uploads/gallery/photos', $newName);
                        $updateData['file_path'] = $newName;
                        
                        // Create thumbnail
                        $image = \Config\Services::image()
                            ->withFile('uploads/gallery/photos/' . $newName)
                            ->fit(300, 300, 'center')
                            ->save('uploads/gallery/thumbnails/' . $newName);
                        $updateData['thumbnail'] = $newName;
                    }
                } else {
                    // Video URL
                    $updateData['video_url'] = $this->request->getPost('video_url');
                    
                    // Handle thumbnail upload for video
                    $thumbnailFile = $this->request->getFile('thumbnail');
                    if ($thumbnailFile && $thumbnailFile->isValid() && !$thumbnailFile->hasMoved()) {
                        $newName = $thumbnailFile->getRandomName();
                        $thumbnailFile->move('uploads/gallery/thumbnails', $newName);
                        $updateData['thumbnail'] = $newName;
                    }
                }

                $this->galleryModel->update($id, $updateData);
                session()->setFlashdata('success', 'Galeri berhasil diperbarui');
                return redirect()->to('/admin/galeri');
            } else {
                $data['validation'] = $this->validator;
            }
        }

        return view('admin/galeri/edit', $data);
    }

    public function view($id)
    {
        $gallery = $this->galleryModel->find($id);
        if (!$gallery) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = [
            'title' => 'Detail Galeri',
            'gallery' => $gallery
        ];

        return view('admin/galeri/view', $data);
    }

    public function delete($id)
    {
        $this->galleryModel->delete($id);
        session()->setFlashdata('success', 'Galeri berhasil dihapus');
        return redirect()->to('/admin/galeri');
    }

    public function togglePublish($id)
    {
        $gallery = $this->galleryModel->find($id);
        if ($gallery) {
            $this->galleryModel->update($id, ['is_published' => !$gallery['is_published']]);
            session()->setFlashdata('success', 'Status publikasi berhasil diubah');
        }
        return redirect()->to('/admin/galeri');
    }
}
