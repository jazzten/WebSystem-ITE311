<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateQuizzesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type'=>'INT','constraint'=>9,'unsigned'=>true,'auto_increment'=>true],
            'lesson_id' => ['type'=>'INT','constraint'=>9,'unsigned'=>true,'null'=>false],
            'title' => ['type'=>'VARCHAR','constraint'=>255,'null'=>false],
            'instructions' => ['type'=>'TEXT','null'=>true],
            'created_at' => ['type'=>'DATETIME','null'=>true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('lesson_id','lessons','id','CASCADE','CASCADE');
        $this->forge->createTable('quizzes', true);
    }

    public function down()
    {
        $this->forge->dropTable('quizzes', true);
    }
}
