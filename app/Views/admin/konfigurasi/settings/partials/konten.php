<?php
$settings = $settings ?? [];

$getSetting = static function ($key) use ($settings) {
    foreach ($settings as $setting) {
        if ($setting['key'] === $key) {
            return $setting;
        }
    }
    return null;
};

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

$roles = ['admin' => 'Admin', 'editor' => 'Editor', 'author' => 'Author', 'member' => 'Member'];
$selectedRole = $getValue('content_default_role', 'author');

$newsCategoriesSetting = $getSetting('content_news_category');
$categoryOptions = [];
if ($newsCategoriesSetting && $newsCategoriesSetting['type'] === 'json') {
    $decoded = json_decode($newsCategoriesSetting['value'], true) ?: [];
    if (is_array($decoded)) {
        $categoryOptions = $decoded;
    }
}
$selectedCategory = $getValue('content_news_category', $categoryOptions ? array_key_first($categoryOptions) : '');

?>

<div class="space-y-6">
    <div class="border border-blue-100 bg-blue-50 rounded-lg p-4">
        <h2 class="text-sm font-semibold text-blue-700 flex items-center gap-2">
            <i class="fas fa-newspaper"></i>Pengaturan Konten Beranda
        </h2>
        <p class="text-xs text-blue-600 mt-1">
            Atur penampilan informasi dinamis seperti section informasi, running text, serta komponen interaksi pengunjung.
        </p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
        <div class="space-y-2">
            <label for="content_section_title" class="text-sm font-semibold text-gray-700 flex items-center gap-2">
                <i class="fas fa-heading"></i>Judul Section
            </label>
            <input type="text" id="content_section_title" name="content_section_title" value="<?= esc($getValue('content_section_title')) ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
        </div>

        <?= $booleanField('content_show_section', '<i class="fas fa-eye"></i>Tampilkan Section') ?>

        <?= $booleanField('content_show_running_text', '<i class="fas fa-bullhorn"></i>Tampilkan Running Text', 'Sumber data dari modul pengumuman.') ?>
        <?= $booleanField('content_show_counter', '<i class="fas fa-chart-bar"></i>Tampilkan Counter') ?>

        <?= $booleanField('content_enable_registration', '<i class="fas fa-user-plus"></i>Aktifkan Registrasi') ?>

        <div class="space-y-2">
            <label for="content_default_role" class="text-sm font-semibold text-gray-700 flex items-center gap-2">
                <i class="fas fa-user-tag"></i>Role User saat Daftar
            </label>
            <select id="content_default_role" name="content_default_role" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <?php foreach ($roles as $value => $label): ?>
                    <option value="<?= esc($value) ?>" <?= $selectedRole === $value ? 'selected' : '' ?>><?= esc($label) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <?= $booleanField('content_connect_unit', '<i class="fas fa-network-wired"></i>Konek Unit Kerja') ?>
        <?= $booleanField('content_verify_post', '<i class="fas fa-check-circle"></i>Verifikasi Postingan') ?>

        <?= $booleanField('content_show_popup', '<i class="fas fa-window-restore"></i>Tampilkan Popup', 'Isi popup diatur melalui menu Set Konten.') ?>

        <div class="space-y-2">
            <label for="content_news_category" class="text-sm font-semibold text-gray-700 flex items-center gap-2">
                <i class="fas fa-folder-open"></i>Kategori Berita
            </label>
            <?php if ($categoryOptions): ?>
                <select id="content_news_category" name="content_news_category" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <?php foreach ($categoryOptions as $value => $label): ?>
                        <option value="<?= esc($value) ?>" <?= $selectedCategory == $value ? 'selected' : '' ?>><?= esc(is_string($label) ? $label : $value) ?></option>
                    <?php endforeach; ?>
                </select>
            <?php else: ?>
                <input type="text" id="content_news_category" name="content_news_category" value="<?= esc($selectedCategory) ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Masukkan kategori default">
                <p class="text-xs text-gray-500 mt-1">Tambahkan daftar kategori melalui pengaturan JSON atau modul berita.</p>
            <?php endif; ?>
        </div>
    </div>

    <div class="space-y-2">
        <label for="content_slogan" class="text-sm font-semibold text-gray-700 flex items-center gap-2">
            <i class="fas fa-quote-left"></i>Slogan / Kata Mutiara
        </label>
        <textarea id="content_slogan" name="content_slogan" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"><?= esc($getValue('content_slogan')) ?></textarea>
    </div>

    <div class="flex justify-end">
        <button type="submit" class="inline-flex items-center gap-2 px-5 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
            <i class="fas fa-save"></i>
            Simpan Pengaturan
        </button>
    </div>
</div>
