<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ModifyUserRoleEnum extends Migration
{
    public function up()
    {
        // Kita gunakan Raw Query agar lebih aman mengubah ENUM
        // Menambahkan 'guru' ke dalam daftar pilihan role
        $this->db->query("ALTER TABLE users MODIFY COLUMN role ENUM('superadmin', 'admin', 'guru') DEFAULT 'guru'");
    }

    public function down()
    {
        // Kembalikan ke kondisi semula (Hanya superadmin & admin)
        // Hati-hati: Jika ada user 'guru', ini bisa error saat rollback.
        $this->db->query("ALTER TABLE users MODIFY COLUMN role ENUM('superadmin', 'admin') DEFAULT 'admin'");
    }
}