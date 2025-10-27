<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Classes - LMS</title>
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
                        <p class="text-sm text-purple-300">Hello, <?= esc($user['name']) ?> (Teacher)</p>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="<?= base_url('dashboard') ?>" class="text-gray-300 hover:text-white px-4 py-2 rounded-lg hover:bg-slate-700 transition-all">
                        <i class="fas fa-home mr-2"></i>Dashboard
                    </a>
                    <a href="<?= base_url('dashboard/my-classes') ?>" class="text-white bg-purple-600 px-4 py-2 rounded-lg">
                        <i class="fas fa-chalkboard mr-2"></i>My Classes
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
            <div class="flex justify-between items-center">
                <div>
                    <h2 class="text-2xl font-bold text-white mb-2">My Classes</h2>
                    <p class="text-purple-300">Manage your teaching schedule and materials</p>
                </div>
                <button onclick="addClass()" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition-all">
                    <i class="fas fa-plus mr-2"></i>Add Class
                </button>
            </div>
        </div>

        <!-- Classes Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach ($classes as $class): ?>
            <div class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-xl shadow-xl p-6 border border-purple-500/20 transform hover:scale-105 transition-all duration-300">
                <div class="flex items-start justify-between mb-4">
                    <div class="bg-purple-600 p-3 rounded-lg">
                        <i class="fas fa-book text-white text-2xl"></i>
                    </div>
                    <span class="bg-green-500/20 text-green-300 px-3 py-1 rounded-full text-sm font-semibold">Active</span>
                </div>
                <h3 class="text-xl font-bold text-white mb-2"><?= esc($class['name']) ?></h3>
                <div class="space-y-2 mb-4">
                    <div class="flex items-center text-gray-300">
                        <i class="fas fa-clock text-purple-400 mr-2"></i>
                        <span class="text-sm"><?= esc($class['schedule']) ?></span>
                    </div>
                    <div class="flex items-center text-gray-300">
                        <i class="fas fa-users text-purple-400 mr-2"></i>
                        <span class="text-sm"><?= esc($class['students']) ?> Students</span>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-2">
                    <button onclick="viewClass(<?= $class['id'] ?>)" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded-lg transition-all text-sm">
                        <i class="fas fa-eye mr-1"></i>View
                    </button>
                    <button onclick="editClass(<?= $class['id'] ?>)" class="bg-purple-600 hover:bg-purple-700 text-white px-3 py-2 rounded-lg transition-all text-sm">
                        <i class="fas fa-edit mr-1"></i>Edit
                    </button>
                    <a href="<?= base_url('materials/upload/' . $class['id']) ?>" class="col-span-2 bg-green-600 hover:bg-green-700 text-white px-3 py-2 rounded-lg transition-all text-sm text-center">
                        <i class="fas fa-folder mr-1"></i>Manage Materials
                    </a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </main>

    <script>
        function addClass() {
            alert('Add new class - Feature coming soon!');
        }

        function viewClass(id) {
            alert('View class details #' + id + ' - Feature coming soon!');
        }

        function editClass(id) {
            alert('Edit class #' + id + ' - Feature coming soon!');
        }
    </script>
</body>
</html>
