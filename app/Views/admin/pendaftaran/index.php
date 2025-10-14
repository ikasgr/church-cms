<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
    <div>
        <h2 class="text-xl font-semibold text-gray-800">Pendaftaran Online</h2>
        <p class="text-sm text-gray-600 mt-1">Kelola pendaftaran baptis, sidi, dan nikah</p>
    </div>
    <div class="flex gap-2 mt-4 md:mt-0">
        <div class="relative inline-block text-left">
            <button type="button" onclick="toggleDropdown()" 
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                <i class="fas fa-plus mr-2"></i>Tambah Pendaftaran
                <i class="fas fa-chevron-down ml-2"></i>
            </button>
            <div id="dropdownMenu" class="hidden absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-10">
                <div class="py-1">
                    <a href="<?= base_url('admin/pendaftaran/baptis/create') ?>" 
                       class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        <i class="fas fa-water text-blue-600 mr-2"></i>Baptis
                    </a>
                    <a href="<?= base_url('admin/pendaftaran/sidi/create') ?>" 
                       class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        <i class="fas fa-cross text-purple-600 mr-2"></i>Sidi
                    </a>
                    <a href="<?= base_url('admin/pendaftaran/nikah/create') ?>" 
                       class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        <i class="fas fa-rings-wedding text-pink-600 mr-2"></i>Nikah
                    </a>
                </div>
            </div>
        </div>
        <a href="<?= base_url('admin/pendaftaran/export') ?>" 
           class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
            <i class="fas fa-file-excel mr-2"></i>Export
        </a>
    </div>
</div>

<script>
function toggleDropdown() {
    document.getElementById('dropdownMenu').classList.toggle('hidden');
}
// Close dropdown when clicking outside
window.onclick = function(event) {
    if (!event.target.matches('button')) {
        var dropdowns = document.getElementsByClassName("absolute");
        for (var i = 0; i < dropdowns.length; i++) {
            var openDropdown = dropdowns[i];
            if (!openDropdown.classList.contains('hidden')) {
                openDropdown.classList.add('hidden');
            }
        }
    }
}
</script>

<!-- Filter -->
<div class="bg-white rounded-lg shadow-md p-4 mb-6">
    <form method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <select name="type" class="px-4 py-2 border border-gray-300 rounded-lg">
            <option value="">Semua Tipe</option>
            <option value="baptis" <?= ($type ?? '') == 'baptis' ? 'selected' : '' ?>>Baptis</option>
            <option value="sidi" <?= ($type ?? '') == 'sidi' ? 'selected' : '' ?>>Sidi</option>
            <option value="nikah" <?= ($type ?? '') == 'nikah' ? 'selected' : '' ?>>Nikah</option>
        </select>
        
        <select name="status" class="px-4 py-2 border border-gray-300 rounded-lg">
            <option value="">Semua Status</option>
            <option value="pending" <?= ($status ?? '') == 'pending' ? 'selected' : '' ?>>Pending</option>
            <option value="approved" <?= ($status ?? '') == 'approved' ? 'selected' : '' ?>>Approved</option>
            <option value="rejected" <?= ($status ?? '') == 'rejected' ? 'selected' : '' ?>>Rejected</option>
        </select>
        
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
            <i class="fas fa-filter mr-2"></i>Filter
        </button>
    </form>
</div>

<!-- Table -->
<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <table class="min-w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tipe</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            <?php if (empty($registrations)): ?>
                <tr>
                    <td colspan="5" class="px-6 py-8 text-center text-gray-500">Tidak ada pendaftaran</td>
                </tr>
            <?php else: ?>
                <?php foreach ($registrations as $r): ?>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm"><?= date('d M Y', strtotime($r['created_at'])) ?></td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">
                                <?= ucfirst($r['type']) ?>
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm"><?= $r['full_name'] ?></td>
                        <td class="px-6 py-4">
                            <?php if ($r['status'] == 'pending'): ?>
                                <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                            <?php elseif ($r['status'] == 'approved'): ?>
                                <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Approved</span>
                            <?php else: ?>
                                <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800">Rejected</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="<?= base_url('admin/pendaftaran/view/' . $r['id']) ?>" 
                               class="text-blue-600 hover:text-blue-900 mr-3">
                                <i class="fas fa-eye"></i>
                            </a>
                            <?php if ($r['status'] == 'pending'): ?>
                                <a href="<?= base_url('admin/pendaftaran/approve/' . $r['id']) ?>" 
                                   class="text-green-600 hover:text-green-900 mr-3">
                                    <i class="fas fa-check"></i>
                                </a>
                                <a href="<?= base_url('admin/pendaftaran/reject/' . $r['id']) ?>" 
                                   class="text-red-600 hover:text-red-900">
                                    <i class="fas fa-times"></i>
                                </a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>
