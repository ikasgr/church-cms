<?php

namespace App\Controllers;

use App\Models\NewsModel;
use App\Models\MajelisModel;
use App\Models\RegistrationModel;
use App\Models\ProductModel;
use App\Models\ProductCategoryModel;
use App\Models\SellerModel;

class Home extends BaseController
{
    protected NewsModel $newsModel;
    protected MajelisModel $majelisModel;
    protected RegistrationModel $registrationModel;
    protected ProductModel $productModel;
    protected ProductCategoryModel $productCategoryModel;
    protected SellerModel $sellerModel;

    /**
     * Mapping of news categories to display labels.
     *
     * @var array<string, string>
     */
    protected array $newsCategories = [
        'artikel'     => 'Artikel',
        'pengumuman'  => 'Pengumuman',
        'renungan'    => 'Renungan',
        'agenda'      => 'Agenda',
    ];

    public function __construct()
    {
        helper(['text', 'url', 'form']);
        $this->newsModel = new NewsModel();
        $this->majelisModel = new MajelisModel();
        $this->registrationModel = new RegistrationModel();
        $this->productModel = new ProductModel();
        $this->productCategoryModel = new ProductCategoryModel();
        $this->sellerModel = new SellerModel();
    }

    public function index(): string
    {
        $latestNews = $this->newsModel
            ->where('is_published', 1)
            ->where('published_at <=', date('Y-m-d H:i:s'))
            ->orderBy('published_at', 'DESC')
            ->limit(4)
            ->findAll();

        $majelis = $this->majelisModel->getActiveMajelis();

        return view('frontend/home', [
            'title' => 'CMS Church || Responsive HTML 5 Template',
            'latestNews' => $latestNews,
            'newsCategories' => $this->newsCategories,
            'majelis' => $majelis,
        ]);
    }

    public function news(): string
    {
        $news = $this->newsModel
            ->where('is_published', 1)
            ->where('published_at <=', date('Y-m-d H:i:s'))
            ->orderBy('published_at', 'DESC')
            ->paginate(9, 'news');

        return view('frontend/news/index', [
            'title' => 'Berita & Warta',
            'newsList' => $news,
            'pager' => $this->newsModel->pager,
            'activeCategory' => null,
            'categories' => $this->newsCategories,
            'popularNews' => $this->newsModel->getPopular(5),
        ]);
    }

