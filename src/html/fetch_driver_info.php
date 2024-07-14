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

if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];

    // Fetch driver information
    $sql = "SELECT name, email, phone FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $driver_info = $result->fetch_assoc();
        echo json_encode($driver_info);
    } else {
        echo json_encode(["error" => "Driver not found"]);
    }

    $stmt->close();
}

$conn->close();
?>
