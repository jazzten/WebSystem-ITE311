<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
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
        <div class="card shadow p-4" style="width:500px;">
        <h2 class="text-center mb-4">Create Account</h2>
        <?php if(isset($validation)): ?>
            <div class="alert alert-danger"><?= $validation->listErrors() ?></div>
        <?php endif; ?>
        <form action="/registerPost" method="post">
            <div class="mb-3">
                <label>Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Confirm Password</label>
                <input type="password" name="confpassword" class="form-control" required>
            </div>
            <button class="btn btn-success w-100">Create Account</button>
        </form>
        <p class="text-center mt-3">Already have an account? <a href="/login" class="text-primary">Login</a></p>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

