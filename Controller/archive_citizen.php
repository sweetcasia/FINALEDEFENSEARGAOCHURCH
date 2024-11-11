<?php
require_once '../Model/db_connection.php';
require_once '../Model/login_mod.php';

error_reporting(0); // Disable all error reporting

// Alternatively, if you only want to hide errors but log them
error_reporting(E_ALL); // Report all errors
ini_set('display_errors', '0'); // Hide errors from displaying on the page
ini_set('log_errors', '1'); // Enable error logging
ini_set('error_log', 'error.log'); // Specify the path to the error log file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    if (isset($_POST['citizen_id']) && isset($_POST['action'])) {
        $citizen_id = intval($_POST['citizen_id']);
        $action = $_POST['action'];  // This could be 'archive' or 'unarchive'
        $citizen = new User($conn);
        
        if ($action === 'archive') {
            $_SESSION['status'] = "success";
            $result = $citizen->archiveCitizen($citizen_id, 'Unactive');

        } elseif ($action === 'unarchive') {
            $_SESSION['status'] = "success";
            $result = $citizen->archiveCitizen($citizen_id, 'Active');
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid action.']);
            exit;
        }

        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Citizen ' . $action . 'd successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to ' . $action . ' citizen.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid citizen ID or action.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
