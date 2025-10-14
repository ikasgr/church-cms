<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<div class="mb-6">
    <div class="flex items-center gap-2 text-sm text-gray-600 mb-4">
        <a href="<?= base_url('admin/umkm/sellers') ?>" class="hover:text-blue-600">
            <i class="fas fa-users"></i> Pelapak
        </a>
        <i class="fas fa-chevron-right text-xs"></i>
        <span class="text-gray-800">Edit Pelapak</span>
    </div>
    <h2 class="text-2xl font-bold text-gray-800">
        <i class="fas fa-edit text-blue-600 mr-2"></i>Edit Pelapak: <?= $seller['business_name'] ?>
    </h2>
</div>

<div class="bg-white rounded-lg shadow-md">
    <form action="<?= base_url('admin/umkm/sellers/edit/' . $seller['id']) ?>" method="POST" enctype="multipart/form-data" class="p-6">
        <?= csrf_field() ?>
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Informasi Usaha -->
            <div class="space-y-6">
                <h3 class="text-lg font-semibold text-gray-800 border-b pb-2">
                    <i class="fas fa-store mr-2"></i>Informasi Usaha
                </h3>
                
                <div>
                    <label for="business_name" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Usaha <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="business_name" name="business_name" 
                           value="<?= old('business_name', $seller['business_name']) ?>"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <?php if (isset($validation) && $validation->hasError('business_name')): ?>
                        <p class="text-red-500 text-sm mt-1"><?= $validation->getError('business_name') ?></p>
                    <?php endif; ?>
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                        Deskripsi Usaha
                    </label>
                    <textarea id="description" name="description" rows="4"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"><?= old('description', $seller['description']) ?></textarea>
                </div>

                <div>
                    <label for="logo" class="block text-sm font-medium text-gray-700 mb-2">
                        Logo Usaha
                    </label>
                    <?php if ($seller['logo']): ?>
                        <div class="mb-3">
                            <img src="<?= base_url('uploads/umkm/sellers/' . $seller['logo']) ?>" 
                                 alt="Current Logo" 
                                 class="w-32 h-32 object-cover rounded-lg border">
                            <p class="text-xs text-gray-500 mt-1">Logo saat ini</p>
                        </div>
                    <?php endif; ?>
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center hover:border-blue-500 transition">
                        <input type="file" id="logo" name="logo" 
                               accept="image/*"
                               class="hidden"
                               onchange="showFileName(this, 'logoName')">
                        <label for="logo" class="cursor-pointer">
                            <i class="fas fa-upload text-3xl text-gray-400 mb-2"></i>
                            <p class="text-sm text-gray-600">Klik untuk upload logo baru</p>
                            <p class="text-xs text-gray-500 mt-1">JPG, PNG (Max: 2MB)</p>
                            <p id="logoName" class="text-xs text-blue-600 mt-2"></p>
                        </label>
                    </div>
                </div>

                <div>
                    <label for="commission_rate" class="block text-sm font-medium text-gray-700 mb-2">
                        Komisi Gereja (%)
                    </label>
                    <input type="number" id="commission_rate" name="commission_rate" 
                           value="<?= old('commission_rate', $seller['commission_rate']) ?>"
                           min="0" max="100" step="0.01"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>

                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                        Status
                    </label>
                    <select id="status" name="status" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="active" <?= old('status', $seller['status']) == 'active' ? 'selected' : '' ?>>Aktif</option>
                        <option value="pending" <?= old('status', $seller['status']) == 'pending' ? 'selected' : '' ?>>Pending</option>
                        <option value="suspended" <?= old('status', $seller['status']) == 'suspended' ? 'selected' : '' ?>>Suspended</option>
                    </select>
                </div>
            </div>

            <!-- Informasi Pemilik & Kontak -->
            <div class="space-y-6">
                <h3 class="text-lg font-semibold text-gray-800 border-b pb-2">
                    <i class="fas fa-user mr-2"></i>Informasi Pemilik
                </h3>
                
                <div>
                    <label for="owner_name" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Pemilik <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="owner_name" name="owner_name" 
                           value="<?= old('owner_name', $seller['owner_name']) ?>"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <?php if (isset($validation) && $validation->hasError('owner_name')): ?>
                        <p class="text-red-500 text-sm mt-1"><?= $validation->getError('owner_name') ?></p>
                    <?php endif; ?>
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        Email <span class="text-red-500">*</span>
                    </label>
                    <input type="email" id="email" name="email" 
                           value="<?= old('email', $seller['email']) ?>"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <?php if (isset($validation) && $validation->hasError('email')): ?>
                        <p class="text-red-500 text-sm mt-1"><?= $validation->getError('email') ?></p>
                    <?php endif; ?>
                </div>

                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                        No. Telepon <span class="text-red-500">*</span>
                    </label>
                    <input type="tel" id="phone" name="phone" 
                           value="<?= old('phone', $seller['phone']) ?>"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <?php if (isset($validation) && $validation->hasError('phone')): ?>
                        <p class="text-red-500 text-sm mt-1"><?= $validation->getError('phone') ?></p>
                    <?php endif; ?>
                </div>

                <div>
                    <label for="address" class="block text-sm font-medium text-gray-700 mb-2">
                        Alamat Lengkap
                    </label>
                    <textarea id="address" name="address" rows="3"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"><?= old('address', $seller['address']) ?></textarea>
                </div>

                <h3 class="text-lg font-semibold text-gray-800 border-b pb-2 mt-6">
                    <i class="fas fa-university mr-2"></i>Informasi Rekening Bank
                </h3>

                <div>
                    <label for="bank_name" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Bank
                    </label>
                    <input type="text" id="bank_name" name="bank_name" 
                           value="<?= old('bank_name', $seller['bank_name']) ?>"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>

                <div>
                    <label for="bank_account_number" class="block text-sm font-medium text-gray-700 mb-2">
                        Nomor Rekening
                    </label>
                    <input type="text" id="bank_account_number" name="bank_account_number" 
                           value="<?= old('bank_account_number', $seller['bank_account_number']) ?>"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>

                <div>
                    <label for="bank_account_name" class="block text-sm font-medium text-gray-700 mb-2">
                        Atas Nama
                    </label>
                    <input type="text" id="bank_account_name" name="bank_account_name" 
                           value="<?= old('bank_account_name', $seller['bank_account_name']) ?>"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex gap-3 pt-6 border-t mt-6">
            <button type="submit" 
                    class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                <i class="fas fa-save mr-2"></i>Update Pelapak
            </button>
            <a href="<?= base_url('admin/umkm/sellers') ?>" 
               class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                <i class="fas fa-times mr-2"></i>Batal
            </a>
        </div>
    </form>
</div>

<script>
function showFileName(input, targetId) {
    const target = document.getElementById(targetId);
    if (input.files && input.files[0]) {
        target.textContent = 'File: ' + input.files[0].name;
    }
}
</script>

<?= $this->endSection() ?>
