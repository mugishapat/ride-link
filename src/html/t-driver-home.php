<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php"); // Redirect to the login page if not authenticated
    exit();
}
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Ridelink</title>
  <link rel="shortcut icon" type="image/png" href="../assets/images/logos/favicon.png" />
  <link rel="stylesheet" href="../assets/css/styles.min.css" />
  <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-f0lbY+RDxPWJmqFrGzWdYzdrJSHJibLCR/GvJ4crVAC/3ywhi5tZGYxvU95Qvkeq+kBqCDTQf+6r0eYAaGSzdg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<!-- Add this script inside the <head> tag -->
<script>
    // Function to send location data to the server
    function sendLocation(latitude, longitude) {
        // Create a FormData object
        var formData = new FormData();
        formData.append('latitude', latitude);
        formData.append('longitude', longitude);

        // Send a POST request to the store.php file
        fetch('store.php', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.text();
        })
        .then(data => {
            console.log(data); // Log the response from the server
        })
        .catch(error => {
            console.error('There was a problem with the fetch operation:', error);
        });
    }

    // Function to track driver location
    function trackDriverLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.watchPosition(function (position) {
                var latitude = position.coords.latitude;
                var longitude = position.coords.longitude;
                sendLocation(latitude, longitude); // Send location data to the server
            });
        } else {
            alert("Geolocation is not supported by this browser.");
        }
    }

    // Call the function to track driver location
    trackDriverLocation();
</script>
<style>
/* General styles */
.card-body {
    padding: 20px;
}

.card-title {
    margin-bottom: 10px;
}

.passenger-info {
    margin-bottom: 15px;
}

/* Modal styles */
.modal {
        display: none; /* Hidden by default */
        position: fixed; /* Stay in place */
        z-index: 1; /* Sit on top */
        padding-top: 60px; /* Location of the box */
        left: 0;
        top: 0;
        width: 100%; /* Full width */
        height: 100%; /* Full height */
        overflow: auto; /* Enable scroll if needed */
        background-color: rgb(0,0,0); /* Fallback color */
        background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
    }

    .modal-content {
        background-color: #fefefe;
        margin: 5% auto; /* 15% from the top and centered */
        padding: 20px;
        border: 1px solid #888;
        width: 80%; /* Could be more or less, depending on screen size */
        max-width: 400px; /* Limit the max width for smaller modals */
        position: relative; /* For positioning the close button */
        border-radius: 10px; /* Rounded corners */
    }

    .close {
        color: #aaa;
        position: absolute;
        top: 10px;
        right: 15px;
        font-size: 24px;
        font-weight: bold;
        cursor: pointer;
        transition: color 0.3s ease;
    }

    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }

    .whatsapp-button {
        display: inline-flex;
        align-items: center;
        padding: 6px 12px; /* Smaller padding for a smaller button */
        background-color: #25D366; /* WhatsApp brand color */
        color: #FFF;
        text-decoration: none;
        border-radius: 5px;
        font-weight: bold;
        transition: background-color 0.3s ease;
        margin-top: 10px;
        font-size: 14px; /* Smaller font size */
    }

    .whatsapp-button i {
        margin-right: 5px; /* Smaller margin for the icon */
    }

    .whatsapp-button:hover {
        background-color: #128C7E; /* Darker shade on hover */
    }

/* More Info button styles */
.more-info-btn {
    font-size: 10px;
    padding: 8px 12px;
    margin-right: 10px;
    margin-bottom: 10px;
}

.more-info-btn i {
    margin-right: 5px;
}

/* Adjust spacing between buttons and rows */
.d-flex .btn {
    margin-right: 5px;
}

.d-flex .btn:last-child {
    margin-right: 0;
}
</style>
</head>

<body>
  <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
      </div>
    </aside>
    <!--  Sidebar End -->
    <!--  Main wrapper -->
    <div class="body-wrapper">
      <!--  Header Start -->
      <header class="app-header">
        <nav class="navbar navbar-expand-lg navbar-light">
          <ul class="navbar-nav">
            <li class="nav-item d-block d-xl-none">
              <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse" href="javascript:void(0)">
                <i class="ti ti-menu-2"></i>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link nav-icon-hover" href="javascript:void(0)">
                <i class="ti ti-bell-ringing"></i>
                <div class="notification bg-primary rounded-circle"></div>
              </a>
            </li>
          </ul>
          <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
          <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end"><li class="nav-item dropdown">
            <a class="nav-link nav-icon-hover" href="profile.php" id="drop2" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="fas fa-cog"></i> <!-- Replace the image with a settings icon -->
              </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
                  <div class="message-body">
                  <a href="profile.php" class="d-flex align-items-center gap-2 dropdown-item">
    <i class="ti ti-user fs-6"></i>
    <p class="mb-0 fs-3">My Profile</p>
