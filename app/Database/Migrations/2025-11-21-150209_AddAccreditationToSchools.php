<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\Exceptions\DatabaseException;

class AddAccreditationToSchools extends Migration
{
    public function up()
    {
        // Tambahkan kolom accreditation_status
        try {
            $this->forge->addColumn('schools', [
                'accreditation_status' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 20,
                    'default'    => 'A',
                    'after'      => 'phone',
                    'comment'    => 'Status akreditasi: A, B, C, atau Belum Terakreditasi',
                ],
            ]);
        } catch (DatabaseException $e) {
            // Kolom sudah ada, skip
        }
        
        // Update data yang sudah ada
        $this->db->table('schools')
                 ->where('accreditation_status', '')
                 ->orWhere('accreditation_status', null)
                 ->update(['accreditation_status' => 'A']);
    }

    public function down()
    {
        try {
            $this->forge->dropColumn('schools', 'accreditation_status');
        } catch (DatabaseException $e) {
            // Kolom tidak ada, skip
        }
    }
}