<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<div class="mb-6">
    <div class="flex items-center gap-2 text-sm text-gray-600 mb-4">
        <a href="<?= base_url('admin/jemaat/families') ?>" class="hover:text-blue-600">
            <i class="fas fa-home"></i> Data Keluarga
        </a>
        <i class="fas fa-chevron-right text-xs"></i>
        <span class="text-gray-800">Detail Keluarga</span>
    </div>
    <div class="flex items-center justify-between">
        <h2 class="text-2xl font-bold text-gray-800">
            <i class="fas fa-home text-blue-600 mr-2"></i><?= $family['family_name'] ?>
        </h2>
        <div class="flex gap-2">
            <a href="<?= base_url('admin/jemaat/families/edit/' . $family['id']) ?>" 
               class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                <i class="fas fa-edit mr-2"></i>Edit
            </a>
            <a href="<?= base_url('admin/jemaat/families/delete/' . $family['id']) ?>" 
               onclick="return confirm('Yakin ingin menghapus keluarga ini?')"
               class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                <i class="fas fa-trash mr-2"></i>Hapus
            </a>
        </div>
    </div>
</div>

<?php if (session()->getFlashdata('success')): ?>
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
        <i class="fas fa-check-circle mr-2"></i><?= session()->getFlashdata('success') ?>
    </div>
<?php endif; ?>

<!-- Statistics -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600 mb-1">Total Anggota</p>
                <p class="text-3xl font-bold text-blue-600"><?= count($members) ?></p>
            </div>
            <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center">
                <i class="fas fa-users text-2xl text-blue-600"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600 mb-1">Laki-laki</p>
                <?php $maleCount = count(array_filter($members, fn($m) => $m['gender'] == 'L')); ?>
                <p class="text-3xl font-bold text-green-600"><?= $maleCount ?></p>
            </div>
            <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center">
                <i class="fas fa-male text-2xl text-green-600"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600 mb-1">Perempuan</p>
                <?php $femaleCount = count(array_filter($members, fn($m) => $m['gender'] == 'P')); ?>
                <p class="text-3xl font-bold text-purple-600"><?= $femaleCount ?></p>
            </div>
            <div class="w-12 h-12 rounded-full bg-purple-100 flex items-center justify-center">
                <i class="fas fa-female text-2xl text-purple-600"></i>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Family Information -->
    <div class="lg:col-span-1">
        <div class="bg-white rounded-lg shadow-md">
            <div class="p-6 border-b">
                <h3 class="text-lg font-semibold text-gray-800">
                    <i class="fas fa-info-circle mr-2"></i>Informasi Keluarga
                </h3>
            </div>
            <div class="p-6 space-y-4">
                <div>
                    <p class="text-sm text-gray-600">Nama Keluarga</p>
                    <p class="font-semibold text-gray-800 text-lg"><?= $family['family_name'] ?></p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Kepala Keluarga</p>
                    <p class="font-semibold text-gray-800"><?= $family['head_of_family'] ?></p>
                </div>
                <?php if ($family['address']): ?>
                    <div>
                        <p class="text-sm text-gray-600">Alamat</p>
                        <p class="text-gray-800"><?= nl2br($family['address']) ?></p>
                    </div>
                <?php endif; ?>
                <?php if ($family['wilayah']): ?>
                    <div>
                        <p class="text-sm text-gray-600">Wilayah</p>
                        <span class="px-3 py-1 text-sm font-semibold rounded-full bg-blue-100 text-blue-800">
                            <?= $family['wilayah'] ?>
                        </span>
                    </div>
                <?php endif; ?>
                <?php if ($family['phone']): ?>
                    <div>
                        <p class="text-sm text-gray-600">Telepon</p>
                        <p class="text-gray-800">
                            <a href="tel:<?= $family['phone'] ?>" class="text-blue-600 hover:underline">
                                <i class="fas fa-phone mr-1"></i><?= $family['phone'] ?>
                            </a>
                        </p>
                    </div>
                <?php endif; ?>
                <?php if ($family['notes']): ?>
                    <div>
                        <p class="text-sm text-gray-600">Catatan</p>
                        <p class="text-gray-800 italic"><?= nl2br($family['notes']) ?></p>
                    </div>
                <?php endif; ?>
                <div>
                    <p class="text-sm text-gray-600">Terdaftar</p>
                    <p class="text-gray-800"><?= date('d M Y', strtotime($family['created_at'])) ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Family Members -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-lg shadow-md">
            <div class="p-6 border-b flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-800">
                    <i class="fas fa-users mr-2"></i>Anggota Keluarga (<?= count($members) ?>)
                </h3>
                <a href="<?= base_url('admin/jemaat/create?family_id=' . $family['id']) ?>" 
                   class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-sm">
                    <i class="fas fa-plus mr-2"></i>Tambah Anggota
                </a>
            </div>
            <div class="p-6">
                <?php if (empty($members)): ?>
                    <div class="text-center py-12">
                        <i class="fas fa-users text-6xl text-gray-300 mb-4"></i>
                        <p class="text-gray-500 mb-4">Belum ada anggota keluarga</p>
                        <a href="<?= base_url('admin/jemaat/create?family_id=' . $family['id']) ?>" 
                           class="inline-block px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                            <i class="fas fa-plus mr-2"></i>Tambah Anggota
                        </a>
                    </div>
                <?php else: ?>
                    <div class="space-y-4">
                        <?php foreach ($members as $member): ?>
                            <div class="border rounded-lg p-4 hover:shadow-md transition">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-4">
                                        <?php if ($member['photo']): ?>
                                            <img src="<?= base_url('uploads/jemaat/' . $member['photo']) ?>" 
                                                 alt="<?= $member['full_name'] ?>"
                                                 class="w-16 h-16 rounded-full object-cover">
                                        <?php else: ?>
                                            <div class="w-16 h-16 rounded-full bg-gray-200 flex items-center justify-center">
                                                <i class="fas fa-user text-2xl text-gray-400"></i>
                                            </div>
                                        <?php endif; ?>
                                        <div>
                                            <h4 class="font-semibold text-gray-800"><?= $member['full_name'] ?></h4>
                                            <p class="text-sm text-gray-600">
                                                <i class="fas fa-id-card mr-1"></i><?= $member['no_induk'] ?>
                                            </p>
                                            <div class="flex items-center gap-2 mt-1">
                                                <span class="px-2 py-0.5 text-xs rounded-full <?= $member['gender'] == 'L' ? 'bg-blue-100 text-blue-800' : 'bg-pink-100 text-pink-800' ?>">
                                                    <?= $member['gender'] == 'L' ? 'Laki-laki' : 'Perempuan' ?>
                                                </span>
                                                <?php if ($member['birth_date']): ?>
                                                    <span class="text-xs text-gray-600">
                                                        <?php
                                                        $birthDate = new DateTime($member['birth_date']);
                                                        $today = new DateTime();
                                                        $age = $today->diff($birthDate)->y;
                                                        echo $age . ' tahun';
                                                        ?>
                                                    </span>
                                                <?php endif; ?>
                                                <span class="px-2 py-0.5 text-xs rounded-full <?= $member['status'] == 'aktif' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' ?>">
                                                    <?= ucfirst($member['status']) ?>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex gap-2">
                                        <a href="<?= base_url('admin/jemaat/view/' . $member['id']) ?>" 
                                           class="px-3 py-2 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition text-sm">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="<?= base_url('admin/jemaat/edit/' . $member['id']) ?>" 
                                           class="px-3 py-2 bg-green-50 text-green-600 rounded-lg hover:bg-green-100 transition text-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
