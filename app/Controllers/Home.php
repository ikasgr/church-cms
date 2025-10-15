<?php

namespace App\Controllers;

use App\Models\NewsModel;
use App\Models\MajelisModel;
use App\Models\RegistrationModel;
use App\Models\ProductModel;
use App\Models\ProductCategoryModel;
use App\Models\SellerModel;
use App\Models\KeuanganModel;
use App\Models\GalleryModel;
use App\Models\FeedbackModel;
use App\Models\GuestbookModel;
use App\Models\SurveyModel;
use App\Models\SurveyQuestionModel;
use App\Models\SurveyResponseModel;

class Home extends BaseController
{
    protected NewsModel $newsModel;
    protected MajelisModel $majelisModel;
    protected RegistrationModel $registrationModel;
    protected ProductModel $productModel;
    protected ProductCategoryModel $productCategoryModel;
    protected SellerModel $sellerModel;
    protected KeuanganModel $keuanganModel;
    protected GalleryModel $galleryModel;
    protected FeedbackModel $feedbackModel;
    protected GuestbookModel $guestbookModel;
    protected SurveyModel $surveyModel;
    protected SurveyQuestionModel $surveyQuestionModel;
    protected SurveyResponseModel $surveyResponseModel;

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
        $this->keuanganModel = new KeuanganModel();
        $this->galleryModel = new GalleryModel();
        $this->feedbackModel = new FeedbackModel();
        $this->guestbookModel = new GuestbookModel();
        $this->surveyModel = new SurveyModel();
        $this->surveyQuestionModel = new SurveyQuestionModel();
        $this->surveyResponseModel = new SurveyResponseModel();
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

    public function surveys(): string
    {
        $surveys = $this->surveyModel
            ->orderBy('created_at', 'DESC')
            ->findAll();

        foreach ($surveys as &$survey) {
            $survey['response_count'] = $this->surveyModel->getResponseCount($survey['id']);
            $survey['is_open'] = $this->isSurveyOpen($survey, $survey['response_count']);
        }
        unset($survey);

        return view('frontend/surveys', [
            'title' => 'Survei & Jajak Pendapat Jemaat',
            'surveys' => $surveys,
        ]);
    }

    public function survey(int $id): string
    {
        $survey = $this->surveyModel->getWithQuestions($id);

        if (!$survey) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $responseCount = $this->surveyModel->getResponseCount($id);
        $isOpen = $this->isSurveyOpen($survey, $responseCount);

        return view('frontend/survey_detail', [
            'title' => $survey['title'],
            'survey' => $survey,
            'isOpen' => $isOpen,
            'responseCount' => $responseCount,
            'successMessage' => session()->getFlashdata('survey_success'),
            'errors' => session()->getFlashdata('survey_errors') ?? [],
        ]);
    }

    public function surveySubmit(int $id)
    {
        if ($this->request->getMethod() !== 'POST') {
            return redirect()->to('/survey/' . $id);
        }

        $survey = $this->surveyModel->getWithQuestions($id);

        if (!$survey) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $responseCount = $this->surveyModel->getResponseCount($id);
        if (!$this->isSurveyOpen($survey, $responseCount)) {
            return redirect()->to('/survey/' . $id)->with('survey_errors', ['Survei ini sudah ditutup.']);
        }

        $errors = [];
        $answers = [];
        $name = trim((string) $this->request->getPost('respondent_name'));
        $email = trim((string) $this->request->getPost('respondent_email'));

        if (!(int) $survey['is_anonymous'] && $name === '') {
            $errors['respondent_name'] = 'Nama wajib diisi.';
        }

        if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['respondent_email'] = 'Format email tidak valid.';
        }

        foreach ($survey['questions'] as $question) {
            $field = 'question_' . $question['id'];
            $rawValue = $this->request->getPost($field);
            $value = null;

            switch ($question['type']) {
                case 'checkbox':
                    $value = $rawValue ? array_filter((array) $rawValue) : [];
                    break;
                default:
                    $value = is_string($rawValue) ? trim($rawValue) : (is_array($rawValue) ? reset($rawValue) : '');
                    break;
            }

            $isEmpty = $question['type'] === 'checkbox' ? empty($value) : ($value === '' || $value === null);

            if ((int) $question['is_required'] && $isEmpty) {
                $errors[$field] = 'Pertanyaan ini wajib diisi.';
            }

            $options = (array) ($question['options'] ?? []);

            if (!$isEmpty && in_array($question['type'], ['radio', 'select'], true) && !in_array($value, $options, true)) {
                $errors[$field] = 'Pilihan tidak valid.';
            }

            if (!$isEmpty && $question['type'] === 'checkbox') {
                $invalid = array_diff($value, $options);
                if (!empty($invalid)) {
                    $errors[$field] = 'Pilihan tidak valid.';
                }
            }

            if (!$isEmpty && !isset($errors[$field])) {
                $answers[] = [
                    'question' => $question,
                    'value' => $value,
                ];
            }
        }

