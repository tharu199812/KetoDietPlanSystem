<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . "/vendor/autoload.php"; // Ensure PHPMailer is autoloaded

// Get the email from the form
$email = $_POST["email"];

// Generate reset token and expiry time
$token = bin2hex(random_bytes(16));
$token_hash = hash("sha256", $token);
$expiry = gmdate("Y-m-d H:i:s", time() + 1800); // UTC time, 30 minutes from now

// Connect to database
$mysqli = require __DIR__ . "/database.php";

// Check if email exists in the database
$sql = "SELECT * FROM register WHERE email = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    die("No account found with that email address.");
}

// Update the reset token and expiry in the database
$sql = "UPDATE register
        SET reset_token_hash = ?, reset_token_expire_at = ?
        WHERE email = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("sss", $token_hash, $expiry, $email);
$stmt->execute();

// Check if the update was successful
if ($stmt->affected_rows === 0) {
    die("Failed to generate reset token. Please try again.");
}

// Set up the email
$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host = "smtp.gmail.com"; // Update with your SMTP server
    $mail->SMTPAuth = true;
    $mail->Username = "example@gmail.com"; // Update with your email
    $mail->Password = "PASSWORD"; // Update with your password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    $mail->setFrom("noreply@example.com", "Keto diet plan");
    $mail->addAddress($email);

    $mail->Subject = "Password Reset Request";
    $mail->isHTML(true);
    $mail->Body = <<<EOT
        <p>Hello {$user['name']},</p>
        <p>We received a request to reset your password. Click the link below to reset your password:</p>
        <p><a href="http://localhost/KetoDietPlanWebsite/reset_password.php?token=$token">Reset Password</a></p>
        <p>This link will expire in 30 minutes (UTC).</p>
        <p>If you did not request this, you can ignore this email.</p>
        <p>Thanks,</p>
        <p> - Keto diet plan -</p>
    EOT;

    $mail->send();
    echo "Password reset email has been sent! Check your inbox.";

} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>
