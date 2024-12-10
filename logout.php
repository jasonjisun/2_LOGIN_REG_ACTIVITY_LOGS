<?php
session_start();

// Log the logout activity
logActivity($pdo, $_SESSION['user']['id'], 'Logout', 'User logged out.');

session_destroy();
header('Location: login.php');
exit;

?>