</a>
                  
                    <a href="logout.php" class="btn btn-outline-primary mx-3 mt-2 d-block">Logout</a>
                  </div>
                </div>
              </li>
            </ul>
          </div>
        </nav>
      </header>
      <!--  Header End -->
      <div class="container-fluid">
        <!--  Row 1 -->
        <div class="row">
          <div class="col-lg-8 d-flex align-items-strech">
          <div class="card w-100">
    <div class="card-body" style="position: relative; overflow: visible;">
        <div class="d-sm-flex d-block align-items-center justify-content-between mb-9">
            <div class="mb-3 mb-sm-0">
                <h5 class="card-title fw-semibold">Map</h5>
            </div>
        </div>
        <!-- Map container with fixed height -->
        <div id="map" style="width: 100%; height: 200px; position: relative; z-index: 0;"></div>
    </div>
</div>


<script>
    // Initialize Leaflet map
    var map = L.map('map').setView([0, 0], 13);

    // Add OpenStreetMap tiles
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    // Function to update user location on the map
    function updateUserLocation(latitude, longitude) {
        map.setView([latitude, longitude], 13);
        L.marker([latitude, longitude]).addTo(map)
            .bindPopup('Your current location')
            .openPopup();
    }

    // Function to track user location
    function trackUserLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.watchPosition(function(position) {
                var latitude = position.coords.latitude;
                var longitude = position.coords.longitude;
                updateUserLocation(latitude, longitude);
            });
        } else {
            alert("Geolocation is not supported by this browser.");
        }
    }

    // Call the function to track user location
    trackUserLocation();

    // Adjust map dimensions based on the card's dimensions
    var cardBody = document.querySelector('.card-body');
    var mapContainer = document.getElementById('map');
    var cardHeight = cardBody.clientHeight;
    mapContainer.style.height = cardHeight + 'px';
    map.invalidateSize();
</script>

          </div>
          <div class="col-lg-4">
            <div class="row">
              <div class="col-lg-12">
                <!-- Yearly Breakup -->
                <div class="card overflow-hidden">
                <div class="card-body p-4">
    <h5 class="card-title mb-9 fw-semibold">Ride Requests</h5>
    <div class="row">
        <?php

        include 'config.php'; // Include your database connection file

        // Check if user is logged in
        if (isset($_SESSION["user_id"])) {
            $userId = $_SESSION["user_id"];

            // Fetch ride requests for the logged-in private driver along with user names and phone numbers
            $sql_requests = "SELECT booking_details.*, users.name AS user_name, users.phone AS user_phone 
                             FROM booking_details 
                             JOIN users ON booking_details.user_id = users.user_id 
                             WHERE booking_details.driver_id = '$userId' AND booking_details.status = 'pending'";
            $result_requests = $conn->query($sql_requests);

            // Display ride requests
            if ($result_requests->num_rows > 0) {
                // Output data of each row
                while ($row_request = $result_requests->fetch_assoc()) {
                    echo "<div class='col-12 mb-3'>";
                    echo "<div class='card'>";
                    echo "<div class='card-body'>";
                    echo "<h5 class='card-title'>Request ID: " . $row_request["booking_id"] . "</h5>";
                    echo "<p class='card-text'>Passanger Name: " . $row_request["user_name"] . "</p>";
                    echo "<p class='card-text'>User Phone: " . $row_request["user_phone"] . "</p>";
                    echo "<p class='card-text'>Pickup Location: " . $row_request["pickup_location"] . "</p>";
                    echo "<p class='card-text'>Destination Location: " . $row_request["destination_location"] . "</p>";
                    echo "<p class='card-text'>Booking Time: " . $row_request["booking_time"] . "</p>";
                    
                    // Accept and decline buttons with margin between them
                    echo "<form action='handle_bookingtmpdvr.php' method='POST'>";
                    echo "<input type='hidden' name='booking_id' value='" . $row_request["booking_id"] . "'>";
                    echo "<button type='submit' class='btn btn-success' name='accept'>Accept</button>";
                    echo "&nbsp;"; // Non-breaking space
                    echo "<button type='submit' class='btn btn-danger' name='decline'>Decline</button>";
                    echo "</form>";

                    echo "</div>";
                    echo "</div>";
                    echo "</div>";
                }
            } else {
                echo "<p>No ride requests found.</p>";
            }
        } else {
            echo "<p>User not logged in.</p>";
        }
        ?>
    </div>
