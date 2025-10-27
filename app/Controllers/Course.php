<?php

namespace App\Controllers;

use App\Models\EnrollmentModel;
use App\Models\CourseModel;
use CodeIgniter\Controller;

class Course extends Controller
{
    protected $enrollmentModel;
    protected $courseModel;

    public function __construct()
    {
        $this->enrollmentModel = new EnrollmentModel();
        $this->courseModel = new CourseModel();
    }

    /**
     * Handle course enrollment via AJAX
     */
    public function enroll()
    {
        // Check if user is logged in
        if (!session()->get('isLoggedIn')) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'You must be logged in to enroll in courses.'
            ])->setStatusCode(401);
        }

        // Check if user is a student
        if (session()->get('role') !== 'student') {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Only students can enroll in courses.'
            ])->setStatusCode(403);
        }

        // Get course_id from POST request
        $courseId = $this->request->getPost('course_id');
        $userId = session()->get('id');

        // Validate course_id
        if (!$courseId || !is_numeric($courseId) || $courseId <= 0) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Invalid course ID.'
            ])->setStatusCode(400);
        }

        // Check if course exists
        $course = $this->courseModel->find($courseId);
        if (!$course) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Course not found.'
            ])->setStatusCode(404);
        }

        try {
            // Check if user is already enrolled
            if ($this->enrollmentModel->isAlreadyEnrolled($userId, $courseId)) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'You are already enrolled in this course.'
                ])->setStatusCode(409);
            }

            // Enroll user in the course
            $enrollmentData = [
                'user_id' => $userId,
                'course_id' => $courseId,
                'enrollment_date' => date('Y-m-d H:i:s')
            ];

            $enrollmentId = $this->enrollmentModel->enrollUser($enrollmentData);

            if ($enrollmentId) {
                // Get enrolled course details
                $enrolledCourse = $this->enrollmentModel->select('enrollments.*, 
                                     courses.id as course_id,
                                     courses.course_name, 
                                     courses.course_code, 
                                     courses.description,
                                     courses.schedule,
                                     users.name as teacher_name')
                            ->join('courses', 'courses.id = enrollments.course_id')
                            ->join('users', 'users.id = courses.teacher_id', 'left')
                            ->where('enrollments.id', $enrollmentId)
                            ->first();

                // Format enrollment date
                if ($enrolledCourse) {
                    $enrolledCourse['enrollment_date'] = date('M d, Y', strtotime($enrolledCourse['enrollment_date']));
                }

                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'Successfully enrolled in ' . $course['course_name'] . '!',
                    'enrolledCourse' => $enrolledCourse
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Failed to enroll in the course. Please try again.'
                ])->setStatusCode(500);
            }
        } catch (\Exception $e) {
            log_message('error', 'Enrollment error: ' . $e->getMessage());
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'An error occurred while enrolling. Please try again.'
            ])->setStatusCode(500);
        }
    }

    /**
     * Handle course unenrollment via AJAX
     */
    public function unenroll()
    {
        if (!session()->get('isLoggedIn')) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'You must be logged in to unenroll from courses.'
            ])->setStatusCode(401);
        }

        if (session()->get('role') !== 'student') {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Only students can unenroll from courses.'
            ])->setStatusCode(403);
        }

        $courseId = $this->request->getPost('course_id');
        $userId = session()->get('id');

        if (!$courseId || !is_numeric($courseId)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Invalid course ID.'
            ])->setStatusCode(400);
        }

        try {
            if (!$this->enrollmentModel->isAlreadyEnrolled($userId, $courseId)) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'You are not enrolled in this course.'
                ])->setStatusCode(404);
            }

            if ($this->enrollmentModel->unenrollUser($userId, $courseId)) {
                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'Successfully unenrolled from the course.'
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Failed to unenroll from the course.'
                ])->setStatusCode(500);
            }
        } catch (\Exception $e) {
            log_message('error', 'Unenrollment error: ' . $e->getMessage());
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'An error occurred while unenrolling.'
            ])->setStatusCode(500);
        }
    }
}
