<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
    <div>
        <h2 class="text-xl font-semibold text-gray-800">Kegiatan Gereja</h2>
        <p class="text-sm text-gray-600 mt-1">Kelola kegiatan khusus dan kategorial</p>
    </div>
    <a href="<?= base_url('admin/ibadah/kegiatan/create') ?>" 
       class="mt-4 md:mt-0 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
        <i class="fas fa-plus mr-2"></i>Tambah Kegiatan
    </a>
</div>

<!-- Filter -->
<div class="bg-white rounded-lg shadow-md p-4 mb-6">
    <form method="GET" class="flex gap-4">
        <select name="category" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
            <option value="">Semua Kategori</option>
            <option value="remaja" <?= ($category ?? '') == 'remaja' ? 'selected' : '' ?>>Remaja</option>
            <option value="pemuda" <?= ($category ?? '') == 'pemuda' ? 'selected' : '' ?>>Pemuda</option>
            <option value="lansia" <?= ($category ?? '') == 'lansia' ? 'selected' : '' ?>>Lansia</option>
            <option value="paduan_suara" <?= ($category ?? '') == 'paduan_suara' ? 'selected' : '' ?>>Paduan Suara</option>
            <option value="perayaan" <?= ($category ?? '') == 'perayaan' ? 'selected' : '' ?>>Perayaan</option>
            <option value="lainnya" <?= ($category ?? '') == 'lainnya' ? 'selected' : '' ?>>Lainnya</option>
        </select>
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
            <i class="fas fa-filter mr-2"></i>Filter
        </button>
    </form>
</div>

<!-- Kegiatan Grid -->
<?php if (empty($kegiatan)): ?>
    <div class="bg-white rounded-lg shadow-md p-12 text-center">
        <i class="fas fa-calendar-alt text-6xl text-gray-300 mb-4"></i>
        <p class="text-gray-500">Belum ada kegiatan</p>
    </div>
<?php else: ?>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php foreach ($kegiatan as $k): ?>
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                <!-- Image -->
                <?php if ($k['image']): ?>
                    <img src="<?= base_url('uploads/kegiatan/' . $k['image']) ?>" 
                         alt="<?= $k['title'] ?>"
                         class="w-full h-48 object-cover">
                <?php else: ?>
                    <div class="w-full h-48 bg-gradient-to-br from-purple-400 to-purple-600 flex items-center justify-center">
                        <i class="fas fa-calendar-alt text-6xl text-white opacity-50"></i>
                    </div>
                <?php endif; ?>
                
                <div class="p-6">
                    <!-- Category & Status -->
                    <div class="flex items-center justify-between mb-3">
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-800">
                            <?= ucfirst(str_replace('_', ' ', $k['category'])) ?>
                        </span>
                        <?php if ($k['is_published']): ?>
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                <i class="fas fa-check-circle"></i> Published
                            </span>
                        <?php else: ?>
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                                <i class="fas fa-clock"></i> Draft
                            </span>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Title -->
                    <h3 class="text-lg font-semibold text-gray-800 mb-2 line-clamp-2">
                        <?= $k['title'] ?>
                    </h3>
                    
                    <!-- Date & Location -->
                    <div class="space-y-2 mb-4">
                        <div class="flex items-center text-sm text-gray-600">
                            <i class="far fa-calendar mr-2"></i>
                            <?= date('d M Y', strtotime($k['date_start'])) ?>
                            <?php if ($k['date_end'] && $k['date_end'] != $k['date_start']): ?>
                                - <?= date('d M Y', strtotime($k['date_end'])) ?>
                            <?php endif; ?>
                        </div>
                        <?php if ($k['location']): ?>
                            <div class="flex items-center text-sm text-gray-600">
                                <i class="fas fa-map-marker-alt mr-2"></i>
                                <?= $k['location'] ?>
                            </div>
                        <?php endif; ?>
                        <?php if ($k['registration_required']): ?>
                            <div class="flex items-center text-sm text-blue-600">
                                <i class="fas fa-user-check mr-2"></i>
                                Perlu Pendaftaran
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Actions -->
                    <div class="flex gap-2">
                        <a href="<?= base_url('admin/ibadah/kegiatan/view/' . $k['id']) ?>" 
                           class="flex-1 px-3 py-2 text-center bg-blue-50 text-blue-600 rounded hover:bg-blue-100 transition text-sm">
                            <i class="fas fa-eye mr-1"></i>Detail
                        </a>
                        <a href="<?= base_url('admin/ibadah/kegiatan/edit/' . $k['id']) ?>" 
                           class="flex-1 px-3 py-2 text-center bg-green-50 text-green-600 rounded hover:bg-green-100 transition text-sm">
                            <i class="fas fa-edit mr-1"></i>Edit
                        </a>
                        <a href="<?= base_url('admin/ibadah/kegiatan/delete/' . $k['id']) ?>" 
                           onclick="return confirm('Yakin ingin menghapus kegiatan ini?')"
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
