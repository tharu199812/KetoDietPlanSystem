<?php

$token = $_GET["token"] ?? die("Token is required.");

// Hash the token
$token_hash = hash("sha256", $token);

// Connect to database
$mysqli = require __DIR__ . "/database.php";

// Fetch user with the token
$sql = "SELECT * FROM register
        WHERE reset_token_hash = ? AND reset_token_expire_at > NOW()";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("s", $token_hash);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    die("Invalid or expired token.");
}

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Reset Password</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
    </head>
    <body>

        <h1>Reset Password</h1>
        <!--reset password form-->
        <form method="post" action="process_reset_password.php">
            <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">

            <label for="password">New password</label>
            <input type="password" id="password" name="password" required>

            <label for="password_confirmation">Repeat password</label>
            <input type="password" id="password_confirmation" name="password_confirmation" required>

            <button type="submit">Reset Password</button>
        </form>

    </body>
</html>
