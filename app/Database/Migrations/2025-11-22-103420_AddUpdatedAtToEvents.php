<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddUpdatedAtToEvents extends Migration
{
    public function up()
    {
        // Menambahkan kolom updated_at ke tabel events
        $this->forge->addColumn('events', [
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
                'after' => 'created_at', // Posisi setelah created_at
            ],
        ]);
    }

    public function down()
    {
        // Menghapus kolom jika rollback
        $this->forge->dropColumn('events', 'updated_at');
    }
}