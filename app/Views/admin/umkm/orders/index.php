<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
    <div>
        <h2 class="text-xl font-semibold text-gray-800">Kelola Pesanan</h2>
        <p class="text-sm text-gray-600 mt-1">Proses dan lacak semua pesanan</p>
    </div>
</div>

<?php if (session()->getFlashdata('success')): ?>
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
        <i class="fas fa-check-circle mr-2"></i><?= session()->getFlashdata('success') ?>
    </div>
<?php endif; ?>

<!-- Filter Tabs -->
<div class="bg-white rounded-lg shadow-md mb-6">
    <div class="flex overflow-x-auto border-b">
        <a href="?status=" class="px-6 py-3 text-sm font-medium whitespace-nowrap <?= !isset($_GET['status']) ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-600 hover:text-blue-600' ?>">
            Semua
        </a>
        <a href="?status=pending" class="px-6 py-3 text-sm font-medium whitespace-nowrap <?= ($_GET['status'] ?? '') == 'pending' ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-600 hover:text-blue-600' ?>">
            Pending
        </a>
        <a href="?status=confirmed" class="px-6 py-3 text-sm font-medium whitespace-nowrap <?= ($_GET['status'] ?? '') == 'confirmed' ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-600 hover:text-blue-600' ?>">
            Confirmed
        </a>
        <a href="?status=processing" class="px-6 py-3 text-sm font-medium whitespace-nowrap <?= ($_GET['status'] ?? '') == 'processing' ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-600 hover:text-blue-600' ?>">
            Processing
        </a>
        <a href="?status=shipped" class="px-6 py-3 text-sm font-medium whitespace-nowrap <?= ($_GET['status'] ?? '') == 'shipped' ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-600 hover:text-blue-600' ?>">
            Shipped
        </a>
        <a href="?status=completed" class="px-6 py-3 text-sm font-medium whitespace-nowrap <?= ($_GET['status'] ?? '') == 'completed' ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-600 hover:text-blue-600' ?>">
            Completed
        </a>
        <a href="?status=cancelled" class="px-6 py-3 text-sm font-medium whitespace-nowrap <?= ($_GET['status'] ?? '') == 'cancelled' ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-600 hover:text-blue-600' ?>">
            Cancelled
        </a>
    </div>
</div>

<?php if (empty($orders)): ?>
    <div class="bg-white rounded-lg shadow-md p-12 text-center">
        <i class="fas fa-shopping-cart text-6xl text-gray-300 mb-4"></i>
        <p class="text-gray-500 mb-4">Belum ada pesanan</p>
    </div>
<?php else: ?>
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No. Pesanan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pelanggan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php foreach ($orders as $order): ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="font-semibold text-blue-600"><?= $order['order_number'] ?></span>
                            </td>
                            <td class="px-6 py-4">
                                <div>
                                    <p class="font-medium text-gray-800"><?= $order['customer_name'] ?></p>
                                    <p class="text-sm text-gray-600"><?= $order['customer_phone'] ?></p>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="font-semibold text-gray-800">Rp <?= number_format($order['total'], 0, ',', '.') ?></span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
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
                                <span class="px-2 py-1 text-xs font-semibold rounded-full <?= $statusColor ?>">
                                    <?= ucfirst($order['status']) ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                <?= date('d M Y H:i', strtotime($order['created_at'])) ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <a href="<?= base_url('admin/umkm/orders/view/' . $order['id']) ?>" 
                                   class="text-blue-600 hover:text-blue-900">
                                    <i class="fas fa-eye"></i> Detail
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php endif; ?>

<?= $this->endSection() ?>
