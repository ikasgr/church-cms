<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<div class="mb-6">
    <div class="flex items-center gap-2 text-sm text-gray-600 mb-4">
        <a href="<?= base_url('admin/berita') ?>" class="hover:text-blue-600">
            <i class="fas fa-newspaper"></i> Berita & Warta
        </a>
        <i class="fas fa-chevron-right text-xs"></i>
        <span class="text-gray-800">Tambah Berita</span>
    </div>
    <h2 class="text-2xl font-bold text-gray-800">Tambah Berita Baru</h2>
</div>

<div class="bg-white rounded-lg shadow-md">
    <form action="<?= base_url('admin/berita/create') ?>" method="POST" enctype="multipart/form-data" class="p-6">
        <?= csrf_field() ?>
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content (2 columns) -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Title -->
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                        Judul <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="title" name="title" 
                           value="<?= old('title') ?>"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="Contoh: Ibadah Minggu 14 Oktober 2024">
                    <?php if (isset($validation) && $validation->hasError('title')): ?>
                        <p class="text-red-500 text-sm mt-1"><?= $validation->getError('title') ?></p>
                    <?php endif; ?>
                </div>

                <!-- Excerpt -->
                <div>
                    <label for="excerpt" class="block text-sm font-medium text-gray-700 mb-2">
                        Ringkasan
                    </label>
                    <textarea id="excerpt" name="excerpt" rows="3"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                              placeholder="Ringkasan singkat berita (opsional)"><?= old('excerpt') ?></textarea>
                    <p class="text-xs text-gray-500 mt-1">Akan ditampilkan di daftar berita</p>
                </div>

                <!-- Content -->
                <div>
                    <label for="content" class="block text-sm font-medium text-gray-700 mb-2">
                        Konten <span class="text-red-500">*</span>
                    </label>
                    <textarea id="content" name="content" rows="15"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                              placeholder="Tulis konten berita di sini..."><?= old('content') ?></textarea>
                    <?php if (isset($validation) && $validation->hasError('content')): ?>
                        <p class="text-red-500 text-sm mt-1"><?= $validation->getError('content') ?></p>
                    <?php endif; ?>
                </div>

                <!-- SEO Section -->
                <div class="border-t pt-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">
                        <i class="fas fa-search mr-2"></i>SEO Meta
                    </h3>
                    
                    <div class="space-y-4">
                        <!-- Meta Keywords -->
                        <div>
                            <label for="meta_keywords" class="block text-sm font-medium text-gray-700 mb-2">
                                Keywords
                            </label>
                            <input type="text" id="meta_keywords" name="meta_keywords" 
                                   value="<?= old('meta_keywords') ?>"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="gereja, ibadah, flobamora">
                            <p class="text-xs text-gray-500 mt-1">Pisahkan dengan koma</p>
                        </div>

                        <!-- Meta Description -->
                        <div>
                            <label for="meta_description" class="block text-sm font-medium text-gray-700 mb-2">
                                Description
                            </label>
                            <textarea id="meta_description" name="meta_description" rows="3"
                                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                      placeholder="Deskripsi untuk mesin pencari"><?= old('meta_description') ?></textarea>
                            <p class="text-xs text-gray-500 mt-1">Maksimal 160 karakter</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar (1 column) -->
            <div class="space-y-6">
                <!-- Category -->
                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700 mb-2">
                        Kategori <span class="text-red-500">*</span>
                    </label>
                    <select id="category" name="category" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">-- Pilih Kategori --</option>
                        <option value="artikel" <?= old('category') == 'artikel' ? 'selected' : '' ?>>Artikel</option>
                        <option value="pengumuman" <?= old('category') == 'pengumuman' ? 'selected' : '' ?>>Pengumuman</option>
                        <option value="renungan" <?= old('category') == 'renungan' ? 'selected' : '' ?>>Renungan</option>
                        <option value="agenda" <?= old('category') == 'agenda' ? 'selected' : '' ?>>Agenda</option>
                    </select>
                    <?php if (isset($validation) && $validation->hasError('category')): ?>
                        <p class="text-red-500 text-sm mt-1"><?= $validation->getError('category') ?></p>
                    <?php endif; ?>
                </div>

                <!-- Featured Image -->
                <div>
                    <label for="featured_image" class="block text-sm font-medium text-gray-700 mb-2">
                        Gambar Utama
                    </label>
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center hover:border-blue-500 transition">
                        <input type="file" id="featured_image" name="featured_image" 
                               accept="image/*"
                               class="hidden"
                               onchange="previewImage(this)">
                        <label for="featured_image" class="cursor-pointer">
                            <div id="imagePreview" class="mb-3">
                                <i class="fas fa-image text-4xl text-gray-400"></i>
                            </div>
                            <p class="text-sm text-gray-600">Klik untuk upload</p>
                            <p class="text-xs text-gray-500 mt-1">JPG, PNG (Max: 5MB)</p>
                        </label>
                    </div>
                </div>

                <!-- Publish Status -->
                <div class="border-t pt-6">
                    <h4 class="text-sm font-semibold text-gray-700 mb-3">Status Publikasi</h4>
                    <label class="flex items-center cursor-pointer">
                        <input type="checkbox" name="is_published" value="1" 
                               class="form-checkbox text-blue-600 rounded"
                               <?= old('is_published', '1') ? 'checked' : '' ?>>
                        <span class="ml-2 text-sm text-gray-700">
                            <i class="fas fa-eye text-green-600"></i> Publikasikan sekarang
                        </span>
                    </label>
                    <p class="text-xs text-gray-500 mt-2 ml-6">Berita akan langsung tampil di website</p>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex gap-3 pt-6 border-t mt-6">
            <button type="submit" 
                    class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                <i class="fas fa-save mr-2"></i>Simpan
            </button>
            <a href="<?= base_url('admin/berita') ?>" 
               class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                <i class="fas fa-times mr-2"></i>Batal
            </a>
        </div>
    </form>
</div>

<script>
function previewImage(input) {
    const preview = document.getElementById('imagePreview');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            preview.innerHTML = '<img src="' + e.target.result + '" class="max-w-full h-auto rounded-lg shadow-md">';
        }
        
        reader.readAsDataURL(input.files[0]);
    }
}
</script>

<?= $this->endSection() ?>
