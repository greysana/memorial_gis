<?php
include 'middleware.php';
include 'config.php';

session_start();

// Retrieve reservation data
$reservation_id = $_GET['reservation_id'];
$user_id = $_SESSION['user_id'];

if (!$reservation_id) {
    echo "No reservation ID provided.";
    exit;
}

// Fetch reservation details
$sql = "
    SELECT 
        r.reservation_id, 
        r.user_id, 
        r.status_id, 
        r.holder_name, 
        r.holder_address, 
        r.holder_phone, 
        r.holder_email,
        d.deceased_name, 
        d.date_of_birth, 
        d.date_of_death,
        rd.service_id, 
        s.service_name,
        r.plot_code,
        rd.fee_code, 
        f.amount AS fee_amount
    FROM 
        reservations r
    JOIN 
        deceased_info d 
    ON 
        r.deceased_id = d.deceased_id
    JOIN 
        reservation_details rd 
    ON 
        r.reservation_id = rd.reservation_id
    JOIN 
        services s 
    ON 
        rd.service_id = s.service_id
    JOIN 
        fees f 
    ON 
        rd.fee_code = f.code 
    WHERE 
        r.reservation_id = ? 
    AND 
        r.user_id = ?
";

$stmt = $conn->prepare($sql);
$stmt->bind_param('ii', $reservation_id, $user_id);
$stmt->execute();
if (!$stmt->execute()) {
    // Output error message if execution fails
    $error_message = "Error executing query: " . $stmt->error;
    var_dump($error_message);  // Log to PHP error log or display
    throw new Exception($error_message); 
}

$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Reservation not found.";
    exit;
}

$reservation = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Renewal Form</title>

    <link rel="stylesheet" href="css/renewal.css">
    <link rel="stylesheet" href="css/style.css">
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
        <h2>Renewal Form</h2>
        <p>Please fill in the required information to proceed.</p>
        <form action="api/post_renewal.php" method="POST" class="form-wrap" enctype="multipart/form-data">
            <input type="hidden" name="reservation_id" value="<?php echo htmlspecialchars($reservation['id']); ?>">
            <div class="form-section">
                <h3>Personal Information</h3>
                <div class="form-group">
                    <label for="holder_name">Name*</label>
                    <input type="text" id="holder_name" name="holder_name"
                        value="<?php echo htmlspecialchars($reservation['holder_name']); ?>" disabled>
                </div>

                <div class="form-group">
                    <label for="holder_address">Address*</label>
                    <input type="text" id="holder_address" name="holder_address"
                        value="<?php echo htmlspecialchars($reservation['holder_address']); ?>" disabled>
                </div>

                <div class="form-group">
                    <label for="holder_phone">Phone Number*</label>
                    <input type="text" id="holder_phone" name="holder_phone"
                        value="<?php echo htmlspecialchars($reservation['holder_phone']); ?>" disabled>
                </div>

                <div class="form-group">
                    <label for="holder_email">Email</label>
                    <input type="email" id="holder_email" name="holder_email"
                        value="<?php echo htmlspecialchars($reservation['holder_email']); ?>" disabled>
                </div>
            </div>

            <div class="form-section">
                <h3>Deceased Information</h3>
                <div class="form-group">
                    <label for="deceased_name">Deceased Name*</label>
                    <input type="text" id="deceased_name" name="deceased_name"
                        value="<?php echo htmlspecialchars($reservation['deceased_name']); ?>" disabled>
                </div>

                <div class="form-group">
                    <label for="date_of_birth">Date of Birth*</label>
                    <input type="date" id="date_of_birth" name="date_of_birth"
                        value="<?php echo htmlspecialchars($reservation['date_of_birth']); ?>" disabled>
                </div>

                <div class="form-group">
                    <label for="date_of_death">Date of Death*</label>
                    <input type="date" id="date_of_death" name="date_of_death"
                        value="<?php echo htmlspecialchars($reservation['date_of_death']); ?>" disabled>
                </div>

                <h3>Service Information</h3>
                <div class="form-group">
                    <label for="service_name">Service Name*</label>
                    <input type="text" id="service_name" name="service_name"
                        value="<?php echo htmlspecialchars($reservation['service_name']); ?>" disabled>
                </div>
                <div class="form-group">
                    <label for="plot_code">Plot Code</label>
                    <input type="text" id="plot_code" name="plot_code"
                        value="<?php echo htmlspecialchars($reservation['plot_code']); ?>" disabled>

                </div>
                <div id="feesDisplay" style="margin-top: 10px; display: block;">
                    <h3>Fees:</h3>
                    <div id="feesDetails"><?php echo htmlspecialchars($reservation['fee_amount']); ?></div>
                </div>

                <input type="hidden" id="amount" name="amount"
                    value="<?php echo htmlspecialchars($reservation['fee_amount']); ?>">
                <input type="hidden" id="fee_code" name="fee_code"
                    value="<?php echo htmlspecialchars($reservation['fee_code']); ?>">
                <input type="hidden" id="reservation_id" name="reservation_id"
                    value="<?php echo htmlspecialchars($reservation['reservation_id']); ?>">

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
                    <input type="file" id="payment_proof" name="payment_proof" required>
                </div>

                <div class="form-group">
                    <button type="submit">Submit</button>
                </div>
        </form>
    </div>
    <footer class="footer" style="">
        <div class="">
            <p>&copy;2024 Cemetery Services. All rights reserved.</p>
        </div>
    </footer>
    <!-- <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script> -->
    <script src="js/map.js"></script>
    <script src="js/script.js"></script>
</body>

</html>