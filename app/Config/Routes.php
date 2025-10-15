<?php

use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Frontend Routes
$routes->get('/', 'Home::index');

$routes->get('uploads/(.*)', static function (string $path) {
    $uploadsRoot = realpath(FCPATH . 'uploads');
    $targetPath  = realpath(FCPATH . 'uploads/' . ltrim($path, '/'));

    if (!$uploadsRoot || !$targetPath || strpos($targetPath, $uploadsRoot) !== 0 || !is_file($targetPath)) {
        throw PageNotFoundException::forPageNotFound();
    }

    $mimeType = mime_content_type($targetPath) ?: 'application/octet-stream';

    return service('response')
        ->setContentType($mimeType)
        ->setBody(file_get_contents($targetPath));
});

$routes->get('/about', 'Home::about');
$routes->get('/contact', 'Home::contact');
$routes->post('/contact', 'Home::contactSubmit');

// Church Profile
$routes->get('/profile', 'Home::profile');
$routes->get('/history', 'Home::history');
$routes->get('/vision-mission', 'Home::visionMission');
$routes->get('/structure', 'Home::structure');
$routes->get('/majelis', 'Home::majelis');
$routes->get('/greeting', 'Home::greeting');

// News & Articles
$routes->get('/news', 'Home::news');
$routes->get('/news/(:segment)', 'Home::newsDetail/$1');
$routes->get('/news/category/(:segment)', 'Home::newsByCategory/$1');

// Events & Activities
$routes->get('/events', 'Home::events');
$routes->get('/events/(:segment)', 'Home::eventDetail/$1');
$routes->get('/ibadah', 'Home::ibadah');

// Gallery
$routes->get('/gallery', 'Home::gallery');
$routes->get('/gallery/photos', 'Home::galleryPhotos');
$routes->get('/gallery/videos', 'Home::galleryVideos');

// UMKM Marketplace
$routes->get('/umkm', 'Home::umkm');
$routes->get('/umkm/kategori/(:segment)', 'Home::umkmCategory/$1');
$routes->get('/umkm/produk/(:segment)', 'Home::umkmProduct/$1');
$routes->get('/umkm/pelapak/(:num)', 'Home::umkmSeller/$1');

// Registration
$routes->get('/registration', 'Home::registration');
$routes->post('/registration/submit', 'Home::registrationSubmit');

// Interaction
$routes->get('/feedback', 'Home::feedback');
$routes->post('/feedback/submit', 'Home::feedbackSubmit');
$routes->get('/guestbook', 'Home::guestbook');
$routes->post('/guestbook/submit', 'Home::guestbookSubmit');
$routes->get('/survey/(:num)', 'Home::survey/$1');
$routes->post('/survey/(:num)/submit', 'Home::surveySubmit/$1');

// Static Pages
$routes->get('/page/(:segment)', 'Home::page/$1');
$routes->get('/faq', 'Home::faq');

