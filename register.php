<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "keto_diet_plan";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get form data
    $name = trim($_POST['name']);
    $age = intval($_POST['age']);
    $height = floatval($_POST['height']);
    $gender = $_POST['gender'];
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    // Check if passwords match
    if ($password !== $confirmPassword) {
        echo "<p class='text-danger text-center mt-3'>Passwords do not match!</p>";
    } else {
        // Hash the password before storing it
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Prepare and bind SQL statement
        $stmt = $conn->prepare("INSERT INTO register (name, age, height, gender, email, phone, password_hash) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sisssss", $name, $age, $height, $gender, $email, $phone, $hashed_password);

        // Execute the statement
        if ($stmt->execute() === TRUE) {
            session_start();
            $_SESSION['user_id'] = $conn->insert_id; // Store registered user ID
            $_SESSION['name'] = $name; 
        
            echo "<script>
                    alert('Registration successful! Please answer the questions.');
                    window.location.href = 'Q&A.php';
                  </script>";
        }
         else {
            echo "<p class='text-danger text-center mt-3'>Unsuccessful registration: " . $stmt->error . "</p>";
        }

        // Close the statement and connection
        $stmt->close();
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>User Registration</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
        <style>
            /* Background image with blur effect */
            body::before {
                content: "";
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: url('https://www.naturemade.com/cdn/shop/articles/healthy-foods-to-eat_960x.jpg?v=1611988563') no-repeat center center;
                background-size: cover;
                filter: blur(10px);
                z-index: -1;
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
            /*registation form effect*/
            .registration-form {
                background-color: rgba(255, 255, 255, 0.8);
                border: 2px solid rgba(0, 0, 0, 0.5);
                border-radius: 8px;
                padding: 20px;
                max-width: 900px;
                margin: 20px auto;
                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            }
            .form-container {
                display: flex;
                gap: 20px;
            }
            /*registration form field divided to 2 column effect*/
            .left-section {
                flex: 2;
            }
            .right-section {
                flex: 2;
                display: flex;
                flex-direction: column;
                justify-content: space-between;
            }
        </style>
    </head>
    <body>
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
                            <a class="nav-link" href="home.php">Home</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="d-flex justify-content-center align-items-center vh-100">
            <div class="registration-form">
                <h2 class="text-center mb-4">Register</h2>
                <form id="registerForm" method="post" action="register.php">
                    <div class="form-container">
                        <div class="left-section">
                            <div class="form-group mb-3">
                                <label for="name" class="form-label">Full Name</label>
                                <input type="text" class="form-control" name="name" id="name" placeholder="Enter your name" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="age" class="form-label">Age</label>
                                <input type="number" class="form-control" name="age" id="age" placeholder="Enter your age" min="1" max="120" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="height" class="form-label">Height (cm)</label>
                                <input type="number" class="form-control" name="height" id="height" placeholder="Enter your height in cm" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="gender" class="form-label">Gender</label>
                                <select class="form-control" name="gender" id="gender" required>
                                    <option value="" disabled selected>Select your gender</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label for="phone" class="form-label">Phone Number</label>
                                <input type="tel" class="form-control" name="phone" id="phone" placeholder="Enter your phone number" pattern="[0-9]{10}" required>
                                <small class="form-text text-muted">Enter a 10-digit phone number.</small>
                            </div>
                        </div>
                        <div class="right-section">
                            <div class="form-group mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" class="form-control" name="email" id="email" placeholder="Enter your email" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" name="password" id="password" placeholder="Enter your password" minlength="6" required>
                                <small class="form-text text-muted">Password must be at least 6 characters long.</small>
                            </div>
                            <div class="form-group mb-3">
                                <label for="confirmPassword" class="form-label">Confirm Password</label>
                                <input type="password" class="form-control" name="confirmPassword" id="confirmPassword" placeholder="Confirm your password" minlength="6" required>
                            </div>
                            <p class="text-center mt-4">
                                Already have an account? <a href="user_login.php">Log In</a>
                            </p>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary w-100">Register</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <footer class="footer">
            <p>&copy; 2025 Keto Diet Plan. All Rights Reserved.</p>
        </footer>

        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    </body>
</html>