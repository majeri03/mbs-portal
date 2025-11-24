<?php
namespace App\Database\Seeds;
use CodeIgniter\Database\Seeder;

class MtsPageSeeder extends Seeder {
    public function run() {
        $data = [
            'school_id' => 1, // Khusus MTs
            'title'     => 'Tentang MTs MBS',
            'slug'      => 'tentang-mts',
            'content'   => '<p><strong>MTs MBS</strong> adalah lembaga pendidikan tingkat menengah pertama yang memadukan kurikulum nasional dengan nilai-nilai kepesantrenan. Kami berkomitmen mencetak santri yang tidak hanya cerdas secara intelektual, tetapi juga matang secara spiritual.</p><ul><li>Akreditasi A (Unggul)</li><li>Tenaga pengajar lulusan Timur Tengah & Universitas Negeri</li></ul>',
            'is_active' => 1,
            'is_featured' => 1, // INI KUNCINYA: Angka 1 artinya TAMPIL DI DEPAN
            'created_at' => date('Y-m-d H:i:s')
        ];
        $this->db->table('pages')->insert($data);
    }
}