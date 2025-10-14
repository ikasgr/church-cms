<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<div class="mb-6">
    <div class="flex items-center gap-2 text-sm text-gray-600 mb-4">
        <a href="<?= base_url('admin/jemaat') ?>" class="hover:text-blue-600">
            <i class="fas fa-users"></i> Data Jemaat
        </a>
        <i class="fas fa-chevron-right text-xs"></i>
        <span class="text-gray-800">Detail Jemaat</span>
    </div>
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">
                <i class="fas fa-id-card text-blue-600 mr-2"></i><?= esc($jemaat['full_name']) ?>
            </h2>
            <p class="text-sm text-gray-600 mt-1">Informasi lengkap jemaat dan data keluarga</p>
        </div>
        <div class="flex gap-2">
            <a href="<?= base_url('admin/jemaat/edit/' . $jemaat['id']) ?>" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                <i class="fas fa-edit mr-2"></i>Edit
            </a>
            <a href="<?= base_url('admin/jemaat/delete/' . $jemaat['id']) ?>" data-confirm="Yakin ingin menghapus data jemaat ini?" data-confirm-type="delete" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                <i class="fas fa-trash mr-2"></i>Hapus
            </a>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
    <!-- Informasi Utama -->
    <div class="xl:col-span-2 space-y-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                <i class="fas fa-user-circle text-blue-600 mr-2"></i>Profil Jemaat
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                <div>
                    <p class="text-gray-500">Nomor Induk</p>
                    <p class="font-semibold text-gray-800"><?= esc($jemaat['no_induk']) ?></p>
                </div>
                <div>
                    <p class="text-gray-500">Jenis Kelamin</p>
                    <p class="font-semibold text-gray-800"><?= $jemaat['gender'] === 'L' ? 'Laki-Laki' : 'Perempuan' ?></p>
                </div>
                <div>
                    <p class="text-gray-500">Tempat, Tanggal Lahir</p>
                    <p class="font-semibold text-gray-800">
                        <?= esc($jemaat['birth_place']) ?><?= $jemaat['birth_place'] && $jemaat['birth_date'] ? ', ' : '' ?>
                        <?= $jemaat['birth_date'] ? date('d M Y', strtotime($jemaat['birth_date'])) : '-' ?>
                    </p>
                </div>
                <div>
                    <p class="text-gray-500">Wilayah</p>
                    <p class="font-semibold text-gray-800"><?= esc($jemaat['wilayah']) ?: '-' ?></p>
                </div>
                <div>
                    <p class="text-gray-500">Telepon</p>
                    <p class="font-semibold text-gray-800"><?= esc($jemaat['phone']) ?: '-' ?></p>
                </div>
                <div>
                    <p class="text-gray-500">Email</p>
                    <p class="font-semibold text-gray-800"><?= esc($jemaat['email']) ?: '-' ?></p>
                </div>
                <div>
                    <p class="text-gray-500">Status</p>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold <?= $jemaat['status'] === 'aktif' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' ?>">
                        <?= ucfirst($jemaat['status']) ?>
                    </span>
                </div>
                <div>
                    <p class="text-gray-500">Nama Pasangan</p>
                    <p class="font-semibold text-gray-800"><?= esc($jemaat['spouse_name']) ?: '-' ?></p>
                </div>
            </div>
            <div class="mt-4">
                <p class="text-gray-500">Alamat</p>
                <p class="font-semibold text-gray-800 whitespace-pre-line"><?= esc($jemaat['address']) ?: '-' ?></p>
            </div>
            <?php if (!empty($jemaat['notes'])): ?>
                <div class="mt-4">
                    <p class="text-gray-500">Catatan</p>
                    <p class="font-semibold text-gray-800 whitespace-pre-line"><?= esc($jemaat['notes']) ?></p>
                </div>
            <?php endif; ?>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                <i class="fas fa-cross text-blue-600 mr-2"></i>Informasi Sakramen
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                <div>
                    <p class="text-gray-500">Tanggal Baptis</p>
                    <p class="font-semibold text-gray-800">
                        <?= $jemaat['baptis_date'] ? date('d M Y', strtotime($jemaat['baptis_date'])) : '-' ?>
                    </p>
                </div>
                <div>
                    <p class="text-gray-500">Tempat Baptis</p>
                    <p class="font-semibold text-gray-800"><?= esc($jemaat['baptis_place']) ?: '-' ?></p>
                </div>
                <div>
                    <p class="text-gray-500">Tanggal Sidi</p>
                    <p class="font-semibold text-gray-800">
                        <?= $jemaat['sidi_date'] ? date('d M Y', strtotime($jemaat['sidi_date'])) : '-' ?>
                    </p>
                </div>
                <div>
                    <p class="text-gray-500">Tempat Sidi</p>
                    <p class="font-semibold text-gray-800"><?= esc($jemaat['sidi_place']) ?: '-' ?></p>
                </div>
                <div>
                    <p class="text-gray-500">Tanggal Pernikahan</p>
                    <p class="font-semibold text-gray-800">
                        <?= $jemaat['marriage_date'] ? date('d M Y', strtotime($jemaat['marriage_date'])) : '-' ?>
                    </p>
                </div>
                <div>
                    <p class="text-gray-500">Tempat Pernikahan</p>
                    <p class="font-semibold text-gray-800"><?= esc($jemaat['marriage_place']) ?: '-' ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Sisi Kanan -->
    <div class="space-y-6">
        <div class="bg-white rounded-lg shadow-md p-6 text-center">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Foto Jemaat</h3>
            <?php if (!empty($jemaat['photo'])): ?>
                <img src="<?= base_url('uploads/jemaat/' . $jemaat['photo']) ?>" alt="Foto Jemaat" class="w-48 h-48 object-cover mx-auto rounded-full shadow-lg">
            <?php else: ?>
                <div class="w-48 h-48 mx-auto rounded-full bg-blue-100 flex items-center justify-center">
                    <i class="fas fa-user text-5xl text-blue-600"></i>
                </div>
            <?php endif; ?>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                <i class="fas fa-users text-blue-600 mr-2"></i>Data Keluarga
            </h3>
            <?php if ($family): ?>
                <div class="space-y-3 text-sm">
                    <div>
                        <p class="text-gray-500">Nama Keluarga</p>
                        <p class="font-semibold text-gray-800"><?= esc($family['family_name']) ?></p>
                    </div>
                    <div>
                        <p class="text-gray-500">Kepala Keluarga</p>
                        <p class="font-semibold text-gray-800"><?= esc($family['head_of_family']) ?></p>
                    </div>
                    <div>
                        <p class="text-gray-500">Alamat</p>
                        <p class="font-semibold text-gray-800 whitespace-pre-line"><?= esc($family['address']) ?: '-' ?></p>
                    </div>
                    <div>
                        <p class="text-gray-500">Wilayah</p>
                        <p class="font-semibold text-gray-800"><?= esc($family['wilayah']) ?: '-' ?></p>
                    </div>
                    <div>
                        <p class="text-gray-500">Telepon</p>
                        <p class="font-semibold text-gray-800"><?= esc($family['phone']) ?: '-' ?></p>
                    </div>
                    <a href="<?= base_url('admin/jemaat/families/view/' . $family['id']) ?>" class="inline-flex items-center px-4 py-2 mt-2 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition">
                        <i class="fas fa-eye mr-2"></i>Lihat detail keluarga
                    </a>
                </div>
            <?php else: ?>
                <p class="text-sm text-gray-600">Jemaat ini belum terhubung dengan data keluarga.</p>
            <?php endif; ?>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                <i class="fas fa-clock text-blue-600 mr-2"></i>Aktivitas Terakhir
            </h3>
            <div class="space-y-3 text-sm text-gray-600">
                <div>
                    <p class="text-gray-500">Dibuat</p>
                    <p class="font-semibold text-gray-800"><?= date('d M Y H:i', strtotime($jemaat['created_at'])) ?></p>
                </div>
                <div>
                    <p class="text-gray-500">Terakhir Diperbarui</p>
                    <p class="font-semibold text-gray-800"><?= date('d M Y H:i', strtotime($jemaat['updated_at'])) ?></p>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
