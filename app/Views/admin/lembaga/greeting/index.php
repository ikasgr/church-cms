<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
    <div>
        <h2 class="text-xl font-semibold text-gray-800">Sambutan Ketua Majelis</h2>
        <p class="text-sm text-gray-600 mt-1">Kelola sambutan dan pesan dari ketua majelis</p>
    </div>
    <a href="<?= base_url('admin/lembaga/greeting/create') ?>" 
       class="mt-4 md:mt-0 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
        <i class="fas fa-plus mr-2"></i>Tambah Sambutan
    </a>
</div>

<?php if (empty($greetings)): ?>
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <i class="fas fa-comment-dots text-6xl text-gray-300 mb-4"></i>
        <p class="text-gray-500 mb-4">Belum ada sambutan</p>
        <a href="<?= base_url('admin/lembaga/greeting/create') ?>" 
           class="inline-block px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
            <i class="fas fa-plus mr-2"></i>Tambah Sambutan
        </a>
    </div>
<?php else: ?>
    <div class="grid grid-cols-1 gap-6">
        <?php foreach ($greetings as $g): ?>
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                <div class="p-6">
                    <div class="flex items-start gap-6">
                        <!-- Author Photo -->
                        <div class="flex-shrink-0">
                            <?php if ($g['author_photo']): ?>
                                <img src="<?= base_url('uploads/greeting/' . $g['author_photo']) ?>" 
                                     alt="<?= $g['author_name'] ?>"
                                     class="w-24 h-24 rounded-full object-cover shadow-lg">
                            <?php else: ?>
                                <div class="w-24 h-24 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center text-white text-2xl font-bold shadow-lg">
                                    <?= strtoupper(substr($g['author_name'], 0, 1)) ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Content -->
                        <div class="flex-1">
                            <div class="flex items-start justify-between mb-3">
                                <div>
                                    <h3 class="text-xl font-bold text-gray-800 mb-1"><?= $g['title'] ?></h3>
                                    <div class="flex items-center gap-3 text-sm text-gray-600">
                                        <span class="font-medium"><?= $g['author_name'] ?></span>
                                        <span>•</span>
                                        <span><?= $g['author_position'] ?></span>
                                    </div>
                                </div>
                                
                                <!-- Status Badge -->
                                <?php if ($g['is_active']): ?>
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                        <i class="fas fa-check-circle mr-1"></i>Aktif
                                    </span>
                                <?php else: ?>
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                                        <i class="fas fa-eye-slash mr-1"></i>Non-Aktif
                                    </span>
                                <?php endif; ?>
                            </div>
                            
                            <!-- Excerpt -->
                            <div class="text-gray-600 mb-4 line-clamp-3">
                                <?= substr(strip_tags($g['content']), 0, 200) ?>...
                            </div>
                            
                            <!-- Meta Info -->
                            <div class="flex items-center gap-4 text-xs text-gray-500 mb-4">
                                <span>
                                    <i class="far fa-calendar mr-1"></i>
                                    <?= date('d M Y', strtotime($g['created_at'])) ?>
                                </span>
                                <span>
                                    <i class="far fa-clock mr-1"></i>
                                    <?= date('H:i', strtotime($g['created_at'])) ?>
                                </span>
                            </div>
                            
                            <!-- Actions -->
                            <div class="flex gap-2 pt-4 border-t">
                                <a href="<?= base_url('admin/lembaga/greeting/edit/' . $g['id']) ?>" 
                                   class="px-4 py-2 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition text-sm">
                                    <i class="fas fa-edit mr-1"></i>Edit
                                </a>
                                <a href="<?= base_url('admin/lembaga/greeting/toggle/' . $g['id']) ?>" 
                                   class="px-4 py-2 bg-purple-50 text-purple-600 rounded-lg hover:bg-purple-100 transition text-sm">
                                    <i class="fas fa-<?= $g['is_active'] ? 'eye-slash' : 'eye' ?> mr-1"></i>
                                    <?= $g['is_active'] ? 'Non-Aktifkan' : 'Aktifkan' ?>
                                </a>
                                <a href="<?= base_url('admin/lembaga/greeting/delete/' . $g['id']) ?>" 
                                   onclick="return confirm('Yakin ingin menghapus sambutan ini?')"
                                   class="px-4 py-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition text-sm">
                                    <i class="fas fa-trash mr-1"></i>Hapus
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?= $this->endSection() ?>
