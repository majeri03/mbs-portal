<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddAuthorToPosts extends Migration
{
    public function up()
    {
        $this->forge->addColumn('posts', [
            'author' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
                'after'      => 'slug',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('posts', 'author');
    }
}