<?php

namespace App\Controllers;

use App\Models\SellerModel;
use App\Models\ProductModel;
use App\Models\ProductCategoryModel;
use App\Models\OrderModel;

class AdminUmkm extends BaseController
{
    protected $sellerModel;
    protected $productModel;
    protected $categoryModel;
    protected $orderModel;

    public function __construct()
    {
        $this->sellerModel = new SellerModel();
        $this->productModel = new ProductModel();
        $this->categoryModel = new ProductCategoryModel();
        $this->orderModel = new OrderModel();

        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/admin/login');
        }
    }

    // Dashboard UMKM
    public function index()
    {
        $db = \Config\Database::connect();
        
        $data = [
            'title' => 'Dashboard Toko UMKM',
            'total_sellers' => $this->sellerModel->where('status', 'active')->countAllResults(),
            'total_products' => $this->productModel->where('is_active', 1)->countAllResults(),
            'total_orders' => $this->orderModel->countAllResults(),
            'pending_orders' => $this->orderModel->where('status', 'pending')->countAllResults(),
            'total_revenue' => $db->table('orders')->selectSum('total')->where('status', 'completed')->get()->getRow()->total ?? 0,
            'recent_orders' => $this->orderModel->orderBy('created_at', 'DESC')->limit(10)->find(),
            'top_products' => $this->productModel->orderBy('sold_count', 'DESC')->limit(5)->find(),
        ];

        return view('admin/umkm/index', $data);
    }

    // Sellers Management
    public function sellers()
    {
        $data = [
            'title' => 'Kelola Pelapak UMKM',
            'sellers' => $this->sellerModel->getWithStats()
        ];

        return view('admin/umkm/sellers/index', $data);
    }

    public function sellerView($id)
    {
        $seller = $this->sellerModel->getWithStats($id);
        if (!$seller) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = [
            'title' => 'Detail Pelapak',
            'seller' => $seller,
            'products' => $this->productModel->where('seller_id', $id)->findAll(),
            'orders' => $this->orderModel->getSellerOrders($id)
        ];

        return view('admin/umkm/sellers/view', $data);
    }

    public function sellerApprove($id)
    {
        $this->sellerModel->update($id, ['status' => 'active', 'is_verified' => 1]);
        session()->setFlashdata('success', 'Pelapak berhasil disetujui');
        return redirect()->to('/admin/umkm/sellers');
    }

    public function sellerSuspend($id)
    {
        $this->sellerModel->update($id, ['status' => 'suspended']);
        session()->setFlashdata('success', 'Pelapak berhasil disuspend');
        return redirect()->to('/admin/umkm/sellers');
    }

    public function sellerCreate()
    {
        $data = ['title' => 'Tambah Pelapak'];

        if ($this->request->getMethod() === 'POST') {
            $rules = [
                'business_name' => 'required|min_length[3]',
                'owner_name' => 'required|min_length[3]',
                'email' => 'required|valid_email|is_unique[sellers.email]',
                'phone' => 'required',
            ];

            if ($this->validate($rules)) {
                $insertData = [
                    'business_name' => $this->request->getPost('business_name'),
                    'owner_name' => $this->request->getPost('owner_name'),
                    'email' => $this->request->getPost('email'),
                    'phone' => $this->request->getPost('phone'),
                    'address' => $this->request->getPost('address'),
                    'description' => $this->request->getPost('description'),
                    'bank_name' => $this->request->getPost('bank_name'),
                    'bank_account_number' => $this->request->getPost('bank_account_number'),
                    'bank_account_name' => $this->request->getPost('bank_account_name'),
                    'commission_rate' => $this->request->getPost('commission_rate') ?: 0,
                    'status' => $this->request->getPost('status') ?: 'active',
                ];

                // Handle logo upload
                $logoFile = $this->request->getFile('logo');
                if ($logoFile && $logoFile->isValid() && !$logoFile->hasMoved()) {
                    $newName = $logoFile->getRandomName();
                    $logoFile->move('uploads/umkm/sellers', $newName);
                    $insertData['logo'] = $newName;
                }

                $this->sellerModel->insert($insertData);
                session()->setFlashdata('success', 'Pelapak berhasil ditambahkan');
                return redirect()->to('/admin/umkm/sellers');
            } else {
                $data['validation'] = $this->validator;
            }
        }

        return view('admin/umkm/sellers/create', $data);
    }

    public function sellerEdit($id)
    {
        $seller = $this->sellerModel->find($id);
        if (!$seller) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = [
            'title' => 'Edit Pelapak',
            'seller' => $seller
        ];

        if ($this->request->getMethod() === 'POST') {
            $rules = [
                'business_name' => 'required|min_length[3]',
                'owner_name' => 'required|min_length[3]',
                'email' => 'required|valid_email',
                'phone' => 'required',
            ];

            if ($this->validate($rules)) {
                $updateData = [
                    'business_name' => $this->request->getPost('business_name'),
                    'owner_name' => $this->request->getPost('owner_name'),
                    'email' => $this->request->getPost('email'),
                    'phone' => $this->request->getPost('phone'),
                    'address' => $this->request->getPost('address'),
                    'description' => $this->request->getPost('description'),
                    'bank_name' => $this->request->getPost('bank_name'),
                    'bank_account_number' => $this->request->getPost('bank_account_number'),
                    'bank_account_name' => $this->request->getPost('bank_account_name'),
                    'commission_rate' => $this->request->getPost('commission_rate') ?: 0,
                    'status' => $this->request->getPost('status'),
                ];

                // Handle logo upload
                $logoFile = $this->request->getFile('logo');
                if ($logoFile && $logoFile->isValid() && !$logoFile->hasMoved()) {
                    // Delete old logo
                    if ($seller['logo'] && file_exists('uploads/umkm/sellers/' . $seller['logo'])) {
                        unlink('uploads/umkm/sellers/' . $seller['logo']);
                    }
                    $newName = $logoFile->getRandomName();
                    $logoFile->move('uploads/umkm/sellers', $newName);
                    $updateData['logo'] = $newName;
                }

                $this->sellerModel->update($id, $updateData);
                session()->setFlashdata('success', 'Pelapak berhasil diupdate');
                return redirect()->to('/admin/umkm/sellers');
            } else {
                $data['validation'] = $this->validator;
            }
        }

        return view('admin/umkm/sellers/edit', $data);
    }

    public function sellerDelete($id)
    {
        $seller = $this->sellerModel->find($id);
        if ($seller) {
            // Delete logo
            if ($seller['logo'] && file_exists('uploads/umkm/sellers/' . $seller['logo'])) {
                unlink('uploads/umkm/sellers/' . $seller['logo']);
            }
            $this->sellerModel->delete($id);
            session()->setFlashdata('success', 'Pelapak berhasil dihapus');
        }
        return redirect()->to('/admin/umkm/sellers');
    }

    // Products Management
    public function products()
    {
        $data = [
            'title' => 'Kelola Produk UMKM',
            'products' => $this->productModel->getWithDetails()
        ];

        return view('admin/umkm/products/index', $data);
    }

    public function productToggle($id)
    {
        $product = $this->productModel->find($id);
        if ($product) {
            $this->productModel->update($id, ['is_active' => !$product['is_active']]);
            session()->setFlashdata('success', 'Status produk berhasil diubah');
        }
        return redirect()->to('/admin/umkm/products');
    }

    public function productCreate()
    {
        $data = [
            'title' => 'Tambah Produk',
            'sellers' => $this->sellerModel->where('status', 'active')->findAll(),
            'categories' => $this->categoryModel->where('is_active', 1)->findAll()
        ];

        if ($this->request->getMethod() === 'POST') {
            $rules = [
                'seller_id' => 'required',
                'name' => 'required|min_length[3]',
                'price' => 'required|numeric',
                'stock' => 'required|numeric',
            ];

            if ($this->validate($rules)) {
                $insertData = [
                    'seller_id' => $this->request->getPost('seller_id'),
                    'category_id' => $this->request->getPost('category_id'),
                    'name' => $this->request->getPost('name'),
                    'slug' => url_title($this->request->getPost('name'), '-', true),
                    'description' => $this->request->getPost('description'),
                    'price' => $this->request->getPost('price'),
                    'discount_price' => $this->request->getPost('discount_price'),
                    'stock' => $this->request->getPost('stock'),
                    'unit' => $this->request->getPost('unit') ?: 'pcs',
                    'min_order' => $this->request->getPost('min_order') ?: 1,
                    'weight' => $this->request->getPost('weight'),
                    'sku' => $this->request->getPost('sku'),
                    'is_featured' => $this->request->getPost('is_featured') ? 1 : 0,
                    'is_active' => $this->request->getPost('is_active') ? 1 : 0,
                ];

                // Handle multiple image upload
                $images = [];
                $imageFiles = $this->request->getFiles();
                if (isset($imageFiles['images'])) {
                    foreach ($imageFiles['images'] as $img) {
                        if ($img->isValid() && !$img->hasMoved()) {
                            $newName = $img->getRandomName();
                            $img->move('uploads/umkm/products', $newName);
                            $images[] = $newName;
                        }
                    }
                }
                $insertData['images'] = json_encode($images);

                $this->productModel->insert($insertData);
                
                // Update seller total products
                $this->sellerModel->updateTotalProducts($insertData['seller_id']);
                
                session()->setFlashdata('success', 'Produk berhasil ditambahkan');
                return redirect()->to('/admin/umkm/products');
            } else {
                $data['validation'] = $this->validator;
            }
        }

        return view('admin/umkm/products/create', $data);
    }

    public function productEdit($id)
    {
        $product = $this->productModel->find($id);
        if (!$product) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = [
            'title' => 'Edit Produk',
            'product' => $product,
            'sellers' => $this->sellerModel->where('status', 'active')->findAll(),
            'categories' => $this->categoryModel->where('is_active', 1)->findAll()
        ];

        if ($this->request->getMethod() === 'POST') {
            $rules = [
                'seller_id' => 'required',
                'name' => 'required|min_length[3]',
                'price' => 'required|numeric',
                'stock' => 'required|numeric',
            ];

            if ($this->validate($rules)) {
                $updateData = [
                    'seller_id' => $this->request->getPost('seller_id'),
                    'category_id' => $this->request->getPost('category_id'),
                    'name' => $this->request->getPost('name'),
                    'slug' => url_title($this->request->getPost('name'), '-', true),
                    'description' => $this->request->getPost('description'),
                    'price' => $this->request->getPost('price'),
                    'discount_price' => $this->request->getPost('discount_price'),
                    'stock' => $this->request->getPost('stock'),
                    'unit' => $this->request->getPost('unit') ?: 'pcs',
                    'min_order' => $this->request->getPost('min_order') ?: 1,
                    'weight' => $this->request->getPost('weight'),
                    'sku' => $this->request->getPost('sku'),
                    'is_featured' => $this->request->getPost('is_featured') ? 1 : 0,
                    'is_active' => $this->request->getPost('is_active') ? 1 : 0,
                ];

                // Handle multiple image upload
                $imageFiles = $this->request->getFiles();
                if (isset($imageFiles['images'])) {
                    $oldImages = json_decode($product['images'], true) ?: [];
                    $images = $oldImages;
                    
                    foreach ($imageFiles['images'] as $img) {
                        if ($img->isValid() && !$img->hasMoved()) {
                            $newName = $img->getRandomName();
                            $img->move('uploads/umkm/products', $newName);
                            $images[] = $newName;
                        }
                    }
                    $updateData['images'] = json_encode($images);
                }

                $this->productModel->update($id, $updateData);
                session()->setFlashdata('success', 'Produk berhasil diupdate');
                return redirect()->to('/admin/umkm/products');
            } else {
                $data['validation'] = $this->validator;
            }
        }

        return view('admin/umkm/products/edit', $data);
    }

    public function productDelete($id)
    {
        $product = $this->productModel->find($id);
        if ($product) {
            // Delete images
            $images = json_decode($product['images'], true);
            if ($images) {
                foreach ($images as $img) {
                    if (file_exists('uploads/umkm/products/' . $img)) {
                        unlink('uploads/umkm/products/' . $img);
                    }
                }
            }
            
            $sellerId = $product['seller_id'];
            $this->productModel->delete($id);
            
            // Update seller total products
            $this->sellerModel->updateTotalProducts($sellerId);
            
            session()->setFlashdata('success', 'Produk berhasil dihapus');
        }
        return redirect()->to('/admin/umkm/products');
    }

    // Orders Management
    public function orders()
    {
        $data = [
            'title' => 'Kelola Pesanan',
            'orders' => $this->orderModel->orderBy('created_at', 'DESC')->findAll()
        ];

        return view('admin/umkm/orders/index', $data);
    }

    public function orderView($id)
    {
        $order = $this->orderModel->getWithItems($id);
        if (!$order) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = [
            'title' => 'Detail Pesanan',
            'order' => $order
        ];

        return view('admin/umkm/orders/view', $data);
    }

    public function orderUpdateStatus($id)
    {
        if ($this->request->getMethod() === 'POST') {
            $status = $this->request->getPost('status');
            $this->orderModel->updateStatus($id, $status);
            session()->setFlashdata('success', 'Status pesanan berhasil diupdate');
            return redirect()->to('/admin/umkm/orders/view/' . $id);
        }
    }

    // Categories Management
    public function categories()
    {
        $data = [
            'title' => 'Kategori Produk',
            'categories' => $this->categoryModel->getWithProductCount()
        ];

        return view('admin/umkm/categories/index', $data);
    }

    public function categoryCreate()
    {
        $data = ['title' => 'Tambah Kategori'];

        if ($this->request->getMethod() === 'POST') {
            $rules = [
                'name' => 'required|min_length[3]|is_unique[product_categories.name]',
            ];

            if ($this->validate($rules)) {
                $insertData = [
                    'name' => $this->request->getPost('name'),
                    'slug' => url_title($this->request->getPost('name'), '-', true),
                    'description' => $this->request->getPost('description'),
                    'icon' => $this->request->getPost('icon') ?: 'fas fa-box',
                    'order_position' => $this->request->getPost('order_position') ?: 0,
                    'is_active' => $this->request->getPost('is_active') ? 1 : 0,
                ];

                $this->categoryModel->insert($insertData);
                session()->setFlashdata('success', 'Kategori berhasil ditambahkan');
                return redirect()->to('/admin/umkm/categories');
            } else {
                $data['validation'] = $this->validator;
            }
        }

        return view('admin/umkm/categories/create', $data);
    }

    public function categoryEdit($id)
    {
        $category = $this->categoryModel->find($id);
        if (!$category) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = [
            'title' => 'Edit Kategori',
            'category' => $category
        ];

        if ($this->request->getMethod() === 'POST') {
            $rules = [
                'name' => 'required|min_length[3]',
            ];

            if ($this->validate($rules)) {
                $updateData = [
                    'name' => $this->request->getPost('name'),
                    'slug' => url_title($this->request->getPost('name'), '-', true),
                    'description' => $this->request->getPost('description'),
                    'icon' => $this->request->getPost('icon') ?: 'fas fa-box',
                    'order_position' => $this->request->getPost('order_position') ?: 0,
                    'is_active' => $this->request->getPost('is_active') ? 1 : 0,
                ];

                $this->categoryModel->update($id, $updateData);
                session()->setFlashdata('success', 'Kategori berhasil diupdate');
                return redirect()->to('/admin/umkm/categories');
            } else {
                $data['validation'] = $this->validator;
            }
        }

        return view('admin/umkm/categories/edit', $data);
    }

    public function categoryDelete($id)
    {
        $this->categoryModel->delete($id);
        session()->setFlashdata('success', 'Kategori berhasil dihapus');
        return redirect()->to('/admin/umkm/categories');
    }

    // Reports
    public function reports()
    {
        $db = \Config\Database::connect();
        
        $data = [
            'title' => 'Laporan Penjualan',
            'daily_sales' => $db->table('orders')
                ->select('DATE(created_at) as date, COUNT(*) as total_orders, SUM(total) as total_sales')
                ->where('status', 'completed')
                ->where('created_at >=', date('Y-m-d', strtotime('-30 days')))
                ->groupBy('DATE(created_at)')
                ->orderBy('date', 'DESC')
                ->get()
                ->getResultArray(),
            'seller_sales' => $db->table('order_items')
                ->select('sellers.business_name, SUM(order_items.seller_income) as total_income, COUNT(order_items.id) as total_orders')
                ->join('sellers', 'sellers.id = order_items.seller_id')
                ->where('order_items.status', 'completed')
                ->groupBy('order_items.seller_id')
                ->orderBy('total_income', 'DESC')
                ->get()
                ->getResultArray()
        ];

        return view('admin/umkm/reports/index', $data);
    }
}
