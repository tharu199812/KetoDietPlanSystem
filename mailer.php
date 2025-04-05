<?php
// Import the necessary PHPMailer classes.
use PHPMailer\PHPMailer\PHPMailer; // The main PHPMailer class
use PHPMailer\PHPMailer\SMTP; // The SMTP class for sending emails via SMTP
use PHPMailer\PHPMailer\Exception;// The Exception class for handling errors

// Include the Composer autoload file, which loads the PHPMailer library
require __DIR__ . "/vendor/autoload.php";

//Creates and configures a PHPMailer instance
function createMailer(): PHPMailer
{
    $mail = new PHPMailer(true);

    try {
        // Enable SMTP debugging (use SMTP::DEBUG_OFF in production)
        $mail->SMTPDebug = SMTP::DEBUG_OFF; // Change to DEBUG_SERVER for detailed logs in development

        // Server settings
        $mail->Host = 'smtp.gmail.com';
        $mail->Username = 'example@gmail.com'; // Replace with your Gmail
        $mail->Password = 'PASSWORD';            // Use App Password
        $mail->Port = 587; // TLS
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        
        // Email formatting
        $mail->isHTML(true);

        return $mail;
    } catch (Exception $e) {
        echo "Mailer Error: {$e->getMessage()}";
        exit; // Ensure the script stops on failure
    }
}
