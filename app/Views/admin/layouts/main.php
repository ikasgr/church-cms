<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
    $siteLogo = app_setting_asset('site_logo', 'assets/images/resources/logo-1.png');
    $siteIcon = app_setting_asset('site_icon', 'assets/images/favicons/favicon-32x32.png');
    ?>
    <title><?= $title ?? 'Admin Panel' ?> - CMS Church FLOBAMORA</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="<?= base_url('assets/plugins/sweetalert2/sweetalert2.min.css') ?>">
    
    <link rel="icon" type="image/png" href="<?= $siteIcon ?>">
    <link rel="apple-touch-icon" href="<?= $siteIcon ?>">
    <style>
        [x-cloak] { display: none !important; }
    </style>
    <script src="<?= base_url('assets/plugins/sweetalert2/sweetalert2.all.min.js') ?>"></script>
<?php
$uri = service('uri');
$segments = $uri->getSegments();
$segment1 = $segments[0] ?? '';
$segment2 = $segments[1] ?? '';
$segment3 = $segments[2] ?? '';
$segment4 = $segments[3] ?? '';
$currentPath = trim($uri->getPath(), '/');
$startsWith = static function (?string $haystack, string $needle): bool {
    $haystack = $haystack ?? '';
    if ($needle === '') {
        return true;
    }
    return strncmp($haystack, $needle, strlen($needle)) === 0;
};

$dashboardActive = ($currentPath === 'admin' || $currentPath === 'admin/index');

$lembagaActive = $startsWith($currentPath, 'admin/lembaga');
$lembagaProfileActive = $startsWith($currentPath, 'admin/lembaga/profile');
$lembagaMajelisActive = $startsWith($currentPath, 'admin/lembaga/majelis');
$lembagaGreetingActive = $startsWith($currentPath, 'admin/lembaga/greeting');

$jemaatActive = $startsWith($currentPath, 'admin/jemaat');
$jemaatFamiliesActive = $startsWith($currentPath, 'admin/jemaat/families');
$jemaatDataActive = $jemaatActive && !$jemaatFamiliesActive;

$ibadahActive = $startsWith($currentPath, 'admin/ibadah');
$ibadahKegiatanActive = $startsWith($currentPath, 'admin/ibadah/kegiatan');
$ibadahScheduleActive = $ibadahActive && !$ibadahKegiatanActive;

$keuanganActive = $startsWith($currentPath, 'admin/keuangan');
$keuanganReportActive = $startsWith($currentPath, 'admin/keuangan/report');
$keuanganTransActive = $keuanganActive && !$keuanganReportActive;

$beritaActive = $startsWith($currentPath, 'admin/berita');
$galeriActive = $startsWith($currentPath, 'admin/galeri');

$umkmActive = $startsWith($currentPath, 'admin/umkm');
$umkmDashboardActive = $currentPath === 'admin/umkm' || $currentPath === 'admin/umkm/index';
$umkmCategoriesActive = $startsWith($currentPath, 'admin/umkm/categories');
$umkmProductsActive = $startsWith($currentPath, 'admin/umkm/products');
$umkmSellersActive = $startsWith($currentPath, 'admin/umkm/sellers');
$umkmOrdersActive = $startsWith($currentPath, 'admin/umkm/orders');
$umkmReportsActive = $startsWith($currentPath, 'admin/umkm/reports');

$interaksiActive = $startsWith($currentPath, 'admin/interaksi');
$interaksiSurveysActive = $startsWith($currentPath, 'admin/interaksi/surveys');
$interaksiFeedbackActive = $startsWith($currentPath, 'admin/interaksi/feedback');
$interaksiGuestbookActive = $startsWith($currentPath, 'admin/interaksi/guestbook');

$pendaftaranActive = $startsWith($currentPath, 'admin/pendaftaran');

