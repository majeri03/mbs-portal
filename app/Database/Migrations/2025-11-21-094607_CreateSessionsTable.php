<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSessionsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'       => 'VARCHAR',
                'constraint' => 128,
                'null'       => false,
            ],
            'ip_address' => [
                'type'       => 'VARCHAR',
                'constraint' => 45,
                'null'       => false,
            ],
            'timestamp' => [
                'type'     => 'INT',
                'unsigned' => true,
                'null'     => false,
                'default'  => 0,
            ],
            'data' => [
                'type' => 'TEXT',
                'null' => false,
            ],
        ]);

        $this->forge->addKey('id', true); // Primary Key
        $this->forge->addKey('timestamp'); // Index untuk performa
        $this->forge->createTable('ci_sessions');
    }

    public function down()
    {
        $this->forge->dropTable('ci_sessions');
    }
}