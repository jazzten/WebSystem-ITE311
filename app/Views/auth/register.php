
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - LMS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gradient-to-br from-green-500 via-teal-600 to-blue-600 min-h-screen flex items-center justify-center p-4">

    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md p-8">
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="bg-gradient-to-r from-green-500 to-teal-600 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-user-plus text-white text-3xl"></i>
            </div>
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Create Account</h1>
            <p class="text-gray-600 text-sm">Join our learning management system</p>
        </div>

        <!-- Flash Messages -->
        <?php if (session()->getFlashdata('error')): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-4 text-sm">
                <?= esc(session()->getFlashdata('error')) ?>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('errors')): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-4 text-sm">
                <ul class="list-disc list-inside">
                    <?php foreach (session()->getFlashdata('errors') as $error): ?>
                        <li><?= esc($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <!-- Register Form -->
        <form action="<?= base_url('register') ?>" method="post" class="space-y-5">
            <!-- Full Name -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                <input type="text" name="name" required value="<?= old('name') ?>"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:outline-none"
                    placeholder="Enter your full name">
            </div>

            <!-- Email -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                <input type="email" name="email" required value="<?= old('email') ?>"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:outline-none"
                    placeholder="Enter your email address">
            </div>

            <!-- Password (with toggle) -->
            <div class="relative">
                <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                <input type="password" id="password" name="password" required minlength="6"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:outline-none"
                    placeholder="Create a strong password">
                <button type="button" id="togglePassword" class="absolute inset-y-0 right-3 top-8 flex items-center text-gray-500">
                    <i class="fas fa-eye"></i>
                </button>
                <p class="text-xs text-gray-500 mt-1">Minimum 6 characters</p>
            </div>

            <!-- Role Selection -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Select Role</label>
                <select name="role" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:outline-none">
                    <option value="">-- Choose a Role --</option>
                    <option value="student" <?= old('role') == 'student' ? 'selected' : '' ?>>👨‍🎓 Student</option>
                    <option value="teacher" <?= old('role') == 'teacher' ? 'selected' : '' ?>>👨‍🏫 Teacher</option>
                    <option value="admin" <?= old('role') == 'admin' ? 'selected' : '' ?>>👨‍💼 Admin</option>
                </select>
            </div>

            <!-- Submit Button -->
            <button type="submit"
                class="w-full bg-gradient-to-r from-green-500 to-teal-600 text-white py-3 rounded-lg font-semibold hover:from-green-600 hover:to-teal-700 shadow-lg transition">
                <i class="fas fa-user-plus mr-2"></i> Create Account</button>
        </form>

        <!-- Footer -->
        <div class="mt-6 text-center">
            <p class="text-gray-600 text-sm">
                Already have an account?
                <a href="<?= base_url('login') ?>" class="text-teal-600 font-semibold hover:text-teal-700">
                    Sign in here
                </a>
            </p>
        </div>
    </div>

    <!-- Password Visibility Script -->
    <script>
        const togglePassword = document.getElementById('togglePassword');
        const passwordField = document.getElementById('password');

        togglePassword.addEventListener('click', () => {
            const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);
            togglePassword.innerHTML = type === 'password'
                ? '<i class="fas fa-eye"></i>'
                : '<i class="fas fa-eye-slash"></i>';
        });
    </script>

</body>
</html>

