<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<div class="mb-6">
    <div class="flex items-center gap-2 text-sm text-gray-600 mb-4">
        <a href="<?= base_url('admin/umkm/products') ?>" class="hover:text-blue-600">
            <i class="fas fa-box"></i> Produk
        </a>
        <i class="fas fa-chevron-right text-xs"></i>
        <span class="text-gray-800">Tambah Produk</span>
    </div>
    <h2 class="text-2xl font-bold text-gray-800">
        <i class="fas fa-plus-circle text-blue-600 mr-2"></i>Tambah Produk UMKM
    </h2>
</div>

<div class="bg-white rounded-lg shadow-md">
    <form action="<?= base_url('admin/umkm/products/create') ?>" method="POST" enctype="multipart/form-data" class="p-6">
        <?= csrf_field() ?>
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Informasi Dasar -->
            <div class="space-y-6">
                <h3 class="text-lg font-semibold text-gray-800 border-b pb-2">
                    <i class="fas fa-info-circle mr-2"></i>Informasi Dasar
                </h3>
                
                <div>
                    <label for="seller_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Pelapak <span class="text-red-500">*</span>
                    </label>
                    <select id="seller_id" name="seller_id" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">-- Pilih Pelapak --</option>
                        <?php foreach ($sellers as $seller): ?>
                            <option value="<?= $seller['id'] ?>" <?= old('seller_id') == $seller['id'] ? 'selected' : '' ?>>
                                <?= $seller['business_name'] ?> (<?= $seller['owner_name'] ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?php if (isset($validation) && $validation->hasError('seller_id')): ?>
                        <p class="text-red-500 text-sm mt-1"><?= $validation->getError('seller_id') ?></p>
                    <?php endif; ?>
                </div>

                <div>
                    <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Kategori
                    </label>
                    <select id="category_id" name="category_id"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">-- Pilih Kategori --</option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= $category['id'] ?>" <?= old('category_id') == $category['id'] ? 'selected' : '' ?>>
                                <?= $category['name'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Produk <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="name" name="name" required
                           value="<?= old('name') ?>"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="Nama produk">
                    <?php if (isset($validation) && $validation->hasError('name')): ?>
                        <p class="text-red-500 text-sm mt-1"><?= $validation->getError('name') ?></p>
                    <?php endif; ?>
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                        Deskripsi Produk
                    </label>
                    <textarea id="description" name="description" rows="5"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                              placeholder="Deskripsi lengkap produk..."><?= old('description') ?></textarea>
                </div>

                <div>
                    <label for="images" class="block text-sm font-medium text-gray-700 mb-2">
                        Gambar Produk (Multiple)
                    </label>
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center hover:border-blue-500 transition">
                        <input type="file" id="images" name="images[]" multiple
                               accept="image/*"
                               class="hidden"
                               onchange="showFileNames(this)">
                        <label for="images" class="cursor-pointer">
                            <i class="fas fa-images text-3xl text-gray-400 mb-2"></i>
                            <p class="text-sm text-gray-600">Klik untuk upload gambar</p>
                            <p class="text-xs text-gray-500 mt-1">JPG, PNG (Max: 2MB per file)</p>
                            <div id="fileNames" class="text-xs text-blue-600 mt-2"></div>
                        </label>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox" name="is_featured" value="1" 
                                   class="form-checkbox text-blue-600 rounded"
                                   <?= old('is_featured') ? 'checked' : '' ?>>
                            <span class="ml-2 text-sm text-gray-700">Produk Unggulan</span>
                        </label>
                    </div>
                    <div>
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox" name="is_active" value="1" checked
                                   class="form-checkbox text-blue-600 rounded"
                                   <?= old('is_active', '1') ? 'checked' : '' ?>>
                            <span class="ml-2 text-sm text-gray-700">Aktif</span>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Harga & Stok -->
            <div class="space-y-6">
                <h3 class="text-lg font-semibold text-gray-800 border-b pb-2">
                    <i class="fas fa-dollar-sign mr-2"></i>Harga & Stok
                </h3>
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700 mb-2">
                            Harga <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-2 text-gray-500">Rp</span>
                            <input type="number" id="price" name="price" required
                                   value="<?= old('price') ?>"
                                   min="0" step="0.01"
                                   class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="0">
                        </div>
                        <?php if (isset($validation) && $validation->hasError('price')): ?>
                            <p class="text-red-500 text-sm mt-1"><?= $validation->getError('price') ?></p>
                        <?php endif; ?>
                    </div>

                    <div>
                        <label for="discount_price" class="block text-sm font-medium text-gray-700 mb-2">
                            Harga Diskon
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-2 text-gray-500">Rp</span>
                            <input type="number" id="discount_price" name="discount_price"
                                   value="<?= old('discount_price') ?>"
                                   min="0" step="0.01"
                                   class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="0">
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="stock" class="block text-sm font-medium text-gray-700 mb-2">
                            Stok <span class="text-red-500">*</span>
                        </label>
                        <input type="number" id="stock" name="stock" required
                               value="<?= old('stock', 0) ?>"
                               min="0"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <?php if (isset($validation) && $validation->hasError('stock')): ?>
                            <p class="text-red-500 text-sm mt-1"><?= $validation->getError('stock') ?></p>
                        <?php endif; ?>
                    </div>

                    <div>
                        <label for="unit" class="block text-sm font-medium text-gray-700 mb-2">
                            Satuan
                        </label>
                        <select id="unit" name="unit"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="pcs" <?= old('unit', 'pcs') == 'pcs' ? 'selected' : '' ?>>Pcs</option>
                            <option value="kg" <?= old('unit') == 'kg' ? 'selected' : '' ?>>Kg</option>
                            <option value="gram" <?= old('unit') == 'gram' ? 'selected' : '' ?>>Gram</option>
                            <option value="liter" <?= old('unit') == 'liter' ? 'selected' : '' ?>>Liter</option>
                            <option value="ml" <?= old('unit') == 'ml' ? 'selected' : '' ?>>Ml</option>
                            <option value="box" <?= old('unit') == 'box' ? 'selected' : '' ?>>Box</option>
                            <option value="pack" <?= old('unit') == 'pack' ? 'selected' : '' ?>>Pack</option>
                            <option value="lusin" <?= old('unit') == 'lusin' ? 'selected' : '' ?>>Lusin</option>
                        </select>
                    </div>
                </div>

                <h3 class="text-lg font-semibold text-gray-800 border-b pb-2 mt-6">
                    <i class="fas fa-cog mr-2"></i>Informasi Tambahan
                </h3>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="min_order" class="block text-sm font-medium text-gray-700 mb-2">
                            Minimal Order
                        </label>
                        <input type="number" id="min_order" name="min_order"
                               value="<?= old('min_order', 1) ?>"
                               min="1"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>

                    <div>
                        <label for="weight" class="block text-sm font-medium text-gray-700 mb-2">
                            Berat (gram)
                        </label>
                        <input type="number" id="weight" name="weight"
                               value="<?= old('weight') ?>"
                               min="0"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               placeholder="Berat dalam gram">
                    </div>
                </div>

                <div>
                    <label for="sku" class="block text-sm font-medium text-gray-700 mb-2">
                        SKU (Stock Keeping Unit)
                    </label>
                    <input type="text" id="sku" name="sku"
                           value="<?= old('sku') ?>"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="Contoh: PRD-001">
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex gap-3 pt-6 border-t mt-6">
            <button type="submit" 
                    class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                <i class="fas fa-save mr-2"></i>Simpan Produk
            </button>
            <a href="<?= base_url('admin/umkm/products') ?>" 
               class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                <i class="fas fa-times mr-2"></i>Batal
            </a>
        </div>
    </form>
</div>

<script>
function showFileNames(input) {
    const container = document.getElementById('fileNames');
    if (input.files && input.files.length > 0) {
        let fileList = Array.from(input.files).map(f => f.name).join(', ');
        container.textContent = input.files.length + ' file dipilih: ' + fileList;
    }
}
</script>

<?= $this->endSection() ?>
