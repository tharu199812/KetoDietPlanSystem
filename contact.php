<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Contact Us</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
        <style>
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
            .footer {
                background-color: #343a40;
                color: white;
                padding: 20px 0;
                text-align: center;
            }
            .navbar {
                background: linear-gradient(to right, rgb(59, 165, 45), white);
            }
            .navbar-nav {
                margin-left: auto;
            }
            .contact-form {
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
                            <a class="nav-link" href="home.php">Home</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <br><br><br>
        <!--contact us form-->
        <div class=" justify-content-center align-items-center vh-100">
            <div class="contact-form">
                <h2 class="text-center mb-4">Contact Us</h2>
                <form id="contactForm" method="post" action="">
                    <div class="mb-3">
                        <label for="name" class="form-label">Full Name</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Enter your name" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" class="form-control" name="email" id="email" placeholder="Enter your email" required>
                    </div>
                    <div class="mb-3">
                        <label for="message" class="form-label">Message</label>
                        <textarea class="form-control" name="message" id="message" rows="5" placeholder="Enter your message" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Submit</button>
                </form>
            </div>
        </div>    
        
        <!--backend logic for contact us form-->
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

            $name = $_POST['name'];
            $email = $_POST['email'];
            $message = $_POST['message'];

            // Prepare and bind
            $stmt = $conn->prepare("INSERT INTO contact (name, email, message) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $name, $email, $message);

            // Execute the statement
            if ($stmt->execute() === TRUE) {
                echo "<p class='text-success text-center mt-3'>Your message has been sent successfully!</p>";
            } else {
                echo "<p class='text-danger text-center mt-3'>Error: " . $stmt->error . "</p>";
            }

            // Close the statement and connection
            $stmt->close();
            $conn->close();
        }
        ?>

        <!--footer section-->
        <footer class="footer">
            <p>&copy; 2025 Keto Diet Plan. All Rights Reserved.</p>
        </footer>

        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    </body>
</html>
