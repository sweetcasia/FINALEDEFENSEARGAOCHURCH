<?php
require_once '../Model/db_connection.php';
require_once '../Controller/citizen_con.php';
require_once '../Model/citizen_mod.php';
error_reporting(0); // Disable all error reporting

// Alternatively, if you only want to hide errors but log them
error_reporting(E_ALL); // Report all errors
ini_set('display_errors', '0'); // Hide errors from displaying on the page
ini_set('log_errors', '1'); // Enable error logging
ini_set('error_log', 'error.log'); // Specify the path to the error log file

session_start(); // Make sure to start the session if you're using it

// Get POST data
$scheduleDate = $_POST['selectedDate'] ?? null;
$startTime = $_POST['start_time'] ?? null;
$endTime = $_POST['end_time'] ?? null;

// Assuming you have a function to get available priests
$citizen = new Citizen($conn);
$priests = $citizen->getAvailablePriests($scheduleDate, $startTime, $endTime);

// Return the data
if ($priests) {
    foreach ($priests as $priest) {
        echo htmlspecialchars($priest['name']) . "<br>"; // Adjust based on your data structure
    }
} else {
    echo "No available priests.";
}
?>
