<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class FinalContentSeeder extends Seeder
{
    public function run()
    {
        $this->db->disableForeignKeyChecks();
        
        // BERSIHKAN DATA LAMA (Agar tidak duplikat/berantakan)
        $this->db->table('settings')->truncate();
        $this->db->table('sliders')->truncate();
        $this->db->table('announcements')->truncate();
        $this->db->table('posts')->truncate();
        $this->db->table('events')->truncate();
        $this->db->table('teachers')->truncate();
        $this->db->table('galleries')->truncate();
        $this->db->table('pages')->truncate();
        $this->db->table('programs')->truncate();
        
        $this->db->enableForeignKeyChecks();
        $now = Time::now();

        // =====================================================================
        // 1. UPDATE DATA SEKOLAH (ID 1 = MTs -> Kita poles deskripsinya)
        // =====================================================================
        $this->db->table('schools')->where('id', 1)->update([
            'name' => 'MTs MBS', // Tetap pakai nama MTs agar sesuai header
            'slug' => 'mts',
            // Deskripsi kita buat keren (seolah-olah MA)
            'description' => 'Madrasah Tsanawiyah Unggulan Berbasis Pesantren & Sains. Mencetak kader ulama intelek yang siap bersaing di kancah global.',
            'accreditation_status' => 'A', 
            'order_position' => 1
        ]);

        // =====================================================================
        // 2. USER LOGIN (Admin MTs & Superadmin)
        // =====================================================================
        $users = [
            [
                'username' => 'admin', 'email' => 'admin@mbs.sch.id',
                'password' => password_hash('123456', PASSWORD_DEFAULT),
                'full_name' => 'Administrator Pusat', 'role' => 'superadmin', 'school_id' => null,
                'is_active' => 1, 'created_at' => $now
            ],
            [
                'username' => 'admin_mts', 'email' => 'mts@mbs.sch.id',
                'password' => password_hash('123456', PASSWORD_DEFAULT),
                'full_name' => 'Admin Sekolah', 'role' => 'admin', 'school_id' => 1, // ID 1
                'is_active' => 1, 'created_at' => $now
            ],
        ];
        $this->db->table('users')->ignore(true)->insertBatch($users);

        // =====================================================================
        // 3. PENGATURAN (SETTINGS)
        // =====================================================================
        $settings = [
            // --- PENGATURAN PUSAT (MBS) ---
            ['school_id' => null, 'setting_key' => 'site_name', 'setting_value' => 'MBS Boarding School', 'setting_group' => 'general'],
            ['school_id' => null, 'setting_key' => 'site_desc', 'setting_value' => 'Pusat Pendidikan Islam Terpadu Membentuk Generasi Qurani Berkemajuan.', 'setting_group' => 'general'],
            ['school_id' => null, 'setting_key' => 'phone', 'setting_value' => '(0274) 123456', 'setting_group' => 'contact'],
            ['school_id' => null, 'setting_key' => 'email', 'setting_value' => 'sekretariat@mbs.sch.id', 'setting_group' => 'contact'],
            ['school_id' => null, 'setting_key' => 'address', 'setting_value' => 'Jl. KH. Ahmad Dahlan, Kampus 1 MBS, Yogyakarta', 'setting_group' => 'contact'],
            ['school_id' => null, 'setting_key' => 'facebook_url', 'setting_value' => 'https://facebook.com/mbspusat', 'setting_group' => 'social'],
            ['school_id' => null, 'setting_key' => 'instagram_url', 'setting_value' => 'https://instagram.com/mbspusat', 'setting_group' => 'social'],
            ['school_id' => null, 'setting_key' => 'youtube_url', 'setting_value' => 'https://youtube.com/mbspusat', 'setting_group' => 'social'],

            // --- PENGATURAN SEKOLAH (ID 1) - ISINYA KITA BUAT KEREN ALA MA ---
            ['school_id' => 1, 'setting_key' => 'site_name', 'setting_value' => 'MTs MBS Unggulan', 'setting_group' => 'general'],
            ['school_id' => 1, 'setting_key' => 'site_desc', 'setting_value' => 'Sekolah Kader Ulama & Saintis Muda.', 'setting_group' => 'general'],
            ['school_id' => 1, 'setting_key' => 'phone', 'setting_value' => '0812-3456-7890', 'setting_group' => 'contact'],
            ['school_id' => 1, 'setting_key' => 'email', 'setting_value' => 'akademik@mbs.sch.id', 'setting_group' => 'contact'],
            ['school_id' => 1, 'setting_key' => 'address', 'setting_value' => 'Gedung Buya Hamka Lt. 2, Komp. MBS', 'setting_group' => 'contact'],
            ['school_id' => 1, 'setting_key' => 'instagram_url', 'setting_value' => 'https://instagram.com/mts.mbs', 'setting_group' => 'social'],
            ['school_id' => 1, 'setting_key' => 'tiktok_url', 'setting_value' => 'https://tiktok.com/@mts.mbs', 'setting_group' => 'social'],
        ];
        
        foreach ($settings as $s) {
            $s['created_at'] = $now;
            $this->db->table('settings')->insert($s);
        }

        // =====================================================================
        // 4. SLIDER (HERO IMAGE)
        // =====================================================================
        $sliders = [
            // PUSAT
            [
                'school_id' => null, 'title' => 'Selamat Datang di MBS', 
                'description' => 'Lembaga Pendidikan Islam Modern Berkemajuan.',
                'image_url' => 'https://images.unsplash.com/photo-1564981797816-1043664bf78d?w=1600&q=80',
                'button_text' => 'Profil Kami', 'button_link' => '#profil', 'is_active' => 1, 'created_at' => $now, 'order_position' => 1
            ],
            
            // SEKOLAH (ID 1) - Konten Premium
            [
                'school_id' => 1, 'title' => 'Mencetak Generasi Emas 2045', 
                'description' => 'Kurikulum terintegrasi (Agama & Sains) siap mengantarkan santri menembus Olimpiade Nasional.',
                'image_url' => 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?w=1600&q=80', 
                'button_text' => 'Lihat Program', 'button_link' => '#program', 'is_active' => 1, 'created_at' => $now, 'order_position' => 1
            ],
            [
                'school_id' => 1, 'title' => 'Fasilitas Laboratorium Lengkap', 
                'description' => 'Menunjang pembelajaran sains dan teknologi modern berbasis praktikum.',
                'image_url' => 'https://images.unsplash.com/photo-1532094349884-543bc11b234d?w=1600&q=80', 
                'button_text' => null, 'button_link' => null, 'is_active' => 1, 'created_at' => $now, 'order_position' => 2
            ],
        ];
        $this->db->table('sliders')->insertBatch($sliders);

        // =====================================================================
        // 5. PENGUMUMAN (ANNOUNCEMENTS) - Bubble Chat
        // =====================================================================
        $announcements = [
            [
                'school_id' => 1, 'title' => 'Try Out Ujian Nasional', 
                'content' => 'Wajib diikuti seluruh santri kelas akhir. Jadwal terlampir di papan pengumuman.',
                'category' => 'urgent', 'icon' => 'bi-pencil-square',
                'start_date' => date('Y-m-d'), 'end_date' => date('Y-m-d', strtotime('+7 days')), 
                'is_active' => 1, 'priority' => 1, 'created_at' => $now
            ],
            [
                'school_id' => 1, 'title' => 'Kajian Kitab Kuning', 
                'content' => 'Diadakan setiap bada Maghrib di Masjid Kampus 2 khusus santri putra.',
                'category' => 'normal', 'icon' => 'bi-book-half',
                'start_date' => date('Y-m-d'), 'end_date' => date('Y-m-d', strtotime('+1 year')), 
                'is_active' => 1, 'priority' => 2, 'created_at' => $now
            ],
        ];
        $this->db->table('announcements')->insertBatch($announcements);

        // =====================================================================
        // 6. BERITA (POSTS) - Konten Prestasi MA (Dimasukkan ke ID 1)
        // =====================================================================
        $posts = [
            [
                'school_id' => 1, 
                'title' => 'Tim Robotik MBS Raih Gold Medal di Kompetisi Jepang', 
                'slug' => 'tim-robotik-juara-jepang',
                'content' => '<p>Alhamdulillah, prestasi membanggakan kembali ditorehkan. Tim Robotik berhasil menyisihkan 50 negara dalam ajang World Robotic Olympiad di Tokyo. Inovasi robot pemilah sampah otomatis karya santri mendapatkan apresiasi tinggi dari dewan juri...</p>',
                'thumbnail' => 'https://images.unsplash.com/photo-1581092921461-eab6245b0987?w=800&q=80',
                'author' => 'Humas MBS', 'is_published' => 1, 'created_at' => $now, 'views' => 342
            ],
            [
                'school_id' => 1, 
                'title' => 'Studi Banding ke Universitas Al-Azhar Kairo', 
                'slug' => 'studi-banding-kairo',
                'content' => '<p>Sebanyak 20 santri kelas akhir mengikuti program rihlah ilmiah ke Mesir untuk mengenal dunia perkuliahan timur tengah. Kegiatan ini bertujuan memotivasi santri untuk melanjutkan studi ke jenjang yang lebih tinggi di universitas islam tertua di dunia...</p>',
                'thumbnail' => 'https://images.unsplash.com/photo-1565058126570-3a769307f723?w=800&q=80',
                'author' => 'Admin Sekolah', 'is_published' => 1, 'created_at' => $now, 'views' => 120
            ],
            [
                'school_id' => 1, 
                'title' => 'Pelantikan IPM Ranting MBS Periode 2025/2026', 
                'slug' => 'pelantikan-ipm',
                'content' => '<p>Estafet kepemimpinan terus berlanjut. Selamat kepada pengurus baru Ikatan Pelajar Muhammadiyah (IPM) yang telah dilantik. Semoga amanah dalam menjalankan tugas dan membawa organisasi semakin berkemajuan...</p>',
                'thumbnail' => 'https://images.unsplash.com/photo-1529070538774-1843cb3265df?w=800&q=80',
                'author' => 'Kesiswaan', 'is_published' => 1, 'created_at' => $now, 'views' => 85
            ],
        ];
        $this->db->table('posts')->insertBatch($posts);

        // =====================================================================
        // 7. AGENDA (EVENTS)
        // =====================================================================
        $events = [
            [
                'school_id' => 1, 'title' => 'Ujian Praktik Seni Budaya', 'slug' => 'ujian-seni',
                'event_date' => date('Y-m-d', strtotime('+3 days')), 'time_start' => '08:00:00', 'location' => 'Aula Utama',
                'description' => 'Menampilkan karya seni santri kelas akhir sebagai syarat kelulusan.', 'created_at' => $now
            ],
            [
                'school_id' => 1, 'title' => 'Munaqosah Tahfidz Al-Quran', 'slug' => 'munaqosah-tahfidz',
                'event_date' => date('Y-m-d', strtotime('+10 days')), 'time_start' => '07:00:00', 'location' => 'Masjid Kampus 1',
                'description' => 'Ujian hafalan terbuka disaksikan orang tua/wali santri.', 'created_at' => $now
            ],
        ];
        $this->db->table('events')->insertBatch($events);

        // =====================================================================
        // 8. PIMPINAN & GURU
        // =====================================================================
        $teachers = [
            // Kepala Sekolah (Leader)
            ['school_id' => 1, 'name' => 'Ust. Fulan S.Pd.I', 'position' => 'Kepala Sekolah', 'photo' => 'https://ui-avatars.com/api/?name=Fulan&background=582C83&color=fff&size=256', 'is_leader' => 1, 'order_position' => 1, 'created_at' => $now],
            // Guru Lain
            ['school_id' => 1, 'name' => 'Ust. Ahmad M.Sc', 'position' => 'Waka Kurikulum', 'photo' => 'https://ui-avatars.com/api/?name=Ahmad&background=random', 'is_leader' => 0, 'order_position' => 2, 'created_at' => $now],
            ['school_id' => 1, 'name' => 'Usth. Siti S.Hum', 'position' => 'Guru B. Arab', 'photo' => 'https://ui-avatars.com/api/?name=Siti&background=random', 'is_leader' => 0, 'order_position' => 3, 'created_at' => $now],
            ['school_id' => 1, 'name' => 'Ust. Budi S.Si', 'position' => 'Guru Fisika', 'photo' => 'https://ui-avatars.com/api/?name=Budi&background=random', 'is_leader' => 0, 'order_position' => 4, 'created_at' => $now],
        ];
        $this->db->table('teachers')->insertBatch($teachers);

        // =====================================================================
        // 9. HALAMAN STATIS (FEATURED)
        // =====================================================================
        $pages = [
            [
                'school_id' => 1, 
                'title' => 'Profil Singkat Sekolah',
                'slug' => 'profil-sekolah',
                'content' => '<p>MBS adalah satuan pendidikan jenjang menengah yang memadukan kurikulum Kemenag (Jurusan IPA, IPS, Keagamaan) dengan kurikulum kepesantrenan (Tahfidz, Bahasa Arab, Kitab Kuning).</p><p>Kami memiliki visi terwujudnya kader ulama yang intelek dan intelek yang ulama. Dengan sistem boarding school (asrama), kami memantau perkembangan karakter santri selama 24 jam penuh.</p>',
                'is_active' => 1,
                'is_featured' => 1, // TAMPIL DI LANDING PAGE
                'created_at' => $now
            ]
        ];
        $this->db->table('pages')->insertBatch($pages);

        // =====================================================================
        // 10. PROGRAM UNGGULAN
        // =====================================================================
        $programs = [
            ['school_id' => 1, 'title' => 'Tahfidz 30 Juz', 'description' => 'Program intensif menghafal Al-Quran bersanad dalam 3 tahun.', 'icon' => 'bi-book-half', 'order_position' => 1, 'created_at' => $now],
            ['school_id' => 1, 'title' => 'Kelas Internasional', 'description' => 'Persiapan studi lanjut ke Timur Tengah (Mesir, Madinah, Turki).', 'icon' => 'bi-globe', 'order_position' => 2, 'created_at' => $now],
            ['school_id' => 1, 'title' => 'Riset & Sains', 'description' => 'Pengembangan minat bakat bidang olimpiade dan penelitian ilmiah remaja.', 'icon' => 'bi-microscope', 'order_position' => 3, 'created_at' => $now],
        ];
        $this->db->table('programs')->insertBatch($programs);

        // =====================================================================
        // 11. GALERI
        // =====================================================================
        $galleries = [
            ['school_id' => 1, 'title' => 'Wisuda Purna Siswa', 'category' => 'kegiatan', 'image_url' => 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=600', 'created_at' => $now],
            ['school_id' => 1, 'title' => 'Praktikum Kimia', 'category' => 'fasilitas', 'image_url' => 'https://images.unsplash.com/photo-1532094349884-543bc11b234d?w=600', 'created_at' => $now],
            ['school_id' => 1, 'title' => 'Asrama Putra', 'category' => 'asrama', 'image_url' => 'https://images.unsplash.com/photo-1555854877-bab0e564b8d5?w=600', 'created_at' => $now],
            ['school_id' => 1, 'title' => 'Juara 1 Futsal', 'category' => 'prestasi', 'image_url' => 'https://images.unsplash.com/photo-1518609878373-06d740f60d8b?w=600', 'created_at' => $now],
        ];
        $this->db->table('galleries')->insertBatch($galleries);
    }
}