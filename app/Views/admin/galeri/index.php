<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
    <div>
        <h2 class="text-xl font-semibold text-gray-800">Galeri</h2>
        <p class="text-sm text-gray-600 mt-1">Kelola foto dan video kegiatan gereja</p>
    </div>
    <a href="<?= base_url('admin/galeri/create') ?>" 
       class="mt-4 md:mt-0 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
        <i class="fas fa-plus mr-2"></i>Tambah Galeri
    </a>
</div>

<!-- Filter Tabs -->
<div class="bg-white rounded-lg shadow-md mb-6">
    <div class="border-b border-gray-200">
        <nav class="flex -mb-px">
            <a href="<?= base_url('admin/galeri') ?>" 
               class="px-6 py-3 border-b-2 <?= empty($type) ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700' ?> font-medium text-sm">
                <i class="fas fa-th mr-2"></i>Semua
            </a>
            <a href="<?= base_url('admin/galeri?type=photo') ?>" 
               class="px-6 py-3 border-b-2 <?= ($type ?? '') == 'photo' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700' ?> font-medium text-sm">
                <i class="fas fa-image mr-2"></i>Foto
            </a>
            <a href="<?= base_url('admin/galeri?type=video') ?>" 
               class="px-6 py-3 border-b-2 <?= ($type ?? '') == 'video' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700' ?> font-medium text-sm">
                <i class="fas fa-video mr-2"></i>Video
            </a>
        </nav>
    </div>
</div>

<!-- Gallery Grid -->
<?php if (empty($gallery)): ?>
    <div class="bg-white rounded-lg shadow-md p-12 text-center">
        <i class="fas fa-images text-6xl text-gray-300 mb-4"></i>
        <p class="text-gray-500">Belum ada galeri</p>
    </div>
<?php else: ?>
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
        <?php foreach ($gallery as $g): ?>
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition group">
                <!-- Thumbnail -->
                <div class="relative aspect-square overflow-hidden">
                    <?php if ($g['type'] == 'photo'): ?>
                        <?php if ($g['file_path']): ?>
                            <img src="<?= base_url('uploads/gallery/photos/' . $g['file_path']) ?>" 
                                 alt="<?= $g['title'] ?>"
                                 class="w-full h-full object-cover group-hover:scale-110 transition duration-300">
                        <?php endif; ?>
                    <?php else: ?>
                        <?php if ($g['thumbnail']): ?>
                            <img src="<?= base_url('uploads/gallery/thumbnails/' . $g['thumbnail']) ?>" 
                                 alt="<?= $g['title'] ?>"
                                 class="w-full h-full object-cover">
                        <?php else: ?>
                            <div class="w-full h-full bg-gradient-to-br from-red-400 to-red-600 flex items-center justify-center">
                                <i class="fas fa-play-circle text-6xl text-white opacity-75"></i>
                            </div>
                        <?php endif; ?>
                        <div class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center">
                            <i class="fas fa-play-circle text-5xl text-white"></i>
                        </div>
                    <?php endif; ?>
                    
                    <!-- Type Badge -->
                    <div class="absolute top-2 right-2">
                        <?php if ($g['type'] == 'photo'): ?>
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-500 text-white">
                                <i class="fas fa-image"></i> Foto
                            </span>
                        <?php else: ?>
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-500 text-white">
                                <i class="fas fa-video"></i> Video
                            </span>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Status Badge -->
                    <div class="absolute top-2 left-2">
                        <?php if ($g['is_published']): ?>
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-500 text-white">
                                <i class="fas fa-check"></i>
                            </span>
                        <?php else: ?>
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-500 text-white">
                                <i class="fas fa-eye-slash"></i>
                            </span>
                        <?php endif; ?>
                    </div>
                </div>
                
                <!-- Info -->
                <div class="p-3">
                    <h3 class="text-sm font-semibold text-gray-800 line-clamp-1 mb-1">
                        <?= $g['title'] ?>
                    </h3>
                    <div class="flex items-center text-xs text-gray-500 mb-3">
                        <i class="far fa-calendar mr-1"></i>
                        <?= date('d M Y', strtotime($g['event_date'])) ?>
                        <span class="mx-2">•</span>
                        <i class="far fa-eye mr-1"></i>
                        <?= $g['views'] ?>
                    </div>
                    
                    <!-- Actions -->
                    <div class="flex gap-1">
                        <a href="<?= base_url('admin/galeri/view/' . $g['id']) ?>" 
                           class="flex-1 px-2 py-1 text-center bg-blue-50 text-blue-600 rounded hover:bg-blue-100 transition text-xs">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="<?= base_url('admin/galeri/edit/' . $g['id']) ?>" 
                           class="flex-1 px-2 py-1 text-center bg-green-50 text-green-600 rounded hover:bg-green-100 transition text-xs">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="<?= base_url('admin/galeri/toggle-publish/' . $g['id']) ?>" 
                           class="flex-1 px-2 py-1 text-center bg-purple-50 text-purple-600 rounded hover:bg-purple-100 transition text-xs"
                           title="<?= $g['is_published'] ? 'Unpublish' : 'Publish' ?>">
                            <i class="fas fa-<?= $g['is_published'] ? 'eye-slash' : 'eye' ?>"></i>
                        </a>
                        <a href="<?= base_url('admin/galeri/delete/' . $g['id']) ?>" 
                           onclick="return confirm('Yakin ingin menghapus?')"
                           class="flex-1 px-2 py-1 text-center bg-red-50 text-red-600 rounded hover:bg-red-100 transition text-xs">
                            <i class="fas fa-trash"></i>
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?= $this->endSection() ?>
