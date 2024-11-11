<?php
require_once __DIR__ . '/../Model/db_connection.php';
require_once __DIR__ . '/../Model/login_mod.php';
error_reporting(0); // Disable all error reporting

// Alternatively, if you only want to hide errors but log them
error_reporting(E_ALL); // Report all errors
ini_set('display_errors', '0'); // Hide errors from displaying on the page
ini_set('log_errors', '1'); // Enable error logging
ini_set('error_log', 'error.log'); // Specify the path to the error log file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'] ?? '';

    // Create an instance of your User class
    $user = new User($conn); // Ensure $conn is properly defined

    // Check if the email exists
    if ($user->checkEmailExistss($email)) {
        echo 'exists';
    } else {
        echo 'available';
    }
}
?>
