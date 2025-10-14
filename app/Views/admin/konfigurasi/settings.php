<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<div class="p-6" x-data="{ tab: '<?= esc($activeTab) ?>' }">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <h1 class="text-xl font-bold text-gray-800 flex items-center gap-2">
            <i class="fas fa-cogs text-blue-600"></i> Pengaturan Sistem
        </h1>
    </div>

    <form id="settings-form" action="<?= base_url('admin/konfigurasi/settings') ?>" method="POST" enctype="multipart/form-data" class="mt-4 space-y-6">
        <?= csrf_field() ?>
        <input type="hidden" name="active_tab" x-bind:value="tab">

        <div class="flex gap-2 border-b border-gray-200 overflow-x-auto">
            <button type="button" @click="tab='identitas'" :class="tab==='identitas' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500'" class="px-4 py-2 border-b-2 font-semibold flex items-center gap-2">
                <i class="fas fa-id-card"></i>Identitas
            </button>
            <button type="button" @click="tab='konten'" :class="tab==='konten' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500'" class="px-4 py-2 border-b-2 font-semibold flex items-center gap-2">
                <i class="fas fa-file-alt"></i>Konten
            </button>
            <button type="button" @click="tab='medsos'" :class="tab==='medsos' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500'" class="px-4 py-2 border-b-2 font-semibold flex items-center gap-2">
                <i class="fas fa-share-alt"></i>Media Sosial
            </button>
            <button type="button" @click="tab='notif'" :class="tab==='notif' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500'" class="px-4 py-2 border-b-2 font-semibold flex items-center gap-2">
                <i class="fas fa-bell"></i>Notifikasi
            </button>
            <button type="button" @click="tab='utility'" :class="tab==='utility' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500'" class="px-4 py-2 border-b-2 font-semibold flex items-center gap-2">
                <i class="fas fa-toolbox"></i>Utilitas
            </button>
        </div>

        <div class="mt-4 bg-white shadow rounded-lg p-5">
            <template x-if="tab === 'identitas'">
                <div>
                    <?= view('admin/konfigurasi/settings/partials/identitas', ['settings' => $settings['identitas'] ?? [], 'activeTab' => $activeTab]) ?>
                </div>
            </template>

            <template x-if="tab === 'konten'">
                <div>
                    <?= view('admin/konfigurasi/settings/partials/konten', ['settings' => $settings['konten'] ?? [], 'activeTab' => $activeTab]) ?>
                </div>
            </template>

            <template x-if="tab === 'medsos'">
                <div>
                    <?= view('admin/konfigurasi/settings/partials/medsos', ['settings' => $settings['medsos'] ?? [], 'activeTab' => $activeTab]) ?>
                </div>
            </template>

            <template x-if="tab === 'notif'">
                <div>
                    <?= view('admin/konfigurasi/settings/partials/notif', ['settings' => $settings['notif'] ?? [], 'activeTab' => $activeTab]) ?>
                </div>
            </template>

            <template x-if="tab === 'utility'">
                <div>
                    <?= view('admin/konfigurasi/settings/partials/utility', ['settings' => $settings['utility'] ?? [], 'activeTab' => $activeTab]) ?>
                </div>
            </template>
        </div>

        <div class="text-right">
            <button type="submit" class="px-4 py-2 rounded bg-blue-600 text-white hover:bg-blue-700">
                <i class="fas fa-save mr-2"></i>Simpan
            </button>
        </div>
    </form>
</div>

<?= $this->endSection() ?>
