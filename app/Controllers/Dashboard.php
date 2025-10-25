<?php

namespace App\Controllers;

use App\Models\UserModel;
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
        // Check if user is logged in
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
            return redirect()->to(base_url('login'))->with('error', 'Please login first');
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
                    $data['totalUsers'] = $this->userModel->countAll();
                    $data['recentUsers'] = $this->userModel->orderBy('created_at', 'DESC')->findAll(10);
                    return view('dashboard/admin', $data);

                case 'teacher':
                    $data['students'] = $this->userModel->getUsersByRole('student');
                    return view('dashboard/teacher', $data);

                case 'student':
                    return view('dashboard/student', $data);

                default:
                    session()->destroy();
                    return redirect()->to(base_url('login'))->with('error', 'Invalid role');
            }
        } catch (\Exception $e) {
            log_message('error', 'Dashboard error: ' . $e->getMessage());
            return redirect()->to(base_url('login'))->with('error', 'An error occurred. Please try again.');
        }

    }
}