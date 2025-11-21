<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class LeaderSeeder extends Seeder
{
    public function run()
    {
        $now = Time::now();
        $data = [
            [
                'name' => 'Drs. K.H Mardan',
                'position' => 'Mudir / Direktur',
                'photo' => 'https://ui-avatars.com/api/?name=Mardan&background=582C83&color=fff&size=512', // Placeholder
                'is_leader' => 1,
                'order_position' => 1,
                'created_at' => $now
            ],
            [
                'name' => 'Nasruddin S.Pd',
                'position' => 'Wakil Direktur', // DULU: Wakil Direktur & Ka. SMA (SMA Dihapus)
                'photo' => 'https://ui-avatars.com/api/?name=Nasruddin&background=7A4E9F&color=fff&size=512',
                'is_leader' => 1,
                'order_position' => 2,
                'created_at' => $now
            ],
            [
                'name' => 'Drs. H. Hasbudi',
                'position' => 'Sekertaris & Ka. MTs',
                'photo' => 'https://ui-avatars.com/api/?name=Hasbudi&background=7A4E9F&color=fff&size=512',
                'is_leader' => 1,
                'order_position' => 3,
                'created_at' => $now
            ],
            [
                'name' => 'Nurhidana, S.Pd.I',
                'position' => 'Kepala MA',
                'photo' => 'https://ui-avatars.com/api/?name=Nurhidana&background=7A4E9F&color=fff&size=512',
                'is_leader' => 1,
                'order_position' => 4,
                'created_at' => $now
            ],
        ];

        $this->db->table('teachers')->insertBatch($data);
    }
}