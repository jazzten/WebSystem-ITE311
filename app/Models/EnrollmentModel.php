<?php

namespace App\Models;

use CodeIgniter\Model;

class EnrollmentModel extends Model
{
    protected $table            = 'enrollments';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['user_id', 'course_id', 'enrollment_date'];

    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';

    protected $validationRules = [
        'user_id'         => 'required|integer',
        'course_id'       => 'required|integer',
        'enrollment_date' => 'required'
    ];

    /**
     * Enroll a user in a course
     */
    public function enrollUser($data)
    {
        try {
            return $this->insert($data);
        } catch (\Exception $e) {
            log_message('error', 'Enrollment Error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Get all courses a user is enrolled in
     */
    public function getUserEnrollments($userId)
    {
        return $this->select('enrollments.*, 
                             courses.id as course_id,
                             courses.course_name, 
                             courses.course_code, 
                             courses.description,
                             courses.schedule,
                             courses.teacher_id,
                             users.name as teacher_name')
                    ->join('courses', 'courses.id = enrollments.course_id')
                    ->join('users', 'users.id = courses.teacher_id', 'left')
                    ->where('enrollments.user_id', $userId)
                    ->orderBy('enrollments.enrollment_date', 'DESC')
                    ->findAll();
    }

    /**
     * Check if a user is already enrolled in a specific course
     */
    public function isAlreadyEnrolled($userId, $courseId)
    {
        $result = $this->where('user_id', $userId)
                       ->where('course_id', $courseId)
                       ->first();
        
        return $result !== null;
    }

    /**
     * Unenroll a user from a course
     */
    public function unenrollUser($userId, $courseId)
    {
        try {
            return $this->where('user_id', $userId)
                        ->where('course_id', $courseId)
                        ->delete();
        } catch (\Exception $e) {
            log_message('error', 'Unenrollment Error: ' . $e->getMessage());
            return false;
        }
    }
}