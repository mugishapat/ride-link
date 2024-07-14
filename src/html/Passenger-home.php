<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: index.php"); // Redirect to the login page if not authenticated
    exit();
}
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Ridelink</title>
  <link rel="stylesheet" href="buttonstyle.css">
  <link rel="shortcut icon" type="image/png" href="../assets/images/logos/favicon.png" />
  <link rel="stylesheet" href="../assets/css/styles.min.css" />
  <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
<style>
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

    .small-button {
            padding: 5px 10px;
            font-size: 0.8em;
            width: auto;
            display: inline-block;
            margin-top: 10px;
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
</style>


</head>

<body>
  
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
                <a class="nav-link nav-icon-hover" href="profile.php" id="drop2" data-bs-toggle="dropdown"
                  aria-expanded="false">
                  <img src="../assets/images/profile/user-1.jpg" alt="" width="35" height="35" class="rounded-circle">
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
    <!-- Map container with specific dimensions -->
    <div id="map" style="width: 100%; height: 300px; position: relative; z-index: 0;"></div>
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
                                    navigator.geolocation.watchPosition(function (position) {
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
                        </script>
              
            </div>
          </div>
          <div class="col-lg-4">
            <div class="row">
              <div class="col-lg-12">
                <!-- Yearly Breakup -->
              </div>
              <div class="col-lg-12">
                <!-- Monthly Earnings -->
                <div class="card">
                <div class="card-body">
    <div class="row align-items-start">
        <div class="col-8">
            <h5 class="card-title mb-9 fw-semibold">Nearby Drivers</h5>
        </div>
        <?php
        // Include the database connection file
        include('config.php');

        // Fetch nearby private drivers with active sessions and additional information
        $sql = "SELECT u.user_id, u.name, u.email, u.phone, s.status 
                FROM users u
                INNER JOIN user_sessions s ON u.user_id = s.user_id
                WHERE u.role = 'private_driver' AND s.status = 'active'";
        $result = $conn->query($sql);

        // Check if there are any nearby private drivers with active sessions
        if ($result->num_rows > 0) {
            // Output data of each row
            while ($row = $result->fetch_assoc()) {
                echo "<div class='col-8'>";
                echo "<h5 class='card-title mb-9 fw-semibold'>" . $row["name"] . "</h5>";
                echo "</div>";
                echo "<div class='col-4'>";
                echo "<div class='d-flex justify-content-end'>";echo "<button class='btn btn-primary more-info-btn' data-driver-id='" . $row["user_id"] . "' data-driver-name='" . $row["name"] . "' data-driver-email='" . $row["email"] . "' data-driver-phone='" . $row["phone"] . "'><i class='fa fa-info-circle'></i></button>";
                echo "<button class='book-ride-btn' data-driver-name='" . $row["name"] . "' style='margin-left: 10px;'><i class='fa fa-car'></i></button>";
                echo "</div>";
                echo "</div>";
            }
        } else {
            echo "No nearby private drivers found with active sessions";
        }

        $conn->close();
        ?>
    </div>
                </div>

</div>

<div id="driverInfoModal" class="modal">
    <div class="modal-content">
        <span class="close"><i class="fa fa-times"></i></span>
        <h2 id="driverName"></h2>
        <p><strong>Email:</strong> <span id="driverEmail"></span></p>
        <p><strong>Phone:</strong> <span id="driverPhone"></span></p>
        <a id="whatsappLink" href="#" class="whatsapp-button" target="_blank">
            <i class="fa fa-whatsapp"></i> WhatsApp Me
        </a>
    </div>
</div>


<!-- Separate division for booking form card -->
<div class="card mt-4" id="booking-card" style="display: none;">
    <div class="card-body">
        <form action="book_ride.php" method="POST">
        <div class="container mt-5">
        <div class="mb-3">
            <label for="pickup-location" class="form-label">Pickup Location:</label>
            <input type="text" class="form-control" id="pickup-location" name="pickup_location" required>
            <button type="button" class="btn btn-primary small-button" onclick="getCurrentLocation()">Use Current Location</button>
        </div>
    
            <div class="mb-3">
                <label for="destination-location" class="form-label">Destination Location:</label>
                <input type="text" class="form-control" id="destination-location" name="destination_location" required>
            </div>
            <!-- Hidden input field to store driver's name -->
            <input type="hidden" id="driver-name" name="driver_name">
            <button type="submit" class="btn btn-primary">Book Ride</button>
        </form>
    </div>
</div>


<script>
        function getCurrentLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition, showError);
            } else {
                alert("Geolocation is not supported by this browser.");
            }
        }

        function showPosition(position) {
            var lat = position.coords.latitude;
            var lon = position.coords.longitude;
            var pickupLocationInput = document.getElementById("pickup-location");

            // Use reverse geocoding to get readable address from coordinates
            fetch('https://nominatim.openstreetmap.org/reverse?format=json&lat=' + lat + '&lon=' + lon)
                .then(response => response.json())
                .then(data => {
                    pickupLocationInput.value = data.display_name; // Set the readable address in the input field
                })
                .catch(error => {
                    console.error('Error reverse geocoding:', error);
                    pickupLocationInput.value = lat + ', ' + lon; // Set the coordinates if reverse geocoding fails
                });
        }

        function showError(error) {
            switch (error.code) {
                case error.PERMISSION_DENIED:
                    alert("User denied the request for Geolocation.");
                    break;
                case error.POSITION_UNAVAILABLE:
                    alert("Location information is unavailable.");
                    break;
                case error.TIMEOUT:
                    alert("The request to get user location timed out.");
                    break;
                case error.UNKNOWN_ERROR:
                    alert("An unknown error occurred.");
                    break;
            }
        }
    </script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Get the modal
    var modal = document.getElementById("driverInfoModal");

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
        modal.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }

    // Add event listeners to the more-info buttons
    var moreInfoButtons = document.getElementsByClassName('more-info-btn');
    for (var i = 0; i < moreInfoButtons.length; i++) {
        moreInfoButtons[i].onclick = function() {
            var driverName = this.getAttribute('data-driver-name');
            var driverEmail = this.getAttribute('data-driver-email');
            var driverPhone = this.getAttribute('data-driver-phone');
            
            // Add default country code if not already present
            if (!driverPhone.startsWith('+')) {
                driverPhone = '+25' + driverPhone;
            }

            // Update the modal content
            document.getElementById('driverName').innerText = driverName;
            document.getElementById('driverEmail').innerText = driverEmail;
            document.getElementById('driverPhone').innerText = driverPhone;

            // Update the WhatsApp link
            var whatsappLink = document.getElementById('whatsappLink');
            whatsappLink.href = "https://wa.me/" + driverPhone.replace(/\+/g, '');

            // Display the modal
            modal.style.display = "block";
        }
    }
});
</script>

