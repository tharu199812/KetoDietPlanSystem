<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
    exit();
}

$userId = $_SESSION['user_id'];

// Database connection
$host = 'localhost';
$db = 'keto_diet_plan';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Delete user diet plans
$stmt = $conn->prepare("DELETE FROM user_diet_plans WHERE user_id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$stmt->close();
$conn->close();

echo json_encode(['status' => 'success', 'message' => 'All diet plans cleared.']);
?>