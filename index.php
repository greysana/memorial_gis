<?php
// include 'middleware.php';
session_start();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Starter Project</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/fees.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

</head>

<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="nav-container">
            <a href="#" class="logo">Garden of Life Memorial Park</a>
            <div class="navwrap">

                <button class="nav-toggle" aria-label="toggle navigation">
                    <i class="fa fa-bars"></i>
                </button>
                <ul class="nav-menu1">
                    <li><a href="#hero">Home</a></li>
                    <li><a href="#about">About</a></li>
                    <li><a href="#services">Services</a></li>
                    <li><a href="#contact">Contact</a></li>
                    <li><a href="map_search.php">Map</a></li>

                    <?php if (isset($_SESSION['user_id'])): ?>
                    <li><a href="dashboard.php">Dashboard</a></li>
                    <li>
                        <a href="logout.php">Logout</a>

                    </li>
                    <?php else : ?>
                    <li>
                        <a href="login.php">Login</a>

                    </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
        <ul class="nav-menu">
            <li><a href="#hero">Home</a></li>
            <li><a href="#about">About</a></li>
            <li><a href="#services">Services</a></li>
            <li><a href="#contact">Contact</a></li>
            <li><a href="map_search.php">Map</a></li>

            <?php if (isset($_SESSION['user_id'])): ?>
            <li><a href="dashboard.php">Dashboard</a></li>
            <li>
                <a href="logout.php">Logout</a>

            </li>
            <?php else : ?>
            <li>
                <a href="login.php">Login</a>

            </li>
            <?php endif; ?>
        </ul>
    </nav>

    <!-- Hero Section -->
    <section id="hero" class="section hero">
        <div class="container ">
            <h1>GARDEN OF LIFE MEMORIAL PARK</h1>
            <p>Life is short, life is beautiful, and to make it more beautiful, it must be meaningful.</p>
            <a href="#services" class="btn">Browse Services <i class="fa fa-arrow-right"></i></a>
        </div>
    </section>
    <section id="about" class="about section ">
        <div class="container ">
            <h2>WHO ARE WE?</h2>
            <p>Refers to the redeveloped and enhanced Mandaluyong City Garden of Life Park, a public cemetery owned and
                operated by the City Government of Mandaluyong, inclusive of the private or apartment niches, memorial
                chapel, mausoleums, crematorium and colombarium, situated along Rev. Aglipay St. Barangay Vergara and
                containing an area of 2.54 hectares, more or less or any other cemetery or cemeteries which the City
                Government may later build for the disposal or burial of deceased human beings by cremation or in a
                grave, mausoleum, vault, columbarium or other receptacle but does not include a family cemetery or other
                receptacle but does not include a family cemetery or a private cemetery. The management or
                administration of the GLP may also be referred to herein as the “GLP Administrator”.</p>

        </div>
    </section>
    <section id="services" class="services section ">
        <div class="container">
            <h2>What We Do?</h2>
            <p>Out of the 166 entries nationwide, the Garden of Life Park Project was recognized</p>
            <p>for its innovativeness and great impact worthy of emulation by other local government</p>
            <p>units. The GLP Project is a manifestation of a successful one-stop-shop concept</p>
            <div class="sevices_cards">
                <div class="sevices_card">
                    <img style="height:100px;" src="https://cdn-icons-png.flaticon.com/512/89/89013.png" alt="">
                    <h4>Chapel</h4>
                </div>
                <div class="sevices_card">
                    <img style="height:100px;" src="https://cpdd.mandaluyong.gov.ph/glp/img/Columbarium.png" alt="">
                    <h4>Columbarium</h4>
                </div>
                <div class="sevices_card">
                    <img style="height:100px;" src="https://cpdd.mandaluyong.gov.ph/glp/img/funeral.png" alt="">
                    <h4>Funeral Service </h4>
                </div>
                <div class="sevices_card">
                    <img style="height:100px;" src="https://cpdd.mandaluyong.gov.ph/glp/img/crematorium.png" alt="">
                    <h4>Crematorium</h4>
                </div>
                <div class="sevices_card">
                    <img style="height:100px;" src="https://cpdd.mandaluyong.gov.ph/glp/img/cemetery.png" alt="">
                    <h4>Cemetery</h4>
                </div>
            </div>
        </div>
    </section>

    <!-- Cards Section -->
    <section id="fees" class="cards section ">
        <div class="container">
            <h2>FEES</h2>
            <div class="card-container">

                <div class="card">
                    <div class="card-header">
                        <h3>BASIC FEES</h3>
                    </div>
                    <div class="card-body">
                        <h5>Burial / Exhumation / Restus</h5>
                        <p>₱480.00</p>

                        <h5>Entrance / Transfer</h5>
                        <p>Cemetery Fee (A-2 only) - ₱600.00</p>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h3>NICHES</h3>
                    </div>
                    <div class="card-body">
                        <h6>Apartment (5 yrs lease, no renewal)</h6>
                        <ul>
                            <li>A-1 - ₱6,000.00</li>
                            <li>B-1 - ₱4,800.00</li>
                            <li>C-1 - ₱4,200.00</li>
                        </ul>

                        <h6>Exclusive Lot/Niches</h6>
                        <p>(A-1) P6,000.00 ÷ 5yrs = P1,200.00 ÷ 2.5 sq.m = P480.00</p>
                        <p>Annual Fee of ₱480.00 per sq.m × lot area</p>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h3>CREMATION</h3>
                    </div>
                    <div class="card-body">
                        <h6>Bones</h6>
                        <ul>
                            <li>A-1 - ₱7,200.00</li>
                            <li>A-2 - ₱19,250.00</li>
                            <li>B-1 - ₱4,800.00</li>
                            <li>C - ₱2,400.00</li>
                            <li>D - ₱20,000.00</li>
                        </ul>

                        <h6>Apartment</h6>
                        <div class="ul-group">
                            <ul>
                                <li>A-1 - ₱12,000.00</li>
                                <li>A-1.1 - ₱5,000.00</li>
                                <li>A-2 - ₱35,000.00</li>
                                <li>B-1 - ₱8,400.00</li>

                            </ul>
                            <ul>

                                <li>B-1.1 - ₱4,000.00</li>
                                <li>C-1 - ₱3,600.00</li>
                                <li>C-1.1 - ₱1,500.00</li>
                                <li>D - ₱25,000.00</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h3>COLUMBARIUM</h3>
                    </div>
                    <div class="card-body">
                        <p>(For residents only and 1st degree relative and spouse)</p>
                        <h6>For rows #1, 2, 3, 7, 8, and 9</h6>
                        <ul>
                            <li>A-1 - ₱1,800.00/year</li>
                            <li>B - ₱1,500.00/year</li>
                            <li>C - ₱1,200.00/year</li>
                        </ul>

                        <h6>For rows #4, 5, and 6 (uniform rate)</h6>
                        <p>₱2,400.00/year</p>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h3>CHAPEL</h3>
                    </div>
                    <div class="card-body">
                        <p>Services provided by the use of the chapel shall be at a rate of ₱1,200.00 per day,
                            maximum
                            of
                            five (5) days.</p>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h3>FUNERAL PARLOR</h3>
                    </div>
                    <div class="card-body">
                        <p>Funeral Services include:</p>
                        <ul>
                            <li>Pick-up (within Mandaluyong City)</li>
                            <li>Embalming</li>
                            <li>Preparation</li>
                            <li>GLP Chapel Viewing (3 days)</li>
                            <li>Casket (Optional)</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>


    </section>

    <!-- Form Section -->
    <section id="contact" class="form-section section ">
        <div class="container contact-con">
            <div class="right">
                <h2>Contact Us</h2>
                <p>Reach out to us for any inquiries.</p>
            </div>
            <form action="send_email.php" method="POST">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" placeholder="Your Name">

                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Your Email">

                <label for="subject">Subject</label>


                <label for="message">Message</label>
                <textarea id="message" name="message" rows="5" placeholder="Your Message"></textarea>

                <button type="submit" class="btn">Submit</button>
            </form>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <p>&copy;2024 Cemetery Services. All rights reserved.</p>
        </div>
    </footer>

    <script src="js/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script>

    </script>
</body>

</html>