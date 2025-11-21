<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\Exceptions\DatabaseException;

class UpdateSchoolsTableStructure extends Migration
{
    public function up()
    {
        // Tambahkan kolom image_url (untuk foto utama sekolah)
        try {
            $this->forge->addColumn('schools', [
                'image_url' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 255,
                    'null'       => true,
                    'after'      => 'description',
                ],
            ]);
        } catch (DatabaseException $e) {
            // Kolom sudah ada, skip
        }
        
        // Tambahkan kolom order_position
        try {
            $this->forge->addColumn('schools', [
                'order_position' => [
                    'type'       => 'INT',
                    'constraint' => 11,
                    'default'    => 0,
                    'after'      => 'image_url',
                ],
            ]);
        } catch (DatabaseException $e) {
            // Kolom sudah ada, skip
        }
        
        // Tambahkan kolom website_url
        try {
            $this->forge->addColumn('schools', [
                'website_url' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 255,
                    'null'       => true,
                    'after'      => 'order_position',
                ],
            ]);
        } catch (DatabaseException $e) {
            // Kolom sudah ada, skip
        }
        
        // Tambahkan kolom contact_person
        try {
            $this->forge->addColumn('schools', [
                'contact_person' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 100,
                    'null'       => true,
                    'after'      => 'website_url',
                ],
            ]);
        } catch (DatabaseException $e) {
            // Kolom sudah ada, skip
        }
        
        // Tambahkan kolom phone
        try {
            $this->forge->addColumn('schools', [
                'phone' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 20,
                    'null'       => true,
                    'after'      => 'contact_person',
                ],
            ]);
        } catch (DatabaseException $e) {
            // Kolom sudah ada, skip
        }
        
        // Update order_position untuk data yang sudah ada
        $builder = $this->db->table('schools');
        $schools = $builder->get()->getResultArray();
        
        if (!empty($schools)) {
            $order = 1;
            foreach ($schools as $school) {
                $builder->where('id', $school['id'])
                        ->update(['order_position' => $order]);
                $order++;
            }
        }
    }

    public function down()
    {
        // Rollback: hapus kolom yang ditambahkan
        $columns = ['image_url', 'order_position', 'website_url', 'contact_person', 'phone'];
        
        foreach ($columns as $column) {
            try {
                $this->forge->dropColumn('schools', $column);
            } catch (DatabaseException $e) {
                // Kolom tidak ada, skip
            }
        }
    }
}