<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<div class="mb-6">
    <div class="flex items-center gap-2 text-sm text-gray-600 mb-4">
        <a href="<?= base_url('admin/pendaftaran') ?>" class="hover:text-blue-600">
            <i class="fas fa-clipboard-list"></i> Pendaftaran
        </a>
        <i class="fas fa-chevron-right text-xs"></i>
        <span class="text-gray-800">Pendaftaran Sidi</span>
    </div>
    <h2 class="text-2xl font-bold text-gray-800">
        <i class="fas fa-cross text-purple-600 mr-2"></i>Pendaftaran Sidi
    </h2>
</div>

<div class="bg-white rounded-lg shadow-md">
    <form action="<?= base_url('admin/pendaftaran/sidi/create') ?>" method="POST" enctype="multipart/form-data" class="p-6">
        <?= csrf_field() ?>
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Data Pribadi -->
            <div class="space-y-6">
                <h3 class="text-lg font-semibold text-gray-800 border-b pb-2">
                    <i class="fas fa-user mr-2"></i>Data Pribadi
                </h3>
                
                <div>
                    <label for="full_name" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Lengkap <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="full_name" name="full_name" 
                           value="<?= old('full_name') ?>"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="Nama lengkap calon sidi">
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
                            Tanggal Lahir <span class="text-red-500">*</span>
                        </label>
                        <input type="date" id="birth_date" name="birth_date" 
                               value="<?= old('birth_date') ?>"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <?php if (isset($validation) && $validation->hasError('birth_date')): ?>
                            <p class="text-red-500 text-sm mt-1"><?= $validation->getError('birth_date') ?></p>
                        <?php endif; ?>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Jenis Kelamin
                    </label>
                    <div class="flex gap-4">
                        <label class="flex items-center cursor-pointer">
                            <input type="radio" name="gender" value="L" 
                                   class="form-radio text-blue-600"
                                   <?= old('gender', 'L') == 'L' ? 'checked' : '' ?>>
                            <span class="ml-2">Laki-laki</span>
                        </label>
                        <label class="flex items-center cursor-pointer">
                            <input type="radio" name="gender" value="P" 
                                   class="form-radio text-blue-600"
                                   <?= old('gender') == 'P' ? 'checked' : '' ?>>
                            <span class="ml-2">Perempuan</span>
                        </label>
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

            <!-- Data Baptis & Jadwal -->
            <div class="space-y-6">
                <h3 class="text-lg font-semibold text-gray-800 border-b pb-2">
                    <i class="fas fa-water mr-2"></i>Data Baptis
                </h3>
                
                <div>
                    <label for="baptism_place" class="block text-sm font-medium text-gray-700 mb-2">
                        Tempat Baptis
                    </label>
                    <input type="text" id="baptism_place" name="baptism_place" 
                           value="<?= old('baptism_place') ?>"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="Nama gereja tempat baptis">
                </div>

                <div>
                    <label for="baptism_date" class="block text-sm font-medium text-gray-700 mb-2">
                        Tanggal Baptis
                    </label>
                    <input type="date" id="baptism_date" name="baptism_date" 
                           value="<?= old('baptism_date') ?>"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>

                <h3 class="text-lg font-semibold text-gray-800 border-b pb-2 mt-6">
                    <i class="fas fa-calendar mr-2"></i>Jadwal & Dokumen
                </h3>

                <div>
                    <label for="preferred_date" class="block text-sm font-medium text-gray-700 mb-2">
                        Tanggal Sidi yang Diinginkan
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
                        Dokumen: Surat Baptis, KTP, KK, atau dokumen pendukung lainnya
                    </p>
                </div>

                <div>
                    <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                        Catatan Tambahan
                    </label>
                    <textarea id="notes" name="notes" rows="4"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                              placeholder="Informasi tambahan yang perlu diketahui..."><?= old('notes') ?></textarea>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex gap-3 pt-6 border-t mt-6">
            <button type="submit" 
                    class="px-6 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">
                <i class="fas fa-save mr-2"></i>Simpan Pendaftaran
            </button>
            <a href="<?= base_url('admin/pendaftaran?type=sidi') ?>" 
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
