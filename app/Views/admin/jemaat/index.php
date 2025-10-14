<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<!-- Header Actions -->
<div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
    <div>
        <h2 class="text-xl font-semibold text-gray-800">Data Jemaat</h2>
        <p class="text-sm text-gray-600 mt-1">Kelola data anggota jemaat</p>
    </div>
    <div class="flex gap-2 mt-4 md:mt-0">
        <a href="<?= base_url('admin/jemaat/export') ?>" 
           class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
            <i class="fas fa-file-excel mr-2"></i>Export CSV
        </a>
        <a href="<?= base_url('admin/jemaat/create') ?>" 
           class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
            <i class="fas fa-plus mr-2"></i>Tambah Jemaat
        </a>
    </div>
</div>

<!-- Search & Filter -->
<div class="bg-white rounded-lg shadow-md p-6 mb-6" x-data="{ showFilter: false }">
    <form method="GET" action="<?= base_url('admin/jemaat') ?>">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <!-- Search -->
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Pencarian</label>
                <input type="text" 
                       name="keyword" 
                       value="<?= $keyword ?? '' ?>"
                       placeholder="Cari nama, no induk, atau email..."
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            
            <!-- Wilayah -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Wilayah</label>
                <select name="wilayah" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option value="">Semua Wilayah</option>
                    <?php foreach ($wilayah_list as $w): ?>
                        <option value="<?= $w['wilayah'] ?>" <?= ($wilayah ?? '') == $w['wilayah'] ? 'selected' : '' ?>>
                            <?= $w['wilayah'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <!-- Status -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option value="">Semua Status</option>
                    <option value="aktif" <?= ($status ?? '') == 'aktif' ? 'selected' : '' ?>>Aktif</option>
                    <option value="pindah" <?= ($status ?? '') == 'pindah' ? 'selected' : '' ?>>Pindah</option>
                    <option value="meninggal" <?= ($status ?? '') == 'meninggal' ? 'selected' : '' ?>>Meninggal</option>
                    <option value="non-aktif" <?= ($status ?? '') == 'non-aktif' ? 'selected' : '' ?>>Non-Aktif</option>
                </select>
            </div>
        </div>
        
        <div class="flex gap-2 mt-4">
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                <i class="fas fa-search mr-2"></i>Cari
            </button>
            <a href="<?= base_url('admin/jemaat') ?>" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition">
                <i class="fas fa-redo mr-2"></i>Reset
            </a>
        </div>
    </form>
</div>

<!-- Data Table -->
<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No Induk</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Lengkap</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">JK</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Wilayah</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Telepon</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php if (empty($jemaat)): ?>
                    <tr>
                        <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                            <i class="fas fa-inbox text-4xl mb-2"></i>
                            <p>Tidak ada data jemaat</p>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($jemaat as $j): ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm font-medium text-gray-900"><?= $j['no_induk'] ?></span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <?php if ($j['photo']): ?>
                                        <img src="<?= base_url('uploads/jemaat/' . $j['photo']) ?>" 
                                             class="w-10 h-10 rounded-full object-cover mr-3"
                                             alt="<?= $j['full_name'] ?>">
                                    <?php else: ?>
                                        <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center mr-3">
                                            <i class="fas fa-user text-blue-600"></i>
                                        </div>
                                    <?php endif; ?>
                                    <div>
                                        <div class="text-sm font-medium text-gray-900"><?= $j['full_name'] ?></div>
                                        <div class="text-sm text-gray-500"><?= $j['email'] ?></div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm text-gray-900"><?= $j['gender'] ?></span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm text-gray-900"><?= $j['wilayah'] ?></span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm text-gray-900"><?= $j['phone'] ?></span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php
                                $statusColors = [
                                    'aktif' => 'bg-green-100 text-green-800',
                                    'pindah' => 'bg-yellow-100 text-yellow-800',
                                    'meninggal' => 'bg-red-100 text-red-800',
                                    'non-aktif' => 'bg-gray-100 text-gray-800',
                                ];
                                $colorClass = $statusColors[$j['status']] ?? 'bg-gray-100 text-gray-800';
                                ?>
                                <span class="px-2 py-1 text-xs font-semibold rounded-full <?= $colorClass ?>">
                                    <?= ucfirst($j['status']) ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end gap-2">
                                    <a href="<?= base_url('admin/jemaat/view/' . $j['id']) ?>" 
                                       class="text-blue-600 hover:text-blue-900" title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="<?= base_url('admin/jemaat/edit/' . $j['id']) ?>" 
                                       class="text-green-600 hover:text-green-900" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="<?= base_url('admin/jemaat/delete/' . $j['id']) ?>" 
                                       onclick="return confirm('Yakin ingin menghapus data ini?')"
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
    
    <!-- Pagination -->
    <?php if (!empty($jemaat)): ?>
        <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
            <?= $pager->links() ?>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>
