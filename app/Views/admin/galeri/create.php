<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<div class="mb-6">
    <div class="flex items-center gap-2 text-sm text-gray-600 mb-4">
        <a href="<?= base_url('admin/galeri') ?>" class="hover:text-blue-600">
            <i class="fas fa-images"></i> Galeri
        </a>
        <i class="fas fa-chevron-right text-xs"></i>
        <span class="text-gray-800">Tambah Galeri</span>
    </div>
    <h2 class="text-2xl font-bold text-gray-800">Tambah Galeri</h2>
</div>

<div class="bg-white rounded-lg shadow-md">
    <form action="<?= base_url('admin/galeri/create') ?>" method="POST" enctype="multipart/form-data" class="p-6">
        <?= csrf_field() ?>
        
        <!-- Type Selection -->
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Tipe Galeri <span class="text-red-500">*</span>
            </label>
            <div class="flex gap-4">
                <label class="flex items-center cursor-pointer">
                    <input type="radio" name="type" value="photo" 
                           class="form-radio text-blue-600" 
                           onchange="toggleTypeFields()"
                           <?= old('type', 'photo') == 'photo' ? 'checked' : '' ?>>
                    <span class="ml-2">
                        <i class="fas fa-image text-blue-600"></i> Foto
                    </span>
                </label>
                <label class="flex items-center cursor-pointer">
                    <input type="radio" name="type" value="video" 
                           class="form-radio text-red-600" 
                           onchange="toggleTypeFields()"
                           <?= old('type') == 'video' ? 'checked' : '' ?>>
                    <span class="ml-2">
                        <i class="fas fa-video text-red-600"></i> Video
                    </span>
                </label>
            </div>
            <?php if (isset($validation) && $validation->hasError('type')): ?>
                <p class="text-red-500 text-sm mt-1"><?= $validation->getError('type') ?></p>
            <?php endif; ?>
        </div>

        <!-- Title -->
        <div class="mb-6">
            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                Judul <span class="text-red-500">*</span>
            </label>
            <input type="text" id="title" name="title" 
                   value="<?= old('title') ?>"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                   placeholder="Contoh: Ibadah Minggu 14 Oktober 2024">
            <?php if (isset($validation) && $validation->hasError('title')): ?>
                <p class="text-red-500 text-sm mt-1"><?= $validation->getError('title') ?></p>
            <?php endif; ?>
        </div>

        <!-- Description -->
        <div class="mb-6">
            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                Deskripsi
            </label>
            <textarea id="description" name="description" rows="4"
                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                      placeholder="Deskripsi singkat tentang foto/video ini"><?= old('description') ?></textarea>
        </div>

        <!-- Photo Upload (shown when type=photo) -->
        <div id="photoFields" class="mb-6">
            <label for="file_path" class="block text-sm font-medium text-gray-700 mb-2">
                Upload Foto <span class="text-red-500">*</span>
            </label>
            <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-blue-500 transition">
                <input type="file" id="file_path" name="file_path" 
                       accept="image/*"
                       class="hidden"
                       onchange="previewImage(this)">
                <label for="file_path" class="cursor-pointer">
                    <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-2"></i>
                    <p class="text-gray-600">Klik untuk upload foto</p>
                    <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG, GIF (Max: 5MB)</p>
                </label>
                <div id="imagePreview" class="mt-4 hidden">
                    <img src="" alt="Preview" class="max-w-xs mx-auto rounded-lg shadow-md">
                </div>
            </div>
        </div>

        <!-- Video Fields (shown when type=video) -->
        <div id="videoFields" class="mb-6 hidden">
            <label for="video_url" class="block text-sm font-medium text-gray-700 mb-2">
                URL Video <span class="text-red-500">*</span>
            </label>
            <input type="url" id="video_url" name="video_url" 
                   value="<?= old('video_url') ?>"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                   placeholder="https://www.youtube.com/watch?v=...">
            <p class="text-xs text-gray-500 mt-1">
                <i class="fas fa-info-circle"></i> Masukkan URL dari YouTube, Vimeo, atau platform video lainnya
            </p>
            
            <!-- Video Thumbnail -->
            <div class="mt-4">
                <label for="thumbnail" class="block text-sm font-medium text-gray-700 mb-2">
                    Thumbnail Video (Opsional)
                </label>
                <input type="file" id="thumbnail" name="thumbnail" 
                       accept="image/*"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                <p class="text-xs text-gray-500 mt-1">Upload thumbnail custom untuk video</p>
            </div>
        </div>

        <!-- Category -->
        <div class="mb-6">
            <label for="category" class="block text-sm font-medium text-gray-700 mb-2">
                Kategori
            </label>
            <input type="text" id="category" name="category" 
                   value="<?= old('category') ?>"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                   placeholder="Contoh: Ibadah, Perayaan, Kegiatan Pemuda">
        </div>

        <!-- Event Date -->
        <div class="mb-6">
            <label for="event_date" class="block text-sm font-medium text-gray-700 mb-2">
                Tanggal Kegiatan
            </label>
            <input type="date" id="event_date" name="event_date" 
                   value="<?= old('event_date', date('Y-m-d')) ?>"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
        </div>

        <!-- Order Position -->
        <div class="mb-6">
            <label for="order_position" class="block text-sm font-medium text-gray-700 mb-2">
                Urutan Tampil
            </label>
            <input type="number" id="order_position" name="order_position" 
                   value="<?= old('order_position', 0) ?>"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                   placeholder="0">
            <p class="text-xs text-gray-500 mt-1">Semakin kecil angka, semakin awal ditampilkan</p>
        </div>

        <!-- Published Status -->
        <div class="mb-6">
            <label class="flex items-center cursor-pointer">
                <input type="checkbox" name="is_published" value="1" 
                       class="form-checkbox text-blue-600 rounded"
                       <?= old('is_published', '1') ? 'checked' : '' ?>>
                <span class="ml-2 text-sm text-gray-700">
                    <i class="fas fa-eye text-green-600"></i> Publikasikan galeri ini
                </span>
            </label>
        </div>

        <!-- Action Buttons -->
        <div class="flex gap-3 pt-4 border-t">
            <button type="submit" 
                    class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                <i class="fas fa-save mr-2"></i>Simpan
            </button>
            <a href="<?= base_url('admin/galeri') ?>" 
               class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                <i class="fas fa-times mr-2"></i>Batal
            </a>
        </div>
    </form>
</div>

<script>
function toggleTypeFields() {
    const type = document.querySelector('input[name="type"]:checked').value;
    const photoFields = document.getElementById('photoFields');
    const videoFields = document.getElementById('videoFields');
    
    if (type === 'photo') {
        photoFields.classList.remove('hidden');
        videoFields.classList.add('hidden');
    } else {
        photoFields.classList.add('hidden');
        videoFields.classList.remove('hidden');
    }
}

function previewImage(input) {
    const preview = document.getElementById('imagePreview');
    const previewImg = preview.querySelector('img');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            preview.classList.remove('hidden');
        }
        
        reader.readAsDataURL(input.files[0]);
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    toggleTypeFields();
});
</script>

<?= $this->endSection() ?>
