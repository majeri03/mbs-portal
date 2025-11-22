<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\Exceptions\DatabaseException;

class UpdateAnnouncementsTableStructure extends Migration
{
    public function up()
    {
        // Tambahkan kolom title (jika belum ada)
        if (!$this->db->fieldExists('title', 'announcements')) {
            $this->forge->addColumn('announcements', [
                'title' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 255,
                    'null'       => false,
                    'after'      => 'id',
                    'comment'    => 'Judul pengumuman',
                ],
            ]);
        }
        
        // Tambahkan kolom category (jika belum ada)
        if (!$this->db->fieldExists('category', 'announcements')) {
            $this->forge->addColumn('announcements', [
                'category' => [
                    'type'       => 'ENUM',
                    'constraint' => ['urgent', 'important', 'normal'],
                    'default'    => 'normal',
                    'after'      => 'content',
                    'comment'    => 'Kategori: urgent (merah), important (kuning), normal (biru)',
                ],
            ]);
        }
        
        // Tambahkan kolom priority (jika belum ada)
        if (!$this->db->fieldExists('priority', 'announcements')) {
            $this->forge->addColumn('announcements', [
                'priority' => [
                    'type'    => 'INT',
                    'default' => 0,
                    'after'   => 'is_active',
                    'comment' => 'Urutan tampil (angka kecil = prioritas tinggi)',
                ],
            ]);
        }
        
        // Tambahkan kolom icon (jika belum ada)
        if (!$this->db->fieldExists('icon', 'announcements')) {
            $this->forge->addColumn('announcements', [
                'icon' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 50,
                    'default'    => 'bi-megaphone-fill',
                    'after'      => 'priority',
                    'comment'    => 'Bootstrap icon class',
                ],
            ]);
        }
        
        // Tambahkan kolom created_by (jika belum ada)
        if (!$this->db->fieldExists('created_by', 'announcements')) {
            $this->forge->addColumn('announcements', [
                'created_by' => [
                    'type'       => 'INT',
                    'constraint' => 11,
                    'null'       => true,
                    'after'      => 'icon',
                    'comment'    => 'User ID yang membuat',
                ],
            ]);
        }
        
        // Tambahkan kolom updated_at (jika belum ada)
        if (!$this->db->fieldExists('updated_at', 'announcements')) {
            $this->forge->addColumn('announcements', [
                'updated_at' => [
                    'type' => 'DATETIME',
                    'null' => true,
                    'after' => 'created_at',
                ],
            ]);
        }
        
        // Update data existing (set default values)
        $builder = $this->db->table('announcements');
        
        // Set title default jika NULL/kosong
        $builder->set('title', 'content', false) // Gunakan content sebagai title sementara
                ->where('title IS NULL OR title = ""')
                ->update();
        
        // Set priority default
        $builder->set('priority', 0)
                ->where('priority IS NULL')
                ->update();
    }

    public function down()
    {
        // Rollback: hapus kolom yang ditambahkan
        $columns = ['title', 'category', 'priority', 'icon', 'created_by', 'updated_at'];
        
        foreach ($columns as $column) {
            if ($this->db->fieldExists($column, 'announcements')) {
                $this->forge->dropColumn('announcements', $column);
            }
        }
    }
}