<?php
require_once 'core/models.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $response = loginUser($pdo, $username, $password);

    if ($response['statusCode'] == 200) {
        session_start();
        $_SESSION['user'] = $response['user'];

        // Log the login activity
        logActivity($pdo, $response['user']['id'], 'Login', 'User logged in successfully.');

        header('Location: index.php');
        exit;
    } else {
        $message = $response['message'];
        $statusCode = $response['statusCode'];
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1 class="my-4">Login</h1>
        
        <?php if (isset($message)): ?>
            <div class="alert alert-danger"><?= $message ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" name="username" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>

        <a href="register.php" class="btn btn-link mt-3">Don't have an account? Register</a>
    </div>
</body>
</html>