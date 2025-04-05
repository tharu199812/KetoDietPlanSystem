<?php
// Database connection
$host = 'localhost'; // Change if necessary
$user = 'root'; // Change to your database username
$pass = ''; // Change to your database password
$db = 'keto_diet_plan'; // Change to your database name

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get calories and duration from the request
$calories = isset($_GET['calories']) ? intval($_GET['calories']) : 0;
$duration = isset($_GET['duration']) ? intval($_GET['duration']) : 0;

// Fetch diet plans that match the calorie count
$stmt = $conn->prepare("SELECT * FROM admindietdetails WHERE calorie_count <= ? ORDER BY calorie_count ASC LIMIT ?");
$stmt->bind_param("ii", $calories, $duration);
$stmt->execute();
$result = $stmt->get_result();

$dietPlans = [];
while ($row = $result->fetch_assoc()) {
    $dietPlans[] = [
        'diteDetails' => $row['diet_plan_description'], 
        'diteName' => $row['diet_plan_name'],
        'calorie' => $row['calorie_count'],
        'fat' => $row['fats'],
        'carb' => $row['carbs'],
        'protein' => $row['protein']
    ];
}

$stmt->close();
$conn->close();

// Return the diet plans as JSON
header('Content-Type: application/json');
echo json_encode($dietPlans);
?>