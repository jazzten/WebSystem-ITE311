<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCoursesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'=>'INT',
                'constraint'=>9,
                'unsigned'=>true,
                'auto_increment'=>true
            ],
            'title' => ['type'=>'VARCHAR','constraint'=>255,'null'=>false],
            'slug'  => ['type'=>'VARCHAR','constraint'=>255,'null'=>false],
            'description' => ['type'=>'TEXT','null'=>true],
            'instructor_id' => ['type'=>'INT','constraint'=>9,'unsigned'=>true,'null'=>true],
            'created_at' => ['type'=>'DATETIME','null'=>true],
            'updated_at' => ['type'=>'DATETIME','null'=>true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('slug');

        $this->forge->addForeignKey('instructor_id','users','id','SET NULL','CASCADE');
        $this->forge->createTable('courses', true);
    }

    public function down()
    {
        $this->forge->dropTable('courses', true);
    }
}