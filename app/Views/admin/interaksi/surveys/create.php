<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<div class="mb-6">
    <div class="flex items-center gap-2 text-sm text-gray-600 mb-4">
        <a href="<?= base_url('admin/interaksi/surveys') ?>" class="hover:text-blue-600">
            <i class="fas fa-poll"></i> Survei
        </a>
        <i class="fas fa-chevron-right text-xs"></i>
        <span class="text-gray-800">Tambah Survei</span>
    </div>
    <h2 class="text-2xl font-bold text-gray-800">
        <i class="fas fa-plus-circle text-blue-600 mr-2"></i>Tambah Survei / Jajak Pendapat
    </h2>
</div>

<div class="bg-white rounded-lg shadow-md max-w-3xl">
    <form action="<?= base_url('admin/interaksi/surveys/create') ?>" method="POST" class="p-6">
        <?= csrf_field() ?>
        
        <div class="space-y-6">
            <div>
                <label for="type" class="block text-sm font-medium text-gray-700 mb-2">
                    Tipe <span class="text-red-500">*</span>
                </label>
                <select id="type" name="type" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="survey" <?= old('type') == 'survey' ? 'selected' : '' ?>>Survei</option>
                    <option value="poll" <?= old('type') == 'poll' ? 'selected' : '' ?>>Jajak Pendapat (Poll)</option>
                </select>
                <p class="text-xs text-gray-500 mt-1">Survei: Banyak pertanyaan | Poll: 1 pertanyaan cepat</p>
                <?php if (isset($validation) && $validation->hasError('type')): ?>
                    <p class="text-red-500 text-sm mt-1"><?= $validation->getError('type') ?></p>
                <?php endif; ?>
            </div>

            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                    Judul <span class="text-red-500">*</span>
                </label>
                <input type="text" id="title" name="title" required
                       value="<?= old('title') ?>"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                       placeholder="Judul survei atau jajak pendapat">
                <?php if (isset($validation) && $validation->hasError('title')): ?>
                    <p class="text-red-500 text-sm mt-1"><?= $validation->getError('title') ?></p>
                <?php endif; ?>
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                    Deskripsi
                </label>
                <textarea id="description" name="description" rows="4"
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                          placeholder="Deskripsi atau penjelasan survei..."><?= old('description') ?></textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="start_date" class="block text-sm font-medium text-gray-700 mb-2">
                        Tanggal Mulai <span class="text-red-500">*</span>
                    </label>
                    <input type="date" id="start_date" name="start_date" required
                           value="<?= old('start_date', date('Y-m-d')) ?>"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <?php if (isset($validation) && $validation->hasError('start_date')): ?>
                        <p class="text-red-500 text-sm mt-1"><?= $validation->getError('start_date') ?></p>
                    <?php endif; ?>
                </div>

                <div>
                    <label for="end_date" class="block text-sm font-medium text-gray-700 mb-2">
                        Tanggal Selesai <span class="text-red-500">*</span>
                    </label>
                    <input type="date" id="end_date" name="end_date" required
                           value="<?= old('end_date', date('Y-m-d', strtotime('+30 days'))) ?>"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <?php if (isset($validation) && $validation->hasError('end_date')): ?>
                        <p class="text-red-500 text-sm mt-1"><?= $validation->getError('end_date') ?></p>
                    <?php endif; ?>
                </div>
            </div>

            <div>
                <label for="max_responses" class="block text-sm font-medium text-gray-700 mb-2">
                    Maksimal Responden
                </label>
                <input type="number" id="max_responses" name="max_responses"
                       value="<?= old('max_responses') ?>"
                       min="0"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                       placeholder="Kosongkan jika tidak ada batas">
                <p class="text-xs text-gray-500 mt-1">Batas jumlah responden (kosongkan untuk unlimited)</p>
            </div>

            <div class="space-y-3">
                <div class="flex items-center">
                    <input type="checkbox" id="is_active" name="is_active" value="1" checked
                           class="form-checkbox text-blue-600 rounded"
                           <?= old('is_active', '1') ? 'checked' : '' ?>>
                    <label for="is_active" class="ml-2 text-sm text-gray-700">
                        Aktifkan survei sekarang
                    </label>
                </div>

                <div class="flex items-center">
                    <input type="checkbox" id="is_anonymous" name="is_anonymous" value="1"
                           class="form-checkbox text-blue-600 rounded"
                           <?= old('is_anonymous') ? 'checked' : '' ?>>
                    <label for="is_anonymous" class="ml-2 text-sm text-gray-700">
                        Responden anonim (tidak perlu login)
                    </label>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex gap-3 pt-6 border-t mt-6">
            <button type="submit" 
                    class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                <i class="fas fa-save mr-2"></i>Simpan Survei
            </button>
            <a href="<?= base_url('admin/interaksi/surveys') ?>" 
               class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                <i class="fas fa-times mr-2"></i>Batal
            </a>
        </div>

        <div class="mt-4 p-4 bg-blue-50 rounded-lg">
            <p class="text-sm text-blue-800">
                <i class="fas fa-info-circle mr-2"></i>
                <strong>Catatan:</strong> Setelah menyimpan survei, Anda dapat menambahkan pertanyaan pada halaman berikutnya.
            </p>
        </div>
    </form>
</div>

<?= $this->endSection() ?>
