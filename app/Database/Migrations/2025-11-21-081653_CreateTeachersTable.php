<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTeachersTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'             => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'name'           => ['type' => 'VARCHAR', 'constraint' => 100],
            'position'       => ['type' => 'VARCHAR', 'constraint' => 100], // Jabatan: Mudir, Kepala MA, dll
            'photo'          => ['type' => 'VARCHAR', 'constraint' => 255, 'default' => 'default_avatar.jpg'],
            'is_leader'      => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0], // 1 = Petinggi/Wajah MBS
            'order_position' => ['type' => 'INT', 'constraint' => 11, 'default' => 99], // Urutan tampil
            'created_at'     => ['type' => 'DATETIME', 'null' => true],
            'updated_at'     => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('teachers');
    }

    public function down()
    {
        $this->forge->dropTable('teachers');
    }
}