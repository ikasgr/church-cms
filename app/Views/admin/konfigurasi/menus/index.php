<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
    <div>
        <h2 class="text-xl font-semibold text-gray-800">Pengaturan Menu</h2>
        <p class="text-sm text-gray-600 mt-1">Kelola menu navigasi website</p>
    </div>
    <a href="<?= base_url('admin/konfigurasi/menus/create') ?>" 
       class="mt-4 md:mt-0 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
        <i class="fas fa-plus mr-2"></i>Tambah Menu
    </a>
</div>

<?php if (session()->getFlashdata('success')): ?>
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
        <i class="fas fa-check-circle mr-2"></i><?= session()->getFlashdata('success') ?>
    </div>
<?php endif; ?>

<!-- Position Tabs -->
<div class="bg-white rounded-lg shadow-md mb-6">
    <div class="border-b border-gray-200">
        <nav class="flex -mb-px">
            <a href="<?= base_url('admin/konfigurasi/menus?position=header') ?>" 
               class="px-6 py-3 border-b-2 <?= $position == 'header' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700' ?> font-medium text-sm">
                <i class="fas fa-bars mr-2"></i>Header
            </a>
            <a href="<?= base_url('admin/konfigurasi/menus?position=footer') ?>" 
               class="px-6 py-3 border-b-2 <?= $position == 'footer' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700' ?> font-medium text-sm">
                <i class="fas fa-th mr-2"></i>Footer
            </a>
            <a href="<?= base_url('admin/konfigurasi/menus?position=sidebar') ?>" 
               class="px-6 py-3 border-b-2 <?= $position == 'sidebar' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700' ?> font-medium text-sm">
                <i class="fas fa-list mr-2"></i>Sidebar
            </a>
        </nav>
    </div>
</div>

<!-- Menu List -->
<?php if (empty($menus)): ?>
    <div class="bg-white rounded-lg shadow-md p-12 text-center">
        <i class="fas fa-bars text-6xl text-gray-300 mb-4"></i>
        <p class="text-gray-500 mb-4">Belum ada menu untuk posisi ini</p>
        <a href="<?= base_url('admin/konfigurasi/menus/create') ?>" 
           class="inline-block px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
            <i class="fas fa-plus mr-2"></i>Tambah Menu
        </a>
    </div>
<?php else: ?>
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Menu
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            URL
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Parent
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Urutan
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Target
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php foreach ($menus as $menu): ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <?php if ($menu['icon']): ?>
                                        <i class="<?= $menu['icon'] ?> text-gray-400 mr-2"></i>
                                    <?php endif; ?>
                                    <span class="text-sm font-medium text-gray-900"><?= $menu['title'] ?></span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-600 truncate max-w-xs">
                                    <?= $menu['url'] ?: '-' ?>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php if ($menu['parent_id']): ?>
                                    <span class="text-sm text-gray-600">
                                        <i class="fas fa-level-up-alt mr-1"></i>Sub Menu
                                    </span>
                                <?php else: ?>
                                    <span class="text-sm text-gray-400">-</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                                    <?= $menu['order_position'] ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm text-gray-600">
                                    <?= $menu['target'] == '_blank' ? 'Tab Baru' : 'Tab Sama' ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php if ($menu['is_active']): ?>
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        <i class="fas fa-check-circle mr-1"></i>Aktif
                                    </span>
                                <?php else: ?>
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                        <i class="fas fa-times-circle mr-1"></i>Non-Aktif
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end gap-2">
                                    <a href="<?= base_url('admin/konfigurasi/menus/edit/' . $menu['id']) ?>" 
                                       class="text-blue-600 hover:text-blue-900"
                                       title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="<?= base_url('admin/konfigurasi/menus/delete/' . $menu['id']) ?>" 
                                       onclick="return confirm('Yakin ingin menghapus menu ini?')"
                                       class="text-red-600 hover:text-red-900"
                                       title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php endif; ?>

<?= $this->endSection() ?>
