<?php
include 'middleware.php';
session_start();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation Form</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/reservation.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/map.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

</head>

<body>
    <nav class="navbar">
        <div class="nav-container">
            <a href="#" class="logo">Garden of Life Memorial Park</a>
            <div class="navwrap">

                <button class="nav-toggle" aria-label="toggle navigation">
                    <i class="fa fa-bars"></i>
                </button>
                <ul class="nav-menu1">
                    <li><a href="index.php#hero">Home</a></li>
                    <li><a href="index.php#about">About</a></li>
                    <li><a href="index.php#services">Services</a></li>
                    <li><a href="index.php#contact">Contact</a></li>
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
            <li><a href="index.php#hero">Home</a></li>
            <li><a href="index.php#about">About</a></li>
            <li><a href="index.php#services">Services</a></li>
            <li><a href="index.php#contact">Contact</a></li>
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

    <div class="container">
        <div class="map-section">
            <div class="legend">
                <span class="available1">Available</span>
                <span class="occupied">Occupied</span>
            </div>
            <!-- <div class="controls">
                <button id="togglePolygon">Toggle Polygon</button>
                <button id="toggleMarker">Toggle Marker</button>
            </div> -->
            <!-- <div class="map-placeholder" style="height: 400px; background-color: #eee; border: 1px solid #ccc;">
                Please select an available plot, click the circle of your choice.
            </div> -->
            <div id="map"></div>
            <div class="selection-con " id="selectionCon">
                <!-- Columbarium and Apartment Grid -->
                <h3 id='plot_name'></h3>
                <div class="selection-wrap">

                    <div id="plotGrid" class="plotGrid"></div>
                </div>
            </div>
        </div>

        <div class="form-section">

            <h2>Reservation Form</h2>
            <p>Please fill in the required information to proceed.</p>
            <form action="api/post_reservations.php" method="POST" class="form-wrap" enctype="multipart/form-data">
                <h3>Personal Information</h3>

                <div class="form-group">
                    <label for="holder_name">Name*</label>
                    <input type="text" id="holder_name" name="holder_name"
                        placeholder="Enter the name of the applicant">
                </div>

                <div class="form-group">
                    <label for="holder_address">Address*</label>
                    <input type="text" id="holder_address" name="holder_address"
                        placeholder="Enter the current address">
                </div>

                <div class="form-group">
                    <label for="holder_phone">Phone Number*</label>
                    <input type="text" id="holder_phone" name="holder_phone"
                        placeholder="Enter the current phone number">
                </div>

                <div class="form-group">
                    <label for="holder_email">Email</label>
                    <input type="email" id="holder_email" name="holder_email" placeholder="Enter the email address">
                </div>

                <h3>Deceased Information</h3>
                <div class="form-group">
                    <label for="deceased_name">Deceased Name*</label>
                    <input type="text" id="deceased_name" name="deceased_name"
                        placeholder="Enter the name of the deceased">
                </div>

                <div class="form-group">
                    <label for="date_of_birth">Date of Birth*</label>
                    <input type="date" id="date_of_birth" name="date_of_birth">
                </div>

                <div class="form-group">
                    <label for="date_of_death">Date of Death*</label>
                    <input type="date" id="date_of_death" name="date_of_death">
                </div>

                <div class="form-group">
                    <label for="start_date">Date of Service*</label>
                    <input type="date" id="start_date" name="start_date">
                </div>




                <!-- Service Type Selection -->
                <div class="form-group">

                    <label for="serviceType">Select Service Type:</label>
                    <select id="serviceType" name="serviceType" required>
                        <option value="">-- Select Service Type --</option>
                    </select>
                </div>
                <!-- Services Selection -->
                <div id="servicesDiv" class="form-group" style="margin-top: 10px; display: none;">
                    <label for="services">Select Service:</label>
                    <select id="services" name="services">
                        <option value="">-- Select Service --</option>
                    </select>
                </div>

                <!-- Plot Types Selection -->
                <div id="plotTypesDiv" class="form-group" style="margin-top: 10px; display: none;">
                    <label for="plotTypes">Select Plot Type:</label>
                    <select id="plotTypes" name="plotTypes">
                        <option value="">-- Select Plot Type --</option>
                    </select>
                </div>
                <input type="hidden" id="status_id" value="1" name="status_id">
                <input type="hidden" id="amount" name="amount">
                <input type="hidden" id="fee_code" name="fee_code">




                <!-- Final Plot Selection -->
                <div id="finalPlotDiv" class="form-group" style="margin-top: 10px; display: none;">
                    <label for="plot_code">Select Plot:</label>
                    <select id="plot_code" name="plot_code">
                        <option value="">-- Select Plot --</option>
                    </select>
                </div>
                <!-- Fees Display -->
                <div id="feesDisplay" style="margin-top: 10px; display: none;">
                    <h3>Fees:</h3>
                    <div id="feesDetails"></div>
                </div>

                <h3>Payment Method</h3>
                <div class="form-group">
                    <label for="payment_method">Payment Method*</label>
                    <select id="payment_method" name="payment_method">
                        <option value="1">Gcash</option>
                        <option value="2">PayMaya</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="payment_proof">Proof of Payment*</label>
                    <input type="file" id="payment_proof" name="payment_proof">
                </div>

                <div class="form-group">
                    <button type="submit">Submit</button>
                </div>
            </form>
        </div>
    </div>
    <!-- Footer -->
    <footer class="footer">
        <div class="">
            <p>&copy;2024 Cemetery Services. All rights reserved.</p>
        </div>
    </footer>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="js/map.js"></script>
    <script src="js/script.js"></script>

</body>

</html>