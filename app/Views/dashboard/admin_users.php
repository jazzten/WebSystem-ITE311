<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users - LMS</title>
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
                    <a href="<?= base_url('dashboard/manage-users') ?>" class="text-white bg-purple-600 px-4 py-2 rounded-lg">
                        <i class="fas fa-users mr-2"></i>Manage Users
                    </a>
                    <a href="<?= base_url('dashboard/reports') ?>" class="text-gray-300 hover:text-white px-4 py-2 rounded-lg hover:bg-slate-700 transition-all">
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
        <div class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-2xl shadow-xl p-6 border border-purple-500/20">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-bold text-white">User Management</h3>
                <button onclick="alert('Add User feature coming soon!')" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition-all">
                    <i class="fas fa-plus mr-2"></i>Add New User
                </button>
            </div>

            <!-- Search Bar -->
            <div class="mb-4">
                <input type="text" id="searchInput" placeholder="Search by name or email..." 
                    class="w-full px-4 py-3 bg-slate-700 text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
            </div>

            <!-- Users Table -->
            <div class="overflow-x-auto">
                <table class="w-full" id="usersTable">
                    <thead>
                        <tr class="border-b border-purple-500/20">
                            <th class="text-left py-3 px-4 text-purple-300 font-semibold">ID</th>
                            <th class="text-left py-3 px-4 text-purple-300 font-semibold">Name</th>
                            <th class="text-left py-3 px-4 text-purple-300 font-semibold">Email</th>
                            <th class="text-left py-3 px-4 text-purple-300 font-semibold">Role</th>
                            <th class="text-left py-3 px-4 text-purple-300 font-semibold">Joined</th>
                            <th class="text-left py-3 px-4 text-purple-300 font-semibold">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $singleUser): ?>
                        <tr class="border-b border-slate-700 hover:bg-slate-700/50 transition-colors" data-user-id="<?= $singleUser['id'] ?>">
                            <td class="py-3 px-4 text-gray-300"><?= esc($singleUser['id']) ?></td>
                            <td class="py-3 px-4 text-gray-300"><?= esc($singleUser['name']) ?></td>
                            <td class="py-3 px-4 text-gray-300"><?= esc($singleUser['email']) ?></td>
                            <td class="py-3 px-4">
                                <span class="px-3 py-1 rounded-full text-sm font-semibold
                                    <?= $singleUser['role'] == 'admin' ? 'bg-red-500/20 text-red-300' :
                                        ($singleUser['role'] == 'teacher' ? 'bg-green-500/20 text-green-300' : 'bg-blue-500/20 text-blue-300') ?>">
                                    <?= ucfirst($singleUser['role']) ?>
                                </span>
                            </td>
                            <td class="py-3 px-4 text-gray-300"><?= date('M d, Y', strtotime($singleUser['created_at'])) ?></td>
                            <td class="py-3 px-4">
                                <button onclick="editUser(<?= $singleUser['id'] ?>)" class="text-blue-400 hover:text-blue-300 mr-3">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button onclick="deleteUser(<?= $singleUser['id'] ?>)" class="text-red-400 hover:text-red-300">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <script>
        // Search functionality
        document.getElementById('searchInput').addEventListener('keyup', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll('#usersTable tbody tr');
            
            rows.forEach(row => {
                const name = row.cells[1].textContent.toLowerCase();
                const email = row.cells[2].textContent.toLowerCase();
                
                if (name.includes(searchTerm) || email.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });

        // Edit user function
        function editUser(userId) {
            alert('Edit user #' + userId + ' - Feature coming soon!');
        }

        // Delete user function
        function deleteUser(userId) {
            if (confirm('Are you sure you want to delete this user?')) {
                fetch('<?= base_url('dashboard/delete-user') ?>/' + userId, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Remove row from table
                        const row = document.querySelector(`tr[data-user-id="${userId}"]`);
                        if (row) {
                            row.remove();
                        }
                        alert('User deleted successfully!');
                    } else {
                        alert('Failed to delete user: ' + data.message);
                    }
                })
                .catch(error => {
                    alert('Error: ' + error);
                });
            }
        }
    </script>
</body>
</html>