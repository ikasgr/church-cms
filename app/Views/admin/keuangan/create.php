<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<div class="bg-white rounded-lg shadow p-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
        <div>
            <h2 class="text-xl font-semibold text-gray-800">Tambah Transaksi Keuangan</h2>
            <p class="text-sm text-gray-600 mt-1">Catat pemasukan atau pengeluaran gereja</p>
        </div>
        <a href="<?= base_url('admin/keuangan') ?>" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition">
            <i class="fas fa-arrow-left mr-2"></i>Kembali
        </a>
    </div>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif ?>

    <form action="" method="POST" enctype="multipart/form-data" class="space-y-6">
        <?= csrf_field() ?>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Transaksi <span class="text-red-500">*</span></label>
                <select name="type" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" required>
                    <option value="">-- Pilih Jenis --</option>
                    <option value="penerimaan" <?= old('type') == 'penerimaan' ? 'selected' : '' ?>>Penerimaan</option>
                    <option value="pengeluaran" <?= old('type') == 'pengeluaran' ? 'selected' : '' ?>>Pengeluaran</option>
                </select>
                <?php if (isset($validation) && $validation->hasError('type')): ?>
                    <p class="text-sm text-red-600 mt-1"><?= $validation->getError('type') ?></p>
                <?php endif ?>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Kategori <span class="text-red-500">*</span></label>
                <input type="text" name="category" value="<?= old('category') ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" placeholder="Contoh: Persembahan Minggu" required>
                <?php if (isset($validation) && $validation->hasError('category')): ?>
                    <p class="text-sm text-red-600 mt-1"><?= $validation->getError('category') ?></p>
                <?php endif ?>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Transaksi <span class="text-red-500">*</span></label>
                <input type="date" name="transaction_date" value="<?= old('transaction_date') ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" required>
                <?php if (isset($validation) && $validation->hasError('transaction_date')): ?>
                    <p class="text-sm text-red-600 mt-1"><?= $validation->getError('transaction_date') ?></p>
                <?php endif ?>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nominal (Rp) <span class="text-red-500">*</span></label>
                <input type="number" name="amount" value="<?= old('amount') ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" placeholder="0" required>
                <?php if (isset($validation) && $validation->hasError('amount')): ?>
                    <p class="text-sm text-red-600 mt-1"><?= $validation->getError('amount') ?></p>
                <?php endif ?>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Sumber Dana</label>
                <input type="text" name="source" value="<?= old('source') ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" placeholder="Contoh: Persembahan Jemaat">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Unggah Bukti (Opsional)</label>
                <input type="file" name="receipt" accept="image/*" class="w-full text-sm text-gray-600">
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
            <textarea name="description" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" placeholder="Tuliskan detail transaksi"><?= old('description') ?></textarea>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Catatan Tambahan</label>
            <textarea name="notes" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" placeholder="Catatan internal jika diperlukan"><?= old('notes') ?></textarea>
        </div>

        <div class="flex justify-end gap-3">
            <a href="<?= base_url('admin/keuangan') ?>" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition">Batal</a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                <i class="fas fa-save mr-2"></i>Simpan Transaksi
            </button>
        </div>
    </form>
</div>

<?= $this->endSection() ?>
