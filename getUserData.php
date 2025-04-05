<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "keto_diet_plan");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Assume user is logged in and we have the user ID from the session
session_start();
$user_id = $_SESSION['user_id'];

// Fetch gender and height from the register table
$sql = "SELECT gender, height FROM register WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$userData = $result->fetch_assoc();

echo json_encode($userData);
?>