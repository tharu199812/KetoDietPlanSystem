<?php
session_start();
require 'database.php'; // Include the database connection

// Assuming user ID is stored in session after login
$userId = $_SESSION['user_id'];

// Fetch current user details
$stmt = $mysqli->prepare("SELECT name, age, height, gender, email, phone FROM register WHERE id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Settings</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
        <style>
            /*background effect*/
            body::before {
                content: ""; /* Required for pseudo-elements */
                position: fixed; /* Change to fixed to keep it in place */
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: url('https://www.naturemade.com/cdn/shop/articles/healthy-foods-to-eat_960x.jpg?v=1611988563') no-repeat center center; /* Replace with your image URL */
                background-size: cover; /* Cover the entire area */
                filter: blur(10px); /* Apply blur effect */
                z-index: -1; /* Place it behind all other content */
            }
            /*footer effect*/
            .footer {
                background-color: #343a40;
                color: white;
                padding: 20px 0;
                text-align: center;
            }
            /*navibar effect*/
            .navbar {
                background: linear-gradient(to right, rgb(59, 165, 45), white);
            }
            .navbar-nav {
                margin-left: auto;
            }
            /*settings form 1 (password reset) effect*/
            .settings-form1 {
                background-color: rgba(255, 255, 255, 0.8); /* White background with 80% opacity for transparency */
                border: 2px solid rgba(0, 0, 0, 0.5); /* Black border with 50% opacity */
                border-radius: 8px; /* Rounded corners */
                padding: 20px; /* Padding inside the form */
                max-width: 400px; /* Maximum width of the form */
                margin: 20px auto; /* Center the form horizontally */
                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2); /* Optional shadow for depth */
            }
            /*settings form 2 (personal details update) effect*/
            .settings-form2 {
                background-color: rgba(255, 255, 255, 0.8); /* White background with 80% opacity for transparency */
                border: 2px solid rgba(0, 0, 0, 0.5); /* Black border with 50% opacity */
                border-radius: 8px; /* Rounded corners */
                padding: 20px; /* Padding inside the form */
                max-width: 400px; /* Maximum width of the form */
                margin: 20px auto; /* Center the form horizontally */
                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2); /* Optional shadow for depth */
            }
            .settings-container {
                display: flex;
                justify-content: space-between;
                align-items: flex-start; /* Aligns the forms to the top */
            }
            .settings-form1, .settings-form2 {
                flex: 1; /* Allows the forms to grow and shrink */
                max-width: 45%; /* Limits the maximum width of each form */
                margin: 0 10px; /* Adds some space between the forms */
            }
        </style>
    </head>
    <body>
        <!--navigation bar-->
        <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">
                    <img src="3.png" alt="Keto Diet Plan Logo" class="rounded-circle" style="width: 50px; height: 50px;"> Keto Diet Plan
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="dashboard.php">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-danger" href="logout.php">Logout</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav> 
        <br><br><br><br><br>
        <div class="settings-container d-flex justify-content-between">
            <!-- Update Password Form -->
            <div class="settings-form1">
                <h2 class="text-center mb-4">Update Password</h2>
                <form id="passwordForm" action="update_password.php" method="POST">
                    <div class="mb-3">
                        <label for="currentPassword" class="form-label">Current Password</label>
                        <input type="password" class="form-control" name="currentPassword" id="currentPassword" placeholder="Enter current password" required>
                    </div>
                    <div class="mb-3">
                        <label for="newPassword" class="form-label">New Password</label>
                        <input type="password" class="form-control" name="newPassword" id="newPassword" placeholder="Enter new password" required>
                    </div>
                    <div class="mb-3">
                        <label for="confirmNewPassword" class="form-label">Confirm New Password</label>
                        <input type="password" class="form-control" name="confirmNewPassword" id="confirmNewPassword" placeholder="Confirm new password" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Update Password</button>
                </form>
                <div id="message" class="mt-3">
                    <?php
                    if (isset($_SESSION['message'])) {
                        $messageType = $_SESSION['message_type'] === 'success' ? 'text-success' : 'text-danger';
                        echo "<div class='$messageType'>{$_SESSION['message']}</div>";
                        unset($_SESSION['message']); // Clear the message after displaying
                        unset($_SESSION['message_type']); // Clear the message type after displaying
                    }
                    ?>
                </div>
            </div>

            <!-- Update Personal Details Form -->
            <div class="settings-form2">
                <h2 class="text-center mb-4">Update Personal Details</h2>
                    <form id="personalDetailsForm" action="update_personal_details.php" method="POST">
                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name</label>
                            <input type="text" class="form-control" name="name" id="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="age" class="form-label">Age</label>
                            <input type="number" class="form-control" name="age" id="age" value="<?php echo htmlspecialchars($user['age']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="height" class="form-label">Height</label>
                            <input type="text" class="form-control" name="height" id="height" value="<?php echo htmlspecialchars($user['height']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="gender" class="form-label">Gender</label>
                            <select class="form-control" name="gender" id="gender" required>
                                <option value="male" <?php echo $user['gender'] === 'male' ? 'selected' : ''; ?>>Male</option>
                                <option value="female" <?php echo $user['gender'] === 'female' ? 'selected' : ''; ?>>Female</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" id="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="text" class="form-control" name="phone" id="phone" value="<?php echo htmlspecialchars($user['phone']); ?>" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Update Details</button>
                    </form>
                    <div id="message" class="mt-3">
                        <?php
                        if (isset($_SESSION['message'])) {
                            $messageType = $_SESSION['message_type'] === 'success' ? 'text-success' : 'text-danger';
                            echo "<div class='$messageType'>{$_SESSION['message']}</div>";
                            unset($_SESSION['message']); // Clear the message after displaying
                            unset($_SESSION['message_type']); // Clear the message type after displaying
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <br><br>
        <!--footer section-->
        <footer class="footer">
            <p>&copy; 2025 Keto Diet Plan. All Rights Reserved.</p>
        </footer>

        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    </body>
</html>
