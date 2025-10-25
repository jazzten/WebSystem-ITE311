<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSubmissionsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type'=>'INT','constraint'=>9,'unsigned'=>true,'auto_increment'=>true],
            'quiz_id' => ['type'=>'INT','constraint'=>9,'unsigned'=>true,'null'=>false],
            'user_id' => ['type'=>'INT','constraint'=>9,'unsigned'=>true,'null'=>false],

            'answers' => ['type'=>'TEXT','null'=>true],
            'score' => ['type'=>'DECIMAL','constraint'=>'5,2','null'=>true],
            'submitted_at' => ['type'=>'DATETIME','null'=>true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('quiz_id','quizzes','id','CASCADE','CASCADE');
        $this->forge->addForeignKey('user_id','users','id','CASCADE','CASCADE');
        $this->forge->createTable('submissions', true);
    }

    public function down()
    {
        $this->forge->dropTable('submissions', true);
    }
}