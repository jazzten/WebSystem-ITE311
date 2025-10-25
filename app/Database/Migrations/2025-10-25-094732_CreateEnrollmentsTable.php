<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateEnrollmentsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type'=>'INT','constraint'=>9,'unsigned'=>true,'auto_increment'=>true],
            'user_id' => ['type'=>'INT','constraint'=>9,'unsigned'=>true,'null'=>false],
            'course_id' => ['type'=>'INT','constraint'=>9,'unsigned'=>true,'null'=>false],
            'enrolled_at' => ['type'=>'DATETIME','null'=>true],
            'status' => ['type'=>"ENUM('active','completed','dropped')", 'default' => 'active']
        ]);

        $this->forge->addKey('id', true);
        // prevent duplicate enrollments
        $this->forge->addUniqueKey(['user_id','course_id']);
        $this->forge->addForeignKey('user_id','users','id','CASCADE','CASCADE');
        $this->forge->addForeignKey('course_id','courses','id','CASCADE','CASCADE');
        $this->forge->createTable('enrollments', true);
    }

    public function down()
    {
        $this->forge->dropTable('enrollments', true);
    }
}