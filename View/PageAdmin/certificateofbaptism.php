<?php
require_once '../../Model/db_connection.php';
require_once '../../Model/admin_mod.php';
session_start();

// Check if user is logged in
if (!isset($_SESSION['email']) || !isset($_SESSION['user_type'])) {
    header("Location: ../../index.php");
    exit();
}

// Redirect based on user type
switch ($_SESSION['user_type']) {
    case 'Admin':
        // Allow access
        break;
    case 'Staff':
        header("Location: ../PageStaff/StaffDashboard.php");
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
if (isset($_GET['id'])) {
    $baptismId = $_GET['id'];

    $admin = new Admin($conn);
    $baptismRecord = $admin->getBaptismRecordById($baptismId);

 
} else {
    echo "No ID provided.";
    exit;
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate of Baptism</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Style+Script&display=swap" rel="stylesheet">
<style>
   /* Import Google Fonts for Pinyon Script and Open Sans */
   @import url('https://fonts.googleapis.com/css2?family=Style+Script&display=swap');
   @import url('https://fonts.googleapis.com/css2?family=Noto+Sans+Ethiopic:wght@100..900&family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Style+Script&display=swap');
   @import url('https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Noto+Sans+Ethiopic:wght@100..900&family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Style+Script&display=swap');
   @import url('https://fonts.googleapis.com/css2?family=Great+Vibes&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Noto+Sans+Ethiopic:wght@100..900&family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Style+Script&display=swap');
/* Bold style for any text */
.bold {
    font-weight: bold;
}
.signatures {
    display: flex;
    justify-content: space-between; /* Space out the signature elements */
    align-items: center; /* Align the items vertically in the center */
    padding: 12px;}

.signatures p {
    margin: 0 10px; /* Add some horizontal margin between the signature lines */
    text-align: center;
    padding-top: 13px;
}

.bold {
    font-weight: bold;
}

/* Title-specific styling */
h1 {
    font-family: "Great Vibes", cursive;
    font-size: 3.5rem;
            margin-bottom: 1rem;
            letter-spacing:5px;
            margin-top: 23px;
            color:#4b3001;
}


body {
            font-family: Arial, sans-serif; 
            text-align: center;
            margin: 0; /* Remove default margin */
        }
        .underlines {
    border-bottom: 1px solid #000;
}
.certificate-inner {
        padding: 15px;
        border: 5px solid #d1a14d; /* Inner Border */
        border-radius: 10px;
    }
        .certificate {
            padding: 20px;
            background: white;
            max-width: 700px; /* Adjusted to fit letter size */
            max-height: 10.5in; /* Adjusted to fit the height of the Letter size (11 inches minus padding) */
            margin: auto;
            position: relative;
            background: white;
    max-width: 800px;
    margin: auto;
    position: relative;
    background: linear-gradient(to right, #e3dac4, #fdf8f4);    overflow: hidden; /* Ensures content doesn't overflow outside the border */

    border: 10px solid #6c5b3c; /* Dark brown color for the border */
    border-radius: 15px; /* Rounded corners */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Soft shadow for depth */
        }
        .certificate::before {
    content: '';
    position: absolute;
    top: -20px;
    left: -20px;
    right: -20px;
    bottom: -20px;
    border: 4px solid #D1A14D; /* Light golden color border inside the main border */
    border-radius: 20px;
    z-index: -1; /* Keeps it behind the content */
}

        .certificate p {
            text-align: left;
            padding-left: 30px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;

        }
     
        .maintitle {
            font-size: 20px;
            text-align: center;
            font-family: "Playfair Display", serif;
font-weight:bold;
color: #6c5b3c; /* Dark brown for subtitles */

        }

       
        .subtitle {
            padding-left: 30px;
            margin-top: 30px;
            font-size: 18px;
    font-weight: bold;
    text-align: center;
    margin-top: 10px;
    font-family: "Playfair Display", serif;
    letter-spacing: 1px;
        }

        .details, .baptism-details, .certification {
            font-size: 14px;
            text-align: center;
            
        }
        
        .details span.underline {
            display: inline-block;
    margin-bottom: 5px;
    font-size: 25px;
    font-weight: 600;
    font-style: italic;
    font-family: "Style Script", cursive;
    letter-spacing: 3px;
}.details p strong {
    display: inline-block;
    /* margin-top: 5px; */
    font-weight: 600;
    font-style: italic;
}
    .details p, .baptism-details p, .certification p {
        display: inline-block; /* Keeps the underline applied directly to the text */
        font-family: "Playfair Display", serif;

        margin: 5px 0; /* Add margin between the lines */
        text-align: center; /* Center text alignment */

    }

    .underline {
        display: inline-block;
        border-bottom: 1px solid #000;
        width: 600px; /* Adjust width as needed */
        float: right;
    }

    .bold {
        font-weight: bold;
        text-align: center;
    }

    .signatures {
        text-align: left;
    }

    .signatures p {
        text-align: center;
    }

    .seal {
                position: absolute;
                top: 53%;
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

    .underline {
    display: inline-block;
    border-bottom: 1px solid #000;
    width: 100%; /* Adjust width as needed */
    margin-top: 5px;
}


        /*PRINT */

       /* Override default styles for the Bootstrap dropdown-toggle button */
.btn-primary {
    background: #ac0727cf !important;
    border-color: #ac0727d6 !important;
    border:none;
}.btn {
    padding: .65rem 1.4rem;
    font-size: 1rem;
    font-weight: 500;
    opacity: 1;
    border-radius: 3px;
color:white;
margin: 20px;

}

        @media print {
            .print-button {
                display: none; /* Hide the button when printing */
            }
        }

        @media print {
            @page {
                margin: 0; /* Remove default margin */
            }
        }



</style>
</head>
<body>
<div class="print-button">
    <button  class="btn btn-primary  dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-expanded="false" onclick="window.print()">Print Certificate</button>
</div>
    <?php if ($baptismRecord): ?>
    <div class="certificate">
    <div class="certificate-inner">
        <div class="seal"></div>
        <div class="header">
    <img style="width:130px!important; height:120px;" src="../assets/img/mainlogonobg.png" alt="Logo Left" class="logo">
        <div class="maintitle">ST. MICHAEL THE ARCHANGEL PARISH CHURCH <br> ARGAO, CHURCH</div>
        <img  style= "height: 90px;width: 96px;"src="images/logo222.png" alt="Logo Right" class="logo">
    </div>
        <div class="content">
        <p style="font-weight: bold; text-align: center; margin:0;">____________________________________________________________________________</p>
<h1>Certificate of Baptism</h1>         
<div class="subtitle">This is to certify that</div>
<div class="details">
    <p><span class="underline"><?php echo htmlspecialchars($baptismRecord['citizen_name']); ?></span><strong>Name of Child:</strong> </p>
    <p><span class="underline"><?php echo htmlspecialchars($baptismRecord['birth_date']); ?></span> <strong>Date of Birth</strong></p>
    <p><span class="underline"><?php echo htmlspecialchars($baptismRecord['place_of_birth']); ?></span> <strong>Place of Birth</strong></p>
    <p><span class="underline"><?php echo htmlspecialchars($baptismRecord['father_name']); ?></span> <strong>Name of Father</strong></p>
    <p><span class="underline"><?php echo htmlspecialchars($baptismRecord['mother_name']); ?></span> <strong>Maiden Name of Mother</strong></p>
    <p><span class="underline"><?php echo htmlspecialchars($baptismRecord['address']); ?></span> <strong>Address of Parents</strong></p>

    <p  style="margin-top: 20px;
    margin-bottom: 20px;font-size: 15px;
    font-weight: 500;"class="subtitle">Was solemnly baptised according to the Rite of the Roman Catholic Church at the</p>
    <p><span class="underline">St. Michael the Archangel Parish Church</span> <strong>Name of Parish</strong></p>
    <p><span class="underline">Argao Cebu, Philippines</span> <strong>Address of Parish</strong></p>
    <p><span class="underline"><?php echo htmlspecialchars($baptismRecord['scheduleDate']); ?></span> <strong>Date of Baptism</strong></p>
    <p><span class="underline">Priest of Argao Church</span> <strong>Baptised by</strong></p>
    <p><span class="underline"><?php echo htmlspecialchars($baptismRecord['godparent']); ?></span> <strong>Sponsored by</strong></p>
</div>

<div class="certification">
    <p style="margin-top: 20px;
    margin-bottom: 20px; font-size: 15px;
    font-weight: 500; padding-left:0;" class="subtitle">THIS IS TO CERTIFY that the above data are true and correct and agree with the Book of Baptism to which I refer in testimony hereof...</p>
</div>

<div class="signatures">
    <div class="signature-left">
        <p><?php echo htmlspecialchars($baptismRecord['priestname']); ?></p>
        <p class="bold">PARISH PRIEST</p>
    </div>
    <div class="signature-right">
        <p>By: ___________________________</p>
        <p class="bold">PARISH STAFF</p>
    </div>
</div>

        </div>
    </div>
    </div>
    
    <?php else: ?>
        <p>Record not found.</p>
    <?php endif; ?>
</body>
</html>
<script>
 document.addEventListener('DOMContentLoaded', function() {
    var currentDate = new Date();
    var day = currentDate.getDate();
    var monthIndex = currentDate.getMonth();
    var year = currentDate.getFullYear(); // Get current year
    
    // Determine day suffix (st, nd, rd, or th)
    var daySuffix;
    if (day >= 11 && day <= 13) {
        daySuffix = "th";
    } else {
        switch (day % 10) {
            case 1:  daySuffix = "st"; break;
            case 2:  daySuffix = "nd"; break;
            case 3:  daySuffix = "rd"; break;
            default: daySuffix = "th";
        }
    }
    
    // Array of month names
    var monthNames = [
        "January", "February", "March",
        "April", "May", "June", "July",
        "August", "September", "October",
        "November", "December"
    ];

    // Update HTML content with current date values
    document.getElementById('dayOfMonth').textContent = day;
    document.getElementById('daySuffix').textContent = daySuffix;
    document.getElementById('month').textContent = monthNames[monthIndex];
    document.getElementById('year').textContent = year; // Update year
});

</script>
