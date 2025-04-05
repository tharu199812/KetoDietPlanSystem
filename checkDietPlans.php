<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
    exit();
}

$userId = $_GET['userId'];

// Database connection
$host = 'localhost';
$db = 'keto_diet_plan';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the user has existing diet plans
$result = $conn->query("SELECT COUNT(*) as planCount FROM user_diet_plans WHERE user_id = $userId");
$row = $result->fetch_assoc();

echo json_encode(['hasPlans' => $row['planCount'] > 0]);

$conn->close();
?>