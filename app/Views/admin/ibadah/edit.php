<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<div class="mb-6">
    <div class="flex items-center gap-2 text-sm text-gray-600 mb-4">
        <a href="<?= base_url('admin/ibadah') ?>" class="hover:text-blue-600">
            <i class="fas fa-church"></i> Jadwal Ibadah
        </a>
        <i class="fas fa-chevron-right text-xs"></i>
        <span class="text-gray-800">Edit Jadwal</span>
    </div>
    <h2 class="text-2xl font-bold text-gray-800">Edit Jadwal Ibadah</h2>
</div>

<div class="bg-white rounded-lg shadow-md">
    <form action="<?= base_url('admin/ibadah/edit/' . $ibadah['id']) ?>" method="POST" class="p-6">
        <?= csrf_field() ?>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Left Column -->
            <div class="space-y-6">
                <!-- Title -->
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Ibadah <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="title" name="title" 
                           value="<?= old('title', $ibadah['title']) ?>"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="Contoh: Ibadah Minggu Pagi">
                    <?php if (isset($validation) && $validation->hasError('title')): ?>
                        <p class="text-red-500 text-sm mt-1"><?= $validation->getError('title') ?></p>
                    <?php endif; ?>
                </div>

                <!-- Day of Week -->
                <div>
                    <label for="day_of_week" class="block text-sm font-medium text-gray-700 mb-2">
                        Hari <span class="text-red-500">*</span>
                    </label>
                    <select id="day_of_week" name="day_of_week" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">-- Pilih Hari --</option>
                        <option value="0" <?= old('day_of_week', $ibadah['day_of_week']) == '0' ? 'selected' : '' ?>>Minggu</option>
                        <option value="1" <?= old('day_of_week', $ibadah['day_of_week']) == '1' ? 'selected' : '' ?>>Senin</option>
                        <option value="2" <?= old('day_of_week', $ibadah['day_of_week']) == '2' ? 'selected' : '' ?>>Selasa</option>
                        <option value="3" <?= old('day_of_week', $ibadah['day_of_week']) == '3' ? 'selected' : '' ?>>Rabu</option>
                        <option value="4" <?= old('day_of_week', $ibadah['day_of_week']) == '4' ? 'selected' : '' ?>>Kamis</option>
                        <option value="5" <?= old('day_of_week', $ibadah['day_of_week']) == '5' ? 'selected' : '' ?>>Jumat</option>
                        <option value="6" <?= old('day_of_week', $ibadah['day_of_week']) == '6' ? 'selected' : '' ?>>Sabtu</option>
                    </select>
                    <?php if (isset($validation) && $validation->hasError('day_of_week')): ?>
                        <p class="text-red-500 text-sm mt-1"><?= $validation->getError('day_of_week') ?></p>
                    <?php endif; ?>
                </div>

                <!-- Time -->
                <div>
                    <label for="time" class="block text-sm font-medium text-gray-700 mb-2">
                        Waktu <span class="text-red-500">*</span>
                    </label>
                    <input type="time" id="time" name="time" 
                           value="<?= old('time', $ibadah['time']) ?>"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <?php if (isset($validation) && $validation->hasError('time')): ?>
                        <p class="text-red-500 text-sm mt-1"><?= $validation->getError('time') ?></p>
                    <?php endif; ?>
                </div>

                <!-- Location -->
                <div>
                    <label for="location" class="block text-sm font-medium text-gray-700 mb-2">
                        Lokasi
                    </label>
                    <input type="text" id="location" name="location" 
                           value="<?= old('location', $ibadah['location']) ?>"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="Contoh: Gereja Utama">
                </div>
            </div>

            <!-- Right Column -->
            <div class="space-y-6">
                <!-- Minister -->
                <div>
                    <label for="minister" class="block text-sm font-medium text-gray-700 mb-2">
                        Pelayan/Pendeta
                    </label>
                    <input type="text" id="minister" name="minister" 
                           value="<?= old('minister', $ibadah['minister']) ?>"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="Contoh: Pdt. John Doe">
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                        Deskripsi
                    </label>
                    <textarea id="description" name="description" rows="4"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                              placeholder="Deskripsi singkat tentang ibadah ini"><?= old('description', $ibadah['description']) ?></textarea>
                </div>

                <!-- Active Status -->
                <div>
                    <label class="flex items-center cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" 
                               class="form-checkbox text-blue-600 rounded"
                               <?= old('is_active', $ibadah['is_active']) ? 'checked' : '' ?>>
                        <span class="ml-2 text-sm text-gray-700">
                            <i class="fas fa-check-circle text-green-600"></i> Jadwal Aktif
                        </span>
                    </label>
                    <p class="text-xs text-gray-500 mt-1 ml-6">Jadwal yang aktif akan ditampilkan di website</p>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex gap-3 pt-6 border-t mt-6">
            <button type="submit" 
                    class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                <i class="fas fa-save mr-2"></i>Update
            </button>
            <a href="<?= base_url('admin/ibadah') ?>" 
               class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                <i class="fas fa-times mr-2"></i>Batal
            </a>
        </div>
    </form>
</div>

<?= $this->endSection() ?>
