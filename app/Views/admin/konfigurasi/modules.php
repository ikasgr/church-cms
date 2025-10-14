<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Pengaturan Modul</h2>
    <p class="text-sm text-gray-600 mt-1">Aktifkan atau nonaktifkan modul aplikasi</p>
</div>

<?php if (session()->getFlashdata('success')): ?>
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
        <i class="fas fa-check-circle mr-2"></i><?= session()->getFlashdata('success') ?>
    </div>
<?php endif; ?>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <?php foreach ($modules as $key => $module): ?>
        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
            <div class="p-6">
                <div class="flex items-start justify-between mb-4">
                    <div class="flex-1">
                        <h3 class="text-lg font-bold text-gray-800 mb-2">
                            <?= $module['name'] ?>
                        </h3>
                        <p class="text-sm text-gray-600">
                            <?php
                            $descriptions = [
                                'lembaga' => 'Kelola profil gereja, majelis, dan sambutan',
                                'jemaat' => 'Manajemen data jemaat dan keluarga',
                                'ibadah' => 'Jadwal ibadah dan kegiatan gereja',
                                'keuangan' => 'Pencatatan transaksi keuangan',
                                'berita' => 'Artikel, pengumuman, dan renungan',
                                'galeri' => 'Foto dan video kegiatan',
                                'interaksi' => 'Survei, feedback, dan buku tamu',
                                'pendaftaran' => 'Pendaftaran baptis, sidi, dan nikah',
                                'konten' => 'Halaman, banner, dan link'
                            ];
                            echo $descriptions[$key] ?? 'Modul ' . $module['name'];
                            ?>
                        </p>
                    </div>
                    
                    <!-- Status Icon -->
                    <div class="ml-4">
                        <?php if ($module['enabled']): ?>
                            <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center">
                                <i class="fas fa-check text-2xl text-green-600"></i>
                            </div>
                        <?php else: ?>
                            <div class="w-12 h-12 rounded-full bg-gray-100 flex items-center justify-center">
                                <i class="fas fa-times text-2xl text-gray-400"></i>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                
                <!-- Module Icon -->
                <div class="mb-4">
                    <?php
                    $icons = [
                        'lembaga' => 'fa-church',
                        'jemaat' => 'fa-users',
                        'ibadah' => 'fa-pray',
                        'keuangan' => 'fa-money-bill-wave',
                        'berita' => 'fa-newspaper',
                        'galeri' => 'fa-images',
                        'interaksi' => 'fa-comments',
                        'pendaftaran' => 'fa-clipboard-list',
                        'konten' => 'fa-file-alt'
                    ];
                    $icon = $icons[$key] ?? 'fa-cube';
                    ?>
                    <i class="fas <?= $icon ?> text-4xl text-blue-500"></i>
                </div>
                
                <!-- Status Badge -->
                <div class="mb-4">
                    <?php if ($module['enabled']): ?>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                            <i class="fas fa-check-circle mr-1"></i>Aktif
                        </span>
                    <?php else: ?>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-600">
                            <i class="fas fa-times-circle mr-1"></i>Non-Aktif
                        </span>
                    <?php endif; ?>
                </div>
                
                <!-- Actions -->
                <div class="flex gap-2 pt-4 border-t">
                    <?php if ($module['enabled']): ?>
                        <button onclick="alert('Modul sudah aktif')" 
                                class="flex-1 px-4 py-2 bg-gray-100 text-gray-400 rounded-lg cursor-not-allowed text-sm">
                            <i class="fas fa-toggle-on mr-1"></i>Aktif
                        </button>
                    <?php else: ?>
                        <button onclick="alert('Fitur toggle modul akan segera hadir')" 
                                class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-sm">
                            <i class="fas fa-toggle-off mr-1"></i>Aktifkan
                        </button>
                    <?php endif; ?>
                    
                    <a href="<?= base_url('admin/' . $key) ?>" 
                       class="flex-1 px-4 py-2 bg-green-50 text-green-600 rounded-lg hover:bg-green-100 transition text-sm text-center">
                        <i class="fas fa-cog mr-1"></i>Kelola
                    </a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<!-- Info Box -->
<div class="mt-8 bg-blue-50 border border-blue-200 rounded-lg p-6">
    <div class="flex items-start gap-4">
        <div class="flex-shrink-0">
            <i class="fas fa-info-circle text-3xl text-blue-600"></i>
        </div>
        <div>
            <h4 class="text-lg font-semibold text-blue-900 mb-2">Informasi Modul</h4>
            <div class="text-sm text-blue-800 space-y-2">
                <p>• <strong>Modul Aktif:</strong> Semua fitur dapat digunakan dan ditampilkan di website</p>
                <p>• <strong>Modul Non-Aktif:</strong> Fitur tidak dapat diakses (akan segera hadir)</p>
                <p>• <strong>Kelola:</strong> Akses langsung ke halaman manajemen modul</p>
            </div>
        </div>
    </div>
</div>

<!-- Statistics -->
<div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-6">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600 mb-1">Total Modul</p>
                <p class="text-3xl font-bold text-gray-800"><?= count($modules) ?></p>
            </div>
            <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center">
                <i class="fas fa-cubes text-2xl text-blue-600"></i>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600 mb-1">Modul Aktif</p>
                <p class="text-3xl font-bold text-green-600">
                    <?= count(array_filter($modules, function($m) { return $m['enabled']; })) ?>
                </p>
            </div>
            <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center">
                <i class="fas fa-check-circle text-2xl text-green-600"></i>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600 mb-1">Modul Non-Aktif</p>
                <p class="text-3xl font-bold text-gray-400">
                    <?= count(array_filter($modules, function($m) { return !$m['enabled']; })) ?>
                </p>
            </div>
            <div class="w-12 h-12 rounded-full bg-gray-100 flex items-center justify-center">
                <i class="fas fa-times-circle text-2xl text-gray-400"></i>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
