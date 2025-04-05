<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    echo json_encode(['error' => 'Unauthorized']);
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

// Fetch the start date and duration
$result = $conn->query("SELECT plan_date, duration FROM user_diet_plans WHERE user_id = $userId LIMIT 1");

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo json_encode(['startDate' => $row['plan_date'], 'duration' => $row['duration']]);
} else {
    // No diet plans found
    echo json_encode(['startDate' => null, 'duration' => 0]);
}

$conn->close();
?>