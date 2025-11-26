<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddSchoolIdToSettings extends Migration
{
    public function up()
    {
        // Tambahkan kolom school_id agar setting tidak tertukar antar sekolah
        $this->forge->addColumn('settings', [
            'school_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true, // Null = Settingan Pusat
                'after'      => 'id',
            ]
        ]);
        
        $this->forge->addForeignKey('school_id', 'schools', 'id', 'CASCADE', 'CASCADE');
        
        // Hapus unique key lama (setting_key) karena sekarang key yang sama boleh ada beda sekolah
        $this->db->query('ALTER TABLE settings DROP INDEX setting_key');
        // Buat unique key baru kombinasi (school_id + setting_key)
        // $this->db->query('ALTER TABLE settings ADD UNIQUE KEY unique_setting (school_id, setting_key)');
    }

    public function down()
    {
        $this->forge->dropColumn('settings', 'school_id');
    }
}