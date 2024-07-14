<?php
// Database connection
$servername = "localhost";
$username = "root"; // your database username
$password = ""; // your database password
$dbname = "ridelink"; // your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get passenger location from the AJAX request
$data = json_decode(file_get_contents("php://input"));

// Extract latitude and longitude
$latitude = $data->latitude;
$longitude = $data->longitude;

// Get the user ID of the current passenger from the session
session_start();
$user_id = $_SESSION["user_id"];

// Insert the passenger location into the database
$sql = "INSERT INTO passenger_locations (user_id, latitude, longitude) VALUES ('$user_id', '$latitude', '$longitude')";
if ($conn->query($sql) === TRUE) {
    echo json_encode(array("status" => "success", "message" => "Passenger location inserted successfully"));
} else {
    echo json_encode(array("status" => "error", "message" => "Error: " . $sql . "<br>" . $conn->error));
}

$conn->close();
?>
