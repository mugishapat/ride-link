<?php
session_start();

include 'config.php'; // Include your database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $driverName = $_POST["driver_name"];
    $pickupLocation = $_POST["pickup_location"];
    $destinationLocation = $_POST["destination_location"];

    // Get user's ID from the session
    if(isset($_SESSION["user_id"])) {
        $userId = $_SESSION["user_id"];

        // Get driver's information from the users table
        $sql_driver = "SELECT user_id FROM users WHERE name = '$driverName'";
        $result_driver = $conn->query($sql_driver);
        if ($result_driver->num_rows > 0) {
            $row_driver = $result_driver->fetch_assoc();
            $driverId = $row_driver["user_id"];

            // Insert booking details into booking_details table
            $sql_insert_booking = "INSERT INTO booking_details (user_id, driver_id, driver_name, pickup_location, destination_location) 
                                    VALUES ('$userId', '$driverId', '$driverName', '$pickupLocation', '$destinationLocation')";
            if ($conn->query($sql_insert_booking) === TRUE) {
                // Display popup message
                echo "<script>
                        alert('Booking details stored successfully');
                        window.location.href = 'passenger-home.php';
                      </script>";
                exit();
            } else {
                // Display error popup message
                echo "<script>
                        alert('Error storing booking details: " . $conn->error . "');
                        window.location.href = 'passenger-home.php';
                      </script>";
                exit();
            }
        } else {
            // Display error popup message
            echo "<script>
                    alert('Driver not found');
                    window.location.href = 'passenger-home.php';
                  </script>";
            exit();
        }
    } else {
        // Redirect to login page if user is not logged in
        header("Location: index.php");
        exit();
    }
}
?>
