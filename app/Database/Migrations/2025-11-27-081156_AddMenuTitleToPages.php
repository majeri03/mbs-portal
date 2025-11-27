<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddMenuTitleToPages extends Migration
{
    public function up()
    {
        $this->forge->addColumn('pages', [
            'menu_title' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'default'    => 'Tentang Kami', // Default nama menu
                'after'      => 'school_id',
                'comment'    => 'Nama Group Menu di Navbar'
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('pages', 'menu_title');
    }
}