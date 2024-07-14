<?php
session_start();
include 'config.php'; // Include your database connection file

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if user is logged in
    if (isset($_SESSION["user_id"])) {
        $userId = $_SESSION["user_id"];

        // Check if the accept button is clicked
        if (isset($_POST["accept"])) {
            $bookingId = $_POST["booking_id"];

            // Update the status of the ride request to accepted
            $sql_update = "UPDATE booking_details SET status = 'accepted' WHERE booking_id = '$bookingId' AND driver_id = '$userId'";
            if ($conn->query($sql_update) === TRUE) {
                // Display success pop-up and redirect
                echo "<script>
                        alert('Ride request accepted.');
                        window.location.href = 't-driver-home.php';
                      </script>";
                exit();
            } else {
                // Display error message and redirect
                echo "<script>
                        alert('Error accepting ride request: " . $conn->error . "');
                        window.location.href = 'p-driver-home.php';
                      </script>";
                exit();
            }
        }
        
        // Check if the decline button is clicked
        if (isset($_POST["decline"])) {
            $bookingId = $_POST["booking_id"];

            // Update the status of the ride request to declined
            $sql_update = "UPDATE booking_details SET status = 'declined' WHERE booking_id = '$bookingId' AND driver_id = '$userId'";
            if ($conn->query($sql_update) === TRUE) {
                // Display success pop-up and redirect
                echo "<script>
                        alert('Ride request declined');
                        window.location.href = 'p-driver-home.php';
                      </script>";
                exit();
            } else {
                // Display error message and redirect
                echo "<script>
                        alert('Error declining ride request: " . $conn->error . "');
                        window.location.href = 'p-driver-home.php';
                      </script>";
                exit();
            }
        }
    } else {
        // Redirect to login page if user is not logged in
        header("Location: index.php");
        exit();
    }
} else {
    // Redirect to home page if form is not submitted
    header("Location: p-driver-home.php");
    exit();
}
?>
