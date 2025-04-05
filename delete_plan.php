<?php
// delete_plan.php

// Database connection
$host = 'localhost'; // Change if necessary
$db = 'keto_diet_plan'; // Change to your database name
$user = 'root'; // Change to your database username
$pass = ''; // Change to your database password

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the plan ID from the POST request
if (isset($_POST['planId'])) {
    $planId = intval($_POST['planId']); // Ensure the ID is an integer

    // Prepare and execute the delete query
    $stmt = $conn->prepare("DELETE FROM admindietdetails WHERE id = ?");
    $stmt->bind_param("i", $planId);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Plan deleted successfully."]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to delete plan."]);
    }

    $stmt->close();
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request. Plan ID not provided."]);
}

$conn->close();
?>