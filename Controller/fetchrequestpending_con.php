<?php
require_once __DIR__ . '/../Model/staff_mod.php';
require_once __DIR__ .'/../Model/db_connection.php';
session_start();
$email = $_SESSION['email'];
$nme = $_SESSION['fullname'];
error_reporting(0); // Disable all error reporting

// Alternatively, if you only want to hide errors but log them
error_reporting(E_ALL); // Report all errors
ini_set('display_errors', '0'); // Hide errors from displaying on the page
ini_set('log_errors', '1'); // Enable error logging
ini_set('error_log', 'error.log'); // Specify the path to the error log file

$staff = new Staff($conn);

// Retrieve the pending item based on the ID from the URL
$pendingItem = null;
$eventName = '';
if (isset($_GET['req_id'])) {
    $id = $_GET['req_id'];
    $pendingItems = $staff->getRequestSchedule();  // Fetch all request schedules

    foreach ($pendingItems as $item) {
        if ($item['req_id'] == $id) {  // Match reg_id to the passed URL parameter
            $pendingItem = $item;
            break;
        }
    }
    
}
$cal_date = isset($pendingItem['cal_date']) ? $pendingItem['cal_date'] : '';
$Priest = isset($pendingItem['priest_name']) ? ($pendingItem['priest_name']) : '';
$Pending = isset($pendingItem['pr_status']) ? ($pendingItem['pr_status']) : '';
$schedule_id = isset($pendingItem['schedule_id']) ? $pendingItem['schedule_id'] : '';
$citizen_id = isset($pendingItem['citizen_id']) ? $pendingItem['citizen_id'] : '';
$date = isset($pendingItem['date']) ? date($pendingItem['date']) : '';
$startTime = isset($pendingItem['start_time']) ? date('h:i A', strtotime($pendingItem['start_time'])) : '';
$endTime = isset($pendingItem['end_time']) ? date('h:i A', strtotime($pendingItem['end_time'])) : '';

$req_name_pamisahan = isset($pendingItem['req_name_pamisahan']) ? $pendingItem['req_name_pamisahan'] : '';

// Split the full name into components
$nameParts = explode(' ', $req_name_pamisahan);

$first_name = isset($nameParts[0]) ? $nameParts[0] : '';
$middle_name = isset($nameParts[1]) ? $nameParts[1] : ''; // Assumes the middle name is in the second position
$last_name = isset($nameParts[2]) ? $nameParts[2] : ''; // Assumes the last name is in the third position (if available)

$req_address = isset($pendingItem['req_address']) ? $pendingItem['req_address'] : '';
$req_category = isset($pendingItem['req_category']) ? $pendingItem['req_category'] : '';
$req_person = isset($pendingItem['req_person']) ? $pendingItem['req_person'] : '';

// Split the full name into components
$namePartsReq = explode(' ', $req_person);

$first_name_req = isset($namePartsReq[0]) ? $namePartsReq[0] : '';
$middle_name_req = isset($namePartsReq[1]) ? $namePartsReq[1] : ''; // Assuming middle name is in the second position
$last_name_req = isset($namePartsReq[2]) ? $namePartsReq[2] : ''; // Assuming last name is in the third position (if available)

$req_pnumber = isset($pendingItem['req_pnumber']) ? $pendingItem['req_pnumber'] : '';
$cal_date = isset($pendingItem['cal_date']) ? $pendingItem['cal_date'] : '';
$req_chapel = isset($pendingItem['req_chapel']) ? $pendingItem['req_chapel'] : '';
$req_status = isset($pendingItem['req_status']) ? $pendingItem['req_status'] : '';
$priest_name = isset($pendingItem['priest_name']) ? $pendingItem['priest_name'] : '';
$approve_priest = isset($pendingItem['approve_priest']) ? $pendingItem['approve_priest'] : '';

?>