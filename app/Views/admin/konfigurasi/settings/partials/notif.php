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

$smtpHost = $getValue('notif_smtp_host');
$smtpUser = $getValue('notif_smtp_user');
$smtpPassword = $getValue('notif_smtp_password');
$smtpPort = $getValue('notif_smtp_port', 465);
$smtpFromName = $getValue('notif_smtp_from_name');
$smtpReplyText = $getValue('notif_smtp_reply_text');

$waApiKey = $getValue('notif_wa_api_key');
$waServerUrl = $getValue('notif_wa_server_url');
$waSenderNumber = $getValue('notif_wa_sender_number');
$waRecipientNumber = $getValue('notif_wa_recipient_number');

?>

<div class="space-y-6">
    <div class="border border-blue-100 bg-blue-50 rounded-lg p-4">
        <h2 class="text-sm font-semibold text-blue-700 flex items-center gap-2">
            <i class="fas fa-envelope"></i>Pengaturan Email Pemberitahuan
        </h2>
        <p class="text-xs text-blue-600 mt-1">
            Gunakan kredensial SMTP yang valid agar sistem dapat mengirimkan email informasi secara otomatis.
        </p>
    </div>

    <div class="rounded-lg border border-amber-200 bg-amber-50 px-4 py-3 text-xs text-amber-700">
        <p class="font-semibold">Pastikan akun email SMTP Anda telah dikonfigurasi di hosting.</p>
        <p class="mt-1">Untuk SMTP Google, sesuaikan pengaturan dengan kebijakan Google yang dapat berubah sewaktu-waktu.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
        <div class="space-y-2">
            <label for="notif_smtp_host" class="text-sm font-semibold text-gray-700 flex items-center gap-2">
                <i class="fas fa-server"></i>Host SMTP
            </label>
            <input type="text" id="notif_smtp_host" name="notif_smtp_host" value="<?= esc($smtpHost) ?>" placeholder="smtp.domain.com" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
        </div>
        <div class="space-y-2">
            <label for="notif_smtp_user" class="text-sm font-semibold text-gray-700 flex items-center gap-2">
                <i class="fas fa-at"></i>User SMTP
            </label>
            <input type="email" id="notif_smtp_user" name="notif_smtp_user" value="<?= esc($smtpUser) ?>" placeholder="email@domain.com" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
        </div>

        <div class="space-y-2">
            <label for="notif_smtp_password" class="text-sm font-semibold text-gray-700 flex items-center gap-2">
                <i class="fas fa-lock"></i>Password SMTP
            </label>
            <input type="password" id="notif_smtp_password" name="notif_smtp_password" value="<?= esc($smtpPassword) ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
        </div>
        <div class="space-y-2">
            <label for="notif_smtp_port" class="text-sm font-semibold text-gray-700 flex items-center gap-2">
                <i class="fas fa-ethernet"></i>Port SMTP
            </label>
            <input type="number" id="notif_smtp_port" name="notif_smtp_port" value="<?= esc($smtpPort) ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
        </div>

        <div class="space-y-2 lg:col-span-2">
            <label for="notif_smtp_reply_text" class="text-sm font-semibold text-gray-700 flex items-center gap-2">
                <i class="fas fa-comment-dots"></i>Balasan Pembuka
            </label>
            <input type="text" id="notif_smtp_reply_text" name="notif_smtp_reply_text" value="<?= esc($smtpReplyText) ?>" placeholder="Terima kasih telah menghubungi kami..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
        </div>

        <div class="space-y-2 lg:col-span-2">
            <label for="notif_smtp_from_name" class="text-sm font-semibold text-gray-700 flex items-center gap-2">
                <i class="fas fa-user"></i>Nama Pengirim
            </label>
            <input type="text" id="notif_smtp_from_name" name="notif_smtp_from_name" value="<?= esc($smtpFromName) ?>" placeholder="Nama yang tampil di email" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
        </div>
    </div>

    <hr class="border-dashed">

    <div class="border border-green-200 bg-green-50 rounded-lg p-4">
        <h3 class="text-sm font-semibold text-green-600 flex items-center gap-2">
            <i class="fab fa-whatsapp"></i>Pengaturan WhatsApp Pemberitahuan
        </h3>
        <p class="text-xs text-green-600 mt-1">Integrasikan layanan WhatsApp Gateway untuk mengirimkan notifikasi penting secara instan.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
        <div class="space-y-2">
            <label for="notif_wa_api_key" class="text-sm font-semibold text-gray-700 flex items-center gap-2">
                <i class="fas fa-key"></i>API Key
            </label>
            <input type="text" id="notif_wa_api_key" name="notif_wa_api_key" value="<?= esc($waApiKey) ?>" placeholder="Masukkan API Key" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus-border-transparent">
        </div>
        <div class="space-y-2">
            <label for="notif_wa_server_url" class="text-sm font-semibold text-gray-700 flex items-center gap-2">
                <i class="fas fa-link"></i>URL Server
            </label>
            <input type="url" id="notif_wa_server_url" name="notif_wa_server_url" value="<?= esc($waServerUrl) ?>" placeholder="https://gateway.whatsapp.com" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus-border-transparent">
        </div>

        <div class="space-y-2">
            <label for="notif_wa_sender_number" class="text-sm font-semibold text-gray-700 flex items-center gap-2">
                <i class="fab fa-whatsapp"></i>Nomor WhatsApp Terdaftar
            </label>
            <input type="text" id="notif_wa_sender_number" name="notif_wa_sender_number" value="<?= esc($waSenderNumber) ?>" placeholder="62xxx" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus-border-transparent">
        </div>
        <div class="space-y-2">
            <label for="notif_wa_recipient_number" class="text-sm font-semibold text-gray-700 flex items-center gap-2">
                <i class="fas fa-phone"></i>Nomor WhatsApp Penerima Pesan
            </label>
            <input type="text" id="notif_wa_recipient_number" name="notif_wa_recipient_number" value="<?= esc($waRecipientNumber) ?>" placeholder="62xxx" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus-border-transparent">
        </div>
    </div>

    <div class="flex justify-end">
        <button type="submit" class="inline-flex items-center gap-2 px-5 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
            <i class="fas fa-save"></i>
            Simpan Pengaturan Notifikasi
        </button>
    </div>
</div>
