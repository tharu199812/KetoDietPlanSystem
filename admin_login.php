<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin Login</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
        <style>
            .footer {
                background-color: #343a40;
                color: white;
                padding: 20px 0;
                text-align: center;
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
                background: url('https://www.matherhospital.org/wp-content/uploads/2020/12/food-control-take-charge-and-take-a-step-towards-healthier-eating-12.18.2020.jpg') no-repeat center center; /* Replace with your image URL */
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

            .login-form {
                background-color: rgba(255, 255, 255, 0.8); /* White background with 80% opacity for transparency */
                border: 2px solid rgba(0, 0, 0, 0.5); /* Black border with 50% opacity */
                border-radius: 8px; /* Rounded corners */
                padding: 20px; /* Padding inside the form */
                max-width: 400px; /* Maximum width of the form */
                margin: 20px auto; /* Center the form horizontally */
                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2); /* Optional shadow for depth */
            }
        </style>    
    </head>
    <body>
        <br><br>
        <div class="text-center">
            <h1>Welcome To Admin Login Page</h1>
        </div><br><br>
        <!--admin login form-->
        <div class="justify-content-center align-items-center vh-100">
            <div class="login-form">
                <h2 class="text-center mb-4">Admin Login</h2>
                <form method="POST" action="admin_login.php">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" id="email" placeholder="Enter your admin email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" id="password" placeholder="Enter your admin password" required>
                    </div>
                    <button type="submit" class="btn btn-danger w-100">Login as Admin</button>
                </form>
                <!--backend logic for admin login form-->
                <?php
                session_start();
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $admin_email = "tharushidissanayaka955@gmail.com";
                    $admin_password = "tvan1982";

                    if ($_POST['email'] === $admin_email && $_POST['password'] === $admin_password) {
                        $_SESSION['admin'] = true;
                        $_SESSION['user_email'] = $admin_email;
                        header("Location: admin.php");
                        exit();
                    } else {
                        echo "<p class='text-danger text-center mt-3'>Invalid Admin Credentials</p>";
                    }
                }
                ?>
            </div>
        </div>

        <!--footer section-->
        <footer class="footer">
            <p>&copy; 2025 Keto Diet Plan. All Rights Reserved.</p>
        </footer>

        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    </body>
</html>
