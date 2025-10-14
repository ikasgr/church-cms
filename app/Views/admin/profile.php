<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-800">
        <i class="fas fa-user-circle text-blue-600 mr-2"></i>Profile Admin
    </h2>
    <p class="text-sm text-gray-600 mt-1">Kelola informasi akun Anda</p>
</div>

<?php if (session()->getFlashdata('success')): ?>
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
        <i class="fas fa-check-circle mr-2"></i><?= session()->getFlashdata('success') ?>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6">
        <i class="fas fa-exclamation-circle mr-2"></i><?= session()->getFlashdata('error') ?>
    </div>
<?php endif; ?>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Profile Info Card -->
    <div class="lg:col-span-1">
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="text-center">
                <div class="w-24 h-24 mx-auto rounded-full bg-blue-100 flex items-center justify-center mb-4">
                    <i class="fas fa-user text-5xl text-blue-600"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-1"><?= $user['full_name'] ?></h3>
                <p class="text-sm text-gray-600 mb-2">@<?= $user['username'] ?></p>
                <span class="px-3 py-1 text-xs font-semibold rounded-full <?= $user['role'] == 'admin' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' ?>">
                    <?= ucfirst($user['role']) ?>
                </span>
            </div>

            <div class="mt-6 pt-6 border-t space-y-3">
                <div class="flex items-center text-sm text-gray-600">
                    <i class="fas fa-envelope w-5 mr-2"></i>
                    <span><?= $user['email'] ?></span>
                </div>
                <div class="flex items-center text-sm text-gray-600">
                    <i class="fas fa-calendar w-5 mr-2"></i>
                    <span>Bergabung: <?= date('d M Y', strtotime($user['created_at'])) ?></span>
                </div>
                <?php if ($user['last_login']): ?>
                    <div class="flex items-center text-sm text-gray-600">
                        <i class="fas fa-clock w-5 mr-2"></i>
                        <span>Login terakhir: <?= date('d M Y H:i', strtotime($user['last_login'])) ?></span>
                    </div>
                <?php endif; ?>
                <div class="flex items-center text-sm">
                    <i class="fas fa-circle w-5 mr-2 <?= $user['is_active'] ? 'text-green-500' : 'text-gray-400' ?>"></i>
                    <span class="<?= $user['is_active'] ? 'text-green-600' : 'text-gray-600' ?>">
                        <?= $user['is_active'] ? 'Aktif' : 'Non-Aktif' ?>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Profile Form -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-lg shadow-md">
            <div class="p-6 border-b">
                <h3 class="text-lg font-semibold text-gray-800">
                    <i class="fas fa-edit mr-2"></i>Edit Profile
                </h3>
            </div>
            
            <form action="<?= base_url('admin/profile') ?>" method="POST" class="p-6">
                <?= csrf_field() ?>
                
                <div class="space-y-6">
                    <!-- Username (Read Only) -->
                    <div>
                        <label for="username" class="block text-sm font-medium text-gray-700 mb-2">
                            Username
                        </label>
                        <input type="text" id="username" name="username"
                               value="<?= $user['username'] ?>"
                               readonly
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-100 cursor-not-allowed">
                        <p class="text-xs text-gray-500 mt-1">Username tidak dapat diubah</p>
                    </div>

                    <!-- Full Name -->
                    <div>
                        <label for="full_name" class="block text-sm font-medium text-gray-700 mb-2">
                            Nama Lengkap <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="full_name" name="full_name" required
                               value="<?= old('full_name', $user['full_name']) ?>"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
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
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <?php if (isset($validation) && $validation->hasError('email')): ?>
                            <p class="text-red-500 text-sm mt-1"><?= $validation->getError('email') ?></p>
                        <?php endif; ?>
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
                        <i class="fas fa-save mr-2"></i>Simpan Perubahan
                    </button>
                    <a href="<?= base_url('admin') ?>" 
                       class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                        <i class="fas fa-times mr-2"></i>Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
