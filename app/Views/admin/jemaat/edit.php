<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<div class="mb-6">
    <div class="flex items-center gap-2 text-sm text-gray-600 mb-4">
        <a href="<?= base_url('admin/jemaat') ?>" class="hover:text-blue-600">
            <i class="fas fa-users"></i> Data Jemaat
        </a>
        <i class="fas fa-chevron-right text-xs"></i>
        <span class="text-gray-800">Edit Jemaat</span>
    </div>
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">
                <i class="fas fa-user-edit text-blue-600 mr-2"></i>Edit Data Jemaat
            </h2>
            <p class="text-sm text-gray-600 mt-1">Perbarui informasi jemaat berikut</p>
        </div>
        <a href="<?= base_url('admin/jemaat/view/' . $jemaat['id']) ?>" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
            <i class="fas fa-eye mr-2"></i>Lihat Detail
        </a>
    </div>
</div>

<?php if (session()->getFlashdata('error')): ?>
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6">
        <i class="fas fa-exclamation-circle mr-2"></i><?= session()->getFlashdata('error') ?>
    </div>
<?php endif; ?>

<div class="bg-white rounded-lg shadow-md">
    <form action="<?= base_url('admin/jemaat/edit/' . $jemaat['id']) ?>" method="POST" enctype="multipart/form-data" class="p-6">
        <?= csrf_field() ?>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Kolom kiri: Informasi Jemaat -->
            <div class="lg:col-span-2 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="no_induk" class="block text-sm font-medium text-gray-700 mb-2">Nomor Induk <span class="text-red-500">*</span></label>
                        <input type="text" id="no_induk" name="no_induk" required
                               value="<?= old('no_induk', $jemaat['no_induk']) ?>"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <?php if (isset($validation) && $validation->hasError('no_induk')): ?>
                            <p class="text-red-500 text-sm mt-1"><?= $validation->getError('no_induk') ?></p>
                        <?php endif; ?>
                    </div>
                    <div>
                        <label for="family_id" class="block text-sm font-medium text-gray-700 mb-2">Keluarga</label>
                        <select id="family_id" name="family_id"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">-- Pilih Keluarga --</option>
                            <?php foreach ($families as $family): ?>
                                <option value="<?= $family['id'] ?>" <?= old('family_id', $jemaat['family_id']) == $family['id'] ? 'selected' : '' ?>>
                                    <?= $family['family_name'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="md:col-span-2">
                        <label for="full_name" class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                        <input type="text" id="full_name" name="full_name" required
                               value="<?= old('full_name', $jemaat['full_name']) ?>"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <?php if (isset($validation) && $validation->hasError('full_name')): ?>
                            <p class="text-red-500 text-sm mt-1"><?= $validation->getError('full_name') ?></p>
                        <?php endif; ?>
                    </div>
                    <div>
                        <label for="gender" class="block text-sm font-medium text-gray-700 mb-2">Jenis Kelamin <span class="text-red-500">*</span></label>
                        <select id="gender" name="gender" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="L" <?= old('gender', $jemaat['gender']) == 'L' ? 'selected' : '' ?>>Laki-Laki</option>
                            <option value="P" <?= old('gender', $jemaat['gender']) == 'P' ? 'selected' : '' ?>>Perempuan</option>
                        </select>
                        <?php if (isset($validation) && $validation->hasError('gender')): ?>
                            <p class="text-red-500 text-sm mt-1"><?= $validation->getError('gender') ?></p>
                        <?php endif; ?>
                    </div>
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                        <select id="status" name="status"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="aktif" <?= old('status', $jemaat['status']) == 'aktif' ? 'selected' : '' ?>>Aktif</option>
                            <option value="nonaktif" <?= old('status', $jemaat['status']) == 'nonaktif' ? 'selected' : '' ?>>Non-Aktif</option>
                            <option value="pindah" <?= old('status', $jemaat['status']) == 'pindah' ? 'selected' : '' ?>>Pindah</option>
                            <option value="meninggal" <?= old('status', $jemaat['status']) == 'meninggal' ? 'selected' : '' ?>>Meninggal</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="birth_place" class="block text-sm font-medium text-gray-700 mb-2">Tempat Lahir</label>
                        <input type="text" id="birth_place" name="birth_place"
                               value="<?= old('birth_place', $jemaat['birth_place']) ?>"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    <div>
                        <label for="birth_date" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Lahir</label>
                        <input type="date" id="birth_date" name="birth_date"
                               value="<?= old('birth_date', $jemaat['birth_date']) ?>"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <?php if (isset($validation) && $validation->hasError('birth_date')): ?>
                            <p class="text-red-500 text-sm mt-1"><?= $validation->getError('birth_date') ?></p>
                        <?php endif; ?>
                    </div>
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Telepon</label>
                        <input type="text" id="phone" name="phone"
                               value="<?= old('phone', $jemaat['phone']) ?>"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <input type="email" id="email" name="email"
                               value="<?= old('email', $jemaat['email']) ?>"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <?php if (isset($validation) && $validation->hasError('email')): ?>
                            <p class="text-red-500 text-sm mt-1"><?= $validation->getError('email') ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="md:col-span-2">
                        <label for="address" class="block text-sm font-medium text-gray-700 mb-2">Alamat</label>
                        <textarea id="address" name="address" rows="3"
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"><?= old('address', $jemaat['address']) ?></textarea>
                    </div>
                    <div>
                        <label for="wilayah" class="block text-sm font-medium text-gray-700 mb-2">Wilayah</label>
                        <input type="text" id="wilayah" name="wilayah"
                               value="<?= old('wilayah', $jemaat['wilayah']) ?>"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                </div>

                <div class="border-t pt-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">
                        <i class="fas fa-cross mr-2"></i>Informasi Sakramen
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="baptis_date" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Baptis</label>
                            <input type="date" id="baptis_date" name="baptis_date"
                                   value="<?= old('baptis_date', $jemaat['baptis_date']) ?>"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                        <div>
                            <label for="baptis_place" class="block text-sm font-medium text-gray-700 mb-2">Tempat Baptis</label>
                            <input type="text" id="baptis_place" name="baptis_place"
                                   value="<?= old('baptis_place', $jemaat['baptis_place']) ?>"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                        <div>
                            <label for="sidi_date" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Sidi</label>
                            <input type="date" id="sidi_date" name="sidi_date"
                                   value="<?= old('sidi_date', $jemaat['sidi_date']) ?>"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                        <div>
                            <label for="sidi_place" class="block text-sm font-medium text-gray-700 mb-2">Tempat Sidi</label>
                            <input type="text" id="sidi_place" name="sidi_place"
                                   value="<?= old('sidi_place', $jemaat['sidi_place']) ?>"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                    </div>
                </div>

                <div class="border-t pt-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">
                        <i class="fas fa-ring mr-2"></i>Informasi Pernikahan
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="marriage_date" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Pernikahan</label>
                            <input type="date" id="marriage_date" name="marriage_date"
                                   value="<?= old('marriage_date', $jemaat['marriage_date']) ?>"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                        <div>
                            <label for="marriage_place" class="block text-sm font-medium text-gray-700 mb-2">Tempat Pernikahan</label>
                            <input type="text" id="marriage_place" name="marriage_place"
                                   value="<?= old('marriage_place', $jemaat['marriage_place']) ?>"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus;border-transparent">
                        </div>
                        <div class="md:col-span-2">
                            <label for="spouse_name" class="block text-sm font-medium text-gray-700 mb-2">Nama Pasangan</label>
                            <input type="text" id="spouse_name" name="spouse_name"
                                   value="<?= old('spouse_name', $jemaat['spouse_name']) ?>"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                    </div>
                </div>

                <div class="border-t pt-6">
                    <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">Catatan</label>
                    <textarea id="notes" name="notes" rows="4"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"><?= old('notes', $jemaat['notes']) ?></textarea>
                </div>
            </div>

            <!-- Kolom kanan: Foto Profil -->
            <div class="space-y-6">
                <div class="bg-gray-50 rounded-lg border p-6 text-center">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Foto Jemaat</h3>
                    <div class="mb-4" id="photoPreview">
                        <?php if (!empty($jemaat['photo'])): ?>
                            <img src="<?= base_url('uploads/jemaat/' . $jemaat['photo']) ?>" alt="Foto Jemaat" class="w-48 h-48 object-cover mx-auto rounded-full shadow-lg">
                        <?php else: ?>
                            <div class="w-48 h-48 mx-auto rounded-full bg-blue-100 flex items-center justify-center">
                                <i class="fas fa-user text-5xl text-blue-600"></i>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 hover:border-blue-500 transition">
                        <input type="file" id="photo" name="photo" accept="image/*" class="hidden" onchange="previewPhoto(this)">
                        <label for="photo" class="cursor-pointer">
                            <p class="text-sm text-gray-600">Klik untuk upload foto baru</p>
                            <p class="text-xs text-gray-500 mt-1">Format JPG/PNG, maksimal 2MB</p>
                        </label>
                    </div>
                </div>

                <div class="bg-blue-50 rounded-lg p-4 text-sm text-blue-700">
                    <p class="font-semibold mb-2"><i class="fas fa-info-circle mr-2"></i>Tips Data Jemaat</p>
                    <ul class="space-y-2 list-disc list-inside">
                        <li>Pastikan nomor induk unik untuk setiap jemaat.</li>
                        <li>Isi tanggal sakramen hanya jika jemaat sudah menerimanya.</li>
                        <li>Klik "Reset" pada browser jika ingin membatalkan perubahan.</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="flex gap-3 pt-6 border-t mt-6">
            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                <i class="fas fa-save mr-2"></i>Simpan Perubahan
            </button>
            <a href="<?= base_url('admin/jemaat') ?>" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                <i class="fas fa-times mr-2"></i>Batal
            </a>
        </div>
    </form>
</div>

<script>
function previewPhoto(input) {
    const previewContainer = document.getElementById('photoPreview');
    if (!previewContainer) {
        return;
    }

    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            previewContainer.innerHTML = '<img src="' + e.target.result + '" class="w-48 h-48 object-cover mx-auto rounded-full shadow-lg">';
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>

<?= $this->endSection() ?>
