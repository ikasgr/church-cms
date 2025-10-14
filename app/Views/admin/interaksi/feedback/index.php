<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<div class="mb-6">
    <h2 class="text-xl font-semibold text-gray-800">Masukan & Saran</h2>
    <p class="text-sm text-gray-600 mt-1">Kelola masukan dan saran dari jemaat</p>
</div>

<!-- Filter Tabs -->
<div class="bg-white rounded-lg shadow-md mb-6">
    <div class="border-b">
        <nav class="flex -mb-px">
            <a href="<?= base_url('admin/interaksi/feedback') ?>" 
               class="px-6 py-3 border-b-2 <?= empty($status) && empty($type) ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500' ?> text-sm font-medium">
                Semua
            </a>
            <a href="<?= base_url('admin/interaksi/feedback?status=new') ?>" 
               class="px-6 py-3 border-b-2 <?= ($status ?? '') == 'new' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500' ?> text-sm font-medium">
                Baru
            </a>
            <a href="<?= base_url('admin/interaksi/feedback?status=read') ?>" 
               class="px-6 py-3 border-b-2 <?= ($status ?? '') == 'read' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500' ?> text-sm font-medium">
                Dibaca
            </a>
            <a href="<?= base_url('admin/interaksi/feedback?status=responded') ?>" 
               class="px-6 py-3 border-b-2 <?= ($status ?? '') == 'responded' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500' ?> text-sm font-medium">
                Ditanggapi
            </a>
        </nav>
    </div>
</div>

<!-- Feedback List -->
<div class="space-y-4">
    <?php if (empty($feedback)): ?>
        <div class="bg-white rounded-lg shadow-md p-12 text-center">
            <i class="fas fa-comments text-6xl text-gray-300 mb-4"></i>
            <p class="text-gray-500">Belum ada masukan atau saran</p>
        </div>
    <?php else: ?>
        <?php foreach ($feedback as $f): ?>
            <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition">
                <div class="flex items-start justify-between mb-4">
                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-2">
                            <h3 class="text-lg font-semibold text-gray-800"><?= $f['name'] ?></h3>
                            <?php
                            $typeColors = [
                                'masukan' => 'bg-blue-100 text-blue-800',
                                'saran' => 'bg-green-100 text-green-800',
                                'keluhan' => 'bg-red-100 text-red-800',
                                'lainnya' => 'bg-gray-100 text-gray-800',
                            ];
                            ?>
                            <span class="px-2 py-1 text-xs font-semibold rounded-full <?= $typeColors[$f['type']] ?>">
                                <?= ucfirst($f['type']) ?>
                            </span>
                        </div>
                        <p class="text-sm text-gray-600"><?= $f['email'] ?> • <?= $f['phone'] ?></p>
                    </div>
                    <div class="text-right">
                        <?php if ($f['status'] == 'new'): ?>
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                <i class="fas fa-circle text-xs"></i> Baru
                            </span>
                        <?php elseif ($f['status'] == 'read'): ?>
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                <i class="fas fa-eye"></i> Dibaca
                            </span>
                        <?php else: ?>
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                <i class="fas fa-check"></i> Ditanggapi
                            </span>
                        <?php endif; ?>
                        <p class="text-xs text-gray-500 mt-2"><?= date('d M Y H:i', strtotime($f['created_at'])) ?></p>
                    </div>
                </div>
                
                <div class="mb-4">
                    <h4 class="font-semibold text-gray-700 mb-2"><?= $f['subject'] ?></h4>
                    <p class="text-gray-600"><?= nl2br($f['message']) ?></p>
                </div>
                
                <?php if ($f['response']): ?>
                    <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-4">
                        <p class="text-sm font-semibold text-blue-900 mb-1">Tanggapan:</p>
                        <p class="text-sm text-blue-800"><?= nl2br($f['response']) ?></p>
                        <p class="text-xs text-blue-600 mt-2">
                            <?= date('d M Y H:i', strtotime($f['responded_at'])) ?>
                        </p>
                    </div>
                <?php endif; ?>
                
                <div class="flex gap-2">
                    <a href="<?= base_url('admin/interaksi/feedback/view/' . $f['id']) ?>" 
                       class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm">
                        <i class="fas fa-eye mr-2"></i>Detail & Tanggapi
                    </a>
                    <a href="<?= base_url('admin/interaksi/feedback/delete/' . $f['id']) ?>" 
                       onclick="return confirm('Yakin ingin menghapus?')"
                       class="px-4 py-2 bg-red-100 text-red-600 rounded-lg hover:bg-red-200 text-sm">
                        <i class="fas fa-trash mr-2"></i>Hapus
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>
