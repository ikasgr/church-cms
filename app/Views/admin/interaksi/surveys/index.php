<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
    <div>
        <h2 class="text-xl font-semibold text-gray-800">Survei & Jajak Pendapat</h2>
        <p class="text-sm text-gray-600 mt-1">Kelola survei dan polling untuk jemaat</p>
    </div>
    <a href="<?= base_url('admin/interaksi/surveys/create') ?>" 
       class="mt-4 md:mt-0 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
        <i class="fas fa-plus mr-2"></i>Tambah Survei
    </a>
</div>

<?php if (session()->getFlashdata('success')): ?>
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
        <i class="fas fa-check-circle mr-2"></i><?= session()->getFlashdata('success') ?>
    </div>
<?php endif; ?>

<?php if (empty($surveys)): ?>
    <div class="bg-white rounded-lg shadow-md p-12 text-center">
        <i class="fas fa-poll text-6xl text-gray-300 mb-4"></i>
        <p class="text-gray-500 mb-4">Belum ada survei</p>
        <a href="<?= base_url('admin/interaksi/surveys/create') ?>" 
           class="inline-block px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
            <i class="fas fa-plus mr-2"></i>Tambah Survei
        </a>
    </div>
<?php else: ?>
    <div class="grid grid-cols-1 gap-6">
        <?php foreach ($surveys as $survey): ?>
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                <div class="p-6">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex-1">
                            <h3 class="text-lg font-bold text-gray-800 mb-2"><?= $survey['title'] ?></h3>
                            <?php if ($survey['description']): ?>
                                <p class="text-gray-600 text-sm mb-3"><?= $survey['description'] ?></p>
                            <?php endif; ?>
                            
                            <div class="flex flex-wrap gap-4 text-sm text-gray-600">
                                <span>
                                    <i class="far fa-calendar mr-1"></i>
                                    <?= date('d M Y', strtotime($survey['start_date'])) ?> - <?= date('d M Y', strtotime($survey['end_date'])) ?>
                                </span>
                                <?php if ($survey['is_anonymous']): ?>
                                    <span class="text-purple-600">
                                        <i class="fas fa-user-secret mr-1"></i>Anonim
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <!-- Status Badge -->
                        <div>
                            <?php 
                            $now = date('Y-m-d');
                            $isActive = $survey['is_active'] && $now >= $survey['start_date'] && $now <= $survey['end_date'];
                            ?>
                            <?php if ($isActive): ?>
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                    <i class="fas fa-check-circle mr-1"></i>Aktif
                                </span>
                            <?php elseif ($now > $survey['end_date']): ?>
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                                    <i class="fas fa-clock mr-1"></i>Selesai
                                </span>
                            <?php else: ?>
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                    <i class="fas fa-pause-circle mr-1"></i>Non-Aktif
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <!-- Actions -->
                    <div class="flex gap-2 pt-4 border-t">
                        <a href="<?= base_url('admin/interaksi/surveys/view/' . $survey['id']) ?>" 
                           class="px-4 py-2 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition text-sm">
                            <i class="fas fa-eye mr-1"></i>Lihat Detail
                        </a>
                        <a href="<?= base_url('admin/interaksi/surveys/questions/' . $survey['id']) ?>" 
                           class="px-4 py-2 bg-purple-50 text-purple-600 rounded-lg hover:bg-purple-100 transition text-sm">
                            <i class="fas fa-question-circle mr-1"></i>Kelola Pertanyaan
                        </a>
                        <a href="<?= base_url('admin/interaksi/surveys/edit/' . $survey['id']) ?>" 
                           class="px-4 py-2 bg-green-50 text-green-600 rounded-lg hover:bg-green-100 transition text-sm">
                            <i class="fas fa-edit mr-1"></i>Edit
                        </a>
                        <a href="<?= base_url('admin/interaksi/surveys/delete/' . $survey['id']) ?>" 
                           onclick="return confirm('Yakin ingin menghapus survei ini?')"
                           class="px-4 py-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition text-sm">
                            <i class="fas fa-trash mr-1"></i>Hapus
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?= $this->endSection() ?>
