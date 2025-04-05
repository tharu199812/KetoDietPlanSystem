<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
    exit();
}

$data = json_decode(file_get_contents("php://input"), true);
$userId = $_SESSION['user_id'];
$planDate = $data['planDate'];
$dietName = $data['dietName'];
$dietDetails = $data['dietDetails'];
$calorieCount = $data['calorieCount'];
$fatCount = $data['fatCount'];
$carbCount = $data['carbCount'];
$proteinCount = $data['proteinCount'];
$duration = $data['duration']; // Get the duration from the request

// Database connection
$host = 'localhost';
$db = 'keto_diet_plan';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Insert diet plan
$stmt = $conn->prepare("INSERT INTO user_diet_plans (user_id, plan_date, diet_name, diet_details, calorie_count, fat_count, carb_count, protein_count, duration) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("isssiiiii", $userId, $planDate, $dietName, $dietDetails, $calorieCount, $fatCount, $carbCount, $proteinCount, $duration);
$stmt->execute();
$stmt->close();
$conn->close();

echo json_encode(['status' => 'success']);
?>