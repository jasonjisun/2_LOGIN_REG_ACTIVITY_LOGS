<?php
session_start();
require_once 'core/dbconfig.php';
require_once 'core/models.php';

// Check if the user is logged in
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

// Get the logged-in user's ID
$user_id = $_SESSION['user']['id']; // Assuming the user ID is stored in the session

// If the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $id = $_POST['id']; // The applicant's ID to be updated
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $subjects = $_POST['subjects'];
    $years_of_experience = $_POST['years_of_experience'];
    $education = $_POST['education'];
    $skills = $_POST['skills'];

    // Call the updateApplicant function
    updateApplicant($pdo, $id, $first_name, $last_name, $email, $subjects, $years_of_experience, $education, $skills, $user_id);

    // Optionally, log the activity here if not done in updateApplicant itself
    logActivity($pdo, $user_id, 'Update Applicant', "Updated applicant with ID: $id");

    // Redirect back to the applicants page
    header("Location: index.php");
    exit;
}

// Retrieve applicant details for editing
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $applicant = getApplicantById($pdo, $id);
} else {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Applicant</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Edit Applicant</h1>

        <form method="POST">
            <input type="hidden" name="id" value="<?= htmlspecialchars($applicant['id']); ?>">
            <div class="form-group">
                <label for="first_name">First Name</label>
                <input type="text" name="first_name" class="form-control" value="<?= htmlspecialchars($applicant['first_name']); ?>" required>
            </div>
            <div class="form-group">
                <label for="last_name">Last Name</label>
                <input type="text" name="last_name" class="form-control" value="<?= htmlspecialchars($applicant['last_name']); ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($applicant['email']); ?>" required>
            </div>
            <div class="form-group">
                <label for="subjects">Subjects</label>
                <input type="text" name="subjects" class="form-control" value="<?= htmlspecialchars($applicant['subjects']); ?>" required>
            </div>
            <div class="form-group">
                <label for="years_of_experience">Years of Experience</label>
                <input type="number" name="years_of_experience" class="form-control" value="<?= htmlspecialchars($applicant['years_of_experience']); ?>" required>
            </div>
            <div class="form-group">
                <label for="education">Education</label>
                <input type="text" name="education" class="form-control" value="<?= htmlspecialchars($applicant['education']); ?>" required>
            </div>
            <div class="form-group">
                <label for="skills">Skills</label>
                <textarea name="skills" class="form-control" required><?= htmlspecialchars($applicant['skills']); ?></textarea>
            </div>

            <button type="submit" class="btn btn-success mt-3">Update Applicant</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
