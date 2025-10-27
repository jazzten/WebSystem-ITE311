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
});

// ✅ Course Enrollment Routes (Protected by AuthFilter)
$routes->group('course', ['filter' => 'auth'], function($routes) {
    $routes->post('enroll', 'Course::enroll');
    $routes->post('unenroll', 'Course::unenroll');
});

