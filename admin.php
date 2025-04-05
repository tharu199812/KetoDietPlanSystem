<?php
session_start();
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    // Redirect non-admin users to login
    header("Location: admin_login.php");
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

// Insert diet plan
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $planName = $_POST['planName'];
    $description = $_POST['description'];
    $calories = $_POST['calories'];
    $fats = $_POST['fats'];
    $protein = $_POST['protein'];
    $carbs = $_POST['carbs'];

    $stmt = $conn->prepare("INSERT INTO admindietdetails (diet_plan_name, calorie_count, fats, protein, carbs, diet_plan_description) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sissss", $planName, $calories, $fats, $protein, $carbs, $description);
    $stmt->execute();
    $stmt->close();
}

// Fetch contact messages
$contactMessages = $conn->query("SELECT * FROM contact");
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin Page - Home</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <style>
            body {
                background-color: #f8f9fa;
            }
            .card {
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            }
            .navbar {
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            }
            .table-container, .form-container {
                margin-top: 20px;
            }
            body {
                margin: 0; /* Remove default margin */
                height: 100vh; /* Ensure body takes full height */
            }

            body::before {
                content: ""; /* Required for pseudo-elements */
                position: fixed; /* Fix the position to the viewport */
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: url('https://www.naturemade.com/cdn/shop/articles/healthy-foods-to-eat_960x.jpg?v=1611988563') no-repeat center center; /* Replace with your image URL */
                background-size: cover; /* Cover the entire area */
                filter: blur(10px); /* Apply blur effect */
                z-index: -1; /* Place it behind all other content */
            }

            .content {
                position: relative; /* Position content relative to the body */
                z-index: 1; /* Ensure content is above the background */
                padding: 20px; /* Add some padding */
                color: white; /* Change text color for visibility */
                height: 200vh; /* Set height to allow scrolling */
                overflow-y: auto; /* Allow scrolling for content */
            }

            #loadingIcon {
                display: none; /* Initially hidden */
                margin-left: 10px; /* Space between button and icon */
            }
        </style>
    </head>
    <body>
        <!-- Navbar -->
        <nav class="navbar navbar-dark bg-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Keto Diet Plan - Admin Dashboard</a>
                <a href="admin.php" class="btn btn-outline-light">Home</a>
                <a href="adminView.php" class="btn btn-outline-light">Manage Diet Plans</a>
                <a href="admin_Q&A_result.php" class="btn btn-outline-light">Q & A Results</a>
                <a href="admin_login.php" class="btn btn-danger">Logout</a>           
            </div>
        </nav>
        <div class="content">
            <div class="container mt-4">
                <!-- Form to Apply Diet Plan -->
                <div class="form-container">
                    <div class="card">
                        <div class="card-header bg-success text-white">
                            <h5>Apply Diet Plan</h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="">
                                <div class="mb-3">
                                    <label for="planName" class="form-label">Plan Name</label>
                                    <input type="text" class="form-control" name="planName" placeholder="Enter the diet plan name" required>
                                </div>
                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control" name="description" rows="3" placeholder="Describe the diet plan" required></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="calories" class="form-label">Calories (kcal)</label>
                                    <input type="number" class="form-control" name="calories" placeholder="Enter total calories" required>
                                </div>
                                <div class="mb-3">
                                    <label for="fats" class="form-label">Fats (%)</label>
                                    <input type="number" class="form-control" name="fats" placeholder="Add fats as percentage" required>
                                </div>
                                <div class="mb-3">
                                    <label for="protein" class="form-label">Protein (%)</label>
                                    <input type="number" class="form-control" name="protein" placeholder="Add protein as percentage" required>
                                </div>
                                <div class="mb-3">
                                    <label for="carbs" class="form-label">Carbs (%)</label>
                                    <input type="number" class="form-control" name="carbs" placeholder="Add carbs as percentage" required>
                                </div>
                                <button type="submit" class="btn btn-success w-100">Submit Plan</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- View Contact Us Data -->
                <div class="table-container">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h5>Contact Us Data</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped">
                                <thead class="table-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Message</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!--table data retrieve from database - this is backend code for that-->
                                    <?php
                                    if ($contactMessages->num_rows > 0) {
                                        while($row = $contactMessages->fetch_assoc()) {
                                            echo "<tr>
                                                    <td>{$row['id']}</td>
                                                    <td>{$row['name']}</td>
                                                    <td>{$row['email']}</td>
                                                    <td>{$row['message']}</td>
                                                    <td>
                                                        <a href='delete_message.php?id={$row['id']}' class='btn btn-sm btn-danger' onclick='return confirm(\"Are you sure you want to delete this message?\")'>Delete</a>
                                                    </td>
                                                </tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='5'>No messages found.</td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div><br>

                <button id="sendEmailsButton" class="btn btn-success">Send Diet Plans & Motivationl Emails</button>
                <img id="loadingIcon" src="https://www.unboundb2b.com/wp-content/themes/twentytwentyone-child/images/Spin-career.gif" alt="Loading..." width="20" height="20"> <!-- Loading icon -->
                <div id="messageArea"></div>

                <script>
                    $(document).ready(function() {
                        $('#sendEmailsButton').click(function() {
                            $('#messageArea').html(''); // Clear previous messages
                            $('#loadingIcon').show(); // Show loading icon

                            $.ajax({
                                url: 'send_diet_plan_emails.php',
                                type: 'POST',
                                success: function(response) {
                                    $('#loadingIcon').hide(); // Hide loading icon
                                    $('#messageArea').html(response); // Display the response messages
                                },
                                error: function() {
                                    $('#loadingIcon').hide(); // Hide loading icon
                                    $('#messageArea').html('An error occurred while sending emails.');
                                }
                            });
                        });
                    });
                </script>

            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            //user message delete button logic
            function deleteMessage(messageId) {
                if (confirm("Are you sure you want to delete this message?")) {
                    // Make an AJAX call or redirect to a backend script to delete the message
                    console.log("Deleting message with ID:", messageId);
                    alert("Message deleted successfully! (This is a placeholder)");
                }
            }
        </script>
    </body>
</html>