
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

        <!-- Flash Messages -->
        <?php if (session()->getFlashdata('success')): ?>
            <div id="successAlert" class="bg-green-500/20 border border-green-500 text-green-300 px-4 py-3 rounded-lg mb-4">
                <i class="fas fa-check-circle mr-2"></i><?= esc(session()->getFlashdata('success')) ?>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="bg-red-500/20 border border-red-500 text-red-300 px-4 py-3 rounded-lg mb-4">
                <i class="fas fa-exclamation-circle mr-2"></i><?= esc(session()->getFlashdata('error')) ?>
            </div>
        <?php endif; ?>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div class="bg-gradient-to-br from-blue-600 to-blue-700 rounded-2xl shadow-xl p-6 transform hover:scale-105 transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-white">Enrolled Courses</h3>
                    <i class="fas fa-book-open text-blue-200 text-3xl"></i>
                </div>
                <p class="text-4xl font-bold text-white"><?= count($enrolledCourses) ?></p>
                <p class="text-blue-200 mt-2">Active courses</p>
            </div>

            <div class="bg-gradient-to-br from-green-600 to-green-700 rounded-2xl shadow-xl p-6 transform hover:scale-105 transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-white">Available Courses</h3>
                    <i class="fas fa-plus-circle text-green-200 text-3xl"></i>
                </div>
                <p class="text-4xl font-bold text-white"><?= count($availableCourses) ?></p>
                <p class="text-green-200 mt-2">Ready to enroll</p>
            </div>

            <div class="bg-gradient-to-br from-purple-600 to-purple-700 rounded-2xl shadow-xl p-6 transform hover:scale-105 transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-white">Total Courses</h3>
                    <i class="fas fa-graduation-cap text-purple-200 text-3xl"></i>
                </div>
                <p class="text-4xl font-bold text-white"><?= count($enrolledCourses) + count($availableCourses) ?></p>
                <p class="text-purple-200 mt-2">In the system</p>
            </div>
        </div>

        <!-- Enrolled Courses Section -->
        <div class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-2xl shadow-xl p-6 border border-purple-500/20 mb-6">
            <h3 class="text-xl font-bold text-white mb-4">
                <i class="fas fa-book-reader mr-2"></i>My Enrolled Courses
            </h3>
            
            <?php if (empty($enrolledCourses)): ?>
                <div class="text-center py-8 text-gray-400">
                    <i class="fas fa-inbox text-5xl mb-4 opacity-50"></i>
                    <p class="text-lg">You haven't enrolled in any courses yet</p>
                    <p class="text-sm mt-2">Browse available courses below to get started!</p>
                </div>
            <?php else: ?>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4" id="enrolledCoursesGrid">
                    <?php foreach ($enrolledCourses as $course): ?>
                    <div class="bg-slate-700/50 rounded-lg p-4 border border-purple-500/20 hover:border-purple-500/50 transition-all" data-course-id="<?= $course['course_id'] ?>">
                        <div class="flex items-start justify-between mb-3">
                            <div class="bg-blue-600 p-3 rounded-lg">
                                <i class="fas fa-book text-white text-xl"></i>
                            </div>
                            <span class="bg-green-500/20 text-green-300 px-2 py-1 rounded-full text-xs font-semibold">
                                Enrolled
                            </span>
                        </div>
                        <h4 class="text-white font-semibold mb-2"><?= esc($course['course_name']) ?></h4>
                        <p class="text-sm text-gray-400 mb-1">
                            <i class="fas fa-code mr-1"></i><?= esc($course['course_code']) ?>
                        </p>
                        <?php if (!empty($course['teacher_name'])): ?>
                        <p class="text-sm text-gray-400 mb-1">
                            <i class="fas fa-user-tie mr-1"></i><?= esc($course['teacher_name']) ?>
                        </p>
                        <?php endif; ?>
                        <p class="text-xs text-gray-500 mb-3">
                            <i class="fas fa-calendar mr-1"></i>Enrolled: <?= esc($course['enrollment_date']) ?>
                        </p>
                        <div class="grid grid-cols-2 gap-2">
                            <a href="<?= base_url('materials/view/' . $course['course_id']) ?>" 
                               class="bg-purple-600 hover:bg-purple-700 text-white px-3 py-2 rounded-lg transition-all text-sm text-center">
                                <i class="fas fa-folder mr-1"></i>Materials
                            </a>
                            <button onclick="unenrollCourse(<?= $course['course_id'] ?>)" 
                                    class="bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded-lg transition-all text-sm">
                                <i class="fas fa-times mr-1"></i>Unenroll
                            </button>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Available Courses Section -->
        <div class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-2xl shadow-xl p-6 border border-purple-500/20">
            <h3 class="text-xl font-bold text-white mb-4">
                <i class="fas fa-plus-circle mr-2"></i>Available Courses to Enroll
            </h3>

            <?php if (empty($availableCourses)): ?>
                <div class="text-center py-8 text-gray-400">
                    <i class="fas fa-check-circle text-5xl mb-4 opacity-50"></i>
                    <p class="text-lg">You're enrolled in all available courses!</p>
                    <p class="text-sm mt-2">Great job staying on top of your learning!</p>
                </div>
            <?php else: ?>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4" id="availableCoursesGrid">
                    <?php foreach ($availableCourses as $course): ?>
                    <div class="bg-slate-700/50 rounded-lg p-4 border border-purple-500/20 hover:border-purple-500/50 transition-all" data-course-id="<?= $course['id'] ?>">
                        <div class="flex items-start justify-between mb-3">
                            <div class="bg-green-600 p-3 rounded-lg">
                                <i class="fas fa-book text-white text-xl"></i>
                            </div>
                            <span class="bg-blue-500/20 text-blue-300 px-2 py-1 rounded-full text-xs font-semibold">
                                Available
                            </span>
                        </div>
                        <h4 class="text-white font-semibold mb-2"><?= esc($course['course_name']) ?></h4>
                        <p class="text-sm text-gray-400 mb-1">
                            <i class="fas fa-code mr-1"></i><?= esc($course['course_code']) ?>
                        </p>
                        <?php if (!empty($course['teacher_name'])): ?>
                        <p class="text-sm text-gray-400 mb-1">
                            <i class="fas fa-user-tie mr-1"></i><?= esc($course['teacher_name']) ?>
                        </p>
                        <?php endif; ?>
                        <?php if (!empty($course['description'])): ?>
                        <p class="text-xs text-gray-500 mb-3 line-clamp-2">
                            <?= esc(substr($course['description'], 0, 80)) ?><?= strlen($course['description']) > 80 ? '...' : '' ?>
                        </p>
                        <?php endif; ?>
                        <button onclick="enrollCourse(<?= $course['id'] ?>)" 
                                class="w-full bg-green-600 hover:bg-green-700 text-white px-3 py-2 rounded-lg transition-all text-sm">
                            <i class="fas fa-plus-circle mr-1"></i>Enroll Now
                        </button>
                    </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </main>


    <script>
        // Enroll in a course
        function enrollCourse(courseId) {
            if (!confirm('Are you sure you want to enroll in this course?')) {
                return;
            }

            fetch('<?= base_url('course/enroll') ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: 'course_id=' + courseId
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    alert(data.message);
                    location.reload(); // Reload to update the UI
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while enrolling. Please try again.');
            });
        }

        // Unenroll from a course
        function unenrollCourse(courseId) {
            if (!confirm('Are you sure you want to unenroll from this course? You will lose access to all course materials.')) {
                return;
            }

            fetch('<?= base_url('course/unenroll') ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: 'course_id=' + courseId
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    alert(data.message);
                    location.reload(); // Reload to update the UI
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while unenrolling. Please try again.');
            });
        }

        // Auto fade out success alert
        document.addEventListener("DOMContentLoaded", () => {
            const alert = document.getElementById("successAlert");
            if (alert) {
                setTimeout(() => {
                    alert.style.transition = 'opacity 0.8s ease';
                    alert.style.opacity = '0';
                    setTimeout(() => alert.remove(), 800);
                }, 3000);
            }
        });
    </script>
    </body>
</html>

