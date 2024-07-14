<?php
// Start session to manage user authentication
session_start();

// Database connection
$servername = "localhost";
$username = "root"; // default username for XAMPP
$password = ""; // default password for XAMPP is empty
$dbname = "ridelink"; // your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process login form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Check if user exists with the provided email
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $row["password"])) {
            // Set session variables for user authentication
            $_SESSION["user_id"] = $row["user_id"];
            $_SESSION["name"] = $row["name"];
            $_SESSION["email"] = $row["email"];
            $_SESSION["role"] = $row["role"];

            // Generate session token
            $session_token = bin2hex(random_bytes(16));

            // Insert session into user_sessions table
            $insert_sql = "INSERT INTO user_sessions (user_id, session_token, status, start_time) 
                           VALUES (?, ?, 'active', NOW())";
            $stmt = $conn->prepare($insert_sql);
            $stmt->bind_param("is", $row["user_id"], $session_token);
            $stmt->execute();

            // Redirect user based on their role
            switch ($_SESSION["role"]) {
                case "passenger":
                    header("Location: Passenger-home.php");
                    break;
                case "private_driver":
                    header("Location: p-driver-home.php");
                    break;
                case "temporary_driver":
                    header("Location: t-driver-home.php");
                    break;
                case "car_owner":
                    header("Location: car-owner-home.php");
                    break;
                default:
                    // Redirect to a default page if the role is not recognized
                    header("Location: index.php");
                    break;
            }
            exit();
        } else {
            // Invalid password
            echo "<script>alert('Invalid email or password.'); window.location.href = 'index.php';</script>";
        }
    } else {
        // Check if the email matches the admin email
        $sql = "SELECT * FROM admin WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();

            // Verify password
            if (password_verify($password, $row["password"])) {
                // Set session variables for admin authentication
                $_SESSION["admin_id"] = $row["admin_id"];
                $_SESSION["username"] = $row["username"];
                $_SESSION["email"] = $row["email"];

                // Redirect to the admin dashboard
                header("Location: admin-dash.php");
                exit();
            } else {
                // Invalid password
                echo "<script>alert('Invalid email or password.'); window.location.href = 'index.php';</script>";
            }
        } else {
            // User not found
            echo "<script>alert('Invalid email or password.'); window.location.href = 'index.php';</script>";
        }
    }
}

$conn->close();
?>
