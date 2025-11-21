<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddSecurityFieldsToUsers extends Migration
{
    public function up()
    {
        $fields = [
            'last_ip' => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'login_attempts' => ['type' => 'INT', 'constraint' => 11, 'default' => 0], // Anti brute force
            'locked_until' => ['type' => 'DATETIME', 'null' => true], // Lock akun jika 5x salah password
        ];
        $this->forge->addColumn('users', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('users', ['last_ip', 'login_attempts', 'locked_until']);
    }
}