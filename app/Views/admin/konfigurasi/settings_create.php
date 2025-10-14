<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<div class="mb-6">
    <div class="flex items-center gap-2 text-sm text-gray-600 mb-4">
        <a href="<?= base_url('admin/konfigurasi/settings') ?>" class="hover:text-blue-600">
            <i class="fas fa-cog"></i> Pengaturan
        </a>
        <i class="fas fa-chevron-right text-xs"></i>
        <span class="text-gray-800">Tambah Pengaturan</span>
    </div>
    <h2 class="text-2xl font-bold text-gray-800">Tambah Pengaturan Baru</h2>
</div>

<div class="bg-white rounded-lg shadow-md">
    <form action="<?= base_url('admin/konfigurasi/settings/create') ?>" method="POST" class="p-6">
        <?= csrf_field() ?>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Left Column -->
            <div class="space-y-6">
                <!-- Key -->
                <div>
                    <label for="key" class="block text-sm font-medium text-gray-700 mb-2">
                        Key (Kunci) <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="key" name="key" 
                           value="<?= old('key') ?>"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="Contoh: site_name">
                    <?php if (isset($validation) && $validation->hasError('key')): ?>
                        <p class="text-red-500 text-sm mt-1"><?= $validation->getError('key') ?></p>
                    <?php endif; ?>
                    <p class="text-xs text-gray-500 mt-1">Gunakan format snake_case (huruf kecil dengan underscore)</p>
                </div>

                <!-- Type -->
                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700 mb-2">
                        Tipe Data <span class="text-red-500">*</span>
                    </label>
                    <select id="type" name="type" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">-- Pilih Tipe --</option>
                        <option value="text" <?= old('type') == 'text' ? 'selected' : '' ?>>Text (Teks Pendek)</option>
                        <option value="textarea" <?= old('type') == 'textarea' ? 'selected' : '' ?>>Textarea (Teks Panjang)</option>
                        <option value="number" <?= old('type') == 'number' ? 'selected' : '' ?>>Number (Angka)</option>
                        <option value="boolean" <?= old('type') == 'boolean' ? 'selected' : '' ?>>Boolean (Ya/Tidak)</option>
                        <option value="json" <?= old('type') == 'json' ? 'selected' : '' ?>>JSON (Data Terstruktur)</option>
                    </select>
                    <?php if (isset($validation) && $validation->hasError('type')): ?>
                        <p class="text-red-500 text-sm mt-1"><?= $validation->getError('type') ?></p>
                    <?php endif; ?>
                </div>

                <!-- Group -->
                <div>
                    <label for="group" class="block text-sm font-medium text-gray-700 mb-2">
                        Grup
                    </label>
                    <select id="group" name="group" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="general" <?= old('group', 'general') == 'general' ? 'selected' : '' ?>>Umum</option>
                        <option value="email" <?= old('group') == 'email' ? 'selected' : '' ?>>Email</option>
                        <option value="theme" <?= old('group') == 'theme' ? 'selected' : '' ?>>Tema</option>
                        <option value="social" <?= old('group') == 'social' ? 'selected' : '' ?>>Media Sosial</option>
                    </select>
                </div>
            </div>

            <!-- Right Column -->
            <div class="space-y-6">
                <!-- Value -->
                <div>
                    <label for="value" class="block text-sm font-medium text-gray-700 mb-2">
                        Nilai <span class="text-red-500">*</span>
                    </label>
                    <textarea id="value" name="value" rows="4"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                              placeholder="Masukkan nilai pengaturan"><?= old('value') ?></textarea>
                    <?php if (isset($validation) && $validation->hasError('value')): ?>
                        <p class="text-red-500 text-sm mt-1"><?= $validation->getError('value') ?></p>
                    <?php endif; ?>
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                        Deskripsi
                    </label>
                    <textarea id="description" name="description" rows="4"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                              placeholder="Deskripsi singkat tentang pengaturan ini"><?= old('description') ?></textarea>
                    <p class="text-xs text-gray-500 mt-1">Penjelasan untuk memudahkan pengelolaan</p>
                </div>
            </div>
        </div>

        <!-- Examples -->
        <div class="mt-6 p-4 bg-blue-50 rounded-lg">
            <h4 class="text-sm font-semibold text-blue-800 mb-2">
                <i class="fas fa-info-circle mr-1"></i>Contoh Pengaturan:
            </h4>
            <div class="text-xs text-blue-700 space-y-1">
                <p><strong>Key:</strong> site_name | <strong>Type:</strong> text | <strong>Value:</strong> Gereja FLOBAMORA</p>
                <p><strong>Key:</strong> items_per_page | <strong>Type:</strong> number | <strong>Value:</strong> 10</p>
                <p><strong>Key:</strong> enable_registration | <strong>Type:</strong> boolean | <strong>Value:</strong> 1</p>
                <p><strong>Key:</strong> social_links | <strong>Type:</strong> json | <strong>Value:</strong> {"facebook":"url","instagram":"url"}</p>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex gap-3 pt-6 border-t mt-6">
            <button type="submit" 
                    class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                <i class="fas fa-save mr-2"></i>Simpan
            </button>
            <a href="<?= base_url('admin/konfigurasi/settings') ?>" 
               class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                <i class="fas fa-times mr-2"></i>Batal
            </a>
        </div>
    </form>
</div>

<?= $this->endSection() ?>
