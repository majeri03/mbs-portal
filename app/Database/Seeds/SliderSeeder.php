<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class SliderSeeder extends Seeder
{
    public function run()
    {
        $now = Time::now();
        
        $data = [
            [
                'title'          => 'Membangun Generasi Qur\'ani Berkemajuan',
                'description'    => 'Lembaga pendidikan Islam modern yang mengintegrasikan kurikulum nasional, kepesantrenan, dan pengembangan karakter untuk masa depan gemilang.',
                'image_url'      => 'https://images.unsplash.com/photo-1541339907198-e08756dedf3f?q=80&w=1600',
                'button_text'    => 'Jelajahi Kami',
                'button_link'    => '#jenjang-sekolah',
                'order_position' => 1,
                'is_active'      => 1,
                'created_at'     => $now,
            ],
            [
                'title'          => 'Pendaftaran Santri Baru 2025/2026',
                'description'    => 'Bergabunglah bersama ribuan santri MBS dalam menimba ilmu agama dan sains. Kuota terbatas!',
                'image_url'      => 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?q=80&w=1600',
                'button_text'    => 'Daftar Sekarang',
                'button_link'    => '/ppdb',
                'order_position' => 2,
                'is_active'      => 1,
                'created_at'     => $now,
            ],
        ];

        $this->db->table('sliders')->insertBatch($data);
    }
}