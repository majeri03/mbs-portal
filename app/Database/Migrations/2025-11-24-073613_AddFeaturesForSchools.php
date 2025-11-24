<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddFeaturesForSchools extends Migration
{
    public function up()
    {
        // 1. Update Tabel Teachers
        // Cek dulu apakah kolom sudah ada (untuk safety), tapi karena kita reset DB, ini pasti aman.
        $this->forge->addColumn('teachers', [
            'school_id' => [
                'type'       => 'INT', 
                'constraint' => 11, 
                'unsigned'   => true, // Wajib Unsigned
                'null'       => true, 
                'after'      => 'id'
            ],
            'social_links' => [
                'type'       => 'TEXT', 
                'null'       => true,
                'after'      => 'photo'
            ]
        ]);

        // Terapkan FK untuk Teachers SEKARANG
        $this->forge->addForeignKey('school_id', 'schools', 'id', 'CASCADE', 'SET NULL', 'fk_teachers_school');
        $this->forge->processIndexes('teachers'); 

        // 2. Buat Tabel Curriculums
        $this->forge->addField([
            'id' => [
                'type'           => 'INT', 
                'constraint'     => 11, 
                'unsigned'       => true, 
                'auto_increment' => true
            ],
            'school_id' => [
                'type'       => 'INT', 
                'constraint' => 11, 
                'unsigned'   => true, // Wajib Unsigned
                'null'       => true
            ],
            'title' => [
                'type'       => 'VARCHAR', 
                'constraint' => 255
            ],
            'file_url' => [
                'type'       => 'VARCHAR', 
                'constraint' => 255
            ],
            'content' => [
                'type' => 'TEXT', 
                'null' => true
            ],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('school_id', 'schools', 'id', 'CASCADE', 'CASCADE', 'fk_curriculums_school');
        $this->forge->createTable('curriculums');
    }

    public function down()
    {
        $this->forge->dropTable('curriculums');
        $this->forge->dropForeignKey('teachers', 'fk_teachers_school');
        $this->forge->dropColumn('teachers', ['school_id', 'social_links']);
    }
}