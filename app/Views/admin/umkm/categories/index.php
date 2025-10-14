<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
    <div>
        <h2 class="text-xl font-semibold text-gray-800">Kategori Produk</h2>
        <p class="text-sm text-gray-600 mt-1">Kelola kategori produk UMKM</p>
    </div>
    <a href="<?= base_url('admin/umkm/categories/create') ?>" 
       class="mt-4 md:mt-0 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
        <i class="fas fa-plus mr-2"></i>Tambah Kategori
    </a>
</div>

<?php if (empty($categories)): ?>
    <div class="bg-white rounded-lg shadow-md p-12 text-center">
        <i class="fas fa-tags text-6xl text-gray-300 mb-4"></i>
        <p class="text-gray-500 mb-4">Belum ada kategori</p>
        <a href="<?= base_url('admin/umkm/categories/create') ?>" 
           class="inline-block px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
            <i class="fas fa-plus mr-2"></i>Tambah Kategori
        </a>
    </div>
<?php else: ?>
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Kategori
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Slug
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Jumlah Produk
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Urutan
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
                    <?php foreach ($categories as $category): ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <?php if ($category['icon']): ?>
                                        <i class="<?= $category['icon'] ?> text-2xl text-blue-600 mr-3"></i>
                                    <?php endif; ?>
                                    <div>
                                        <div class="text-sm font-medium text-gray-900"><?= $category['name'] ?></div>
                                        <?php if ($category['description']): ?>
                                            <div class="text-sm text-gray-500"><?= substr($category['description'], 0, 50) ?><?= strlen($category['description']) > 50 ? '...' : '' ?></div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <code class="text-sm bg-gray-100 px-2 py-1 rounded"><?= $category['slug'] ?></code>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 text-sm font-semibold rounded-full bg-blue-100 text-blue-800">
                                    <?= $category['product_count'] ?? 0 ?> produk
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                                    <?= $category['order_position'] ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php if ($category['is_active']): ?>
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
                                    <a href="<?= base_url('admin/umkm/categories/edit/' . $category['id']) ?>" 
                                       class="text-blue-600 hover:text-blue-900"
                                       title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="<?= base_url('admin/umkm/categories/delete/' . $category['id']) ?>" 
                                       onclick="return confirm('Yakin ingin menghapus kategori ini?')"
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
