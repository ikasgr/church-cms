<?php
$siteLogo = app_setting_asset('site_logo', 'assets/images/resources/logo-1.png');
$siteIcon = app_setting_asset('site_icon', 'assets/images/favicons/favicon-32x32.png');
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - CMS Church FLOBAMORA</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link rel="icon" type="image/png" href="<?= $siteIcon ?>">
    <link rel="apple-touch-icon" href="<?= $siteIcon ?>">

    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="<?= base_url('assets/plugins/sweetalert2/sweetalert2.min.css') ?>">
    <script src="<?= base_url('assets/plugins/sweetalert2/sweetalert2.all.min.js') ?>"></script>
</head>
<body class="bg-gradient-to-br from-blue-500 to-blue-900 min-h-screen flex items-center justify-center p-4">
    
    <div class="w-full max-w-md">
        
        <!-- Login Card -->
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
            
            <!-- Header -->
            <div class="bg-blue-900 text-white p-8 text-center">
                <div class="w-24 h-24 bg-white rounded-full mx-auto mb-4 flex items-center justify-center overflow-hidden">
                    <img src="<?= $siteLogo ?>" alt="Logo" class="max-h-full max-w-full object-contain">
                </div>
                <h1 class="text-2xl font-bold">CMS FLOBAMORA</h1>
                <p class="text-blue-200 text-sm mt-2">Admin Panel</p>
            </div>
            
            <!-- Form -->
            <div class="p-8">
                
                <?php if (session()->getFlashdata('error')): ?>
                    <script>
                        document.addEventListener('DOMContentLoaded', function () {
                            Swal.fire({
                                icon: 'error',
                                title: 'Login Gagal',
                                text: <?= json_encode(session()->getFlashdata('error')) ?>,
                                confirmButtonColor: '#EF4444'
                            });
                        });
                    </script>
                <?php endif; ?>
                
                <form method="POST" action="<?= base_url('admin/login') ?>">
                    <?= csrf_field() ?>
                    
                    <!-- Username -->
                    <div class="mb-6">
                        <label for="username" class="block text-gray-700 text-sm font-semibold mb-2">
                            <i class="fas fa-user mr-2"></i>Username
                        </label>
                        <input type="text" 
                               id="username" 
                               name="username" 
                               required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               placeholder="Masukkan username">
                    </div>
                    
                    <!-- Password -->
                    <div class="mb-6">
                        <label for="password" class="block text-gray-700 text-sm font-semibold mb-2">
                            <i class="fas fa-lock mr-2"></i>Password
                        </label>
                        <input type="password" 
                               id="password" 
                               name="password" 
                               required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               placeholder="Masukkan password">
                    </div>
                    
                    <!-- Submit Button -->
                    <button type="submit" 
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-4 rounded-lg transition duration-200 flex items-center justify-center">
                        <i class="fas fa-sign-in-alt mr-2"></i>
                        Login
                    </button>
                    
                </form>
                
                <!-- Footer Links -->
                <div class="mt-6 text-center">
                    <a href="<?= base_url('/') ?>" class="text-sm text-blue-600 hover:text-blue-800">
                        <i class="fas fa-arrow-left mr-1"></i>
                        Kembali ke Website
                    </a>
                </div>
                
            </div>
            
        </div>
        
        <!-- Copyright -->
        <div class="text-center mt-6 text-white text-sm">
            &copy; <?= date('Y') ?> CMS Church FLOBAMORA. All rights reserved.
        </div>
        
    </div>
    
</body>
</html>