$kontenActive = $startsWith($currentPath, 'admin/konten');
$kontenPagesActive = $startsWith($currentPath, 'admin/konten/pages');
$kontenBannersActive = $startsWith($currentPath, 'admin/konten/banners');
$kontenLinksActive = $startsWith($currentPath, 'admin/konten/links');
$kontenFaqActive = $startsWith($currentPath, 'admin/konten/faq');

$konfigurasiActive = $startsWith($currentPath, 'admin/konfigurasi');
$konfigurasiSettingsActive = $startsWith($currentPath, 'admin/konfigurasi/settings');
$konfigurasiUsersActive = $startsWith($currentPath, 'admin/konfigurasi/users');
$konfigurasiMenusActive = $startsWith($currentPath, 'admin/konfigurasi/menus');
$konfigurasiModulesActive = $startsWith($currentPath, 'admin/konfigurasi/modules');
$konfigurasiThemeActive = $startsWith($currentPath, 'admin/konfigurasi/theme');
?>
</head>
<body class="bg-gray-100" x-data="{ sidebarOpen: true }">
    
    <!-- Sidebar -->
    <aside :class="sidebarOpen ? 'translate-x-0 lg:translate-x-0' : '-translate-x-full lg:-translate-x-full'" 
           class="fixed inset-y-0 left-0 z-50 w-64 bg-blue-900 text-white transition-transform duration-300 ease-in-out">
        
        <!-- Logo -->
        <div class="flex items-center justify-between h-16 px-6 bg-blue-950">
            <a href="<?= base_url('admin') ?>" class="flex items-center gap-3">
                <img src="<?= $siteLogo ?>" alt="Site Logo" class="h-10 w-auto object-contain bg-white/10 p-1 rounded-lg">
                <span class="text-xl font-bold hidden sm:block">CMS FLOBAMORA</span>
            </a>
            <button @click="sidebarOpen = false" class="lg:hidden">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <!-- Navigation -->
        <nav class="px-4 py-6 space-y-2 overflow-y-auto h-[calc(100vh-4rem)]">
            
            <!-- Dashboard -->
            <a href="<?= base_url('admin') ?>" class="flex items-center px-4 py-3 rounded-lg hover:bg-blue-800 transition <?= $dashboardActive ? 'bg-blue-800 text-white' : '' ?>">
                <i class="fas fa-home w-6"></i>
                <span>Dashboard</span>
            </a>
            
            <!-- Lembaga -->
            <div x-data="{ open: <?= $lembagaActive ? 'true' : 'false' ?> }">
                <button @click="open = !open" class="flex items-center justify-between w-full px-4 py-3 rounded-lg hover:bg-blue-800 transition">
                    <div class="flex items-center">
                        <i class="fas fa-church w-6"></i>
                        <span>Lembaga</span>
                    </div>
                    <i class="fas fa-chevron-down transition-transform" :class="open && 'rotate-180'"></i>
                </button>
                <div x-show="open" x-cloak class="ml-6 mt-2 space-y-2">
                    <a href="<?= base_url('admin/lembaga/profile') ?>" class="block px-4 py-2 rounded hover:bg-blue-800 <?= $lembagaProfileActive ? 'bg-blue-800 text-white' : '' ?>">Profil Gereja</a>
                    <a href="<?= base_url('admin/lembaga/majelis') ?>" class="block px-4 py-2 rounded hover:bg-blue-800 <?= $lembagaMajelisActive ? 'bg-blue-800 text-white' : '' ?>">Data Majelis</a>
                    <a href="<?= base_url('admin/lembaga/greeting') ?>" class="block px-4 py-2 rounded hover:bg-blue-800 <?= $lembagaGreetingActive ? 'bg-blue-800 text-white' : '' ?>">Sambutan</a>
                </div>
            </div>
            
            <!-- Jemaat -->
            <div x-data="{ open: <?= $jemaatActive ? 'true' : 'false' ?> }">
                <button @click="open = !open" class="flex items-center justify-between w-full px-4 py-3 rounded-lg hover:bg-blue-800 transition">
                    <div class="flex items-center">
                        <i class="fas fa-users w-6"></i>
                        <span>Jemaat</span>
                    </div>
                    <i class="fas fa-chevron-down transition-transform" :class="open && 'rotate-180'"></i>
                </button>
                <div x-show="open" x-cloak class="ml-6 mt-2 space-y-2">
                    <a href="<?= base_url('admin/jemaat') ?>" class="block px-4 py-2 rounded hover:bg-blue-800 <?= $jemaatDataActive ? 'bg-blue-800 text-white' : '' ?>">Data Jemaat</a>
                    <a href="<?= base_url('admin/jemaat/families') ?>" class="block px-4 py-2 rounded hover:bg-blue-800 <?= $jemaatFamiliesActive ? 'bg-blue-800 text-white' : '' ?>">Data Keluarga</a>
                </div>
            </div>
            
            <!-- Ibadah & Kegiatan -->
            <div x-data="{ open: <?= $ibadahActive ? 'true' : 'false' ?> }">
                <button @click="open = !open" class="flex items-center justify-between w-full px-4 py-3 rounded-lg hover:bg-blue-800 transition">
                    <div class="flex items-center">
                        <i class="fas fa-calendar-alt w-6"></i>
                        <span>Ibadah & Kegiatan</span>
                    </div>
                    <i class="fas fa-chevron-down transition-transform" :class="open && 'rotate-180'"></i>
                </button>
                <div x-show="open" x-cloak class="ml-6 mt-2 space-y-2">
                    <a href="<?= base_url('admin/ibadah') ?>" class="block px-4 py-2 rounded hover:bg-blue-800 <?= $ibadahScheduleActive ? 'bg-blue-800 text-white' : '' ?>">Jadwal Ibadah</a>
                    <a href="<?= base_url('admin/ibadah/kegiatan') ?>" class="block px-4 py-2 rounded hover:bg-blue-800 <?= $ibadahKegiatanActive ? 'bg-blue-800 text-white' : '' ?>">Kegiatan</a>
                </div>
            </div>
            
            <!-- Keuangan -->
            <div x-data="{ open: <?= $keuanganActive ? 'true' : 'false' ?> }">
                <button @click="open = !open" class="flex items-center justify-between w-full px-4 py-3 rounded-lg hover:bg-blue-800 transition">
                    <div class="flex items-center">
                        <i class="fas fa-money-bill-wave w-6"></i>
                        <span>Keuangan</span>
                    </div>
                    <i class="fas fa-chevron-down transition-transform" :class="open && 'rotate-180'"></i>
                </button>
                <div x-show="open" x-cloak class="ml-6 mt-2 space-y-2">
                    <a href="<?= base_url('admin/keuangan') ?>" class="block px-4 py-2 rounded hover:bg-blue-800 <?= $keuanganTransActive ? 'bg-blue-800 text-white' : '' ?>">Transaksi</a>
                    <a href="<?= base_url('admin/keuangan/report') ?>" class="block px-4 py-2 rounded hover:bg-blue-800 <?= $keuanganReportActive ? 'bg-blue-800 text-white' : '' ?>">Laporan</a>
                </div>
            </div>
            
            <!-- Berita -->
            <a href="<?= base_url('admin/berita') ?>" class="flex items-center px-4 py-3 rounded-lg hover:bg-blue-800 transition <?= $beritaActive ? 'bg-blue-800 text-white' : '' ?>">
                <i class="fas fa-newspaper w-6"></i>
                <span>Berita & Warta</span>
            </a>
            
            <!-- Galeri -->
            <a href="<?= base_url('admin/galeri') ?>" class="flex items-center px-4 py-3 rounded-lg hover:bg-blue-800 transition <?= $galeriActive ? 'bg-blue-800 text-white' : '' ?>">
                <i class="fas fa-images w-6"></i>
                <span>Galeri</span>
            </a>

            <!-- UMKM -->
            <div x-data="{ open: <?= $umkmActive ? 'true' : 'false' ?> }">
                <button @click="open = !open" class="flex items-center justify-between w-full px-4 py-3 rounded-lg hover:bg-blue-800 transition">
                    <div class="flex items-center">
                        <i class="fas fa-store w-6"></i>
                        <span>UMKM</span>
                    </div>
                    <i class="fas fa-chevron-down transition-transform" :class="open && 'rotate-180'"></i>
                </button>
                <div x-show="open" x-cloak class="ml-6 mt-2 space-y-2">
                    <a href="<?= base_url('admin/umkm') ?>" class="block px-4 py-2 rounded hover:bg-blue-800 <?= $umkmDashboardActive ? 'bg-blue-800 text-white' : '' ?>">Dashboard</a>
                    <a href="<?= base_url('admin/umkm/categories') ?>" class="block px-4 py-2 rounded hover:bg-blue-800 <?= $umkmCategoriesActive ? 'bg-blue-800 text-white' : '' ?>">Kategori</a>
                    <a href="<?= base_url('admin/umkm/products') ?>" class="block px-4 py-2 rounded hover:bg-blue-800 <?= $umkmProductsActive ? 'bg-blue-800 text-white' : '' ?>">Produk</a>
                    <a href="<?= base_url('admin/umkm/sellers') ?>" class="block px-4 py-2 rounded hover:bg-blue-800 <?= $umkmSellersActive ? 'bg-blue-800 text-white' : '' ?>">Penjual</a>
                    <a href="<?= base_url('admin/umkm/orders') ?>" class="block px-4 py-2 rounded hover:bg-blue-800 <?= $umkmOrdersActive ? 'bg-blue-800 text-white' : '' ?>">Pesanan</a>
                    <a href="<?= base_url('admin/umkm/reports') ?>" class="block px-4 py-2 rounded hover:bg-blue-800 <?= $umkmReportsActive ? 'bg-blue-800 text-white' : '' ?>">Laporan</a>
                </div>
            </div>

            <!-- Interaksi -->
            <div x-data="{ open: <?= $interaksiActive ? 'true' : 'false' ?> }">
                <button @click="open = !open" class="flex items-center justify-between w-full px-4 py-3 rounded-lg hover:bg-blue-800 transition">
                    <div class="flex items-center">
                        <i class="fas fa-comments w-6"></i>
                        <span>Interaksi</span>
                    </div>
                    <i class="fas fa-chevron-down transition-transform" :class="open && 'rotate-180'"></i>
                </button>
                <div x-show="open" x-cloak class="ml-6 mt-2 space-y-2">
                    <a href="<?= base_url('admin/interaksi/surveys') ?>" class="block px-4 py-2 rounded hover:bg-blue-800 <?= $interaksiSurveysActive ? 'bg-blue-800 text-white' : '' ?>">Survei</a>
                    <a href="<?= base_url('admin/interaksi/feedback') ?>" class="block px-4 py-2 rounded hover:bg-blue-800 <?= $interaksiFeedbackActive ? 'bg-blue-800 text-white' : '' ?>">Masukan & Saran</a>
                    <a href="<?= base_url('admin/interaksi/guestbook') ?>" class="block px-4 py-2 rounded hover:bg-blue-800 <?= $interaksiGuestbookActive ? 'bg-blue-800 text-white' : '' ?>">Buku Tamu</a>
                </div>
            </div>
            
            <!-- Pendaftaran -->
            <a href="<?= base_url('admin/pendaftaran') ?>" class="flex items-center px-4 py-3 rounded-lg hover:bg-blue-800 transition <?= $pendaftaranActive ? 'bg-blue-800 text-white' : '' ?>">
                <i class="fas fa-user-plus w-6"></i>
                <span>Pendaftaran</span>
            </a>
            
            <!-- Konten -->
            <div x-data="{ open: <?= $kontenActive ? 'true' : 'false' ?> }">
                <button @click="open = !open" class="flex items-center justify-between w-full px-4 py-3 rounded-lg hover:bg-blue-800 transition">
                    <div class="flex items-center">
                        <i class="fas fa-file-alt w-6"></i>
                        <span>Konten</span>
                    </div>
                    <i class="fas fa-chevron-down transition-transform" :class="open && 'rotate-180'"></i>
                </button>
                <div x-show="open" x-cloak class="ml-6 mt-2 space-y-2">
                    <a href="<?= base_url('admin/konten/pages') ?>" class="block px-4 py-2 rounded hover:bg-blue-800 <?= $kontenPagesActive ? 'bg-blue-800 text-white' : '' ?>">Halaman</a>
                    <a href="<?= base_url('admin/konten/banners') ?>" class="block px-4 py-2 rounded hover:bg-blue-800 <?= $kontenBannersActive ? 'bg-blue-800 text-white' : '' ?>">Banner</a>
                    <a href="<?= base_url('admin/konten/links') ?>" class="block px-4 py-2 rounded hover:bg-blue-800 <?= $kontenLinksActive ? 'bg-blue-800 text-white' : '' ?>">Link Terkait</a>
                    <a href="<?= base_url('admin/konten/faq') ?>" class="block px-4 py-2 rounded hover:bg-blue-800 <?= $kontenFaqActive ? 'bg-blue-800 text-white' : '' ?>">FAQ</a>
                </div>
            </div>
            
            <!-- Konfigurasi -->
            <div x-data="{ open: <?= $konfigurasiActive ? 'true' : 'false' ?> }">
                <button @click="open = !open" class="flex items-center justify-between w-full px-4 py-3 rounded-lg hover:bg-blue-800 transition">
                    <div class="flex items-center">
                        <i class="fas fa-cog w-6"></i>
                        <span>Konfigurasi</span>
                    </div>
                    <i class="fas fa-chevron-down transition-transform" :class="open && 'rotate-180'"></i>
                </button>
                <div x-show="open" x-cloak class="ml-6 mt-2 space-y-2">
                    <a href="<?= base_url('admin/konfigurasi/settings') ?>" class="block px-4 py-2 rounded hover:bg-blue-800 <?= $konfigurasiSettingsActive ? 'bg-blue-800 text-white' : '' ?>">Pengaturan</a>
                    <a href="<?= base_url('admin/konfigurasi/users') ?>" class="block px-4 py-2 rounded hover:bg-blue-800 <?= $konfigurasiUsersActive ? 'bg-blue-800 text-white' : '' ?>">User</a>
                    <a href="<?= base_url('admin/konfigurasi/menus') ?>" class="block px-4 py-2 rounded hover:bg-blue-800 <?= $konfigurasiMenusActive ? 'bg-blue-800 text-white' : '' ?>">Menu</a>
                    <a href="<?= base_url('admin/konfigurasi/modules') ?>" class="block px-4 py-2 rounded hover:bg-blue-800 <?= $konfigurasiModulesActive ? 'bg-blue-800 text-white' : '' ?>">Modul</a>
                    <a href="<?= base_url('admin/konfigurasi/theme') ?>" class="block px-4 py-2 rounded hover:bg-blue-800 <?= $konfigurasiThemeActive ? 'bg-blue-800 text-white' : '' ?>">Tema</a>
                </div>
            </div>
            
        </nav>
    </aside>
    
    <!-- Main Content -->
    <div :class="sidebarOpen ? 'lg:ml-64' : 'lg:ml-0'" class="transition-[margin] duration-300 ease-in-out">
        
        <!-- Top Bar -->
        <header class="bg-white shadow-sm">
            <div class="flex items-center justify-between h-16 px-6 gap-4">
                <div class="flex items-center gap-3">
                    <button type="button" @click="sidebarOpen = !sidebarOpen" class="inline-flex items-center justify-center w-10 h-10 rounded-lg text-gray-600 hover:text-blue-600 hover:bg-blue-50 transition lg:hidden" aria-label="Toggle sidebar">
                        <i class="fas fa-bars text-lg"></i>
                    </button>
                    <button type="button" @click="sidebarOpen = !sidebarOpen" class="hidden lg:inline-flex items-center justify-center w-10 h-10 rounded-lg text-gray-600 hover:text-blue-600 hover:bg-blue-50 transition" aria-label="Toggle sidebar">
                        <i :class="sidebarOpen ? 'fas fa-chevron-left text-lg' : 'fas fa-bars text-lg'"></i>
                    </button>
                    <a href="<?= base_url('/') ?>" target="_blank" rel="noopener" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition">
                        <i class="fas fa-external-link-alt"></i>
                        <span>Kunjungi Situs</span>
                    </a>
                </div>

                <div class="flex items-center gap-3 ml-auto">
                    <!-- User Menu -->
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" class="flex items-center space-x-2">
                            <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center text-white">
                                <i class="fas fa-user"></i>
                            </div>
                            <span class="hidden md:block"><?= session()->get('fullName') ?></span>
                            <i class="fas fa-chevron-down text-sm"></i>
                        </button>
                        
                        <div x-show="open" @click.away="open = false" x-cloak
                             class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 z-50">
                            <a href="<?= base_url('admin/profile') ?>" class="block px-4 py-2 hover:bg-gray-100">
                                <i class="fas fa-user-circle mr-2"></i> Profile
                            </a>
                            <hr class="my-2">
                            <a href="<?= base_url('admin/logout') ?>" id="logout-button" class="block px-4 py-2 hover:bg-gray-100 text-red-600">
                                <i class="fas fa-sign-out-alt mr-2"></i> Logout
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        
        <!-- Page Content -->
        <main class="p-6">
            
            <?php
                $flashSuccess = session()->getFlashdata('success');
                $flashError = session()->getFlashdata('error');
                $flashWarning = session()->getFlashdata('warning');
                $flashInfo = session()->getFlashdata('info');
            ?>
            <?php if ($flashSuccess || $flashError || $flashWarning || $flashInfo): ?>
                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        <?php if ($flashSuccess): ?>
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: <?= json_encode($flashSuccess) ?>,
                            confirmButtonColor: '#2563EB'
                        });
                        <?php endif; ?>

                        <?php if ($flashError): ?>
                        Swal.fire({
                            icon: 'error',
                            title: 'Terjadi Kesalahan',
                            text: <?= json_encode($flashError) ?>,
                            confirmButtonColor: '#EF4444'
                        });
                        <?php endif; ?>

                        <?php if ($flashWarning): ?>
                        Swal.fire({
                            icon: 'warning',
                            title: 'Perhatian',
                            text: <?= json_encode($flashWarning) ?>,
                            confirmButtonColor: '#F59E0B'
                        });
                        <?php endif; ?>

                        <?php if ($flashInfo): ?>
                        Swal.fire({
                            icon: 'info',
                            title: 'Informasi',
                            text: <?= json_encode($flashInfo) ?>,
                            confirmButtonColor: '#3B82F6'
                        });
                        <?php endif; ?>
                    });
                </script>
            <?php endif; ?>
            
            <!-- Page Title -->
            <div class="mb-6">
                <div class="flex items-center justify-between gap-3 mb-4">
                    <h1 class="text-2xl font-bold text-gray-800"><?= $title ?? 'Dashboard' ?></h1>
                    <div class="flex items-center gap-2">
                        <a href="<?= base_url('admin') ?>" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                            <i class="fas fa-home"></i>
                        </a>
                        <button type="button" onclick="history.back()" class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-red-300 transition">
                            <i class="fas fa-arrow-left mr-2"></i>Kembali
                        </button>
                    </div>
                </div>
                <?php if (isset($breadcrumb)): ?>
                    <nav class="text-sm text-gray-600 mt-2">
                        <?php foreach ($breadcrumb as $item): ?>
                            <?php if (isset($item['url'])): ?>
                                <a href="<?= $item['url'] ?>" class="hover:text-blue-600"><?= $item['label'] ?></a>
                                <span class="mx-2">/</span>
                            <?php else: ?>
                                <span><?= $item['label'] ?></span>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </nav>
                <?php endif; ?>
            </div>
            
            <!-- Content -->
            <?= $this->renderSection('content') ?>
            
        </main>
        
        <!-- Footer -->
        <footer class="bg-white border-t px-6 py-4 text-center text-gray-600 text-sm">
            &copy; <?= date('Y') ?> CMS Church FLOBAMORA. All rights reserved.
        </footer>
        
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const logoutButton = document.getElementById('logout-button');
            if (logoutButton) {
                logoutButton.addEventListener('click', function (event) {
                    event.preventDefault();
                    Swal.fire({
                        title: 'Keluar dari sistem?',
                        text: 'Anda akan keluar dari sesi admin.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#2563EB',
                        cancelButtonColor: '#6B7280',
                        confirmButtonText: 'Ya, logout',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Swal.fire({
                                title: 'Logout...',
                                text: 'Mengakhiri sesi Anda.',
                                icon: 'success',
                                showConfirmButton: false,
                                timer: 1200,
                                willClose: () => {
                                    window.location.href = logoutButton.href;
                                }
                            });
                        }
                    });
                });
            }

            const legacyConfirmElements = document.querySelectorAll('[onclick*="confirm("]');
            legacyConfirmElements.forEach((element) => {
                const handler = element.getAttribute('onclick');
                if (!handler) {
                    return;
                }

                const match = handler.match(/return\s+confirm\(["'](.+?)["']\)\s*;?$/);
                if (match) {
                    if (!element.dataset.confirm) {
                        element.dataset.confirm = match[1];
                    }
                    if (!element.dataset.confirmType) {
                        element.dataset.confirmType = 'delete';
                    }
                    element.removeAttribute('onclick');
                }
            });

            const confirmElements = document.querySelectorAll('[data-confirm]');
            confirmElements.forEach((element) => {
                const attachHandler = () => {
                    const isSubmit = element.tagName === 'BUTTON' || element.tagName === 'INPUT';
                    if (element.dataset.skipConfirm === 'true') {
                        return;
                    }

                    event.preventDefault();

                    const message = element.dataset.confirm || 'Apakah Anda yakin?';
                    const type = element.dataset.confirmType || 'warning';
                    const iconMap = {
                        delete: 'warning',
                        danger: 'error',
                        info: 'info',
                        success: 'success',
                        warning: 'warning'
                    };
                    const icon = iconMap[type] || 'warning';

                    const confirmButtonColor = type === 'delete' || type === 'danger' ? '#EF4444' : '#2563EB';

                    Swal.fire({
                        title: 'Konfirmasi',
                        text: message,
                        icon: icon,
                        showCancelButton: true,
                        confirmButtonColor: confirmButtonColor,
                        cancelButtonColor: '#6B7280',
                        confirmButtonText: element.dataset.confirmButton || 'Ya, lanjutkan',
                        cancelButtonText: element.dataset.cancelButton || 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            const targetHref = element.getAttribute('href');
                            const submitFormId = element.dataset.submitForm;

                            if (submitFormId) {
                                const targetForm = document.getElementById(submitFormId);
                                if (targetForm) {
                                    targetForm.submit();
                                }
                                return;
                            }

                            if (isSubmit) {
                                const closestForm = element.closest('form');
                                if (closestForm) {
                                    closestForm.submit();
                                    return;
                                }
                            }

                            if (targetHref) {
                                window.location.href = targetHref;
                            }
                        }
                    });
                };

                element.addEventListener('click', attachHandler);
            });
        });
    </script>
</body>
</html>
