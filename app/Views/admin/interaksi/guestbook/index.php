<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<div class="mb-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">
                <i class="fas fa-book text-blue-600 mr-2"></i>Buku Tamu
            </h2>
            <p class="text-sm text-gray-600 mt-1">Kelola pesan dari pengunjung website</p>
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
    <?php
    $totalEntries = count($guestbook);
    $approvedEntries = count(array_filter($guestbook, fn($g) => $g['is_approved']));
    $pendingEntries = count(array_filter($guestbook, fn($g) => !$g['is_approved']));
    ?>
    
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600 mb-1">Total Pesan</p>
                <p class="text-3xl font-bold text-blue-600"><?= $totalEntries ?></p>
            </div>
            <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center">
                <i class="fas fa-book text-2xl text-blue-600"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600 mb-1">Disetujui</p>
                <p class="text-3xl font-bold text-green-600"><?= $approvedEntries ?></p>
            </div>
            <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center">
                <i class="fas fa-check-circle text-2xl text-green-600"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600 mb-1">Menunggu</p>
                <p class="text-3xl font-bold text-orange-600"><?= $pendingEntries ?></p>
            </div>
            <div class="w-12 h-12 rounded-full bg-orange-100 flex items-center justify-center">
                <i class="fas fa-clock text-2xl text-orange-600"></i>
            </div>
        </div>
    </div>
</div>

<!-- Guestbook Entries -->
<?php if (empty($guestbook)): ?>
    <div class="bg-white rounded-lg shadow-md p-12 text-center">
        <i class="fas fa-book text-6xl text-gray-300 mb-4"></i>
        <p class="text-gray-500 mb-4">Belum ada pesan di buku tamu</p>
    </div>
<?php else: ?>
    <div class="space-y-4">
        <?php foreach ($guestbook as $entry): ?>
            <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition">
                <div class="flex items-start justify-between">
                    <div class="flex items-start gap-4 flex-1">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center">
                                <i class="fas fa-user text-xl text-blue-600"></i>
                            </div>
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-2">
                                <h3 class="font-semibold text-gray-800"><?= $entry['name'] ?></h3>
                                <?php if ($entry['is_approved']): ?>
                                    <span class="px-2 py-0.5 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                        <i class="fas fa-check-circle mr-1"></i>Disetujui
                                    </span>
                                <?php else: ?>
                                    <span class="px-2 py-0.5 text-xs font-semibold rounded-full bg-orange-100 text-orange-800">
                                        <i class="fas fa-clock mr-1"></i>Menunggu
                                    </span>
                                <?php endif; ?>
                            </div>
                            
                            <?php if (!empty($entry['email'] ?? null)): ?>
                                <p class="text-sm text-gray-600 mb-2">
                                    <i class="fas fa-envelope mr-1"></i><?= $entry['email'] ?>
                                </p>
                            <?php endif; ?>
                            
                            <?php if (!empty($entry['phone'] ?? null)): ?>
                                <p class="text-sm text-gray-600 mb-2">
                                    <i class="fas fa-phone mr-1"></i><?= $entry['phone'] ?>
                                </p>
                            <?php endif; ?>
                            
                            <?php if (!empty($entry['address'] ?? null)): ?>
                                <p class="text-sm text-gray-600 mb-2">
                                    <i class="fas fa-map-marker-alt mr-1"></i><?= $entry['address'] ?>
                                </p>
                            <?php endif; ?>
                            
                            <div class="mt-3 p-4 bg-gray-50 rounded-lg">
                                <p class="text-gray-800"><?= nl2br($entry['message']) ?></p>
                            </div>
                            
                            <div class="mt-3 flex items-center gap-4 text-xs text-gray-500">
                                <span>
                                    <i class="fas fa-calendar mr-1"></i><?= date('d M Y H:i', strtotime($entry['created_at'])) ?>
                                </span>
                                <?php if (!empty($entry['is_approved']) && !empty($entry['approved_at'] ?? null)): ?>
                                    <span>
                                        <i class="fas fa-check mr-1"></i>Disetujui: <?= date('d M Y H:i', strtotime($entry['approved_at'])) ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex flex-col gap-2 ml-4">
                        <a href="<?= base_url('admin/interaksi/guestbook/view/' . $entry['id']) ?>" 
                           class="px-3 py-2 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition text-sm text-center">
                            <i class="fas fa-eye"></i>
                        </a>
                        <?php if (!$entry['is_approved']): ?>
                            <a href="<?= base_url('admin/interaksi/guestbook/approve/' . $entry['id']) ?>" 
                               onclick="return confirm('Setujui pesan ini untuk ditampilkan?')"
                               class="px-3 py-2 bg-green-50 text-green-600 rounded-lg hover:bg-green-100 transition text-sm text-center">
                                <i class="fas fa-check"></i>
                            </a>
                        <?php endif; ?>
                        <a href="<?= base_url('admin/interaksi/guestbook/delete/' . $entry['id']) ?>" 
                           onclick="return confirm('Yakin ingin menghapus pesan ini?')"
                           class="px-3 py-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition text-sm text-center">
                            <i class="fas fa-trash"></i>
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?= $this->endSection() ?>
