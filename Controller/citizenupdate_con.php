<?php
require_once __DIR__ . '/../Model/db_connection.php';
require_once __DIR__ . '/../Model/login_mod.php';
header('Content-Type: application/json');
error_reporting(0); // Disable all error reporting

// Alternatively, if you only want to hide errors but log them
error_reporting(E_ALL); // Report all errors
ini_set('display_errors', '0'); // Hide errors from displaying on the page
ini_set('log_errors', '1'); // Enable error logging
ini_set('error_log', 'error.log'); // Specify the path to the error log file

$response = [
    'success' => false,
    'message' => 'An error occurred while updating the details.'
];

try {
    // Get JSON input data
    $data = json_decode(file_get_contents('php://input'), true);

    // Ensure required fields are provided
    if (isset($data['citizenId'], $data['fullname'], $data['gender'], $data['phone'], $data['email'], $data['birthDate'], $data['address'])) {
        
        // Sanitize and validate the inputs
        $citizenId = intval($data['citizenId']);
        $fullname = htmlspecialchars(trim($data['fullname']));
        $gender = htmlspecialchars(trim($data['gender']));
        $phone = htmlspecialchars(trim($data['phone']));
        $email = filter_var($data['email'], FILTER_SANITIZE_EMAIL);
        $birthDate = htmlspecialchars(trim($data['birthDate']));
        $address = htmlspecialchars(trim($data['address']));

        // Additional validation
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $response['message'] = 'Invalid email format.';
            echo json_encode($response);
            exit;
        }

        // Create an instance of the User class
        $user = new User($conn);

        // Update the citizen record in the database using the updateCitizen method
        if ($user->updateCitizen($citizenId, $fullname, $gender, $phone, $email, $birthDate, $address)) {
            $response['success'] = true;
            $response['message'] = 'Details updated successfully.';
        } else {
            $response['message'] = 'Failed to update the details.';
        }

    } else {
        $response['message'] = 'Required fields are missing.';
    }
} catch (Exception $e) {
    $response['message'] = 'Error: ' . $e->getMessage();
}

// Return the JSON response
echo json_encode($response);
?>
