<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<div class="mb-6">
    <div class="flex items-center gap-2 text-sm text-gray-600 mb-4">
        <a href="<?= base_url('admin/konfigurasi/menus') ?>" class="hover:text-blue-600">
            <i class="fas fa-bars"></i> Menu
        </a>
        <i class="fas fa-chevron-right text-xs"></i>
        <span class="text-gray-800">Tambah Menu</span>
    </div>
    <h2 class="text-2xl font-bold text-gray-800">Tambah Menu Baru</h2>
</div>

<div class="bg-white rounded-lg shadow-md">
    <form action="<?= base_url('admin/konfigurasi/menus/create') ?>" method="POST" class="p-6">
        <?= csrf_field() ?>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Left Column -->
            <div class="space-y-6">
                <!-- Title -->
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                        Judul Menu <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="title" name="title" 
                           value="<?= old('title') ?>"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="Contoh: Beranda">
                    <?php if (isset($validation) && $validation->hasError('title')): ?>
                        <p class="text-red-500 text-sm mt-1"><?= $validation->getError('title') ?></p>
                    <?php endif; ?>
                </div>

                <!-- URL -->
                <div>
                    <label for="url" class="block text-sm font-medium text-gray-700 mb-2">
                        URL
                    </label>
                    <input type="text" id="url" name="url" 
                           value="<?= old('url') ?>"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="Contoh: /beranda atau https://example.com">
                    <p class="text-xs text-gray-500 mt-1">Gunakan URL relatif (/) atau absolut (https://)</p>
                </div>

                <!-- Icon -->
                <div>
                    <label for="icon" class="block text-sm font-medium text-gray-700 mb-2">
                        Icon (Font Awesome)
                    </label>
                    <input type="text" id="icon" name="icon" 
                           value="<?= old('icon') ?>"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="Contoh: fas fa-home">
                    <p class="text-xs text-gray-500 mt-1">
                        Lihat icon di <a href="https://fontawesome.com/icons" target="_blank" class="text-blue-600 hover:underline">fontawesome.com</a>
                    </p>
                </div>

                <!-- Parent Menu -->
                <div>
                    <label for="parent_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Parent Menu
                    </label>
                    <select id="parent_id" name="parent_id" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">-- Tidak Ada (Menu Utama) --</option>
                        <?php foreach ($menus as $m): ?>
                            <option value="<?= $m['id'] ?>" <?= old('parent_id') == $m['id'] ? 'selected' : '' ?>>
                                <?= $m['title'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <p class="text-xs text-gray-500 mt-1">Pilih parent jika ini adalah sub menu</p>
                </div>
            </div>

            <!-- Right Column -->
            <div class="space-y-6">
                <!-- Position -->
                <div>
                    <label for="position" class="block text-sm font-medium text-gray-700 mb-2">
                        Posisi <span class="text-red-500">*</span>
                    </label>
                    <select id="position" name="position" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">-- Pilih Posisi --</option>
                        <option value="header" <?= old('position', 'header') == 'header' ? 'selected' : '' ?>>Header</option>
                        <option value="footer" <?= old('position') == 'footer' ? 'selected' : '' ?>>Footer</option>
                        <option value="sidebar" <?= old('position') == 'sidebar' ? 'selected' : '' ?>>Sidebar</option>
                    </select>
                    <?php if (isset($validation) && $validation->hasError('position')): ?>
                        <p class="text-red-500 text-sm mt-1"><?= $validation->getError('position') ?></p>
                    <?php endif; ?>
                </div>

                <!-- Target -->
                <div>
                    <label for="target" class="block text-sm font-medium text-gray-700 mb-2">
                        Target
                    </label>
                    <select id="target" name="target" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="_self" <?= old('target', '_self') == '_self' ? 'selected' : '' ?>>Tab yang Sama (_self)</option>
                        <option value="_blank" <?= old('target') == '_blank' ? 'selected' : '' ?>>Tab Baru (_blank)</option>
                    </select>
                </div>

                <!-- Order Position -->
                <div>
                    <label for="order_position" class="block text-sm font-medium text-gray-700 mb-2">
                        Urutan Tampil
                    </label>
                    <input type="number" id="order_position" name="order_position" 
                           value="<?= old('order_position', 0) ?>"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="0">
                    <p class="text-xs text-gray-500 mt-1">Semakin kecil angka, semakin awal ditampilkan</p>
                </div>

                <!-- Active Status -->
                <div>
                    <label class="flex items-center cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" 
                               class="form-checkbox text-blue-600 rounded"
                               <?= old('is_active', '1') ? 'checked' : '' ?>>
                        <span class="ml-2 text-sm text-gray-700">
                            <i class="fas fa-check-circle text-green-600"></i> Menu Aktif
                        </span>
                    </label>
                    <p class="text-xs text-gray-500 mt-1 ml-6">Menu yang aktif akan ditampilkan di website</p>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex gap-3 pt-6 border-t mt-6">
            <button type="submit" 
                    class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                <i class="fas fa-save mr-2"></i>Simpan
            </button>
            <a href="<?= base_url('admin/konfigurasi/menus') ?>" 
               class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                <i class="fas fa-times mr-2"></i>Batal
            </a>
        </div>
    </form>
</div>

<?= $this->endSection() ?>
