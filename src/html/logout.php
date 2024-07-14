<?php
session_start();

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

// Function to delete session from the database
function deleteSession($userId, $conn) {
    $sql_delete_session = "DELETE FROM user_sessions WHERE user_id = '$userId'";
    if ($conn->query($sql_delete_session) === TRUE) {
        return true;
    } else {
        return false;
    }
}

// Update session status to "disconnected" for the logged-out user
if (isset($_SESSION["user_id"])) {
    $userId = $_SESSION["user_id"];

    // Delete session from the database
    $session_deleted = deleteSession($userId, $conn);

    if ($session_deleted) {
        // Destroy the session
        session_destroy();

        // Redirect the user to the login page or any other appropriate page
        header("Location: index.php");
        exit();
    } else {
        // Error handling if session deletion fails
        echo "Error deleting session from the database.";
    }
} else {
    // If the user is not logged in, redirect them to the login page
    header("Location: index.php");
    exit();
}
?>
