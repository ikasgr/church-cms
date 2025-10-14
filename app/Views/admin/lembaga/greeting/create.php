<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<div class="mb-6">
    <div class="flex items-center gap-2 text-sm text-gray-600 mb-4">
        <a href="<?= base_url('admin/lembaga/greeting') ?>" class="hover:text-blue-600">
            <i class="fas fa-comment-dots"></i> Sambutan
        </a>
        <i class="fas fa-chevron-right text-xs"></i>
        <span class="text-gray-800">Tambah Sambutan</span>
    </div>
    <h2 class="text-2xl font-bold text-gray-800">Tambah Sambutan</h2>
</div>

<div class="bg-white rounded-lg shadow-md">
    <form action="<?= base_url('admin/lembaga/greeting/create') ?>" method="POST" enctype="multipart/form-data" class="p-6">
        <?= csrf_field() ?>
        
        <!-- Title -->
        <div class="mb-6">
            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                Judul Sambutan <span class="text-red-500">*</span>
            </label>
            <input type="text" id="title" name="title" 
                   value="<?= old('title') ?>"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                   placeholder="Contoh: Sambutan Ketua Majelis">
            <?php if (isset($validation) && $validation->hasError('title')): ?>
                <p class="text-red-500 text-sm mt-1"><?= $validation->getError('title') ?></p>
            <?php endif; ?>
        </div>

        <!-- Content -->
        <div class="mb-6">
            <label for="content" class="block text-sm font-medium text-gray-700 mb-2">
                Isi Sambutan <span class="text-red-500">*</span>
            </label>
            <textarea id="content" name="content" rows="12"
                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                      placeholder="Tulis isi sambutan di sini..."><?= old('content') ?></textarea>
            <?php if (isset($validation) && $validation->hasError('content')): ?>
                <p class="text-red-500 text-sm mt-1"><?= $validation->getError('content') ?></p>
            <?php endif; ?>
            <p class="text-xs text-gray-500 mt-1">
                <i class="fas fa-info-circle"></i> Anda bisa menggunakan paragraf dan format teks sederhana
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Left Column -->
            <div class="space-y-6">
                <!-- Author Name -->
                <div>
                    <label for="author_name" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Penulis <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="author_name" name="author_name" 
                           value="<?= old('author_name') ?>"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="Contoh: Pdt. John Doe, S.Th">
                    <?php if (isset($validation) && $validation->hasError('author_name')): ?>
                        <p class="text-red-500 text-sm mt-1"><?= $validation->getError('author_name') ?></p>
                    <?php endif; ?>
                </div>

                <!-- Author Position -->
                <div>
                    <label for="author_position" class="block text-sm font-medium text-gray-700 mb-2">
                        Jabatan Penulis <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="author_position" name="author_position" 
                           value="<?= old('author_position') ?>"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="Contoh: Ketua Majelis">
                    <?php if (isset($validation) && $validation->hasError('author_position')): ?>
                        <p class="text-red-500 text-sm mt-1"><?= $validation->getError('author_position') ?></p>
                    <?php endif; ?>
                </div>

                <!-- Active Status -->
                <div>
                    <label class="flex items-center cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" 
                               class="form-checkbox text-blue-600 rounded"
                               <?= old('is_active', '1') ? 'checked' : '' ?>>
                        <span class="ml-2 text-sm text-gray-700">
                            <i class="fas fa-check-circle text-green-600"></i> Aktifkan sambutan ini
                        </span>
                    </label>
                    <p class="text-xs text-gray-500 mt-1 ml-6">Sambutan yang aktif akan ditampilkan di website</p>
                </div>
            </div>

            <!-- Right Column -->
            <div class="space-y-6">
                <!-- Author Photo Upload -->
                <div>
                    <label for="author_photo" class="block text-sm font-medium text-gray-700 mb-2">
                        Foto Penulis
                    </label>
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-blue-500 transition">
                        <input type="file" id="author_photo" name="author_photo" 
                               accept="image/*"
                               class="hidden"
                               onchange="previewImage(this)">
                        <label for="author_photo" class="cursor-pointer">
                            <div id="photoPreview" class="mb-4">
                                <i class="fas fa-user-circle text-6xl text-gray-400"></i>
                            </div>
                            <p class="text-gray-600">Klik untuk upload foto</p>
                            <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG (Max: 2MB)</p>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex gap-3 pt-6 border-t mt-6">
            <button type="submit" 
                    class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                <i class="fas fa-save mr-2"></i>Simpan
            </button>
            <a href="<?= base_url('admin/lembaga/greeting') ?>" 
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
