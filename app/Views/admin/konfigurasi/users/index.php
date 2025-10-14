<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
    <div>
        <h2 class="text-xl font-semibold text-gray-800">Manajemen User</h2>
        <p class="text-sm text-gray-600 mt-1">Kelola akses user admin</p>
    </div>
    <a href="<?= base_url('admin/konfigurasi/users/create') ?>" 
       class="mt-4 md:mt-0 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
        <i class="fas fa-plus mr-2"></i>Tambah User
    </a>
</div>

<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">User</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Role</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Last Login</th>
                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            <?php foreach ($users as $u): ?>
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                <i class="fas fa-user text-blue-600"></i>
                            </div>
                            <div>
                                <div class="text-sm font-medium text-gray-900"><?= $u['full_name'] ?></div>
                                <div class="text-sm text-gray-500">@<?= $u['username'] ?></div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-900"><?= $u['email'] ?></td>
                    <td class="px-6 py-4">
                        <?php
                        $roleColors = [
                            'admin' => 'bg-red-100 text-red-800',
                            'editor' => 'bg-blue-100 text-blue-800',
                            'viewer' => 'bg-gray-100 text-gray-800',
                        ];
                        ?>
                        <span class="px-2 py-1 text-xs font-semibold rounded-full <?= $roleColors[$u['role']] ?>">
                            <?= ucfirst($u['role']) ?>
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <?php if ($u['is_active']): ?>
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                <i class="fas fa-check-circle"></i> Aktif
                            </span>
                        <?php else: ?>
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                                <i class="fas fa-ban"></i> Non-Aktif
                            </span>
                        <?php endif; ?>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500">
                        <?= $u['last_login'] ? date('d M Y H:i', strtotime($u['last_login'])) : '-' ?>
                    </td>
                    <td class="px-6 py-4 text-right text-sm font-medium">
                        <div class="flex justify-end gap-2">
                            <a href="<?= base_url('admin/konfigurasi/users/edit/' . $u['id']) ?>" 
                               class="text-green-600 hover:text-green-900" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="<?= base_url('admin/konfigurasi/users/toggle-active/' . $u['id']) ?>" 
                               class="text-blue-600 hover:text-blue-900" 
                               title="<?= $u['is_active'] ? 'Nonaktifkan' : 'Aktifkan' ?>">
                                <i class="fas fa-<?= $u['is_active'] ? 'ban' : 'check' ?>"></i>
                            </a>
                            <?php if ($u['id'] != session()->get('userId')): ?>
                                <a href="<?= base_url('admin/konfigurasi/users/delete/' . $u['id']) ?>" 
                                   onclick="return confirm('Yakin ingin menghapus user ini?')"
                                   class="text-red-600 hover:text-red-900" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </a>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>
