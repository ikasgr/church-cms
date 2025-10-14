<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<div class="mb-6">
    <div class="flex items-center gap-2 text-sm text-gray-600 mb-4">
        <a href="<?= base_url('admin/konfigurasi/settings') ?>" class="hover:text-blue-600">
            <i class="fas fa-cog"></i> Pengaturan
        </a>
        <i class="fas fa-chevron-right text-xs"></i>
        <span class="text-gray-800">Tema</span>
    </div>
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">
                <i class="fas fa-palette text-blue-600 mr-2"></i>Pengaturan Tema Website
            </h2>
            <p class="text-sm text-gray-600 mt-1">Sesuaikan tampilan warna, font, dan logo situs</p>
        </div>
        <a href="<?= base_url('') ?>" target="_blank" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
            <i class="fas fa-external-link-alt mr-2"></i>Lihat Situs
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Theme Form -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-lg shadow-md">
            <form action="<?= base_url('admin/konfigurasi/theme') ?>" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
                <?= csrf_field() ?>

                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">
                        <i class="fas fa-tint mr-2"></i>Warna Utama
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-gray-50 border rounded-lg p-4">
                            <label for="primary_color" class="block text-sm font-medium text-gray-700 mb-2">Warna Primer</label>
                            <div class="flex items-center gap-3">
                                <input type="color" id="primary_color" name="primary_color" value="<?= esc($theme['theme_primary_color'] ?? '#1D4ED8') ?>" class="w-16 h-10 border border-gray-300 rounded">
                                <input type="text" value="<?= esc($theme['theme_primary_color'] ?? '#1D4ED8') ?>" readonly class="flex-1 px-3 py-2 border border-gray-300 rounded bg-white">
                            </div>
                            <p class="text-xs text-gray-500 mt-2">Digunakan untuk tombol utama dan highlight</p>
                        </div>
                        <div class="bg-gray-50 border rounded-lg p-4">
                            <label for="secondary_color" class="block text-sm font-medium text-gray-700 mb-2">Warna Sekunder</label>
                            <div class="flex items-center gap-3">
                                <input type="color" id="secondary_color" name="secondary_color" value="<?= esc($theme['theme_secondary_color'] ?? '#2563EB') ?>" class="w-16 h-10 border border-gray-300 rounded">
                                <input type="text" value="<?= esc($theme['theme_secondary_color'] ?? '#2563EB') ?>" readonly class="flex-1 px-3 py-2 border border-gray-300 rounded bg-white">
                            </div>
                            <p class="text-xs text-gray-500 mt-2">Digunakan untuk elemen sekunder dan hover</p>
                        </div>
                    </div>
                </div>

                <div class="border-t pt-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">
                        <i class="fas fa-font mr-2"></i>Tipografi & Layout
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="font_family" class="block text-sm font-medium text-gray-700 mb-2">Font Utama</label>
                            <select id="font_family" name="font_family" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <?php
                                $fonts = [
                                    'Inter, sans-serif' => 'Inter',
                                    'Roboto, sans-serif' => 'Roboto',
                                    'Poppins, sans-serif' => 'Poppins',
                                    'Open Sans, sans-serif' => 'Open Sans',
                                    'Nunito, sans-serif' => 'Nunito',
                                    'Merriweather, serif' => 'Merriweather'
                                ];
                                $selectedFont = $theme['theme_font_family'] ?? 'Inter, sans-serif';
                                foreach ($fonts as $value => $label): ?>
                                    <option value="<?= esc($value) ?>" <?= $selectedFont == $value ? 'selected' : '' ?>><?= esc($label) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div>
                            <label for="layout" class="block text-sm font-medium text-gray-700 mb-2">Layout</label>
                            <select id="layout" name="layout" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <?php
                                $layouts = [
                                    'wide' => 'Wide (Full Width)',
                                    'boxed' => 'Boxed',
                                    'centered' => 'Centered'
                                ];
                                $selectedLayout = $theme['theme_layout'] ?? 'wide';
                                foreach ($layouts as $value => $label): ?>
                                    <option value="<?= esc($value) ?>" <?= $selectedLayout == $value ? 'selected' : '' ?>><?= esc($label) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="border-t pt-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">
                        <i class="fas fa-image mr-2"></i>Logo Website
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center hover:border-blue-500 transition">
                            <input type="file" id="logo" name="logo" accept="image/*" class="hidden" onchange="previewLogo(this)">
                            <label for="logo" class="cursor-pointer">
                                <div id="logoPreview" class="mb-3">
                                    <?php if (!empty($theme['theme_logo'])): ?>
                                        <img src="<?= base_url('uploads/theme/' . $theme['theme_logo']) ?>" alt="Logo" class="mx-auto max-h-24 object-contain">
                                    <?php else: ?>
                                        <i class="fas fa-image text-4xl text-gray-400"></i>
                                    <?php endif; ?>
                                </div>
                                <p class="text-sm text-gray-600">Klik untuk upload logo</p>
                                <p class="text-xs text-gray-500 mt-1">PNG atau SVG (Disarankan background transparan)</p>
                            </label>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-sm text-gray-600">Pastikan logo memiliki resolusi yang cukup agar tampil tajam di perangkat retina.</p>
                            <ul class="text-xs text-gray-500 mt-3 space-y-2">
                                <li>• Ukuran minimal 256 x 256 px</li>
                                <li>• Format PNG dengan transparansi atau SVG</li>
                                <li>• Maksimal ukuran file 2MB</li>
                            </ul>
                            <?php if (!empty($theme['theme_logo'])): ?>
                                <div class="mt-4">
                                    <p class="text-xs text-gray-500">Logo saat ini:</p>
                                    <p class="text-sm text-gray-800 truncate">uploads/theme/<?= esc($theme['theme_logo']) ?></p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="flex gap-3 pt-6 border-t">
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                        <i class="fas fa-save mr-2"></i>Simpan Pengaturan
                    </button>
                    <a href="<?= base_url('admin/konfigurasi/theme') ?>" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                        <i class="fas fa-redo mr-2"></i>Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Preview & Tips -->
    <div class="space-y-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">
                <i class="fas fa-eye mr-2"></i>Pratinjau Warna
            </h3>
            <div class="space-y-4">
                <div>
                    <p class="text-sm text-gray-600 mb-2">Primer</p>
                    <div class="flex gap-2 items-center">
                        <div class="w-12 h-12 rounded-lg shadow" style="background: <?= esc($theme['theme_primary_color'] ?? '#1D4ED8') ?>"></div>
                        <div class="flex-1 p-3 rounded-lg border" style="border-color: <?= esc($theme['theme_primary_color'] ?? '#1D4ED8') ?>; color: <?= esc($theme['theme_primary_color'] ?? '#1D4ED8') ?>;">
                            Contoh teks
                        </div>
                    </div>
                </div>
                <div>
                    <p class="text-sm text-gray-600 mb-2">Sekunder</p>
                    <div class="flex gap-2 items-center">
                        <div class="w-12 h-12 rounded-lg shadow" style="background: <?= esc($theme['theme_secondary_color'] ?? '#2563EB') ?>"></div>
                        <div class="flex-1 p-3 rounded-lg border" style="border-color: <?= esc($theme['theme_secondary_color'] ?? '#2563EB') ?>; color: <?= esc($theme['theme_secondary_color'] ?? '#2563EB') ?>;">
                            Contoh teks
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">
                <i class="fas fa-lightbulb mr-2"></i>Tips Tampilan
            </h3>
            <div class="space-y-3 text-sm text-gray-600">
                <p>• Gunakan warna kontras untuk memastikan keterbacaan teks.</p>
                <p>• Pastikan font yang dipilih mendukung karakter bahasa Indonesia.</p>
                <p>• Logo transparan terlihat lebih baik pada latar gelap maupun terang.</p>
            </div>
        </div>
    </div>
</div>

<script>
function previewLogo(input) {
    const preview = document.getElementById('logoPreview');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = '<img src="' + e.target.result + '" class="mx-auto max-h-24 object-contain">';
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>

<?= $this->endSection() ?>