    public function newsByCategory(string $category)
    {
        if (!array_key_exists($category, $this->newsCategories)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $news = $this->newsModel
            ->where('category', $category)
            ->where('is_published', 1)
            ->where('published_at <=', date('Y-m-d H:i:s'))
            ->orderBy('published_at', 'DESC')
            ->paginate(9, 'news');

        return view('frontend/news/index', [
            'title' => 'Berita & Warta - ' . $this->newsCategories[$category],
            'newsList' => $news,
            'pager' => $this->newsModel->pager,
            'activeCategory' => $category,
            'categories' => $this->newsCategories,
            'popularNews' => $this->newsModel->getPopular(5),
        ]);
    }

    public function newsDetail(string $slug)
    {
        $news = $this->newsModel->where('is_published', 1)
            ->where('published_at <=', date('Y-m-d H:i:s'))
            ->where('slug', $slug)
            ->first();

        if (!$news) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $this->newsModel->incrementViews($news['id']);

        $related = $this->newsModel
            ->where('id !=', $news['id'])
            ->where('is_published', 1)
            ->where('published_at <=', date('Y-m-d H:i:s'))
            ->orderBy('published_at', 'DESC')
            ->limit(4)
            ->findAll();

        return view('frontend/news/detail', [
            'title' => $news['title'],
            'newsItem' => $news,
            'relatedNews' => $related,
            'categories' => $this->newsCategories,
        ]);
    }

    public function majelis(): string
    {
        $majelis = $this->majelisModel->getActiveMajelis();

        return view('frontend/majelis', [
            'title' => 'Majelis Gereja',
            'majelis' => $majelis,
        ]);
    }

    public function registration(): string
    {
        $allowedTypes = ['baptis', 'sidi', 'nikah'];
        $activeType = $this->request->getGet('type') ?? 'baptis';

        if (!in_array($activeType, $allowedTypes, true)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return view('frontend/registration', [
            'title' => 'Pendaftaran Pelayanan Gereja',
            'activeType' => $activeType,
            'allowedTypes' => $allowedTypes,
            'successMessage' => session()->getFlashdata('success'),
            'errors' => session()->getFlashdata('errors') ?? [],
        ]);
    }

    public function registrationSubmit()
    {
        $type = $this->request->getPost('type');
        $allowedTypes = ['baptis', 'sidi', 'nikah'];

        if (!in_array($type, $allowedTypes, true)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $rules = [
            'full_name' => 'required|min_length[3]',
            'birth_date' => 'required|valid_date',
            'gender' => 'required|in_list[L,P]',
            'phone' => 'required',
            'address' => 'required|min_length[5]',
        ];

        if ($type === 'sidi') {
            $rules['baptism_place'] = 'required';
            $rules['baptism_date'] = 'required|valid_date';
        }

        if ($type === 'nikah') {
            $rules['partner_name'] = 'required|min_length[3]';
            $rules['partner_phone'] = 'required';
        }

        $validation = \Config\Services::validation();

        if (!$this->validate($rules)) {
            return redirect()
                ->to('/registration?type=' . $type)
                ->withInput()
                ->with('errors', $validation->getErrors());
        }

        $insertData = [
            'type' => $type,
            'full_name' => $this->request->getPost('full_name'),
            'birth_place' => $this->request->getPost('birth_place'),
            'birth_date' => $this->request->getPost('birth_date'),
            'gender' => $this->request->getPost('gender'),
            'address' => $this->request->getPost('address'),
            'phone' => $this->request->getPost('phone'),
            'email' => $this->request->getPost('email'),
            'preferred_date' => $this->request->getPost('preferred_date'),
            'notes' => $this->request->getPost('notes'),
            'status' => 'pending',
        ];

        if ($type === 'baptis') {
            $insertData['parent_name'] = $this->request->getPost('parent_name');
            $insertData['parent_phone'] = $this->request->getPost('parent_phone');
        }

        if ($type === 'sidi') {
            $insertData['baptism_place'] = $this->request->getPost('baptism_place');
            $insertData['baptism_date'] = $this->request->getPost('baptism_date');
        }

        if ($type === 'nikah') {
            $insertData['partner_name'] = $this->request->getPost('partner_name');
            $insertData['partner_birth_place'] = $this->request->getPost('partner_birth_place');
            $insertData['partner_birth_date'] = $this->request->getPost('partner_birth_date');
            $insertData['partner_address'] = $this->request->getPost('partner_address');
            $insertData['partner_phone'] = $this->request->getPost('partner_phone');
        }

        $document = $this->request->getFile('document');
        if ($document && $document->isValid() && !$document->hasMoved()) {
            $folder = FCPATH . 'uploads/pendaftaran/' . $type;
            if (!is_dir($folder)) {
                mkdir($folder, 0775, true);
            }

            $newName = $type . '_' . time() . '_' . $document->getRandomName();
            $document->move($folder, $newName);
            $insertData['document_path'] = $newName;
        }

        $this->registrationModel->insert($insertData);

        session()->setFlashdata('success', 'Pendaftaran berhasil dikirim. Tim gereja akan segera menghubungi Anda.');

        return redirect()->to('/registration?type=' . $type);
    }

    public function umkm(): string
    {
        $data = $this->buildUmkmListData();

        return view('frontend/umkm/index', $data);
    }

    public function umkmCategory(string $slug): string
    {
        $category = $this->productCategoryModel
            ->where('slug', $slug)
            ->where('is_active', 1)
            ->first();

        if (!$category) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = $this->buildUmkmListData($category);

        return view('frontend/umkm/index', $data);
    }

    public function umkmProduct(string $slug): string
    {
        $product = $this->productModel
            ->select('products.*, sellers.business_name as seller_name, sellers.id as seller_id, sellers.phone as seller_phone, sellers.email as seller_email, sellers.address as seller_address, sellers.logo as seller_logo, product_categories.name as category_name, product_categories.slug as category_slug')
            ->join('sellers', 'sellers.id = products.seller_id', 'left')
            ->join('product_categories', 'product_categories.id = products.category_id', 'left')
            ->where('products.slug', $slug)
            ->where('products.is_active', 1)
            ->where('products.deleted_at', null)
            ->first();

        if (!$product) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $this->productModel->incrementViews($product['id']);

        $relatedBuilder = $this->productModel
            ->select('products.*, sellers.business_name as seller_name, product_categories.name as category_name')
            ->join('sellers', 'sellers.id = products.seller_id', 'left')
            ->join('product_categories', 'product_categories.id = products.category_id', 'left')
            ->where('products.is_active', 1)
            ->where('products.deleted_at', null)
            ->where('products.id !=', $product['id'])
            ->orderBy('products.created_at', 'DESC')
            ->limit(4);

        if (!empty($product['category_id'])) {
            $relatedBuilder->where('products.category_id', $product['category_id']);
        }

        $relatedProducts = $relatedBuilder->findAll();

        $images = json_decode($product['images'] ?? '[]', true) ?: [];

        return view('frontend/umkm/product_detail', [
            'title' => $product['name'] ?? 'Detail Produk',
            'product' => $product,
            'images' => $images,
            'relatedProducts' => $relatedProducts,
        ]);
    }

    public function umkmSeller(int $sellerId): string
    {
        $seller = $this->sellerModel->getWithStats($sellerId);

        if (!$seller || ($seller['status'] ?? '') !== 'active') {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $products = $this->productModel->getPublicProducts(['seller_id' => $sellerId]);

        return view('frontend/umkm/seller', [
            'title' => 'Pelapak: ' . $seller['business_name'],
            'seller' => $seller,
            'products' => $products,
        ]);
    }

    private function buildUmkmListData(?array $category = null): array
    {
        $categories = $this->getActiveProductCategories();

        $search = trim((string) ($this->request->getGet('q') ?? ''));
        $priceMinParam = $this->request->getGet('min');
        $priceMaxParam = $this->request->getGet('max');
        $sortParam = $this->request->getGet('sort') ?? 'latest';

        $allowedSorts = ['latest', 'price_asc', 'price_desc', 'popular', 'rating'];
        $sort = in_array($sortParam, $allowedSorts, true) ? $sortParam : 'latest';

        $filters = [];
        if ($category) {
            $filters['category_id'] = $category['id'];
        }

        if ($search !== '') {
            $filters['search'] = $search;
        }

        $priceMin = is_numeric($priceMinParam) ? (int) $priceMinParam : null;
        $priceMax = is_numeric($priceMaxParam) ? (int) $priceMaxParam : null;

        if ($priceMin !== null) {
            $filters['min_price'] = $priceMin;
        }

        if ($priceMax !== null) {
            $filters['max_price'] = $priceMax;
        }

        if ($sort !== 'latest') {
            $filters['sort'] = $sort;
        }

        $products = $this->productModel->getPublicProducts($filters);

        return [
            'title' => 'UMKM Jemaat',
            'products' => $products,
            'categories' => $categories,
            'activeCategory' => $category['slug'] ?? null,
            'activeCategoryName' => $category['name'] ?? null,
            'search' => $search,
            'priceMin' => $priceMin,
            'priceMax' => $priceMax,
            'sort' => $sort,
        ];
    }

    private function getActiveProductCategories(): array
    {
        $categories = $this->productCategoryModel->getWithProductCount();

        return array_values(array_filter($categories, static function (array $category): bool {
            return (int) ($category['is_active'] ?? 0) === 1;
        }));
    }
}
