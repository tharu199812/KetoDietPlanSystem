<?php
$conn = new mysqli("localhost", "root", "", "keto_diet_plan");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch user answers grouped by question and count answers
$sql = "SELECT question, answer, COUNT(*) as count FROM user_answers GROUP BY question, answer";
$result = $conn->query($sql);

$questions = [];

// Process results
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $question = $row['question'];
        $answer = $row['answer'];
        $count = $row['count'];

        if (!isset($questions[$question])) {
            $questions[$question] = [];
        }

        $questions[$question][$answer] = $count;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Food Preferences</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        .navbar {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* Responsive chart canvas */
        .canvas-container {
            position: relative;
            width: 100%;
             /* Adjust the height as needed */
        }

        canvas {
            width: 50% !important; /* Make canvas fill the container */
            height: 50% !important; /* Maintain height proportion */
        }

        .col-md-6 {
            margin-bottom: 30px;  /* Space between charts */
        }
        body::before {
            content: ""; /* Required for pseudo-elements */
            position: fixed; /* Change to fixed to keep it in place */
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('https://img.freepik.com/premium-photo/orange-graph-chart-signifies-moderate-level-growth-potential-higher-returns_795881-3927.jpg') no-repeat center center; /* Replace with your image URL */
            background-size: cover; /* Cover the entire area */
            filter: blur(10px); /* Apply blur effect */
            z-index: -1; /* Place it behind all other content */
        }
                /* White text for headings, questions, and labels */
                h1, h4 {
            color: white;
        }

        /* White text for chart labels */
        .chartjs-tooltip .tooltip-item {
            color: white;
        }

        /* White text for chart legend */
        .chartjs-legend li {
            color: white;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Keto Diet Plan - Admin Dashboard</a>
            <a href="admin.php" class="btn btn-outline-light">Home</a>
            <a href="adminView.php" class="btn btn-outline-light">Manage Diet Plans</a>
            <a href="admin_Q&A_result.php" class="btn btn-outline-light">Q & A Results</a>
            <a href="admin_login.php" class="btn btn-danger">Logout</a>           
        </div>
    </nav>

    <div class="container mt-5">
        <h1 class="text-center">User Food Preferences</h1><br>

        <div class="row">
            <?php foreach ($questions as $question => $answers): ?>
                <div class="col-md-6">
                    <h4><?php echo htmlspecialchars($question); ?></h4>
                    <!-- Wrapper for the canvas -->
                    <div class="canvas-container">
                        <!-- Change canvas ID to reflect pie chart -->
                        <canvas id="pieChart_<?php echo str_replace(' ', '_', $question); ?>"></canvas>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    </div>

    <script>
    window.onload = function() {
        // Data from PHP
        const questionsData = <?php echo json_encode($questions); ?>;

        for (const question in questionsData) {
            const answers = Object.keys(questionsData[question]);
            const counts = Object.values(questionsData[question]);
            const totalAnswers = counts.reduce((a, b) => a + b, 0);

            // Avoid division by zero
            const percentages = totalAnswers > 0 ? counts.map(count => (count / totalAnswers) * 100) : counts.map(() => 0);

            // Unique ID for canvas
            const chartId = 'pieChart_' + question.replace(/\s/g, '_');

            // Select canvas
            const ctxPie = document.getElementById(chartId);
            if (!ctxPie) continue; // Skip if canvas not found

            // Create pie chart config
            const chartConfig = {
    type: 'pie',
    data: {
        labels: answers,
        datasets: [{
            label: 'Percentage (%)',
            data: percentages,
            backgroundColor: ['rgba(205, 74, 131, 0.7)', 'rgba(75, 192, 192, 0.7)', 'rgba(255, 159, 64, 0.7)', 'rgba(153, 102, 255, 0.7)', 'rgba(54, 162, 235, 0.7)'], // Add more colors as needed
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'top',
                labels: {
                    color: 'white',  // Set the color of the labels above the pie chart (answers)
                }
            },
            tooltip: {
                callbacks: {
                    label: function(tooltipItem) {
                        return tooltipItem.label + ': ' + tooltipItem.raw.toFixed(2) + '%'; // Show percentage in tooltip
                    }
                },
                titleFont: { color: 'white' },
                bodyFont: { color: 'white' }
            }
        }
    }
};


            // Create the pie chart
            new Chart(ctxPie, chartConfig);
        }
    };
    </script>

</body>
</html>
