<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateDocumentTables extends Migration
{
    public function up()
    {
        // 1. TABEL KATEGORI DOKUMEN
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
                'null'       => true, // NULL = Kategori Pusat, Isi = Kategori Sekolah
            ],
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'slug' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('school_id', 'schools', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('document_categories');

        // 2. TABEL DOKUMEN (FILE)
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
                'null'       => true,
            ],
            'category_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'title' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'slug' => [ // Untuk link halaman detail yang "keren"
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'description' => [ // Penjelasan detail dokumen sebelum download
                'type' => 'TEXT',
                'null' => true,
            ],
            'external_url' => [ // Link Google Drive / Dropbox
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'file_type' => [ // Ikon otomatis (pdf, docx, xlsx, link)
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'default'    => 'pdf',
            ],
            'is_public' => [ // 1 = Tampil, 0 = Sembunyi
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 1,
            ],
            'created_by' => [ // Siapa yang upload (User ID)
                'type'       => 'INT', 
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('school_id', 'schools', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('category_id', 'document_categories', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('documents');
    }

    public function down()
    {
        $this->forge->dropTable('documents');
        $this->forge->dropTable('document_categories');
    }
}