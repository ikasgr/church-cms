<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<div class="mb-6">
    <div class="flex items-center gap-2 text-sm text-gray-600 mb-4">
        <a href="<?= base_url('admin/interaksi/guestbook') ?>" class="hover:text-blue-600">
            <i class="fas fa-book"></i> Buku Tamu
        </a>
        <i class="fas fa-chevron-right text-xs"></i>
        <span class="text-gray-800">Detail Pesan</span>
    </div>
    <div class="flex items-center justify-between">
        <h2 class="text-2xl font-bold text-gray-800">
            <i class="fas fa-envelope-open text-blue-600 mr-2"></i><?= esc($entry['name']) ?>
        </h2>
        <div class="flex gap-2">
            <?php if (empty($entry['is_approved'])): ?>
                <a href="<?= base_url('admin/interaksi/guestbook/approve/' . $entry['id']) ?>"
                   onclick="return confirm('Setujui pesan ini untuk ditampilkan?')"
                   class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                    <i class="fas fa-check mr-2"></i>Setujui
                </a>
            <?php endif; ?>
            <a href="<?= base_url('admin/interaksi/guestbook/delete/' . $entry['id']) ?>"
               onclick="return confirm('Yakin ingin menghapus pesan ini?')"
               class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                <i class="fas fa-trash mr-2"></i>Hapus
            </a>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Message Content -->
    <div class="lg:col-span-2 space-y-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">
                <i class="fas fa-comment-dots mr-2"></i>Pesan Dari Pengunjung
            </h3>
            <div class="bg-gray-50 rounded-lg p-4">
                <p class="text-gray-800 leading-relaxed whitespace-pre-line">
                    <?= esc($entry['message']) ?>
                </p>
            </div>
        </div>

        <?php if (!empty($entry['reply'] ?? null)): ?>
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">
                    <i class="fas fa-reply mr-2"></i>Tanggapan Admin
                </h3>
                <div class="bg-blue-50 rounded-lg p-4">
                    <p class="text-gray-800 leading-relaxed whitespace-pre-line">
                        <?= esc($entry['reply']) ?>
                    </p>
                    <?php if (!empty($entry['replied_at'] ?? null)): ?>
                        <p class="text-xs text-gray-500 mt-3">
                            <i class="fas fa-clock mr-1"></i>Dikirim: <?= date('d M Y H:i', strtotime($entry['replied_at'])) ?>
                        </p>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Info Sidebar -->
    <div class="space-y-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">
                <i class="fas fa-user mr-2"></i>Informasi Pengunjung
            </h3>
            <div class="space-y-3 text-sm text-gray-600">
                <div>
                    <p class="text-gray-500">Nama Lengkap</p>
                    <p class="font-semibold text-gray-800"><?= esc($entry['name']) ?></p>
                </div>
                <?php if (!empty($entry['email'] ?? null)): ?>
                    <div>
                        <p class="text-gray-500">Email</p>
                        <p class="text-gray-800">
                            <a href="mailto:<?= esc($entry['email']) ?>" class="text-blue-600 hover:underline">
                                <?= esc($entry['email']) ?>
                            </a>
                        </p>
                    </div>
                <?php endif; ?>
                <?php if (!empty($entry['phone'] ?? null)): ?>
                    <div>
                        <p class="text-gray-500">Telepon</p>
                        <p class="text-gray-800">
                            <a href="tel:<?= esc($entry['phone']) ?>" class="text-blue-600 hover:underline">
                                <?= esc($entry['phone']) ?>
                            </a>
                        </p>
                    </div>
                <?php endif; ?>
                <?php if (!empty($entry['address'] ?? null)): ?>
                    <div>
                        <p class="text-gray-500">Alamat</p>
                        <p class="text-gray-800"><?= esc($entry['address']) ?></p>
                    </div>
                <?php endif; ?>
                <?php if (!empty($entry['organization'] ?? null)): ?>
                    <div>
                        <p class="text-gray-500">Organisasi</p>
                        <p class="text-gray-800"><?= esc($entry['organization']) ?></p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">
                <i class="fas fa-info-circle mr-2"></i>Status Pesan
            </h3>
            <div class="space-y-3 text-sm text-gray-600">
                <div class="flex items-center justify-between">
                    <span>Status</span>
                    <span class="px-3 py-1 text-xs font-semibold rounded-full <?= !empty($entry['is_approved']) ? 'bg-green-100 text-green-800' : 'bg-orange-100 text-orange-800' ?>">
                        <?= !empty($entry['is_approved']) ? 'Disetujui' : 'Menunggu' ?>
                    </span>
                </div>
                <div>
                    <p class="text-gray-500">Dikirim</p>
                    <p class="text-gray-800 font-semibold"><?= date('d M Y H:i', strtotime($entry['created_at'])) ?></p>
                </div>
                <?php if (!empty($entry['approved_at'] ?? null)): ?>
                    <div>
                        <p class="text-gray-500">Disetujui</p>
                        <p class="text-gray-800 font-semibold"><?= date('d M Y H:i', strtotime($entry['approved_at'])) ?></p>
                    </div>
                <?php endif; ?>
                <?php if (!empty($entry['approved_by_name'] ?? null)): ?>
                    <div>
                        <p class="text-gray-500">Disetujui oleh</p>
                        <p class="text-gray-800 font-semibold"><?= esc($entry['approved_by_name']) ?></p>
                    </div>
                <?php elseif (!empty($entry['approved_by'] ?? null)): ?>
                    <div>
                        <p class="text-gray-500">Disetujui oleh (ID)</p>
                        <p class="text-gray-800 font-semibold">User #<?= esc($entry['approved_by']) ?></p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">
                <i class="fas fa-link mr-2"></i>Tautan Cepat
            </h3>
            <div class="space-y-3 text-sm">
                <a href="<?= base_url('admin/interaksi/guestbook') ?>" class="flex items-center text-blue-600 hover:underline">
                    <i class="fas fa-list mr-2"></i>Lihat Daftar Pesan
                </a>
                <a href="<?= base_url('admin/interaksi/guestbook') ?>#pending" class="flex items-center text-blue-600 hover:underline">
                    <i class="fas fa-clock mr-2"></i>Lihat Pesan Menunggu
                </a>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
