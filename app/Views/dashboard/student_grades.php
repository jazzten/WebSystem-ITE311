<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Grades - LMS</title>
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
                    <a href="<?= base_url('dashboard/my-courses') ?>" class="text-gray-300 hover:text-white px-4 py-2 rounded-lg hover:bg-slate-700 transition-all">
                        <i class="fas fa-book mr-2"></i>My Courses
                    </a>
                    <a href="<?= base_url('dashboard/my-grades') ?>" class="text-white bg-purple-600 px-4 py-2 rounded-lg">
                        <i class="fas fa-star mr-2"></i>My Grades
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
        <!-- Header Section -->
        <div class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-2xl shadow-xl p-6 border border-purple-500/20 mb-6">
            <h2 class="text-2xl font-bold text-white mb-2">My Grades</h2>
            <p class="text-purple-300">View your academic performance and grades</p>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
            <div class="bg-gradient-to-br from-green-600 to-green-700 rounded-xl p-6">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-white font-semibold">Overall GPA</h3>
                    <i class="fas fa-chart-line text-green-200 text-2xl"></i>
                </div>
                <p class="text-4xl font-bold text-white">3.5</p>
                <p class="text-green-200 text-sm mt-1">Out of 4.0</p>
            </div>

            <div class="bg-gradient-to-br from-blue-600 to-blue-700 rounded-xl p-6">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-white font-semibold">Average Score</h3>
                    <i class="fas fa-percentage text-blue-200 text-2xl"></i>
                </div>
                <p class="text-4xl font-bold text-white">87%</p>
                <p class="text-blue-200 text-sm mt-1">All courses</p>
            </div>

            <div class="bg-gradient-to-br from-purple-600 to-purple-700 rounded-xl p-6">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-white font-semibold">Completed</h3>
                    <i class="fas fa-check-circle text-purple-200 text-2xl"></i>
                </div>
                <p class="text-4xl font-bold text-white">24</p>
                <p class="text-purple-200 text-sm mt-1">Assignments</p>
            </div>

            <div class="bg-gradient-to-br from-orange-600 to-orange-700 rounded-xl p-6">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-white font-semibold">Pending</h3>
                    <i class="fas fa-clock text-orange-200 text-2xl"></i>
                </div>
                <p class="text-4xl font-bold text-white">7</p>
                <p class="text-orange-200 text-sm mt-1">To submit</p>
            </div>
        </div>

        <!-- Grades Table -->
        <div class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-2xl shadow-xl p-6 border border-purple-500/20">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-bold text-white">Recent Grades</h3>
                <button onclick="exportGrades()" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg transition-all">
                    <i class="fas fa-download mr-2"></i>Export Report
                </button>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-purple-500/20">
                            <th class="text-left py-3 px-4 text-purple-300 font-semibold">Course</th>
                            <th class="text-left py-3 px-4 text-purple-300 font-semibold">Assignment</th>
                            <th class="text-left py-3 px-4 text-purple-300 font-semibold">Score</th>
                            <th class="text-left py-3 px-4 text-purple-300 font-semibold">Grade</th>
                            <th class="text-left py-3 px-4 text-purple-300 font-semibold">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($grades as $grade): ?>
                        <tr class="border-b border-slate-700 hover:bg-slate-700/50 transition-colors">
                            <td class="py-3 px-4 text-gray-300"><?= esc($grade['course']) ?></td>
                            <td class="py-3 px-4 text-gray-300"><?= esc($grade['assignment']) ?></td>
                            <td class="py-3 px-4 text-gray-300">
                                <span class="font-semibold"><?= $grade['score'] ?>%</span>
                            </td>
                            <td class="py-3 px-4">
                                <span class="px-3 py-1 rounded-full text-sm font-semibold
                                    <?= $grade['grade'][0] == 'A' ? 'bg-green-500/20 text-green-300' :
                                        ($grade['grade'][0] == 'B' ? 'bg-blue-500/20 text-blue-300' : 'bg-yellow-500/20 text-yellow-300') ?>">
                                    <?= esc($grade['grade']) ?>
                                </span>
                            </td>
                            <td class="py-3 px-4">
                                <span class="px-3 py-1 rounded-full text-sm bg-green-500/20 text-green-300">
                                    <i class="fas fa-check mr-1"></i>Graded
                                </span>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <script>
        function exportGrades() {
            alert('Export grades report - Feature coming soon!');
        }
    </script>
</body>
</html>