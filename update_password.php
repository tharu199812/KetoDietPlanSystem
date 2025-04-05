<?php
session_start();
require 'db.php'; // Include the database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if the required POST variables are set
    if (isset($_POST['currentPassword'], $_POST['newPassword'], $_POST['confirmNewPassword'])) {
        $currentPassword = $_POST['currentPassword'];
        $newPassword = $_POST['newPassword'];
        $confirmNewPassword = $_POST['confirmNewPassword'];

        // Assuming user ID is stored in session after login
        $userId = $_SESSION['user_id'];

        // Fetch the current password hash from the database
        $stmt = $mysqli->prepare("SELECT password_hash FROM register WHERE id = ?");
        $stmt->bind_param("i", $userId); // Bind the user ID as an integer
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user && password_verify($currentPassword, $user['password_hash'])) {
            if ($newPassword === $confirmNewPassword) {
                $newPasswordHash = password_hash($newPassword, PASSWORD_DEFAULT);
                $updateStmt = $mysqli->prepare("UPDATE register SET password_hash = ? WHERE id = ?");
                $updateStmt->bind_param("si", $newPasswordHash, $userId); // Bind the new password and user ID
                $updateStmt->execute();
                $_SESSION['message'] = "Password updated successfully.";
                $_SESSION['message_type'] = "success"; // Set message type
            } else {
                $_SESSION['message'] = "New passwords do not match.";
                $_SESSION['message_type'] = "error"; // Set message type
            }
        } else {
            $_SESSION['message'] = "Current password is incorrect.";
            $_SESSION['message_type'] = "error"; // Set message type
        }
    } else {
        $_SESSION['message'] = "Please fill in all fields.";
        $_SESSION['message_type'] = "error"; // Set message type
    }

    // Redirect back to the form page
    header("Location: settings.php"); // Change to your settings page URL
    exit();
}
?>