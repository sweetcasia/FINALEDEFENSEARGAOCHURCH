<?php
require_once __DIR__ . '/../Model/citizen_mod.php';
require_once __DIR__ .'/../Model/db_connection.php';
session_start();
$email = $_SESSION['email'];
$regId = $_SESSION['citizend_id'];
$staff = new Citizen($conn);

// Retrieve the pending item based on the ID from the URL
$pendingItem = null;
$eventName = '';

if (isset($_GET['appointment_id'])) {
    $id = $_GET['appointment_id'];
    $pendingItems = $staff->getPendingCitizens($regId,null);

    // Find the specific item with the provided ID
    foreach ($pendingItems as $item) {
        if ($item['appointment_id'] == $id) {
            $pendingItem = $item;
            $eventName = $item['event_name'];
            break;
        }
    }
}
$speaker_app = isset($pendingItem['speaker_app']) ? $pendingItem['speaker_app'] : '';
$req_category = isset($pendingItem['type']) ? $pendingItem['type'] : '';
$req_name_pamisahan = isset($pendingItem['req_name_pamisahan']) ? $pendingItem['req_name_pamisahan'] : '';
$nameParts = explode(' ', $req_name_pamisahan);
$first_name = isset($nameParts[0]) ? $nameParts[0] : '';
$middle_name = isset($nameParts[1]) ? $nameParts[1] : ''; // Assumes the middle name is in the second position
$last_name = isset($nameParts[2]) ? $nameParts[2] : ''; 
$req_person = isset($pendingItem['citizen_name']) ? $pendingItem['citizen_name'] : '';
$namePartsReq = explode(' ', $req_person);
$cal_date = isset($pendingItem['cal_date']) ? $pendingItem['cal_date'] : '';
$first_name_req = isset($namePartsReq[0]) ? $namePartsReq[0] : '';
$middle_name_req = isset($namePartsReq[1]) ? $namePartsReq[1] : ''; // Assuming middle name is in the second position
$last_name_req = isset($namePartsReq[2]) ? $namePartsReq[2] : ''; 
$req_person = isset($pendingItem['req_person']) ? $pendingItem['req_person'] : '';
$reference_number = $pendingItem['reference_number'] ?? '';
$req_address = isset($pendingItem['req_address']) ? $pendingItem['req_address'] : '';
// Initialize variables common to all events
$req_chapel = isset($pendingItem['req_chapel']) ? $pendingItem['req_chapel'] : '';
$req_pnumber = isset($pendingItem['req_pnumber']) ? $pendingItem['req_pnumber'] : '';
$startTime = isset($pendingItem['schedule_start_time']) ? date('h:i A', strtotime($pendingItem['schedule_start_time'])) : '';
$endTime = isset($pendingItem['schedule_start_time']) ? date('h:i A', strtotime($pendingItem['schedule_end_time'])) : '';

// Initialize date variables
$dateOfBirth = '';
$pbirth = '';
switch ($eventName) {
    case 'Baptism':
        $dateOfBirth = $pendingItem['c_date_birth'] ?? '';
        break;
        case 'MassBaptism':
            $dateOfBirth = $pendingItem['c_date_birth'] ?? '';
            break;
    case 'Confirmation':
        $dateOfBirth = $pendingItem['c_date_birth'] ?? '';
        $pbirth = $pendingItem['date_of_baptism'] ?? '';
        break;
        case 'MassConfirmation':
            $dateOfBirth = $pendingItem['c_date_birth'] ?? '';
            $pbirth = $pendingItem['date_of_baptism'] ?? '';
            break;
    case 'Funeral':
        $dateOfBirth = $pendingItem['date_of_birth'] ?? '';
        $pbirth = $pendingItem['date_of_death'] ?? '';
        break;
    case 'Wedding':
        $dateOfBirth = $pendingItem['groom_dob'] ?? '';
        $pbirth = $pendingItem['bride_dob'] ?? '';
        break;
        case 'MassWedding':
            $dateOfBirth = $pendingItem['groom_dob'] ?? '';
            $pbirth = $pendingItem['bride_dob'] ?? '';
            break;
}

// Convert dates to day, month, and year components
$year = $month = $day = '';
if ($dateOfBirth) {
    list($year, $month, $day) = explode('-', $dateOfBirth);
}
$monthName = $month ? DateTime::createFromFormat('!m', $month)->format('F') : '';

$years = $months = $days = '';
if ($pbirth) {
    list($years, $months, $days) = explode('-', $pbirth);
}
$monthNames = $months ? DateTime::createFromFormat('!m', $months)->format('F') : '';

// Function to clean and split names
function cleanName($name) {
    return trim(preg_replace('/\s+/', ' ', $name)); // Remove extra spaces
}

// Handle names based on the event
$firstname = $middlename = $lastname = '';
$firstnames = $middlenames = $lastnames = '';
$fullname = ''; 
switch ($eventName) {
    case 'Baptism':
        case 'MassBaptism':
    case 'MassConfirmation':
        case 'Confirmation':
        $fullname = cleanName($pendingItem['citizen_name'] ?? '');
        break;
    case 'Funeral':
        $fullname = cleanName($pendingItem['d_fullname'] ?? '');
        break;
    case 'Wedding':
        $groom_name = cleanName($pendingItem['groom_name'] ?? '');
        $bride_name = cleanName($pendingItem['bride_name'] ?? '');
        break;
}

// Split names into first, middle, and last components
$names = explode(' ', $fullname);
if (count($names) >= 3) {
    $firstname = implode(' ', array_slice($names, 0, -2));
    $middlename = $names[count($names) - 2];
    $lastname = $names[count($names) - 1];
} elseif (count($names) === 2) {
    $firstname = $names[0];
    $lastname = $names[1];
} else {
    $firstname = $names[0];
}

// Handle wedding names separately
if ($eventName === 'Wedding') {
    $groomNames = explode(' ', $groom_name);
    $brideNames = explode(' ', $bride_name);

    if (count($groomNames) >= 3) {
        $firstname = implode(' ', array_slice($groomNames, 0, -2));
        $middlename = $groomNames[count($groomNames) - 2];
        $lastname = $groomNames[count($groomNames) - 1];
    } elseif (count($groomNames) === 2) {
        $firstname = $groomNames[0];
        $lastname = $groomNames[1];
    } else {
        $firstname = $groomNames[0];
    }

    if (count($brideNames) >= 3) {
        $firstnames = $brideNames[0];
        $middlenames = $brideNames[1];
        $lastnames = $brideNames[count($brideNames) - 1];
    }  elseif (count($brideNames) === 2) {
        $firstnames = $brideNames[0];
        $lastnames = $brideNames[1];
    } else {
        $firstnames = $brideNames[0];
    }
    
}
?>