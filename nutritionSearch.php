<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nutrition Search</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
            .input-group {
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
                            <a class="nav-link" href="dashboard.php">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-danger" href="logout.php">Logout</a>
                        </li>                    
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container mt-5"><br><br>
            <h1 class="text-center">Nutrition Search</h1>

            <!-- Search bar -->
            <form action="" method="GET" class="mt-3">
            <div class="input-group mb-3">
                <input type="text" name="food" class="form-control" placeholder="Enter food item (e.g., Apple, Chicken)" value="<?= htmlspecialchars($_GET['food'] ?? '') ?>">
                <button class="btn btn-primary" type="submit">Search</button>
            </div>
            </form>

            <!--backend logc for nutrition search - API & API endpoint logics-->
            <?php
            $consumer_key = '02d2f66fd5a4420a936667a2e021a82d'; //API key
            $consumer_secret = '47b4ffcaca39474fabfa70ba9217395a'; //API secret key

            if (isset($_GET['food']) && !empty($_GET['food'])) {
                $foodItem = urlencode($_GET['food']);
                $base_url = "https://platform.fatsecret.com/rest/server.api";

                $method = "foods.search";
                $format = "json";
                $nonce = bin2hex(random_bytes(16));
                $timestamp = time();

                $params = [
                    'method' => $method,
                    'format' => $format,
                    'oauth_consumer_key' => $consumer_key,
                    'oauth_nonce' => $nonce,
                    'oauth_signature_method' => 'HMAC-SHA1',
                    'oauth_timestamp' => $timestamp,
                    'oauth_version' => '1.0',
                    'search_expression' => $foodItem
                ];

                ksort($params);
                $parameter_string = http_build_query($params, '', '&', PHP_QUERY_RFC3986);
                $signature_base_string = "GET&" . rawurlencode($base_url) . "&" . rawurlencode($parameter_string);

                $signing_key = rawurlencode($consumer_secret) . "&";
                $signature = base64_encode(hash_hmac('sha1', $signature_base_string, $signing_key, true));
                $params['oauth_signature'] = $signature;

                $api_url = $base_url . '?' . http_build_query($params);

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $api_url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                $response = curl_exec($ch);

                if (curl_errno($ch)) {
                    echo "<div class='alert alert-danger'>Error: " . curl_error($ch) . "</div>";
                } else {
                    $data = json_decode($response, true);

                    if (isset($data['foods']['food'])) {
                        echo "<table class='table table-bordered mt-4'>";
                        echo "<thead class='table-dark'><tr><th>Food Name</th><th>Description</th></tr></thead><tbody>";

                        foreach ($data['foods']['food'] as $food) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($food['food_name']) . "</td>";
                            echo "<td>" . htmlspecialchars($food['food_description']) . "</td>";
                            echo "</tr>";
                        }

                        echo "</tbody></table>";
                    } else {
                        echo "<div class='alert alert-warning'>No nutrition information found for your search.</div>";
                    }
                }

                curl_close($ch);
            }
            ?>
        </div>

            <!--footer section-->
            <footer class="footer">
            <p>&copy; 2025 Keto Diet Plan. All Rights Reserved.</p>
        </footer>

        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    </body>
</html>
