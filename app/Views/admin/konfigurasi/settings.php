<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
    <div>
        <h2 class="text-xl font-semibold text-gray-800">Pengaturan Sistem</h2>
        <p class="text-sm text-gray-600 mt-1">Kelola pengaturan aplikasi</p>
    </div>
    <a href="<?= base_url('admin/konfigurasi/settings/create') ?>" 
       class="mt-4 md:mt-0 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
        <i class="fas fa-plus mr-2"></i>Tambah Pengaturan
    </a>
</div>

<?php if (session()->getFlashdata('success')): ?>
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
        <i class="fas fa-check-circle mr-2"></i><?= session()->getFlashdata('success') ?>
    </div>
<?php endif; ?>

<!-- Group Tabs -->
<div class="bg-white rounded-lg shadow-md mb-6">
    <div class="border-b border-gray-200">
        <nav class="flex -mb-px overflow-x-auto">
            <a href="<?= base_url('admin/konfigurasi/settings?group=general') ?>" 
               class="px-6 py-3 border-b-2 whitespace-nowrap <?= $group == 'general' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700' ?> font-medium text-sm">
                <i class="fas fa-cog mr-2"></i>Umum
            </a>
            <a href="<?= base_url('admin/konfigurasi/settings?group=email') ?>" 
               class="px-6 py-3 border-b-2 whitespace-nowrap <?= $group == 'email' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700' ?> font-medium text-sm">
                <i class="fas fa-envelope mr-2"></i>Email
            </a>
            <a href="<?= base_url('admin/konfigurasi/settings?group=theme') ?>" 
               class="px-6 py-3 border-b-2 whitespace-nowrap <?= $group == 'theme' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700' ?> font-medium text-sm">
                <i class="fas fa-palette mr-2"></i>Tema
            </a>
            <a href="<?= base_url('admin/konfigurasi/settings?group=social') ?>" 
               class="px-6 py-3 border-b-2 whitespace-nowrap <?= $group == 'social' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700' ?> font-medium text-sm">
                <i class="fas fa-share-alt mr-2"></i>Media Sosial
            </a>
        </nav>
    </div>
</div>

<!-- Settings Form -->
<?php if (empty($settings)): ?>
    <div class="bg-white rounded-lg shadow-md p-12 text-center">
        <i class="fas fa-cog text-6xl text-gray-300 mb-4"></i>
        <p class="text-gray-500 mb-4">Belum ada pengaturan untuk grup ini</p>
        <a href="<?= base_url('admin/konfigurasi/settings/create') ?>" 
           class="inline-block px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
            <i class="fas fa-plus mr-2"></i>Tambah Pengaturan
        </a>
    </div>
<?php else: ?>
    <div class="bg-white rounded-lg shadow-md">
        <form action="<?= base_url('admin/konfigurasi/settings?group=' . $group) ?>" method="POST" class="p-6">
            <?= csrf_field() ?>
            
            <div class="space-y-6">
                <?php foreach ($settings as $setting): ?>
                    <div class="border-b border-gray-200 pb-6 last:border-0 last:pb-0">
                        <div class="flex items-start justify-between mb-2">
                            <div class="flex-1">
                                <label for="<?= $setting['key'] ?>" class="block text-sm font-medium text-gray-700 mb-1">
                                    <?= ucwords(str_replace('_', ' ', $setting['key'])) ?>
                                </label>
                                <?php if ($setting['description']): ?>
                                    <p class="text-xs text-gray-500 mb-2"><?= $setting['description'] ?></p>
                                <?php endif; ?>
                            </div>
                            <div class="flex gap-2 ml-4">
                                <a href="<?= base_url('admin/konfigurasi/settings/edit/' . $setting['id']) ?>" 
                                   class="text-blue-600 hover:text-blue-800"
                                   title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="<?= base_url('admin/konfigurasi/settings/delete/' . $setting['id']) ?>" 
                                   onclick="return confirm('Yakin ingin menghapus pengaturan ini?')"
                                   class="text-red-600 hover:text-red-800"
                                   title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </div>
                        </div>
                        
                        <?php if ($setting['type'] == 'text'): ?>
                            <input type="text" 
                                   id="<?= $setting['key'] ?>" 
                                   name="<?= $setting['key'] ?>" 
                                   value="<?= old($setting['key'], $setting['value']) ?>"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        
                        <?php elseif ($setting['type'] == 'textarea'): ?>
                            <textarea id="<?= $setting['key'] ?>" 
                                      name="<?= $setting['key'] ?>" 
                                      rows="4"
                                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"><?= old($setting['key'], $setting['value']) ?></textarea>
                        
                        <?php elseif ($setting['type'] == 'number'): ?>
                            <input type="number" 
                                   id="<?= $setting['key'] ?>" 
                                   name="<?= $setting['key'] ?>" 
                                   value="<?= old($setting['key'], $setting['value']) ?>"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        
                        <?php elseif ($setting['type'] == 'boolean'): ?>
                            <label class="flex items-center cursor-pointer">
                                <input type="checkbox" 
                                       id="<?= $setting['key'] ?>" 
                                       name="<?= $setting['key'] ?>" 
                                       value="1"
                                       class="form-checkbox text-blue-600 rounded"
                                       <?= old($setting['key'], $setting['value']) ? 'checked' : '' ?>>
                                <span class="ml-2 text-sm text-gray-700">Aktifkan</span>
                            </label>
                        
                        <?php elseif ($setting['type'] == 'json'): ?>
                            <textarea id="<?= $setting['key'] ?>" 
                                      name="<?= $setting['key'] ?>" 
                                      rows="6"
                                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent font-mono text-sm"><?= old($setting['key'], $setting['value']) ?></textarea>
                            <p class="text-xs text-gray-500 mt-1">Format JSON</p>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Action Buttons -->
            <div class="flex gap-3 pt-6 border-t mt-6">
                <button type="submit" 
                        class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    <i class="fas fa-save mr-2"></i>Simpan Perubahan
                </button>
                <a href="<?= base_url('admin/konfigurasi/settings') ?>" 
                   class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                    <i class="fas fa-times mr-2"></i>Batal
                </a>
            </div>
        </form>
    </div>
<?php endif; ?>

<?= $this->endSection() ?>
