<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<div class="mb-6">
    <a href="<?= base_url('admin/jemaat') ?>" class="text-blue-600 hover:text-blue-800">
        <i class="fas fa-arrow-left mr-2"></i>Kembali ke Daftar Jemaat
    </a>
</div>

<div class="bg-white rounded-lg shadow-md p-6">
    <h2 class="text-xl font-semibold text-gray-800 mb-6">Tambah Data Jemaat</h2>
    
    <form method="POST" action="<?= base_url('admin/jemaat/create') ?>" enctype="multipart/form-data">
        <?= csrf_field() ?>
        
        <!-- Data Pribadi -->
        <div class="mb-8">
            <h3 class="text-lg font-semibold text-gray-700 mb-4 border-b pb-2">Data Pribadi</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- No Induk -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        No Induk <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="no_induk" 
                           value="<?= old('no_induk') ?>"
                           required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <?php if (isset($validation) && $validation->hasError('no_induk')): ?>
                        <p class="text-red-500 text-sm mt-1"><?= $validation->getError('no_induk') ?></p>
                    <?php endif; ?>
                </div>
                
                <!-- Nama Lengkap -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Lengkap <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="full_name" 
                           value="<?= old('full_name') ?>"
                           required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <?php if (isset($validation) && $validation->hasError('full_name')): ?>
                        <p class="text-red-500 text-sm mt-1"><?= $validation->getError('full_name') ?></p>
                    <?php endif; ?>
                </div>
                
                <!-- Jenis Kelamin -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Jenis Kelamin <span class="text-red-500">*</span>
                    </label>
                    <select name="gender" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        <option value="">Pilih Jenis Kelamin</option>
                        <option value="L" <?= old('gender') == 'L' ? 'selected' : '' ?>>Laki-laki</option>
                        <option value="P" <?= old('gender') == 'P' ? 'selected' : '' ?>>Perempuan</option>
                    </select>
                </div>
                
                <!-- Tempat Lahir -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tempat Lahir</label>
                    <input type="text" 
                           name="birth_place" 
                           value="<?= old('birth_place') ?>"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                
                <!-- Tanggal Lahir -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Lahir</label>
                    <input type="date" 
                           name="birth_date" 
                           value="<?= old('birth_date') ?>"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                
                <!-- Foto -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Foto</label>
                    <input type="file" 
                           name="photo" 
                           accept="image/*"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG. Max: 2MB</p>
                </div>
            </div>
        </div>
        
        <!-- Kontak & Alamat -->
        <div class="mb-8">
            <h3 class="text-lg font-semibold text-gray-700 mb-4 border-b pb-2">Kontak & Alamat</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Alamat -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Alamat</label>
                    <textarea name="address" 
                              rows="3"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"><?= old('address') ?></textarea>
                </div>
                
                <!-- Wilayah -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Wilayah</label>
                    <input type="text" 
                           name="wilayah" 
                           value="<?= old('wilayah') ?>"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                
                <!-- Telepon -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Telepon</label>
                    <input type="text" 
                           name="phone" 
                           value="<?= old('phone') ?>"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                
                <!-- Email -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                    <input type="email" 
                           name="email" 
                           value="<?= old('email') ?>"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                
                <!-- Keluarga -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Keluarga</label>
                    <select name="family_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        <option value="">Pilih Keluarga</option>
                        <?php foreach ($families as $family): ?>
                            <option value="<?= $family['id'] ?>" <?= old('family_id') == $family['id'] ? 'selected' : '' ?>>
                                <?= $family['family_name'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>
        
        <!-- Data Gereja -->
        <div class="mb-8">
            <h3 class="text-lg font-semibold text-gray-700 mb-4 border-b pb-2">Data Gereja</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Baptis -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Baptis</label>
                    <input type="date" 
                           name="baptis_date" 
                           value="<?= old('baptis_date') ?>"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tempat Baptis</label>
                    <input type="text" 
                           name="baptis_place" 
                           value="<?= old('baptis_place') ?>"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                
                <!-- Sidi -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Sidi</label>
                    <input type="date" 
                           name="sidi_date" 
                           value="<?= old('sidi_date') ?>"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tempat Sidi</label>
                    <input type="text" 
                           name="sidi_place" 
                           value="<?= old('sidi_place') ?>"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                
                <!-- Pernikahan -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Nikah</label>
                    <input type="date" 
                           name="marriage_date" 
                           value="<?= old('marriage_date') ?>"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tempat Nikah</label>
                    <input type="text" 
                           name="marriage_place" 
                           value="<?= old('marriage_place') ?>"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Pasangan</label>
                    <input type="text" 
                           name="spouse_name" 
                           value="<?= old('spouse_name') ?>"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                
                <!-- Status -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                    <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        <option value="aktif" <?= old('status') == 'aktif' ? 'selected' : '' ?>>Aktif</option>
                        <option value="pindah" <?= old('status') == 'pindah' ? 'selected' : '' ?>>Pindah</option>
                        <option value="meninggal" <?= old('status') == 'meninggal' ? 'selected' : '' ?>>Meninggal</option>
                        <option value="non-aktif" <?= old('status') == 'non-aktif' ? 'selected' : '' ?>>Non-Aktif</option>
                    </select>
                </div>
            </div>
        </div>
        
        <!-- Catatan -->
        <div class="mb-8">
            <label class="block text-sm font-medium text-gray-700 mb-2">Catatan</label>
            <textarea name="notes" 
                      rows="4"
                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"><?= old('notes') ?></textarea>
        </div>
        
        <!-- Submit Buttons -->
        <div class="flex gap-4">
            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                <i class="fas fa-save mr-2"></i>Simpan
            </button>
            <a href="<?= base_url('admin/jemaat') ?>" class="px-6 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition">
                <i class="fas fa-times mr-2"></i>Batal
            </a>
        </div>
    </form>
</div>

<?= $this->endSection() ?>
