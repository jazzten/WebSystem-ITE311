<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports - LMS</title>
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
                        <p class="text-sm text-purple-300">Hello, <?= esc($user['name']) ?> (Admin)</p>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="<?= base_url('dashboard') ?>" class="text-gray-300 hover:text-white px-4 py-2 rounded-lg hover:bg-slate-700 transition-all">
                        <i class="fas fa-home mr-2"></i>Dashboard
                    </a>
                    <a href="<?= base_url('dashboard/manage-users') ?>" class="text-gray-300 hover:text-white px-4 py-2 rounded-lg hover:bg-slate-700 transition-all">
                        <i class="fas fa-users mr-2"></i>Manage Users
                    </a>
                    <a href="<?= base_url('dashboard/reports') ?>" class="text-white bg-purple-600 px-4 py-2 rounded-lg">
                        <i class="fas fa-chart-bar mr-2"></i>Reports
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
        <div class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-2xl shadow-xl p-6 border border-purple-500/20 mb-6">
            <h2 class="text-2xl font-bold text-white mb-2">System Reports</h2>
            <p class="text-purple-300">Overview of system statistics and analytics</p>
        </div>

        <!-- Statistics Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
            <div class="bg-gradient-to-br from-blue-600 to-blue-700 rounded-xl p-6">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="text-white font-semibold">Total Users</h3>
                    <i class="fas fa-users text-blue-200 text-2xl"></i>
                </div>
                <p class="text-4xl font-bold text-white"><?= $totalUsers ?></p>
            </div>

            <div class="bg-gradient-to-br from-red-600 to-red-700 rounded-xl p-6">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="text-white font-semibold">Admins</h3>
                    <i class="fas fa-user-shield text-red-200 text-2xl"></i>
                </div>
                <p class="text-4xl font-bold text-white"><?= $totalAdmins ?></p>
            </div>

            <div class="bg-gradient-to-br from-green-600 to-green-700 rounded-xl p-6">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="text-white font-semibold">Teachers</h3>
                    <i class="fas fa-chalkboard-teacher text-green-200 text-2xl"></i>
                </div>
                <p class="text-4xl font-bold text-white"><?= $totalTeachers ?></p>
            </div>

            <div class="bg-gradient-to-br from-purple-600 to-purple-700 rounded-xl p-6">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="text-white font-semibold">Students</h3>
                    <i class="fas fa-user-graduate text-purple-200 text-2xl"></i>
                </div>
                <p class="text-4xl font-bold text-white"><?= $totalStudents ?></p>
            </div>
        </div>

        <!-- Report Types -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- User Distribution -->
            <div class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-2xl shadow-xl p-6 border border-purple-500/20">
                <h3 class="text-xl font-bold text-white mb-4">User Distribution</h3>
                <div class="space-y-4">
                    <div>
                        <div class="flex justify-between text-gray-300 mb-2">
                            <span>Students</span>
                            <span><?= round(($totalStudents / $totalUsers) * 100) ?>%</span>
                        </div>
                        <div class="w-full bg-slate-700 rounded-full h-3">
                            <div class="bg-purple-600 h-3 rounded-full" style="width: <?= round(($totalStudents / $totalUsers) * 100) ?>%"></div>
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-between text-gray-300 mb-2">
                            <span>Teachers</span>
                            <span><?= round(($totalTeachers / $totalUsers) * 100) ?>%</span>
                        </div>
                        <div class="w-full bg-slate-700 rounded-full h-3">
                            <div class="bg-green-600 h-3 rounded-full" style="width: <?= round(($totalTeachers / $totalUsers) * 100) ?>%"></div>
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-between text-gray-300 mb-2">
                            <span>Admins</span>
                            <span><?= round(($totalAdmins / $totalUsers) * 100) ?>%</span>
                        </div>
                        <div class="w-full bg-slate-700 rounded-full h-3">
                            <div class="bg-red-600 h-3 rounded-full" style="width: <?= round(($totalAdmins / $totalUsers) * 100) ?>%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-2xl shadow-xl p-6 border border-purple-500/20">
                <h3 class="text-xl font-bold text-white mb-4">Export Reports</h3>
                <div class="space-y-3">
                    <button onclick="exportReport('users')" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-3 rounded-lg transition-all flex items-center justify-between">
                        <span><i class="fas fa-file-excel mr-2"></i>Export All Users</span>
                        <i class="fas fa-download"></i>
                    </button>
                    <button onclick="exportReport('teachers')" class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-3 rounded-lg transition-all flex items-center justify-between">
                        <span><i class="fas fa-file-excel mr-2"></i>Export Teachers</span>
                        <i class="fas fa-download"></i>
                    </button>
                    <button onclick="exportReport('students')" class="w-full bg-purple-600 hover:bg-purple-700 text-white px-4 py-3 rounded-lg transition-all flex items-center justify-between">
                        <span><i class="fas fa-file-excel mr-2"></i>Export Students</span>
                        <i class="fas fa-download"></i>
                    </button>
                    <button onclick="exportReport('activity')" class="w-full bg-orange-600 hover:bg-orange-700 text-white px-4 py-3 rounded-lg transition-all flex items-center justify-between">
                        <span><i class="fas fa-file-pdf mr-2"></i>Activity Report</span>
                        <i class="fas fa-download"></i>
                    </button>
                </div>
            </div>
        </div>
    </main>

    <script>
        function exportReport(type) {
            alert('Exporting ' + type + ' report... (Feature coming soon!)');
        }
    </script>
</body>
</html>