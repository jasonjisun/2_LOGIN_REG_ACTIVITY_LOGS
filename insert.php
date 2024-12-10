<?php
session_start();
require_once 'core/dbconfig.php';
require_once 'core/models.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve data from the form
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $subjects = $_POST['subjects'];
    $years_of_experience = $_POST['years_of_experience'];
    $education = $_POST['education'];
    $skills = $_POST['skills'];

    // Call the createApplicant function
    createApplicant($pdo, $first_name, $last_name, $email, $subjects, $years_of_experience, $education, $skills);

    // Log the activity
    logActivity($pdo, $_SESSION['user']['id'], 'Create Applicant', 'Created a new applicant: ' . $first_name . ' ' . $last_name);

    header("Location: index.php"); // Redirect back to index page after submission
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Applicant</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Add New Applicant</h1>

        <form method="POST" class="mt-4">
            <div class="form-group">
                <label for="first_name">First Name</label>
                <input type="text" name="first_name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="last_name">Last Name</label>
                <input type="text" name="last_name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="subjects">Subjects</label>
                <input type="text" name="subjects" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="years_of_experience">Years of Experience</label>
                <input type="number" name="years_of_experience" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="education">Education</label>
                <input type="text" name="education" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="skills">Skills</label>
                <textarea name="skills" class="form-control" required></textarea>
            </div>

            <button type="submit" class="btn btn-success mt-3">Add Applicant</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>