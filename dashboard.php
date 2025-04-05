<?php
// Start the session to manage user authentication
session_start();

// Check if the user is logged in; if not, redirect to the login page
if (!isset($_SESSION['user_id'])) {
    header("Location: user_login.php");
    exit();
}

// Database connection
$host = 'localhost'; // 
$db = 'keto_diet_plan'; // database name
$user = 'root'; // database username
$pass = ''; // database password

// Create a new MySQLi connection
$conn = new mysqli($host, $user, $pass, $db);

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch user data including age
$userId = $_SESSION['user_id'];
$userResult = $conn->query("SELECT age FROM register WHERE id = $userId");

// Check if user data is found and retrieve age
if ($userResult->num_rows > 0) {
    $userData = $userResult->fetch_assoc();
    $userAge = $userData['age']; // Get the user's age
} else {
    $userAge = 30; // Default value if user not found (should not happen)
}

// Fetch user data including name
$userId = $_SESSION['user_id'];
$userResult = $conn->query("SELECT name FROM register WHERE id = $userId");

// Check if user data is found and retrieve name
if ($userResult->num_rows > 0) {
    $userData = $userResult->fetch_assoc();
    $userName = $userData['name']; // Get the user's name
} else {
    $userName = "Guest"; // Default value if user not found (should not happen)
}

// Function to generate the calendar for the current month
function generateCalendar($userId, $conn, $duration) {
    $currentDate = new DateTime();
    $startDate = new DateTime($currentDate->format('Y-m-d'));
    $endDate = (clone $startDate)->modify("+$duration days");

    // Fetch user's diet plans for the specified duration
    $dietPlans = [];
    $result = $conn->query("SELECT plan_date, diet_name, diet_details, calorie_count, fat_count, carb_count, protein_count FROM user_diet_plans WHERE user_id = $userId AND plan_date BETWEEN '{$startDate->format('Y-m-d')}' AND '{$endDate->format('Y-m-d')}'");
    // Store diet plans by date
    while ($row = $result->fetch_assoc()) {
        $dietPlans[$row['plan_date']] = $row; // Store diet plans by date
    }

    // Start building the calendar HTML
    $calendarHtml = '<div class="calendar mt-4">';
    // Create the header for the days of the week
    $calendarHtml .= '<div class="day">Sun</div><div class="day">Mon</div><div class="day">Tue</div><div class="day">Wed</div><div class="day">Thu</div><div class="day">Fri</div><div class="day">Sat</div>';

    // Fill in the days of the month
    for ($day = 0; $day < $duration; $day++) {
        $currentDay = (clone $startDate)->modify("+$day days");
        $isToday = $currentDay->format('Y-m-d') === $currentDate->format('Y-m-d');
        $dietDetails = isset($dietPlans[$currentDay->format('Y-m-d')]) ? $dietPlans[$currentDay->format('Y-m-d')] : null;

        // Highlight the current day
        $class = $isToday ? 'current-day' : '';

        // Build the HTML for the current day
        $calendarHtml .= '<div class="day ' . $class . '">';
        $calendarHtml .= $currentDay->format('Y-m-d') . '<br>'; // Show day of the month
        if ($dietDetails) {
            // Display diet details if available
            $calendarHtml .= "<strong>Diet:</strong> {$dietDetails['diet_name']}<br>";
            $calendarHtml .= "<strong>Details:</strong> {$dietDetails['diet_details']}<br>";
            $calendarHtml .= "<strong>Calories:</strong> {$dietDetails['calorie_count']}<br>";
            $calendarHtml .= "<strong>Fats:</strong> {$dietDetails['fat_count']}g<br>";
            $calendarHtml .= "<strong>Carbs:</strong> {$dietDetails['carb_count']}g<br>";
            $calendarHtml .= "<strong>Protein:</strong> {$dietDetails['protein_count']}g<br>";
        } else {
            // If no diet plan, show a message
            $calendarHtml .= "No diet plan<br>";
        }
        $calendarHtml .= '</div>';// Close the day div
    }

    $calendarHtml .= '</div>'; // Close the calendar div
    return $calendarHtml; // Return the generated calendar HTML
}

// Fetch user preferences including duration
$userId = $_SESSION['user_id'];
$result = $conn->query("SELECT duration FROM user_diet_plans WHERE user_id = $userId");

$duration = 7; // Default value
if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $duration = intval($row['duration']); // Fetch the duration from the database
}

