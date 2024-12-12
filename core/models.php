<?php
require_once 'dbConfig.php';

// Helper function to log activity
// Log activity function
function logActivity($pdo, $userId, $actionType, $details) {
    $stmt = $pdo->prepare("INSERT INTO activity_logs (user_id, action_type, details, timestamp) VALUES (:user_id, :action_type, :details, NOW())");
    $stmt->bindParam(':user_id', $userId);
    $stmt->bindParam(':action_type', $actionType);
    $stmt->bindParam(':details', $details);
    $stmt->execute();
}



// User Registration
function registerUser($pdo, $username, $email, $password) {
    $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->execute([$username, $email, password_hash($password, PASSWORD_BCRYPT)]);
    return ['statusCode' => 200, 'message' => 'Registration successful'];
}

// User Login
function loginUser($pdo, $username, $password) {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        return ['statusCode' => 200, 'user' => $user];
    }
    return ['statusCode' => 401, 'message' => 'Invalid credentials'];
}

// Get all applicants
function getAllApplicants($pdo) {
    $stmt = $pdo->query("SELECT * FROM applicants");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Search applicants
function searchApplicants($pdo, $query) {
    $stmt = $pdo->prepare("SELECT * FROM applicants WHERE first_name LIKE ? OR last_name LIKE ? OR email LIKE ?");
    $stmt->execute([$query, $query, $query]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Create new applicant
function createApplicant($pdo, $first_name, $last_name, $email, $subjects, $years_of_experience, $education, $skills) {
    // SQL query to insert applicant data
    $query = "INSERT INTO applicants (first_name, last_name, email, subjects, years_of_experience, education, skills) 
              VALUES (:first_name, :last_name, :email, :subjects, :years_of_experience, :education, :skills)";

    // Prepare the statement
    $stmt = $pdo->prepare($query);

    // Bind parameters
    $stmt->bindParam(':first_name', $first_name);
    $stmt->bindParam(':last_name', $last_name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':subjects', $subjects);
    $stmt->bindParam(':years_of_experience', $years_of_experience);
    $stmt->bindParam(':education', $education);
    $stmt->bindParam(':skills', $skills);

    // Execute the statement
    $stmt->execute();
}



// Update applicant
function updateApplicant($pdo, $id, $first_name, $last_name, $email, $subjects, $years_of_experience, $education, $skills, $user_id) {
    $stmt = $pdo->prepare("UPDATE applicants SET first_name = :first_name, last_name = :last_name, email = :email, subjects = :subjects, years_of_experience = :years_of_experience, education = :education, skills = :skills WHERE id = :id");
    $stmt->bindParam(':first_name', $first_name);
    $stmt->bindParam(':last_name', $last_name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':subjects', $subjects);
    $stmt->bindParam(':years_of_experience', $years_of_experience);
    $stmt->bindParam(':education', $education);
    $stmt->bindParam(':skills', $skills);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    
    // Optionally log the activity of the update
    logActivity($pdo, $user_id, 'Update Applicant', "Updated applicant with ID: $id");
}

function getApplicantById($pdo, $id) {
    $stmt = $pdo->prepare("SELECT * FROM applicants WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// core/models.php

function deleteApplicant($pdo, $id) {
    $stmt = $pdo->prepare("DELETE FROM applicants WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
}

?>
