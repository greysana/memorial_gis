<?php
include 'middleware.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Starter Project</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

</head>

<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="nav-container">
            <a href="#" class="logo">MyWebsite</a>
            <div class="navwrap">

                <button class="nav-toggle" aria-label="toggle navigation">
                    <i class="fa fa-bars"></i>
                </button>
                <ul class="nav-menu1">
                    <li><a href="#hero">Home</a></li>
                    <li><a href="#about">About</a></li>
                    <li><a href="#services">Services</a></li>
                    <li><a href="#contact">Contact</a></li>
                    <li>
                        <a href="logout.php">Logout</a>

                    </li>
                </ul>
            </div>
        </div>
        <ul class="nav-menu">
            <li><a href="#hero">Home</a></li>
            <li><a href="#about">About</a></li>
            <li><a href="#services">Services</a></li>
            <li><a href="#contact">Contact</a></li>
            <li>
                <a href="logout.php">Logout</a>

            </li>
        </ul>
    </nav>

    <!-- Hero Section -->
    <section id="hero" class="hero">
        <div class="container">
            <h1>Welcome to MyWebsite</h1>
            <p>Your one-stop solution for all things awesome.</p>
            <a href="#about" class="btn">Learn More</a>
        </div>
    </section>

    <!-- Cards Section -->
    <section id="services" class="cards">
        <div class="container">
            <h2>Our Services</h2>
            <div class="card">
                <h3>Service 1</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
            </div>
            <div class="card">
                <h3>Service 2</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
            </div>
            <div class="card">
                <h3>Service 3</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
            </div>
        </div>
        <div class="calendar-container">
            <label for="single-date">Select a Single Date:</label>
            <div class="input-wrapper">
                <span class="input-icon">
                    <i class="fa fa-calendar"></i>
                </span>

                <input type="text" id="single-date" class="calendar-input" placeholder="Choose a date...">
            </div>

            <label for="date-range">Select Start and End Dates:</label>
            <div class="input-wrapper">
                <span class="input-icon">
                    <i class="fa fa-calendar"></i>
                </span>

                <input type="text" id="date-range" class="calendar-input" placeholder="Choose a range...">
            </div>
        </div>

    </section>

    <!-- Form Section -->
    <section id="contact" class="form-section">
        <div class="container">
            <h2>Contact Us</h2>
            <form action="#" method="POST">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" placeholder="Your Name">

                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Your Email">

                <label for="subject">Subject</label>
                <select id="subject" name="subject">
                    <option value="inquiry">General Inquiry</option>
                    <option value="support">Support</option>
                    <option value="feedback">Feedback</option>
                </select>

                <label for="message">Message</label>
                <textarea id="message" name="message" rows="5" placeholder="Your Message"></textarea>

                <button type="submit" class="btn">Submit</button>
            </form>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <p>&copy; 2024 MyWebsite. All rights reserved.</p>
        </div>
    </footer>

    <script src="js/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script>
    // Initialize Flatpickr for Single Date Picker
    flatpickr("#single-date", {
        dateFormat: "Y-m-d", // Customize date format
        defaultDate: null, // No pre-selected date
    });

    // Initialize Flatpickr for Date Range Picker
    flatpickr("#date-range", {
        mode: "range", // Enable range selection
        dateFormat: "Y-m-d", // Customize date format
    });
    </script>
</body>

</html>