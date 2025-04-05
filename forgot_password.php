<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Forgot Password</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
        <style>
            body::before {
                content: ""; /* Required for pseudo-elements */
                position: absolute; /* Position it absolutely within the body */
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: url('https://www.naturemade.com/cdn/shop/articles/healthy-foods-to-eat_960x.jpg?v=1611988563') no-repeat center center; /* Replace with your image URL */
                background-size: cover; /* Cover the entire area */
                filter: blur(10px); /* Apply blur effect */
                z-index: -1; /* Place it behind all other content */
            }
            .forgot-password-form {
                background-color: rgba(255, 255, 255, 0.8); /* White background with 80% opacity for transparency */
                border: 2px solid rgba(0, 0, 0, 0.5); /* Black border with 50% opacity */
                border-radius: 8px; /* Rounded corners */
                padding: 20px; /* Padding inside the form */
                max-width: 1000px; /* Maximum width of the form */
                margin: 20px auto; /* Center the form horizontally */
                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2); /* Optional shadow for depth */
            }
        </style>
    </head>
    <body>
        <div class="d-flex align-items-center vh-100">
            <div class="forgot-password-form">
                <h2 class="text-center mb-4">Forgot Password</h2>
                <form method="post" action="send_password_rest.php">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" class="form-control" name="email" id="email" placeholder="Enter your registered email" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Send Recovery Email</button>
                </form>
                <div class="text-center mt-3">
                    <a href="user_login.php" class="text-primary">Back to Login</a>
                </div>
            </div>
        </div>    
    </body>
</html>
