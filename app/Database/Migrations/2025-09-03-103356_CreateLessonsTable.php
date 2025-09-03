<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateLessonsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type'=>'INT','constraint'=>9,'unsigned'=>true,'auto_increment'=>true],
            'course_id' => ['type'=>'INT','constraint'=>9,'unsigned'=>true,'null'=>false],
            'title' => ['type'=>'VARCHAR','constraint'=>255,'null'=>false],
            'content' => ['type'=>'TEXT','null'=>true],
            'position' => ['type'=>'INT','constraint'=>5,'null'=>true],
            'created_at' => ['type'=>'DATETIME','null'=>true],
            'updated_at' => ['type'=>'DATETIME','null'=>true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('course_id','courses','id','CASCADE','CASCADE');
        $this->forge->createTable('lessons', true);
    }

    public function down()
    {
        $this->forge->dropTable('lessons', true);
    }
}
