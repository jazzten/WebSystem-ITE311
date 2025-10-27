<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\EnrollmentModel;
use App\Models\CourseModel;
use CodeIgniter\Controller;

class Dashboard extends Controller
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Please login first');
        }

        $role = session()->get('role');
        $data['user'] = [
            'id' => session()->get('id'),
            'name' => session()->get('name'),
            'email' => session()->get('email'),
            'role' => session()->get('role'),
        ];

        try {
            switch ($role) {
                case 'admin':
                    return $this->adminDashboard($data);
                case 'teacher':
                    return $this->teacherDashboard($data);
                case 'student':
                    return $this->studentDashboard($data);
                default:
                    session()->destroy();
                    return redirect()->to(base_url('login'))->with('error', 'Invalid role');
            }
        } catch (\Exception $e) {
            log_message('error', 'Dashboard error: ' . $e->getMessage());
            return redirect()->to(base_url('login'))->with('error', 'An error occurred.');
        }
    }

    private function adminDashboard($data)
    {
        $data['totalUsers'] = $this->userModel->countAll();
        $data['totalAdmins'] = $this->userModel->where('role', 'admin')->countAllResults();
        $data['totalTeachers'] = $this->userModel->where('role', 'teacher')->countAllResults();
        $data['totalStudents'] = $this->userModel->where('role', 'student')->countAllResults();
        $data['recentUsers'] = $this->userModel->orderBy('created_at', 'DESC')->findAll(10);
        $data['allUsers'] = $this->userModel->orderBy('created_at', 'DESC')->findAll();
        return view('dashboard/admin', $data);
    }

    private function teacherDashboard($data)
    {
        $data['students'] = $this->userModel->getUsersByRole('student');
        $data['totalStudents'] = count($data['students']);
        return view('dashboard/teacher', $data);
    }

    private function studentDashboard($data)
    {
        // ✅ FIXED: Load enrollment and course models
        $enrollmentModel = new EnrollmentModel();
        $courseModel = new CourseModel();
        
        $userId = session()->get('id');
        
        // Get enrolled courses
        $data['enrolledCourses'] = $enrollmentModel->getUserEnrollments($userId);
        
        // Get available courses (not yet enrolled)
        $data['availableCourses'] = $courseModel->getAvailableCoursesForStudent($userId);
        
        return view('dashboard/student', $data);
    }

    // Admin: Manage Users Page
    public function manageUsers()
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            return redirect()->to('/dashboard')->with('error', 'Unauthorized access');
        }

        $data['user'] = [
            'name' => session()->get('name'),
            'role' => session()->get('role'),
        ];
        $data['users'] = $this->userModel->orderBy('created_at', 'DESC')->findAll();
        return view('dashboard/admin_users', $data);
    }


    public function reports()
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            return redirect()->to('/dashboard')->with('error', 'Unauthorized access');
        }

        $data['user'] = [
            'name' => session()->get('name'),
            'role' => session()->get('role'),
        ];
        $data['totalUsers'] = $this->userModel->countAll();
        $data['totalAdmins'] = $this->userModel->where('role', 'admin')->countAllResults();
        $data['totalTeachers'] = $this->userModel->where('role', 'teacher')->countAllResults();
        $data['totalStudents'] = $this->userModel->where('role', 'student')->countAllResults();
        return view('dashboard/admin_reports', $data);
    }


    public function myClasses()
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'teacher') {
            return redirect()->to('/dashboard')->with('error', 'Unauthorized access');
        }

        $data['user'] = [
            'name' => session()->get('name'),
            'role' => session()->get('role'),
        ];

        $data['classes'] = [
            ['id' => 1, 'name' => 'Mathematics 101', 'schedule' => 'Mon/Wed 9:00 AM', 'students' => 25],
            ['id' => 2, 'name' => 'Physics 201', 'schedule' => 'Tue/Thu 11:00 AM', 'students' => 30],
            ['id' => 3, 'name' => 'Chemistry 101', 'schedule' => 'Fri 2:00 PM', 'students' => 20],
        ];
        return view('dashboard/teacher_classes', $data);
    }


    public function myCourses()
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'student') {
            return redirect()->to('/dashboard')->with('error', 'Unauthorized access');
        }

        $data['user'] = [
            'name' => session()->get('name'),
            'role' => session()->get('role'),
        ];

        $data['courses'] = [
            ['id' => 1, 'name' => 'Mathematics 101', 'teacher' => 'Dr. Smith', 'progress' => 75],
            ['id' => 2, 'name' => 'Physics 221', 'teacher' => 'Prof. Nabuntoran', 'progress' => 60],
            ['id' => 3, 'name' => 'Object-Oriented Programming 331', 'teacher' => 'Prof. Wiggy', 'progress' => 85],
            ['id' => 4, 'name' => 'Database Management Systems 301', 'teacher' => 'Prof. Oscar', 'progress' => 50],
        ];
        return view('dashboard/student_courses', $data);
    }


    public function myGrades()
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'student') {
            return redirect()->to('/dashboard')->with('error', 'Unauthorized access');
        }

        $data['user'] = [
            'name' => session()->get('name'),
            'role' => session()->get('role'),
        ];

        $data['grades'] = [
            ['course' => 'Mathematics 101', 'assignment' => 'Midterm Exam', 'grade' => 'A', 'score' => 92],
            ['course' => 'Physics 201', 'assignment' => 'Lab Report 1', 'grade' => 'B+', 'score' => 87],
            ['course' => 'Chemistry 101', 'assignment' => 'Quiz 3', 'grade' => 'A-', 'score' => 90],
            ['course' => 'Biology 101', 'assignment' => 'Final Project', 'grade' => 'B', 'score' => 85],
        ];
        return view('dashboard/student_grades', $data);
    }


    public function deleteUser($id)
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            return $this->response->setJSON(['success' => false, 'message' => 'Unauthorized']);
        }

        try {
            if ($this->userModel->delete($id)) {
                return $this->response->setJSON(['success' => true, 'message' => 'User deleted successfully']);
            }
            return $this->response->setJSON(['success' => false, 'message' => 'Failed to delete user']);
        } catch (\Exception $e) {
            return $this->response->setJSON(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    // ============================================
    // ✅ ADDED METHOD: Manage Courses (Admin/Teacher)
    // ============================================
    public function manageCourses()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Please login first');
        }

        $role = session()->get('role');
        if ($role !== 'admin' && $role !== 'teacher') {
            return redirect()->to('/dashboard')->with('error', 'Unauthorized access');
        }

        helper('form');
        $courseModel = new \App\Models\CourseModel();

        $data['user'] = [
            'name' => session()->get('name'),
            'role' => session()->get('role'),
        ];

        // For teachers, show only their courses
        if ($role === 'teacher') {
            $data['courses'] = $courseModel->where('teacher_id', session()->get('id'))->findAll();
        } else {
            // For admins, show all courses
            $data['courses'] = $courseModel->getAllCoursesWithTeachers();
        }

        return view('dashboard/manage_courses', $data);
    }
}

