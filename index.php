<?php
session_start();
require_once 'core/dbconfig.php';
require_once 'core/models.php';

// Check if the user is logged in
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

// The rest of your code for displaying applicants goes here...
$searchQuery = '';
if (isset($_POST['search'])) {
    $searchQuery = $_POST['search'];
    $applicants = searchApplicants($pdo, $searchQuery);
} else {
    $applicants = getAllApplicants($pdo);
}

// Fetch activity logs
$stmt = $pdo->query("SELECT a.*, u.username FROM activity_logs a JOIN users u ON a.user_id = u.id ORDER BY timestamp DESC LIMIT 10");
$logs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Application System</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <!-- Add a logout button at the top -->
        <a href="logout.php" class="btn btn-danger mt-3">Logout</a>

        <h1 class="mt-5">Job Applicants</h1>

        <form method="POST" class="form-inline mb-3">
            <input type="text" name="search" class="form-control" placeholder="Search applicants" value="<?php echo htmlspecialchars($searchQuery); ?>">
            <button type="submit" class="btn btn-primary ml-2">Search</button>
        </form>

        <a href="insert.php" class="btn btn-success mb-3">Add New Applicant</a>
        <a href="index.php" class="btn btn-secondary mb-3">Refresh Table</a>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Subjects</th>
                    <th>Years of Experience</th>
                    <th>Skills</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($applicants): ?>
                    <?php foreach ($applicants as $applicant): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($applicant['first_name']); ?></td>
                            <td><?php echo htmlspecialchars($applicant['last_name']); ?></td>
                            <td><?php echo htmlspecialchars($applicant['email']); ?></td>
                            <td><?php echo htmlspecialchars($applicant['subjects']); ?></td>
                            <td><?php echo htmlspecialchars($applicant['years_of_experience']); ?></td>
                            <td><?php echo htmlspecialchars($applicant['skills']); ?></td>
                            <td>
                                <a href="edit.php?id=<?php echo $applicant['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                <a href="delete.php?id=<?php echo $applicant['id']; ?>" class="btn btn-danger btn-sm">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6">No applicants found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <h2 class="mt-5">Recent Activity Logs</h2>
<table class="table table-bordered mt-3">
    <thead>
        <tr>
            <th>User</th>
            <th>Action</th>
            <th>Details</th>
            <th>Timestamp</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($logs): ?>
            <?php foreach ($logs as $log): ?>
                <tr>
                    <td><?php echo htmlspecialchars($log['username']); ?></td>
                    <td><?php echo htmlspecialchars($log['action_type']); ?></td>
                    <td><?php echo htmlspecialchars($log['details']); ?></td>
                    <td><?php echo htmlspecialchars($log['timestamp']); ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="4">No recent activity found.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
