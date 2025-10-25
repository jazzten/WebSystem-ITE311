<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Login - LMS</title>

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome (icons) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>

    <style>
      /* Small enhancement for focus outline */
      :focus { outline: 3px solid rgba(99,102,241,0.18); outline-offset: 2px; }
    </style>
</head>
<body class="bg-gradient-to-br from-blue-600 via-purple-600 to-pink-500 min-h-screen flex items-center justify-center p-4">

  <main class="bg-white rounded-2xl shadow-2xl w-full max-w-md p-8" role="main" aria-labelledby="login-title">
    <header class="text-center mb-6">
      <div class="bg-gradient-to-r from-blue-600 to-purple-600 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
        <i class="fas fa-graduation-cap text-white text-3xl" aria-hidden="true"></i>
      </div>
      <h1 id="login-title" class="text-3xl font-bold text-gray-800 mb-1">LMS</h1>
      <p class="text-gray-600">School Management System</p>
    </header>

    <!-- ARIA live region for flash messages -->
    <div aria-live="polite" aria-atomic="true" class="mb-4">
      <?php if (session()->getFlashdata('error')): ?>
        <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg mb-4" role="alert">
          <?= esc(session()->getFlashdata('error')) ?>
        </div>
      <?php endif; ?>

      <?php if (session()->getFlashdata('success')): ?>
        <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg mb-4" role="status">
          <?= esc(session()->getFlashdata('success')) ?>
        </div>
      <?php endif; ?>

      <?php if (session()->getFlashdata('errors')): ?>
        <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg mb-4" role="alert">
          <ul class="list-disc list-inside text-sm">
            <?php foreach (session()->getFlashdata('errors') as $error): ?>
              <li><?= esc($error) ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endif; ?>
    </div>

    <form id="loginForm" action="<?= base_url('login') ?>" method="post" class="space-y-6" novalidate>
      <?= csrf_field() ?>

      <div>
        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
        <div class="relative">
          <span class="absolute inset-y-0 left-3 flex items-center pointer-events-none text-gray-400">
            <i class="fas fa-envelope"></i>
          </span>
          <input
            id="email"
            type="email"
            name="email"
            required
            autofocus
            value="<?= esc(old('email')) ?>"
            aria-required="true"
            aria-label="Email"
            placeholder="you@example.com"
            class="w-full pl-11 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:outline-none"
          />
        </div>
      </div>

      <div>
        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
        <div class="relative">
          <span class="absolute inset-y-0 left-3 flex items-center pointer-events-none text-gray-400">
            <i class="fas fa-lock"></i>
          </span>
          <input
            id="password"
            type="password"
            name="password"
            required
            minlength="6"
            aria-required="true"
            aria-label="Password"
            placeholder="Enter your password"
            class="w-full pl-11 pr-12 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:outline-none"
          />
          <button
            type="button"
            id="togglePassword"
            aria-label="Show password"
            class="absolute inset-y-0 right-2 flex items-center px-3 text-gray-500 hover:text-gray-700"
          >
            <i class="far fa-eye"></i>
          </button>
        </div>
      </div>

      <div class="flex items-center justify-between">
        <label class="inline-flex items-center text-sm text-gray-700">
          <input type="checkbox" name="remember" class="form-checkbox h-4 w-4 text-purple-600" />
          <span class="ml-2">Remember me</span>
        </label>

        <a href="<?= base_url('forgot-password') ?>" class="text-sm text-purple-600 hover:underline">Forgot password?</a>
      </div>

      <div>
        <button
          type="submit"
          id="submitBtn"
          class="w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white py-3 rounded-lg font-semibold hover:from-blue-700 hover:to-purple-700 shadow-lg disabled:opacity-60"
        >
          Sign In
        </button>
      </div>
    </form>

    <div class="mt-6 text-center">
      <p class="text-gray-600">
        Don't have an account?
        <a href="<?= base_url('register') ?>" class="text-purple-600 font-semibold hover:underline">
          Register here
        </a>
      </p>
    </div>

    <hr class="my-6 border-t border-gray-200">

    <section class="text-center text-xs text-gray-600">
      <p class="font-semibold mb-2">Demo Credentials</p>
      <p>👨‍💼 Admin: <span class="font-medium">admin@example.com</span> / <span class="font-medium">admin123</span></p>
      <p>👨‍🏫 Teacher: <span class="font-medium">teacher@example.com</span> / <span class="font-medium">teacher123</span></p>
      <p>👨‍🎓 Student: <span class="font-medium">student@example.com</span> / <span class="font-medium">student123</span></p>
    </section>

    <noscript class="block mt-4 text-sm text-red-600">
      JavaScript is required for some features on this page (show/hide password, client-side validation).
    </noscript>
  </main>

    <script>
    // Toggle password visibility
    (function () {
        const pwd = document.getElementById('password');
        const btn = document.getElementById('togglePassword');
        if (!pwd || !btn) return;

        btn.addEventListener('click', () => {
        const type = pwd.getAttribute('type') === 'password' ? 'text' : 'password';
        pwd.setAttribute('type', type);
        btn.setAttribute('aria-label', type === 'text' ? 'Hide password' : 'Show password');
        btn.querySelector('i').classList.toggle('fa-eye');
        btn.querySelector('i').classList.toggle('fa-eye-slash');
        });
    })();

    // Prevent double submit and do simple client-side check
    (function () {
        const form = document.getElementById('loginForm');
        const submit = document.getElementById('submitBtn');

        if (!form || !submit) return;

        form.addEventListener('submit', (e) => {
        // Basic validation before sending to server
        const email = form.email.value.trim();
        const password = form.password.value;

        if (!email || !password || password.length < 6) {
            e.preventDefault();
            alert('Please provide a valid email and password (min 6 characters).');
            return;
        }

        // disable button to prevent multiple clicks
        submit.disabled = true;
        });
    })();
    </script>
</body>
</html>

