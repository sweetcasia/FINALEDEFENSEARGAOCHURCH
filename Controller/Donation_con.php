<?php
require_once __DIR__ . '/../Model/admin_mod.php';
require_once __DIR__ .'/../Model/db_connection.php';
session_start();
error_reporting(0); // Disable all error reporting

// Alternatively, if you only want to hide errors but log them
error_reporting(E_ALL); // Report all errors
ini_set('display_errors', '0'); // Hide errors from displaying on the page
ini_set('log_errors', '1'); // Enable error logging
ini_set('error_log', 'error.log'); // Specify the path to the error log file

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add_donation') {
    // Create Admin object
    $admin = new Admin($conn);

    // Get data from AJAX request
    $d_name = $_POST['d_name'];
    $amount = $_POST['amount'];
    $donated_on = $_POST['donated_on'];
    $description = $_POST['description'];

    // Call the addDonation method
    if ($admin->addDonation($d_name, $amount, $donated_on, $description)) {
        // Send JSON response for success
    
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to add donation.']);
    }
    exit; // Prevent further output
}
