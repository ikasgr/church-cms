<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<div class="mb-6">
    <div class="flex items-center gap-2 text-sm text-gray-600 mb-4">
        <a href="<?= base_url('admin/galeri') ?>" class="hover:text-blue-600">
            <i class="fas fa-images"></i> Galeri
        </a>
        <i class="fas fa-chevron-right text-xs"></i>
        <span class="text-gray-800">Detail Galeri</span>
    </div>
    <div class="flex items-center justify-between">
        <h2 class="text-2xl font-bold text-gray-800">Detail Galeri</h2>
        <div class="flex gap-2">
            <a href="<?= base_url('admin/galeri/edit/' . $gallery['id']) ?>" 
               class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                <i class="fas fa-edit mr-2"></i>Edit
            </a>
            <a href="<?= base_url('admin/galeri/delete/' . $gallery['id']) ?>" 
               onclick="return confirm('Yakin ingin menghapus galeri ini?')"
               class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                <i class="fas fa-trash mr-2"></i>Hapus
            </a>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Main Content -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <!-- Media Display -->
            <div class="relative">
                <?php if ($gallery['type'] == 'photo'): ?>
                    <?php if ($gallery['file_path']): ?>
                        <img src="<?= base_url('uploads/gallery/photos/' . $gallery['file_path']) ?>" 
                             alt="<?= $gallery['title'] ?>"
                             class="w-full h-auto">
                    <?php else: ?>
                        <div class="w-full h-96 bg-gray-200 flex items-center justify-center">
                            <i class="fas fa-image text-6xl text-gray-400"></i>
                        </div>
                    <?php endif; ?>
                <?php else: ?>
                    <!-- Video Embed -->
                    <?php if ($gallery['video_url']): ?>
                        <div class="aspect-video bg-black">
                            <?php
                            $videoUrl = $gallery['video_url'];
                            $embedUrl = '';
                            
                            // Convert YouTube URL to embed
                            if (preg_match('/youtube\.com\/watch\?v=([^\&\?\/]+)/', $videoUrl, $id)) {
                                $embedUrl = 'https://www.youtube.com/embed/' . $id[1];
                            } elseif (preg_match('/youtu\.be\/([^\&\?\/]+)/', $videoUrl, $id)) {
                                $embedUrl = 'https://www.youtube.com/embed/' . $id[1];
                            } elseif (preg_match('/vimeo\.com\/([0-9]+)/', $videoUrl, $id)) {
                                $embedUrl = 'https://player.vimeo.com/video/' . $id[1];
                            }
                            
                            if ($embedUrl):
                            ?>
                                <iframe src="<?= $embedUrl ?>" 
                                        class="w-full h-full" 
                                        frameborder="0" 
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                        allowfullscreen>
                                </iframe>
                            <?php else: ?>
                                <div class="w-full h-full flex items-center justify-center text-white">
                                    <div class="text-center">
                                        <i class="fas fa-video text-6xl mb-4"></i>
                                        <p>Video tidak dapat ditampilkan</p>
                                        <a href="<?= $videoUrl ?>" target="_blank" class="text-blue-400 hover:underline">
                                            Buka di tab baru
                                        </a>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php else: ?>
                        <div class="w-full h-96 bg-gray-200 flex items-center justify-center">
                            <i class="fas fa-video text-6xl text-gray-400"></i>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
                
                <!-- Type Badge -->
                <div class="absolute top-4 right-4">
                    <?php if ($gallery['type'] == 'photo'): ?>
                        <span class="px-3 py-1 text-sm font-semibold rounded-full bg-blue-500 text-white shadow-lg">
                            <i class="fas fa-image"></i> Foto
                        </span>
                    <?php else: ?>
                        <span class="px-3 py-1 text-sm font-semibold rounded-full bg-red-500 text-white shadow-lg">
                            <i class="fas fa-video"></i> Video
                        </span>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Content -->
            <div class="p-6">
                <h1 class="text-2xl font-bold text-gray-800 mb-4"><?= $gallery['title'] ?></h1>
                
                <?php if ($gallery['description']): ?>
                    <div class="prose max-w-none mb-6">
                        <p class="text-gray-600"><?= nl2br(esc($gallery['description'])) ?></p>
                    </div>
                <?php endif; ?>
                
                <!-- Stats -->
                <div class="flex items-center gap-6 text-sm text-gray-600 pt-4 border-t">
                    <div class="flex items-center gap-2">
                        <i class="far fa-calendar text-blue-600"></i>
                        <span><?= date('d F Y', strtotime($gallery['event_date'])) ?></span>
                    </div>
                    <div class="flex items-center gap-2">
                        <i class="far fa-eye text-green-600"></i>
                        <span><?= number_format($gallery['views']) ?> views</span>
                    </div>
                    <?php if ($gallery['category']): ?>
                        <div class="flex items-center gap-2">
                            <i class="fas fa-tag text-purple-600"></i>
                            <span><?= $gallery['category'] ?></span>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Sidebar -->
    <div class="lg:col-span-1">
        <!-- Status Card -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">
                <i class="fas fa-info-circle text-blue-600 mr-2"></i>Informasi
            </h3>
            
            <div class="space-y-4">
                <!-- Status -->
                <div>
                    <label class="text-sm text-gray-600 block mb-1">Status</label>
                    <?php if ($gallery['is_published']): ?>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                            <i class="fas fa-check-circle mr-1"></i> Dipublikasikan
                        </span>
                    <?php else: ?>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                            <i class="fas fa-eye-slash mr-1"></i> Draft
                        </span>
                    <?php endif; ?>
                </div>
                
                <!-- Type -->
                <div>
                    <label class="text-sm text-gray-600 block mb-1">Tipe</label>
                    <div class="text-gray-800 font-medium">
                        <?php if ($gallery['type'] == 'photo'): ?>
                            <i class="fas fa-image text-blue-600 mr-1"></i> Foto
                        <?php else: ?>
                            <i class="fas fa-video text-red-600 mr-1"></i> Video
                        <?php endif; ?>
                    </div>
                </div>
                
                <!-- Category -->
                <?php if ($gallery['category']): ?>
                    <div>
                        <label class="text-sm text-gray-600 block mb-1">Kategori</label>
                        <div class="text-gray-800 font-medium">
                            <i class="fas fa-tag text-purple-600 mr-1"></i>
                            <?= $gallery['category'] ?>
                        </div>
                    </div>
                <?php endif; ?>
                
                <!-- Event Date -->
                <div>
                    <label class="text-sm text-gray-600 block mb-1">Tanggal Kegiatan</label>
                    <div class="text-gray-800 font-medium">
                        <i class="far fa-calendar text-blue-600 mr-1"></i>
                        <?= date('d F Y', strtotime($gallery['event_date'])) ?>
                    </div>
                </div>
                
                <!-- Views -->
                <div>
                    <label class="text-sm text-gray-600 block mb-1">Total Views</label>
                    <div class="text-gray-800 font-medium">
                        <i class="far fa-eye text-green-600 mr-1"></i>
                        <?= number_format($gallery['views']) ?>
                    </div>
                </div>
                
                <!-- Order Position -->
                <div>
                    <label class="text-sm text-gray-600 block mb-1">Urutan Tampil</label>
                    <div class="text-gray-800 font-medium">
                        <i class="fas fa-sort-numeric-down text-gray-600 mr-1"></i>
                        <?= $gallery['order_position'] ?>
                    </div>
                </div>
                
                <!-- Created At -->
                <div>
                    <label class="text-sm text-gray-600 block mb-1">Dibuat</label>
                    <div class="text-gray-800 text-sm">
                        <?= date('d M Y H:i', strtotime($gallery['created_at'])) ?>
                    </div>
                </div>
                
                <!-- Updated At -->
                <div>
                    <label class="text-sm text-gray-600 block mb-1">Terakhir Diupdate</label>
                    <div class="text-gray-800 text-sm">
                        <?= date('d M Y H:i', strtotime($gallery['updated_at'])) ?>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Quick Actions -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">
                <i class="fas fa-bolt text-yellow-600 mr-2"></i>Aksi Cepat
            </h3>
            
            <div class="space-y-2">
                <a href="<?= base_url('admin/galeri/toggle-publish/' . $gallery['id']) ?>" 
                   class="block w-full px-4 py-2 text-center bg-purple-50 text-purple-600 rounded-lg hover:bg-purple-100 transition">
                    <i class="fas fa-<?= $gallery['is_published'] ? 'eye-slash' : 'eye' ?> mr-2"></i>
                    <?= $gallery['is_published'] ? 'Unpublish' : 'Publish' ?>
                </a>
                
                <?php if ($gallery['type'] == 'photo' && $gallery['file_path']): ?>
                    <a href="<?= base_url('uploads/gallery/photos/' . $gallery['file_path']) ?>" 
                       download
                       class="block w-full px-4 py-2 text-center bg-green-50 text-green-600 rounded-lg hover:bg-green-100 transition">
                        <i class="fas fa-download mr-2"></i>Download Foto
                    </a>
                <?php endif; ?>
                
                <?php if ($gallery['type'] == 'video' && $gallery['video_url']): ?>
                    <a href="<?= $gallery['video_url'] ?>" 
                       target="_blank"
                       class="block w-full px-4 py-2 text-center bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition">
                        <i class="fas fa-external-link-alt mr-2"></i>Buka Video
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
