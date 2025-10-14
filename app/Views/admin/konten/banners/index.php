<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<div class="mb-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">
                <i class="fas fa-image text-blue-600 mr-2"></i>Kelola Banner
            </h2>
            <p class="text-sm text-gray-600 mt-1">Kelola banner dan slider website</p>
        </div>
        <a href="<?= base_url('admin/konten/banners/create') ?>" 
           class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
            <i class="fas fa-plus mr-2"></i>Tambah Banner
        </a>
    </div>
</div>

<?php if (session()->getFlashdata('success')): ?>
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
        <i class="fas fa-check-circle mr-2"></i><?= session()->getFlashdata('success') ?>
    </div>
<?php endif; ?>

<!-- Statistics -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
    <?php
    $totalBanners = count($banners);
    $activeBanners = count(array_filter($banners, fn($b) => $b['is_active']));
    $homeSliders = count(array_filter($banners, fn($b) => $b['position'] == 'home_slider'));
    $sidebarBanners = count(array_filter($banners, fn($b) => $b['position'] == 'sidebar'));
    ?>
    
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600 mb-1">Total Banner</p>
                <p class="text-3xl font-bold text-blue-600"><?= $totalBanners ?></p>
            </div>
            <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center">
                <i class="fas fa-image text-2xl text-blue-600"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600 mb-1">Banner Aktif</p>
                <p class="text-3xl font-bold text-green-600"><?= $activeBanners ?></p>
            </div>
            <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center">
                <i class="fas fa-check-circle text-2xl text-green-600"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600 mb-1">Home Slider</p>
                <p class="text-3xl font-bold text-purple-600"><?= $homeSliders ?></p>
            </div>
            <div class="w-12 h-12 rounded-full bg-purple-100 flex items-center justify-center">
                <i class="fas fa-sliders-h text-2xl text-purple-600"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600 mb-1">Sidebar</p>
                <p class="text-3xl font-bold text-orange-600"><?= $sidebarBanners ?></p>
            </div>
            <div class="w-12 h-12 rounded-full bg-orange-100 flex items-center justify-center">
                <i class="fas fa-columns text-2xl text-orange-600"></i>
            </div>
        </div>
    </div>
</div>

<!-- Banners List -->
<?php if (empty($banners)): ?>
    <div class="bg-white rounded-lg shadow-md p-12 text-center">
        <i class="fas fa-image text-6xl text-gray-300 mb-4"></i>
        <p class="text-gray-500 mb-4">Belum ada banner</p>
        <a href="<?= base_url('admin/konten/banners/create') ?>" 
           class="inline-block px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
            <i class="fas fa-plus mr-2"></i>Tambah Banner
        </a>
    </div>
<?php else: ?>
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Banner
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Posisi
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Periode
                        </th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Urutan
                        </th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php foreach ($banners as $banner): ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <?php if ($banner['image']): ?>
                                        <img src="<?= base_url('uploads/banners/' . $banner['image']) ?>" 
                                             alt="<?= $banner['title'] ?>"
                                             class="w-20 h-12 object-cover rounded">
                                    <?php else: ?>
                                        <div class="w-20 h-12 bg-gray-200 rounded flex items-center justify-center">
                                            <i class="fas fa-image text-gray-400"></i>
                                        </div>
                                    <?php endif; ?>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900"><?= $banner['title'] ?></div>
                                        <?php if ($banner['description']): ?>
                                            <div class="text-sm text-gray-500"><?= substr($banner['description'], 0, 50) ?><?= strlen($banner['description']) > 50 ? '...' : '' ?></div>
                                        <?php endif; ?>
                                        <?php if ($banner['link']): ?>
                                            <div class="text-xs text-blue-600 mt-1">
                                                <i class="fas fa-link mr-1"></i><?= substr($banner['link'], 0, 40) ?>...
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php
                                $positionLabels = [
                                    'home_slider' => ['label' => 'Home Slider', 'color' => 'bg-purple-100 text-purple-800'],
                                    'sidebar' => ['label' => 'Sidebar', 'color' => 'bg-orange-100 text-orange-800'],
                                    'header' => ['label' => 'Header', 'color' => 'bg-blue-100 text-blue-800'],
                                    'footer' => ['label' => 'Footer', 'color' => 'bg-gray-100 text-gray-800']
                                ];
                                $position = $positionLabels[$banner['position']] ?? ['label' => $banner['position'], 'color' => 'bg-gray-100 text-gray-800'];
                                ?>
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?= $position['color'] ?>">
                                    <?= $position['label'] ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                <div><?= date('d M Y', strtotime($banner['start_date'])) ?></div>
                                <div class="text-xs text-gray-500">s/d <?= date('d M Y', strtotime($banner['end_date'])) ?></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                                    <?= $banner['order_position'] ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <?php if ($banner['is_active']): ?>
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
                                    <a href="<?= base_url('admin/konten/banners/edit/' . $banner['id']) ?>" 
                                       class="text-blue-600 hover:text-blue-900"
                                       title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="<?= base_url('admin/konten/banners/delete/' . $banner['id']) ?>" 
                                       onclick="return confirm('Yakin ingin menghapus banner ini?')"
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
