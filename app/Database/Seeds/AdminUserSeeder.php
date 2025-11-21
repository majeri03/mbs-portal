<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'username'   => 'admin',
            'email'      => 'admin@mbs.sch.id',
            'password'   => password_hash('admin123', PASSWORD_DEFAULT), // WAJIB pakai password_hash untuk keamanan
            'full_name'  => 'Administrator MBS',
            'role'       => 'superadmin',
            'is_active'  => 1,
            'created_at' => Time::now(),
        ];

        $this->db->table('users')->insert($data);
    }
}