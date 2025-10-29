<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/about', 'Home::about');
$routes->get('/contact', 'Home::contact');


// Authentication Routes
$routes->get('/', 'Auth::login');
$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::loginPost');
$routes->get('register', 'Auth::register');
$routes->post('register', 'Auth::registerPost');
$routes->get('logout', 'Auth::logout');

// Dashboard Routes (Protected by AuthFilter)
$routes->group('dashboard', ['filter' => 'auth'], function($routes) {
    // Main Dashboard
    $routes->get('/', 'Dashboard::index');

    // Admin Routes
    $routes->get('manage-users', 'Dashboard::manageUsers');
    $routes->get('reports', 'Dashboard::reports');
    $routes->post('delete-user/(:num)', 'Dashboard::deleteUser/$1');

    // Teacher Routes
    $routes->get('my-classes', 'Dashboard::myClasses');

    // Student Routes
    $routes->get('my-courses', 'Dashboard::myCourses');
    $routes->get('my-grades', 'Dashboard::myGrades');

    // Manage Courses (Admin/Teacher)
    $routes->get('manage-courses', 'Dashboard::manageCourses');
});

// Course Enrollment Routes (Protected by AuthFilter)
$routes->group('course', ['filter' => 'auth'], function($routes) {
    $routes->post('enroll', 'Course::enroll');
    $routes->post('unenroll', 'Course::unenroll');
});



// Materials Routes (Protected by AuthFilter)
$routes->group('materials', ['filter' => 'auth'], function($routes) {
    // Admin/Teacher: Upload materials
    $routes->get('upload/(:num)', 'Materials::upload/$1');
    $routes->post('upload/(:num)', 'Materials::upload/$1');

    // Admin/Teacher: Delete materials
    $routes->get('delete/(:num)', 'Materials::delete/$1');

    // All users: Download materials
    $routes->get('download/(:num)', 'Materials::download/$1');

    // Students: View course materials
    $routes->get('view/(:num)', 'Materials::view/$1');
});

// ✅ Notification Routes (MUST be outside any group)
$routes->get('notifications', 'Notifications::get', ['filter' => 'auth']);
$routes->post('notifications/mark_read/(:num)', 'Notifications::mark_as_read/$1', ['filter' => 'auth']);
$routes->post('notifications/mark_all_read', 'Notifications::mark_all_as_read', ['filter' => 'auth']);


