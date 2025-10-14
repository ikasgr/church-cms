<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<div class="mb-6">
    <div class="flex items-center gap-2 text-sm text-gray-600 mb-4">
        <a href="<?= base_url('admin/umkm/sellers') ?>" class="hover:text-blue-600">
            <i class="fas fa-users"></i> Pelapak
        </a>
        <i class="fas fa-chevron-right text-xs"></i>
        <span class="text-gray-800">Detail Pelapak</span>
    </div>
    <div class="flex items-center justify-between">
        <h2 class="text-2xl font-bold text-gray-800">
            <i class="fas fa-store text-blue-600 mr-2"></i><?= $seller['business_name'] ?>
        </h2>
        <div class="flex gap-2">
            <a href="<?= base_url('admin/umkm/sellers/edit/' . $seller['id']) ?>" 
               class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                <i class="fas fa-edit mr-2"></i>Edit
            </a>
            <?php if ($seller['status'] == 'pending'): ?>
                <a href="<?= base_url('admin/umkm/sellers/approve/' . $seller['id']) ?>" 
                   onclick="return confirm('Setujui pelapak ini?')"
                   class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                    <i class="fas fa-check mr-2"></i>Approve
                </a>
            <?php elseif ($seller['status'] == 'active'): ?>
                <a href="<?= base_url('admin/umkm/sellers/suspend/' . $seller['id']) ?>" 
                   onclick="return confirm('Suspend pelapak ini?')"
                   class="px-4 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition">
                    <i class="fas fa-ban mr-2"></i>Suspend
                </a>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Status Badge -->
<div class="mb-6">
    <?php
    $statusColors = [
        'pending' => 'bg-yellow-100 text-yellow-800',
        'active' => 'bg-green-100 text-green-800',
        'suspended' => 'bg-red-100 text-red-800'
    ];
    $statusColor = $statusColors[$seller['status']] ?? 'bg-gray-100 text-gray-800';
    ?>
    <span class="px-4 py-2 text-sm font-semibold rounded-full <?= $statusColor ?>">
        <i class="fas fa-circle text-xs mr-1"></i><?= ucfirst($seller['status']) ?>
    </span>
    <?php if ($seller['is_verified']): ?>
        <span class="ml-2 px-4 py-2 text-sm font-semibold rounded-full bg-blue-100 text-blue-800">
            <i class="fas fa-check-circle mr-1"></i>Verified
        </span>
    <?php endif; ?>
