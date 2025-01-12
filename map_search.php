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
    <link rel="stylesheet" href="css/map_search.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

</head>

<body>
    <nav class="navbar" style="background-color:white; 
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    
    ">
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
        <div class="form-section">
            <div class="searchWrap">
                <!-- <h2>Reservation Form</h2> -->
                <p>If you do not know where the grave is or in case you forgot the way to your loved one's grave, you
                    can
                    search the location here. Give it a try.</p>
                <!-- <form action="api/post_reservations.php" method="POST" enctype="multipart/form-data"> -->


                <h3>Search deceased name or plot code</h3>
                <div class="form-group">
                    <input type="text" id="map_search" name="map_search"
                        placeholder="Enter the name of the deceased or the plot code">
                </div>

                <div class="form-group">
                    <button type="button" id="search_map">Search</button>
                </div>
            </div>
            <!-- </form> -->
        </div>
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
                <div id="details-container" class="details-con"></div>
                <div class="selection-wrap" style="overflow:hidden; width:auto; height:auto;">

                    <div id="plotGrid" class="plotGrid " style="overflow:none;"></div>
                </div>
            </div>
        </div>


    </div>
    <!-- Footer -->
    <footer class="footer">
        <div class="">
            <p>&copy;2024 Cemetery Services. All rights reserved.</p>
        </div>
    </footer>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="js/map_search.js"></script>
    <script src="js/script.js"></script>

</body>

</html>