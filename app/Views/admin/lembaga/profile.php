<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<div class="bg-white rounded-lg shadow-md p-6">
    <h2 class="text-xl font-semibold text-gray-800 mb-6">Profil Gereja</h2>
    
    <form method="POST" action="<?= base_url('admin/lembaga/profile') ?>" enctype="multipart/form-data">
        <?= csrf_field() ?>
        
        <!-- Informasi Dasar -->
        <div class="mb-8">
            <h3 class="text-lg font-semibold text-gray-700 mb-4 border-b pb-2">Informasi Dasar</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nama Gereja -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Gereja <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="church_name" 
                           value="<?= old('church_name', $profile['church_name'] ?? '') ?>"
                           required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                
                <!-- Tagline -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tagline</label>
                    <input type="text" 
                           name="tagline" 
                           value="<?= old('tagline', $profile['tagline'] ?? '') ?>"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                
                <!-- Logo -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Logo Gereja</label>
                    <?php if (!empty($profile['logo'])): ?>
                        <div class="mb-3">
                            <img src="<?= base_url('uploads/logo/' . $profile['logo']) ?>" 
                                 alt="Logo" 
                                 class="h-24 object-contain">
                        </div>
                    <?php endif; ?>
                    <input type="file" 
                           name="logo" 
                           accept="image/*"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <p class="text-xs text-gray-500 mt-1">Format: PNG, JPG. Rekomendasi: 200x200px</p>
                </div>
            </div>
        </div>
        
        <!-- Kontak -->
        <div class="mb-8">
            <h3 class="text-lg font-semibold text-gray-700 mb-4 border-b pb-2">Kontak</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Alamat -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Alamat</label>
                    <textarea name="address" 
                              rows="3"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"><?= old('address', $profile['address'] ?? '') ?></textarea>
                </div>
                
                <!-- Telepon -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Telepon</label>
                    <input type="text" 
                           name="phone" 
                           value="<?= old('phone', $profile['phone'] ?? '') ?>"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                
                <!-- Email -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                    <input type="email" 
                           name="email" 
                           value="<?= old('email', $profile['email'] ?? '') ?>"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                
                <!-- Website -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Website</label>
                    <input type="url" 
                           name="website" 
                           value="<?= old('website', $profile['website'] ?? '') ?>"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
            </div>
        </div>
        
        <!-- Profil Gereja -->
        <div class="mb-8">
            <h3 class="text-lg font-semibold text-gray-700 mb-4 border-b pb-2">Profil Gereja</h3>
            
            <!-- Sejarah -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Sejarah Gereja</label>
                <textarea name="history" 
                          rows="6"
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"><?= old('history', $profile['history'] ?? '') ?></textarea>
            </div>
            
            <!-- Visi -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Visi</label>
                <textarea name="vision" 
                          rows="4"
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"><?= old('vision', $profile['vision'] ?? '') ?></textarea>
            </div>
            
            <!-- Misi -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Misi</label>
                <textarea name="mission" 
                          rows="6"
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"><?= old('mission', $profile['mission'] ?? '') ?></textarea>
            </div>
            
            <!-- Struktur Organisasi -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Struktur Organisasi</label>
                <textarea name="organizational_structure" 
                          rows="6"
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"><?= old('organizational_structure', $profile['organizational_structure'] ?? '') ?></textarea>
            </div>
        </div>
        
        <!-- Media Sosial -->
        <div class="mb-8">
            <h3 class="text-lg font-semibold text-gray-700 mb-4 border-b pb-2">Media Sosial</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Facebook -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fab fa-facebook text-blue-600 mr-2"></i>Facebook
                    </label>
                    <input type="url" 
                           name="social_facebook" 
                           value="<?= old('social_facebook', $profile['social_facebook'] ?? '') ?>"
                           placeholder="https://facebook.com/..."
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                
                <!-- Instagram -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fab fa-instagram text-pink-600 mr-2"></i>Instagram
                    </label>
                    <input type="url" 
                           name="social_instagram" 
                           value="<?= old('social_instagram', $profile['social_instagram'] ?? '') ?>"
                           placeholder="https://instagram.com/..."
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                
                <!-- YouTube -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fab fa-youtube text-red-600 mr-2"></i>YouTube
                    </label>
                    <input type="url" 
                           name="social_youtube" 
                           value="<?= old('social_youtube', $profile['social_youtube'] ?? '') ?>"
                           placeholder="https://youtube.com/..."
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                
                <!-- Twitter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fab fa-twitter text-blue-400 mr-2"></i>Twitter
                    </label>
                    <input type="url" 
                           name="social_twitter" 
                           value="<?= old('social_twitter', $profile['social_twitter'] ?? '') ?>"
                           placeholder="https://twitter.com/..."
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
            </div>
        </div>
        
        <!-- Submit Button -->
        <div class="flex gap-4">
            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                <i class="fas fa-save mr-2"></i>Simpan Perubahan
            </button>
        </div>
    </form>
</div>

<?= $this->endSection() ?>
