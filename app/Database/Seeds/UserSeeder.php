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
                'email'         => 'justine@gmail.com',
                'password_hash' => password_hash('admin123', PASSWORD_DEFAULT),
            ],

            [
                'role'          => 'instructor',
                'first_name'    => 'Wiggy',
                'last_name'     => 'Oscar',
                'email'         => 'wiggy@gmail.com',
                'password_hash' => password_hash('instructor123', PASSWORD_DEFAULT),
            ],

            [
                'role'          => 'student',
                'first_name'    => 'Jazz',
                'last_name'     => 'Baltazar',
                'email'         => 'jazz@gmail.com',
                'password_hash' => password_hash('student123', PASSWORD_DEFAULT),
            ],
        ];

        $this->db->table('users')->insertBatch($data);
    }
}
