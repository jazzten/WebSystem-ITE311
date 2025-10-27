<?php

namespace App\Models;

use CodeIgniter\Model;

class CourseModel extends Model
{
    protected $table            = 'courses';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['course_name', 'course_code', 'description', 'schedule', 'teacher_id'];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules = [
        'course_name' => 'required|min_length[3]|max_length[255]',
        'course_code' => 'required|min_length[2]|max_length[50]',
    ];

    /**
     * Get available courses for a student (not yet enrolled)
     * 
     * @param int $userId The student's user ID
     * @return array
     */
    public function getAvailableCoursesForStudent($userId)
    {
        return $this->select('courses.*, users.name as teacher_name')
                    ->join('users', 'users.id = courses.teacher_id', 'left')
                    ->join('enrollments', 'enrollments.course_id = courses.id AND enrollments.user_id = ' . (int)$userId, 'left')
                    ->where('enrollments.id IS NULL')
                    ->orderBy('courses.course_name', 'ASC')
                    ->findAll();
    }

    /**
     * Get all courses with teacher information
     */
    public function getAllCoursesWithTeachers()
    {
        return $this->select('courses.*, users.name as teacher_name')
                    ->join('users', 'users.id = courses.teacher_id', 'left')
                    ->orderBy('courses.course_name', 'ASC')
                    ->findAll();
    }
}