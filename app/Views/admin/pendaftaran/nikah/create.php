<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<div class="mb-6">
    <div class="flex items-center gap-2 text-sm text-gray-600 mb-4">
        <a href="<?= base_url('admin/pendaftaran') ?>" class="hover:text-blue-600">
            <i class="fas fa-clipboard-list"></i> Pendaftaran
        </a>
        <i class="fas fa-chevron-right text-xs"></i>
        <span class="text-gray-800">Pendaftaran Nikah</span>
    </div>
    <h2 class="text-2xl font-bold text-gray-800">
        <i class="fas fa-rings-wedding text-pink-600 mr-2"></i>Pendaftaran Pernikahan
    </h2>
</div>

<div class="bg-white rounded-lg shadow-md">
    <form action="<?= base_url('admin/pendaftaran/nikah/create') ?>" method="POST" enctype="multipart/form-data" class="p-6">
        <?= csrf_field() ?>
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Data Calon Suami -->
            <div class="space-y-6">
                <h3 class="text-lg font-semibold text-gray-800 border-b pb-2 bg-blue-50 -mx-6 px-6 py-3">
                    <i class="fas fa-male mr-2"></i>Data Calon Suami
                </h3>
                
                <div>
                    <label for="full_name" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Lengkap <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="full_name" name="full_name" 
                           value="<?= old('full_name') ?>"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="Nama lengkap calon suami">
                    <?php if (isset($validation) && $validation->hasError('full_name')): ?>
                        <p class="text-red-500 text-sm mt-1"><?= $validation->getError('full_name') ?></p>
                    <?php endif; ?>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="birth_place" class="block text-sm font-medium text-gray-700 mb-2">
                            Tempat Lahir
                        </label>
                        <input type="text" id="birth_place" name="birth_place" 
                               value="<?= old('birth_place') ?>"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    <div>
                        <label for="birth_date" class="block text-sm font-medium text-gray-700 mb-2">
                            Tanggal Lahir
                        </label>
                        <input type="date" id="birth_date" name="birth_date" 
                               value="<?= old('birth_date') ?>"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                </div>

                <div>
                    <label for="address" class="block text-sm font-medium text-gray-700 mb-2">
                        Alamat Lengkap
                    </label>
                    <textarea id="address" name="address" rows="3"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"><?= old('address') ?></textarea>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                            No. Telepon <span class="text-red-500">*</span>
                        </label>
                        <input type="tel" id="phone" name="phone" 
                               value="<?= old('phone') ?>"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               placeholder="08xx-xxxx-xxxx">
                        <?php if (isset($validation) && $validation->hasError('phone')): ?>
                            <p class="text-red-500 text-sm mt-1"><?= $validation->getError('phone') ?></p>
                        <?php endif; ?>
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            Email
                        </label>
                        <input type="email" id="email" name="email" 
                               value="<?= old('email') ?>"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                </div>
            </div>

            <!-- Data Calon Istri -->
            <div class="space-y-6">
                <h3 class="text-lg font-semibold text-gray-800 border-b pb-2 bg-pink-50 -mx-6 px-6 py-3">
                    <i class="fas fa-female mr-2"></i>Data Calon Istri
                </h3>
                
                <div>
                    <label for="partner_name" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Lengkap <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="partner_name" name="partner_name" 
                           value="<?= old('partner_name') ?>"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="Nama lengkap calon istri">
                    <?php if (isset($validation) && $validation->hasError('partner_name')): ?>
                        <p class="text-red-500 text-sm mt-1"><?= $validation->getError('partner_name') ?></p>
                    <?php endif; ?>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="partner_birth_place" class="block text-sm font-medium text-gray-700 mb-2">
                            Tempat Lahir
                        </label>
                        <input type="text" id="partner_birth_place" name="partner_birth_place" 
                               value="<?= old('partner_birth_place') ?>"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    <div>
                        <label for="partner_birth_date" class="block text-sm font-medium text-gray-700 mb-2">
                            Tanggal Lahir
                        </label>
                        <input type="date" id="partner_birth_date" name="partner_birth_date" 
                               value="<?= old('partner_birth_date') ?>"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                </div>

                <div>
                    <label for="partner_address" class="block text-sm font-medium text-gray-700 mb-2">
                        Alamat Lengkap
                    </label>
                    <textarea id="partner_address" name="partner_address" rows="3"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"><?= old('partner_address') ?></textarea>
                </div>

                <div>
                    <label for="partner_phone" class="block text-sm font-medium text-gray-700 mb-2">
                        No. Telepon
                    </label>
                    <input type="tel" id="partner_phone" name="partner_phone" 
                           value="<?= old('partner_phone') ?>"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="08xx-xxxx-xxxx">
                </div>
            </div>
        </div>

        <!-- Jadwal & Dokumen -->
        <div class="mt-6 pt-6 border-t">
            <h3 class="text-lg font-semibold text-gray-800 border-b pb-2 mb-6">
                <i class="fas fa-calendar-check mr-2"></i>Jadwal & Dokumen Pendukung
            </h3>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div>
                    <label for="preferred_date" class="block text-sm font-medium text-gray-700 mb-2">
                        Tanggal Pernikahan yang Diinginkan
                    </label>
                    <input type="date" id="preferred_date" name="preferred_date" 
                           value="<?= old('preferred_date') ?>"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>

                <div>
                    <label for="document" class="block text-sm font-medium text-gray-700 mb-2">
                        Upload Dokumen Pendukung
                    </label>
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center hover:border-blue-500 transition">
                        <input type="file" id="document" name="document" 
                               accept=".pdf,.jpg,.jpeg,.png"
                               class="hidden"
                               onchange="showFileName(this)">
                        <label for="document" class="cursor-pointer">
                            <i class="fas fa-upload text-3xl text-gray-400 mb-2"></i>
                            <p class="text-sm text-gray-600">Klik untuk upload</p>
                            <p class="text-xs text-gray-500 mt-1">PDF, JPG, PNG (Max: 5MB)</p>
                            <p id="fileName" class="text-xs text-blue-600 mt-2"></p>
                        </label>
                    </div>
                    <p class="text-xs text-gray-500 mt-2">
                        <i class="fas fa-info-circle mr-1"></i>
                        Dokumen: KTP, KK, Surat Baptis, Surat Keterangan, dll
                    </p>
                </div>
            </div>

            <div class="mt-6">
                <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                    Catatan Tambahan
                </label>
                <textarea id="notes" name="notes" rows="4"
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                          placeholder="Informasi tambahan yang perlu diketahui..."><?= old('notes') ?></textarea>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex gap-3 pt-6 border-t mt-6">
            <button type="submit" 
                    class="px-6 py-2 bg-pink-600 text-white rounded-lg hover:bg-pink-700 transition">
                <i class="fas fa-save mr-2"></i>Simpan Pendaftaran
            </button>
            <a href="<?= base_url('admin/pendaftaran?type=nikah') ?>" 
               class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                <i class="fas fa-times mr-2"></i>Batal
            </a>
        </div>
    </form>
</div>

<script>
function showFileName(input) {
    const fileName = document.getElementById('fileName');
    if (input.files && input.files[0]) {
        fileName.textContent = 'File: ' + input.files[0].name;
    }
}
</script>

<?= $this->endSection() ?>
