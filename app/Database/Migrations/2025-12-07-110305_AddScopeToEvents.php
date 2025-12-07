<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddScopeToEvents extends Migration
{
    public function up()
    {
        $this->forge->addColumn('events', [
            'scope' => [
                'type'       => 'ENUM',
                'constraint' => ['public', 'internal'],
                'default'    => 'public',
                'after'      => 'slug',
                'comment'    => 'public=Tampil di web, internal=Hanya untuk guru/admin'
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('events', 'scope');
    }
}