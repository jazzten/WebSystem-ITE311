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

                    <!-- ✅ ADD NOTIFICATION BELL HERE -->
                        <?php include(APPPATH . 'Views/includes/notification_bell.php'); ?>

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
        <div id="flashMessage"></div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div class="bg-gradient-to-br from-blue-600 to-blue-700 rounded-2xl shadow-xl p-6 transform hover:scale-105 transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-white">Enrolled Courses</h3>
                    <i class="fas fa-book-open text-blue-200 text-3xl"></i>
                </div>
                <p class="text-4xl font-bold text-white" id="enrolledCount"><?= count($enrolledCourses) ?></p>
                <p class="text-blue-200 mt-2">Active courses</p>
            </div>

            <div class="bg-gradient-to-br from-green-600 to-green-700 rounded-2xl shadow-xl p-6 transform hover:scale-105 transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-white">Available Courses</h3>
                    <i class="fas fa-plus-circle text-green-200 text-3xl"></i>
                </div>
                <p class="text-4xl font-bold text-white" id="availableCount"><?= count($availableCourses) ?></p>
                <p class="text-green-200 mt-2">To enroll</p>
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

        <!-- Enrolled Courses Section -->
        <div class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-2xl shadow-xl p-6 border border-purple-500/20 mb-6">
            <h3 class="text-xl font-bold text-white mb-4">My Enrolled Courses</h3>
            
            <div id="enrolledCoursesContainer" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <?php if (empty($enrolledCourses)): ?>
                    <div class="col-span-full text-center py-8 text-gray-400">
                        <i class="fas fa-inbox text-5xl mb-3"></i>
                        <p>You haven't enrolled in any courses yet</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($enrolledCourses as $course): ?>
                        <div class="bg-slate-700/50 rounded-lg p-4 border border-purple-500/20 hover:border-purple-500/50 transition-all" data-course-id="<?= $course['course_id'] ?>">
                            <div class="flex items-start justify-between mb-3">
                                <div class="bg-blue-600 p-3 rounded-lg">
                                    <i class="fas fa-book text-white text-xl"></i>
                                </div>
                                <span class="bg-green-500/20 text-green-300 px-2 py-1 rounded-full text-xs">Enrolled</span>
                            </div>
                            <h4 class="text-white font-bold mb-1"><?= esc($course['course_name']) ?></h4>
                            <p class="text-gray-400 text-sm mb-2"><?= esc($course['course_code']) ?></p>
                            <div class="space-y-1 mb-3">
                                <?php if (!empty($course['teacher_name'])): ?>
                                    <div class="flex items-center text-gray-300 text-sm">
                                        <i class="fas fa-user-tie text-purple-400 mr-2"></i>
                                        <span><?= esc($course['teacher_name']) ?></span>
                                    </div>
                                <?php endif; ?>
                                <div class="flex items-center text-gray-300 text-sm">
                                    <i class="fas fa-calendar text-purple-400 mr-2"></i>
                                    <span><?= date('M d, Y', strtotime($course['enrollment_date'])) ?></span>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-2">
                                <a href="<?= base_url('materials/view/' . $course['course_id']) ?>" 
                                   class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded-lg transition-all text-sm text-center">
                                    <i class="fas fa-folder mr-1"></i>Materials
                                </a>
                                <button onclick="unenrollCourse(<?= $course['course_id'] ?>)" 
                                        class="bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded-lg transition-all text-sm">
                                    <i class="fas fa-times mr-1"></i>Unenroll
                                </button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <!-- Available Courses Section -->
        <div class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-2xl shadow-xl p-6 border border-purple-500/20">
            <h3 class="text-xl font-bold text-white mb-4">Available Courses to Enroll</h3>
            
            <div id="availableCoursesContainer" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <?php if (empty($availableCourses)): ?>
                    <div class="col-span-full text-center py-8 text-gray-400">
                        <i class="fas fa-check-circle text-5xl mb-3"></i>
                        <p>You're enrolled in all available courses!</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($availableCourses as $course): ?>
                        <div class="bg-slate-700/50 rounded-lg p-4 border border-purple-500/20 hover:border-purple-500/50 transition-all" data-available-course-id="<?= $course['id'] ?>">
                            <div class="flex items-start justify-between mb-3">
                                <div class="bg-green-600 p-3 rounded-lg">
                                    <i class="fas fa-book-open text-white text-xl"></i>
                                </div>
                                <span class="bg-yellow-500/20 text-yellow-300 px-2 py-1 rounded-full text-xs">Available</span>
                            </div>
                            <h4 class="text-white font-bold mb-1"><?= esc($course['course_name']) ?></h4>
                            <p class="text-gray-400 text-sm mb-2"><?= esc($course['course_code']) ?></p>
                            <?php if (!empty($course['description'])): ?>
                                <p class="text-gray-300 text-xs mb-3 line-clamp-2"><?= esc($course['description']) ?></p>
                            <?php endif; ?>
                            <div class="space-y-1 mb-3">
                                <?php if (!empty($course['teacher_name'])): ?>
                                    <div class="flex items-center text-gray-300 text-sm">
                                        <i class="fas fa-user-tie text-purple-400 mr-2"></i>
                                        <span><?= esc($course['teacher_name']) ?></span>
                                    </div>
                                <?php endif; ?>
                                <?php if (!empty($course['schedule'])): ?>
                                    <div class="flex items-center text-gray-300 text-sm">
                                        <i class="fas fa-clock text-purple-400 mr-2"></i>
                                        <span><?= esc($course['schedule']) ?></span>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <button onclick="enrollCourse(<?= $course['id'] ?>)" 
                                    class="w-full bg-green-600 hover:bg-green-700 text-white px-3 py-2 rounded-lg transition-all text-sm">
                                <i class="fas fa-plus-circle mr-1"></i>Enroll Now
                            </button>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </main>


    <script>
        function showFlashMessage(message, type) {
            const flashDiv = document.getElementById('flashMessage');
            const bgColor = type === 'success' ? 'bg-green-500/20 border-green-500 text-green-300' : 'bg-red-500/20 border-red-500 text-red-300';
            const icon = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';
            
            flashDiv.innerHTML = `
                <div class="${bgColor} border px-4 py-3 rounded-lg mb-4">
                    <i class="fas ${icon} mr-2"></i>${message}
                </div>
            `;
            
            setTimeout(() => {
                flashDiv.innerHTML = '';
            }, 5000);
        }

        function enrollCourse(courseId) {
            if (!confirm('Are you sure you want to enroll in this course?')) return;

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
                    showFlashMessage(data.message, 'success');
                    
                    // Move course from available to enrolled
                    const availableCourse = document.querySelector(`[data-available-course-id="${courseId}"]`);
                    if (availableCourse) {
                        availableCourse.remove();
                    }
                    
                    // Add to enrolled courses
                    if (data.enrolledCourse) {
                        addEnrolledCourse(data.enrolledCourse);
                    }
                    
                    // Update counts
                    updateCounts();
                    
                    // Reload after 1 second
                    setTimeout(() => location.reload(), 1000);
                } else {
                    showFlashMessage(data.message, 'error');
                }
            })
            .catch(error => {
                showFlashMessage('An error occurred. Please try again.', 'error');
                console.error('Error:', error);
                });
        }

            function unenrollCourse(courseId) {
            if (!confirm('Are you sure you want to unenroll from this course?')) return;

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
                    showFlashMessage(data.message, 'success');
                    
                    // Remove from enrolled courses
                    const enrolledCourse = document.querySelector(`[data-course-id="${courseId}"]`);
                    if (enrolledCourse) {
                        enrolledCourse.remove();
                    }
                    
                    // Update counts
                    updateCounts();
                    
                    // Reload after 1 second
                    setTimeout(() => location.reload(), 1000);
                } else {
                    showFlashMessage(data.message, 'error');
                }
            })
            .catch(error => {
                showFlashMessage('An error occurred. Please try again.', 'error');
                console.error('Error:', error);
            });
        }

        function addEnrolledCourse(course) {
            const container = document.getElementById('enrolledCoursesContainer');
            
            // Remove "no courses" message if exists
            const emptyMsg = container.querySelector('.col-span-full');
            if (emptyMsg) emptyMsg.remove();
            
            const courseHTML = `
                <div class="bg-slate-700/50 rounded-lg p-4 border border-purple-500/20 hover:border-purple-500/50 transition-all" data-course-id="${course.course_id}">
                    <div class="flex items-start justify-between mb-3">
                        <div class="bg-blue-600 p-3 rounded-lg">
                            <i class="fas fa-book text-white text-xl"></i>
                        </div>
                        <span class="bg-green-500/20 text-green-300 px-2 py-1 rounded-full text-xs">Enrolled</span>
                    </div>
                    <h4 class="text-white font-bold mb-1">${course.course_name}</h4>
                    <p class="text-gray-400 text-sm mb-2">${course.course_code}</p>
                    <div class="space-y-1 mb-3">
                        ${course.teacher_name ? `
                        <div class="flex items-center text-gray-300 text-sm">
                            <i class="fas fa-user-tie text-purple-400 mr-2"></i>
                            <span>${course.teacher_name}</span>
                        </div>` : ''}
                        <div class="flex items-center text-gray-300 text-sm">
                            <i class="fas fa-calendar text-purple-400 mr-2"></i>
                            <span>${course.enrollment_date}</span>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        <a href="<?= base_url('materials/view/') ?>${course.course_id}" 
                           class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded-lg transition-all text-sm text-center">
                            <i class="fas fa-folder mr-1"></i>Materials
                        </a>
                        <button onclick="unenrollCourse(${course.course_id})" 
                                class="bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded-lg transition-all text-sm">
                            <i class="fas fa-times mr-1"></i>Unenroll
                        </button>
                    </div>
                </div>
            `;
            
            container.insertAdjacentHTML('beforeend', courseHTML);
        }

        function updateCounts() {
            const enrolledCount = document.querySelectorAll('[data-course-id]').length;
            const availableCount = document.querySelectorAll('[data-available-course-id]').length;
            
            document.getElementById('enrolledCount').textContent = enrolledCount;
            document.getElementById('availableCount').textContent = availableCount;
        }
    </script>
</body>
    </html>
