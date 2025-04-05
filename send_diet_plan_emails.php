<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Include PHPMailer using Composer

// Database connection
$host = 'localhost';
$dbname = 'keto_diet_plan';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Fetch unique user and diet plan details for today's date
$currentDate = date('Y-m-d');
$query = "SELECT DISTINCT r.email, r.name, udp.plan_date, udp.diet_name, udp.diet_details, udp.calorie_count, udp.fat_count, udp.carb_count, udp.protein_count
          FROM user_diet_plans udp 
          JOIN register r ON udp.user_id = r.id
          WHERE udp.plan_date = :currentDate";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':currentDate', $currentDate);
$stmt->execute();
$plans = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Check if there are any diet plans for today
if (empty($plans)) {
    echo "No diet plans to send for today.";
    exit;
}

$sentEmails = []; // To track emails already sent
$outputMessages = []; // To store output messages

foreach ($plans as $plan) {
    if (in_array($plan['email'], $sentEmails)) {
        continue; // Skip sending email if already sent
    }

    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'joobat4@gmail.com'; // Replace with your email
        $mail->Password = 'tuia jhle kbau efeq';  // Replace with your email password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Email recipient
        $mail->setFrom('joobat4@gmail.com', 'Keto Diet Plan System');
        $mail->addAddress($plan['email'], $plan['name']);

        $motivationalMessages = [
            "Remember, every small step you take today brings you closer to your health goals tomorrow!",
            "Stay committed to your journey; every meal is a new opportunity to nourish your body and mind!",
            "Believe in yourself and your ability to achieve your goals; consistency is key to success!",
            "You're not just following a diet; you're embracing a healthier lifestyle. Keep pushing forward!",
            "Every healthy choice you make is a step towards a stronger, healthier you. Keep it up!",
            "Your journey may be challenging, but every effort you make is worth it. Stay focused and motivated!",
            "Success is not just about what you accomplish, but also about what you inspire others to do. Keep shining!"
        ];
        
        $currentDay = date('j'); // Get the current day of the month (1-31)
        $messageIndex = ($currentDay - 1) % count($motivationalMessages); // Get an index based on the day
        $selectedMessage = $motivationalMessages[$messageIndex];

        // Email content
        $mail->isHTML(true);
        $mail->Subject = "Your Keto Diet Plan for " . $plan['plan_date'];
        $mail->Body = "
            <h2>Hello " . htmlspecialchars($plan['name']) . ",</h2>
            <p>Here is your keto diet plan for <strong>" . htmlspecialchars($plan['plan_date']) . "</strong>:</p>
            <ul>
                <li><strong>Diet Name:</strong> " . htmlspecialchars($plan['diet_name']) . "</li>
                <li><strong>Diet Details:</strong> " . htmlspecialchars($plan['diet_details']) . "</li>
                <li><strong>Calorie Count:</strong> " . htmlspecialchars($plan['calorie_count']) . " kcal</li>
                <li><strong>Fat:</strong> " . htmlspecialchars($plan['fat_count']) . " g</li>
                <li><strong>Carbs:</strong> " . htmlspecialchars($plan['carb_count']) . " g</li>
                <li><strong>Protein:</strong> " . htmlspecialchars($plan['protein_count']) . " g</li>
            </ul>
            <p>Stay healthy and keep up with your keto goals!</p>
            <p><strong>$selectedMessage</strong></p>
            <p>Best Regards,<br>Keto Diet Plan Team</p>
        ";

        // Send email
        $mail->send();
        $outputMessages[] = "Email sent to " . htmlspecialchars($plan['email']) . " for diet plan on " . htmlspecialchars($plan['plan_date']);

        // Track sent email
        $sentEmails[] = $plan['email'];
    } catch (Exception $e) {
        $outputMessages[] = "Message could not be sent to " . htmlspecialchars($plan['email']) . ". Mailer Error: {$mail->ErrorInfo}";
    }
}

// Output all messages
foreach ($outputMessages as $message) {
    echo $message . "<br>";
}
?>