</div>
</div>
<div class="card">
<div class="card-body">
    <div class="row align-items-start">
        <div class="col-12">
            <h5 class="card-title mb-9 fw-semibold">Nearby Car-Owners</h5>
        </div>
        <?php
        // Include the database connection file
        include('config.php');

        // Fetch nearby car-owners with active sessions and additional information
        $sql = "SELECT u.user_id, u.name, u.email, u.phone, s.status 
                FROM users u
                INNER JOIN user_sessions s ON u.user_id = s.user_id
                WHERE u.role = 'car_owner' AND s.status = 'active'";
        $result = $conn->query($sql);

        // Check if there are any nearby car-owners with active sessions
        if ($result->num_rows > 0) {
            // Output data of each row
            while ($row = $result->fetch_assoc()) {
                $phoneWithCountryCode = '+25' . $row["phone"];
                echo "<div class='col-12 mb-3 car-owner-info'>";
                echo "<div class='row'>";
                echo "<div class='col-8'>";
                echo "<h5 class='card-title mb-9 fw-semibold'>" . $row["name"] . "</h5>";
                echo "</div>";
                echo "<div class='col-4'>";
                echo "<div class='d-flex justify-content-end'>";
                echo "<button class='btn btn-primary more-info-btn' data-car-owner-id='" . $row["user_id"] . "' data-car-owner-name='" . $row["name"] . "' data-car-owner-email='" . $row["email"] . "' data-car-owner-phone='" . $phoneWithCountryCode . "'><i class='fa fa-info-circle'></i> More Info</button>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
            }
        } else {
            echo "<div class='col-12'>No nearby car-owners found with active sessions</div>";
        }

        $conn->close();
        ?>
    </div>

    <!-- Modal Structure -->
    <div id="carOwnerInfoModal" class="modal">
        <div class="modal-content">
            <span class="close"><i class="fa fa-times"></i></span>
            <h2 id="carOwnerName"></h2>
            <p><strong>Email:</strong> <span id="carOwnerEmail"></span></p>
            <p><strong>Phone:</strong> <span id="carOwnerPhone"></span></p>
            <a id="whatsappLink" href="#" class="whatsapp-button" target="_blank">
                <i class="fa fa-whatsapp"></i> WhatsApp Me
            </a>
        </div>
    </div>
</div>



<!-- JavaScript for Modal Handling -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    var modal = document.getElementById('carOwnerInfoModal');
    var closeBtn = modal.querySelector('.close');
    var moreInfoButtons = document.querySelectorAll('.more-info-btn');

    moreInfoButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            var name = button.getAttribute('data-car-owner-name');
            var email = button.getAttribute('data-car-owner-email');
            var phone = button.getAttribute('data-car-owner-phone');

            document.getElementById('carOwnerName').innerText = name;
            document.getElementById('carOwnerEmail').innerText = email;
            document.getElementById('carOwnerPhone').innerText = phone;
            document.getElementById('whatsappLink').href = 'https://wa.me/' + phone;

            modal.style.display = 'block';
        });
    });

    closeBtn.addEventListener('click', function() {
        modal.style.display = 'none';
    });

    window.addEventListener('click', function(event) {
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    });
});
</script>
</div>
              </div>
              <div class="col-lg-12">
                <!-- Monthly Earnings-->
                <div class="card">
                <div class="card-body">
    <div class="row align-items-start">
        <div class="col-8">
            <h5 class="card-title mb-9 fw-semibold">Accepted Requests</h5>
            <?php
            // Include the configuration file
            include 'config.php';

            // Fetch accepted ride requests for the current temporary driver
            $temp_driver_id = $_SESSION["user_id"]; // Assuming user_id is the unique identifier for temporary drivers
            $sql = "SELECT * FROM booking_details WHERE driver_id = $temp_driver_id AND status = 'accepted'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $requestCount = 1;
                // Output data of each row
                while ($row = $result->fetch_assoc()) {
                    echo '<h5 class="card-title mb-3 fw-semibold">Request ' . $requestCount . '</h5>';
                    echo '<p><strong>Pickup Location:</strong> ' . $row["pickup_location"] . '</p>';
                    echo '<p><strong>Drop-off Location:</strong> ' . $row["destination_location"] . '</p>';
                    echo '<p><strong>Status:</strong> ' . $row["status"] . '</p>';
                    // Change button to a link to booking.php
                    echo '<a class="btn btn-primary" href="temp_routing.php?booking_id=' . $row["booking_id"] . '">Set Destination</a>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                    $requestCount++;
                }
            } else {
                echo "No accepted ride requests";
            }

            // Close the database connection
            $conn->close();
            
            ?>
        </div>
    </div>
</div>

    </div>
</div>
      <div class="py-6 px-6 text-center">
          <p class="mb-0 fs-4">Design and Developed by Ridelink</p>
        </div>
      </div>
    </div>
  </div>
  <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
  <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/js/sidebarmenu.js"></script>
  <script src="../assets/js/app.min.js"></script>
  <script src="../assets/libs/apexcharts/dist/apexcharts.min.js"></script>
  <script src="../assets/libs/simplebar/dist/simplebar.js"></script>
  <script src="../assets/js/dashboard.js"></script>
</body>

</html>