// Admin Routes
$routes->group('admin', function($routes) {
    // Auth
    $routes->get('login', 'Admin::login');
    $routes->post('login', 'Admin::login');
    $routes->get('logout', 'Admin::logout');
    
    // Dashboard
    $routes->get('/', 'Admin::index');
    $routes->get('profile', 'Admin::profile');
    $routes->post('profile', 'Admin::profile');
    
    // Lembaga Module
    $routes->group('lembaga', function($routes) {
        $routes->get('profile', 'AdminLembaga::profile');
        $routes->post('profile', 'AdminLembaga::profile');
        
        $routes->get('majelis', 'AdminLembaga::majelis');
        $routes->get('majelis/create', 'AdminLembaga::majelisCreate');
        $routes->post('majelis/create', 'AdminLembaga::majelisCreate');
        $routes->get('majelis/edit/(:num)', 'AdminLembaga::majelisEdit/$1');
        $routes->post('majelis/edit/(:num)', 'AdminLembaga::majelisEdit/$1');
        $routes->get('majelis/delete/(:num)', 'AdminLembaga::majelisDelete/$1');
        
        $routes->get('greeting', 'AdminLembaga::greeting');
        $routes->get('greeting/create', 'AdminLembaga::greetingCreate');
        $routes->post('greeting/create', 'AdminLembaga::greetingCreate');
        $routes->get('greeting/edit/(:num)', 'AdminLembaga::greetingEdit/$1');
        $routes->post('greeting/edit/(:num)', 'AdminLembaga::greetingEdit/$1');
        $routes->get('greeting/delete/(:num)', 'AdminLembaga::greetingDelete/$1');
        $routes->get('greeting/toggle/(:num)', 'AdminLembaga::greetingToggle/$1');
    });
    
    // Jemaat Module
    $routes->group('jemaat', function($routes) {
        $routes->get('/', 'AdminJemaat::index');
        $routes->get('create', 'AdminJemaat::create');
        $routes->post('create', 'AdminJemaat::create');
        $routes->get('edit/(:num)', 'AdminJemaat::edit/$1');
        $routes->post('edit/(:num)', 'AdminJemaat::edit/$1');
        $routes->get('view/(:num)', 'AdminJemaat::view/$1');
        $routes->get('delete/(:num)', 'AdminJemaat::delete/$1');
        $routes->get('export', 'AdminJemaat::export');
        
        $routes->get('families', 'AdminJemaat::families');
        $routes->get('families/create', 'AdminJemaat::familyCreate');
        $routes->post('families/create', 'AdminJemaat::familyCreate');
        $routes->get('families/edit/(:num)', 'AdminJemaat::familyEdit/$1');
        $routes->post('families/edit/(:num)', 'AdminJemaat::familyEdit/$1');
        $routes->get('families/view/(:num)', 'AdminJemaat::familyView/$1');
        $routes->get('families/delete/(:num)', 'AdminJemaat::familyDelete/$1');
    });
    
    // Ibadah & Kegiatan Module
    $routes->group('ibadah', function($routes) {
        $routes->get('/', 'AdminIbadah::index');
        $routes->get('create', 'AdminIbadah::create');
        $routes->post('create', 'AdminIbadah::create');
        $routes->get('edit/(:num)', 'AdminIbadah::edit/$1');
        $routes->post('edit/(:num)', 'AdminIbadah::edit/$1');
        $routes->get('delete/(:num)', 'AdminIbadah::delete/$1');
        
        $routes->get('kegiatan', 'AdminIbadah::kegiatan');
        $routes->get('kegiatan/create', 'AdminIbadah::kegiatanCreate');
        $routes->post('kegiatan/create', 'AdminIbadah::kegiatanCreate');
        $routes->get('kegiatan/edit/(:num)', 'AdminIbadah::kegiatanEdit/$1');
        $routes->post('kegiatan/edit/(:num)', 'AdminIbadah::kegiatanEdit/$1');
        $routes->get('kegiatan/view/(:num)', 'AdminIbadah::kegiatanView/$1');
        $routes->get('kegiatan/delete/(:num)', 'AdminIbadah::kegiatanDelete/$1');
        $routes->get('kegiatan/registrations/(:num)', 'AdminIbadah::registrations/$1');
        $routes->get('kegiatan/registration/approve/(:num)', 'AdminIbadah::registrationApprove/$1');
        $routes->get('kegiatan/registration/reject/(:num)', 'AdminIbadah::registrationReject/$1');
    });
    
    // Keuangan Module
    $routes->group('keuangan', function($routes) {
        $routes->get('/', 'AdminKeuangan::index');
        $routes->get('create', 'AdminKeuangan::create');
        $routes->post('create', 'AdminKeuangan::create');
        $routes->get('edit/(:num)', 'AdminKeuangan::edit/$1');
        $routes->post('edit/(:num)', 'AdminKeuangan::edit/$1');
        $routes->get('view/(:num)', 'AdminKeuangan::view/$1');
        $routes->get('delete/(:num)', 'AdminKeuangan::delete/$1');
        $routes->get('report', 'AdminKeuangan::report');
        $routes->get('export', 'AdminKeuangan::export');
    });
    
    // Berita Module
    $routes->group('berita', function($routes) {
        $routes->get('/', 'AdminBerita::index');
        $routes->get('create', 'AdminBerita::create');
        $routes->post('create', 'AdminBerita::create');
        $routes->get('edit/(:num)', 'AdminBerita::edit/$1');
        $routes->post('edit/(:num)', 'AdminBerita::edit/$1');
        $routes->get('view/(:num)', 'AdminBerita::view/$1');
        $routes->get('delete/(:num)', 'AdminBerita::delete/$1');
        $routes->get('toggle-publish/(:num)', 'AdminBerita::togglePublish/$1');
    });
    
    // Galeri Module
    $routes->group('galeri', function($routes) {
        $routes->get('/', 'AdminGaleri::index');
        $routes->get('create', 'AdminGaleri::create');
        $routes->post('create', 'AdminGaleri::create');
        $routes->get('edit/(:num)', 'AdminGaleri::edit/$1');
        $routes->post('edit/(:num)', 'AdminGaleri::edit/$1');
        $routes->get('view/(:num)', 'AdminGaleri::view/$1');
        $routes->get('delete/(:num)', 'AdminGaleri::delete/$1');
        $routes->get('toggle-publish/(:num)', 'AdminGaleri::togglePublish/$1');
    });
    
    // Interaksi Module
    $routes->group('interaksi', function($routes) {
        $routes->get('surveys', 'AdminInteraksi::surveys');
        $routes->get('surveys/create', 'AdminInteraksi::surveyCreate');
        $routes->post('surveys/create', 'AdminInteraksi::surveyCreate');
        $routes->get('surveys/edit/(:num)', 'AdminInteraksi::surveyEdit/$1');
        $routes->post('surveys/edit/(:num)', 'AdminInteraksi::surveyEdit/$1');
        $routes->get('surveys/questions/(:num)', 'AdminInteraksi::surveyQuestions/$1');
        $routes->get('surveys/results/(:num)', 'AdminInteraksi::surveyResults/$1');
        $routes->get('surveys/delete/(:num)', 'AdminInteraksi::surveyDelete/$1');
        
        $routes->get('feedback', 'AdminInteraksi::feedback');
        $routes->get('feedback/view/(:num)', 'AdminInteraksi::feedbackView/$1');
        $routes->post('feedback/respond/(:num)', 'AdminInteraksi::feedbackRespond/$1');
        $routes->get('feedback/delete/(:num)', 'AdminInteraksi::feedbackDelete/$1');
        
        $routes->get('guestbook', 'AdminInteraksi::guestbook');
        $routes->get('guestbook/view/(:num)', 'AdminInteraksi::guestbookView/$1');
        $routes->get('guestbook/approve/(:num)', 'AdminInteraksi::guestbookApprove/$1');
        $routes->get('guestbook/delete/(:num)', 'AdminInteraksi::guestbookDelete/$1');
    });
    
    // Pendaftaran Module
    $routes->group('pendaftaran', function($routes) {
        $routes->get('/', 'AdminPendaftaran::index');
        
        // Baptis
        $routes->get('baptis/create', 'AdminPendaftaran::baptisCreate');
        $routes->post('baptis/create', 'AdminPendaftaran::baptisCreate');
        
        // Sidi
        $routes->get('sidi/create', 'AdminPendaftaran::sidiCreate');
        $routes->post('sidi/create', 'AdminPendaftaran::sidiCreate');
        
        // Nikah
        $routes->get('nikah/create', 'AdminPendaftaran::nikahCreate');
        $routes->post('nikah/create', 'AdminPendaftaran::nikahCreate');
        
        // General
        $routes->get('view/(:num)', 'AdminPendaftaran::view/$1');
        $routes->get('approve/(:num)', 'AdminPendaftaran::approve/$1');
        $routes->post('approve/(:num)', 'AdminPendaftaran::approve/$1');
        $routes->get('reject/(:num)', 'AdminPendaftaran::reject/$1');
        $routes->post('reject/(:num)', 'AdminPendaftaran::reject/$1');
        $routes->get('delete/(:num)', 'AdminPendaftaran::delete/$1');
        $routes->get('export', 'AdminPendaftaran::export');
    });
    
    // Konten Module
    $routes->group('konten', function($routes) {
        $routes->get('pages', 'AdminKonten::pages');
        $routes->get('pages/create', 'AdminKonten::pageCreate');
        $routes->post('pages/create', 'AdminKonten::pageCreate');
        $routes->get('pages/edit/(:num)', 'AdminKonten::pageEdit/$1');
        $routes->post('pages/edit/(:num)', 'AdminKonten::pageEdit/$1');
        $routes->get('pages/delete/(:num)', 'AdminKonten::pageDelete/$1');
        
        $routes->get('banners', 'AdminKonten::banners');
        $routes->get('banners/create', 'AdminKonten::bannerCreate');
        $routes->post('banners/create', 'AdminKonten::bannerCreate');
        $routes->get('banners/edit/(:num)', 'AdminKonten::bannerEdit/$1');
        $routes->post('banners/edit/(:num)', 'AdminKonten::bannerEdit/$1');
        $routes->get('banners/delete/(:num)', 'AdminKonten::bannerDelete/$1');
        
        $routes->get('links', 'AdminKonten::links');
        $routes->get('links/create', 'AdminKonten::linkCreate');
        $routes->post('links/create', 'AdminKonten::linkCreate');
        $routes->get('links/edit/(:num)', 'AdminKonten::linkEdit/$1');
        $routes->post('links/edit/(:num)', 'AdminKonten::linkEdit/$1');
        $routes->get('links/delete/(:num)', 'AdminKonten::linkDelete/$1');
        
        $routes->get('faq', 'AdminKonten::faq');
        $routes->get('faq/create', 'AdminKonten::faqCreate');
        $routes->post('faq/create', 'AdminKonten::faqCreate');
        $routes->get('faq/edit/(:num)', 'AdminKonten::faqEdit/$1');
        $routes->post('faq/edit/(:num)', 'AdminKonten::faqEdit/$1');
        $routes->get('faq/delete/(:num)', 'AdminKonten::faqDelete/$1');
    });
    
    // Konfigurasi Module
    $routes->group('konfigurasi', function($routes) {
        $routes->get('settings', 'AdminKonfigurasi::settings');
        $routes->post('settings', 'AdminKonfigurasi::settings');
        
        $routes->get('users', 'AdminKonfigurasi::users');
        $routes->get('users/create', 'AdminKonfigurasi::userCreate');
        $routes->post('users/create', 'AdminKonfigurasi::userCreate');
        $routes->get('users/edit/(:num)', 'AdminKonfigurasi::userEdit/$1');
        $routes->post('users/edit/(:num)', 'AdminKonfigurasi::userEdit/$1');
        $routes->get('users/delete/(:num)', 'AdminKonfigurasi::userDelete/$1');
        $routes->get('users/toggle-active/(:num)', 'AdminKonfigurasi::userToggleActive/$1');
        
        $routes->get('menus', 'AdminKonfigurasi::menus');
        $routes->get('menus/create', 'AdminKonfigurasi::menuCreate');
        $routes->post('menus/create', 'AdminKonfigurasi::menuCreate');
        $routes->get('menus/edit/(:num)', 'AdminKonfigurasi::menuEdit/$1');
        $routes->post('menus/edit/(:num)', 'AdminKonfigurasi::menuEdit/$1');
        $routes->get('menus/delete/(:num)', 'AdminKonfigurasi::menuDelete/$1');
        
        $routes->get('modules', 'AdminKonfigurasi::modules');
        $routes->get('theme', 'AdminKonfigurasi::theme');
        $routes->post('theme', 'AdminKonfigurasi::theme');
    });
    
    // UMKM Module
    $routes->group('umkm', function($routes) {
        $routes->get('/', 'AdminUmkm::index');
        
        // Sellers
        $routes->get('sellers', 'AdminUmkm::sellers');
        $routes->get('sellers/create', 'AdminUmkm::sellerCreate');
        $routes->post('sellers/create', 'AdminUmkm::sellerCreate');
        $routes->get('sellers/view/(:num)', 'AdminUmkm::sellerView/$1');
        $routes->get('sellers/edit/(:num)', 'AdminUmkm::sellerEdit/$1');
        $routes->post('sellers/edit/(:num)', 'AdminUmkm::sellerEdit/$1');
        $routes->get('sellers/delete/(:num)', 'AdminUmkm::sellerDelete/$1');
        $routes->get('sellers/approve/(:num)', 'AdminUmkm::sellerApprove/$1');
        $routes->get('sellers/suspend/(:num)', 'AdminUmkm::sellerSuspend/$1');
        
        // Products
        $routes->get('products', 'AdminUmkm::products');
        $routes->get('products/create', 'AdminUmkm::productCreate');
        $routes->post('products/create', 'AdminUmkm::productCreate');
        $routes->get('products/edit/(:num)', 'AdminUmkm::productEdit/$1');
        $routes->post('products/edit/(:num)', 'AdminUmkm::productEdit/$1');
        $routes->get('products/delete/(:num)', 'AdminUmkm::productDelete/$1');
        $routes->get('products/toggle/(:num)', 'AdminUmkm::productToggle/$1');
        
        // Orders
        $routes->get('orders', 'AdminUmkm::orders');
        $routes->get('orders/view/(:num)', 'AdminUmkm::orderView/$1');
        $routes->post('orders/update-status/(:num)', 'AdminUmkm::orderUpdateStatus/$1');
        
        // Categories
        $routes->get('categories', 'AdminUmkm::categories');
        $routes->get('categories/create', 'AdminUmkm::categoryCreate');
        $routes->post('categories/create', 'AdminUmkm::categoryCreate');
        $routes->get('categories/edit/(:num)', 'AdminUmkm::categoryEdit/$1');
        $routes->post('categories/edit/(:num)', 'AdminUmkm::categoryEdit/$1');
        $routes->get('categories/delete/(:num)', 'AdminUmkm::categoryDelete/$1');
        
        // Reports
        $routes->get('reports', 'AdminUmkm::reports');
    });
});
