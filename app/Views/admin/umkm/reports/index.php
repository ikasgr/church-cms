<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-800">
        <i class="fas fa-chart-line text-blue-600 mr-2"></i>Laporan Penjualan UMKM
    </h2>
    <p class="text-sm text-gray-600 mt-1">Analisis dan statistik penjualan</p>
</div>

<!-- Summary Cards -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
    <?php
    $totalOrders = 0;
    $totalSales = 0;
    foreach ($daily_sales as $sale) {
        $totalOrders += $sale['total_orders'];
        $totalSales += $sale['total_sales'];
    }
    ?>
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600 mb-1">Total Pesanan (30 Hari)</p>
                <p class="text-3xl font-bold text-blue-600"><?= number_format($totalOrders) ?></p>
            </div>
            <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center">
                <i class="fas fa-shopping-cart text-2xl text-blue-600"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600 mb-1">Total Penjualan (30 Hari)</p>
                <p class="text-3xl font-bold text-green-600">Rp <?= number_format($totalSales, 0, ',', '.') ?></p>
            </div>
            <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center">
                <i class="fas fa-money-bill-wave text-2xl text-green-600"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600 mb-1">Rata-rata per Pesanan</p>
                <p class="text-3xl font-bold text-purple-600">
                    Rp <?= $totalOrders > 0 ? number_format($totalSales / $totalOrders, 0, ',', '.') : 0 ?>
                </p>
            </div>
            <div class="w-12 h-12 rounded-full bg-purple-100 flex items-center justify-center">
                <i class="fas fa-calculator text-2xl text-purple-600"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600 mb-1">Total Pelapak Aktif</p>
                <p class="text-3xl font-bold text-orange-600"><?= count($seller_sales) ?></p>
            </div>
            <div class="w-12 h-12 rounded-full bg-orange-100 flex items-center justify-center">
                <i class="fas fa-store text-2xl text-orange-600"></i>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Daily Sales Chart -->
    <div class="bg-white rounded-lg shadow-md">
        <div class="p-6 border-b">
            <h3 class="text-lg font-semibold text-gray-800">
                <i class="fas fa-chart-bar mr-2"></i>Penjualan Harian (30 Hari Terakhir)
            </h3>
        </div>
        <div class="p-6">
            <?php if (empty($daily_sales)): ?>
                <p class="text-gray-500 text-center py-8">Belum ada data penjualan</p>
            <?php else: ?>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                                <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Pesanan</th>
                                <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Total</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php foreach (array_slice($daily_sales, 0, 10) as $sale): ?>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 text-sm text-gray-800">
                                        <?= date('d M Y', strtotime($sale['date'])) ?>
                                    </td>
                                    <td class="px-4 py-3 text-sm text-right">
                                        <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full font-semibold">
                                            <?= $sale['total_orders'] ?>
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-sm text-right font-semibold text-gray-800">
                                        Rp <?= number_format($sale['total_sales'], 0, ',', '.') ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Top Sellers -->
    <div class="bg-white rounded-lg shadow-md">
        <div class="p-6 border-b">
            <h3 class="text-lg font-semibold text-gray-800">
                <i class="fas fa-trophy mr-2"></i>Top Pelapak
            </h3>
        </div>
        <div class="p-6">
            <?php if (empty($seller_sales)): ?>
                <p class="text-gray-500 text-center py-8">Belum ada data penjualan</p>
            <?php else: ?>
                <div class="space-y-4">
                    <?php 
                    $rank = 1;
                    foreach ($seller_sales as $seller): 
                        $rankColors = [
                            1 => 'bg-yellow-100 text-yellow-800',
                            2 => 'bg-gray-100 text-gray-800',
                            3 => 'bg-orange-100 text-orange-800'
                        ];
                        $rankColor = $rankColors[$rank] ?? 'bg-blue-100 text-blue-800';
                    ?>
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full <?= $rankColor ?> flex items-center justify-center font-bold">
                                    <?php if ($rank <= 3): ?>
                                        <i class="fas fa-trophy"></i>
                                    <?php else: ?>
                                        <?= $rank ?>
                                    <?php endif; ?>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-800"><?= $seller['business_name'] ?></p>
                                    <p class="text-sm text-gray-600"><?= $seller['total_orders'] ?> pesanan</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="font-bold text-green-600">
                                    Rp <?= number_format($seller['total_income'], 0, ',', '.') ?>
                                </p>
                            </div>
                        </div>
                    <?php 
                        $rank++;
                    endforeach; 
                    ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Detailed Sales Table -->
<div class="bg-white rounded-lg shadow-md mt-6">
    <div class="p-6 border-b flex items-center justify-between">
        <h3 class="text-lg font-semibold text-gray-800">
            <i class="fas fa-table mr-2"></i>Detail Penjualan per Pelapak
        </h3>
        <button onclick="exportToCSV()" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
            <i class="fas fa-file-excel mr-2"></i>Export CSV
        </button>
    </div>
    <div class="p-6">
        <?php if (empty($seller_sales)): ?>
            <p class="text-gray-500 text-center py-8">Belum ada data penjualan</p>
        <?php else: ?>
            <div class="overflow-x-auto">
                <table id="salesTable" class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pelapak</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Total Pesanan</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Total Pendapatan</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Rata-rata</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach ($seller_sales as $seller): ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <i class="fas fa-store text-blue-600 mr-2"></i>
                                        <span class="font-medium text-gray-800"><?= $seller['business_name'] ?></span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-semibold">
                                        <?= $seller['total_orders'] ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right font-semibold text-gray-800">
                                    Rp <?= number_format($seller['total_income'], 0, ',', '.') ?>
                                </td>
                                <td class="px-6 py-4 text-right text-gray-600">
                                    Rp <?= number_format($seller['total_income'] / $seller['total_orders'], 0, ',', '.') ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot class="bg-gray-50 font-bold">
                        <tr>
                            <td class="px-6 py-4 text-gray-800">TOTAL</td>
                            <td class="px-6 py-4 text-right text-gray-800">
                                <?= array_sum(array_column($seller_sales, 'total_orders')) ?>
                            </td>
                            <td class="px-6 py-4 text-right text-green-600">
                                Rp <?= number_format(array_sum(array_column($seller_sales, 'total_income')), 0, ',', '.') ?>
                            </td>
                            <td class="px-6 py-4"></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
function exportToCSV() {
    const table = document.getElementById('salesTable');
    let csv = [];
    
    // Headers
    const headers = [];
    table.querySelectorAll('thead th').forEach(th => {
        headers.push(th.textContent.trim());
    });
    csv.push(headers.join(','));
    
    // Rows
    table.querySelectorAll('tbody tr').forEach(tr => {
        const row = [];
        tr.querySelectorAll('td').forEach(td => {
            row.push('"' + td.textContent.trim().replace(/"/g, '""') + '"');
        });
        csv.push(row.join(','));
    });
    
    // Download
    const csvContent = csv.join('\n');
    const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
    const link = document.createElement('a');
    link.href = URL.createObjectURL(blob);
    link.download = 'laporan_penjualan_umkm_' + new Date().toISOString().split('T')[0] + '.csv';
    link.click();
}
</script>

<?= $this->endSection() ?>
