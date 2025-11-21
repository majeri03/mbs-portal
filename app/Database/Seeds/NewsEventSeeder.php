<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class NewsEventSeeder extends Seeder
{
    public function run()
    {
        $now = Time::now();

        // 1. DATA BERITA (POSTS)
        $posts = [
            [
                'school_id' => null, // Berita Umum
                'title'     => 'MBS Gelar Wisuda Akbar Angkatan ke-10',
                'slug'      => 'mbs-gelar-wisuda-akbar-10',
                'content'   => 'Sebanyak 500 santri diwisuda hari ini...',
                'thumbnail' => 'https://images.unsplash.com/photo-1523580494863-6f3031224c94?w=600&q=80',
                'created_at'=> $now,
            ],
            [
                'school_id' => 1, // MTs
                'title'     => 'Santri MTs Juara 1 Tahfidz Tingkat Provinsi',
                'slug'      => 'santri-mts-juara-tahfidz',
                'content'   => 'Alhamdulillah santri kami memenangkan lomba...',
                'thumbnail' => 'https://images.unsplash.com/photo-1585829365295-ab7cd400c167?w=600&q=80',
                'created_at'=> $now,
            ],
            [
                'school_id' => 3, // SMK
                'title'     => 'Kunjungan Industri SMK MBS ke Jakarta',
                'slug'      => 'kunjungan-industri-smk',
                'content'   => 'Siswa SMK jurusan TKJ melakukan kunjungan...',
                'thumbnail' => 'https://images.unsplash.com/photo-1531482615713-2afd69097998?w=600&q=80',
                'created_at'=> $now,
            ],
        ];
        $this->db->table('posts')->insertBatch($posts);

        // 2. DATA AGENDA (EVENTS)
        $events = [
            [
                'school_id' => null,
                'title'     => 'Pengajian Ahad Pagi',
                'slug'      => 'pengajian-ahad-pagi',
                'event_date'=> date('Y-m-d', strtotime('+2 days')), // 2 hari lagi
                'time_start'=> '07:00:00',
                'location'  => 'Masjid Kampus 1'
            ],
            [
                'school_id' => 2, // MA
                'title'     => 'Ujian Tengah Semester MA',
                'slug'      => 'uts-ma',
                'event_date'=> date('Y-m-d', strtotime('+1 week')), // 1 minggu lagi
                'time_start'=> '07:30:00',
                'location'  => 'Gedung MA Lt. 2'
            ]
        ];
        $this->db->table('events')->insertBatch($events);
    }
}