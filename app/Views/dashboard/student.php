
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard - LMS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- jQuery for AJAX -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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

        <!-- Alert Container for Messages -->
        <div id="alertContainer" class="mb-4"></div>

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
                    <i class="fas fa-list text-green-200 text-3xl"></i>
                </div>
                <p class="text-4xl font-bold text-white" id="availableCount"><?= count($availableCourses) ?></p>
                <p class="text-green-200 mt-2">Ready to enroll</p>
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

        <!-- Profile and Quick Actions (MOVED TO TOP) -->
        <div class="max-w-[1215px] mx-auto mb-6">
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
        </div>

        <!-- Courses Section (SWAPPED - Available Courses LEFT, Enrolled Courses RIGHT) -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Available Courses Section (NOW ON LEFT) -->
            <div class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-2xl shadow-xl p-6 border border-purple-500/20">
                <h3 class="text-xl font-bold text-white mb-4">
                    <i class="fas fa-plus-circle text-blue-400 mr-2"></i>Available Courses
                </h3>

                <div id="availableCoursesList" class="space-y-3 max-h-[600px] overflow-y-auto">
                    <?php if (!empty($availableCourses)): ?>
                        <?php foreach ($availableCourses as $course): ?>
                        <div class="bg-slate-700/50 rounded-lg p-4 hover:bg-slate-700 transition-all border border-slate-600" id="course-<?= $course['id'] ?>">
                            <div class="flex justify-between items-start">
                                <div class="flex-1">
                                    <h4 class="text-white font-semibold"><?= esc($course['course_name']) ?></h4>
                                    <p class="text-gray-400 text-sm mt-1">
                                        <i class="fas fa-code text-purple-400 mr-1"></i><?= esc($course['course_code']) ?>
                                    </p>
                                    <?php if (!empty($course['teacher_name'])): ?>
                                    <p class="text-gray-400 text-sm">
                                        <i class="fas fa-user-tie text-purple-400 mr-1"></i><?= esc($course['teacher_name']) ?>
                                    </p>
                                    <?php endif; ?>
                                    <?php if (!empty($course['schedule'])): ?>
                                    <p class="text-gray-400 text-sm">
                                        <i class="fas fa-clock text-purple-400 mr-1"></i><?= esc($course['schedule']) ?>
                                    </p>
                                    <?php endif; ?>
                                    <?php if (!empty($course['description'])): ?>
                                    <p class="text-gray-500 text-xs mt-2"><?= esc($course['description']) ?></p>
                                    <?php endif; ?>
                                </div>
                                <button class="btn-enroll bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition-all transform hover:scale-105"
                                        data-course-id="<?= $course['id'] ?>"
                                        data-course-name="<?= esc($course['course_name'], 'attr') ?>">
                                    <i class="fas fa-plus-circle mr-1"></i>Enroll
                                </button>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="text-center py-8">
                            <i class="fas fa-check-circle text-gray-600 text-4xl mb-3"></i>
                            <p class="text-gray-400">No available courses</p>
                            <p class="text-gray-500 text-sm">You're enrolled in all courses</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Enrolled Courses Section (NOW ON RIGHT) -->
            <div class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-2xl shadow-xl p-6 border border-purple-500/20">
                <h3 class="text-xl font-bold text-white mb-4">
                    <i class="fas fa-check-circle text-green-400 mr-2"></i>Enrolled Courses
                </h3>

                <div id="enrolledCoursesList" class="space-y-3">
                    <?php if (!empty($enrolledCourses)): ?>
                        <?php foreach ($enrolledCourses as $course): ?>
                        <div class="bg-slate-700/50 rounded-lg p-4 hover:bg-slate-700 transition-all border border-slate-600" data-enrolled-course="<?= $course['course_id'] ?>">
                            <div class="flex justify-between items-start">
                                <div class="flex-1">
                                    <h4 class="text-white font-semibold"><?= esc($course['course_name']) ?></h4>
                                    <p class="text-gray-400 text-sm mt-1">
                                        <i class="fas fa-code text-purple-400 mr-1"></i><?= esc($course['course_code']) ?>
                                    </p>
                                    <?php if (!empty($course['teacher_name'])): ?>
                                    <p class="text-gray-400 text-sm">
                                        <i class="fas fa-user-tie text-purple-400 mr-1"></i><?= esc($course['teacher_name']) ?>
                                    </p>
                                    <?php endif; ?>
                                    <?php if (!empty($course['schedule'])): ?>
                                    <p class="text-gray-400 text-sm">
                                        <i class="fas fa-clock text-purple-400 mr-1"></i><?= esc($course['schedule']) ?>
                                    </p>
                                    <?php endif; ?>
                                    <p class="text-gray-500 text-xs mt-2">
                                        Enrolled: <?= date('M d, Y', strtotime($course['enrollment_date'])) ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="text-center py-8" id="noEnrolledMessage">
                            <i class="fas fa-book-open text-gray-600 text-4xl mb-3"></i>
                            <p class="text-gray-400">No courses enrolled yet</p>
                            <p class="text-gray-500 text-sm">Start by enrolling in available courses</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </main>

    <!-- AJAX Enrollment Script -->
    <script>
    $(document).ready(function() {
        // Handle Enroll button click
        $(document).on('click', '.btn-enroll', function(e) {
            e.preventDefault();
            
            const button = $(this);
            const courseId = button.data('course-id');
            const courseName = button.data('course-name');
            const courseCard = $('#course-' + courseId);
            
            // Disable button to prevent double-clicking
            button.prop('disabled', true);
            button.html('<i class="fas fa-spinner fa-spin mr-1"></i>Enrolling...');
            
            // Get CSRF token
            const csrfName = '<?= csrf_token() ?>';
            const csrfHash = '<?= csrf_hash() ?>';
            
            // Send AJAX POST request
            $.post('<?= base_url('course/enroll') ?>', {
                course_id: courseId,
                [csrfName]: csrfHash
            })
            .done(function(response) {
                if (typeof response === 'string') {
                    response = JSON.parse(response);
                }
                
                if (response.status === 'success') {
                    showAlert('success', response.message || 'Successfully enrolled in ' + courseName + '!');
                    
                    button.html('<i class="fas fa-check mr-1"></i>Enrolled');
                    button.removeClass('bg-green-600 hover:bg-green-700').addClass('bg-gray-600 cursor-not-allowed');
                    button.prop('disabled', true);
                    
                    courseCard.fadeOut(400, function() {
                        $(this).remove();
                        
                        if ($('#availableCoursesList .bg-slate-700\\/50').length === 0) {
                            $('#availableCoursesList').html(`
                                <div class="text-center py-8">
                                    <i class="fas fa-check-circle text-gray-600 text-4xl mb-3"></i>
                                    <p class="text-gray-400">No available courses</p>
                                    <p class="text-gray-500 text-sm">You're enrolled in all courses</p>
                                </div>
                            `);
                        }
                    });
                    
                    if (response.enrolledCourse) {
                        addEnrolledCourse(response.enrolledCourse);
                    }
                    
                    updateEnrolledCount(1);
                    updateAvailableCount(-1);
                    
                } else {
                    showAlert('error', response.message || 'Failed to enroll in the course.');
                    button.prop('disabled', false);
                    button.html('<i class="fas fa-plus-circle mr-1"></i>Enroll');
                }
            })
            .fail(function(xhr, status, error) {
                console.error('Enrollment error:', error);
                showAlert('error', 'An error occurred. Please try again.');
                button.prop('disabled', false);
                button.html('<i class="fas fa-plus-circle mr-1"></i>Enroll');
            });
        });
        
        function showAlert(type, message) {
            const alertClass = type === 'success' ? 'bg-green-600' : 'bg-red-600';
            const iconClass = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';
            
            const alertHtml = `
                <div class="alert ${alertClass} text-white px-6 py-4 rounded-lg shadow-lg flex items-center justify-between animate-fade-in">
                    <div class="flex items-center">
                        <i class="fas ${iconClass} text-2xl mr-3"></i>
                        <span>${message}</span>
                    </div>
                    <button onclick="this.parentElement.remove()" class="text-white hover:text-gray-200">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            `;
            
            $('#alertContainer').html(alertHtml);
            
            setTimeout(function() {
                $('#alertContainer .alert').fadeOut(400, function() {
                    $(this).remove();
                });
            }, 5000);
        }
        
        function addEnrolledCourse(course) {
            $('#noEnrolledMessage').remove();
            
            const enrolledHtml = `
                <div class="bg-slate-700/50 rounded-lg p-4 hover:bg-slate-700 transition-all border border-slate-600 animate-fade-in" 
                     data-enrolled-course="${course.course_id}">
                    <div class="flex justify-between items-start">
                        <div class="flex-1">
                            <h4 class="text-white font-semibold">${escapeHtml(course.course_name)}</h4>
                            <p class="text-gray-400 text-sm mt-1">
                                <i class="fas fa-code text-purple-400 mr-1"></i>${escapeHtml(course.course_code)}
                            </p>
                            ${course.teacher_name ? `
                            <p class="text-gray-400 text-sm">
                                <i class="fas fa-user-tie text-purple-400 mr-1"></i>${escapeHtml(course.teacher_name)}
                            </p>
                            ` : ''}
                            ${course.schedule ? `
                            <p class="text-gray-400 text-sm">
                                <i class="fas fa-clock text-purple-400 mr-1"></i>${escapeHtml(course.schedule)}
                            </p>
                            ` : ''}
                            <p class="text-gray-500 text-xs mt-2">
                                Enrolled: ${course.enrollment_date}
                            </p>
                        </div>
                    </div>
                </div>
            `;
            
            $('#enrolledCoursesList').prepend(enrolledHtml);
        }
        
        function updateEnrolledCount(change) {
            const countElement = $('#enrolledCount');
            const currentCount = parseInt(countElement.text());
            countElement.text(currentCount + change);
        }
        
        function updateAvailableCount(change) {
            const countElement = $('#availableCount');
            const currentCount = parseInt(countElement.text());
            countElement.text(currentCount + change);
        }
        
        function escapeHtml(text) {
            const map = {
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            };
            return text.replace(/[&<>"']/g, function(m) { return map[m]; });
        }
    });
    </script>

    <script>
        function viewSchedule() {
            alert('View class schedule - Feature coming soon!');
        }

        function submitAssignment() {
            alert('Submit assignment - Feature coming soon!');
        }
    </script>

    <style>
/* Your existing styles */
@keyframes fade-in {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fade-in {
    animation: fade-in 0.4s ease-out;
}

/* ✅ ADD THESE NEW STYLES FOR UNIFORM CARDS */
#enrolledCoursesList > div:not(.text-center),
#availableCoursesList > div:not(.text-center) {
    min-height: 160px;
    max-height: 160px;
}

#enrolledCoursesList h4,
#availableCoursesList h4 {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    max-width: 280px;
}

#availableCoursesList .text-xs.text-gray-500 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

#enrolledCoursesList,
#availableCoursesList {
    max-height: 600px;
    overflow-y: auto;
}

/* Custom scrollbar */
#availableCoursesList::-webkit-scrollbar,
#enrolledCoursesList::-webkit-scrollbar {
    width: 8px;
}

#availableCoursesList::-webkit-scrollbar-track,
#enrolledCoursesList::-webkit-scrollbar-track {
    background: rgba(51, 65, 85, 0.5);
    border-radius: 4px;
}

#availableCoursesList::-webkit-scrollbar-thumb,
#enrolledCoursesList::-webkit-scrollbar-thumb {
    background: rgba(139, 92, 246, 0.5);
    border-radius: 4px;
}

#availableCoursesList::-webkit-scrollbar-thumb:hover,
#enrolledCoursesList::-webkit-scrollbar-thumb:hover {
    background: rgba(139, 92, 246, 0.7);
}
</style>
</body>
</html>
