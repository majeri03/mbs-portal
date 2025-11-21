<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class GallerySeeder extends Seeder
{
    public function run()
    {
        $now = Time::now();
        $data = [
            ['title' => 'Sholat Berjamaah', 'category' => 'ibadah', 'image_url' => 'https://images.unsplash.com/photo-1564121211835-e88c852648ab?w=600&q=80'],
            ['title' => 'Praktikum Lab IPA', 'category' => 'akademik', 'image_url' => 'https://images.unsplash.com/photo-1532094349884-543bc11b234d?w=600&q=80'],
            ['title' => 'Ekskul Panahan', 'category' => 'ekskul', 'image_url' => 'https://images.unsplash.com/photo-1511376777868-611b54f68947?w=600&q=80'],
            ['title' => 'Kajian Kitab Kuning', 'category' => 'pesantren', 'image_url' => 'https://images.unsplash.com/photo-1584818340275-b1f1981d4747?w=600&q=80'],
            ['title' => 'Lomba Pidato Bahasa Arab', 'category' => 'bahasa', 'image_url' => 'https://images.unsplash.com/photo-1524178232363-1fb2b075b655?w=600&q=80'],
            ['title' => 'Wisuda Tahfidz', 'category' => 'prestasi', 'image_url' => 'https://images.unsplash.com/photo-1627556704290-2b1f5853ff78?w=600&q=80'],
            ['title' => 'Outbound Santri', 'category' => 'kegiatan', 'image_url' => 'https://images.unsplash.com/photo-1472653431158-6364773b27a0?w=600&q=80'],
            ['title' => 'Makan Bersama (Talam)', 'category' => 'asrama', 'image_url' => 'https://images.unsplash.com/photo-1567306226416-28f0efdc88ce?w=600&q=80'],
        ];

        foreach ($data as &$row) {
            $row['created_at'] = $now->toDateTimeString();
        }

        $this->db->table('galleries')->insertBatch($data);
    }
}