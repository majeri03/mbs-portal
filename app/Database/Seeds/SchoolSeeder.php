<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SchoolSeeder extends Seeder
{
    public function run()
    {
        // Data Sekolah Utama
        $data = [
            'id'                   => 1, // Penting di-hardcode ID 1 agar relasi tidak putus
            'name'                 => 'MA MBS',
            'slug'                 => 'MA',
            'description'          => 'Madrasah Tsanawiyah Unggulan Berbasis Pesantren & Sains. Mencetak kader ulama intelek yang siap bersaing di kancah global.',
            'accreditation_status' => 'A',
            'order_position'       => 1,
            'created_at'           => date('Y-m-d H:i:s'),
            'updated_at'           => date('Y-m-d H:i:s'),
        ];

        // Cek dulu biar gak duplicate error
        if ($this->db->table('schools')->where('id', 1)->countAllResults() == 0) {
            $this->db->table('schools')->insert($data);
        } else {
            $this->db->table('schools')->where('id', 1)->update($data);
        }
    }
}