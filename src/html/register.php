<?php
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

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $role = $_POST["role"];

    // Insert user data into users table
    $sql_user = "INSERT INTO users (name, email, phone, password, role)
                 VALUES ('$name', '$email', '$phone', '$password', '$role')";

    if ($conn->query($sql_user) === TRUE) {
        // Get the ID of the inserted user
        $user_id = $conn->insert_id;

        // If the user is a car owner, insert additional details into car_owners table
        if ($role === "car_owner") {
            $vehicle_make = $_POST["vehicleMake"];
            $vehicle_model = $_POST["vehicleModel"];
            $vehicle_year = $_POST["vehicleYear"];
            $vehicle_registration = $_POST["vehicleRegistration"];

            $sql_car_owner = "INSERT INTO car_owners (user_id, vehicle_make, vehicle_model, vehicle_year, vehicle_registration)
                              VALUES ('$user_id', '$vehicle_make', '$vehicle_model', '$vehicle_year', '$vehicle_registration')";

            $conn->query($sql_car_owner);
        }

        // Close database connection
        $conn->close();

        // Display pop-up message and redirect to login page
        echo "<script>
                alert('Registration successful! Click OK to proceed to login.');
                window.location.href = './index.php';
              </script>";
        exit();
    } else {
        echo "Error: " . $sql_user . "<br>" . $conn->error;
    }
}
?>
