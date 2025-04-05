<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    die("Unauthorized access. Please register first.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = new mysqli("localhost", "root", "", "keto_diet_plan");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $user_id = $_SESSION['user_id'];
    $questions = [
        "What type of meat do you prefer on a keto diet?",
        "Which type of fish do you enjoy?",
        "What type of dairy products do you consume?",
        "What type of low-carb vegetables do you eat?",
        "What type of healthy fats do you prefer?",
        "What type of nuts do you enjoy?",
        "What type of sweeteners do you use?",
        "What type of snacks do you prefer on a keto diet?",
        "What type of beverages do you consume?",
        "What type of meal prep do you prefer?"
    ];

    foreach ($questions as $key => $question) {
        $answer = $_POST["q" . ($key + 1)]; // Get user's answer
        $stmt = $conn->prepare("INSERT INTO user_answers (user_id, question, answer) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $user_id, $question, $answer);
        $stmt->execute();
        $stmt->close();
    }

    $conn->close();

    // Redirect to login page after saving answers
    echo "<script>
            alert('Answers submitted successfully! Please log in.');
            window.location.href = 'user_login.php';
          </script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Q&A Page</title>
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
        .form-container {
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
    <div class="container mt-5">
        <div class="form-container mt-4">
            <h2 class="text-center">Answer the Following Questions</h2>
            <form method="post">
                <?php
                $questions = [
                    "What type of meat do you prefer on a keto diet?" => ["Chicken", "Beef", "Pork", "Lamb", "All"],
                    "Which type of fish do you enjoy?" => ["Salmon", "Tuna", "Sardines", "Mackerel", "All"],
                    "What type of dairy products do you consume?" => ["Cheese", "Heavy Cream", "Greek Yogurt", "Butter", "All"],
                    "What type of low-carb vegetables do you eat?" => ["Spinach", "Zucchini", "Cauliflower", "Broccoli", "All"],
                    "What type of healthy fats do you prefer?" => ["Olive Oil", "Coconut Oil", "Avocado Oil", "Butter", "All"],
                    "What type of nuts do you enjoy?" => ["Almonds", "Pecans", "Macadamia Nuts", "Walnuts", "All"],
                    "What type of sweeteners do you use?" => ["Stevia", "Erythritol", "Monk Fruit", "Aspartame", "All"],
                    "What type of snacks do you prefer on a keto diet?" => ["Cheese Crisps", "Pork Rinds", "Nut Butter", "Dark Chocolate", "All"],
                    "What type of beverages do you consume?" => ["Water", "Herbal Tea", "Coffee", "Sparkling Water", "All"],
                    "What type of meal prep do you prefer?" => ["Batch Cooking", "Freezing Meals", "Quick Snacks", "Fresh Ingredients", "All"]
                ];
                
                $i = 1;
                foreach ($questions as $question => $options) {
                    echo "<div class='mb-3'><label class='form-label'>$question</label>";
                    echo "<select name='q$i' class='form-control' required>";
                    foreach ($options as $option) {
                        echo "<option value='$option'>$option</option>";
                    }
                    echo "</select></div>";
                    $i++;
                }
                ?>
                <button type="submit" class="btn btn-primary w-100">Submit</button>
            </form>
        </div>    
    </div>
    <br>
</body>
</html>
