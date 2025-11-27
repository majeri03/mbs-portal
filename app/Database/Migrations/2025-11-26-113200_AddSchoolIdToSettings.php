<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddSchoolIdToSettings extends Migration
{
    public function up()
    {
        // 1. Beri tahu editor bahwa ini adalah BaseConnection (agar garis merah hilang)
        /** @var \CodeIgniter\Database\BaseConnection $db */
        $db = $this->db;

        // 2. Ambil daftar kolom menggunakan variabel $db lokal tadi
        $fields = $db->getFieldNames('settings');

        // 3. Cek jika 'school_id' belum ada
        if (! in_array('school_id', $fields)) {
            
            $this->forge->addColumn('settings', [
                'school_id' => [
                    'type'       => 'INT',
                    'constraint' => 11,
                    'unsigned'   => true,
                    'null'       => true,
                    'after'      => 'id',
                ]
            ]);
            
            $this->forge->addForeignKey('school_id', 'schools', 'id', 'CASCADE', 'CASCADE');
            
            try {
                // Hapus index lama jika ada (biar tidak error duplicate key)
                $db->query('ALTER TABLE settings DROP INDEX setting_key');
            } catch (\Throwable $e) {
                // Skip jika index sudah tidak ada
            }
        }
    }
    public function down()
    {
        $this->forge->dropColumn('settings', 'school_id');
    }
}