        if (!empty($errors)) {
            return redirect()->to('/survey/' . $id)->withInput()->with('survey_errors', $errors);
        }

        $ipAddress = $this->request->getIPAddress();

        foreach ($answers as $answer) {
            $value = $answer['value'];
            $formattedValue = is_array($value) ? json_encode(array_values($value), JSON_UNESCAPED_UNICODE) : (string) $value;

            $this->surveyResponseModel->insert([
                'survey_id' => $id,
                'question_id' => $answer['question']['id'],
                'respondent_name' => (int) $survey['is_anonymous'] ? null : ($name ?: null),
                'respondent_email' => $email ?: null,
                'answer' => $formattedValue,
                'ip_address' => $ipAddress,
            ]);
        }

        return redirect()->to('/survey/' . $id)->with('survey_success', 'Terima kasih, tanggapan Anda telah tersimpan.');
    }

    public function feedback(): string
    {
        $recentFeedback = $this->feedbackModel
            ->where('status', 'responded')
            ->orderBy('responded_at', 'DESC')
            ->limit(5)
            ->findAll();

        return view('frontend/feedback', [
            'title' => 'Masukan & Saran Jemaat',
            'types' => [
                'masukan' => 'Masukan',
                'saran' => 'Saran',
                'keluhan' => 'Keluhan',
                'lainnya' => 'Lainnya',
            ],
            'recentFeedback' => $recentFeedback,
            'successMessage' => session()->getFlashdata('feedback_success'),
            'errors' => session()->getFlashdata('feedback_errors') ?? [],
        ]);
    }

    public function feedbackSubmit()
    {
        $rules = [
            'name' => 'required|min_length[3]|max_length[255]',
            'email' => 'permit_empty|valid_email',
            'phone' => 'permit_empty|min_length[8]|max_length[25]',
            'type' => 'required|in_list[masukan,saran,keluhan,lainnya]',
            'subject' => 'required|min_length[3]|max_length[255]',
            'message' => 'required|min_length[10]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->to('/feedback')->withInput()->with('feedback_errors', $this->validator->getErrors());
        }

        $this->feedbackModel->insert([
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'phone' => $this->request->getPost('phone'),
            'type' => $this->request->getPost('type'),
            'subject' => $this->request->getPost('subject'),
            'message' => $this->request->getPost('message'),
            'status' => 'new',
        ]);

        return redirect()->to('/feedback')->with('feedback_success', 'Terima kasih atas masukan Anda. Tim kami akan menindaklanjuti secepatnya.');
    }

    public function guestbook(): string
    {
        $entries = $this->guestbookModel
            ->getApproved();

        return view('frontend/guestbook', [
            'title' => 'Buku Tamu Jemaat',
            'entries' => $entries,
            'successMessage' => session()->getFlashdata('guestbook_success'),
            'errors' => session()->getFlashdata('guestbook_errors') ?? [],
        ]);
    }

    public function guestbookSubmit()
    {
        $rules = [
            'name' => 'required|min_length[3]|max_length[255]',
            'email' => 'permit_empty|valid_email',
            'phone' => 'permit_empty|min_length[8]|max_length[25]',
            'message' => 'required|min_length[10]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->to('/guestbook')->withInput()->with('guestbook_errors', $this->validator->getErrors());
        }

        $this->guestbookModel->insert([
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'phone' => $this->request->getPost('phone'),
            'address' => $this->request->getPost('address'),
            'message' => $this->request->getPost('message'),
            'is_approved' => 0,
            'ip_address' => $this->request->getIPAddress(),
        ]);

        return redirect()->to('/guestbook')->with('guestbook_success', 'Terima kasih telah mengisi buku tamu. Data Anda akan ditampilkan setelah disetujui admin.');
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

    public function finance(): string
    {
        $month = $this->request->getGet('month') ?? date('m');
        $year = $this->request->getGet('year') ?? date('Y');
        $type = $this->request->getGet('type');

        $filters = $this->sanitizeFinanceFilters($month, $year, $type);

        $transactionsModel = new KeuanganModel();

        if ($filters['type']) {
            $transactionsModel->where('type', $filters['type']);
        }

        $transactions = $transactionsModel
            ->where('MONTH(transaction_date)', $filters['month'])
            ->where('YEAR(transaction_date)', $filters['year'])
            ->orderBy('transaction_date', 'DESC')
            ->findAll();

        $summaryTotals = $this->calculateFinanceTotals($filters['month'], $filters['year']);
        $balance = $summaryTotals['penerimaan'] - $summaryTotals['pengeluaran'];

        $categoryBreakdown = $this->getFinanceCategoryBreakdown($filters['month'], $filters['year']);
        $yearlyTrend = $this->getFinanceYearlyTrend($filters['year']);

        return view('frontend/keuangan/index', [
            'title' => 'Transparansi Keuangan',
            'transactions' => $transactions,
            'filters' => $filters,
            'totals' => $summaryTotals,
            'balance' => $balance,
            'categoryBreakdown' => $categoryBreakdown,
            'yearlyTrend' => $yearlyTrend,
        ]);
    }

    public function financeDetail(int $id): string
    {
        $transaction = $this->keuanganModel->find($id);

        if (!$transaction) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return view('frontend/keuangan/detail', [
            'title' => 'Detail Transaksi',
            'transaction' => $transaction,
        ]);
    }

    public function gallery(): string
    {
        $type = $this->request->getGet('type');
        $category = $this->request->getGet('category');

        $filters = $this->sanitizeGalleryFilters($type, $category);

        $galleryQuery = $this->galleryModel->where('is_published', 1);

        if ($filters['type']) {
            $galleryQuery->where('type', $filters['type']);
        }

        if ($filters['category']) {
            $galleryQuery->where('category', $filters['category']);
        }

        $items = $galleryQuery
            ->orderBy('event_date', 'DESC')
            ->findAll();

        $categories = $this->galleryModel
            ->select('category, COUNT(*) as total')
            ->where('is_published', 1)
            ->groupBy('category')
            ->orderBy('category', 'ASC')
            ->findAll();

        return view('frontend/gallery/index', [
            'title' => 'Galeri Kegiatan Gereja',
            'items' => $items,
            'filters' => $filters,
            'categories' => $categories,
        ]);
    }

    public function galleryDetail(int $id): string
    {
        $item = $this->galleryModel
            ->where('is_published', 1)
            ->find($id);

        if (!$item) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $this->galleryModel->incrementViews($id);

        $related = $this->galleryModel
            ->where('is_published', 1)
            ->where('id !=', $id)
            ->orderBy('event_date', 'DESC')
            ->limit(6)
            ->findAll();

        return view('frontend/gallery/detail', [
            'title' => $item['title'],
            'item' => $item,
            'related' => $related,
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

    private function sanitizeFinanceFilters(string $month, string $year, ?string $type): array
    {
        $month = str_pad((string) max(1, min(12, (int) $month)), 2, '0', STR_PAD_LEFT);
        $year = (string) max(2000, min((int) $year, (int) date('Y')));

        $allowedTypes = ['penerimaan', 'pengeluaran'];
        $type = $type && in_array($type, $allowedTypes, true) ? $type : null;

        return [
            'month' => $month,
            'year' => $year,
            'type' => $type,
        ];
    }

    private function calculateFinanceTotals(string $month, string $year): array
    {
        $result = [
            'penerimaan' => 0.0,
            'pengeluaran' => 0.0,
        ];

        $rows = (new KeuanganModel())
            ->select('type, SUM(amount) as total')
            ->where('MONTH(transaction_date)', $month)
            ->where('YEAR(transaction_date)', $year)
            ->groupBy('type')
            ->findAll();

        foreach ($rows as $row) {
            $type = $row['type'];
            if (isset($result[$type])) {
                $result[$type] = (float) $row['total'];
            }
        }

        return $result;
    }

    private function getFinanceCategoryBreakdown(string $month, string $year): array
    {
        $rows = (new KeuanganModel())
            ->select('type, category, SUM(amount) as total')
            ->where('MONTH(transaction_date)', $month)
            ->where('YEAR(transaction_date)', $year)
            ->groupBy(['type', 'category'])
            ->orderBy('total', 'DESC')
            ->findAll();

        $breakdown = [
            'penerimaan' => [],
            'pengeluaran' => [],
        ];

        foreach ($rows as $row) {
            $breakdown[$row['type']][] = [
                'category' => $row['category'],
                'total' => (float) $row['total'],
            ];
        }

        return $breakdown;
    }

    private function getFinanceYearlyTrend(string $year): array
    {
        $rows = (new KeuanganModel())->getYearlyReport($year);

        $trend = [];
        for ($m = 1; $m <= 12; $m++) {
            $trend[$m] = [
                'penerimaan' => 0.0,
                'pengeluaran' => 0.0,
            ];
        }

        foreach ($rows as $row) {
            $monthIndex = (int) $row['month'];
            if (isset($trend[$monthIndex])) {
                $trend[$monthIndex][$row['type']] = (float) $row['total'];
            }
        }

        return $trend;
    }

    private function sanitizeGalleryFilters(?string $type, ?string $category): array
    {
        $allowedTypes = ['photo', 'video'];
        $type = $type && in_array($type, $allowedTypes, true) ? $type : null;

        $category = $category ? trim($category) : null;

        return [
            'type' => $type,
            'category' => $category,
        ];
    }

    private function isSurveyOpen(array $survey, int $currentResponses): bool
    {
        $today = date('Y-m-d');
        $startDate = $survey['start_date'] ?? null;
        $endDate = $survey['end_date'] ?? null;

        if ($startDate && $today < $startDate) {
            return false;
        }

        if ($endDate && $today > $endDate) {
            return false;
        }

        if ((int) ($survey['is_active'] ?? 0) !== 1) {
            return false;
        }

        $maxResponses = (int) ($survey['max_responses'] ?? 0);
        if ($maxResponses > 0 && $currentResponses >= $maxResponses) {
            return false;
        }

        return true;
    }
}
