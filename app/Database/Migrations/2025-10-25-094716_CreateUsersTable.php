<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsersTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 9,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'first_name' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => false],
            'last_name'  => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'email'      => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => false],
            'password_hash' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => false],
            'role'       => ['type' => "ENUM('student','instructor','admin')", 'default' => 'student'],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('email');
        $this->forge->createTable('users', true);
    }

    public function down()
    {
        $this->forge->dropTable('users', true);
    }
}