<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<div class="mb-6">
    <div class="flex items-center gap-2 text-sm text-gray-600 mb-4">
        <a href="<?= base_url('admin/jemaat/families') ?>" class="hover:text-blue-600">
            <i class="fas fa-home"></i> Data Keluarga
        </a>
        <i class="fas fa-chevron-right text-xs"></i>
        <span class="text-gray-800">Tambah Keluarga</span>
    </div>
    <h2 class="text-2xl font-bold text-gray-800">
        <i class="fas fa-plus-circle text-blue-600 mr-2"></i>Tambah Data Keluarga
    </h2>
</div>

<div class="bg-white rounded-lg shadow-md max-w-3xl">
    <form action="<?= base_url('admin/jemaat/families/create') ?>" method="POST" class="p-6">
        <?= csrf_field() ?>
        
        <div class="space-y-6">
            <div>
                <label for="family_name" class="block text-sm font-medium text-gray-700 mb-2">
                    Nama Keluarga <span class="text-red-500">*</span>
                </label>
                <input type="text" id="family_name" name="family_name" required
                       value="<?= old('family_name') ?>"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                       placeholder="Contoh: Keluarga Budi Santoso">
                <?php if (isset($validation) && $validation->hasError('family_name')): ?>
                    <p class="text-red-500 text-sm mt-1"><?= $validation->getError('family_name') ?></p>
                <?php endif; ?>
            </div>

            <div>
                <label for="head_of_family" class="block text-sm font-medium text-gray-700 mb-2">
                    Kepala Keluarga <span class="text-red-500">*</span>
                </label>
                <input type="text" id="head_of_family" name="head_of_family" required
                       value="<?= old('head_of_family') ?>"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                       placeholder="Nama lengkap kepala keluarga">
                <?php if (isset($validation) && $validation->hasError('head_of_family')): ?>
                    <p class="text-red-500 text-sm mt-1"><?= $validation->getError('head_of_family') ?></p>
                <?php endif; ?>
            </div>

            <div>
                <label for="address" class="block text-sm font-medium text-gray-700 mb-2">
                    Alamat Lengkap
                </label>
                <textarea id="address" name="address" rows="3"
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                          placeholder="Alamat lengkap keluarga"><?= old('address') ?></textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="wilayah" class="block text-sm font-medium text-gray-700 mb-2">
                        Wilayah
                    </label>
                    <input type="text" id="wilayah" name="wilayah"
                           value="<?= old('wilayah') ?>"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="Contoh: Wilayah 1">
                </div>

                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                        Nomor Telepon
                    </label>
                    <input type="tel" id="phone" name="phone"
                           value="<?= old('phone') ?>"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="08xx-xxxx-xxxx">
                </div>
            </div>

            <div>
                <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                    Catatan
                </label>
                <textarea id="notes" name="notes" rows="3"
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                          placeholder="Catatan tambahan (opsional)"><?= old('notes') ?></textarea>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex gap-3 pt-6 border-t mt-6">
            <button type="submit" 
                    class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                <i class="fas fa-save mr-2"></i>Simpan Keluarga
            </button>
            <a href="<?= base_url('admin/jemaat/families') ?>" 
               class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                <i class="fas fa-times mr-2"></i>Batal
            </a>
        </div>
    </form>
</div>

<?= $this->endSection() ?>
