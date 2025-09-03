<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $now = date('Y-m-d H:i:s');

        $data = [
            [
                'role'          => 'admin',
                'first_name'    => 'Justine',
                'last_name'     => 'Brian',
                'email'         => 'Jb@gmail.com',
                'password_hash' => password_hash('admin123', PASSWORD_DEFAULT),
            ],

            [
                'role'          => 'instructor',
                'first_name'    => 'Baltazar',
                'last_name'     => 'Wiggy',
                'email'         => 'baltazarwiggy@gmail.com',
                'password_hash' => password_hash('instructor123', PASSWORD_DEFAULT),
            ],

            [
                'role'          => 'student',
                'first_name'    => 'Jessie',
                'last_name'     => 'Nabuntoran',
                'email'         => 'jessie@gmail.com',
                'password_hash' => password_hash('student123', PASSWORD_DEFAULT),
            ],
        ];

        $this->db->table('users')->insertBatch($data);
    }
}