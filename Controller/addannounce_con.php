<?php
require_once __DIR__ . '/../Model/db_connection.php';
require_once __DIR__ . '/../Model/staff_mod.php'; 
session_start();
// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $errors = [];
    $announcement = isset($_POST['announcement']);
    $addcalendar = isset($_POST['addcalendar']);
    // You might want to add validation logic here to populate $errors if needed
    if ($announcement) {
        if (empty($errors)) {
            // Instantiate Staff class
            $staff = new Staff($conn);
    
            // Function to ensure time is in 24-hour format
            function toMilitaryTime($time) {
                if (empty($time)) {
                    return null; // Return null if the time input is empty
                }
            
                // Check if time has "AM" or "PM" (indicating 12-hour format)
                if (strpos($time, 'AM') !== false || strpos($time, 'PM') !== false) {
                    // Convert from 12-hour to 24-hour format
                    $dateTime = DateTime::createFromFormat('g:i A', $time);
                    return $dateTime ? $dateTime->format('H:i') : null; // Return null if format is invalid
                }
            
                // Check if the time is already in 24-hour format (H:i)
                $dateTime = DateTime::createFromFormat('H:i', $time);
                return $dateTime ? $dateTime->format('H:i') : null; // Return null if format is invalid
            }
            
    
            // Schedule data for announcement
            $scheduleData = [
                'date' => $_POST['date'],
                
                'start_time' => toMilitaryTime($_POST['start_time']),
                'end_time' => !empty($_POST['end_time']) ? toMilitaryTime($_POST['end_time']) : null

            ];
    
            // Schedule data for seminar
            $scheduleDatas = [
                'date' => $_POST['dates'] ?? '',
                'start_time' => toMilitaryTime($_POST['start_times']),
                'end_time' => $_POST['end_times']
            ];
    
            // Prepare announcement data
            $announcementData = [
                'event_type' => $_POST['eventType'],
                'title' => $_POST['eventTitle'],
                'description' => $_POST['description'],
                'date_created' => date('Y-m-d H:i:s'),
                'capacity' => $_POST['capacity'],
                'speaker_ann' => $_POST['eventspeaker'],
            ];
    
            // Capture approval_id
            $scheduleDatass = [
                'approval_id' => $_POST['priest_id']
            ];
    
            // Call the addAnnouncement method, passing the necessary parameters
            $announcementResult = $staff->addAnnouncement($announcementData, $scheduleData, $scheduleDatas, $scheduleDatass['approval_id']);
    
            // Check if the insertion was successful
            if ($announcementResult) {
                $_SESSION['status'] = "success";
                header('Location: ../View/PageStaff/StaffAnnouncement.php');
                exit();
            } else {
                echo '<script>alert("Error adding announcement.");</script>';
            }
        } else {
            // Display error messages
            foreach ($errors as $error) {
                echo '<script>alert("' . $error . '");</script>';
            }
        }
    }
    
    else if ($addcalendar){
// Create an instance of the Staff class
$staff = new Staff($conn);
    // Get POST data for the calendar event
    $cal_fullname = $_POST['cal_fullname'];
    $cal_Category = $_POST['cal_Category'];
    $cal_date = $_POST['cal_date']; // The event date
    $cal_description = $_POST['cal_description'];


    // Step 1: Insert into the schedule table (using cal_date for event date)
    $schedule_id = $staff->insertSchedules($cal_date);

    if ($schedule_id) {
        // Step 2: Insert into the event_calendar table with the schedule_id
        $_SESSION['status'] = "success";
        if ($staff->insertEventCalendar($cal_fullname, $cal_Category, $schedule_id, $cal_description)) {
            // Success: Event successfully added to the calendar
            echo 'Event successfully added to the calendar.';
        } else {
            // Error: Failed to insert event into the event calendar
            echo 'Error: Failed to add event to the calendar.';
        }
    } else {
        // Error: Failed to create the schedule
        echo 'Error: Failed to create the schedule.';
    }

}else{
    echo'Theres an error';
}
}
?>
