<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<div class="mb-6">
    <div class="flex items-center gap-2 text-sm text-gray-600 mb-4">
        <a href="<?= base_url('admin/ibadah/kegiatan') ?>" class="hover:text-blue-600">
            <i class="fas fa-calendar-alt"></i> Kegiatan Gereja
        </a>
        <i class="fas fa-chevron-right text-xs"></i>
        <span class="text-gray-800">Edit Kegiatan</span>
    </div>
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">
                <i class="fas fa-edit text-blue-600 mr-2"></i>Edit Kegiatan</h2>
            <p class="text-sm text-gray-600 mt-1">Perbarui informasi detail kegiatan gereja</p>
        </div>
        <a href="<?= base_url('admin/ibadah/kegiatan/view/' . $kegiatan['id']) ?>" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
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
    <form action="<?= base_url('admin/ibadah/kegiatan/edit/' . $kegiatan['id']) ?>" method="POST" enctype="multipart/form-data" class="p-6 space-y-8">
        <?= csrf_field() ?>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Informasi Kegiatan -->
            <div class="lg:col-span-2 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Judul Kegiatan <span class="text-red-500">*</span></label>
                        <input type="text" id="title" name="title" required
                               value="<?= old('title', $kegiatan['title']) ?>"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <?php if (isset($validation) && $validation->hasError('title')): ?>
                            <p class="text-red-500 text-sm mt-1"><?= $validation->getError('title') ?></p>
                        <?php endif; ?>
                    </div>
                    <div>
                        <label for="category" class="block text-sm font-medium text-gray-700 mb-2">Kategori <span class="text-red-500">*</span></label>
                        <select id="category" name="category" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <?php
                            $categories = [
                                'ibadah' => 'Ibadah',
                                'seminar' => 'Seminar',
                                'pelayanan' => 'Pelayanan',
                                'komunitas' => 'Komunitas',
                                'lainnya' => 'Lainnya'
                            ];
                            $selectedCategory = old('category', $kegiatan['category']);
                            ?>
                            <?php foreach ($categories as $value => $label): ?>
                                <option value="<?= $value ?>" <?= $selectedCategory === $value ? 'selected' : '' ?>><?= $label ?></option>
                            <?php endforeach; ?>
                        </select>
                        <?php if (isset($validation) && $validation->hasError('category')): ?>
                            <p class="text-red-500 text-sm mt-1"><?= $validation->getError('category') ?></p>
                        <?php endif; ?>
                    </div>
                    <div>
                        <label for="max_participants" class="block text-sm font-medium text-gray-700 mb-2">Kapasitas Peserta</label>
                        <input type="number" id="max_participants" name="max_participants" min="0"
                               value="<?= old('max_participants', $kegiatan['max_participants']) ?>"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               placeholder="Kosongkan jika tidak dibatasi">
                    </div>
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                    <textarea id="description" name="description" rows="6"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                              placeholder="Tuliskan rundown atau informasi kegiatan"><?= old('description', $kegiatan['description']) ?></textarea>
                </div>

                <div class="border-t pt-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">
                        <i class="fas fa-clock mr-2"></i>Waktu Pelaksanaan
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="date_start" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Mulai <span class="text-red-500">*</span></label>
                            <input type="date" id="date_start" name="date_start" required
                                   value="<?= old('date_start', $kegiatan['date_start']) ?>"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <?php if (isset($validation) && $validation->hasError('date_start')): ?>
                                <p class="text-red-500 text-sm mt-1"><?= $validation->getError('date_start') ?></p>
                            <?php endif; ?>
                        </div>
                        <div>
                            <label for="date_end" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Selesai</label>
                            <input type="date" id="date_end" name="date_end"
                                   value="<?= old('date_end', $kegiatan['date_end']) ?>"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                        <div>
                            <label for="time_start" class="block text-sm font-medium text-gray-700 mb-2">Jam Mulai</label>
                            <input type="time" id="time_start" name="time_start"
                                   value="<?= old('time_start', $kegiatan['time_start']) ?>"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                        <div>
                            <label for="time_end" class="block text-sm font-medium text-gray-700 mb-2">Jam Selesai</label>
                            <input type="time" id="time_end" name="time_end"
                                   value="<?= old('time_end', $kegiatan['time_end']) ?>"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                    </div>
                </div>

                <div class="border-t pt-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">
                        <i class="fas fa-map-marker-alt mr-2"></i>Lokasi & Penanggung Jawab
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label for="location" class="block text-sm font-medium text-gray-700 mb-2">Lokasi</label>
                            <input type="text" id="location" name="location"
                                   value="<?= old('location', $kegiatan['location']) ?>"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="Contoh: Aula Gereja, Ruang Serbaguna">
                        </div>
                        <div>
                            <label for="organizer" class="block text-sm font-medium text-gray-700 mb-2">Penyelenggara</label>
                            <input type="text" id="organizer" name="organizer"
                                   value="<?= old('organizer', $kegiatan['organizer']) ?>"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                        <div>
                            <label for="contact_person" class="block text-sm font-medium text-gray-700 mb-2">Kontak Person</label>
                            <input type="text" id="contact_person" name="contact_person"
                                   value="<?= old('contact_person', $kegiatan['contact_person']) ?>"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                        <div>
                            <label for="contact_phone" class="block text-sm font-medium text-gray-700 mb-2">Nomor Kontak</label>
                            <input type="text" id="contact_phone" name="contact_phone"
                                   value="<?= old('contact_phone', $kegiatan['contact_phone']) ?>"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                    </div>
                </div>

                <div class="border-t pt-6 flex flex-wrap gap-6">
                    <label class="flex items-center text-sm text-gray-700">
                        <input type="checkbox" name="registration_required" value="1"
                               class="form-checkbox text-blue-600 rounded"
                               <?= old('registration_required', $kegiatan['registration_required']) ? 'checked' : '' ?>>
                        <span class="ml-2"><i class="fas fa-clipboard-list mr-1"></i>Pendaftaran diperlukan</span>
                    </label>
                    <label class="flex items-center text-sm text-gray-700">
                        <input type="checkbox" name="is_published" value="1"
                               class="form-checkbox text-blue-600 rounded"
                               <?= old('is_published', $kegiatan['is_published']) ? 'checked' : '' ?>>
                        <span class="ml-2"><i class="fas fa-eye mr-1"></i>Tampilkan di publik</span>
                    </label>
                </div>
            </div>

            <!-- Gambar Kegiatan -->
            <div class="space-y-6">
                <div class="bg-gray-50 rounded-lg border p-6 text-center">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Poster / Banner</h3>
                    <div id="imagePreview" class="mb-4">
                        <?php if (!empty($kegiatan['image'])): ?>
                            <img src="<?= base_url('uploads/kegiatan/' . $kegiatan['image']) ?>" alt="Gambar Kegiatan" class="w-full rounded-lg shadow-md">
                        <?php else: ?>
                            <div class="h-48 flex items-center justify-center bg-blue-100 rounded-lg">
                                <i class="fas fa-image text-4xl text-blue-500"></i>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 hover:border-blue-500 transition">
                        <input type="file" id="image" name="image" accept="image/*" class="hidden" onchange="previewImage(this)">
                        <label for="image" class="cursor-pointer text-sm text-gray-600">
                            Klik untuk upload poster baru
                            <p class="text-xs text-gray-500 mt-1">Format JPG/PNG, maksimal 2MB</p>
                        </label>
                    </div>
                </div>

                <div class="bg-blue-50 rounded-lg p-4 text-sm text-blue-700">
                    <p class="font-semibold mb-2"><i class="fas fa-info-circle mr-2"></i>Tips Kegiatan</p>
                    <ul class="space-y-2 list-disc list-inside">
                        <li>Pastikan jadwal dan lokasi sudah dikonfirmasi.</li>
                        <li>Gunakan poster beresolusi tinggi agar tampil tajam.</li>
                        <li>Aktifkan publikasi agar kegiatan tampil di website.</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="flex gap-3 pt-6 border-t">
            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                <i class="fas fa-save mr-2"></i>Simpan Perubahan
            </button>
            <a href="<?= base_url('admin/ibadah/kegiatan') ?>" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                <i class="fas fa-times mr-2"></i>Batal
            </a>
        </div>
    </form>
</div>

<script>
function previewImage(input) {
    const preview = document.getElementById('imagePreview');
    if (!preview) {
        return;
    }

    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = '<img src="' + e.target.result + '" class="w-full rounded-lg shadow-md">';
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>

<?= $this->endSection() ?>
