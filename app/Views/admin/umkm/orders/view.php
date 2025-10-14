<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<div class="mb-6">
    <div class="flex items-center gap-2 text-sm text-gray-600 mb-4">
        <a href="<?= base_url('admin/umkm/orders') ?>" class="hover:text-blue-600">
            <i class="fas fa-shopping-cart"></i> Pesanan
        </a>
        <i class="fas fa-chevron-right text-xs"></i>
        <span class="text-gray-800">Detail Pesanan</span>
    </div>
    <div class="flex items-center justify-between">
        <h2 class="text-2xl font-bold text-gray-800">
            <i class="fas fa-file-invoice text-blue-600 mr-2"></i>Pesanan #<?= $order['order_number'] ?>
        </h2>
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
        <span class="px-4 py-2 text-sm font-semibold rounded-full <?= $statusColor ?>">
            <?= ucfirst($order['status']) ?>
        </span>
    </div>
</div>

<?php if (session()->getFlashdata('success')): ?>
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
        <i class="fas fa-check-circle mr-2"></i><?= session()->getFlashdata('success') ?>
    </div>
<?php endif; ?>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Order Items -->
    <div class="lg:col-span-2 space-y-6">
        <div class="bg-white rounded-lg shadow-md">
            <div class="p-6 border-b">
                <h3 class="text-lg font-semibold text-gray-800">
                    <i class="fas fa-box mr-2"></i>Item Pesanan
                </h3>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    <?php foreach ($order['items'] as $item): ?>
                        <div class="flex gap-4 border-b pb-4">
                            <?php
                            $images = json_decode($item['images'], true);
                            $firstImage = $images[0] ?? null;
                            ?>
                            <?php if ($firstImage): ?>
                                <img src="<?= base_url('uploads/umkm/products/' . $firstImage) ?>" 
                                     alt="<?= $item['product_name'] ?>"
                                     class="w-20 h-20 object-cover rounded">
                            <?php else: ?>
                                <div class="w-20 h-20 bg-gray-200 rounded flex items-center justify-center">
                                    <i class="fas fa-image text-gray-400"></i>
                                </div>
                            <?php endif; ?>
                            
                            <div class="flex-1">
                                <h4 class="font-semibold text-gray-800"><?= $item['product_name'] ?></h4>
                                <p class="text-sm text-gray-600">
                                    <i class="fas fa-store mr-1"></i><?= $item['seller_name'] ?>
                                </p>
                                <div class="flex items-center gap-4 mt-2">
                                    <p class="text-sm text-gray-600">
                                        Rp <?= number_format($item['product_price'], 0, ',', '.') ?> x <?= $item['quantity'] ?>
                                    </p>
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full <?= $statusColors[$item['status']] ?? 'bg-gray-100 text-gray-800' ?>">
                                        <?= ucfirst($item['status']) ?>
                                    </span>
                                </div>
                            </div>
                            
                            <div class="text-right">
                                <p class="font-semibold text-gray-800">
                                    Rp <?= number_format($item['subtotal'], 0, ',', '.') ?>
                                </p>
                                <?php if ($item['commission'] > 0): ?>
                                    <p class="text-xs text-gray-500">
                                        Komisi: Rp <?= number_format($item['commission'], 0, ',', '.') ?>
                                    </p>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Order Summary -->
                <div class="mt-6 pt-6 border-t space-y-2">
                    <div class="flex justify-between text-gray-600">
                        <span>Subtotal</span>
                        <span>Rp <?= number_format($order['subtotal'], 0, ',', '.') ?></span>
                    </div>
                    <?php if ($order['shipping_cost'] > 0): ?>
                        <div class="flex justify-between text-gray-600">
                            <span>Ongkir</span>
                            <span>Rp <?= number_format($order['shipping_cost'], 0, ',', '.') ?></span>
                        </div>
                    <?php endif; ?>
                    <?php if ($order['discount'] > 0): ?>
                        <div class="flex justify-between text-green-600">
                            <span>Diskon</span>
                            <span>- Rp <?= number_format($order['discount'], 0, ',', '.') ?></span>
                        </div>
                    <?php endif; ?>
                    <div class="flex justify-between text-lg font-bold text-gray-800 pt-2 border-t">
                        <span>Total</span>
                        <span>Rp <?= number_format($order['total'], 0, ',', '.') ?></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Update Status -->
        <div class="bg-white rounded-lg shadow-md">
            <div class="p-6 border-b">
                <h3 class="text-lg font-semibold text-gray-800">
                    <i class="fas fa-sync mr-2"></i>Update Status Pesanan
                </h3>
            </div>
            <div class="p-6">
                <form action="<?= base_url('admin/umkm/orders/update-status/' . $order['id']) ?>" method="POST">
                    <?= csrf_field() ?>
                    <div class="flex gap-3">
                        <select name="status" 
                                class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="pending" <?= $order['status'] == 'pending' ? 'selected' : '' ?>>Pending</option>
                            <option value="confirmed" <?= $order['status'] == 'confirmed' ? 'selected' : '' ?>>Confirmed</option>
                            <option value="processing" <?= $order['status'] == 'processing' ? 'selected' : '' ?>>Processing</option>
                            <option value="shipped" <?= $order['status'] == 'shipped' ? 'selected' : '' ?>>Shipped</option>
                            <option value="completed" <?= $order['status'] == 'completed' ? 'selected' : '' ?>>Completed</option>
                            <option value="cancelled" <?= $order['status'] == 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                        </select>
                        <button type="submit" 
                                class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                            <i class="fas fa-save mr-2"></i>Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Customer Info & Details -->
    <div class="space-y-6">
        <!-- Customer Info -->
        <div class="bg-white rounded-lg shadow-md">
            <div class="p-6 border-b">
                <h3 class="text-lg font-semibold text-gray-800">
                    <i class="fas fa-user mr-2"></i>Informasi Pelanggan
                </h3>
            </div>
            <div class="p-6 space-y-3">
                <div>
                    <p class="text-sm text-gray-600">Nama</p>
                    <p class="font-semibold text-gray-800"><?= $order['customer_name'] ?></p>
                </div>
                <?php if ($order['customer_email']): ?>
                    <div>
                        <p class="text-sm text-gray-600">Email</p>
                        <p class="text-gray-800"><?= $order['customer_email'] ?></p>
                    </div>
                <?php endif; ?>
                <div>
                    <p class="text-sm text-gray-600">Telepon</p>
                    <p class="text-gray-800"><?= $order['customer_phone'] ?></p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Alamat</p>
                    <p class="text-gray-800"><?= nl2br($order['customer_address']) ?></p>
                </div>
                <?php if ($order['customer_notes']): ?>
                    <div>
                        <p class="text-sm text-gray-600">Catatan</p>
                        <p class="text-gray-800 italic"><?= nl2br($order['customer_notes']) ?></p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Payment Info -->
        <div class="bg-white rounded-lg shadow-md">
            <div class="p-6 border-b">
                <h3 class="text-lg font-semibold text-gray-800">
                    <i class="fas fa-credit-card mr-2"></i>Informasi Pembayaran
                </h3>
            </div>
            <div class="p-6 space-y-3">
                <div>
                    <p class="text-sm text-gray-600">Metode Pembayaran</p>
                    <p class="font-semibold text-gray-800">
                        <?php
                        $paymentMethods = [
                            'transfer' => 'Transfer Bank',
                            'cod' => 'Cash on Delivery',
                            'ewallet' => 'E-Wallet'
                        ];
                        echo $paymentMethods[$order['payment_method']] ?? ucfirst($order['payment_method']);
                        ?>
                    </p>
                </div>
                <?php if ($order['payment_proof']): ?>
                    <div>
                        <p class="text-sm text-gray-600 mb-2">Bukti Pembayaran</p>
                        <img src="<?= base_url('uploads/umkm/payments/' . $order['payment_proof']) ?>" 
                             alt="Payment Proof"
                             class="w-full rounded border">
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Order Timeline -->
        <div class="bg-white rounded-lg shadow-md">
            <div class="p-6 border-b">
                <h3 class="text-lg font-semibold text-gray-800">
                    <i class="fas fa-clock mr-2"></i>Timeline
                </h3>
            </div>
            <div class="p-6 space-y-3">
                <div>
                    <p class="text-sm text-gray-600">Dibuat</p>
                    <p class="text-gray-800"><?= date('d M Y H:i', strtotime($order['created_at'])) ?></p>
                </div>
                <?php if ($order['confirmed_at']): ?>
                    <div>
                        <p class="text-sm text-gray-600">Dikonfirmasi</p>
                        <p class="text-gray-800"><?= date('d M Y H:i', strtotime($order['confirmed_at'])) ?></p>
                    </div>
                <?php endif; ?>
                <?php if ($order['shipped_at']): ?>
                    <div>
                        <p class="text-sm text-gray-600">Dikirim</p>
                        <p class="text-gray-800"><?= date('d M Y H:i', strtotime($order['shipped_at'])) ?></p>
                    </div>
                <?php endif; ?>
                <?php if ($order['completed_at']): ?>
                    <div>
                        <p class="text-sm text-gray-600">Selesai</p>
                        <p class="text-gray-800"><?= date('d M Y H:i', strtotime($order['completed_at'])) ?></p>
                    </div>
                <?php endif; ?>
                <?php if ($order['cancelled_at']): ?>
                    <div>
                        <p class="text-sm text-gray-600">Dibatalkan</p>
                        <p class="text-gray-800"><?= date('d M Y H:i', strtotime($order['cancelled_at'])) ?></p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
