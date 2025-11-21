<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class SetupMbsTables extends Migration
{
    public function up()
    {
        // 1. TABEL SETTINGS (Untuk Footer & Identitas Dinamis)
        $this->forge->addField([
            'id'            => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'setting_key'   => ['type' => 'VARCHAR', 'constraint' => 50],
            'setting_value' => ['type' => 'TEXT', 'null' => true],
            'setting_group' => ['type' => 'VARCHAR', 'constraint' => 20, 'default' => 'general'],
            'created_at'    => ['type' => 'DATETIME', 'null' => true],
            'updated_at'    => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('setting_key'); // Key tidak boleh kembar
        $this->forge->createTable('settings');

        // 2. TABEL SCHOOLS (MTs, MA, SMK) - Tabel Induk
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'name'        => ['type' => 'VARCHAR', 'constraint' => 100],
            'slug'        => ['type' => 'VARCHAR', 'constraint' => 100],
            'description' => ['type' => 'TEXT', 'null' => true],
            'hero_image'  => ['type' => 'VARCHAR', 'constraint' => 255, 'default' => 'default_school.jpg'],
            'logo'        => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
            'updated_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('slug');
        $this->forge->createTable('schools');

        // 3. TABEL SLIDERS (Hero Section Homepage)
        $this->forge->addField([
            'id'             => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'title'          => ['type' => 'VARCHAR', 'constraint' => 255],
            'subtitle'       => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'image'          => ['type' => 'VARCHAR', 'constraint' => 255],
            'link_url'       => ['type' => 'VARCHAR', 'constraint' => 255, 'default' => '#'],
            'is_active'      => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'order_position' => ['type' => 'INT', 'constraint' => 11, 'default' => 0],
            'created_at'     => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('sliders');

        // 4. TABEL ANNOUNCEMENTS (Running Text)
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'content'    => ['type' => 'TEXT'],
            'link_url'   => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'is_active'  => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'start_date' => ['type' => 'DATE', 'null' => true],
            'end_date'   => ['type' => 'DATE', 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('announcements');

        // 5. TABEL POSTS (Berita - Punya Relasi ke Schools)
        $this->forge->addField([
            'id'           => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'school_id'    => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true], // Boleh NULL (untuk berita umum)
            'title'        => ['type' => 'VARCHAR', 'constraint' => 255],
            'slug'         => ['type' => 'VARCHAR', 'constraint' => 255],
            'content'      => ['type' => 'LONGTEXT'],
            'thumbnail'    => ['type' => 'VARCHAR', 'constraint' => 255, 'default' => 'no-image.jpg'],
            'is_published' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'views'        => ['type' => 'INT', 'constraint' => 11, 'default' => 0],
            'created_at'   => ['type' => 'DATETIME', 'null' => true],
            'updated_at'   => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('slug');
        // Menambahkan Foreign Key (Relasi)
        $this->forge->addForeignKey('school_id', 'schools', 'id', 'CASCADE', 'SET NULL');
        $this->forge->createTable('posts');

        // 6. TABEL EVENTS (Agenda)
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'school_id'   => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'title'       => ['type' => 'VARCHAR', 'constraint' => 255],
            'slug'        => ['type' => 'VARCHAR', 'constraint' => 255],
            'event_date'  => ['type' => 'DATE'],
            'time_start'  => ['type' => 'TIME', 'null' => true],
            'time_end'    => ['type' => 'TIME', 'null' => true],
            'location'    => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'description' => ['type' => 'TEXT', 'null' => true],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('school_id', 'schools', 'id', 'CASCADE', 'SET NULL');
        $this->forge->createTable('events');

        // 7. TABEL GALLERIES
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'school_id'  => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'title'      => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'image_url'  => ['type' => 'VARCHAR', 'constraint' => 255],
            'category'   => ['type' => 'VARCHAR', 'constraint' => 50, 'default' => 'kegiatan'],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('school_id', 'schools', 'id', 'CASCADE', 'SET NULL');
        $this->forge->createTable('galleries');
    }

    public function down()
    {
        // Hapus tabel dengan urutan terbalik (Anak dulu, baru Induk)
        $this->forge->dropTable('galleries');
        $this->forge->dropTable('events');
        $this->forge->dropTable('posts');
        $this->forge->dropTable('announcements');
        $this->forge->dropTable('sliders');
        $this->forge->dropTable('schools');
        $this->forge->dropTable('settings');
    }
}