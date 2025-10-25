<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
        <a class="navbar-brand fw-bold text-white" href="#">LMS</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
            <li class="nav-item me-2">
                <a class="btn btn-outline-light" href="/">Home</a>
            </li>
            <li class="nav-item me-2">
                <a class="btn btn-outline-light" href="/about">About</a>
            </li>
            <li class="nav-item">
                <a class="btn btn-outline-light" href="/contact">Contact</a>
            </li>
            </ul>
            </div>
        </div>
    </nav>

    <div class="d-flex justify-content-center align-items-center mt-5">
    <div class="card shadow p-4" style="width:1200px;">
        <h2>Dashboard</h2>
        <div class="alert alert-success">
            Welcome, <?= session()->get('email'); ?>!
        </div>
        <div class="card">
    <div class="bg-primary text-white p-2" style="background-color: purple;">Protected Page</div>
    <div class="card-body">
        <p>This is a protected page only visible after login.</p>
        <a href="/logout" class="btn btn-danger">Logout</a>
    </div>
    </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
