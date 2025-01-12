<?php
session_start();
include 'config.php';
include 'middleware.php';

// Fetch reservations and their related data
$user_id = $_SESSION['user_id'];
$reservations_query = "SELECT r.*, rs.status_name, d.deceased_name, d.date_of_birth, d.date_of_death
                       FROM Reservations r
                       LEFT JOIN ReservationStatuses rs ON r.status_id = rs.status_id
                       LEFT JOIN Deceased_Info d ON r.deceased_id = d.deceased_id
                       WHERE r.user_id = ?
                       ORDER BY r.created_at DESC";

$stmt = $conn->prepare($reservations_query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$reservations_result = $stmt->get_result();

// Fetch renewals and their related data
$renewals_query = "SELECT r.*, rs.status_name, rr.plot_code
                   FROM renewals r
                   LEFT JOIN ReservationStatuses rs ON r.status_id = rs.status_id
                   LEFT JOIN Reservations rr ON r.reservation_id = rr.reservation_id
                   
                   WHERE r.user_id = ?
                   ORDER BY r.created_at DESC";

$stmt_renewal = $conn->prepare($renewals_query);
$stmt_renewal->bind_param("i", $user_id);
$stmt_renewal->execute();
$renewals_result = $stmt_renewal->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservations</title>

    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/fees.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <style>
    .cards {
        transition: transform 0.3s, box-shadow 0.3s;
    }

    .cards:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }
    </style>
</head>

<body class="">
    <!-- Navigation -->
    <nav class="navbar bg-white py-5 shadow-md">
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

    <div class="container mx-auto ">
        <!-- New Reservation Button -->
        <div class="text-right mb-6">
            <a href="reservation_form.php"
                class=" inline-flex items-center bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-700 mt-12 mr-10">
                <i class="fas fa-plus mr-2"></i>Add New Reservation
            </a>
        </div>

        <!-- Reservation Cardss -->
        <h2 class="text-xl font-semibold my-5">Reservation History</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 m-10">
            <?php while ($reservation = $reservations_result->fetch_assoc()): ?>
            <div class="cards border-2 border-slate-50 bg-white p-6 rounded-lg shadow-lg">
                <div class="flex justify-between items-center">

                    <div class="text-sm uppercase text-gray-600 mb-8"><strong class="">Status:</strong>
                        <?php echo $reservation['status_name']; ?></div>
                </div>
                <div class="mt-4  w-full text-left">
                    <p class="text-gray-600  w-full">Plot: <?php echo $reservation['plot_code']; ?></p>
                    <p class="text-gray-600  w-full">Deceased Name: <?php echo $reservation['deceased_name']; ?></p>
                </div>
                <div id="details-<?php echo $reservation['reservation_id']; ?>" class="hidden mt-4  w-full text-left">
                    <p class="text-gray-600  w-full">Deceased Date of Birth:
                        <?php echo $reservation['date_of_birth']; ?></p>
                    <p class="text-gray-600  w-full">Deceased Date of Death:
                        <?php echo $reservation['date_of_death']; ?></p>
                    <h3 class="font-bold text-sm my-2">Contact Details</h3>
                    <p class="text-gray-600  w-full">Email: <?php echo $reservation['holder_email']; ?></p>
                    <p class="text-gray-600  w-full">Phone: <?php echo $reservation['holder_phone']; ?></p>
                    <p class="text-gray-600  w-full">Address: <?php echo $reservation['holder_address']; ?></p>
                    <p class="text-gray-600  w-full">Payment Proof:
                        <a href="gis_rose/<?php echo $reservation['payment_proof']; ?>"
                            class="text-blue-500 underline">View</a>
                    </p>
                </div>
                <div class="mt-4 flex justify-between">
                    <?php if (!in_array($reservation['status_name'], [ 'cancelled'])): ?>

                    <a href="renewal_form.php?reservation_id=<?php echo $reservation['reservation_id']; ?>"
                        class=" text-white bg-green-500 hover:bg-green-700 py-1 px-3 rounded-md">
                        <i class="fas fa-sync-alt"></i> Renew
                    </a>
                    <?php endif; ?>

                    <!-- <a href="api/delete_reservation.php?reservation_id=<?php echo $reservation['reservation_id']; ?>"
                        class=" text-white bg-gray-500 hover:bg-gray-700 py-1 px-3 rounded-md">
                        <i class="fas fa-trash"></i> Delete
                    </a> -->
                    <?php if (!in_array($reservation['status_name'], ['approved', 'completed', 'cancelled'])): ?>

                    <a href="api/cancel_reservation.php?reservation_id=<?php echo $reservation['reservation_id']; ?>"
                        class=" text-white bg-red-500 hover:bg-red-700 py-1 px-3 rounded-md">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                    <?php endif; ?>

                </div>
                <button class=" mt-4 w-full text-blue-500  py-2 px-4 rounded-md hover:bg-blue-100"
                    onclick="toggleDetails(<?php echo $reservation['reservation_id']; ?>)">
                    See More
                </button>
            </div>
            <?php endwhile; ?>
        </div>

        <!-- Renewal History -->
        <h2 class="text-xl font-semibold mt-12">Renewal History</h2>
        <div class=" grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-6 m-10">
            <?php while ($renewal = $renewals_result->fetch_assoc()): ?>
            <div class="cards bg-white border-2 border-slate-100  p-6 rounded-lg shadow-lg">
                <div class="text-sm w-full text-left uppercase text-gray-600 mb-8"><strong class="">Status:</strong>
                    <?php echo $renewal['status_name']; ?>
                </div>
                <div class="flex flex-col justify-between items-center text-left w-full">

                    <p class="text-gray-600 w-full">Plot: <?php echo $renewal['plot_code']; ?></p>
                    <p class="text-gray-600 w-full">Amount: <?php echo $renewal['amount']; ?></p>
                    <p class="text-gray-600 w-full">Fee Code: <?php echo $renewal['fee_code']; ?></p>
                    <p class="text-gray-600 w-full">Payment Proof:
                        <a href="uploads/<?php echo $renewal['payment_proof']; ?>"
                            class="text-blue-500 underline">View</a>
                    </p>

                    <div class="mt-4 flex w-full justify-between">

                        <!-- <a href="api/delete_reservation.php?reservation_id=<?php echo $reservation['reservation_id']; ?>"
                            class=" text-white bg-gray-500 hover:bg-gray-700 py-1 px-3 rounded-md">
                            <i class="fas fa-trash"></i> Delete
                        </a> -->
                        <?php if (!in_array($renewal['status_name'], ['approved', 'completed', 'cancelled'])): ?>
                        <a href="api/cancel_renewal.php?renewal_id=<?php echo $renewal['renewal_id']; ?>"
                            class="text-white bg-red-500 hover:bg-red-700 py-1 px-3 rounded-md">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
        </div>
        <!-- Footer -->
        <footer class="footer">
            <div class="container">
                <p>&copy;2024 Cemetery Services. All rights reserved.</p>
            </div>
        </footer>
        <script>
        function toggleDetails(id) {
            const details = document.getElementById(`details-${id}`);
            const isHidden = details.classList.contains('hidden');
            details.classList.toggle('hidden', !isHidden);
            event.target.innerText = isHidden ? "See Less" : "See More";
        }
        </script>
        <script src="js/script.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

</body>

</html>