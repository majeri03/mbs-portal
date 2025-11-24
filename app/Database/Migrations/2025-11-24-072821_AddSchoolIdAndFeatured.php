<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddSchoolIdAndFeatured extends Migration
{
    public function up()
    {
        // 1. Modifikasi Tabel PAGES
        // Tambah school_id (untuk tahu halaman ini milik siapa)
        // Tambah is_featured (untuk menandai halaman yang ditempel di beranda sekolah)
        $this->forge->addColumn('pages', [
            'school_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
                'after'      => 'id',
                'comment'    => 'NULL=Global, ID=Sekolah Tertentu'
            ],
            'is_featured' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
                'after'      => 'is_active',
                'comment'    => '1=Tampil di Landing Page Sekolah'
            ]
        ]);
        
        // Tambah Foreign Key ke pages agar aman
        $this->forge->addForeignKey('school_id', 'schools', 'id', 'CASCADE', 'SET NULL', 'fk_pages_school_id');


        // 2. Modifikasi Tabel SLIDERS
        // Agar Banner MTs tidak muncul di Web SMK, dan sebaliknya.
        $this->forge->addColumn('sliders', [
            'school_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
                'after'      => 'id',
            ]
        ]);
        $this->forge->addForeignKey('school_id', 'schools', 'id', 'CASCADE', 'SET NULL', 'fk_sliders_school_id');


        // 3. Modifikasi Tabel ANNOUNCEMENTS
        // Agar pengumuman "Ujian SMK" tidak muncul di web MTs.
        $this->forge->addColumn('announcements', [
            'school_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
                'after'      => 'id',
            ]
        ]);
        $this->forge->addForeignKey('school_id', 'schools', 'id', 'CASCADE', 'SET NULL', 'fk_announcements_school_id');
    }

    public function down()
    {
        // Rollback: Hapus kolom & FK jika migrasi dibatalkan
        $this->forge->dropForeignKey('pages', 'fk_pages_school_id');
        $this->forge->dropColumn('pages', ['school_id', 'is_featured']);

        $this->forge->dropForeignKey('sliders', 'fk_sliders_school_id');
        $this->forge->dropColumn('sliders', 'school_id');

        $this->forge->dropForeignKey('announcements', 'fk_announcements_school_id');
        $this->forge->dropColumn('announcements', 'school_id');
    }
}