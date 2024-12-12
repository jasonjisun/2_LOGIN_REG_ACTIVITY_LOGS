<?php
session_start();
require_once 'core/dbconfig.php';
require_once 'core/models.php'; // Include models.php to access logActivity

// Log the logout activity
if (isset($_SESSION['user'])) {
    $userId = $_SESSION['user']['id']; // Assuming the user ID is stored in the session
    logActivity($pdo, $userId, 'Logout', 'User logged out.');
}

// Destroy the session
session_destroy();
header('Location: login.php');
exit;
