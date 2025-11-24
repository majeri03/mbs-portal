<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class SchoolContentSeeder extends Seeder
{
    public function run()
    {
        $now = Time::now();

        // 1. USER ADMIN SEKOLAH
        $users = [
            [
                'username' => 'admin_mts', 'email' => 'mts@mbs.sch.id', 
                'password' => password_hash('123456', PASSWORD_DEFAULT), 'full_name' => 'Admin MTs', 
                'role' => 'admin', 'school_id' => 1, 'is_active' => 1, 'created_at' => $now
            ],
            [
                'username' => 'admin_ma', 'email' => 'ma@mbs.sch.id', 
                'password' => password_hash('123456', PASSWORD_DEFAULT), 'full_name' => 'Admin MA', 
                'role' => 'admin', 'school_id' => 2, 'is_active' => 1, 'created_at' => $now
            ],
            [
                'username' => 'admin_smk', 'email' => 'smk@mbs.sch.id', 
                'password' => password_hash('123456', PASSWORD_DEFAULT), 'full_name' => 'Admin SMK', 
                'role' => 'admin', 'school_id' => 3, 'is_active' => 1, 'created_at' => $now
            ],
        ];
        // Insert ignore agar tidak duplikat username
        $this->db->table('users')->ignore(true)->insertBatch($users);

        // 2. BERITA DUMMY (Per Sekolah)
        $posts = [
            // Berita MTs
            ['school_id' => 1, 'title' => 'MTs MBS Juara 1 Pidato Bahasa Arab Nasional', 'slug' => 'mts-juara-pidato', 'content' => 'Santri MTs kembali menorehkan prestasi...', 'thumbnail' => 'https://images.unsplash.com/photo-1585829365295-ab7cd400c167?w=600', 'is_published' => 1, 'created_at' => $now],
            ['school_id' => 1, 'title' => 'Kegiatan Mukhayyam Al-Qur\'an MTs', 'slug' => 'mukhayyam-mts', 'content' => 'Kegiatan menghafal intensif selama 3 hari...', 'thumbnail' => 'https://images.unsplash.com/photo-1609531612446-6499548b3c95?w=600', 'is_published' => 1, 'created_at' => $now],
            
            // Berita MA
            ['school_id' => 2, 'title' => 'MA MBS Lolos Seleksi Olimpiade Sains Provinsi', 'slug' => 'ma-lolos-osp', 'content' => 'Siswa MA jurusan IPA berhasil melaju...', 'thumbnail' => 'https://images.unsplash.com/photo-1564981797816-1043664bf78d?w=600', 'is_published' => 1, 'created_at' => $now],
            
            // Berita SMK
            ['school_id' => 3, 'title' => 'Kunjungan Industri SMK ke Telkom Indonesia', 'slug' => 'smk-kunjungan-telkom', 'content' => 'Siswa TKJ belajar langsung infrastruktur jaringan...', 'thumbnail' => 'https://images.unsplash.com/photo-1550751827-4bd374c3f58b?w=600', 'is_published' => 1, 'created_at' => $now],
        ];
        $this->db->table('posts')->insertBatch($posts);

        // 3. AGENDA DUMMY
        $events = [
            ['school_id' => 1, 'title' => 'Ujian Tahfidz Jus 30', 'slug' => 'ujian-tahfidz-mts', 'event_date' => date('Y-m-d', strtotime('+5 days')), 'location' => 'Masjid Kampus 1', 'created_at' => $now],
            ['school_id' => 3, 'title' => 'Uji Kompetensi Keahlian (UKK)', 'slug' => 'ukk-smk', 'event_date' => date('Y-m-d', strtotime('+10 days')), 'location' => 'Lab TKJ', 'created_at' => $now],
        ];
        $this->db->table('events')->insertBatch($events);

        // 4. SLIDER KHUSUS SEKOLAH
        $sliders = [
            ['school_id' => 1, 'title' => 'MTs MBS - Membentuk Generasi Qurani', 'image_url' => 'https://images.unsplash.com/photo-1542810634-71277d95dcbe?w=1600', 'is_active' => 1, 'created_at' => $now],
            ['school_id' => 3, 'title' => 'SMK MBS - Siap Kerja, Santun, Mandiri', 'image_url' => 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?w=1600', 'is_active' => 1, 'created_at' => $now],
        ];
        $this->db->table('sliders')->insertBatch($sliders);
        
        // 5. GURU & STAFF (Update data lama biar punya school_id)
        // Kita asumsikan update random/manual saja untuk contoh
        $this->db->query("UPDATE teachers SET school_id = 1 WHERE id = 1"); // Direktur masuk MTs (contoh)
        $this->db->query("UPDATE teachers SET school_id = 2 WHERE id = 2"); // MA
        $this->db->query("UPDATE teachers SET school_id = 3 WHERE id = 3"); // SMK
    }
}