<!-- JavaScript to toggle visibility of booking form -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.book-ride-btn').forEach(function(btn) {
            btn.addEventListener('click', function() {
                // Get the driver's name from the data-driver-name attribute
                var driverName = btn.getAttribute('data-driver-name');
                // Set the driver's name in the hidden input field
                document.getElementById('driver-name').value = driverName;
                // Display the booking form
                document.getElementById('booking-card').style.display = 'block';
            });
        });
    });
</script>



<script>
        function getCurrentLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition, showError);
            } else {
                alert("Geolocation is not supported by this browser.");
            }
        }

        function showPosition(position) {
            var lat = position.coords.latitude;
            var lon = position.coords.longitude;
            var pickupLocationInput = document.getElementById("pickup-location");

            // Use reverse geocoding to get readable address from coordinates
            fetch('https://nominatim.openstreetmap.org/reverse?format=json&lat=' + lat + '&lon=' + lon)
                .then(response => response.json())
                .then(data => {
                    pickupLocationInput.value = data.display_name; // Set the readable address in the input field
                })
                .catch(error => {
                    console.error('Error reverse geocoding:', error);
                    pickupLocationInput.value = lat + ', ' + lon; // Set the coordinates if reverse geocoding fails
                });
        }

        function showError(error) {
            switch (error.code) {
                case error.PERMISSION_DENIED:
                    alert("User denied the request for Geolocation.");
                    break;
                case error.POSITION_UNAVAILABLE:
                    alert("Location information is unavailable.");
                    break;
                case error.TIMEOUT:
                    alert("The request to get user location timed out.");
                    break;
                case error.UNKNOWN_ERROR:
                    alert("An unknown error occurred.");
                    break;
            }
        }
    </script>


<script>
    function showBookingForm(driverName) {
        document.getElementById("driver-name").value = driverName;
        document.getElementById("booking-card").style.display = "block";
    }
</script>
              </div>
              <div class="card-body p-4">
    <h5 class="card-title mb-9 fw-semibold">Ride Requests</h5>
    <div class="row">
    <?php

    include 'config.php'; // Include your database connection file

    // Check if user is logged in
    if (isset($_SESSION["user_id"])) {
        $userId = $_SESSION["user_id"];

        // Fetch ride requests for the logged-in user
        $sql_requests = "SELECT * FROM booking_details WHERE user_id = '$userId'";
        $result_requests = $conn->query($sql_requests);

        // Display ride requests
        if ($result_requests->num_rows > 0) {
            // Output data of each row
            while ($row_request = $result_requests->fetch_assoc()) {
                echo "<div class='col-12 mb-3'>";
                echo "<div class='card'>";
                echo "<div class='card-body'>";
                echo "<h5 class='card-title'>Request ID: " . $row_request["booking_id"] . "</h5>";
                echo "<p class='card-text'>Pickup Location: " . $row_request["pickup_location"] . "</p>";
                echo "<p class='card-text'>Destination Location: " . $row_request["destination_location"] . "</p>";
                echo "<p class='card-text'>Booking Time: " . $row_request["booking_time"] . "</p>";
                
                // Apply different styles based on the status
                $status = $row_request["status"];
                $statusColor = "";
                switch ($status) {
                    case 'pending':
                        $statusColor = "yellow";
                        break;
                    case 'accepted':
                        $statusColor = "green";
                        break;
                    case 'declined':
                        $statusColor = "red";
                    case 'cancelled':
                          $statusColor = "red";
                        break;
                    default:
                        $statusColor = "black";
                        break;
                }
                
                echo "<p class='card-text' style='font-size: 1.2rem; color: $statusColor;'>Status: " . $status . "</p>";

                // Add cancel button
                echo "<form action='cancel_booking.php' method='POST'>";
                echo "<input type='hidden' name='booking_id' value='" . $row_request["booking_id"] . "'>";
                echo "<button type='submit' class='btn btn-danger' name='cancel'>Cancel</button>";
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
          </div>
        </div>
        <div class="row">
          <div class="col-lg-4 d-flex align-items-stretch">
            <div class="card w-100">
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
  <script src="../assets/libs/simplebar/dist/simplebar.js"></script>
  <script src="../assets/js/dashboard.js"></script>
</body>

</html>