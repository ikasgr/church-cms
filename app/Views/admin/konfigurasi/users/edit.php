<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<div class="mb-6">
    <div class="flex items-center gap-2 text-sm text-gray-600 mb-4">
        <a href="<?= base_url('admin/konfigurasi/users') ?>" class="hover:text-blue-600">
            <i class="fas fa-users"></i> Manajemen User
        </a>
        <i class="fas fa-chevron-right text-xs"></i>
        <span class="text-gray-800">Edit User</span>
    </div>
    <h2 class="text-2xl font-bold text-gray-800">
        <i class="fas fa-user-edit text-blue-600 mr-2"></i>Edit User: <?= $user['username'] ?>
    </h2>
</div>

<div class="bg-white rounded-lg shadow-md max-w-3xl">
    <form action="<?= base_url('admin/konfigurasi/users/edit/' . $user['id']) ?>" method="POST" class="p-6">
        <?= csrf_field() ?>
        
        <div class="space-y-6">
            <!-- Username -->
            <div>
                <label for="username" class="block text-sm font-medium text-gray-700 mb-2">
                    Username <span class="text-red-500">*</span>
                </label>
                <input type="text" id="username" name="username" required
                       value="<?= old('username', $user['username']) ?>"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                       placeholder="Username untuk login">
                <?php if (isset($validation) && $validation->hasError('username')): ?>
                    <p class="text-red-500 text-sm mt-1"><?= $validation->getError('username') ?></p>
                <?php endif; ?>
            </div>

            <!-- Full Name -->
            <div>
                <label for="full_name" class="block text-sm font-medium text-gray-700 mb-2">
                    Nama Lengkap <span class="text-red-500">*</span>
                </label>
                <input type="text" id="full_name" name="full_name" required
                       value="<?= old('full_name', $user['full_name']) ?>"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                       placeholder="Nama lengkap user">
                <?php if (isset($validation) && $validation->hasError('full_name')): ?>
                    <p class="text-red-500 text-sm mt-1"><?= $validation->getError('full_name') ?></p>
                <?php endif; ?>
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                    Email <span class="text-red-500">*</span>
                </label>
                <input type="email" id="email" name="email" required
                       value="<?= old('email', $user['email']) ?>"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                       placeholder="email@example.com">
                <?php if (isset($validation) && $validation->hasError('email')): ?>
                    <p class="text-red-500 text-sm mt-1"><?= $validation->getError('email') ?></p>
                <?php endif; ?>
            </div>

            <!-- Role -->
            <div>
                <label for="role" class="block text-sm font-medium text-gray-700 mb-2">
                    Role <span class="text-red-500">*</span>
                </label>
                <select id="role" name="role" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="admin" <?= old('role', $user['role']) == 'admin' ? 'selected' : '' ?>>Admin - Akses penuh</option>
                    <option value="editor" <?= old('role', $user['role']) == 'editor' ? 'selected' : '' ?>>Editor - Kelola konten</option>
                    <option value="viewer" <?= old('role', $user['role']) == 'viewer' ? 'selected' : '' ?>>Viewer - Hanya lihat</option>
                </select>
                <?php if (isset($validation) && $validation->hasError('role')): ?>
                    <p class="text-red-500 text-sm mt-1"><?= $validation->getError('role') ?></p>
                <?php endif; ?>
            </div>

            <!-- Status -->
            <div>
                <label class="flex items-center">
                    <input type="checkbox" name="is_active" value="1" 
                           class="form-checkbox text-blue-600 rounded"
                           <?= old('is_active', $user['is_active']) ? 'checked' : '' ?>>
                    <span class="ml-2 text-sm text-gray-700">
                        <i class="fas fa-check-circle text-green-600 mr-1"></i>User aktif (dapat login)
                    </span>
                </label>
            </div>

            <!-- Divider -->
            <div class="border-t pt-6">
                <h4 class="text-md font-semibold text-gray-800 mb-4">
                    <i class="fas fa-lock mr-2"></i>Ubah Password (Opsional)
                </h4>
                <p class="text-sm text-gray-600 mb-4">Kosongkan jika tidak ingin mengubah password</p>
            </div>

            <!-- New Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                    Password Baru
                </label>
                <input type="password" id="password" name="password"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                       placeholder="Minimal 6 karakter">
                <?php if (isset($validation) && $validation->hasError('password')): ?>
                    <p class="text-red-500 text-sm mt-1"><?= $validation->getError('password') ?></p>
                <?php endif; ?>
            </div>

            <!-- Confirm Password -->
            <div>
                <label for="confirm_password" class="block text-sm font-medium text-gray-700 mb-2">
                    Konfirmasi Password Baru
                </label>
                <input type="password" id="confirm_password" name="confirm_password"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                       placeholder="Ulangi password baru">
                <?php if (isset($validation) && $validation->hasError('confirm_password')): ?>
                    <p class="text-red-500 text-sm mt-1"><?= $validation->getError('confirm_password') ?></p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex gap-3 pt-6 border-t mt-6">
            <button type="submit" 
                    class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                <i class="fas fa-save mr-2"></i>Update User
            </button>
            <a href="<?= base_url('admin/konfigurasi/users') ?>" 
               class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                <i class="fas fa-times mr-2"></i>Batal
            </a>
        </div>

        <!-- Info Box -->
        <div class="mt-4 p-4 bg-yellow-50 rounded-lg">
            <p class="text-sm text-yellow-800">
                <i class="fas fa-info-circle mr-2"></i>
                <strong>Catatan:</strong> Perubahan role akan mempengaruhi hak akses user di sistem.
            </p>
        </div>
    </form>
</div>

<!-- User Info Card -->
<div class="bg-white rounded-lg shadow-md max-w-3xl mt-6 p-6">
    <h3 class="text-lg font-semibold text-gray-800 mb-4">
        <i class="fas fa-info-circle mr-2"></i>Informasi User
    </h3>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
        <div>
            <p class="text-gray-600">ID User</p>
            <p class="font-semibold text-gray-800"><?= $user['id'] ?></p>
        </div>
        <div>
            <p class="text-gray-600">Status</p>
            <p>
                <span class="px-2 py-1 text-xs font-semibold rounded-full <?= $user['is_active'] ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' ?>">
                    <?= $user['is_active'] ? 'Aktif' : 'Non-Aktif' ?>
                </span>
            </p>
        </div>
        <div>
            <p class="text-gray-600">Terdaftar</p>
            <p class="font-semibold text-gray-800"><?= date('d M Y H:i', strtotime($user['created_at'])) ?></p>
        </div>
        <?php if ($user['last_login']): ?>
            <div>
                <p class="text-gray-600">Login Terakhir</p>
                <p class="font-semibold text-gray-800"><?= date('d M Y H:i', strtotime($user['last_login'])) ?></p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>
