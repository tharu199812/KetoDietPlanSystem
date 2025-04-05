<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Keto Diet Plan System</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <style>
            /* General body styling */
            body {
                background-color: #f8f9fa;
                font-family: 'Arial', sans-serif;
            }
            /* Hero section styling */
            .hero-section {
                position: relative; /* Position relative to allow absolute positioning of the pseudo-element */
                color: white;
                text-align: center;
                padding: 100px 20px;
                overflow: hidden; /* Ensure the pseudo-element doesn't overflow */
            }
            /* Hero section background image (using a pseudo-element) */
            .hero-section::before {
                content: ""; /* Required for pseudo-elements */
                position: absolute; /* Position it absolutely within the hero section */
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: url('https://www.naturemade.com/cdn/shop/articles/healthy-foods-to-eat_960x.jpg?v=1611988563') no-repeat center center;
                background-size: cover;
                filter: blur(5px); /* Apply blur effect */
                z-index: 1; /* Place it behind the text */
            }
            /* Hero section heading and paragraph styling */
            .hero-section h1, .hero-section p {
                position: relative; /* Position text above the pseudo-element */
                z-index: 2; /* Ensure text is above the blurred background */
            }
            /* Features section styling */
            .features-section {
                margin: 40px 0;
            }
            /* Feature card styling */
            .feature-card {
                border: none;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                border-radius: 10px;
                padding: 20px;
            }
            .feature-card {
                transition: transform 0.3s ease, box-shadow 0.3s ease; /* Smooth transition */
                cursor: pointer; /* Change cursor to pointer */
            }
            /* Feature card hover effect */
            .feature-card:hover {
                transform: translateY(-10px); /* Move the card up */
                box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2); /* Add shadow for depth */
            }
            /* Feature card image styling */
            .feature-card img {
                width: 300px; /* Set a fixed width */
                height: 300px; /* Set a fixed height */
                object-fit: cover; /* Ensure the image covers the area without distortion */
            }
            /* Call to action section styling */
            .cta-section {
                background-color:rgb(59, 165, 45);
                color: white;
                padding: 40px 20px;
                text-align: center;
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
            /* Navbar navigation items alignment */
            .navbar-nav {
                margin-left: auto;
            }
            /* Hero section heading styling */
            h1 {
                font-size: 48px; /* Adjust the size as needed */
                color: white; /* Text color */
                text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5); /* Shadow effect */
            }
            /* Hero section heading styling */
            .lead {
                font-size: 24px; /* Adjust the size as needed */
                color: white; /* Text color */
                text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5); /* Shadow effect */
            }
        </style>
    </head>
    <body>
        <!--navigation  bar-->
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
                            <a class="nav-link" href="contact.php">Contact Us</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-primary" href="user_login.php">Log in</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        
        <!--Hero section-->
        <header class="hero-section">
        <h1><strong>Welcome to the Keto Diet Plan System</strong></h1>
        <p class="lead">Personalized diet plans to help you achieve your health goals.</p>
        </header>
        
        <section class="container">
            <br><h2 class="text-center mb-5"><strong>Why Choose Us?</strong></h2>
            <div class="row">
                <div class="col-md-4">
                    <div class="feature-card p-3 text-center">
                        <img src="https://vaya.in/recipes/wp-content/uploads/2018/11/Healthy-Diet.jpg" alt="Personalized Plans" class="img-fluid mb-3">
                        <h4>Personalized Plans</h4>
                        <p>Receive custom diet schedules tailored to your health goals and preferences.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card p-3 text-center">
                        <img src="https://img.freepik.com/free-photo/flat-lay-charts-organic-food-lunch-boxes_23-2148515964.jpg" alt="Track Progress" class="img-fluid mb-3">
                        <h4>Track Your Progress</h4>
                        <p>Monitor your success and stay on track with our easy tracking tools.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card p-3 text-center">
                        <img src="https://st4.depositphotos.com/1000975/40791/i/450/depositphotos_407918276-stock-photo-the-nutrition-expert-testing-food.jpg" alt="Expert Support" class="img-fluid mb-3">
                        <h4>Expert Support</h4>
                        <p>Access guidance from nutritionists and stay motivated throughout your journey.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="cta-section">
            <h2>Ready to Transform Your Life?</h2>
            <p class="lead">Join now and take the first step toward a healthier you.</p>
            <a href="register.php" class="btn btn-primary btn-lg mt-3">Register Today</a>
        </section>

        <section class="faq-section my-5">
            <div class="container">
                <h2 class="text-center mb-4">Frequently Asked Questions (FAQ)</h2>
                <div class="accordion" id="faqAccordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="faqHeadingOne">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapseOne" aria-expanded="true" aria-controls="faqCollapseOne">
                                What is a keto diet?
                            </button>
                        </h2>
                        <div id="faqCollapseOne" class="accordion-collapse collapse show" aria-labelledby="faqHeadingOne" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                A keto diet is a low-carb, high-fat diet that helps your body enter a metabolic state called ketosis, where it burns fat for energy instead of carbohydrates.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="faqHeadingTwo">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapseTwo" aria-expanded="false" aria-controls="faqCollapseTwo">
                                How long does it take to see results on a keto diet?
                            </button>
                        </h2>
                        <div id="faqCollapseTwo" class="accordion-collapse collapse" aria-labelledby="faqHeadingTwo" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Results can vary based on individual factors. Some people notice changes in the first week, while others may take a few weeks to see noticeable weight loss and energy improvements.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="faqHeadingThree">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapseThree" aria-expanded="false" aria-controls="faqCollapseThree">
                                Can I follow a keto diet if I have dietary restrictions?
                            </button>
                        </h2>
                        <div id="faqCollapseThree" class="accordion-collapse collapse" aria-labelledby="faqHeadingThree" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Yes, keto diets can be adjusted to accommodate various dietary restrictions. Consult with a healthcare professional or nutritionist for tailored advice.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!--footer section-->
        <footer class="footer bg-dark text-white py-4 mt-5">
            <div class="container text-center">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <h5>About Us</h5>
                        <p>Your trusted partner for healthy keto diet plans. Stay fit and motivated with personalized diet schedules.</p>
                    </div>
                    <div class="col-md-4 mb-3">
                        <h5>Contact</h5>
                        <p>Email: support@ketodietplan.com</p>
                        <p>Phone: +44 1234 567890</p>
                    </div>
                    <div class="col-md-4 mb-3">
                        <h5>Follow Us</h5>
                        <a href="#" class="text-white me-2"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="text-white me-2"><i class="bi bi-twitter"></i></a>
                        <a href="#" class="text-white"><i class="bi bi-instagram"></i></a>
                    </div>
                </div>
                <p class="mt-3">&copy; 2025 Keto Diet Plan. All Rights Reserved.</p>
            </div>
        </footer>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

    </body>
</html>
