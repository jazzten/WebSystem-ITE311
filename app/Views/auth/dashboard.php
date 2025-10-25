<!-- Styles for Dashboard -->
<style>
    body {
        background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
        min-height: 100vh;
    }
    
    .top-nav {
        background: rgba(30, 41, 59, 0.95);
        padding: 1rem 0;
        margin-bottom: 2rem;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }
    
    .brand-section {
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    
    .brand-icon {
        font-size: 2rem;
    }
    
    .nav-buttons .btn {
        margin-left: 0.5rem;
    }
</style>

<!-- Top Navigation Bar -->
<div class="top-nav">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center">
            <div class="brand-section text-white">
                <span class="brand-icon">🎓</span>
                <div>
                    <h4 class="mb-0">LMS</h4>
                    <small class="text-muted">Hello, <?= esc($username) ?> (<?= esc(ucfirst($role)) ?>)</small>
                </div>
            </div>
            
            <?php if ($role === 'admin'): ?>
                <div class="nav-buttons">
                    <a href="<?= base_url('admin/users') ?>" class="btn btn-outline-light">
                        <i class="bi bi-people"></i> Manage Users
                    </a>
                    <a href="<?= base_url('admin/reports') ?>" class="btn btn-outline-light">
                        <i class="bi bi-file-bar-graph"></i> Reports
                    </a>
                    <a href="<?= base_url('logout') ?>" class="btn btn-danger">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </a>
                </div>
            <?php elseif ($role === 'teacher'): ?>
                <div class="nav-buttons">
                    <a href="#" class="btn btn-outline-light">
                        <i class="bi bi-journal-text"></i> My Classes
                    </a>
                    <a href="<?= base_url('logout') ?>" class="btn btn-danger">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </a>
                </div>
            <?php elseif ($role === 'student'): ?>
                <div class="nav-buttons">
                    <a href="#" class="btn btn-outline-light">
                        <i class="bi bi-book"></i> My Classes
                    </a>
                    <a href="<?= base_url('logout') ?>" class="btn btn-danger">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Main Dashboard Content -->

    <div class="container mt-5">

    <div class="row mb-4">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-1 text-white">Welcome, <?= esc($username) ?>! 👋</h2>
                    <p class="text-white-50 mb-0">
                        <span class="badge bg-<?= $role === 'admin' ? 'danger' : ($role === 'teacher' ? 'success' : 'primary') ?>">
                            <?= esc(ucfirst($role)) ?>
                        </span>
                    </p>
                </div>
            </div>
            <hr class="bg-white">
        </div>
    </div>

    <?php if ($role === 'admin'): ?>
        <!-- ADMIN DASHBOARD -->
        <div class="row mb-4">
            <div class="col-md-4 mb-3">
                <div class="card text-white bg-primary h-100">
                    <div class="card-body">
                        <h6 class="card-subtitle mb-2 text-white-50">Total Users</h6>
                        <h2 class="card-title"><?= esc($total_users) ?></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card text-white bg-success h-100">
                    <div class="card-body">
                        <h6 class="card-subtitle mb-2 text-white-50">Teachers</h6>
                        <h2 class="card-title"><?= esc($total_teachers) ?></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card text-white bg-info h-100">
                    <div class="card-body">
                        <h6 class="card-subtitle mb-2 text-white-50">Students</h6>
                        <h2 class="card-title"><?= esc($total_students) ?></h2>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Users Table -->
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Recent Users</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Created</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($recent_users)): ?>
                                        <?php foreach ($recent_users as $user): ?>
                                            <tr>
                                                <td><?= esc($user['id']) ?></td>
                                                <td><strong><?= esc($user['username']) ?></strong></td>
                                                <td><?= esc($user['email']) ?></td>
                                                <td>
                                                    <span class="badge bg-<?= $user['role'] === 'admin' ? 'danger' : ($user['role'] === 'teacher' ? 'success' : 'primary') ?>">
                                                        <?= esc(ucfirst($user['role'])) ?>
                                                    </span>
                                                </td>
                                                <td><?= date('M d, Y', strtotime($user['created_at'])) ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="5" class="text-center py-4 text-muted">No users found</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <?php elseif ($role === 'teacher'): ?>
        <!-- TEACHER DASHBOARD -->
        <div class="row mb-4">
            <div class="col-md-4 mb-3">
                <div class="card border-success h-100 bg-white">
                    <div class="card-body">
                        <h6 class="card-subtitle mb-2 text-success">My Classes</h6>
                        <h2 class="card-title"><?= count($my_classes) ?></h2>
                        <p class="card-text text-muted small">Active classes</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card border-primary h-100 bg-white">
                    <div class="card-body">
                        <h6 class="card-subtitle mb-2 text-primary">Students</h6>
                        <h2 class="card-title"><?= esc($total_students) ?></h2>
                        <p class="card-text text-muted small">Total students</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card border-warning h-100 bg-white">
                    <div class="card-body">
                        <h6 class="card-subtitle mb-2 text-warning">Assignments</h6>
                        <h2 class="card-title"><?= esc($total_assignments) ?></h2>
                        <p class="card-text text-muted small">Pending grading</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Quick Actions</h5>
                    </div>
                    <div class="card-body">
                        <a href="#" class="btn btn-primary me-2">Create Assignment</a>
                        <a href="#" class="btn btn-success me-2">Grade Submissions</a>
                        <a href="#" class="btn btn-info">Manage Classes</a>
                    </div>
                </div>
            </div>
        </div>

    <?php elseif ($role === 'student'): ?>
        <!-- STUDENT DASHBOARD -->
        <div class="row mb-4">
            <div class="col-md-4 mb-3">
                <div class="card border-info h-100 bg-white">
                    <div class="card-body">
                        <h6 class="card-subtitle mb-2 text-info">Enrolled Classes</h6>
                        <h2 class="card-title"><?= count($enrolled_classes) ?></h2>
                        <p class="card-text text-muted small">This semester</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card border-success h-100 bg-white">
                    <div class="card-body">
                        <h6 class="card-subtitle mb-2 text-success">Average Grade</h6>
                        <h2 class="card-title">--</h2>
                        <p class="card-text text-muted small">Current GPA</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card border-warning h-100 bg-white">
                    <div class="card-body">
                        <h6 class="card-subtitle mb-2 text-warning">Pending Tasks</h6>
                        <h2 class="card-title"><?= count($recent_grades) ?></h2>
                        <p class="card-text text-muted small">Assignments due</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Quick Access</h5>
                    </div>
                    <div class="card-body">
                        <a href="#" class="btn btn-primary me-2">My Assignments</a>
                        <a href="#" class="btn btn-success me-2">View Grades</a>
                        <a href="#" class="btn btn-info">Class Schedule</a>
                    </div>
                </div>
            </div>
        </div>

    <?php else: ?>
        <!-- ERROR STATE -->
        <div class="alert alert-danger">
            <h4>Invalid User Role</h4>
            <p>Your account has an invalid role. Please contact administrator.</p>
        </div>
    <?php endif; ?>
</div>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">