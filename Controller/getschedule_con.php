<?php
require_once __DIR__ . '/../Model/db_connection.php';
require_once __DIR__ . '/../Model/citizen_mod.php';

if (isset($_POST['date'])) {
    $date = $_POST['date'];
    
    // Instantiate the Citizen class with the database connection
    $staff = new Citizen($conn);
    
    // Call getSchedule method to retrieve schedule data for the given date
    $schedules = $staff->getSchedule($date);

    // Check if schedules were found
    if ($schedules) {
        echo json_encode($schedules); // Return schedule data as JSON
    } else {
        // Handle case where no schedules are found
        echo json_encode(['error' => 'No schedules found for this date.']);
    }
} else {
    // If no date is provided, send an error message
    echo json_encode(['error' => 'No date provided.']);
}
?>
