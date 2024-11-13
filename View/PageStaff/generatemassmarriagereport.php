<?php
session_start();
require_once '../../Model/staff_mod.php'; 
require_once '../../Model/db_connection.php';  
// Check if user is logged in
if (!isset($_SESSION['email']) || !isset($_SESSION['user_type'])) {
    header("Location: ../../index.php");
    exit();
}

// Redirect based on user type
switch ($_SESSION['user_type']) {
    case 'Staff':
        // Allow access
        break;
    case 'Admin':
        header("Location: ../PageAdmin/AdminDashboard.php");
        exit();
    case 'Priest':
        header("Location: ../PagePriest/PriestDashboard.php");
        exit();
    case 'Citizen':
        header("Location: ../PageCitizen/CitizenPage.php");
        exit();
    default:
        header("Location: ../../index.php");
        exit();
}

// Validate specific Citizen data
if (!isset($_SESSION['fullname']) || !isset($_SESSION['citizend_id'])) {
    header("Location: ../../index.php");
    exit();
}

// Assign session variables
$nme = $_SESSION['fullname'];
$regId = $_SESSION['citizend_id'];
$userManager = new Staff($conn);
$seminarReports = $userManager->generatemassmarriageSeminarReport('MassMarriage');  

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seminar Report</title>
    <script>
        function printReport() {
            window.print();
        }
    </script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .report-header {
            text-align: center;
            margin-bottom: 30px;
        }
        .report-header img {
            width: 80px;
            height: 80px;
        }
        .report-header h4 {
            margin: 0;
            font-size: 24px;
            color: #333;
        }
        .report-header p {
            margin: 5px 0;
            font-size: 16px;
            color: #555;
        }

        .button {
            display: block;
            width: 150px;
            padding: 10px;
            margin: 20px auto;
            background-color: #4CAF50;
            color: white;
            text-align: center;
            text-decoration: none;
            border-radius: 5px;
            cursor: pointer;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #f5f5f5;
        }

        @media print {
            .button {
                display: none;
            }
        }
    </style>
</head>
<body>

    <div class="report-header">
        <img src="../assets/img/mainlogo.jpg" alt="Church Logo"> <!-- Replace with your logo -->
        <h4>Argao Parish Church</h4>
        <p>Argao, Cebu</p>
        <p>0939-424-232</p>
        <p>argaoparishchurch@gmail.com</p>
    </div>

    <h2 style="text-align: center;">Mass Marriage Seminar Report</h2>

    <!-- Print Button -->
    <button class="button" onclick="printReport()">Print Report</button>

    <table class="table table-bordered">
    <thead>
        <tr>
            <th>No.</th> <!-- Add the No. column header -->
            <th>Seminar Date</th>
            <th>Reference Number</th>
            <th>Type</th>
            <th>Citizen Name</th>
            <th>Payment Status</th>
            <th>Payable Amount</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($seminarReports)): ?>
            <?php $no = 1; // Initialize row counter ?>
            <?php foreach ($seminarReports as $report): ?>
                <tr>
                    <td><?= $no++ ?></td> <!-- Display the row number and increment the counter -->
                    <td><?= htmlspecialchars($report['seminar_date']) ?></td>
                    <td><?= htmlspecialchars($report['ref_number']) ?></td>
                    <td><?= htmlspecialchars($report['type']) ?></td>
                    <td><?= htmlspecialchars($report['fullnames']) ?></td>
                    <td><?= htmlspecialchars($report['p_status']) ?></td>
                    <td><?= htmlspecialchars($report['payable_amount']) ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="7">No seminar records found.</td> <!-- Update colspan to 7 because of the new No. column -->
            </tr>
        <?php endif; ?>
    </tbody>
</table>


    <button class="button" onclick="history.back()">Back</button>
</body>
</html>
