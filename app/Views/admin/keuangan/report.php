<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<div class="mb-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">
                <i class="fas fa-chart-line text-blue-600 mr-2"></i>Laporan Keuangan
            </h2>
            <p class="text-sm text-gray-600 mt-1">Analisis keuangan gereja tahun <?= $year ?></p>
        </div>
        <div class="flex gap-2">
            <form method="GET" class="flex gap-2">
                <select name="year" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <?php for ($y = date('Y'); $y >= date('Y') - 5; $y--): ?>
                        <option value="<?= $y ?>" <?= $year == $y ? 'selected' : '' ?>><?= $y ?></option>
                    <?php endfor; ?>
                </select>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    <i class="fas fa-filter mr-2"></i>Filter
                </button>
            </form>
            <a href="<?= base_url('admin/keuangan') ?>" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
        </div>
    </div>
</div>

<!-- Summary Cards -->
<?php
$totalIncome = array_sum(array_column($monthlyData, 'income'));
$totalExpense = array_sum(array_column($monthlyData, 'expense'));
$totalBalance = $totalIncome - $totalExpense;
?>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600 mb-1">Total Penerimaan</p>
                <p class="text-3xl font-bold text-green-600">Rp <?= number_format($totalIncome, 0, ',', '.') ?></p>
            </div>
            <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center">
                <i class="fas fa-arrow-down text-2xl text-green-600"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600 mb-1">Total Pengeluaran</p>
                <p class="text-3xl font-bold text-red-600">Rp <?= number_format($totalExpense, 0, ',', '.') ?></p>
            </div>
            <div class="w-12 h-12 rounded-full bg-red-100 flex items-center justify-center">
                <i class="fas fa-arrow-up text-2xl text-red-600"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600 mb-1">Saldo</p>
                <p class="text-3xl font-bold <?= $totalBalance >= 0 ? 'text-blue-600' : 'text-red-600' ?>">
                    Rp <?= number_format($totalBalance, 0, ',', '.') ?>
                </p>
            </div>
            <div class="w-12 h-12 rounded-full <?= $totalBalance >= 0 ? 'bg-blue-100' : 'bg-red-100' ?> flex items-center justify-center">
                <i class="fas fa-wallet text-2xl <?= $totalBalance >= 0 ? 'text-blue-600' : 'text-red-600' ?>"></i>
            </div>
        </div>
    </div>
</div>

<!-- Monthly Chart -->
<div class="bg-white rounded-lg shadow-md mb-6">
    <div class="p-6 border-b">
        <h3 class="text-lg font-semibold text-gray-800">
            <i class="fas fa-chart-bar mr-2"></i>Grafik Bulanan
        </h3>
    </div>
    <div class="p-6">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Bulan</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Penerimaan</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Pengeluaran</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Saldo</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php 
                    $months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                    foreach ($monthlyData as $data): 
                    ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">
                                <?= $months[$data['month'] - 1] ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-right text-green-600 font-semibold">
                                Rp <?= number_format($data['income'], 0, ',', '.') ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-right text-red-600 font-semibold">
                                Rp <?= number_format($data['expense'], 0, ',', '.') ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-bold <?= $data['balance'] >= 0 ? 'text-blue-600' : 'text-red-600' ?>">
                                Rp <?= number_format($data['balance'], 0, ',', '.') ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot class="bg-gray-50 font-bold">
                    <tr>
                        <td class="px-6 py-4 text-gray-800">TOTAL</td>
                        <td class="px-6 py-4 text-right text-green-600">
                            Rp <?= number_format($totalIncome, 0, ',', '.') ?>
                        </td>
                        <td class="px-6 py-4 text-right text-red-600">
                            Rp <?= number_format($totalExpense, 0, ',', '.') ?>
                        </td>
                        <td class="px-6 py-4 text-right <?= $totalBalance >= 0 ? 'text-blue-600' : 'text-red-600' ?>">
                            Rp <?= number_format($totalBalance, 0, ',', '.') ?>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<!-- Category Breakdown -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Income by Category -->
    <div class="bg-white rounded-lg shadow-md">
        <div class="p-6 border-b">
            <h3 class="text-lg font-semibold text-gray-800">
                <i class="fas fa-arrow-down text-green-600 mr-2"></i>Penerimaan per Kategori
            </h3>
        </div>
        <div class="p-6">
            <?php if (empty($incomeByCategory)): ?>
                <p class="text-gray-500 text-center py-8">Belum ada data penerimaan</p>
            <?php else: ?>
                <div class="space-y-4">
                    <?php foreach ($incomeByCategory as $item): ?>
                        <div class="flex items-center justify-between p-4 bg-green-50 rounded-lg">
                            <div>
                                <p class="font-semibold text-gray-800"><?= $item['category'] ?></p>
                                <p class="text-sm text-gray-600">
                                    <?= number_format(($item['total'] / $totalIncome) * 100, 1) ?>% dari total
                                </p>
                            </div>
                            <p class="text-lg font-bold text-green-600">
                                Rp <?= number_format($item['total'], 0, ',', '.') ?>
                            </p>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Expense by Category -->
    <div class="bg-white rounded-lg shadow-md">
        <div class="p-6 border-b">
            <h3 class="text-lg font-semibold text-gray-800">
                <i class="fas fa-arrow-up text-red-600 mr-2"></i>Pengeluaran per Kategori
            </h3>
        </div>
        <div class="p-6">
            <?php if (empty($expenseByCategory)): ?>
                <p class="text-gray-500 text-center py-8">Belum ada data pengeluaran</p>
            <?php else: ?>
                <div class="space-y-4">
                    <?php foreach ($expenseByCategory as $item): ?>
                        <div class="flex items-center justify-between p-4 bg-red-50 rounded-lg">
                            <div>
                                <p class="font-semibold text-gray-800"><?= $item['category'] ?></p>
                                <p class="text-sm text-gray-600">
                                    <?= number_format(($item['total'] / $totalExpense) * 100, 1) ?>% dari total
                                </p>
                            </div>
                            <p class="text-lg font-bold text-red-600">
                                Rp <?= number_format($item['total'], 0, ',', '.') ?>
                            </p>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
