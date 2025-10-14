<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<div class="mb-6">
    <div class="flex items-center gap-2 text-sm text-gray-600 mb-4">
        <a href="<?= base_url('admin/berita') ?>" class="hover:text-blue-600">
            <i class="fas fa-newspaper"></i> Berita & Warta
        </a>
        <i class="fas fa-chevron-right text-xs"></i>
        <span class="text-gray-800">Detail Berita</span>
    </div>
    <div class="flex items-center justify-between">
        <h2 class="text-2xl font-bold text-gray-800">
            <i class="fas fa-info-circle text-blue-600 mr-2"></i><?= esc($news['title']) ?>
        </h2>
        <div class="flex gap-2">
            <a href="<?= base_url('admin/berita/edit/' . $news['id']) ?>" 
               class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                <i class="fas fa-edit mr-2"></i>Edit
            </a>
            <a href="<?= base_url('admin/berita/delete/' . $news['id']) ?>" 
               onclick="return confirm('Yakin ingin menghapus berita ini?')"
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

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Main Content -->
    <div class="lg:col-span-2 space-y-6">
        <?php if (!empty($news['featured_image'])): ?>
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <img src="<?= base_url('uploads/news/' . $news['featured_image']) ?>" 
                     alt="<?= esc($news['title']) ?>"
                     class="w-full h-72 object-cover">
            </div>
        <?php endif; ?>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center gap-3 mb-4">
                <?php
                $categoryLabels = [
                    'artikel' => ['label' => 'Artikel', 'color' => 'bg-blue-100 text-blue-800'],
                    'pengumuman' => ['label' => 'Pengumuman', 'color' => 'bg-green-100 text-green-800'],
                    'renungan' => ['label' => 'Renungan', 'color' => 'bg-purple-100 text-purple-800'],
                    'agenda' => ['label' => 'Agenda', 'color' => 'bg-orange-100 text-orange-800']
                ];
                $category = $categoryLabels[$news['category']] ?? ['label' => $news['category'], 'color' => 'bg-gray-100 text-gray-800'];
                ?>
                <span class="px-3 py-1 text-xs font-semibold rounded-full <?= $category['color'] ?>">
                    <?= $category['label'] ?>
                </span>

                <span class="px-3 py-1 text-xs font-semibold rounded-full <?= $news['is_published'] ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' ?>">
                    <?= $news['is_published'] ? 'Dipublikasikan' : 'Draft' ?>
                </span>
            </div>

            <?php if (!empty($news['excerpt'])): ?>
                <div class="bg-gray-50 border-l-4 border-blue-400 p-4 rounded mb-4">
                    <p class="text-gray-700 italic">"<?= esc($news['excerpt']) ?>"</p>
                </div>
            <?php endif; ?>

            <div class="prose max-w-none text-gray-800">
                <?= $news['content'] ?>
            </div>
        </div>
    </div>

    <!-- Sidebar Info -->
    <div class="space-y-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">
                <i class="fas fa-info mr-2"></i>Informasi Berita
            </h3>
            <div class="space-y-3 text-sm text-gray-600">
                <div class="flex items-start">
                    <i class="fas fa-user w-5 mt-1"></i>
                    <div>
                        <p class="text-gray-500">Penulis</p>
                        <p class="font-semibold text-gray-800">ID: <?= $news['author_id'] ?></p>
                    </div>
                </div>
                <div class="flex items-start">
                    <i class="fas fa-calendar-alt w-5 mt-1"></i>
                    <div>
                        <p class="text-gray-500">Dibuat</p>
                        <p class="font-semibold text-gray-800"><?= date('d M Y H:i', strtotime($news['created_at'])) ?></p>
                    </div>
                </div>
                <div class="flex items-start">
                    <i class="fas fa-edit w-5 mt-1"></i>
                    <div>
                        <p class="text-gray-500">Diperbarui</p>
                        <p class="font-semibold text-gray-800"><?= date('d M Y H:i', strtotime($news['updated_at'])) ?></p>
                    </div>
                </div>
                <?php if (!empty($news['published_at'])): ?>
                    <div class="flex items-start">
                        <i class="fas fa-bullhorn w-5 mt-1"></i>
                        <div>
                            <p class="text-gray-500">Dipublikasikan</p>
                            <p class="font-semibold text-gray-800"><?= date('d M Y H:i', strtotime($news['published_at'])) ?></p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">
                <i class="fas fa-search mr-2"></i>SEO Metadata
            </h3>
            <div class="space-y-3 text-sm text-gray-600">
                <div>
                    <p class="text-gray-500">Slug</p>
                    <p class="font-semibold text-gray-800"><?= esc($news['slug']) ?></p>
                </div>
                <?php if (!empty($news['meta_keywords'])): ?>
                    <div>
                        <p class="text-gray-500">Keywords</p>
                        <p class="font-semibold text-gray-800"><?= esc($news['meta_keywords']) ?></p>
                    </div>
                <?php endif; ?>
                <?php if (!empty($news['meta_description'])): ?>
                    <div>
                        <p class="text-gray-500">Description</p>
                        <p class="text-gray-800"><?= esc($news['meta_description']) ?></p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">
                <i class="fas fa-link mr-2"></i>Tautan Cepat
            </h3>
            <div class="space-y-3 text-sm">
                <a href="<?= base_url('admin/berita') ?>" class="flex items-center text-blue-600 hover:underline">
                    <i class="fas fa-list mr-2"></i>Lihat Semua Berita
                </a>
                <a href="<?= base_url('admin/berita/create') ?>" class="flex items-center text-blue-600 hover:underline">
                    <i class="fas fa-plus mr-2"></i>Tambah Berita Baru
                </a>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
