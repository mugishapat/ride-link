<?php
session_start();
include 'config.php'; // Include your database connection file

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if user is logged in
    if (isset($_SESSION["user_id"])) {
        $userId = $_SESSION["user_id"];

        // Check if the cancel button is clicked
        if (isset($_POST["cancel"])) {
            $bookingId = $_POST["booking_id"];

            // Update the status of the ride request to cancelled
            $sql_update = "UPDATE booking_details SET status = 'cancelled' WHERE booking_id = '$bookingId' AND user_id = '$userId'";
            if ($conn->query($sql_update) === TRUE) {
                // Display success message and redirect
                echo "<script>
                        alert('Ride request cancelled successfully');
                        window.location.href = 'passenger-home.php';
                      </script>";
                exit();
            } else {
                // Display error message and redirect
                echo "<script>
                        alert('Error cancelling ride request: " . $conn->error . "');
                        window.location.href = 'passenger-home.php';
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
    header("Location: passenger-home.php");
    exit();
}
?>
