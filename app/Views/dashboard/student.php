?>
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
                    <button class="text-gray-300 hover:text-white px-4 py-2 rounded-lg hover:bg-slate-700 transition-all">
                        My Courses
                    </button>
                    <button class="text-gray-300 hover:text-white px-4 py-2 rounded-lg hover:bg-slate-700 transition-all">
                        My Grades
                    </button>
                    <a href="<?= base_url('logout') ?>"
                        class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg flex items-center space-x-2 transition-all transform hover:scale-105">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-gradient-to-r from-slate-800 to-slate-900 rounded-2xl shadow-2xl p-6 mb-6 border border-purple-500/20">
            <h2 class="text-2xl font-bold text-white mb-2">Welcome, <?= esc($user['name']) ?></h2>
            <p class="text-purple-300">Your learning dashboard</p>
        </div>

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
            </div>
        </div>
    </main>
</body>
</html>