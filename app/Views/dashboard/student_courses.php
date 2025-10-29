<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Courses - LMS</title>
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
                        <p class="text-sm text-purple-300">Hello, <?= esc($user['name']) ?> (Student)</p>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="<?= base_url('dashboard') ?>" class="text-gray-300 hover:text-white px-4 py-2 rounded-lg hover:bg-slate-700 transition-all">
                        <i class="fas fa-home mr-2"></i>Dashboard
                    </a>
                    <a href="<?= base_url('dashboard/my-courses') ?>" class="text-white bg-purple-600 px-4 py-2 rounded-lg">
                        <i class="fas fa-book mr-2"></i>My Courses
                    </a>
                    <a href="<?= base_url('dashboard/my-grades') ?>" class="text-gray-300 hover:text-white px-4 py-2 rounded-lg hover:bg-slate-700 transition-all">
                        <i class="fas fa-star mr-2"></i>My Grades
                    </a>

                    <!-- ✅ ADD NOTIFICATION BELL HERE -->
                        <?php include(APPPATH . 'Views/includes/notification_bell.php'); ?>

                    <a href="<?= base_url('logout') ?>" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg flex items-center space-x-2 transition-all">
                        <i class="fas fa-sign-out-alt"></i><span>Logout</span>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-2xl shadow-xl p-6 border border-purple-500/20 mb-6">
            <h2 class="text-2xl font-bold text-white mb-2">My Courses</h2>
            <p class="text-purple-300">View all your enrolled courses and progress</p>
        </div>

        <!-- Courses Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6">
            <?php foreach ($courses as $course): ?>
            <div class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-xl shadow-xl p-6 border border-purple-500/20 hover:border-purple-400/50 transition-all">
                <div class="flex items-start justify-between mb-4">
                    <div class="bg-blue-600 p-3 rounded-lg">
                        <i class="fas fa-book-open text-white text-2xl"></i>
                    </div>
                    <span class="bg-green-500/20 text-green-300 px-3 py-1 rounded-full text-sm font-semibold">
                        <?= $course['progress'] ?>% Complete
                    </span>
                </div>
                
                <h3 class="text-xl font-bold text-white mb-2"><?= esc($course['name']) ?></h3>
                
                <div class="space-y-2 mb-4">
                    <div class="flex items-center text-gray-300">
                        <i class="fas fa-user-tie text-purple-400 mr-2"></i>
                        <span class="text-sm"><?= esc($course['teacher']) ?></span>
                    </div>
                </div>

                <!-- Progress Bar -->
                <div class="mb-4">
                    <div class="flex justify-between text-sm text-gray-400 mb-1">
                        <span>Progress</span>
                        <span><?= $course['progress'] ?>%</span>
                    </div>
                    <div class="w-full bg-slate-700 rounded-full h-2">
                        <div class="bg-gradient-to-r from-blue-500 to-purple-500 h-2 rounded-full transition-all" 
                             style="width: <?= $course['progress'] ?>%"></div>
                    </div>
                </div>

                <div class="flex gap-2">
                    <button onclick="viewCourse(<?= $course['id'] ?>)" 
                            class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-all">
                        <i class="fas fa-eye mr-1"></i>View Course
                    </button>
                    <button onclick="viewMaterials(<?= $course['id'] ?>)" 
                            class="flex-1 bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg transition-all">
                        <i class="fas fa-folder mr-1"></i>Materials
                    </button>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </main>

    <script>
        function viewCourse(id) {
            alert('View course details #' + id + ' - Feature coming soon!');
        }

        function viewMaterials(id) {
            alert('View course materials #' + id + ' - Feature coming soon!');
        }
    </script>
</body>
</html>