</div>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600 mb-1">Total Produk</p>
                <p class="text-3xl font-bold text-blue-600"><?= $seller['total_products'] ?></p>
            </div>
            <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center">
                <i class="fas fa-box text-2xl text-blue-600"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600 mb-1">Total Penjualan</p>
                <p class="text-3xl font-bold text-green-600">Rp <?= number_format($seller['total_sales'], 0, ',', '.') ?></p>
            </div>
            <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center">
                <i class="fas fa-money-bill-wave text-2xl text-green-600"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600 mb-1">Rating</p>
                <p class="text-3xl font-bold text-yellow-600">
                    <?= number_format($seller['rating'], 1) ?>
                    <i class="fas fa-star text-xl"></i>
                </p>
            </div>
            <div class="w-12 h-12 rounded-full bg-yellow-100 flex items-center justify-center">
                <i class="fas fa-star text-2xl text-yellow-600"></i>
            </div>
        </div>
        <p class="text-xs text-gray-500 mt-2"><?= $seller['total_reviews'] ?> ulasan</p>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600 mb-1">Komisi Gereja</p>
                <p class="text-3xl font-bold text-purple-600"><?= number_format($seller['commission_rate'], 1) ?>%</p>
            </div>
            <div class="w-12 h-12 rounded-full bg-purple-100 flex items-center justify-center">
                <i class="fas fa-percentage text-2xl text-purple-600"></i>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Seller Information -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Business Info -->
        <div class="bg-white rounded-lg shadow-md">
            <div class="p-6 border-b">
                <h3 class="text-lg font-semibold text-gray-800">
                    <i class="fas fa-store mr-2"></i>Informasi Usaha
                </h3>
            </div>
            <div class="p-6">
                <div class="flex gap-6">
                    <?php if ($seller['logo']): ?>
                        <div class="flex-shrink-0">
                            <img src="<?= base_url('uploads/umkm/sellers/' . $seller['logo']) ?>" 
                                 alt="<?= $seller['business_name'] ?>"
                                 class="w-32 h-32 object-cover rounded-lg border">
                        </div>
                    <?php endif; ?>
                    <div class="flex-1 space-y-4">
                        <div>
                            <p class="text-sm text-gray-600">Nama Usaha</p>
                            <p class="font-semibold text-gray-800 text-lg"><?= $seller['business_name'] ?></p>
                        </div>
                        <?php if ($seller['description']): ?>
                            <div>
                                <p class="text-sm text-gray-600">Deskripsi</p>
                                <p class="text-gray-800"><?= nl2br($seller['description']) ?></p>
                            </div>
                        <?php endif; ?>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-600">Bergabung</p>
                                <p class="text-gray-800"><?= date('d M Y', strtotime($seller['created_at'])) ?></p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Update Terakhir</p>
                                <p class="text-gray-800"><?= date('d M Y', strtotime($seller['updated_at'])) ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Products List -->
        <div class="bg-white rounded-lg shadow-md">
            <div class="p-6 border-b flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-800">
                    <i class="fas fa-box mr-2"></i>Produk (<?= count($products) ?>)
                </h3>
                <a href="<?= base_url('admin/umkm/products?seller=' . $seller['id']) ?>" 
                   class="text-blue-600 hover:text-blue-800 text-sm">
                    Lihat Semua <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
            <div class="p-6">
                <?php if (empty($products)): ?>
                    <p class="text-gray-500 text-center py-8">Belum ada produk</p>
                <?php else: ?>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <?php foreach (array_slice($products, 0, 4) as $product): ?>
                            <?php
                            $images = json_decode($product['images'], true);
                            $firstImage = $images[0] ?? null;
                            ?>
                            <div class="border rounded-lg p-4 hover:shadow-md transition">
                                <div class="flex gap-3">
                                    <?php if ($firstImage): ?>
                                        <img src="<?= base_url('uploads/umkm/products/' . $firstImage) ?>" 
                                             alt="<?= $product['name'] ?>"
                                             class="w-20 h-20 object-cover rounded">
                                    <?php else: ?>
                                        <div class="w-20 h-20 bg-gray-200 rounded flex items-center justify-center">
                                            <i class="fas fa-image text-gray-400"></i>
                                        </div>
                                    <?php endif; ?>
                                    <div class="flex-1">
                                        <h4 class="font-semibold text-gray-800 line-clamp-2"><?= $product['name'] ?></h4>
                                        <p class="text-blue-600 font-bold mt-1">
                                            Rp <?= number_format($product['price'], 0, ',', '.') ?>
                                        </p>
                                        <div class="flex items-center gap-2 mt-1">
                                            <span class="text-xs text-gray-600">Stok: <?= $product['stock'] ?></span>
                                            <?php if ($product['is_active']): ?>
                                                <span class="px-2 py-0.5 text-xs bg-green-100 text-green-800 rounded-full">Aktif</span>
                                            <?php else: ?>
                                                <span class="px-2 py-0.5 text-xs bg-gray-100 text-gray-800 rounded-full">Non-Aktif</span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Contact & Bank Info -->
    <div class="space-y-6">
        <!-- Owner Info -->
        <div class="bg-white rounded-lg shadow-md">
            <div class="p-6 border-b">
                <h3 class="text-lg font-semibold text-gray-800">
                    <i class="fas fa-user mr-2"></i>Informasi Pemilik
                </h3>
            </div>
            <div class="p-6 space-y-4">
                <div>
                    <p class="text-sm text-gray-600">Nama Pemilik</p>
                    <p class="font-semibold text-gray-800"><?= $seller['owner_name'] ?></p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Email</p>
                    <p class="text-gray-800">
                        <a href="mailto:<?= $seller['email'] ?>" class="text-blue-600 hover:underline">
                            <?= $seller['email'] ?>
                        </a>
                    </p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Telepon</p>
                    <p class="text-gray-800">
                        <a href="tel:<?= $seller['phone'] ?>" class="text-blue-600 hover:underline">
                            <?= $seller['phone'] ?>
                        </a>
                    </p>
                </div>
                <?php if ($seller['address']): ?>
                    <div>
                        <p class="text-sm text-gray-600">Alamat</p>
                        <p class="text-gray-800"><?= nl2br($seller['address']) ?></p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Bank Info -->
        <?php if ($seller['bank_name'] || $seller['bank_account_number']): ?>
            <div class="bg-white rounded-lg shadow-md">
                <div class="p-6 border-b">
                    <h3 class="text-lg font-semibold text-gray-800">
                        <i class="fas fa-university mr-2"></i>Informasi Rekening
                    </h3>
                </div>
                <div class="p-6 space-y-4">
                    <?php if ($seller['bank_name']): ?>
                        <div>
                            <p class="text-sm text-gray-600">Nama Bank</p>
                            <p class="font-semibold text-gray-800"><?= $seller['bank_name'] ?></p>
                        </div>
                    <?php endif; ?>
                    <?php if ($seller['bank_account_number']): ?>
                        <div>
                            <p class="text-sm text-gray-600">Nomor Rekening</p>
                            <p class="font-mono text-gray-800"><?= $seller['bank_account_number'] ?></p>
                        </div>
                    <?php endif; ?>
                    <?php if ($seller['bank_account_name']): ?>
                        <div>
                            <p class="text-sm text-gray-600">Atas Nama</p>
                            <p class="text-gray-800"><?= $seller['bank_account_name'] ?></p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- Quick Actions -->
        <div class="bg-white rounded-lg shadow-md">
            <div class="p-6 border-b">
                <h3 class="text-lg font-semibold text-gray-800">
                    <i class="fas fa-bolt mr-2"></i>Aksi Cepat
                </h3>
            </div>
            <div class="p-6 space-y-2">
                <a href="<?= base_url('admin/umkm/products?seller=' . $seller['id']) ?>" 
                   class="block w-full px-4 py-2 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition text-center">
                    <i class="fas fa-box mr-2"></i>Lihat Semua Produk
                </a>
                <a href="<?= base_url('admin/umkm/orders?seller=' . $seller['id']) ?>" 
                   class="block w-full px-4 py-2 bg-green-50 text-green-600 rounded-lg hover:bg-green-100 transition text-center">
                    <i class="fas fa-shopping-cart mr-2"></i>Lihat Pesanan
                </a>
                <a href="<?= base_url('admin/umkm/sellers/edit/' . $seller['id']) ?>" 
                   class="block w-full px-4 py-2 bg-purple-50 text-purple-600 rounded-lg hover:bg-purple-100 transition text-center">
                    <i class="fas fa-edit mr-2"></i>Edit Data
                </a>
                <a href="<?= base_url('admin/umkm/sellers/delete/' . $seller['id']) ?>" 
                   onclick="return confirm('Yakin ingin menghapus pelapak ini?')"
                   class="block w-full px-4 py-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition text-center">
                    <i class="fas fa-trash mr-2"></i>Hapus Pelapak
                </a>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
