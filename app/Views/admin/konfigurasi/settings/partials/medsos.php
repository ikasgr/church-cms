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

$socialPlatforms = [
    'social_facebook' => ['label' => 'Facebook', 'icon' => 'fab fa-facebook'],
    'social_instagram' => ['label' => 'Instagram', 'icon' => 'fab fa-instagram'],
    'social_youtube' => ['label' => 'YouTube', 'icon' => 'fab fa-youtube'],
    'social_tiktok' => ['label' => 'TikTok', 'icon' => 'fab fa-tiktok'],
    'social_twitter' => ['label' => 'X / Twitter', 'icon' => 'fab fa-x-twitter'],
    'social_linkedin' => ['label' => 'LinkedIn', 'icon' => 'fab fa-linkedin-in'],
    'social_whatsapp' => ['label' => 'WhatsApp Channel', 'icon' => 'fab fa-whatsapp'],
];

$shareMessage = $getValue('social_share_message');
$hashtag = $getValue('social_hashtag');
$contactEmail = $getValue('social_contact_email');
$contactPhone = $getValue('social_contact_phone');
$customScript = $getValue('social_widget_script');

?>

<div class="space-y-6">
    <div class="border border-blue-100 bg-blue-50 rounded-lg p-4">
        <h2 class="text-sm font-semibold text-blue-700 flex items-center gap-2">
            <i class="fas fa-share-alt"></i>Integrasi Media Sosial
        </h2>
        <p class="text-xs text-blue-600 mt-1">
            Hubungkan akun media sosial untuk meningkatkan interaksi jemaat dan tampilkan tautan resmi di situs.
        </p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
        <?= $booleanField('social_show_bar', '<i class="fas fa-eye"></i>Tampilkan Bar Ikon Sosial', 'Tampilkan kumpulan ikon medsos di header/footer.') ?>
        <?= $booleanField('social_enable_share', '<i class="fas fa-share-nodes"></i>Aktifkan Tombol Bagikan', 'Tampilkan tombol share di halaman berita/artikel.') ?>
        <?= $booleanField('social_enable_whatsapp_button', '<i class="fab fa-whatsapp"></i>Tombol Whatsapp Cepat') ?>
        <?= $booleanField('social_show_follow_section', '<i class="fas fa-users"></i>Tampilkan Section Follow Us') ?>
    </div>

    <div class="border border-gray-200 rounded-lg">
        <div class="border-b border-gray-200 px-5 py-3 bg-gray-50">
            <h3 class="text-sm font-semibold text-gray-700 flex items-center gap-2">
                <i class="fas fa-link"></i>Link Akun Media Sosial
            </h3>
            <p class="text-xs text-gray-500">Gunakan URL penuh termasuk protokol (https://).</p>
        </div>
        <div class="p-5 grid grid-cols-1 md:grid-cols-2 gap-4">
            <?php foreach ($socialPlatforms as $key => $meta): ?>
                <div class="space-y-2">
                    <label for="<?= esc($key) ?>" class="text-sm font-semibold text-gray-700 flex items-center gap-2">
                        <i class="<?= esc($meta['icon']) ?> text-blue-500"></i><?= esc($meta['label']) ?>
                    </label>
                    <input type="url" id="<?= esc($key) ?>" name="<?= esc($key) ?>" value="<?= esc($getValue($key)) ?>" placeholder="https://..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
        <div class="space-y-2">
            <label for="social_share_message" class="text-sm font-semibold text-gray-700 flex items-center gap-2">
                <i class="fas fa-message"></i>Pesan Default Share
            </label>
            <textarea id="social_share_message" name="social_share_message" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Bagikan kabar sukacita dari ..."><?= esc($shareMessage) ?></textarea>
        </div>
        <div class="space-y-2">
            <label for="social_hashtag" class="text-sm font-semibold text-gray-700 flex items-center gap-2">
                <i class="fas fa-hashtag"></i>Hashtag Kampanye
            </label>
            <input type="text" id="social_hashtag" name="social_hashtag" value="<?= esc($hashtag) ?>" placeholder="#GerejaHebat" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            <p class="text-xs text-gray-500">Pisahkan beberapa hashtag dengan koma.</p>
        </div>

        <div class="space-y-2">
            <label for="social_contact_email" class="text-sm font-semibold text-gray-700 flex items-center gap-2">
                <i class="fas fa-envelope"></i>Email Kontak Media Sosial
            </label>
            <input type="email" id="social_contact_email" name="social_contact_email" value="<?= esc($contactEmail) ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
        </div>
        <div class="space-y-2">
            <label for="social_contact_phone" class="text-sm font-semibold text-gray-700 flex items-center gap-2">
                <i class="fas fa-phone"></i>Nomor Hotline / Call Center
            </label>
            <input type="text" id="social_contact_phone" name="social_contact_phone" value="<?= esc($contactPhone) ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
        </div>
    </div>

    <div class="space-y-2">
        <label for="social_widget_script" class="text-sm font-semibold text-gray-700 flex items-center gap-2">
            <i class="fas fa-code"></i>Widget Embed
        </label>
        <textarea id="social_widget_script" name="social_widget_script" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent font-mono text-xs" placeholder="Tempelkan script widget (contoh: Facebook Page, Instagram Feed)"><?= esc($customScript) ?></textarea>
        <p class="text-xs text-gray-500">Gunakan dengan hati-hati dan pastikan script berasal dari sumber terpercaya.</p>
    </div>

    <div class="flex justify-end">
        <button type="submit" class="inline-flex items-center gap-2 px-5 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
            <i class="fas fa-save"></i>
            Simpan Pengaturan Media Sosial
        </button>
    </div>
</div>
