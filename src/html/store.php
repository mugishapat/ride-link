<?php
// Check if latitude and longitude are set
if (isset($_POST['latitude']) && isset($_POST['longitude'])) {
    // Include your database connection file
    include 'config.php';

    // Get latitude and longitude from POST data
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];

    // Get user ID from session
    session_start();
    $userId = $_SESSION['user_id'];

    // Prepare and execute SQL statement to insert location into database
    $stmt = $conn->prepare("INSERT INTO user_locations (user_id, latitude, longitude) VALUES (?, ?, ?)");
    $stmt->bind_param("idd", $userId, $latitude, $longitude);

    if ($stmt->execute()) {
        echo "Location stored successfully.";
    } else {
        echo "Error storing location: " . $conn->error;
    }

    // Close database connection
    $stmt->close();
    $conn->close();
} else {
    echo "Latitude and longitude not set.";
}
?>
