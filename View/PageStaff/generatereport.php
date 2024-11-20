<?php
require_once '../../Model/staff_mod.php';  // Your Staff class file
require_once '../../Model/db_connection.php';  // Your DB connection
session_start();

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
$baptismReports = $userManager->generateBaptismReport();  // Call the method
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Citizen Accounts Report</title>
    <script>
           function printReport() {
            window.print();
        }
    </script>
  <style>
    body {
        font-family: Arial, sans-serif;
       
        background-color: #f9f9f9;
    }



    /* Button Styling */
    .button {
        display: block;
    width: 101px;
    padding: 8px;
    /* margin: 30px auto; */
    margin-top: 10px;
    margin-left: 10px;
    background-color: #4CAF50;
    color: white;
    text-align: center;
    text-decoration: none;
    border-radius: 6px;
    cursor: pointer;
    font-size: 13px;
    }
    .button:hover {
        background-color: #45a049;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        background-color: #ffffff;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    th, td {
        border: 1px solid #3333338a;
        padding: 12px;
        text-align: left;
        font-size: 14px;
        color: #333;
    }
    th {
        background-color: #0066a8;
   
    color: white;
    font-weight: 600;

    }
  
tr:hover {
    background-color: #f5f5f5;
}

/* Style for even numbered td elements */
tr:nth-child(even) {
    background-color: #0022b317; /* Change this to the color you want for even td */
}
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f9f9f9;
        height: 100%;
    }

  
  
.certificate {
    width: 100%;
    max-width: 816px;  /* Set a max-width */
    min-height: 11in; /* Ensure it fills at least 11 inches */
    background-color: none;
    box-shadow: none;
    padding: 0;
    margin: 0 auto;
    overflow: hidden; /* Prevent content overflow */
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);   
    page-break-before: avoid;
    page-break-after: avoid;

}
    .certificate-inner {
        width: 100%;
        max-width: 750px;
        margin: 0 auto;
        padding: 20px;
    }

    /* Header and Logos */
    .header {
        display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 24px;
    }

    .header .logo {
        width: 130px;
        height: 120px;
    }

    .header .maintitle {
        text-align: center;
        font-size: 20px;
        font-weight: bold;
        color: #333;
    }

    .header .logo-right {
        width: 96px;
        height: 90px;
    }

    /* Content Styling */
    .content {
        text-align: center;
        margin-top: 30px;
    }

    .content h1 {
        font-size: 24px;
        margin-bottom: 20px;
        font-weight: bold;
    }
    .seal {
                position: absolute;
                top: 67%;
                left: 50%;
                transform: translate(-50%, -50%);
                width: 700px; /* Adjusted to fit within letter size */
                height: 700px;
                background-image: url('../assets/img/mainlogonobg.png'); /* Path to your logo */
                background-size: contain;
                background-repeat: no-repeat;
                opacity: 0.1; /* Adjust opacity as needed */
                z-index: 1; /* Ensure the seal appears above the white background */
    }
  

    .certification {
        margin-top: 20px;
        font-size: 15px;
        font-weight: 500;
        text-align: center;
    }

  
    /* Print Button */
    .print-button {
        text-align: center;
    }

    .btn {
        background-color: #007bff;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .btn:hover {
        background-color: #0056b3;
    }
    @page {
        size: 8.5in 11in;
        margin: 0; /* Adjust margin to suit your needs */
    }

    /* Print Media Styles */
    @media print {
        .button,.print-button {
            display: none; /* Hide the print button when printing */
        }

    
        .seal {
                position: absolute;
                top: 43%;
                left: 50%;
                transform: translate(-50%, -50%);
                width: 700px; /* Adjusted to fit within letter size */
                height: 700px;
                background-image: url('../assets/img/mainlogonobg.png'); /* Path to your logo */
                background-size: contain;
                background-repeat: no-repeat;
                opacity: 0.1; /* Adjust opacity as needed */
                z-index: 1; /* Ensure the seal appears above the white background */
    }
  
        .certificate-inner {
          
            width: 100%;
    padding: 0;
    max-height: 10.8in; /* Make sure it fits within 11in height */
    margin: 0 auto;
        }

        .header {
            display: block;
        }

        .details p {
            font-size: 14px;
        }
        body {
         
        margin: 0;
        padding: 0;
        width: 100%;
        height: 100%;
    }


    .certificate {
        width: 100%;
        min-height: 11in; /* Ensure it fills at least 11 inches */
    height: 11in; /* Restrict height to 11 inches */
        max-width: none; /* Remove any width restrictions */
        background-image: none; /* Remove background for print */
        box-shadow: none; /* Remove box shadow for print */
        padding: 0; /* Remove padding for print */
        margin: 0; /* Remove margin for print */
        page-break-before: avoid;
        page-break-after: avoid;
    }

    .table {
        width: 100%; /* Ensure the table takes the full width */
        margin: 0;  /* Ensure no extra margins */
        border-collapse: collapse; /* Collapse borders for a cleaner print */
    }

    th, td {
        padding: 12px;
        text-align: left;
        font-size: 14px;
    }

    /* Header and Logos */
    .header {
        display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 40px;
    }

    .header .logo {
        width: 130px;
        height: 120px;
    }

    .header .maintitle {
        text-align: center;
        font-size: 20px;
        font-weight: bold;
        color: #333;
    }

    .header .logo-right {
        width: 96px;
        height: 90px;
    }
    }
    /* Print Media Styling */
   
</style>

</head>
<body>

<button class="button" onclick="history.back()">Back</button>
<div class="print-button">
    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-expanded="false" onclick="window.print()">Print Report</button>
</div>

<?php if (!empty($baptismReports)): ?>
<div class="certificate">
    <div class="certificate-inner">
        <div class="seal"></div>
        <div class="header">
            <img style="width:130px!important; height:120px;" src="../assets/img/mainlogonobg.png" alt="Logo Left" class="logo">
            <div class="maintitle">ST. MICHAEL THE ARCHANGEL PARISH CHURCH <br> ARGAO, CEBU</div>
            <img style="height: 90px;width: 96px;" src="images/logo222.png" alt="Logo Right" class="logo">
        </div>
        <div class="content">
            <p style="font-weight: bold; text-align: center; margin-top:-16px;">____________________________________________________________________________</p>
            <br>
            <h1>Generate Report</h1>
            
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Speaker</th>
                        <th>Seminar Date</th>
                        <th>Reference Number</th>
                        <th>Type</th>
                        <th>Citizen Name</th>
                        <th>Payment Status</th>
                        <th>Payable Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($baptismReports as $report): ?>
                        <tr>
                            <td><?= htmlspecialchars($report['speaker']) ?></td>
                            <td><?= htmlspecialchars($report['appointment_schedule_date']) ?></td>
                            <td><?= htmlspecialchars($report['ref_number']) ?></td>
                            <td><?= htmlspecialchars($report['type']) ?></td>
                            <td><?= htmlspecialchars($report['fullnames']) ?></td>
                            <td><?= htmlspecialchars($report['p_status']) ?></td>
                            <td><?= htmlspecialchars($report['payable_amount']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <?php else: ?>
                <div class="no-records">
                    <p>No Baptism records found for this week.</p>
                </div>
            <?php endif; ?>

           
        </div>
    </div>
</div>

  
    </div>
</body>
</html>
