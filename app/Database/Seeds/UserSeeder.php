<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name'     => 'Gudang A',
                'email'    => 'gudang.a@example.com',
                'password' => password_hash('gudang.a', PASSWORD_DEFAULT),
                'role'     => 'gudang',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name'     => 'Gudang B',
                'email'    => 'gudang.b@example.com',
                'password' => password_hash('gudang.b', PASSWORD_DEFAULT),
                'role'     => 'gudang',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name'     => 'Dapur A',
                'email'    => 'dapur.a@example.com',
                'password' => password_hash('dapur.a', PASSWORD_DEFAULT),
                'role'     => 'dapur',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name'     => 'Dapur B',
                'email'    => 'dapur.b@example.com',
                'password' => password_hash('dapur.b', PASSWORD_DEFAULT),
                'role'     => 'dapur',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name'     => 'Dapur C',
                'email'    => 'dapur.c@example.com',
                'password' => password_hash('dapur.c', PASSWORD_DEFAULT),
                'role'     => 'dapur',
                'created_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('user')->insertBatch($data);
    }
}

