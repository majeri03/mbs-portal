<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddUpdatedAtToGalleries extends Migration
{
    public function up()
    {
        // Menambahkan kolom updated_at ke tabel galleries
        $this->forge->addColumn('galleries', [
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
                'after' => 'created_at', // Letakkan setelah created_at
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('galleries', 'updated_at');
    }
}