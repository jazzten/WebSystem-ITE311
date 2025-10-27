<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Courses - LMS</title>
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
                    <?php if ($user['role'] === 'admin'): ?>
                    <a href="<?= base_url('dashboard/manage-users') ?>" class="text-gray-300 hover:text-white px-4 py-2 rounded-lg hover:bg-slate-700 transition-all">
                        <i class="fas fa-users mr-2"></i>Manage Users
                    </a>
                    <?php endif; ?>
                    <a href="<?= base_url('dashboard/manage-courses') ?>" class="text-white bg-purple-600 px-4 py-2 rounded-lg">
                        <i class="fas fa-book mr-2"></i>Manage Courses
                    </a>
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
            <div class="flex justify-between items-center">
                <div>
                    <h2 class="text-2xl font-bold text-white mb-2">Manage Courses</h2>
                    <p class="text-purple-300">View and manage all course materials</p>
                </div>
            </div>
        </div>

        <!-- Flash Messages -->
        <?php if (session()->getFlashdata('success')): ?>
            <div class="bg-green-500/20 border border-green-500 text-green-300 px-4 py-3 rounded-lg mb-4">
                <i class="fas fa-check-circle mr-2"></i><?= esc(session()->getFlashdata('success')) ?>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="bg-red-500/20 border border-red-500 text-red-300 px-4 py-3 rounded-lg mb-4">
                <i class="fas fa-exclamation-circle mr-2"></i><?= esc(session()->getFlashdata('error')) ?>
            </div>
        <?php endif; ?>

        <!-- Courses Grid -->
        <?php if (empty($courses)): ?>
            <div class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-2xl shadow-xl p-12 border border-purple-500/20 text-center">
                <i class="fas fa-book-open text-6xl text-gray-600 mb-4"></i>
                <p class="text-gray-400 text-lg">No courses available</p>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ($courses as $course): ?>
                <div class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-xl shadow-xl p-6 border border-purple-500/20 hover:border-purple-400/50 transition-all">
                    <div class="flex items-start justify-between mb-4">
                        <div class="bg-purple-600 p-3 rounded-lg">
                            <i class="fas fa-book-open text-white text-2xl"></i>
                        </div>
                        <span class="bg-blue-500/20 text-blue-300 px-3 py-1 rounded-full text-sm font-semibold">
                            <?= esc($course['course_code']) ?>
                        </span>
                    </div>

                    <h3 class="text-xl font-bold text-white mb-2"><?= esc($course['course_name']) ?></h3>

                    <div class="space-y-2 mb-4">
                        <?php if (isset($course['teacher_name'])): ?>
                        <div class="flex items-center text-gray-300">
                            <i class="fas fa-user-tie text-purple-400 mr-2"></i>
                            <span class="text-sm"><?= esc($course['teacher_name']) ?></span>
                        </div>
                        <?php endif; ?>

                        <?php if (!empty($course['schedule'])): ?>
                        <div class="flex items-center text-gray-300">
                            <i class="fas fa-clock text-purple-400 mr-2"></i>
                            <span class="text-sm"><?= esc($course['schedule']) ?></span>
                        </div>
                        <?php endif; ?>

                        <?php if (!empty($course['description'])): ?>
                        <div class="flex items-start text-gray-300 mt-3">
                            <i class="fas fa-info-circle text-purple-400 mr-2 mt-1"></i>
                            <span class="text-sm"><?= esc(substr($course['description'], 0, 100)) ?><?= strlen($course['description']) > 100 ? '...' : '' ?></span>
                        </div>
                        <?php endif; ?>
                    </div>

                    <div class="grid grid-cols-2 gap-2">
                        <a href="<?= base_url('materials/upload/' . $course['id']) ?>"
                            class="bg-green-600 hover:bg-green-700 text-white px-3 py-2 rounded-lg transition-all text-sm text-center">
                            <i class="fas fa-upload mr-1"></i>Upload
                        </a>
                        <a href="<?= base_url('materials/view/' . $course['id']) ?>"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded-lg transition-all text-sm text-center">
                            <i class="fas fa-eye mr-1"></i>View
                        </a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </main>
</body>
</html>