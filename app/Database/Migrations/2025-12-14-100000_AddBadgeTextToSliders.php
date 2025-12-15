<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddBadgeTextToSliders extends Migration
{
    public function up()
    {
        // Tambah kolom badge_text setelah kolom school_id
        $fields = [
            'badge_text' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
                'after'      => 'school_id',
            ],
        ];
        
        $this->forge->addColumn('sliders', $fields);
    }

    public function down()
    {
        // Hapus kolom badge_text jika rollback
        $this->forge->dropColumn('sliders', 'badge_text');
    }
}