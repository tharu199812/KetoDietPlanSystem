<?php

$token = $_POST["token"] ?? die("Token is required.");
$password = $_POST["password"];
$password_confirmation = $_POST["password_confirmation"];

if ($password !== $password_confirmation) {
    die("Passwords do not match.");
}

if (strlen($password) < 8) {
    die("Password must be at least 8 characters.");
}

// Hash the new password
$password_hash = password_hash($password, PASSWORD_DEFAULT);

// Hash the token
$token_hash = hash("sha256", $token);

// Connect to database
$mysqli = require __DIR__ . "/database.php";

// Fetch user with the token
$sql = "SELECT * FROM register
        WHERE reset_token_hash = ? AND reset_token_expire_at > NOW()";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("s", $token_hash);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    die("Invalid or expired token.");
}

// Update the password and clear the token
$sql = "UPDATE register
        SET password_hash = ?, reset_token_hash = NULL, reset_token_expire_at = NULL
        WHERE id = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("si", $password_hash, $user["id"]);
$stmt->execute();

if ($stmt->affected_rows === 0) {
    die("Failed to update password.");
}

echo "Your password has been successfully reset. You can now log in.";
?>
