<?php
session_start();

$hardcoded_username = 'admin';
$hardcoded_password_hash = 'admin10'; // hashed password for 'admin123'

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if credentials are valid
    if ($username === $hardcoded_username && password_verify($password, $hardcoded_password_hash)) {
        $_SESSION['username'] = $username;
        header("Location: admin-dash.php");
        exit();
    } else {
        $error = "Invalid username or password";
        header("Location: admin_login.php?error=" . urlencode($error));
        exit();
    }
} else {
    header("Location: admin_login.php");
    exit();
}
?>