// Call the function to generate the calendar
$calendarHtml = generateCalendar($userId, $conn, $duration);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Dashboard - Diet Plan</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
        <style>
            /* Background image with blur effect */
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
            /* Footer styling */
            .footer {
                background-color: #343a40;
                color: white;
                padding: 20px 0;
                text-align: center;
            }
            /* Navbar styling */
            .navbar {
                background: linear-gradient(to right, rgb(59, 165, 45), white);
            }
            .navbar-nav {
                margin-left: auto;
            }
            /* Diet plan schedule form styling */
            .diet-plan-schedule-form {
                background-color: rgba(255, 255, 255, 0.8); /* White background with 80% opacity for transparency */
                border: 2px solid rgba(0, 0, 0, 0.5); /* Black border with 50% opacity */
                border-radius: 8px; /* Rounded corners */
                padding: 20px; /* Padding inside the form */
                max-width: 400px; /* Maximum width of the form */
                margin: 20px auto; /* Center the form horizontally */
                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2); /* Optional shadow for depth */
            }
            /* Calendar styling */
            .calendar { 
                display: grid; 
                grid-template-columns: repeat(7, 1fr); 
                gap: 10px; margin-top: 20px; 
            } 
            .calendar .day { 
                background: #ffffff; border: 1px solid #dee2e6; 
                padding: 15px; text-align: center; border-radius: 5px; 
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); 
            }    
            .day.current-day { 
                background: #007bff; color: white;
            }
            /* Header styling */
            h4 {
                font-size: 30px; /* Adjust the size as needed */
                color: white; /* Text color */
                text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5); /* Shadow effect */
            }
        </style>
    </head>
    <body>
        <!--navigation bar-->
        <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
            <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="3.png" alt="Keto Diet Plan Logo" class="rounded-circle" style="width: 50px; height: 50px;"> Keto Diet Plan - Welcome 
                <?php echo htmlspecialchars($userName); ?>
            </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="settings.php">Settings</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="nutritionSearch.php">Search</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-danger" href="logout.php">Logout</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>    

        <div class="container mt-4"><br>
            <!-- Diet Plan Schedule Form -->
            <div class="diet-plan-schedule-form mt-4">
                <h2>Schedule Your Diet Plan</h2>
                <form id="dietPlanScheduleForm">
                    <div class="mb-3">
                        <label for="startDate" class="form-label">Start Date</label>
                        <input type="date" class="form-control" id="startDate" required min="">
                        <!--day chosing validation-->
                        <script>
                            document.addEventListener("DOMContentLoaded", function () {
                                // Set the minimum date to today's date
                                const today = new Date().toISOString().split('T')[0]; // Get today's date
                                document.getElementById("startDate").setAttribute("min", today); // Set min attribute
                            });
                        </script>
                    </div>
                    <div class="mb-3">
                        <label for="duration" class="form-label">Duration</label>
                        <select class="form-control" id="duration" required>
                            <option value="21">21 days</option>
                            <option value="30">30 days</option>
                            <option value="45">45 days</option>
                            <option value="60">60 days</option>
                            <option value="90">90 days</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="activityLevel" class="form-label">Activity Level</label>
                        <select class="form-control" id="activityLevel" required>
                            <option value="1.2">Sedentary (little/no exercise)</option>
                            <option value="1.375">Lightly active (1-3 days/week)</option>
                            <option value="1.55">Moderately active (3-5 days/week)</option>
                            <option value="1.725">Very active (6-7 days/week)</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="currentWeight" class="form-label">Current Weight (kg)</label>
                        <input type="number" class="form-control" id="currentWeight" placeholder="Enter your current weight" required>
                    </div>
                    <div class="mb-3">
                        <label for="targetWeight" class="form-label">Target Weight (kg)</label>
                        <input type="number" class="form-control" id="targetWeight" placeholder="Enter your target weight" required>
                    </div>
                    <div class="mb-3">
                        <label for="gender" class="form-label">Gender</label>
                        <input type="text" class="form-control" id="gender" value="" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="height" class="form-label">Height (cm)</label>
                        <input type="number" class="form-control" id="height" value="" readonly>
                    </div>
                    <!--Age Group Selection-->
                    <div class="mb-3">
                        <label for="ageGroup" class="form-label">Age Group</label>
                        <select class="form-control" id="ageGroup" required>
                            <option value="18-25">18-25</option>
                            <option value="26-35">26-35</option>
                            <option value="36-45">36-45</option>
                            <option value="46-60">46-60</option>
                            <option value="60+">60+</option>
                        </select>
                    </div>
                    <!--diet plan generate button-->
                    <button type="submit" class="btn btn-primary w-100">Generate Diet Plan</button>
                    <script>
                        //genedar, height selection form register table
                        document.addEventListener("DOMContentLoaded", function () {
                            fetch("getUserData.php")
                                .then(response => response.json())
                                .then(data => {
                                    // Populate the gender and height fields
                                    document.getElementById("gender").value = data.gender || "N/A";
                                    document.getElementById("height").value = data.height || "0";
                                })
                                .catch(error => console.error("Error fetching user data:", error));
                        });

                        //calcualtion part - logics
                        document.getElementById("dietPlanScheduleForm").addEventListener("submit", function (e) {
                            e.preventDefault();

                            // Check if the user has existing diet plans
                            fetch(`checkDietPlans.php?userId=<?php echo $_SESSION['user_id']; ?>`)
                                .then(response => response.json())
                                .then(data => {
                                    if (data.hasPlans) {
                                        alert("You must clear your current diet plans before generating a new schedule.");
                                        return; // Stop the form submission
                                    }

                                    // Gather all input values
                                    const startDate = document.getElementById("startDate").value;
                                    const duration = document.getElementById("duration").value;
                                    const activityLevel = document.getElementById("activityLevel").value;
                                    const currentWeight = parseFloat(document.getElementById("currentWeight").value);
                                    const targetWeight = parseFloat(document.getElementById("targetWeight").value);
                                    const gender = document.getElementById("gender").value;
                                    const height = parseFloat(document.getElementById("height").value);
                                    const ageGroup = document.getElementById("ageGroup").value;

                                    // Use the PHP variable for age
                                    const userAge = <?php echo $userAge; ?>; // Embed PHP variable into JavaScript

                                    // Calculate healthy weight range based on height and gender
                                    const heightInMeters = height / 100; // Convert height to meters
                                    const minHealthyWeight = 18.5 * (heightInMeters * heightInMeters);
                                    const maxHealthyWeight = 24.9 * (heightInMeters * heightInMeters);

                                    // Weight selecting validation
                                    if (currentWeight < targetWeight) {
                                        alert("Current weight cannot be less than target weight.");
                                        return;
                                    }

                                    if (targetWeight < minHealthyWeight || targetWeight > maxHealthyWeight) {
                                        alert(`Target weight must be between ${minHealthyWeight.toFixed(2)} kg and ${maxHealthyWeight.toFixed(2)} kg based on your height.`);
                                        return;
                                    }

                                    // Example calculation factor for age group (modify as needed)
                                    let ageFactor = 1;
                                    if (ageGroup === "18-25") ageFactor = 1.1;
                                    else if (ageGroup === "26-35") ageFactor = 1.05;
                                    else if (ageGroup === "36-45") ageFactor = 1.0;
                                    else if (ageGroup === "46-60") ageFactor = 0.95;
                                    else if (ageGroup === "60+") ageFactor = 0.9;

                                    // Perform your diet plan calculation using ageFactor and other inputs
                                    const dailyCalories = ((10 * currentWeight) + (6.25 * height) - (5 * userAge) + (gender === "male" ? 5 : -161)) * activityLevel * ageFactor;

                                    // Fetch diet plans with age group considerations (backend should handle this if needed)
                                    fetch(`getDietPlan.php?calories=${Math.round(dailyCalories)}&duration=${duration}&ageGroup=${ageGroup}`)
                                        .then(response => response.json())
                                        .then(dietPlans => {
                                            const calendar = document.querySelector(".calendar");
                                            calendar.innerHTML = ""; // Clear previous entries
                                            dietPlans.forEach((plan, index) => {
                                                const dayDiv = document.createElement("div");
                                                dayDiv.className = "day";
                                                dayDiv.innerHTML = `
                                                    <strong>Day:</strong> ${index + 1}<br>
                                                    <strong>Diet Name:</strong> ${plan.diteName}<br>
                                                    <strong>Diet Details:</strong> ${plan.diteDetails}<br>
                                                    <strong>Calorie Count:</strong> ${plan.calorie}<br>
                                                    <strong>Micronutrient Count:</strong> Fats-${plan.fat}, Carbs-${plan.carb}, Protein-${plan.protein}
                                                `;
                                                calendar.appendChild(dayDiv);

                                                // Insert into user_diet_plans table
                                                fetch('storeDietPlan.php', {
                                                    method: 'POST',
                                                    headers: {
                                                        'Content-Type': 'application/json'
                                                    },
                                                    body: JSON.stringify({
                                                        userId: <?php echo $_SESSION['user_id']; ?>,
                                                        planDate: new Date(new Date(startDate).setDate(new Date(startDate).getDate() + index)).toISOString().split('T')[0],
                                                        dietName: plan.diteName,
                                                        dietDetails: plan.diteDetails,
                                                        calorieCount: plan.calorie,
                                                        fatCount: plan.fat,
                                                        carbCount: plan.carb,
                                                        proteinCount: plan.protein,
                                                        duration: duration // Add duration to the data being sent
                                                    })
                                                });
                                            });
                                        })
                                    .catch(error => console.error("Error fetching diet plans:", error));
                                })
                            .catch(error => console.error("Error checking diet plans:", error));
                        });

                    </script>
                </form>
            </div>
            
            <!-- Display the generated calendar -->
            <div class="calendar-container">
                <h4>Diet Calendar</h4>
                <?php echo $calendarHtml; ?> <!-- This is where the calendar HTML is displayed -->
            </div>
            
            <!--Progress bar-->
            <br>
            <h4>Your progress</h4>
            <div class="progress mt-4">
                <div id="dietProgressBar" class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
            </div>
            <script>
                document.addEventListener("DOMContentLoaded", function () {
                    // Fetch the start date and duration from the server
                    fetch(`getDietPlanStartDate.php?userId=<?php echo $_SESSION['user_id']; ?>`)
                        .then(response => response.json())
                        .then(data => {
                            const progressBar = document.getElementById("dietProgressBar");

                            if (data.startDate === null || data.duration === 0) {
                                // No diet plans found, set progress to 0%
                                progressBar.style.width = "0%";
                                progressBar.setAttribute("aria-valuenow", "0");
                                progressBar.textContent = "0%";
                                return; // Exit early
                            }

                            const startDate = new Date(data.startDate);
                            const duration = parseInt(data.duration);
                            const today = new Date();

                            // Calculate the number of days passed
                            const timeDiff = today - startDate;
                            const daysPassed = Math.floor(timeDiff / (1000 * 60 * 60 * 24));

                            // Calculate the progress percentage
                            const progressPercentage = Math.min((daysPassed / duration) * 100, 100); // Ensure it doesn't exceed 100%

                            // Update the progress bar
                            progressBar.style.width = progressPercentage + "%";
                            progressBar.setAttribute("aria-valuenow", progressPercentage);
                            progressBar.textContent = Math.round(progressPercentage) + "%";
                        })
                        .catch(error => console.error("Error fetching diet plan start date:", error));
                });
            </script>

            <!-- Display User Diet Plans -->
            <div class="user-diet-plans mt-4">
                <h4>Your Diet Plans</h4>
                <table class="table table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>Date</th>
                            <th>Diet Name</th>
                            <th>Details</th>
                            <th>Calories</th>
                            <th>Fats</th>
                            <th>Carbs</th>
                            <th>Protein</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!--backend logic to show generate diet plan as table-->
                        <?php
                        $userId = $_SESSION['user_id'];
                        $result = $conn->query("SELECT * FROM user_diet_plans WHERE user_id = $userId");

                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo "<tr>
                                        <td>{$row['plan_date']}</td>
                                        <td>{$row['diet_name']}</td>
                                        <td>{$row['diet_details']}</td>
                                        <td>{$row['calorie_count']}</td>
                                        <td>{$row['fat_count']}</td>
                                        <td>{$row['carb_count']}</td>
                                        <td>{$row['protein_count']}</td>
                                    </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='7'>No diet plans found.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <!--Clear diet button-->
            <button id="clearDietPlans" class="btn btn-danger mt-4">Clear Diet Plan</button>
        </div>
        <br>

        <!--Diet plan clearing logic-->
        <script>
            document.getElementById("clearDietPlans").addEventListener("click", function() {
                if (confirm("Are you sure, you want to clear your current diet plan?")) {
                    fetch('clearDietPlans.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({ userId: <?php echo $_SESSION['user_id']; ?> })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === "success") {
                            alert("All diet plan cleared successfully!");
                            location.reload(); // Reload the page to reflect changes
                        } else {
                            alert(data.message);
                        }
                    });
                }
            });
        </script>

        <!--footer section-->
        <footer class="footer">
        <p>&copy; 2025 Keto Diet Plan. All Rights Reserved.</p>
        </footer>

        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    </body>
</html>

<?php
$conn->close(); // Close the database connection
?>