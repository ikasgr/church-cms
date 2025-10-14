<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<div class="mb-6">
    <div class="flex items-center gap-2 text-sm text-gray-600 mb-4">
        <a href="<?= base_url('admin/lembaga/majelis') ?>" class="hover:text-blue-600">
            <i class="fas fa-users"></i> Data Majelis
        </a>
        <i class="fas fa-chevron-right text-xs"></i>
        <span class="text-gray-800">Edit Majelis</span>
    </div>
    <h2 class="text-2xl font-bold text-gray-800">Edit Majelis</h2>
</div>

<div class="bg-white rounded-lg shadow-md">
    <form action="<?= base_url('admin/lembaga/majelis/edit/' . $majelis['id']) ?>" method="POST" enctype="multipart/form-data" class="p-6">
        <?= csrf_field() ?>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Left Column -->
            <div class="space-y-6">
                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Lengkap <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="name" name="name" 
                           value="<?= old('name', $majelis['name']) ?>"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="Contoh: Pdt. John Doe, S.Th">
                    <?php if (isset($validation) && $validation->hasError('name')): ?>
                        <p class="text-red-500 text-sm mt-1"><?= $validation->getError('name') ?></p>
                    <?php endif; ?>
                </div>

                <!-- Position -->
                <div>
                    <label for="position" class="block text-sm font-medium text-gray-700 mb-2">
                        Jabatan <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="position" name="position" 
                           value="<?= old('position', $majelis['position']) ?>"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="Contoh: Ketua Majelis">
                    <?php if (isset($validation) && $validation->hasError('position')): ?>
                        <p class="text-red-500 text-sm mt-1"><?= $validation->getError('position') ?></p>
                    <?php endif; ?>
                </div>

                <!-- Phone -->
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                        Nomor Telepon
                    </label>
                    <input type="text" id="phone" name="phone" 
                           value="<?= old('phone', $majelis['phone']) ?>"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="Contoh: 0812-3456-7890">
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        Email
                    </label>
                    <input type="email" id="email" name="email" 
                           value="<?= old('email', $majelis['email']) ?>"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="Contoh: john@example.com">
                    <?php if (isset($validation) && $validation->hasError('email')): ?>
                        <p class="text-red-500 text-sm mt-1"><?= $validation->getError('email') ?></p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Right Column -->
            <div class="space-y-6">
                <!-- Photo Upload -->
                <div>
                    <label for="photo" class="block text-sm font-medium text-gray-700 mb-2">
                        Foto
                    </label>
                    
                    <?php if ($majelis['photo']): ?>
                        <div class="mb-4 text-center">
                            <img src="<?= base_url('uploads/majelis/' . $majelis['photo']) ?>" 
                                 alt="<?= $majelis['name'] ?>"
                                 class="w-32 h-32 rounded-full object-cover mx-auto shadow-lg mb-2">
                            <p class="text-xs text-gray-500">Foto saat ini</p>
                        </div>
                    <?php endif; ?>
                    
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-blue-500 transition">
                        <input type="file" id="photo" name="photo" 
                               accept="image/*"
                               class="hidden"
                               onchange="previewImage(this)">
                        <label for="photo" class="cursor-pointer">
                            <div id="photoPreview" class="mb-4">
                                <i class="fas fa-user-circle text-6xl text-gray-400"></i>
                            </div>
                            <p class="text-gray-600">Klik untuk upload foto baru</p>
                            <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG (Max: 2MB)</p>
                        </label>
                    </div>
                </div>

                <!-- Order Position -->
                <div>
                    <label for="order_position" class="block text-sm font-medium text-gray-700 mb-2">
                        Urutan Tampil
                    </label>
                    <input type="number" id="order_position" name="order_position" 
                           value="<?= old('order_position', $majelis['order_position']) ?>"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="0">
                    <p class="text-xs text-gray-500 mt-1">Semakin kecil angka, semakin awal ditampilkan</p>
                </div>

                <!-- Active Status -->
                <div>
                    <label class="flex items-center cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" 
                               class="form-checkbox text-blue-600 rounded"
                               <?= old('is_active', $majelis['is_active']) ? 'checked' : '' ?>>
                        <span class="ml-2 text-sm text-gray-700">
                            <i class="fas fa-check-circle text-green-600"></i> Status Aktif
                        </span>
                    </label>
                </div>
            </div>
        </div>

        <!-- Bio -->
        <div class="mt-6">
            <label for="bio" class="block text-sm font-medium text-gray-700 mb-2">
                Biografi
            </label>
            <textarea id="bio" name="bio" rows="5"
                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                      placeholder="Tulis biografi singkat..."><?= old('bio', $majelis['bio']) ?></textarea>
        </div>

        <!-- Action Buttons -->
        <div class="flex gap-3 pt-6 border-t mt-6">
            <button type="submit" 
                    class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                <i class="fas fa-save mr-2"></i>Update
            </button>
            <a href="<?= base_url('admin/lembaga/majelis') ?>" 
               class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                <i class="fas fa-times mr-2"></i>Batal
            </a>
        </div>
    </form>
</div>

<script>
function previewImage(input) {
    const preview = document.getElementById('photoPreview');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            preview.innerHTML = '<img src="' + e.target.result + '" class="w-32 h-32 rounded-full object-cover mx-auto shadow-lg">';
        }
        
        reader.readAsDataURL(input.files[0]);
    }
}
</script>

<?= $this->endSection() ?>
