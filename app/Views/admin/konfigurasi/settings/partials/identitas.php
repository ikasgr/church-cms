<?php
$settings = $settings ?? [];

// Helper to fetch value by key
$getValue = static function ($key, $default = '') use ($settings) {
    foreach ($settings as $setting) {
        if ($setting['key'] === $key) {
            return old($key, $setting['value']);
        }
    }
    return old($key, $default);
};

// Helper to fetch setting meta
$getSetting = static function ($key) use ($settings) {
    foreach ($settings as $setting) {
        if ($setting['key'] === $key) {
            return $setting;
        }
    }
    return null;
};

$logoSetting = $getSetting('site_logo');
$iconSetting = $getSetting('site_icon');
$maintenanceSetting = $getSetting('site_maintenance_mode');
$isMaintenance = $getValue('site_maintenance_mode', 0);

?>

<div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
    <div class="xl:col-span-2 space-y-6">
        <div class="border border-blue-100 bg-blue-50 rounded-lg p-4">
            <h2 class="text-sm font-semibold text-blue-700 flex items-center gap-2">
                <i class="fas fa-info-circle"></i>
                Identitas Gereja
            </h2>
            <p class="text-xs text-blue-600 mt-1">
                Pastikan data identitas sesuai untuk ditampilkan di website dan dokumen resmi.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="space-y-2">
                <label for="site_name" class="text-sm font-semibold text-gray-700">Nama Situs</label>
                <input type="text" id="site_name" name="site_name" value="<?= esc($getValue('site_name')) ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            <div class="space-y-2">
                <label for="site_short_name" class="text-sm font-semibold text-gray-700">Nama Situs Singkat</label>
                <input type="text" id="site_short_name" name="site_short_name" value="<?= esc($getValue('site_short_name')) ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <p class="text-xs text-gray-500">Digunakan pada tampilan mobile atau badge.</p>
            </div>

            <div class="space-y-2 md:col-span-2">
                <label for="site_description" class="text-sm font-semibold text-gray-700">Deskripsi</label>
                <textarea id="site_description" name="site_description" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"><?= esc($getValue('site_description')) ?></textarea>
            </div>

            <div class="space-y-2">
                <label for="site_phone" class="text-sm font-semibold text-gray-700">No HP / WhatsApp</label>
                <input type="text" id="site_phone" name="site_phone" value="<?= esc($getValue('site_phone')) ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            <div class="space-y-2">
                <label for="site_email" class="text-sm font-semibold text-gray-700">Email Kantor</label>
                <input type="email" id="site_email" name="site_email" value="<?= esc($getValue('site_email')) ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>

            <div class="space-y-2">
                <label for="site_province" class="text-sm font-semibold text-gray-700">Provinsi</label>
                <input type="text" id="site_province" name="site_province" value="<?= esc($getValue('site_province')) ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            <div class="space-y-2">
                <label for="site_city" class="text-sm font-semibold text-gray-700">Kota / Kabupaten</label>
                <input type="text" id="site_city" name="site_city" value="<?= esc($getValue('site_city')) ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>

            <div class="space-y-2">
                <label for="site_url" class="text-sm font-semibold text-gray-700">Alamat Situs</label>
                <input type="url" id="site_url" name="site_url" value="<?= esc($getValue('site_url')) ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            <div class="space-y-2">
                <label for="site_office_address" class="text-sm font-semibold text-gray-700">Alamat Kantor</label>
                <textarea id="site_office_address" name="site_office_address" rows="2" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"><?= esc($getValue('site_office_address')) ?></textarea>
            </div>

            <div class="space-y-2 md:col-span-2">
                <label for="site_footer" class="text-sm font-semibold text-gray-700">Footer Situs</label>
                <textarea id="site_footer" name="site_footer" rows="2" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"><?= esc($getValue('site_footer')) ?></textarea>
                <p class="text-xs text-gray-500">Gunakan HTML sederhana untuk menampilkan tautan atau kredit pengembang.</p>
            </div>
        </div>
    </div>

    <div class="space-y-6">
        <div class="border border-gray-200 rounded-lg p-5">
            <div class="flex items-center justify-between">
                <h3 class="text-sm font-semibold text-gray-800 flex items-center gap-2">
                    <i class="fas fa-tools text-purple-500"></i>Mode Maintenance
                </h3>
                <span class="px-2 py-1 text-xs rounded-full <?= $isMaintenance ? 'bg-red-100 text-red-600' : 'bg-green-100 text-green-600' ?>">
                    <?= $isMaintenance ? 'Aktif' : 'Nonaktif' ?>
                </span>
            </div>
            <p class="text-xs text-gray-500 mt-2">
                Mode ini membatasi akses publik saat website sedang dalam perbaikan. Hanya administrator yang dapat mengakses ketika mode aktif.
            </p>
            <div class="mt-4 space-y-2">
                <input type="hidden" name="site_maintenance_mode" value="0">
                <label class="flex items-center gap-2 text-sm text-gray-700">
                    <input type="checkbox" name="site_maintenance_mode" value="1" class="form-checkbox text-red-600 rounded" <?= $isMaintenance ? 'checked' : '' ?>>
                    <span>Aktifkan Mode Maintenance</span>
                </label>
            </div>
        </div>

        <div class="border border-gray-200 rounded-lg p-5 space-y-4">
            <div>
                <h3 class="text-sm font-semibold text-gray-800 flex items-center gap-2">
                    <i class="fas fa-image text-blue-500"></i>Logo Situs
                </h3>
                <p class="text-xs text-gray-500 mt-1">Klik gambar untuk mengubah logo. Ukuran optimal 360x360px (maks 375px).</p>
            </div>
            <div class="flex items-center justify-center">
                <?php if ($logoSetting && !empty($logoSetting['value'])): ?>
                    <a href="<?= base_url('uploads/settings/' . $logoSetting['value']) ?>" target="_blank" class="block">
                        <img src="<?= base_url('uploads/settings/' . $logoSetting['value']) ?>" alt="Logo Situs" class="max-h-40 object-contain rounded border">
                    </a>
                <?php else: ?>
                    <div class="w-full h-40 bg-gray-100 border border-dashed border-gray-300 rounded flex items-center justify-center text-sm text-gray-500">
                        Belum ada logo yang diunggah.
                    </div>
                <?php endif; ?>
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-500 mb-1">Unggah Logo Baru</label>
                <input type="file" name="site_logo" accept="image/*" class="block w-full text-sm text-gray-600 file:mr-3 file:py-2 file:px-3 file:rounded file:border-0 file:bg-blue-50 file:text-blue-600 hover:file:bg-blue-100">
            </div>
        </div>

        <div class="border border-gray-200 rounded-lg p-5 space-y-4">
            <div>
                <h3 class="text-sm font-semibold text-gray-800 flex items-center gap-2">
                    <i class="fas fa-icons text-yellow-500"></i>Icon Situs
                </h3>
                <p class="text-xs text-gray-500 mt-1">Gunakan icon persegi dengan ukuran minimum 128x128px.</p>
            </div>
            <div class="flex items-center justify-center">
                <?php if ($iconSetting && !empty($iconSetting['value'])): ?>
                    <a href="<?= base_url('uploads/settings/' . $iconSetting['value']) ?>" target="_blank" class="block">
                        <img src="<?= base_url('uploads/settings/' . $iconSetting['value']) ?>" alt="Icon Situs" class="w-24 h-24 object-contain rounded border">
                    </a>
                <?php else: ?>
                    <div class="w-24 h-24 bg-gray-100 border border-dashed border-gray-300 rounded flex items-center justify-center text-xs text-gray-500 text-center">
                        Belum ada icon.
                    </div>
                <?php endif; ?>
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-500 mb-1">Unggah Icon Baru</label>
                <input type="file" name="site_icon" accept="image/*" class="block w-full text-sm text-gray-600 file:mr-3 file:py-2 file:px-3 file:rounded file:border-0 file:bg-blue-50 file:text-blue-600 hover:file:bg-blue-100">
            </div>
        </div>
    </div>
</div>

<div class="mt-6 flex justify-end">
    <button type="submit" class="inline-flex items-center gap-2 px-5 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
        <i class="fas fa-save"></i>
        Perbarui Data
    </button>
</div>
