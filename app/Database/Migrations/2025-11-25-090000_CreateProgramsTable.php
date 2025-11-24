<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateProgramsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'school_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true, // Null = Program Yayasan/Pusat, Isi = Program Sekolah
            ],
            'title' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'description' => [ // Deskripsi singkat untuk di kartu
                'type' => 'TEXT',
                'null' => true,
            ],
            'icon' => [ // Menyimpan class icon (misal: bi-book-half)
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'default'    => 'bi-bookmarks-fill',
            ],
            'order_position' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 0,
            ],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        // Relasi ke tabel schools (Jika sekolah dihapus, program ikut terhapus)
        $this->forge->addForeignKey('school_id', 'schools', 'id', 'CASCADE', 'CASCADE');
        
        $this->forge->createTable('programs');
    }

    public function down()
    {
        $this->forge->dropTable('programs');
    }
}