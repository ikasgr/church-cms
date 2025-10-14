<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<!-- Header -->
<div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
    <div>
        <h2 class="text-xl font-semibold text-gray-800">Berita & Warta Jemaat</h2>
        <p class="text-sm text-gray-600 mt-1">Kelola berita, artikel, pengumuman, dan renungan</p>
    </div>
    <a href="<?= base_url('admin/berita/create') ?>" 
       class="mt-4 md:mt-0 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
        <i class="fas fa-plus mr-2"></i>Tambah Berita
    </a>
</div>

<!-- Filter Tabs -->
<div class="bg-white rounded-lg shadow-md mb-6">
    <div class="border-b border-gray-200">
        <nav class="flex -mb-px">
            <a href="<?= base_url('admin/berita') ?>" 
               class="px-6 py-3 border-b-2 <?= empty($category) ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' ?> font-medium text-sm">
                Semua
            </a>
            <a href="<?= base_url('admin/berita?category=artikel') ?>" 
               class="px-6 py-3 border-b-2 <?= ($category ?? '') == 'artikel' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' ?> font-medium text-sm">
                Artikel
            </a>
            <a href="<?= base_url('admin/berita?category=pengumuman') ?>" 
               class="px-6 py-3 border-b-2 <?= ($category ?? '') == 'pengumuman' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' ?> font-medium text-sm">
                Pengumuman
            </a>
            <a href="<?= base_url('admin/berita?category=renungan') ?>" 
               class="px-6 py-3 border-b-2 <?= ($category ?? '') == 'renungan' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' ?> font-medium text-sm">
                Renungan
            </a>
            <a href="<?= base_url('admin/berita?category=agenda') ?>" 
               class="px-6 py-3 border-b-2 <?= ($category ?? '') == 'agenda' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' ?> font-medium text-sm">
                Agenda
            </a>
        </nav>
    </div>
</div>

<!-- News Grid -->
<?php if (empty($news)): ?>
    <div class="bg-white rounded-lg shadow-md p-12 text-center">
        <i class="fas fa-newspaper text-6xl text-gray-300 mb-4"></i>
        <p class="text-gray-500">Belum ada berita</p>
        <a href="<?= base_url('admin/berita/create') ?>" class="inline-block mt-4 text-blue-600 hover:text-blue-800">
            <i class="fas fa-plus mr-2"></i>Tambah Berita Pertama
        </a>
    </div>
<?php else: ?>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php foreach ($news as $n): ?>
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                <!-- Featured Image -->
                <?php if ($n['featured_image']): ?>
                    <img src="<?= base_url('uploads/news/' . $n['featured_image']) ?>" 
                         alt="<?= $n['title'] ?>"
                         class="w-full h-48 object-cover">
                <?php else: ?>
                    <div class="w-full h-48 bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center">
                        <i class="fas fa-newspaper text-6xl text-white opacity-50"></i>
                    </div>
                <?php endif; ?>
                
                <!-- Content -->
                <div class="p-6">
                    <!-- Category Badge -->
                    <div class="mb-3">
                        <?php
                        $categoryColors = [
                            'artikel' => 'bg-blue-100 text-blue-800',
                            'pengumuman' => 'bg-yellow-100 text-yellow-800',
                            'renungan' => 'bg-purple-100 text-purple-800',
                            'agenda' => 'bg-green-100 text-green-800',
                        ];
                        $colorClass = $categoryColors[$n['category']] ?? 'bg-gray-100 text-gray-800';
                        ?>
                        <span class="px-2 py-1 text-xs font-semibold rounded-full <?= $colorClass ?>">
                            <?= ucfirst($n['category']) ?>
                        </span>
                        
                        <!-- Published Status -->
                        <?php if ($n['is_published']): ?>
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 ml-2">
                                <i class="fas fa-check-circle"></i> Published
                            </span>
                        <?php else: ?>
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800 ml-2">
                                <i class="fas fa-clock"></i> Draft
                            </span>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Title -->
                    <h3 class="text-lg font-semibold text-gray-800 mb-2 line-clamp-2">
                        <?= $n['title'] ?>
                    </h3>
                    
                    <!-- Excerpt -->
                    <?php if ($n['excerpt']): ?>
                        <p class="text-sm text-gray-600 mb-4 line-clamp-3">
                            <?= $n['excerpt'] ?>
                        </p>
                    <?php endif; ?>
                    
                    <!-- Meta -->
                    <div class="flex items-center text-xs text-gray-500 mb-4">
                        <i class="far fa-calendar mr-1"></i>
                        <?= date('d M Y', strtotime($n['created_at'])) ?>
                        <span class="mx-2">•</span>
                        <i class="far fa-eye mr-1"></i>
                        <?= $n['views'] ?> views
                    </div>
                    
                    <!-- Actions -->
                    <div class="flex gap-2">
                        <a href="<?= base_url('admin/berita/view/' . $n['id']) ?>" 
                           class="flex-1 px-3 py-2 text-center bg-blue-50 text-blue-600 rounded hover:bg-blue-100 transition text-sm">
                            <i class="fas fa-eye mr-1"></i>Lihat
                        </a>
                        <a href="<?= base_url('admin/berita/edit/' . $n['id']) ?>" 
                           class="flex-1 px-3 py-2 text-center bg-green-50 text-green-600 rounded hover:bg-green-100 transition text-sm">
                            <i class="fas fa-edit mr-1"></i>Edit
                        </a>
                        <a href="<?= base_url('admin/berita/toggle-publish/' . $n['id']) ?>" 
                           class="px-3 py-2 text-center bg-purple-50 text-purple-600 rounded hover:bg-purple-100 transition text-sm"
                           title="<?= $n['is_published'] ? 'Unpublish' : 'Publish' ?>">
                            <i class="fas fa-<?= $n['is_published'] ? 'eye-slash' : 'eye' ?>"></i>
                        </a>
                        <a href="<?= base_url('admin/berita/delete/' . $n['id']) ?>" 
                           onclick="return confirm('Yakin ingin menghapus berita ini?')"
                           class="px-3 py-2 text-center bg-red-50 text-red-600 rounded hover:bg-red-100 transition text-sm">
                            <i class="fas fa-trash"></i>
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?= $this->endSection() ?>
