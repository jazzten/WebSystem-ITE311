<?php
/**
 * Standalone Upload Diagnostic Test Script
 * Save as: public/test_upload.php
 * Run: http://localhost/ITE311-BRIAN/public/test_upload.php
 */

// Define paths manually
$publicPath = __DIR__; // Current directory (public/)
$rootPath = dirname($publicPath); // One level up (project root)
$writablePath = $rootPath . DIRECTORY_SEPARATOR . 'writable' . DIRECTORY_SEPARATOR;
$uploadsPath = $writablePath . 'uploads' . DIRECTORY_SEPARATOR;
$materialsPath = $uploadsPath . 'materials' . DIRECTORY_SEPARATOR;

// Paths to check
$paths = [
    'Public Folder' => $publicPath,
    'Project Root' => $rootPath,
    'Writable Folder' => $writablePath,
    'Uploads Folder' => $uploadsPath,
    'Materials Folder' => $materialsPath,
];

?>
<!DOCTYPE html>
<html>
<head>
    <title>Upload Diagnostic Test</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; background: #f5f5f5; }
        .container { max-width: 900px; margin: 0 auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h1 { color: #333; border-bottom: 3px solid #4CAF50; padding-bottom: 10px; }
        h2 { color: #555; margin-top: 30px; }
        .path-check { background: #f9f9f9; padding: 15px; margin: 10px 0; border-left: 4px solid #2196F3; border-radius: 4px; }
        .path-check h3 { margin-top: 0; color: #2196F3; }
        .success { color: #4CAF50; font-weight: bold; }
        .error { color: #f44336; font-weight: bold; }
        .warning { color: #ff9800; font-weight: bold; }
        code { background: #e8e8e8; padding: 2px 6px; border-radius: 3px; font-family: 'Courier New', monospace; }
        pre { background: #263238; color: #aed581; padding: 15px; border-radius: 4px; overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; margin: 15px 0; }
        table td { padding: 8px; border-bottom: 1px solid #ddd; }
        table td:first-child { font-weight: bold; width: 150px; }
        .fix-box { background: #fff3cd; border: 1px solid #ffc107; padding: 15px; border-radius: 4px; margin: 20px 0; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔍 Upload Directory Diagnostic</h1>
        <p><strong>Current Time:</strong> <?= date('Y-m-d H:i:s') ?></p>
        <p><strong>PHP Version:</strong> <?= PHP_VERSION ?></p>
        <p><strong>Operating System:</strong> <?= PHP_OS ?></p>
        <hr>

        <h2>📁 Directory Paths</h2>
        <?php foreach ($paths as $name => $path): ?>
            <div class="path-check">
                <h3><?= $name ?></h3>
                <table>
                    <tr>
                        <td>Path:</td>
                        <td><code><?= htmlspecialchars($path) ?></code></td>
                    </tr>
                    <tr>
                        <td>Exists:</td>
                        <td>
                            <?php if (is_dir($path)): ?>
                                <span class="success">✅ Yes</span>
                            <?php else: ?>
                                <span class="error">❌ No</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Writable:</td>
                        <td>
                            <?php if (is_dir($path) && is_writable($path)): ?>
                                <span class="success">✅ Yes</span>
                            <?php elseif (!is_dir($path)): ?>
                                <span class="warning">⚠️ N/A (doesn't exist)</span>
                            <?php else: ?>
                                <span class="error">❌ No</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Readable:</td>
                        <td>
                            <?php if (is_dir($path) && is_readable($path)): ?>
                                <span class="success">✅ Yes</span>
                            <?php elseif (!is_dir($path)): ?>
                                <span class="warning">⚠️ N/A (doesn't exist)</span>
                            <?php else: ?>
                                <span class="error">❌ No</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php if (is_dir($path)): ?>
                    <tr>
                        <td>Permissions:</td>
                        <td><code><?= substr(sprintf('%o', fileperms($path)), -4) ?></code></td>
                    </tr>
                    <?php endif; ?>
                </table>
            </div>
        <?php endforeach; ?>

        <h2>🛠️ Auto-Fix Attempt</h2>
        <?php
        $created = false;
        $createError = null;
        
        if (!is_dir($materialsPath)) {
            echo "<p class='warning'>⚠️ Materials folder doesn't exist. Attempting to create...</p>";
            
            if (@mkdir($materialsPath, 0777, true)) {
                echo "<p class='success'>✅ Successfully created: <code>" . htmlspecialchars($materialsPath) . "</code></p>";
                $created = true;
                
                // Try to set permissions
                @chmod($materialsPath, 0777);
            } else {
                $createError = error_get_last();
                echo "<p class='error'>❌ Failed to create directory</p>";
                if ($createError) {
                    echo "<p>Error: " . htmlspecialchars($createError['message']) . "</p>";
                }
            }
        } else {
            echo "<p class='success'>✅ Materials folder already exists</p>";
        }
        ?>

        <h2>🧪 Write Permission Test</h2>
        <?php
        $testFile = $materialsPath . 'test_' . time() . '.txt';
        $testContent = "Test upload at " . date('Y-m-d H:i:s');
        $writeSuccess = false;

        if (is_dir($materialsPath)) {
            if (@file_put_contents($testFile, $testContent)) {
                echo "<p class='success'>✅ Write test SUCCESSFUL!</p>";
                echo "<p><strong>Test file created:</strong> <code>" . htmlspecialchars($testFile) . "</code></p>";
                $writeSuccess = true;
                
                // Clean up test file
                if (@unlink($testFile)) {
                    echo "<p class='success'>✅ Test file deleted (cleanup successful)</p>";
                } else {
                    echo "<p class='warning'>⚠️ Test file could not be deleted automatically</p>";
                }
            } else {
                echo "<p class='error'>❌ Write test FAILED!</p>";
                echo "<p>The application cannot write to this directory.</p>";
                $lastError = error_get_last();
                if ($lastError) {
                    echo "<p>Error: " . htmlspecialchars($lastError['message']) . "</p>";
                }
            }
        } else {
            echo "<p class='error'>❌ Cannot test - materials folder doesn't exist</p>";
        }
        ?>

        <?php if (!$writeSuccess): ?>
        <div class="fix-box">
            <h2>🔧 How to Fix (Windows)</h2>
            <p><strong>Option 1: PowerShell (Recommended)</strong></p>
            <p>Run this command in <strong>PowerShell as Administrator</strong>:</p>
            <pre>cd <?= htmlspecialchars($rootPath) ?>

icacls "writable\uploads\materials" /grant Everyone:F /T</pre>

            <p><strong>Option 2: File Explorer (GUI)</strong></p>
            <ol>
                <li>Navigate to: <code><?= htmlspecialchars($materialsPath) ?></code></li>
                <li>Right-click the folder → Properties</li>
                <li>Go to Security tab → Edit</li>
                <li>Select "Users" or "Everyone"</li>
                <li>Check "Full Control"</li>
                <li>Click Apply → OK</li>
            </ol>

            <p><strong>Option 3: Create Manually</strong></p>
            <ol>
                <li>Open File Explorer</li>
                <li>Navigate to: <code><?= htmlspecialchars($writablePath) ?></code></li>
                <li>Create folder: <code>uploads</code></li>
                <li>Inside uploads, create folder: <code>materials</code></li>
                <li>Apply permissions as shown above</li>
            </ol>
        </div>
        <?php endif; ?>

        <h2>📋 Summary</h2>
        <table>
            <tr>
                <td>Materials folder exists:</td>
                <td><?= is_dir($materialsPath) ? '<span class="success">✅ Yes</span>' : '<span class="error">❌ No</span>' ?></td>
            </tr>
            <tr>
                <td>Materials folder writable:</td>
                <td><?= is_writable($materialsPath) ? '<span class="success">✅ Yes</span>' : '<span class="error">❌ No</span>' ?></td>
            </tr>
            <tr>
                <td>Write test passed:</td>
                <td><?= $writeSuccess ? '<span class="success">✅ Yes</span>' : '<span class="error">❌ No</span>' ?></td>
            </tr>
            <tr>
                <td><strong>Status:</strong></td>
                <td>
                    <?php if ($writeSuccess): ?>
                        <span class="success"><strong>✅ READY TO UPLOAD FILES</strong></span>
                    <?php else: ?>
                        <span class="error"><strong>❌ NEEDS FIXING</strong></span>
                    <?php endif; ?>
                </td>
            </tr>
        </table>

        <?php if ($writeSuccess): ?>
            <div style="background: #d4edda; border: 1px solid #c3e6cb; padding: 15px; border-radius: 4px; margin-top: 20px;">
                <h3 style="color: #155724; margin-top: 0;">✅ All Tests Passed!</h3>
                <p>Your upload directory is properly configured. You can now:</p>
                <ol>
                    <li>Delete this test file: <code>public/test_upload.php</code></li>
                    <li>Try uploading materials as a teacher</li>
                    <li>Files should now save to: <code><?= htmlspecialchars($materialsPath) ?></code></li>
                </ol>
            </div>
        <?php endif; ?>

        <hr>
        <p style="text-align: center; color: #999; font-size: 12px;">
            <small>Diagnostic completed at <?= date('Y-m-d H:i:s') ?></small>
        </p>
    </div>
</body>
</html>