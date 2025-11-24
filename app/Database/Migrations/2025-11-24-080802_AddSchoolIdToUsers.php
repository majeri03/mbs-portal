<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddSchoolIdToUsers extends Migration
{
    public function up()
    {
        $this->forge->addColumn('users', [
            'school_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true, // NULL = Superadmin / Pusat
                'after'      => 'role',
                'comment'    => 'NULL jika Superadmin, Isi ID Sekolah jika Admin Sekolah'
            ]
        ]);
        
        // Tambah Foreign Key
        $this->forge->addForeignKey('school_id', 'schools', 'id', 'CASCADE', 'SET NULL', 'fk_users_school');
    }

    public function down()
    {
        $this->forge->dropForeignKey('users', 'fk_users_school');
        $this->forge->dropColumn('users', 'school_id');
    }
}