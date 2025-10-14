<?php
$settings = $settings ?? [];

$getValue = static function ($key, $default = '') use ($settings) {
    foreach ($settings as $setting) {
        if ($setting['key'] === $key) {
            return old($key, $setting['value']);
        }
    }

    return old($key, $default);
};

$isTrue = static function ($value) {
    return in_array($value, ['1', 1, true, 'true', 'yes', 'on'], true);
};

$booleanField = static function ($key, $label, $note = '') use ($getValue, $isTrue) {
    $current = $getValue($key, 0);
    $checked = $isTrue($current);
    ob_start();
    ?>
    <div class="space-y-2">
        <label class="text-sm font-semibold text-gray-700 flex items-center gap-2">
            <?= $label ?>
        </label>
        <?php if ($note): ?>
            <p class="text-xs text-gray-500"><?= $note ?></p>
        <?php endif; ?>
        <div class="inline-flex items-center gap-6 text-sm">
            <label class="inline-flex items-center gap-2">
                <input type="radio" name="<?= esc($key) ?>" value="1" class="form-radio text-blue-600" <?= $checked ? 'checked' : '' ?>>
                <span>Ya</span>
            </label>
            <label class="inline-flex items-center gap-2">
                <input type="radio" name="<?= esc($key) ?>" value="0" class="form-radio text-gray-400" <?= !$checked ? 'checked' : '' ?>>
                <span>Tidak</span>
            </label>
        </div>
    </div>
    <?php
    return ob_get_clean();
};

$loginBaseUrl = $getValue('utility_login_base_url', base_url());
$loginAlias = $getValue('utility_login_alias', 'cms-login');
$recaptchaSiteKey = $getValue('utility_recaptcha_site_key');
$recaptchaSecretKey = $getValue('utility_recaptcha_secret_key');
$backupInfo = [
    ['icon' => 'fas fa-check-circle text-green-500', 'text' => 'Lakukan pencadangan data secara berkala dan simpan di lokasi aman di luar server utama.'],
    ['icon' => 'fas fa-trash text-yellow-500', 'text' => 'Hapus salinan cadangan lama sebelum membuat cadangan baru untuk mengoptimalkan ruang penyimpanan.'],
    ['icon' => 'fas fa-exclamation-triangle text-red-500', 'text' => 'Pastikan file cadangan dihapus dari server setelah diunduh untuk mencegah potensi ancaman keamanan.'],
];

?>

<div class="space-y-6">
    <div class="border border-blue-100 bg-blue-50 rounded-lg p-4">
        <h2 class="text-sm font-semibold text-blue-700 flex items-center gap-2">
            <i class="fas fa-tools"></i>Pengaturan Utilitas & Keamanan
        </h2>
        <p class="text-xs text-blue-600 mt-1">
            Kelola URL login, autentikasi tambahan, integrasi keamanan, serta alat pemeliharaan sistem.
        </p>
    </div>

    <div class="border border-gray-200 rounded-lg">
        <div class="border-b border-gray-200 px-5 py-3 bg-gray-50 flex items-center gap-2 text-sm font-semibold text-gray-700">
            <i class="fas fa-link"></i>
            Login Page URL
        </div>
        <div class="p-5 space-y-5">
            <div class="rounded-lg border border-violet-200 bg-violet-50 px-4 py-3 text-xs text-violet-700">
                <p class="font-semibold">Ganti URL login untuk meningkatkan keamanan. Pastikan mudah diingat dan aman.</p>
                <p class="mt-1 text-violet-600">Ubah URL login secara berkala untuk mencegah akses bot atau peretas.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="space-y-2">
                    <label for="utility_login_base_url" class="text-sm font-semibold text-gray-700">URL Utama Login</label>
                    <input type="url" id="utility_login_base_url" name="utility_login_base_url" value="<?= esc($loginBaseUrl) ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                <div class="space-y-2">
                    <label for="utility_login_alias" class="text-sm font-semibold text-gray-700">Alias URL Login</label>
                    <input type="text" id="utility_login_alias" name="utility_login_alias" value="<?= esc($loginAlias) ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="cms-login">
                    <p class="text-xs text-gray-500">URL login menjadi: <span class="font-semibold"><?= esc(trim($loginBaseUrl, '/')) ?>/<?= esc($loginAlias) ?></span></p>
                </div>
            </div>

            <?= $booleanField('utility_enable_login_otp', '<i class="fas fa-shield-alt"></i>Aktifkan One-Time Password (OTP) Login') ?>
        </div>
    </div>

    <div class="border border-gray-200 rounded-lg">
        <div class="border-b border-gray-200 px-5 py-3 bg-gray-50 flex items-center gap-2 text-sm font-semibold text-gray-700">
            <i class="fas fa-robot"></i>
            Google reCAPTCHA v2
        </div>
        <div class="p-5 space-y-4">
            <p class="text-xs text-gray-500">Tambahkan Site Key dan Secret Key dari konsol Google reCAPTCHA untuk melindungi formulir publik.</p>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="space-y-2">
                    <label for="utility_recaptcha_site_key" class="text-sm font-semibold text-gray-700">Site Key <a href="https://www.google.com/recaptcha/about/" target="_blank" class="text-blue-600 text-xs ml-1">(Daftar)</a></label>
                    <input type="text" id="utility_recaptcha_site_key" name="utility_recaptcha_site_key" value="<?= esc($recaptchaSiteKey) ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                <div class="space-y-2">
                    <label for="utility_recaptcha_secret_key" class="text-sm font-semibold text-gray-700">Secret Key <a href="https://developers.google.com/recaptcha/docs/v2" target="_blank" class="text-blue-600 text-xs ml-1">(Baca petunjuk)</a></label>
                    <input type="text" id="utility_recaptcha_secret_key" name="utility_recaptcha_secret_key" value="<?= esc($recaptchaSecretKey) ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
            </div>
        </div>
    </div>

    <div class="border border-gray-200 rounded-lg">
        <div class="border-b border-gray-200 px-5 py-3 bg-gray-50 flex items-center gap-2 text-sm font-semibold text-gray-700">
            <i class="fas fa-database"></i>
            Backup Database
        </div>
        <div class="p-5 space-y-4">
            <div class="rounded-lg border border-blue-200 bg-blue-50 px-4 py-4 space-y-3 text-sm text-gray-700">
                <?php foreach ($backupInfo as $item): ?>
                    <p class="flex items-start gap-2">
                        <i class="<?= esc($item['icon']) ?> mt-1"></i>
                        <span><?= esc($item['text']) ?></span>
                    </p>
                <?php endforeach; ?>
            </div>
            <div>
                <button type="button" class="inline-flex items-center gap-2 px-5 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    <i class="fas fa-cloud-download-alt"></i>
                    Backup Database
                </button>
                <p class="text-xs text-gray-500 mt-2">Tombol ini menjalankan proses backup sesuai konfigurasi backend (implementasi tambahan diperlukan).</p>
            </div>
        </div>
    </div>
</div>
