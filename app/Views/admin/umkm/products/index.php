<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
    <div>
        <h2 class="text-xl font-semibold text-gray-800">Kelola Produk UMKM</h2>
        <p class="text-sm text-gray-600 mt-1">Moderasi semua produk</p>
    </div>
    <a href="<?= base_url('admin/umkm/products/create') ?>" 
       class="mt-4 md:mt-0 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
        <i class="fas fa-plus mr-2"></i>Tambah Produk
    </a>
</div>

<?php if (session()->getFlashdata('success')): ?>
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
        <i class="fas fa-check-circle mr-2"></i><?= session()->getFlashdata('success') ?>
    </div>
<?php endif; ?>

<?php if (empty($products)): ?>
    <div class="bg-white rounded-lg shadow-md p-12 text-center">
        <i class="fas fa-box text-6xl text-gray-300 mb-4"></i>
        <p class="text-gray-500 mb-4">Belum ada produk</p>
    </div>
<?php else: ?>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <?php foreach ($products as $product): ?>
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                <?php
                $images = json_decode($product['images'], true);
                $firstImage = $images[0] ?? null;
                ?>
                <?php if ($firstImage): ?>
                    <img src="<?= base_url('uploads/umkm/products/' . $firstImage) ?>" 
                         alt="<?= $product['name'] ?>"
                         class="w-full h-48 object-cover">
                <?php else: ?>
                    <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                        <i class="fas fa-image text-4xl text-gray-400"></i>
                    </div>
                <?php endif; ?>
                
                <div class="p-4">
                    <div class="flex items-start justify-between mb-2">
                        <h3 class="font-semibold text-gray-800 line-clamp-2"><?= $product['name'] ?></h3>
                        <?php if ($product['is_active']): ?>
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                Aktif
                            </span>
                        <?php else: ?>
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                                Non-Aktif
                            </span>
                        <?php endif; ?>
                    </div>
                    
                    <p class="text-sm text-gray-600 mb-2">
                        <i class="fas fa-store mr-1"></i><?= $product['seller_name'] ?>
                    </p>
                    
                    <div class="flex items-center justify-between mb-3">
                        <p class="text-lg font-bold text-blue-600">
                            Rp <?= number_format($product['price'], 0, ',', '.') ?>
                        </p>
                        <p class="text-sm text-gray-600">
                            Stok: <?= $product['stock'] ?>
                        </p>
                    </div>
                    
                    <div class="flex gap-2">
                        <a href="<?= base_url('admin/umkm/products/edit/' . $product['id']) ?>" 
                           class="flex-1 px-3 py-2 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition text-sm text-center">
                            <i class="fas fa-edit mr-1"></i>Edit
                        </a>
                        <a href="<?= base_url('admin/umkm/products/toggle/' . $product['id']) ?>" 
                           class="flex-1 px-3 py-2 <?= $product['is_active'] ? 'bg-orange-50 text-orange-600 hover:bg-orange-100' : 'bg-green-50 text-green-600 hover:bg-green-100' ?> rounded-lg transition text-sm text-center">
                            <i class="fas fa-<?= $product['is_active'] ? 'times' : 'check' ?> mr-1"></i>
                        </a>
                    </div>
                    <div class="mt-2">
                        <a href="<?= base_url('admin/umkm/products/delete/' . $product['id']) ?>" 
                           onclick="return confirm('Yakin ingin menghapus produk ini?')"
                           class="block w-full px-3 py-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition text-sm text-center">
                            <i class="fas fa-trash mr-1"></i>Hapus
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?= $this->endSection() ?>
