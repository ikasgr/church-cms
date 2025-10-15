<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<div class="mb-6">
    <div class="flex items-center gap-2 text-sm text-gray-600 mb-4">
        <a href="<?= base_url('admin/konfigurasi/users') ?>" class="hover:text-blue-600">
            <i class="fas fa-users"></i> Manajemen User
        </a>
        <i class="fas fa-chevron-right text-xs"></i>
        <span class="text-gray-800">Tambah User</span>
    </div>
    <h2 class="text-2xl font-bold text-gray-800">
        <i class="fas fa-user-plus text-blue-600 mr-2"></i>Tambah User Baru
    </h2>
    <p class="text-sm text-gray-600 mt-2">Isi form berikut untuk menambahkan user admin baru.</p>
</div>

<div class="bg-white rounded-lg shadow-md max-w-3xl">
    <form action="<?= base_url('admin/konfigurasi/users/create') ?>" method="POST" class="p-6">
        <?= csrf_field() ?>

        <div class="space-y-6">
            <div>
                <label for="username" class="block text-sm font-medium text-gray-700 mb-2">
                    Username <span class="text-red-500">*</span>
                </label>
                <input type="text" id="username" name="username" required
                       value="<?= old('username') ?>"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                       placeholder="Username untuk login">
                <?php if (isset($validation) && $validation->hasError('username')): ?>
                    <p class="text-red-500 text-sm mt-1"><?= $validation->getError('username') ?></p>
                <?php endif; ?>
            </div>

            <div>
                <label for="full_name" class="block text-sm font-medium text-gray-700 mb-2">
                    Nama Lengkap <span class="text-red-500">*</span>
                </label>
                <input type="text" id="full_name" name="full_name" required
                       value="<?= old('full_name') ?>"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                       placeholder="Nama lengkap user">
                <?php if (isset($validation) && $validation->hasError('full_name')): ?>
                    <p class="text-red-500 text-sm mt-1"><?= $validation->getError('full_name') ?></p>
                <?php endif; ?>
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                    Email <span class="text-red-500">*</span>
                </label>
                <input type="email" id="email" name="email" required
                       value="<?= old('email') ?>"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                       placeholder="email@example.com">
                <?php if (isset($validation) && $validation->hasError('email')): ?>
                    <p class="text-red-500 text-sm mt-1"><?= $validation->getError('email') ?></p>
                <?php endif; ?>
            </div>

            <div>
                <label for="role" class="block text-sm font-medium text-gray-700 mb-2">
                    Role <span class="text-red-500">*</span>
                </label>
                <select id="role" name="role" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="admin" <?= old('role') == 'admin' ? 'selected' : '' ?>>Admin - Akses penuh</option>
                    <option value="editor" <?= old('role') == 'editor' ? 'selected' : '' ?>>Editor - Kelola konten</option>
                    <option value="viewer" <?= old('role') == 'viewer' ? 'selected' : '' ?>>Viewer - Hanya lihat</option>
                    <option value="seller" <?= old('role') == 'seller' ? 'selected' : '' ?>>Seller - Pengelola UMKM</option>
                </select>
                <?php if (isset($validation) && $validation->hasError('role')): ?>
                    <p class="text-red-500 text-sm mt-1"><?= $validation->getError('role') ?></p>
                <?php endif; ?>
            </div>

            <div id="seller-section" class="space-y-4" style="display: none;">
                <div class="border-t pt-6">
                    <h4 class="text-md font-semibold text-gray-800 mb-4 flex items-center gap-2">
                        <i class="fas fa-store text-blue-600"></i>
                        Pilih Pelapak UMKM
                    </h4>
                    <p class="text-sm text-gray-600 mb-4">Hubungkan akun seller dengan data pelapak yang telah terdaftar.</p>
                </div>

                <div>
                    <label for="seller_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Pelapak UMKM <span class="text-red-500">*</span>
                    </label>
                    <select id="seller_id" name="seller_id"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">-- Pilih Pelapak --</option>
                        <?php foreach ($sellers as $seller): ?>
                            <option value="<?= $seller['id'] ?>" <?= old('seller_id') == $seller['id'] ? 'selected' : '' ?>>
                                <?= esc($seller['business_name']) ?> (<?= esc($seller['owner_name']) ?>)
                                <?php if ($seller['status']): ?> - Status: <?= esc(ucfirst($seller['status'])) ?><?php endif; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?php if (isset($validation) && $validation->hasError('seller_id')): ?>
                        <p class="text-red-500 text-sm mt-1"><?= $validation->getError('seller_id') ?></p>
                    <?php endif; ?>
                    <?php if (empty($sellers)): ?>
                        <p class="text-sm text-yellow-600 mt-2">
                            <i class="fas fa-info-circle mr-1"></i>
                            Belum ada pelapak yang tersedia. Tambahkan data pelapak melalui modul UMKM terlebih dahulu.
                        </p>
                    <?php endif; ?>
                </div>
            </div>

            <div>
                <label class="flex items-center">
                    <input type="checkbox" name="is_active" value="1"
                           class="form-checkbox text-blue-600 rounded"
                           <?= old('is_active', 1) ? 'checked' : '' ?>>
                    <span class="ml-2 text-sm text-gray-700">
                        <i class="fas fa-check-circle text-green-600 mr-1"></i>Aktifkan user (dapat login)
                    </span>
                </label>
            </div>

            <div class="border-t pt-6">
                <h4 class="text-md font-semibold text-gray-800 mb-4">
                    <i class="fas fa-lock mr-2"></i>Password User
                </h4>
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                    Password <span class="text-red-500">*</span>
                </label>
                <input type="password" id="password" name="password" required
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                       placeholder="Minimal 6 karakter">
                <?php if (isset($validation) && $validation->hasError('password')): ?>
                    <p class="text-red-500 text-sm mt-1"><?= $validation->getError('password') ?></p>
                <?php endif; ?>
            </div>

            <div>
                <label for="confirm_password" class="block text-sm font-medium text-gray-700 mb-2">
                    Konfirmasi Password <span class="text-red-500">*</span>
                </label>
                <input type="password" id="confirm_password" name="confirm_password" required
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                       placeholder="Ulangi password">
                <?php if (isset($validation) && $validation->hasError('confirm_password')): ?>
                    <p class="text-red-500 text-sm mt-1"><?= $validation->getError('confirm_password') ?></p>
                <?php endif; ?>
            </div>
        </div>

        <div class="flex gap-3 pt-6 border-t mt-6">
            <button type="submit"
                    class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                <i class="fas fa-save mr-2"></i>Simpan User
            </button>
            <a href="<?= base_url('admin/konfigurasi/users') ?>"
               class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                <i class="fas fa-times mr-2"></i>Batal
            </a>
        </div>

        <div class="mt-4 p-4 bg-blue-50 rounded-lg">
            <p class="text-sm text-blue-800">
                <i class="fas fa-info-circle mr-2"></i>
                <strong>Catatan:</strong> Pastikan email dan username unik. Role menentukan hak akses user di sistem. Role seller terhubung dengan data pelapak UMKM.
            </p>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const roleSelect = document.getElementById('role');
        const sellerSection = document.getElementById('seller-section');

        const toggleSellerSection = () => {
            if (roleSelect.value === 'seller') {
                sellerSection.style.display = '';
            } else {
                sellerSection.style.display = 'none';
            }
        };

        roleSelect.addEventListener('change', toggleSellerSection);
        toggleSellerSection();
    });
</script>

<?= $this->endSection() ?>
