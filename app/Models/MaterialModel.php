<?php

namespace App\Models;

use CodeIgniter\Model;

class MaterialModel extends Model
{
    protected $table            = 'materials';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['course_id', 'file_name', 'file_path'];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = false;

    protected $validationRules = [
        'course_id' => 'required|integer',
        'file_name' => 'required|min_length[1]|max_length[255]',
        'file_path' => 'required|min_length[1]|max_length[255]',
    ];

    /**
     * Insert a new material record
     *
     * @param array $data
     * @return int|bool Insert ID on success, false on failure
     */
    public function insertMaterial($data)
    {
        try {
            return $this->insert($data);
        } catch (\Exception $e) {
            log_message('error', 'Material Insert Error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Get all materials for a specific course
     *
     * @param int $courseId
     * @return array
     */
    public function getMaterialsByCourse($courseId)
    {
        return $this->where('course_id', $courseId)
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }

    /**
     * Get material details by ID
     *
     * @param int $materialId
     * @return array|null
     */
    public function getMaterialById($materialId)
    {
        return $this->find($materialId);
    }

    /**
     * Delete a material and return its file path
     *
     * @param int $materialId
     * @return string|false File path on success, false on failure
     */
    public function deleteMaterial($materialId)
    {
        try {
            $material = $this->find($materialId);
            if (!$material) {
                return false;
            }

            $filePath = $material['file_path'];

            if ($this->delete($materialId)) {
                return $filePath;
            }

            return false;
        } catch (\Exception $e) {
            log_message('error', 'Material Delete Error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Get materials for courses the student is enrolled in
     *
     * @param int $userId Student's user ID
     * @return array
     */
    public function getMaterialsForEnrolledCourses($userId)
    {
        return $this->select('materials.*, courses.course_name, courses.course_code')
                    ->join('courses', 'courses.id = materials.course_id')
                    ->join('enrollments', 'enrollments.course_id = courses.id')
                    ->where('enrollments.user_id', $userId)
                    ->orderBy('materials.created_at', 'DESC')
                    ->findAll();
    }
}
