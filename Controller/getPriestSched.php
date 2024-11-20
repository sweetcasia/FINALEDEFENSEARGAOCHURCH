<?php
session_start();
require_once __DIR__ . '/../Model/priest_mod.php';
require_once __DIR__ . '/../Model/db_connection.php';

if (isset($_POST['date']) && isset($_POST['priestId'])) {
    $priestId = $_POST['priestId'];
    $date = $_POST['date'];
    
    // Log the received data for debugging
    error_log("Received date: $date, priestId: $priestId");

    // Initialize Priest class
    $appointments = new Priest($conn);
    $schedule = $appointments->getPriestScheduleByDate($priestId, $date);
    
    // Check if schedule is empty or has data
    if ($schedule) {
        echo json_encode($schedule);
    } else {
        echo json_encode([]);
    }
} else {
    // If data is missing
    echo json_encode(['error' => 'Missing date or priestId']);
}

?>
