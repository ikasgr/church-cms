<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<div class="mb-6">
    <div class="flex items-center gap-2 text-sm text-gray-600 mb-4">
        <a href="<?= base_url('admin/umkm/categories') ?>" class="hover:text-blue-600">
            <i class="fas fa-tags"></i> Kategori
        </a>
        <i class="fas fa-chevron-right text-xs"></i>
        <span class="text-gray-800">Edit Kategori</span>
    </div>
    <h2 class="text-2xl font-bold text-gray-800">
        <i class="fas fa-edit text-blue-600 mr-2"></i>Edit Kategori: <?= $category['name'] ?>
    </h2>
</div>

<div class="bg-white rounded-lg shadow-md max-w-2xl">
    <form action="<?= base_url('admin/umkm/categories/edit/' . $category['id']) ?>" method="POST" class="p-6">
        <?= csrf_field() ?>
        
        <div class="space-y-6">
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                    Nama Kategori <span class="text-red-500">*</span>
                </label>
                <input type="text" id="name" name="name" required
                       value="<?= old('name', $category['name']) ?>"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <?php if (isset($validation) && $validation->hasError('name')): ?>
                    <p class="text-red-500 text-sm mt-1"><?= $validation->getError('name') ?></p>
                <?php endif; ?>
                <p class="text-xs text-gray-500 mt-1">Slug akan diupdate otomatis dari nama kategori</p>
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                    Deskripsi
                </label>
                <textarea id="description" name="description" rows="3"
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"><?= old('description', $category['description']) ?></textarea>
            </div>

            <div>
                <label for="icon" class="block text-sm font-medium text-gray-700 mb-2">
                    Icon Font Awesome
                </label>
                <input type="text" id="icon" name="icon"
                       value="<?= old('icon', $category['icon']) ?>"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <p class="text-xs text-gray-500 mt-1">
                    Gunakan class Font Awesome. Contoh: 
                    <code class="bg-gray-100 px-1 rounded">fas fa-utensils</code>, 
                    <code class="bg-gray-100 px-1 rounded">fas fa-tshirt</code>, 
                    <code class="bg-gray-100 px-1 rounded">fas fa-leaf</code>
                </p>
                <div class="mt-2 p-3 bg-gray-50 rounded-lg">
                    <p class="text-sm text-gray-700 mb-2">Preview Icon:</p>
                    <i id="iconPreview" class="<?= old('icon', $category['icon']) ?> text-3xl text-blue-600"></i>
                </div>
            </div>

            <div>
                <label for="order_position" class="block text-sm font-medium text-gray-700 mb-2">
                    Urutan Tampil
                </label>
                <input type="number" id="order_position" name="order_position"
                       value="<?= old('order_position', $category['order_position']) ?>"
                       min="0"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <p class="text-xs text-gray-500 mt-1">Semakin kecil angka, semakin awal ditampilkan</p>
            </div>

            <div>
                <label class="flex items-center cursor-pointer">
                    <input type="checkbox" name="is_active" value="1"
                           class="form-checkbox text-blue-600 rounded"
                           <?= old('is_active', $category['is_active']) ? 'checked' : '' ?>>
                    <span class="ml-2 text-sm text-gray-700">Aktif</span>
                </label>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex gap-3 pt-6 border-t mt-6">
            <button type="submit" 
                    class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                <i class="fas fa-save mr-2"></i>Update Kategori
            </button>
            <a href="<?= base_url('admin/umkm/categories') ?>" 
               class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                <i class="fas fa-times mr-2"></i>Batal
            </a>
        </div>
    </form>
</div>

<script>
// Live preview icon
document.getElementById('icon').addEventListener('input', function() {
    const iconPreview = document.getElementById('iconPreview');
    iconPreview.className = this.value + ' text-3xl text-blue-600';
});
</script>

<?= $this->endSection() ?>
