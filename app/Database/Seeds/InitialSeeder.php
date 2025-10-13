<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class InitialSeeder extends Seeder
{
    public function run()
    {
        // Seed Users - Admin Default
        $this->db->table('users')->insert([
            'username'   => 'admin',
            'email'      => 'admin@churchflobamora.com',
            'password'   => password_hash('admin123', PASSWORD_DEFAULT),
            'full_name'  => 'Administrator',
            'role'       => 'superadmin',
            'is_active'  => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        // Seed Church Profile
        $this->db->table('church_profile')->insert([
            'church_name' => 'GMIT FLOBAMORA',
            'tagline'     => 'Gereja yang Melayani dengan Kasih',
            'address'     => 'Jl. Contoh No. 123, Kota',
            'phone'       => '0812-3456-7890',
            'email'       => 'info@churchflobamora.com',
            'website'     => 'https://churchflobamora.com',
            'vision'      => 'Menjadi gereja yang membawa terang Kristus bagi semua orang',
            'mission'     => 'Melayani dengan kasih, mengajar dengan kebenaran, dan hidup dalam persekutuan',
            'created_at'  => date('Y-m-d H:i:s'),
            'updated_at'  => date('Y-m-d H:i:s'),
        ]);

        // Seed Settings
        $settings = [
            ['setting_key' => 'site_name', 'setting_value' => 'CMS CHURCH FLOBAMORA', 'setting_group' => 'general'],
            ['setting_key' => 'site_description', 'setting_value' => 'Sistem Manajemen Gereja', 'setting_group' => 'general'],
            ['setting_key' => 'timezone', 'setting_value' => 'Asia/Jakarta', 'setting_group' => 'general'],
            ['setting_key' => 'date_format', 'setting_value' => 'd-m-Y', 'setting_group' => 'general'],
            ['setting_key' => 'time_format', 'setting_value' => 'H:i', 'setting_group' => 'general'],
            ['setting_key' => 'items_per_page', 'setting_value' => '10', 'setting_group' => 'general'],
            ['setting_key' => 'theme_color', 'setting_value' => 'blue', 'setting_group' => 'appearance'],
            ['setting_key' => 'enable_registration', 'setting_value' => '1', 'setting_group' => 'features'],
            ['setting_key' => 'enable_guestbook', 'setting_value' => '1', 'setting_group' => 'features'],
            ['setting_key' => 'enable_feedback', 'setting_value' => '1', 'setting_group' => 'features'],
        ];

        foreach ($settings as $setting) {
            $setting['created_at'] = date('Y-m-d H:i:s');
            $setting['updated_at'] = date('Y-m-d H:i:s');
            $this->db->table('settings')->insert($setting);
        }
    }
}
