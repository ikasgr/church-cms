<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Admin Panel' ?> - CMS Church FLOBAMORA</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-gray-100" x-data="{ sidebarOpen: true }">
    
    <!-- Sidebar -->
    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" 
           class="fixed inset-y-0 left-0 z-50 w-64 bg-blue-900 text-white transition-transform duration-300 ease-in-out lg:translate-x-0">
        
        <!-- Logo -->
        <div class="flex items-center justify-between h-16 px-6 bg-blue-950">
            <h1 class="text-xl font-bold">CMS FLOBAMORA</h1>
            <button @click="sidebarOpen = false" class="lg:hidden">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <!-- Navigation -->
        <nav class="px-4 py-6 space-y-2 overflow-y-auto h-[calc(100vh-4rem)]">
            
            <!-- Dashboard -->
            <a href="<?= base_url('admin') ?>" class="flex items-center px-4 py-3 rounded-lg hover:bg-blue-800 transition">
                <i class="fas fa-home w-6"></i>
                <span>Dashboard</span>
            </a>
            
            <!-- Lembaga -->
            <div x-data="{ open: false }">
                <button @click="open = !open" class="flex items-center justify-between w-full px-4 py-3 rounded-lg hover:bg-blue-800 transition">
                    <div class="flex items-center">
                        <i class="fas fa-church w-6"></i>
                        <span>Lembaga</span>
                    </div>
                    <i class="fas fa-chevron-down transition-transform" :class="open && 'rotate-180'"></i>
                </button>
                <div x-show="open" x-cloak class="ml-6 mt-2 space-y-2">
                    <a href="<?= base_url('admin/lembaga/profile') ?>" class="block px-4 py-2 rounded hover:bg-blue-800">Profil Gereja</a>
                    <a href="<?= base_url('admin/lembaga/majelis') ?>" class="block px-4 py-2 rounded hover:bg-blue-800">Data Majelis</a>
                    <a href="<?= base_url('admin/lembaga/greeting') ?>" class="block px-4 py-2 rounded hover:bg-blue-800">Sambutan</a>
                </div>
            </div>
            
            <!-- Jemaat -->
            <div x-data="{ open: false }">
                <button @click="open = !open" class="flex items-center justify-between w-full px-4 py-3 rounded-lg hover:bg-blue-800 transition">
                    <div class="flex items-center">
                        <i class="fas fa-users w-6"></i>
                        <span>Jemaat</span>
                    </div>
                    <i class="fas fa-chevron-down transition-transform" :class="open && 'rotate-180'"></i>
                </button>
                <div x-show="open" x-cloak class="ml-6 mt-2 space-y-2">
                    <a href="<?= base_url('admin/jemaat') ?>" class="block px-4 py-2 rounded hover:bg-blue-800">Data Jemaat</a>
                    <a href="<?= base_url('admin/jemaat/families') ?>" class="block px-4 py-2 rounded hover:bg-blue-800">Data Keluarga</a>
                </div>
            </div>
            
            <!-- Ibadah & Kegiatan -->
            <div x-data="{ open: false }">
                <button @click="open = !open" class="flex items-center justify-between w-full px-4 py-3 rounded-lg hover:bg-blue-800 transition">
                    <div class="flex items-center">
                        <i class="fas fa-calendar-alt w-6"></i>
                        <span>Ibadah & Kegiatan</span>
                    </div>
                    <i class="fas fa-chevron-down transition-transform" :class="open && 'rotate-180'"></i>
                </button>
                <div x-show="open" x-cloak class="ml-6 mt-2 space-y-2">
                    <a href="<?= base_url('admin/ibadah') ?>" class="block px-4 py-2 rounded hover:bg-blue-800">Jadwal Ibadah</a>
                    <a href="<?= base_url('admin/ibadah/kegiatan') ?>" class="block px-4 py-2 rounded hover:bg-blue-800">Kegiatan</a>
                </div>
            </div>
            
            <!-- Keuangan -->
            <div x-data="{ open: false }">
                <button @click="open = !open" class="flex items-center justify-between w-full px-4 py-3 rounded-lg hover:bg-blue-800 transition">
                    <div class="flex items-center">
                        <i class="fas fa-money-bill-wave w-6"></i>
                        <span>Keuangan</span>
                    </div>
                    <i class="fas fa-chevron-down transition-transform" :class="open && 'rotate-180'"></i>
                </button>
                <div x-show="open" x-cloak class="ml-6 mt-2 space-y-2">
                    <a href="<?= base_url('admin/keuangan') ?>" class="block px-4 py-2 rounded hover:bg-blue-800">Transaksi</a>
                    <a href="<?= base_url('admin/keuangan/report') ?>" class="block px-4 py-2 rounded hover:bg-blue-800">Laporan</a>
                </div>
            </div>
            
            <!-- Berita -->
            <a href="<?= base_url('admin/berita') ?>" class="flex items-center px-4 py-3 rounded-lg hover:bg-blue-800 transition">
                <i class="fas fa-newspaper w-6"></i>
                <span>Berita & Warta</span>
            </a>
            
            <!-- Galeri -->
            <a href="<?= base_url('admin/galeri') ?>" class="flex items-center px-4 py-3 rounded-lg hover:bg-blue-800 transition">
                <i class="fas fa-images w-6"></i>
                <span>Galeri</span>
            </a>
            
            <!-- Interaksi -->
            <div x-data="{ open: false }">
                <button @click="open = !open" class="flex items-center justify-between w-full px-4 py-3 rounded-lg hover:bg-blue-800 transition">
                    <div class="flex items-center">
                        <i class="fas fa-comments w-6"></i>
                        <span>Interaksi</span>
                    </div>
                    <i class="fas fa-chevron-down transition-transform" :class="open && 'rotate-180'"></i>
                </button>
                <div x-show="open" x-cloak class="ml-6 mt-2 space-y-2">
                    <a href="<?= base_url('admin/interaksi/surveys') ?>" class="block px-4 py-2 rounded hover:bg-blue-800">Survei</a>
                    <a href="<?= base_url('admin/interaksi/feedback') ?>" class="block px-4 py-2 rounded hover:bg-blue-800">Masukan & Saran</a>
                    <a href="<?= base_url('admin/interaksi/guestbook') ?>" class="block px-4 py-2 rounded hover:bg-blue-800">Buku Tamu</a>
                </div>
            </div>
            
            <!-- Pendaftaran -->
            <a href="<?= base_url('admin/pendaftaran') ?>" class="flex items-center px-4 py-3 rounded-lg hover:bg-blue-800 transition">
                <i class="fas fa-user-plus w-6"></i>
                <span>Pendaftaran</span>
            </a>
            
            <!-- Konten -->
            <div x-data="{ open: false }">
                <button @click="open = !open" class="flex items-center justify-between w-full px-4 py-3 rounded-lg hover:bg-blue-800 transition">
                    <div class="flex items-center">
                        <i class="fas fa-file-alt w-6"></i>
                        <span>Konten</span>
                    </div>
                    <i class="fas fa-chevron-down transition-transform" :class="open && 'rotate-180'"></i>
                </button>
                <div x-show="open" x-cloak class="ml-6 mt-2 space-y-2">
                    <a href="<?= base_url('admin/konten/pages') ?>" class="block px-4 py-2 rounded hover:bg-blue-800">Halaman</a>
                    <a href="<?= base_url('admin/konten/banners') ?>" class="block px-4 py-2 rounded hover:bg-blue-800">Banner</a>
                    <a href="<?= base_url('admin/konten/links') ?>" class="block px-4 py-2 rounded hover:bg-blue-800">Link Terkait</a>
                    <a href="<?= base_url('admin/konten/faq') ?>" class="block px-4 py-2 rounded hover:bg-blue-800">FAQ</a>
                </div>
            </div>
            
            <!-- Konfigurasi -->
            <div x-data="{ open: false }">
                <button @click="open = !open" class="flex items-center justify-between w-full px-4 py-3 rounded-lg hover:bg-blue-800 transition">
                    <div class="flex items-center">
                        <i class="fas fa-cog w-6"></i>
                        <span>Konfigurasi</span>
                    </div>
                    <i class="fas fa-chevron-down transition-transform" :class="open && 'rotate-180'"></i>
                </button>
                <div x-show="open" x-cloak class="ml-6 mt-2 space-y-2">
                    <a href="<?= base_url('admin/konfigurasi/settings') ?>" class="block px-4 py-2 rounded hover:bg-blue-800">Pengaturan</a>
                    <a href="<?= base_url('admin/konfigurasi/users') ?>" class="block px-4 py-2 rounded hover:bg-blue-800">User</a>
                    <a href="<?= base_url('admin/konfigurasi/menus') ?>" class="block px-4 py-2 rounded hover:bg-blue-800">Menu</a>
                    <a href="<?= base_url('admin/konfigurasi/modules') ?>" class="block px-4 py-2 rounded hover:bg-blue-800">Modul</a>
                    <a href="<?= base_url('admin/konfigurasi/theme') ?>" class="block px-4 py-2 rounded hover:bg-blue-800">Tema</a>
                </div>
            </div>
            
        </nav>
    </aside>
    
    <!-- Main Content -->
    <div class="lg:ml-64">
        
        <!-- Top Bar -->
        <header class="bg-white shadow-sm">
            <div class="flex items-center justify-between h-16 px-6">
                <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden">
                    <i class="fas fa-bars text-xl"></i>
                </button>
                
                <div class="flex-1"></div>
                
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
                        <a href="<?= base_url('admin/logout') ?>" class="block px-4 py-2 hover:bg-gray-100 text-red-600">
                            <i class="fas fa-sign-out-alt mr-2"></i> Logout
                        </a>
                    </div>
                </div>
            </div>
        </header>
        
        <!-- Page Content -->
        <main class="p-6">
            
            <!-- Flash Messages -->
            <?php if (session()->getFlashdata('success')): ?>
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                    <i class="fas fa-check-circle mr-2"></i>
                    <?= session()->getFlashdata('success') ?>
                </div>
            <?php endif; ?>
            
            <?php if (session()->getFlashdata('error')): ?>
                <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>
            
            <!-- Page Title -->
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-800"><?= $title ?? 'Dashboard' ?></h1>
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
    
</body>
</html>
