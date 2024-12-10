<?php
require_once 'core/models.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form data
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Register the user and get the response
    $response = registerUser($pdo, $username, $email, $password);
    $message = $response['message'];
    $statusCode = $response['statusCode'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1 class="my-4">Register</h1>
        
        <!-- Displaying registration success or error messages -->
        <?php if (isset($message)): ?>
            <div class="alert alert-<?= $statusCode == 200 ? 'success' : 'danger' ?>">
                <?= $message ?>
            </div>
        <?php endif; ?>

        <!-- Registration form -->
        <form method="POST">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" name="username" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Register</button>
        </form>

        <!-- Link to login page if already have an account -->
        <a href="login.php" class="btn btn-link mt-3">Already have an account? Login</a>
    </div>
</body>
</html>