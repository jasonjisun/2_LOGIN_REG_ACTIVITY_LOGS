<?php
session_start();
require_once 'core/dbconfig.php';
require_once 'core/models.php';

// Check if the user is logged in
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

// Check if an ID is provided for deletion
if (isset($_GET['id'])) {
    $applicantId = $_GET['id'];

    // Fetch the applicant details before deleting (for logging purposes)
    $applicant = getApplicantById($pdo, $applicantId);

    // Delete the applicant from the database
    deleteApplicant($pdo, $applicantId);

    // Log the deletion activity
    logActivity($pdo, $_SESSION['user']['id'], 'Delete Applicant', 'Deleted applicant: ' . $applicant['first_name'] . ' ' . $applicant['last_name']);

    // Redirect back to the applicants list page
    header('Location: index.php');
    exit;
} else {
    // If no ID is provided, redirect to the applicants list page
    header('Location: index.php');
    exit;
}

// Function to fetch the applicant by ID (if not already defined)
function getApplicantById($pdo, $id) {
    $stmt = $pdo->prepare("SELECT * FROM applicants WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Applicant</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Delete Applicant</h1>
        <p>Are you sure you want to delete this applicant?</p>
        <p><strong>Name:</strong> <?php echo htmlspecialchars($applicant['first_name'] . ' ' . $applicant['last_name']); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($applicant['email']); ?></p>

        <form method="POST">
            <button type="submit" class="btn btn-danger">Delete</button>
            <a href="index.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
