<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MaterialSeeder extends Seeder
{
    public function run()
    {
        // Clear existing materials first
        $this->db->table('materials')->truncate();

        // Get the actual writable path dynamically
        $basePath = WRITEPATH . 'uploads';
        $uploadPath = $basePath . DIRECTORY_SEPARATOR . 'materials' . DIRECTORY_SEPARATOR;

        echo "Base path: " . $basePath . "\n";
        echo "Upload path: " . $uploadPath . "\n";

        // Create base uploads directory first
        if (!is_dir($basePath)) {
            if (mkdir($basePath, 0777, true)) {
                echo "Created base directory: " . $basePath . "\n";
            } else {
                echo "ERROR: Could not create base directory\n";
                return;
            }
        }

        // Create materials directory
        if (!is_dir($uploadPath)) {
            if (mkdir($uploadPath, 0777, true)) {
                echo "Created materials directory: " . $uploadPath . "\n";
            } else {
                echo "ERROR: Could not create materials directory\n";
                return;
            }
        }

        // Set permissions
        @chmod($basePath, 0777);
        @chmod($uploadPath, 0777);

        // Define materials
        $materials = [
            [
                'course_id' => 1,
                'file_name' => 'Laboratory Exercise 7 FILE UPLOADS (COURSE MATERIALS-sample.docx',
                'stored_name' => 'sample_lab_exercise.docx',
            ],
            [
                'course_id' => 1,
                'file_name' => 'Calculus Exercise Set 1.docx',
                'stored_name' => 'calculus_exercises.docx',
            ],
            [
                'course_id' => 2,
                'file_name' => 'Physics Lab Manual Chapter 1.pdf',
                'stored_name' => 'physics_lab_manual.pdf',
            ],
            [
                'course_id' => 3,
                'file_name' => 'HTML CSS JavaScript Guide.pdf',
                'stored_name' => 'web_dev_guide.pdf',
            ],
            [
                'course_id' => 2,
                'file_name' => 'Motion and Forces Presentation.pptx',
                'stored_name' => 'motion_forces.pptx',
            ],
        ];

        $insertData = [];
        $filesCreated = 0;

        foreach ($materials as $material) {
            $filePath = $uploadPath . $material['stored_name'];

            // Generate content
            $content = $this->generateFileContent($material['file_name']);

            // Create the actual file
            $result = @file_put_contents($filePath, $content);

            if ($result !== false) {
                @chmod($filePath, 0666);
                echo "✓ Created: " . $material['stored_name'] . " (" . strlen($content) . " bytes)\n";
                $filesCreated++;

                // Add to database insert array
                $insertData[] = [
                    'course_id' => $material['course_id'],
                    'file_name' => $material['file_name'],
                    'file_path' => $filePath,
                    'created_at' => date('Y-m-d H:i:s'),
                ];
            } else {
                echo "✗ FAILED: " . $material['stored_name'] . "\n";
                echo "  Path: " . $filePath . "\n";
            }
        }

        // Insert into database
        if (!empty($insertData)) {
            $this->db->table('materials')->insertBatch($insertData);
            echo "\n========================================\n";
            echo "SUCCESS!\n";
            echo "Files created: " . $filesCreated . "/" . count($materials) . "\n";
            echo "Database records inserted: " . count($insertData) . "\n";
            echo "Location: " . $uploadPath . "\n";
            echo "========================================\n";
        } else {
            echo "\nERROR: No files were created!\n";
        }
    }

    /**
     * Generate file content
     */
    private function generateFileContent($fileName)
    {
        $timestamp = date('Y-m-d H:i:s');

        $content = "========================================\n";
        $content .= "LMS COURSE MATERIAL\n";
        $content .= "========================================\n\n";
        $content .= "File: " . $fileName . "\n";
        $content .= "Generated: " . $timestamp . "\n\n";
        $content .= "----------------------------------------\n\n";
        $content .= "This is a sample course material file.\n\n";
        $content .= "COURSE CONTENT:\n\n";
        $content .= "1. Introduction\n";
        $content .= "   - Overview of the topic\n";
        $content .= "   - Learning objectives\n\n";
        $content .= "2. Main Content\n";
        $content .= "   - Detailed explanations\n";
        $content .= "   - Examples and demonstrations\n\n";
        $content .= "3. Summary\n";
        $content .= "   - Key takeaways\n";
        $content .= "   - Review questions\n\n";
        $content .= "========================================\n";

        // Add extra content to make file larger
        $content .= "\n" . str_repeat("Lorem ipsum dolor sit amet. ", 100) . "\n";

        return $content;
    }
}