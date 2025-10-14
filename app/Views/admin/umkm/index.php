<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-800">
        <i class="fas fa-store text-blue-600 mr-2"></i>Dashboard Toko UMKM Gereja
    </h2>
    <p class="text-sm text-gray-600 mt-1">Kelola toko UMKM jemaat</p>
</div>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600 mb-1">Total Pelapak</p>
                <p class="text-3xl font-bold text-blue-600"><?= number_format($total_sellers) ?></p>
            </div>
            <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center">
                <i class="fas fa-users text-2xl text-blue-600"></i>
            </div>
        </div>
        <a href="<?= base_url('admin/umkm/sellers') ?>" class="text-sm text-blue-600 hover:underline mt-2 inline-block">
            Lihat Semua <i class="fas fa-arrow-right ml-1"></i>
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600 mb-1">Total Produk</p>
                <p class="text-3xl font-bold text-green-600"><?= number_format($total_products) ?></p>
            </div>
            <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center">
                <i class="fas fa-box text-2xl text-green-600"></i>
            </div>
        </div>
        <a href="<?= base_url('admin/umkm/products') ?>" class="text-sm text-green-600 hover:underline mt-2 inline-block">
            Lihat Semua <i class="fas fa-arrow-right ml-1"></i>
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600 mb-1">Total Pesanan</p>
                <p class="text-3xl font-bold text-purple-600"><?= number_format($total_orders) ?></p>
                <?php if ($pending_orders > 0): ?>
                    <span class="text-xs text-orange-600 font-semibold"><?= $pending_orders ?> pending</span>
                <?php endif; ?>
            </div>
            <div class="w-12 h-12 rounded-full bg-purple-100 flex items-center justify-center">
                <i class="fas fa-shopping-cart text-2xl text-purple-600"></i>
            </div>
        </div>
        <a href="<?= base_url('admin/umkm/orders') ?>" class="text-sm text-purple-600 hover:underline mt-2 inline-block">
            Lihat Semua <i class="fas fa-arrow-right ml-1"></i>
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600 mb-1">Total Pendapatan</p>
                <p class="text-3xl font-bold text-yellow-600">Rp <?= number_format($total_revenue, 0, ',', '.') ?></p>
            </div>
            <div class="w-12 h-12 rounded-full bg-yellow-100 flex items-center justify-center">
                <i class="fas fa-money-bill-wave text-2xl text-yellow-600"></i>
            </div>
        </div>
        <a href="<?= base_url('admin/umkm/reports') ?>" class="text-sm text-yellow-600 hover:underline mt-2 inline-block">
            Lihat Laporan <i class="fas fa-arrow-right ml-1"></i>
        </a>
    </div>
</div>

<!-- Quick Actions -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
    <a href="<?= base_url('admin/umkm/sellers') ?>" class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg shadow-md p-6 text-white hover:shadow-lg transition">
        <i class="fas fa-users text-3xl mb-3"></i>
        <h3 class="text-lg font-semibold">Kelola Pelapak</h3>
        <p class="text-sm opacity-90">Approve, suspend, atau lihat detail pelapak</p>
    </a>

    <a href="<?= base_url('admin/umkm/products') ?>" class="bg-gradient-to-r from-green-500 to-green-600 rounded-lg shadow-md p-6 text-white hover:shadow-lg transition">
        <i class="fas fa-box text-3xl mb-3"></i>
        <h3 class="text-lg font-semibold">Kelola Produk</h3>
        <p class="text-sm opacity-90">Moderasi dan kelola semua produk</p>
    </a>

    <a href="<?= base_url('admin/umkm/orders') ?>" class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-lg shadow-md p-6 text-white hover:shadow-lg transition">
        <i class="fas fa-shopping-cart text-3xl mb-3"></i>
        <h3 class="text-lg font-semibold">Kelola Pesanan</h3>
        <p class="text-sm opacity-90">Proses dan lacak semua pesanan</p>
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Recent Orders -->
    <div class="bg-white rounded-lg shadow-md">
        <div class="p-6 border-b">
            <h3 class="text-lg font-semibold text-gray-800">
                <i class="fas fa-clock text-blue-600 mr-2"></i>Pesanan Terbaru
            </h3>
        </div>
        <div class="p-6">
            <?php if (empty($recent_orders)): ?>
                <p class="text-gray-500 text-center py-8">Belum ada pesanan</p>
            <?php else: ?>
                <div class="space-y-4">
                    <?php foreach ($recent_orders as $order): ?>
                        <div class="flex items-center justify-between border-b pb-3">
                            <div>
                                <p class="font-semibold text-gray-800"><?= $order['order_number'] ?></p>
                                <p class="text-sm text-gray-600"><?= $order['customer_name'] ?></p>
                                <p class="text-xs text-gray-500"><?= date('d M Y H:i', strtotime($order['created_at'])) ?></p>
                            </div>
                            <div class="text-right">
                                <p class="font-semibold text-gray-800">Rp <?= number_format($order['total'], 0, ',', '.') ?></p>
                                <?php
                                $statusColors = [
                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                    'confirmed' => 'bg-blue-100 text-blue-800',
                                    'processing' => 'bg-purple-100 text-purple-800',
                                    'shipped' => 'bg-indigo-100 text-indigo-800',
                                    'completed' => 'bg-green-100 text-green-800',
                                    'cancelled' => 'bg-red-100 text-red-800'
                                ];
                                $statusColor = $statusColors[$order['status']] ?? 'bg-gray-100 text-gray-800';
                                ?>
                                <span class="text-xs px-2 py-1 rounded-full <?= $statusColor ?>">
                                    <?= ucfirst($order['status']) ?>
                                </span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Top Products -->
    <div class="bg-white rounded-lg shadow-md">
        <div class="p-6 border-b">
            <h3 class="text-lg font-semibold text-gray-800">
                <i class="fas fa-fire text-orange-600 mr-2"></i>Produk Terlaris
            </h3>
        </div>
        <div class="p-6">
            <?php if (empty($top_products)): ?>
                <p class="text-gray-500 text-center py-8">Belum ada produk</p>
            <?php else: ?>
                <div class="space-y-4">
                    <?php foreach ($top_products as $product): ?>
                        <div class="flex items-center justify-between border-b pb-3">
                            <div class="flex items-center gap-3">
                                <?php
                                $images = json_decode($product['images'], true);
                                $firstImage = $images[0] ?? null;
                                ?>
                                <?php if ($firstImage): ?>
                                    <img src="<?= base_url('uploads/umkm/products/' . $firstImage) ?>" 
                                         alt="<?= $product['name'] ?>"
                                         class="w-12 h-12 object-cover rounded">
                                <?php else: ?>
                                    <div class="w-12 h-12 bg-gray-200 rounded flex items-center justify-center">
                                        <i class="fas fa-image text-gray-400"></i>
                                    </div>
                                <?php endif; ?>
                                <div>
                                    <p class="font-semibold text-gray-800"><?= $product['name'] ?></p>
                                    <p class="text-sm text-gray-600">Rp <?= number_format($product['price'], 0, ',', '.') ?></p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-semibold text-green-600"><?= $product['sold_count'] ?> terjual</p>
                                <p class="text-xs text-gray-500">Stok: <?= $product['stock'] ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
