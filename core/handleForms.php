<?php

if (isset($_POST['submit'])) {
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $email = $_POST['email'];
    $subjects = $_POST['subjects'];
    $experience = $_POST['years_of_experience'];
    $education = $_POST['education'];
    $skills = $_POST['skills'];
    $response = createApplicant($pdo, $firstName, $lastName, $email, $subjects, $experience, $education, $skills);
    $message = $response['message'];
    $statusCode = $response['statusCode'];
}

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $email = $_POST['email'];
    $subjects = $_POST['subjects'];
    $experience = $_POST['years_of_experience'];
    $education = $_POST['education'];
    $skills = $_POST['skills'];
    $response = updateApplicant($pdo, $id, $firstName, $lastName, $email, $subjects, $experience, $education, $skills);
    $message = $response['message'];
    $statusCode = $response['statusCode'];
}


if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $response = deleteApplicant($pdo, $id);
    $message = $response['message'];
    $statusCode = $response['statusCode'];
}
?>