<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<!-- Header Actions -->
<div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
    <div>
        <h2 class="text-xl font-semibold text-gray-800">Keuangan Gereja</h2>
        <p class="text-sm text-gray-600 mt-1">Kelola transaksi keuangan gereja</p>
    </div>
    <div class="flex gap-2 mt-4 md:mt-0">
        <a href="<?= base_url('admin/keuangan/report') ?>" 
           class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">
            <i class="fas fa-chart-line mr-2"></i>Laporan
        </a>
        <a href="<?= base_url('admin/keuangan/export?month=' . $month . '&year=' . $year) ?>" 
           class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
            <i class="fas fa-file-excel mr-2"></i>Export
        </a>
        <a href="<?= base_url('admin/keuangan/create') ?>" 
           class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
            <i class="fas fa-plus mr-2"></i>Tambah Transaksi
        </a>
    </div>
</div>

<!-- Summary Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
    <!-- Total Pemasukan -->
    <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-lg shadow-md p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-green-100 text-sm">Pemasukan Bulan Ini</p>
                <h3 class="text-2xl font-bold mt-2">Rp <?= number_format($totalIncome, 0, ',', '.') ?></h3>
            </div>
            <div class="w-12 h-12 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                <i class="fas fa-arrow-down text-2xl"></i>
            </div>
        </div>
    </div>
    
    <!-- Total Pengeluaran -->
    <div class="bg-gradient-to-br from-red-500 to-red-600 rounded-lg shadow-md p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-red-100 text-sm">Pengeluaran Bulan Ini</p>
                <h3 class="text-2xl font-bold mt-2">Rp <?= number_format($totalExpense, 0, ',', '.') ?></h3>
            </div>
            <div class="w-12 h-12 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                <i class="fas fa-arrow-up text-2xl"></i>
            </div>
        </div>
    </div>
    
    <!-- Saldo -->
    <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg shadow-md p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-blue-100 text-sm">Saldo Bulan Ini</p>
                <h3 class="text-2xl font-bold mt-2">Rp <?= number_format($balance, 0, ',', '.') ?></h3>
            </div>
            <div class="w-12 h-12 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                <i class="fas fa-wallet text-2xl"></i>
            </div>
        </div>
    </div>
</div>

<!-- Filter -->
<div class="bg-white rounded-lg shadow-md p-6 mb-6">
    <form method="GET" action="<?= base_url('admin/keuangan') ?>">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <!-- Tipe -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tipe Transaksi</label>
                <select name="type" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option value="">Semua Tipe</option>
                    <option value="penerimaan" <?= ($type ?? '') == 'penerimaan' ? 'selected' : '' ?>>Penerimaan</option>
                    <option value="pengeluaran" <?= ($type ?? '') == 'pengeluaran' ? 'selected' : '' ?>>Pengeluaran</option>
                </select>
            </div>
            
            <!-- Bulan -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Bulan</label>
                <select name="month" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <?php for ($m = 1; $m <= 12; $m++): ?>
                        <option value="<?= str_pad($m, 2, '0', STR_PAD_LEFT) ?>" <?= $month == str_pad($m, 2, '0', STR_PAD_LEFT) ? 'selected' : '' ?>>
                            <?= date('F', mktime(0, 0, 0, $m, 1)) ?>
                        </option>
                    <?php endfor; ?>
                </select>
            </div>
            
            <!-- Tahun -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tahun</label>
                <select name="year" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <?php for ($y = date('Y'); $y >= date('Y') - 5; $y--): ?>
                        <option value="<?= $y ?>" <?= $year == $y ? 'selected' : '' ?>><?= $y ?></option>
                    <?php endfor; ?>
                </select>
            </div>
            
            <!-- Button -->
            <div class="flex items-end">
                <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    <i class="fas fa-filter mr-2"></i>Filter
                </button>
            </div>
        </div>
    </form>
</div>

<!-- Transactions Table -->
<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tipe</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kategori</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Deskripsi</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Jumlah</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php if (empty($transactions)): ?>
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                            <i class="fas fa-inbox text-4xl mb-2"></i>
                            <p>Tidak ada transaksi</p>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($transactions as $t): ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <?= date('d M Y', strtotime($t['transaction_date'])) ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php if ($t['type'] == 'penerimaan'): ?>
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                        <i class="fas fa-arrow-down mr-1"></i>Penerimaan
                                    </span>
                                <?php else: ?>
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                        <i class="fas fa-arrow-up mr-1"></i>Pengeluaran
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <?= ucfirst($t['category']) ?>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900">
                                <?= $t['description'] ?>
                                <?php if ($t['source']): ?>
                                    <span class="text-gray-500 text-xs block">Sumber: <?= $t['source'] ?></span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <span class="text-sm font-semibold <?= $t['type'] == 'penerimaan' ? 'text-green-600' : 'text-red-600' ?>">
                                    Rp <?= number_format($t['amount'], 0, ',', '.') ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end gap-2">
                                    <a href="<?= base_url('admin/keuangan/view/' . $t['id']) ?>" 
                                       class="text-blue-600 hover:text-blue-900" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="<?= base_url('admin/keuangan/edit/' . $t['id']) ?>" 
                                       class="text-green-600 hover:text-green-900" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="<?= base_url('admin/keuangan/delete/' . $t['id']) ?>" 
                                       onclick="return confirm('Yakin ingin menghapus transaksi ini?')"
                                       class="text-red-600 hover:text-red-900" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>
