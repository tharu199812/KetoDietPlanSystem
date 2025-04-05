<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin Page - Manage Diet Plans</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
        <style>
            body {
                background-color: #f8f9fa;
            }
            .card {
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            }
            .navbar {
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            }
            .table-container {
                margin-top: 20px;
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
                background: url('https://www.naturemade.com/cdn/shop/articles/healthy-foods-to-eat_960x.jpg?v=1611988563') no-repeat center center; /* Replace with your image URL */
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
        </style>
    </head>
    <body>
        <!-- Navigation bar -->
        <nav class="navbar navbar-dark bg-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Keto Diet Plan - Admin Dashboard</a>
                <a href="admin.php" class="btn btn-outline-light">Home</a>
                <a href="adminView.php" class="btn btn-outline-light">Manage Diet Plans</a>
                <a href="admin_Q&A_result.php" class="btn btn-outline-light">Q & A Results</a>
                <a href="admin_login.php" class="btn btn-danger">Logout</a>           
            </div>
        </nav>
        <div class="content">
            <div class="container mt-4">
                <!-- Diet Plans Table -->
                <div class="table-container">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h5>All Diet Plans</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <input type="text" id="searchInput" class="form-control" placeholder="Search by Plan Name...">
                            </div>

                            <table class="table table-striped">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Plan Name</th>
                                        <th>Description</th>
                                        <th>Calories (kcal)</th>
                                        <th>Macronutrients</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="dietPlansTable">
                                    <?php
                                    // Database connection
                                    $host = 'localhost'; // Change if necessary
                                    $db = 'keto_diet_plan'; // Change to your database name
                                    $user = 'root'; // Change to your database username
                                    $pass = ''; // Change to your database password

                                    $conn = new mysqli($host, $user, $pass, $db);
                                    if ($conn->connect_error) {
                                        die("Connection failed: " . $conn->connect_error);
                                    }

                                    // Fetch diet plans
                                    $result = $conn->query("SELECT * FROM admindietdetails");
                                    if ($result->num_rows > 0) {
                                        while($row = $result->fetch_assoc()) {
                                            echo "<tr>
                                                    <td>{$row['diet_plan_name']}</td>
                                                    <td>{$row['diet_plan_description']}</td>
                                                    <td>{$row['calorie_count']}</td>
                                                    <td>Fats: {$row['fats']}%, Protein: {$row['protein']}%, Carbs: {$row['carbs']}%</td>
                                                    <td>
                                                        <button class='btn btn-sm btn-danger' onclick='deletePlan({$row['id']})'>Delete</button>
                                                    </td>
                                                </tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='6'>No diet plans found.</td></tr>";
                                    }

                                    $conn->close();
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            //delete button logic
            function deletePlan(planId) {
                if (confirm("Are you sure you want to delete this diet plan?")) {
                    // Send an AJAX request to delete the plan
                    fetch('delete_plan.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: `planId=${planId}` // Send data as form-urlencoded
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === "success") {
                            alert(data.message);
                            // Reload the page to reflect the changes
                            location.reload();
                        } else {
                            alert(data.message);
                        }
                    })
                    .catch(error => {
                        console.error("Error:", error);
                        alert("An error occurred while deleting the plan.");
                    });
                }
            }
        </script>
        <script>
            document.getElementById('searchInput').addEventListener('keyup', function () {
                const searchText = this.value.trim().toLowerCase();
                const rows = document.querySelectorAll('#dietPlansTable tr');

                rows.forEach(row => {
                    const planNameCell = row.querySelector('td');
                    if (planNameCell) {
                        const planName = planNameCell.textContent.trim().toLowerCase();
                        // Exact match (case-insensitive)
                        if (planName === searchText) {
                            row.style.display = '';
                        } else {
                            row.style.display = 'none';
                        }
                    }
                });
            });
        </script>
    </body>
</html>
