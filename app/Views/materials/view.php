
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Materials - LMS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gradient-to-br from-slate-900 via-purple-900 to-slate-900 min-h-screen">
    <!-- Header -->
    <header class="bg-gradient-to-r from-slate-800 to-slate-900 shadow-2xl border-b border-purple-500/20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-3">
                    <i class="fas fa-graduation-cap text-purple-400 text-3xl"></i>
                    <div>
                        <h1 class="text-2xl font-bold text-white">LMS</h1>
                        <p class="text-sm text-purple-300">Hello, <?= esc($user['name']) ?> (<?= ucfirst($user['role']) ?>)</p>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="<?= base_url('dashboard') ?>" class="text-gray-300 hover:text-white px-4 py-2 rounded-lg hover:bg-slate-700 transition-all">
                        <i class="fas fa-home mr-2"></i>Dashboard
                    </a>
                    <?php if ($user['role'] === 'student'): ?>
                        <a href="<?= base_url('dashboard/my-courses') ?>" class="text-gray-300 hover:text-white px-4 py-2 rounded-lg hover:bg-slate-700 transition-all">
                            <i class="fas fa-book mr-2"></i>My Courses
                        </a>
                    <?php endif; ?>
                    <a href="<?= base_url('logout') ?>" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg flex items-center space-x-2 transition-all">
                        <i class="fas fa-sign-out-alt"></i><span>Logout</span>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Page Title -->
        <div class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-2xl shadow-xl p-6 border border-purple-500/20 mb-6">
            <h2 class="text-2xl font-bold text-white mb-2">Course Materials</h2>
            <p class="text-purple-300"><?= esc($course['course_name']) ?> (<?= esc($course['course_code']) ?>)</p>
        </div>

        <!-- Flash Messages -->
        <?php if (session()->getFlashdata('error')): ?>
            <div class="bg-red-500/20 border border-red-500 text-red-300 px-4 py-3 rounded-lg mb-4">
                <i class="fas fa-exclamation-circle mr-2"></i><?= esc(session()->getFlashdata('error')) ?>
            </div>
        <?php endif; ?>

        <!-- Materials Grid -->
        <div class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-2xl shadow-xl p-6 border border-purple-500/20">
            <h3 class="text-xl font-bold text-white mb-4">Available Materials</h3>

            <?php if (empty($materials)): ?>
                <div class="text-center py-12 text-gray-400">
                    <i class="fas fa-folder-open text-6xl mb-4 opacity-50"></i>
                    <p class="text-lg">No materials available for this course yet</p>
                    <p class="text-sm mt-2">Check back later for updates</p>
                </div>
            <?php else: ?>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <?php foreach ($materials as $material): ?>
                        <div class="bg-slate-700/50 rounded-lg p-4 hover:bg-slate-700 transition-all border border-purple-500/20 hover:border-purple-500/50">
                            <div class="flex items-start space-x-3 mb-3">
                                <div class="bg-purple-600 p-3 rounded-lg flex-shrink-0">
                                    <?php
                                    $extension = pathinfo($material['file_name'], PATHINFO_EXTENSION);
                                    $icon = 'fa-file';
                                    if (in_array($extension, ['pdf'])) $icon = 'fa-file-pdf';
                                    elseif (in_array($extension, ['doc', 'docx'])) $icon = 'fa-file-word';
                                    elseif (in_array($extension, ['ppt', 'pptx'])) $icon = 'fa-file-powerpoint';
                                    elseif (in_array($extension, ['xls', 'xlsx'])) $icon = 'fa-file-excel';
                                    elseif (in_array($extension, ['zip'])) $icon = 'fa-file-archive';
                                    ?>
                                    <i class="fas <?= $icon ?> text-white text-2xl"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h4 class="text-white font-semibold mb-1 break-words"><?= esc($material['file_name']) ?></h4>
                                    <p class="text-xs text-gray-400">
                                        <i class="fas fa-clock mr-1"></i>
                                        <?= date('M d, Y', strtotime($material['created_at'])) ?>
                                    </p>
                                </div>
                            </div>
                            <a href="<?= base_url('materials/download/' . $material['id']) ?>" 
                            class="block w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-all text-center">
                                <i class="fas fa-download mr-2"></i>Download
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </main>
</body>
</html>
