<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class InitialDataSeeder extends Seeder
{
    public function run()
    {
        $now = Time::now();

        // 1. SEED SCHOOLS
        $schools = [
            [
                'name' => 'MTs MBS',
                'slug' => 'mts',
                'description' => 'Madrasah Tsanawiyah Berbasis Pesantren',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'MA MBS',
                'slug' => 'ma',
                'description' => 'Madrasah Aliyah Program IPA, IPS, Keagamaan',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'SMK MBS',
                'slug' => 'smk',
                'description' => 'Sekolah Menengah Kejuruan Pusat Keunggulan',
                'created_at' => $now,
                'updated_at' => $now
            ]
        ];
        $this->db->table('schools')->insertBatch($schools);

        // 2. SEED SETTINGS (Footer & Identitas)
        $settings = [
            ['setting_key' => 'site_name', 'setting_value' => 'MBS Boarding School', 'setting_group' => 'general'],
            ['setting_key' => 'site_desc', 'setting_value' => 'Membangun Generasi Qurani Berkemajuan', 'setting_group' => 'general'],
            ['setting_key' => 'address', 'setting_value' => 'Jl. KH. Ahmad Dahlan No. 123, Yogyakarta', 'setting_group' => 'contact'],
            ['setting_key' => 'phone', 'setting_value' => '+62 812 3456 7890', 'setting_group' => 'contact'],
            ['setting_key' => 'email', 'setting_value' => 'info@mbs.sch.id', 'setting_group' => 'contact'],
            ['setting_key' => 'facebook_url', 'setting_value' => 'https://facebook.com/mbs', 'setting_group' => 'social'],
            ['setting_key' => 'instagram_url', 'setting_value' => 'https://instagram.com/mbs', 'setting_group' => 'social'],
            ['setting_key' => 'youtube_url', 'setting_value' => 'https://youtube.com/mbs', 'setting_group' => 'social'],
        ];
        
        // Loop insert (karena insertBatch kadang strict di key unique)
        foreach ($settings as $data) {
             // Menambahkan created_at manual
             $data['created_at'] = $now->toDateTimeString();
             $data['updated_at'] = $now->toDateTimeString();
             $this->db->table('settings')->ignore(true)->insert($data);
        }

        // 3. SEED ANNOUNCEMENT (Contoh)
        $this->db->table('announcements')->insert([
            'content' => 'Penerimaan Santri Baru Gelombang 1 Telah Dibuka!',
            'is_active' => 1,
            'start_date' => date('Y-m-d'),
            'created_at' => $now
        ]);
    }
}