<?php
session_start();
require 'db.php'; // Include the database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_SESSION['user_id'];
    $name = $_POST['name'];
    $age = $_POST['age'];
    $height = $_POST['height'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    // Prepare and execute the update statement
    $stmt = $mysqli->prepare("UPDATE register SET name = ?, age = ?, height = ?, gender = ?, email = ?, phone = ? WHERE id = ?");
    $stmt->bind_param("sissssi", $name, $age, $height, $gender, $email, $phone, $userId);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Personal details updated successfully!";
        $_SESSION['message_type'] = 'success';
    } else {
        $_SESSION['message'] = "Error updating details. Please try again.";
        $_SESSION['message_type'] = 'error';
    }

    $stmt->close();
    header("Location: settings.php");
    exit();
}
?>