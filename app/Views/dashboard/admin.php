
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - LMS</title>
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
                    <a href="<?= base_url('dashboard/reports') ?>" class="text-gray-300 hover:text-white px-4 py-2 rounded-lg hover:bg-slate-700 transition-all">
                        <i class="fas fa-chart-bar mr-2"></i>Reports
                    </a>
                    <a href="<?= base_url('logout') ?>" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg flex items-center space-x-2 transition-all transform hover:scale-105">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Welcome Section -->
        <div class="bg-gradient-to-r from-slate-800 to-slate-900 rounded-2xl shadow-2xl p-6 mb-6 border border-purple-500/20">
            <h2 class="text-2xl font-bold text-white mb-2">Welcome, <?= esc($user['name']) ?> 👋</h2>
            <p class="text-purple-300">Your personalized admin dashboard</p>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
            <!-- Total Users -->
            <div class="bg-gradient-to-br from-blue-600 to-blue-700 rounded-2xl shadow-xl p-6 transform hover:scale-105 transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-white">Total Users</h3>
                    <i class="fas fa-users text-blue-200 text-3xl"></i>
                </div>
                <p class="text-4xl font-bold text-white"><?= $totalUsers ?></p>
                <p class="text-blue-200 mt-2">All registered users</p>
            </div>

            <!-- Admins -->
            <div class="bg-gradient-to-br from-red-600 to-red-700 rounded-2xl shadow-xl p-6 transform hover:scale-105 transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-white">Admins</h3>
                    <i class="fas fa-user-shield text-red-200 text-3xl"></i>
                </div>
                <p class="text-4xl font-bold text-white"><?= $totalAdmins ?></p>
                <p class="text-red-200 mt-2">System administrators</p>
            </div>

            <!-- Teachers -->
            <div class="bg-gradient-to-br from-green-600 to-green-700 rounded-2xl shadow-xl p-6 transform hover:scale-105 transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-white">Teachers</h3>
                    <i class="fas fa-chalkboard-teacher text-green-200 text-3xl"></i>
                </div>
                <p class="text-4xl font-bold text-white"><?= $totalTeachers ?></p>
                <p class="text-green-200 mt-2">Active teachers</p>
            </div>

            <!-- Students -->
            <div class="bg-gradient-to-br from-purple-600 to-purple-700 rounded-2xl shadow-xl p-6 transform hover:scale-105 transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-white">Students</h3>
                    <i class="fas fa-user-graduate text-purple-200 text-3xl"></i>
                </div>
                <p class="text-4xl font-bold text-white"><?= $totalStudents ?></p>
                <p class="text-purple-200 mt-2">Enrolled students</p>
            </div>
        </div>

        <!-- Recent Users Table -->
        <div class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-2xl shadow-xl p-6 border border-purple-500/20">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-bold text-white">Recently Registered Users</h3>
                <a href="<?= base_url('dashboard/manage-users') ?>" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg transition-all">
                    <i class="fas fa-eye mr-2"></i>View All
                </a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-purple-500/20">
                            <th class="text-left py-3 px-4 text-purple-300 font-semibold">ID</th>
                            <th class="text-left py-3 px-4 text-purple-300 font-semibold">Name</th>
                            <th class="text-left py-3 px-4 text-purple-300 font-semibold">Email</th>
                            <th class="text-left py-3 px-4 text-purple-300 font-semibold">Role</th>
                            <th class="text-left py-3 px-4 text-purple-300 font-semibold">Joined</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recentUsers as $recentUser): ?>
                        <tr class="border-b border-slate-700 hover:bg-slate-700/50 transition-colors">
                            <td class="py-3 px-4 text-gray-300"><?= esc($recentUser['id']) ?></td>
                            <td class="py-3 px-4 text-gray-300"><?= esc($recentUser['name']) ?></td>
                            <td class="py-3 px-4 text-gray-300"><?= esc($recentUser['email']) ?></td>
                            <td class="py-3 px-4">
                                <span class="px-3 py-1 rounded-full text-sm font-semibold
                                    <?= $recentUser['role'] == 'admin' ? 'bg-red-500/20 text-red-300' :
                                        ($recentUser['role'] == 'teacher' ? 'bg-green-500/20 text-green-300' : 'bg-blue-500/20 text-blue-300') ?>">
                                    <?= ucfirst($recentUser['role']) ?>
                                </span>
                            </td>
                            <td class="py-3 px-4 text-gray-300"><?= date('M d, Y', strtotime($recentUser['created_at'])) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body>
</html>