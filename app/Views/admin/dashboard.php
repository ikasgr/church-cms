<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
    
    <!-- Total Jemaat -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm">Total Jemaat</p>
                <h3 class="text-3xl font-bold text-gray-800 mt-2"><?= $stats['total_jemaat'] ?></h3>
                <p class="text-sm text-green-600 mt-1">
                    <i class="fas fa-check-circle"></i> <?= $stats['active_jemaat'] ?> Aktif
                </p>
            </div>
            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                <i class="fas fa-users text-blue-600 text-xl"></i>
            </div>
        </div>
    </div>
    
    <!-- Saldo Keuangan -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm">Saldo Keuangan</p>
                <h3 class="text-3xl font-bold text-gray-800 mt-2">
                    Rp <?= number_format($stats['total_keuangan'], 0, ',', '.') ?>
                </h3>
                <p class="text-sm text-gray-500 mt-1">Total saldo</p>
            </div>
            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                <i class="fas fa-money-bill-wave text-green-600 text-xl"></i>
            </div>
        </div>
    </div>
    
    <!-- Kegiatan Mendatang -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm">Kegiatan Mendatang</p>
                <h3 class="text-3xl font-bold text-gray-800 mt-2"><?= $stats['upcoming_events'] ?></h3>
                <p class="text-sm text-gray-500 mt-1">Event terjadwal</p>
            </div>
            <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                <i class="fas fa-calendar-alt text-purple-600 text-xl"></i>
            </div>
        </div>
    </div>
    
    <!-- Pendaftaran Pending -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm">Pendaftaran Pending</p>
                <h3 class="text-3xl font-bold text-gray-800 mt-2"><?= $stats['pending_registration'] ?></h3>
                <p class="text-sm text-orange-600 mt-1">
                    <i class="fas fa-clock"></i> Menunggu approval
                </p>
            </div>
            <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center">
                <i class="fas fa-user-plus text-orange-600 text-xl"></i>
            </div>
        </div>
    </div>
    
</div>

<!-- Charts Row -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    
    <!-- Keuangan Bulan Ini -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Keuangan Bulan Ini</h3>
        <div class="space-y-4">
            <div>
                <div class="flex justify-between items-center mb-2">
                    <span class="text-sm text-gray-600">Pemasukan</span>
                    <span class="text-sm font-semibold text-green-600">
                        Rp <?= number_format($stats['this_month_income'], 0, ',', '.') ?>
                    </span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-green-500 h-2 rounded-full" style="width: 70%"></div>
                </div>
            </div>
            <div>
                <div class="flex justify-between items-center mb-2">
                    <span class="text-sm text-gray-600">Pengeluaran</span>
                    <span class="text-sm font-semibold text-red-600">
                        Rp <?= number_format($stats['this_month_expense'], 0, ',', '.') ?>
                    </span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-red-500 h-2 rounded-full" style="width: 45%"></div>
                </div>
            </div>
            <div class="pt-4 border-t">
                <div class="flex justify-between items-center">
                    <span class="text-sm font-semibold text-gray-800">Saldo</span>
                    <span class="text-sm font-bold text-blue-600">
                        Rp <?= number_format($stats['this_month_income'] - $stats['this_month_expense'], 0, ',', '.') ?>
                    </span>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Aktivitas Terbaru -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Aktivitas Terbaru</h3>
        <div class="space-y-4 max-h-64 overflow-y-auto">
            <?php foreach ($recent_activities as $activity): ?>
                <div class="flex items-start space-x-3">
                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-<?= $activity['icon'] ?> text-blue-600 text-sm"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm text-gray-800"><?= $activity['message'] ?></p>
                        <p class="text-xs text-gray-500 mt-1">
                            <i class="far fa-clock"></i> <?= date('d M Y H:i', strtotime($activity['date'])) ?>
                        </p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    
</div>

<!-- Upcoming Events -->
<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-semibold text-gray-800">Kegiatan Mendatang</h3>
        <a href="<?= base_url('admin/ibadah/kegiatan') ?>" class="text-sm text-blue-600 hover:text-blue-800">
            Lihat Semua <i class="fas fa-arrow-right ml-1"></i>
        </a>
    </div>
    
    <?php if (empty($upcoming_events)): ?>
        <p class="text-gray-500 text-center py-8">Tidak ada kegiatan mendatang</p>
    <?php else: ?>
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr class="border-b">
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Kegiatan</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Kategori</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Tanggal</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Lokasi</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($upcoming_events as $event): ?>
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-3 px-4">
                                <a href="<?= base_url('admin/ibadah/kegiatan/view/' . $event['id']) ?>" 
                                   class="text-blue-600 hover:text-blue-800 font-medium">
                                    <?= $event['title'] ?>
                                </a>
                            </td>
                            <td class="py-3 px-4">
                                <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">
                                    <?= ucfirst($event['category']) ?>
                                </span>
                            </td>
                            <td class="py-3 px-4 text-sm text-gray-600">
                                <?= date('d M Y', strtotime($event['date_start'])) ?>
                            </td>
                            <td class="py-3 px-4 text-sm text-gray-600">
                                <?= $event['location'] ?>
                            </td>
                            <td class="py-3 px-4">
                                <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">
                                    <i class="fas fa-check-circle"></i> Aktif
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>
