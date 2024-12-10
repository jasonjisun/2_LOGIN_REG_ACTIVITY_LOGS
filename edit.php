<?php
session_start();
require_once 'core/dbconfig.php';
require_once 'core/models.php';

// Check if the user is logged in
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

// Fetch the applicant details if an ID is provided
if (isset($_GET['id'])) {
    $applicantId = $_GET['id'];
    $applicant = getApplicantById($pdo, $applicantId);
} else {
    header('Location: index.php');
    exit;
}

// Handle form submission for editing the applicant
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the updated data from the form
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $subjects = $_POST['subjects'];
    $years_of_experience = $_POST['years_of_experience'];
    $education = $_POST['education'];
    $skills = $_POST['skills'];

    // Update the applicant information in the database
    updateApplicant($pdo, $applicantId, $first_name, $last_name, $email, $subjects, $years_of_experience, $education, $skills);

    // Log the edit activity
    logActivity($pdo, $_SESSION['user']['id'], 'Edit Applicant', 'Edited applicant: ' . $first_name . ' ' . $last_name);

    // Redirect to the index page after the edit
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
    <title>Edit Applicant</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Edit Applicant</h1>

        <form method="POST" class="mt-4">
            <div class="form-group">
                <label for="first_name">First Name</label>
                <input type="text" name="first_name" class="form-control" value="<?php echo htmlspecialchars($applicant['first_name']); ?>" required>
            </div>
            <div class="form-group">
                <label for="last_name">Last Name</label>
                <input type="text" name="last_name" class="form-control" value="<?php echo htmlspecialchars($applicant['last_name']); ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($applicant['email']); ?>" required>
            </div>
            <div class="form-group">
                <label for="subjects">Subjects</label>
                <input type="text" name="subjects" class="form-control" value="<?php echo htmlspecialchars($applicant['subjects']); ?>" required>
            </div>
            <div class="form-group">
                <label for="years_of_experience">Years of Experience</label>
                <input type="number" name="years_of_experience" class="form-control" value="<?php echo htmlspecialchars($applicant['years_of_experience']); ?>" required>
            </div>
            <div class="form-group">
                <label for="education">Education</label>
                <input type="text" name="education" class="form-control" value="<?php echo htmlspecialchars($applicant['education']); ?>" required>
            </div>
            <div class="form-group">
                <label for="skills">Skills</label>
                <textarea name="skills" class="form-control" required><?php echo htmlspecialchars($applicant['skills']); ?></textarea>
            </div>

            <button type="submit" class="btn btn-primary mt-3">Update Applicant</button>
        </form>

        <a href="index.php" class="btn btn-secondary mt-3">Back to Applicants</a>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
