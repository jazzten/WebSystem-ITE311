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
            // ✅ Use WRITEPATH constant for consistency
            $uploadPath = WRITEPATH . 'uploads' . DIRECTORY_SEPARATOR . 'materials' . DIRECTORY_SEPARATOR;
            
            // ✅ Ensure directory exists with proper permissions
            if (!is_dir($uploadPath)) {
                if (!mkdir($uploadPath, 0777, true)) {
                    log_message('error', 'Failed to create directory: ' . $uploadPath);
                    return redirect()->back()->with('error', 'Failed to create upload directory');
                }
                chmod($uploadPath, 0777);
            }

            // ✅ Check if directory is writable
            if (!is_writable($uploadPath)) {
                @chmod($uploadPath, 0777);
                if (!is_writable($uploadPath)) {
                    log_message('error', 'Upload directory not writable: ' . $uploadPath);
                    return redirect()->back()->with('error', 'Upload directory is not writable');
                }
            }

            // Generate unique filename with timestamp
            $originalName = $file->getClientName();
            $extension = $file->getClientExtension();
            $newName = time() . '_' . preg_replace('/[^a-zA-Z0-9_.-]/', '_', pathinfo($originalName, PATHINFO_FILENAME)) . '.' . $extension;
            
            log_message('info', 'Attempting to upload file to: ' . $uploadPath . $newName);
            
            // ✅ Move file with error handling
            if (!$file->move($uploadPath, $newName)) {
                $error = $file->getErrorString() . ' (' . $file->getError() . ')';
                log_message('error', 'File move failed: ' . $error);
                return redirect()->back()->with('error', 'Failed to move uploaded file: ' . $error);
            }

            // ✅ Verify file was actually moved
            $fullPath = $uploadPath . $newName;
            if (!file_exists($fullPath)) {
                log_message('error', 'File not found after move: ' . $fullPath);
                return redirect()->back()->with('error', 'File upload verification failed');
            }

            log_message('info', 'File successfully uploaded to: ' . $fullPath);

            // ✅ Save to database with ABSOLUTE path
            $materialData = [
                'course_id' => $courseId,
                'file_name' => $originalName,
                'file_path' => $fullPath, // Store absolute path
                'created_at' => date('Y-m-d H:i:s')
            ];

            $insertId = $this->materialModel->insertMaterial($materialData);

            if ($insertId) {
                log_message('info', 'Material record saved to database. ID: ' . $insertId);
                return redirect()->to(base_url('materials/upload/' . $courseId))
                    ->with('success', 'Material uploaded successfully! File: ' . $originalName);
            } else {
                // Delete uploaded file if database insert fails
                if (file_exists($fullPath)) {
                    unlink($fullPath);
                    log_message('error', 'Database insert failed, file deleted: ' . $fullPath);
                }
                return redirect()->back()->with('error', 'Failed to save material to database');
            }
        } catch (\Exception $e) {
            log_message('error', 'Upload Error: ' . $e->getMessage());
            log_message('error', 'Stack trace: ' . $e->getTraceAsString());
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
            // ✅ Resolve the file path properly
            $filePath = $this->resolveFilePath($material['file_path']);
            
            // Delete file from filesystem
            if (file_exists($filePath)) {
                if (unlink($filePath)) {
                    log_message('info', 'File deleted: ' . $filePath);
                } else {
                    log_message('warning', 'Failed to delete file: ' . $filePath);
                }
            } else {
                log_message('warning', 'File not found for deletion: ' . $filePath);
            }

            // Delete from database
            if ($this->materialModel->delete($materialId)) {
                return redirect()->to(base_url('materials/upload/' . $material['course_id']))
                    ->with('success', 'Material deleted successfully!');
            } else {
                return redirect()->back()->with('error', 'Failed to delete material from database');
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

        // ✅ Resolve the file path properly
        $filePath = $this->resolveFilePath($material['file_path']);

        // Check if file exists
        if (!file_exists($filePath)) {
            log_message('error', 'File not found for download: ' . $filePath);
            log_message('error', 'Original path from DB: ' . $material['file_path']);
            return redirect()->back()->with('error', 'File not found on server. Please contact administrator.');
        }

        // ✅ Check if file is readable
        if (!is_readable($filePath)) {
            log_message('error', 'File not readable: ' . $filePath);
            return redirect()->back()->with('error', 'File cannot be read. Please check permissions.');
        }

        log_message('info', 'User ' . $userId . ' downloading file: ' . $filePath);

        // ✅ Force download with proper error handling
        try {
            return $this->response->download($filePath, null)->setFileName($material['file_name']);
        } catch (\Exception $e) {
            log_message('error', 'Download failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to download file: ' . $e->getMessage());
        }
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

    /**
     * ✅ Helper method to resolve file paths
     * Handles both absolute paths and relative paths
     * 
     * @param string $path
     * @return string
     */
    private function resolveFilePath($path)
    {
        // If path is already absolute and exists, return it
        if (file_exists($path)) {
            return $path;
        }

        // Try with WRITEPATH
        $writePath = WRITEPATH . 'uploads' . DIRECTORY_SEPARATOR . 'materials' . DIRECTORY_SEPARATOR;
        
        // If path contains full server path, extract just the filename
        $filename = basename($path);
        $resolvedPath = $writePath . $filename;
        
        if (file_exists($resolvedPath)) {
            return $resolvedPath;
        }

        // Try treating path as relative to WRITEPATH
        if (strpos($path, 'writable') !== false) {
            // Extract path after 'writable'
            $relativePath = substr($path, strpos($path, 'writable') + 9);
            $resolvedPath = WRITEPATH . ltrim($relativePath, '/\\');
            
            if (file_exists($resolvedPath)) {
                return $resolvedPath;
            }
        }

        // Return original path as fallback
        return $path;
    }
}