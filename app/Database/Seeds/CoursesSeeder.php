<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CoursesSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'course_name' => 'Introduction to Web Development',
                'course_code' => 'WEB101',
                'description' => 'Learn HTML, CSS, and JavaScript fundamentals',
                'schedule' => 'Mon/Wed 9:00 AM - 11:00 AM',
                'teacher_id' => 2, // Teacher user ID from UserSeeder
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'course_name' => 'Database Management Systems',
                'course_code' => 'DB201',
                'description' => 'Study relational databases, SQL, and database design',
                'schedule' => 'Tue/Thu 1:00 PM - 3:00 PM',
                'teacher_id' => 2,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'course_name' => 'Object-Oriented Programming',
                'course_code' => 'OOP301',
                'description' => 'Master OOP concepts using PHP',
                'schedule' => 'Fri 10:00 AM - 1:00 PM',
                'teacher_id' => 2,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'course_name' => 'Data Structures and Algorithms',
                'course_code' => 'DSA401',
                'description' => 'Learn essential data structures and algorithms',
                'schedule' => 'Mon/Wed 2:00 PM - 4:00 PM',
                'teacher_id' => 2,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'course_name' => 'Mobile Application Development',
                'course_code' => 'MOB501',
                'description' => 'Build cross-platform mobile apps',
                'schedule' => 'Tue/Thu 9:00 AM - 11:00 AM',
                'teacher_id' => 2,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('courses')->insertBatch($data);
    }
}