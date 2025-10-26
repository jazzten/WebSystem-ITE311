
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard - LMS</title>
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
                    <a href="<?= base_url('dashboard/my-grades') ?>" class="text-gray-300 hover:text-white px-4 py-2 rounded-lg hover:bg-slate-700 transition-all">
                        <i class="fas fa-star mr-2"></i>My Grades
                    </a>
                    <a href="<?= base_url('logout') ?>" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg flex items-center space-x-2 transition-all transform hover:scale-105">
                        <i class="fas fa-sign-out-alt"></i><span>Logout</span>
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
            <p class="text-purple-300">Your learning dashboard</p>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div class="bg-gradient-to-br from-blue-600 to-blue-700 rounded-2xl shadow-xl p-6 transform hover:scale-105 transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-white">Enrolled Courses</h3>
                    <i class="fas fa-book-open text-blue-200 text-3xl"></i>
                </div>
                <p class="text-4xl font-bold text-white"><?= $enrolledCourses ?></p>
                <p class="text-blue-200 mt-2">Active courses</p>
            </div>

            <div class="bg-gradient-to-br from-green-600 to-green-700 rounded-2xl shadow-xl p-6 transform hover:scale-105 transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-white">Average Grade</h3>
                    <i class="fas fa-chart-line text-green-200 text-3xl"></i>
                </div>
                <p class="text-4xl font-bold text-white">87%</p>
                <p class="text-green-200 mt-2">Current GPA: 3.5</p>
            </div>

            <div class="bg-gradient-to-br from-purple-600 to-purple-700 rounded-2xl shadow-xl p-6 transform hover:scale-105 transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-white">Pending Tasks</h3>
                    <i class="fas fa-tasks text-purple-200 text-3xl"></i>
                </div>
                <p class="text-4xl font-bold text-white">7</p>
                <p class="text-purple-200 mt-2">Assignments due</p>
            </div>
        </div>

        <!-- Profile and Quick Actions -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Profile Card -->
            <div class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-2xl shadow-xl p-6 border border-purple-500/20">
                <h3 class="text-xl font-bold text-white mb-4">My Profile</h3>
                <div class="space-y-4">
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-user text-purple-400 text-xl"></i>
                        <div>
                            <p class="text-gray-400 text-sm">Name</p>
                            <p class="text-white font-semibold"><?= esc($user['name']) ?></p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-envelope text-purple-400 text-xl"></i>
                        <div>
                            <p class="text-gray-400 text-sm">Email</p>
                            <p class="text-white font-semibold"><?= esc($user['email']) ?></p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-id-badge text-purple-400 text-xl"></i>
                        <div>
                            <p class="text-gray-400 text-sm">Student ID</p>
                            <p class="text-white font-semibold">STU-<?= str_pad($user['id'], 5, '0', STR_PAD_LEFT) ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-2xl shadow-xl p-6 border border-purple-500/20">
                <h3 class="text-xl font-bold text-white mb-4">Quick Actions</h3>
                <div class="space-y-3">
                    <a href="<?= base_url('dashboard/my-courses') ?>" class="block w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-3 rounded-lg transition-all flex items-center justify-between">
                        <span><i class="fas fa-book mr-2"></i>View My Courses</span>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                    <a href="<?= base_url('dashboard/my-grades') ?>" class="block w-full bg-green-600 hover:bg-green-700 text-white px-4 py-3 rounded-lg transition-all flex items-center justify-between">
                        <span><i class="fas fa-star mr-2"></i>Check My Grades</span>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                    <button onclick="viewSchedule()" class="w-full bg-purple-600 hover:bg-purple-700 text-white px-4 py-3 rounded-lg transition-all flex items-center justify-between">
                        <span><i class="fas fa-calendar mr-2"></i>Class Schedule</span>
                        <i class="fas fa-arrow-right"></i>
                    </button>
                    <button onclick="submitAssignment()" class="w-full bg-orange-600 hover:bg-orange-700 text-white px-4 py-3 rounded-lg transition-all flex items-center justify-between">
                        <span><i class="fas fa-upload mr-2"></i>Submit Assignment</span>
                        <i class="fas fa-arrow-right"></i>
                    </button>
                </div>
            </div>
        </div>
    </main>

    <script>
        function viewSchedule() {
            alert('View class schedule - Feature coming soon!');
        }

        function submitAssignment() {
            alert('Submit assignment - Feature coming soon!');
        }
    </script>
</body>
</html>
