<?php
session_start();
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    // Redirect non-admin users to login
    header("Location: login.php");
    exit();
}

// Database connection
$host = 'localhost'; // Change if necessary
$db = 'keto_diet_plan'; // Change to your database name
$user = 'root'; // Change to your database username
$pass = ''; // Change to your database password

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if ID is set and is a number
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    // Prepare and execute the delete statement
    $stmt = $conn->prepare("DELETE FROM contact WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();

    // Redirect back to the admin page
    header("Location: admin.php");
    exit();
} else {
    // Invalid ID, redirect or handle error
    header("Location: admin.php");
    exit();
}
?>