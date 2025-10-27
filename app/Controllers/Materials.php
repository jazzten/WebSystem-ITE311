<?php

namespace App\Controllers;

use App\Models\MaterialModel;
use App\Models\CourseModel;
use App\Models\EnrollmentModel;
use CodeIgniter\Controller;

class Materials extends Controller
{
    protected $materialModel;
    protected $courseModel;
    protected $enrollmentModel;

    public function __construct()
    {
        $this->materialModel = new MaterialModel();
        $this->courseModel = new CourseModel();
        $this->enrollmentModel = new EnrollmentModel();
        helper(['form', 'url', 'download']);
    }

    /**
     * Display upload form and handle file upload
     * 
     * @param int $courseId
     * @return mixed
     */
    public function upload($courseId)
    {
        // Check if user is logged in and is admin or teacher
        if (!session()->get('isLoggedIn')) {
            return redirect()->to(base_url('login'))->with('error', 'Please login first');
        }

        $role = session()->get('role');
        if ($role !== 'admin' && $role !== 'teacher') {
            return redirect()->to(base_url('dashboard'))->with('error', 'Unauthorized access');
        }

        // Verify course exists
        $course = $this->courseModel->find($courseId);
        if (!$course) {
            return redirect()->to(base_url('dashboard'))->with('error', 'Course not found');
        }

        // Handle POST request (file upload)
        if ($this->request->getMethod() === 'post') {
            return $this->handleUpload($courseId);
        }

        // Display upload form
        $data = [
            'user' => [
                'name' => session()->get('name'),
                'role' => session()->get('role'),
            ],
            'course' => $course,
            'materials' => $this->materialModel->getMaterialsByCourse($courseId)
        ];

        return view('materials/upload', $data);
    }

    /**
     * Handle the file upload process
     * 
     * @param int $courseId
     * @return mixed
     */
    private function handleUpload($courseId)
    {
        $validationRule = [
            'material_file' => [
                'label' => 'Material File',
                'rules' => [
                    'uploaded[material_file]',
                    'max_size[material_file,10240]', // 10MB
                    'ext_in[material_file,pdf,doc,docx,ppt,pptx,xls,xlsx,zip,txt]',
                ],
                'errors' => [
                    'uploaded' => 'Please select a file to upload',
                    'max_size' => 'File size cannot exceed 10MB',
                    'ext_in' => 'Only PDF, DOC, DOCX, PPT, PPTX, XLS, XLSX, ZIP, and TXT files are allowed'
                ]
            ],
        ];

        if (!$this->validate($validationRule)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $file = $this->request->getFile('material_file');

        if (!$file->isValid()) {
            return redirect()->back()->with('error', 'Invalid file upload');
        }

        try {
            // Create uploads directory if it doesn't exist
            $uploadPath = WRITEPATH . 'uploads/materials/';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            // Generate unique filename
            $newName = $file->getRandomName();
            
            // Move file to upload directory
            $file->move($uploadPath, $newName);

            // Save to database
            $materialData = [
                'course_id' => $courseId,
                'file_name' => $file->getClientName(),
                'file_path' => $uploadPath . $newName,
            ];

            $insertId = $this->materialModel->insertMaterial($materialData);

            if ($insertId) {
                return redirect()->to(base_url('materials/upload/' . $courseId))
                    ->with('success', 'Material uploaded successfully!');
            } else {
                // Delete uploaded file if database insert fails
                if (file_exists($uploadPath . $newName)) {
                    unlink($uploadPath . $newName);
                }
                return redirect()->back()->with('error', 'Failed to save material to database');
            }
        } catch (\Exception $e) {
            log_message('error', 'Upload Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred during upload: ' . $e->getMessage());
        }
    }

    /**
     * Delete a material
     * 
     * @param int $materialId
     * @return mixed
     */
    public function delete($materialId)
    {
        // Check if user is logged in and is admin or teacher
        if (!session()->get('isLoggedIn')) {
            return redirect()->to(base_url('login'))->with('error', 'Please login first');
        }

        $role = session()->get('role');
        if ($role !== 'admin' && $role !== 'teacher') {
            return redirect()->to(base_url('dashboard'))->with('error', 'Unauthorized access');
        }

        $material = $this->materialModel->find($materialId);
        if (!$material) {
            return redirect()->back()->with('error', 'Material not found');
        }

        try {
            // Delete file from filesystem
            if (file_exists($material['file_path'])) {
                unlink($material['file_path']);
            }

            // Delete from database
            if ($this->materialModel->delete($materialId)) {
                return redirect()->to(base_url('materials/upload/' . $material['course_id']))
                    ->with('success', 'Material deleted successfully!');
            } else {
                return redirect()->back()->with('error', 'Failed to delete material');
            }
        } catch (\Exception $e) {
            log_message('error', 'Delete Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    /**
     * Download a material (for enrolled students)
     * 
     * @param int $materialId
     * @return mixed
     */
    public function download($materialId)
    {
        // Check if user is logged in
        if (!session()->get('isLoggedIn')) {
            return redirect()->to(base_url('login'))->with('error', 'Please login first');
        }

        $userId = session()->get('id');
        $role = session()->get('role');

        // Get material details
        $material = $this->materialModel->find($materialId);
        if (!$material) {
            return redirect()->back()->with('error', 'Material not found');
        }

        // Check if user has access to this material
        // Admin and teachers can download any material
        // Students can only download materials from enrolled courses
        if ($role === 'student') {
            $isEnrolled = $this->enrollmentModel->isAlreadyEnrolled($userId, $material['course_id']);
            if (!$isEnrolled) {
                return redirect()->back()->with('error', 'You must be enrolled in this course to download materials');
            }
        }

        // Check if file exists
        if (!file_exists($material['file_path'])) {
            log_message('error', 'File not found: ' . $material['file_path']);
            return redirect()->back()->with('error', 'File not found on server');
        }

        // Force download
        return $this->response->download($material['file_path'], null)->setFileName($material['file_name']);
    }

    /**
     * View materials for a specific course (for students)
     * 
     * @param int $courseId
     * @return mixed
     */
    public function view($courseId)
    {
        // Check if user is logged in
        if (!session()->get('isLoggedIn')) {
            return redirect()->to(base_url('login'))->with('error', 'Please login first');
        }

        $userId = session()->get('id');
        $role = session()->get('role');

        // Get course details
        $course = $this->courseModel->find($courseId);
        if (!$course) {
            return redirect()->back()->with('error', 'Course not found');
        }

        // Check if student is enrolled (skip for admin/teacher)
        if ($role === 'student') {
            $isEnrolled = $this->enrollmentModel->isAlreadyEnrolled($userId, $courseId);
            if (!$isEnrolled) {
                return redirect()->to(base_url('dashboard'))->with('error', 'You must be enrolled in this course');
            }
        }

        $data = [
            'user' => [
                'name' => session()->get('name'),
                'role' => session()->get('role'),
            ],
            'course' => $course,
            'materials' => $this->materialModel->getMaterialsByCourse($courseId)
        ];

        return view('materials/view', $data);
    }
}
