<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<div class="mb-6">
    <div class="flex items-center gap-2 text-sm text-gray-600 mb-4">
        <a href="<?= base_url('admin/ibadah/kegiatan') ?>" class="hover:text-blue-600">
            <i class="fas fa-calendar-alt"></i> Kegiatan Gereja
        </a>
        <i class="fas fa-chevron-right text-xs"></i>
        <span class="text-gray-800">Detail Kegiatan</span>
    </div>
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">
                <i class="fas fa-info-circle text-blue-600 mr-2"></i><?= esc($kegiatan['title']) ?>
            </h2>
            <p class="text-sm text-gray-600 mt-1">Informasi lengkap kegiatan gereja</p>
        </div>
        <div class="flex gap-2">
            <a href="<?= base_url('admin/ibadah/kegiatan/edit/' . $kegiatan['id']) ?>" 
               class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                <i class="fas fa-edit mr-2"></i>Edit
            </a>
            <a href="<?= base_url('admin/ibadah/kegiatan/delete/' . $kegiatan['id']) ?>" 
               onclick="return confirm('Yakin ingin menghapus kegiatan ini?')"
               class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                <i class="fas fa-trash mr-2"></i>Hapus
            </a>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Detail Utama -->
    <div class="lg:col-span-2 space-y-6">
        <?php if (!empty($kegiatan['image'])): ?>
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <img src="<?= base_url('uploads/kegiatan/' . $kegiatan['image']) ?>" alt="Poster Kegiatan" class="w-full h-72 object-cover">
            </div>
        <?php endif; ?>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center gap-3 mb-4">
                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-800">
                    <?= ucfirst(str_replace('_', ' ', $kegiatan['category'])) ?>
                </span>
                <span class="px-3 py-1 text-xs font-semibold rounded-full <?= $kegiatan['is_published'] ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' ?>">
                    <?= $kegiatan['is_published'] ? 'Dipublikasikan' : 'Draft' ?>
                </span>
                <?php if ($kegiatan['registration_required']): ?>
                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                        <i class="fas fa-user-check mr-1"></i>Pendaftaran diperlukan
                    </span>
                <?php endif; ?>
            </div>

            <?php if (!empty($kegiatan['description'])): ?>
                <div class="prose max-w-none text-gray-800">
                    <?= nl2br(esc($kegiatan['description'])) ?>
                </div>
            <?php else: ?>
                <p class="text-gray-500 italic">Belum ada deskripsi kegiatan.</p>
            <?php endif; ?>
        </div>

        <?php if (!empty($registrations)): ?>
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">
                        <i class="fas fa-users mr-2"></i>Pendaftar (<?= $total_registered ?>)
                    </h3>
                    <a href="<?= base_url('admin/ibadah/kegiatan/registrations/' . $kegiatan['id']) ?>" class="text-sm text-blue-600 hover:underline">
                        Kelola pendaftaran
                    </a>
                </div>
                <div class="divide-y divide-gray-200">
                    <?php foreach ($registrations as $registration): ?>
                        <div class="py-3 flex items-center justify-between text-sm">
                            <div>
                                <p class="font-semibold text-gray-800"><?= esc($registration['full_name']) ?></p>
                                <?php if (!empty($registration['email'])): ?>
                                    <p class="text-gray-600">Email: <?= esc($registration['email']) ?></p>
                                <?php endif; ?>
                                <?php if (!empty($registration['phone'])): ?>
                                    <p class="text-gray-600">Telepon: <?= esc($registration['phone']) ?></p>
                                <?php endif; ?>
                            </div>
                            <span class="px-3 py-1 text-xs font-semibold rounded-full <?= $registration['status'] === 'approved' ? 'bg-green-100 text-green-800' : ($registration['status'] === 'rejected' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800') ?>">
                                <?= ucfirst($registration['status']) ?>
                            </span>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Informasi Tambahan -->
    <div class="space-y-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">
                <i class="fas fa-calendar-day mr-2"></i>Jadwal & Lokasi
            </h3>
            <div class="space-y-3 text-sm text-gray-600">
                <div class="flex items-start">
                    <i class="far fa-calendar w-5 mt-1"></i>
                    <div>
                        <p class="text-gray-500">Tanggal Mulai</p>
                        <p class="font-semibold text-gray-800"><?= date('d M Y', strtotime($kegiatan['date_start'])) ?></p>
                    </div>
                </div>
                <?php if (!empty($kegiatan['date_end']) && $kegiatan['date_end'] !== $kegiatan['date_start']): ?>
                    <div class="flex items-start">
                        <i class="far fa-calendar-check w-5 mt-1"></i>
                        <div>
                            <p class="text-gray-500">Tanggal Selesai</p>
                            <p class="font-semibold text-gray-800"><?= date('d M Y', strtotime($kegiatan['date_end'])) ?></p>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if (!empty($kegiatan['time_start'])): ?>
                    <div class="flex items-start">
                        <i class="far fa-clock w-5 mt-1"></i>
                        <div>
                            <p class="text-gray-500">Jam</p>
                            <p class="font-semibold text-gray-800">
                                <?= date('H:i', strtotime($kegiatan['time_start'])) ?>
                                <?php if (!empty($kegiatan['time_end'])): ?>
                                    - <?= date('H:i', strtotime($kegiatan['time_end'])) ?>
                                <?php endif; ?>
                            </p>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if (!empty($kegiatan['location'])): ?>
                    <div class="flex items-start">
                        <i class="fas fa-map-marker-alt w-5 mt-1"></i>
                        <div>
                            <p class="text-gray-500">Lokasi</p>
                            <p class="font-semibold text-gray-800"><?= esc($kegiatan['location']) ?></p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">
                <i class="fas fa-user-tie mr-2"></i>Penanggung Jawab
            </h3>
            <div class="space-y-3 text-sm text-gray-600">
                <?php if (!empty($kegiatan['organizer'])): ?>
                    <div>
                        <p class="text-gray-500">Penyelenggara</p>
                        <p class="font-semibold text-gray-800"><?= esc($kegiatan['organizer']) ?></p>
                    </div>
                <?php endif; ?>
                <?php if (!empty($kegiatan['contact_person'])): ?>
                    <div>
                        <p class="text-gray-500">Kontak Person</p>
                        <p class="font-semibold text-gray-800"><?= esc($kegiatan['contact_person']) ?></p>
                    </div>
                <?php endif; ?>
                <?php if (!empty($kegiatan['contact_phone'])): ?>
                    <div>
                        <p class="text-gray-500">Nomor Kontak</p>
                        <p class="font-semibold text-gray-800"><?= esc($kegiatan['contact_phone']) ?></p>
                    </div>
                <?php endif; ?>
                <?php if (!empty($kegiatan['max_participants'])): ?>
                    <div>
                        <p class="text-gray-500">Kapasitas Peserta</p>
                        <p class="font-semibold text-gray-800"><?= esc($kegiatan['max_participants']) ?> orang</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">
                <i class="fas fa-link mr-2"></i>Tautan Cepat
            </h3>
            <div class="space-y-3 text-sm">
                <a href="<?= base_url('admin/ibadah/kegiatan') ?>" class="flex items-center text-blue-600 hover:underline">
                    <i class="fas fa-list mr-2"></i>Kembali ke daftar kegiatan
                </a>
                <a href="<?= base_url('admin/ibadah/kegiatan/create') ?>" class="flex items-center text-blue-600 hover:underline">
                    <i class="fas fa-plus mr-2"></i>Tambah kegiatan baru
                </a>
                <a href="<?= base_url('admin/ibadah/kegiatan/registrations/' . $kegiatan['id']) ?>" class="flex items-center text-blue-600 hover:underline">
                    <i class="fas fa-users mr-2"></i>Lihat pendaftaran peserta
                </a>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
