<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
    <div>
        <h2 class="text-xl font-semibold text-gray-800">Kelola Pelapak UMKM</h2>
        <p class="text-sm text-gray-600 mt-1">Kelola dan moderasi pelapak</p>
    </div>
    <a href="<?= base_url('admin/umkm/sellers/create') ?>" 
       class="mt-4 md:mt-0 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
        <i class="fas fa-plus mr-2"></i>Tambah Pelapak
    </a>
</div>

<?php if (session()->getFlashdata('success')): ?>
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
        <i class="fas fa-check-circle mr-2"></i><?= session()->getFlashdata('success') ?>
    </div>
<?php endif; ?>

<!-- Filter Tabs -->
<div class="bg-white rounded-lg shadow-md mb-6">
    <div class="flex border-b">
        <a href="?status=" class="px-6 py-3 text-sm font-medium <?= !isset($_GET['status']) ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-600 hover:text-blue-600' ?>">
            Semua
        </a>
        <a href="?status=pending" class="px-6 py-3 text-sm font-medium <?= ($_GET['status'] ?? '') == 'pending' ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-600 hover:text-blue-600' ?>">
            Pending
        </a>
        <a href="?status=active" class="px-6 py-3 text-sm font-medium <?= ($_GET['status'] ?? '') == 'active' ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-600 hover:text-blue-600' ?>">
            Aktif
        </a>
        <a href="?status=suspended" class="px-6 py-3 text-sm font-medium <?= ($_GET['status'] ?? '') == 'suspended' ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-600 hover:text-blue-600' ?>">
            Suspended
        </a>
    </div>
</div>

<?php if (empty($sellers)): ?>
    <div class="bg-white rounded-lg shadow-md p-12 text-center">
        <i class="fas fa-store text-6xl text-gray-300 mb-4"></i>
        <p class="text-gray-500 mb-4">Belum ada pelapak</p>
    </div>
<?php else: ?>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php foreach ($sellers as $seller): ?>
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                <div class="p-6">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex items-center gap-3">
                            <?php if ($seller['logo']): ?>
                                <img src="<?= base_url('uploads/umkm/sellers/' . $seller['logo']) ?>" 
                                     alt="<?= $seller['business_name'] ?>"
                                     class="w-16 h-16 object-cover rounded-lg">
                            <?php else: ?>
                                <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-store text-2xl text-gray-400"></i>
                                </div>
                            <?php endif; ?>
                            <div>
                                <h3 class="font-bold text-gray-800"><?= $seller['business_name'] ?></h3>
                                <p class="text-sm text-gray-600"><?= $seller['owner_name'] ?></p>
                            </div>
                        </div>
                        <?php
                        $statusColors = [
                            'pending' => 'bg-yellow-100 text-yellow-800',
                            'active' => 'bg-green-100 text-green-800',
                            'suspended' => 'bg-red-100 text-red-800'
                        ];
                        $statusColor = $statusColors[$seller['status']] ?? 'bg-gray-100 text-gray-800';
                        ?>
                        <span class="px-2 py-1 text-xs font-semibold rounded-full <?= $statusColor ?>">
                            <?= ucfirst($seller['status']) ?>
                        </span>
                    </div>

                    <div class="space-y-2 mb-4">
                        <div class="flex items-center text-sm text-gray-600">
                            <i class="fas fa-phone w-5"></i>
                            <span><?= $seller['phone'] ?></span>
                        </div>
                        <div class="flex items-center text-sm text-gray-600">
                            <i class="fas fa-envelope w-5"></i>
                            <span><?= $seller['email'] ?></span>
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-2 mb-4 pt-4 border-t">
                        <div class="text-center">
                            <p class="text-lg font-bold text-blue-600"><?= $seller['product_count'] ?? 0 ?></p>
                            <p class="text-xs text-gray-600">Produk</p>
                        </div>
                        <div class="text-center">
                            <p class="text-lg font-bold text-green-600"><?= $seller['order_count'] ?? 0 ?></p>
                            <p class="text-xs text-gray-600">Pesanan</p>
                        </div>
                        <div class="text-center">
                            <p class="text-lg font-bold text-yellow-600"><?= number_format($seller['total_income'] ?? 0, 0) ?></p>
                            <p class="text-xs text-gray-600">Pendapatan</p>
                        </div>
                    </div>

                    <div class="flex gap-2">
                        <a href="<?= base_url('admin/umkm/sellers/view/' . $seller['id']) ?>" 
                           class="flex-1 px-3 py-2 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition text-sm text-center">
                            <i class="fas fa-eye mr-1"></i>Detail
                        </a>
                        <a href="<?= base_url('admin/umkm/sellers/edit/' . $seller['id']) ?>" 
                           class="flex-1 px-3 py-2 bg-green-50 text-green-600 rounded-lg hover:bg-green-100 transition text-sm text-center">
                            <i class="fas fa-edit mr-1"></i>Edit
                        </a>
                    </div>
                    <div class="flex gap-2 mt-2">
                        <?php if ($seller['status'] == 'pending'): ?>
                            <a href="<?= base_url('admin/umkm/sellers/approve/' . $seller['id']) ?>" 
                               onclick="return confirm('Setujui pelapak ini?')"
                               class="flex-1 px-3 py-2 bg-green-50 text-green-600 rounded-lg hover:bg-green-100 transition text-sm text-center">
                                <i class="fas fa-check mr-1"></i>Approve
                            </a>
                        <?php elseif ($seller['status'] == 'active'): ?>
                            <a href="<?= base_url('admin/umkm/sellers/suspend/' . $seller['id']) ?>" 
                               onclick="return confirm('Suspend pelapak ini?')"
                               class="flex-1 px-3 py-2 bg-orange-50 text-orange-600 rounded-lg hover:bg-orange-100 transition text-sm text-center">
                                <i class="fas fa-ban mr-1"></i>Suspend
                            </a>
                        <?php endif; ?>
                        <a href="<?= base_url('admin/umkm/sellers/delete/' . $seller['id']) ?>" 
                           onclick="return confirm('Yakin ingin menghapus pelapak ini?')"
                           class="flex-1 px-3 py-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition text-sm text-center">
                            <i class="fas fa-trash mr-1"></i>Hapus
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?= $this->endSection() ?>
