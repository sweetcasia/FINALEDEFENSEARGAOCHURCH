<?php
session_start();
require_once __DIR__ . '/../Model/db_connection.php';
require_once __DIR__ . '/../Model/login_mod.php';
error_reporting(0); // Disable all error reporting

// Alternatively, if you only want to hide errors but log them
error_reporting(E_ALL); // Report all errors
ini_set('display_errors', '0'); // Hide errors from displaying on the page
ini_set('log_errors', '1'); // Enable error logging
ini_set('error_log', 'error.log'); // Specify the path to the error log file

// Instantiate User class
$user = new User($conn);

// Check if the user is logged in
if (isset($_SESSION['user_email'])) {
    $email = $_SESSION['user_email'];

    // Call the deleteAccount method
    $deleteSuccess = $user->deleteAccount($email);

    // Clear session data
    session_unset();
    session_destroy();

    // Optionally, redirect or provide feedback
    // header('Location: login.php'); // Redirect to login page after deletion
}
