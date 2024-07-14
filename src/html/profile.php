<?php
session_start();

// Include config.php for database connection
include('config.php');

// Check if the user is logged in, if not, redirect to the login page
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php"); // Redirect to the login page
    exit();
}

// Fetch user information from the database based on the user_id stored in the session
$user_id = $_SESSION["user_id"];
$sql = "SELECT * FROM users WHERE user_id = '$user_id'";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $name = $row["name"];
    $email = $row["email"];
    $role = $row["role"];
    $registration_date = $row["registration_date"];
    $profile_picture = $row["profile_picture"]; // Fetch profile picture URL
} else {
    // User not found
    // You can handle this case accordingly, e.g., display an error message
}

// Handle profile picture upload
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["profile_picture"])) {
    // Handle profile picture upload code
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            font-size: 28px;
            margin-bottom: 20px;
            text-align: center;
            color: #333;
        }

        .profile-picture {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            margin: 0 auto 20px;
            display: block;
            background-color: #ccc; /* Placeholder background color */
            background-size: cover;
            background-position: center;
        }

        input[type="file"] {
            margin-bottom: 10px;
        }

        input[type="submit"] {
            padding: 10px 20px;
            background-color: #007bff;
            border: none;
            color: #fff;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        p {
            margin-bottom: 10px;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            border: none;
            color: #fff;
            border-radius: 4px;
            text-decoration: none;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Your Profile, <?php echo $name; ?>!</h1>
        <?php if ($profile_picture): ?>
            <img src="<?php echo $profile_picture; ?>" alt="Profile Picture" class="profile-picture">
        <?php else: ?>
            <!-- Placeholder for profile picture if not available -->
            <div class="profile-picture"></div>
        <?php endif; ?>
        <!-- Display user information -->
        <p><strong>Name:</strong> <?php echo $name; ?></p>
        <p><strong>Email:</strong> <?php echo $email; ?></p>
        <p><strong>Role:</strong> <?php echo $role; ?></p>
        <p><strong>Registration Date:</strong> <?php echo $registration_date; ?></p>
        
        <!-- Add more user information as needed -->

        <!-- Logout button -->
        <a href="logout.php" class="btn">Logout</a>
    </div>
</body>
</html>
