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
    $confirmationId = $_GET['id'];  // Use `id` parameter as the confirmation ID
    $admin = new Admin($conn);
    $confirmationRecord = $admin->getConfirmationRecordById($confirmationId);

    if (!$confirmationRecord) {
        echo "No confirmation record found for this ID.";
        exit;
    }
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
    <title>Certificate of Confirmation</title>
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
    border: 5px solid #d1a14d;
    border-radius: 10px;
       
    }
    .leftext {
        font-weight: bold;
    margin-right: 10px;
    margin-left: 40px;
    min-width: 130px;
    text-align: left;
    white-space: nowrap;
    font-family: "Playfair Display", serif;
    font-size:15px;
}
        .certificate {
            padding: 20px;
    background: white;
    max-width: 700px;
    max-height: 10.5in;
    margin: auto;
    position: relative;
    background: white;
    max-width: 800px;
    margin: auto;
    position: relative;
    background: linear-gradient(to right, #e3dac4, #fdf8f4);
    overflow: hidden;
    border: 10px solid #6c5b3c;
    border-radius: 15px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
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
            font-size: 20px;    font-weight: bold;
    text-align: center;
    margin-top: 10px;
    font-family: "Playfair Display", serif;
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
    
}
    .details p, .baptism-details p, .certification p {
    font-family: "Playfair Display", serif;
    margin: 5px 0;
    text-align: center;

    }
    .details strong {
    display: block;
    font-weight: normal;
    font-size: 12px;
    margin-top: 5px;
    text-align: center;
}
.details {
    font-size: 14px;
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
    width: 100%; /* Span full width of the underline container */
    text-align: center;
    padding: 0 10px;
}
.underline-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    flex-grow: 1;
    margin-right: 170px;
}
.underline-container strong {
    display: block;
    font-weight: normal;
    font-size: 18px;
    margin-top: 5px;
    text-align: center;
    font-family: "Playfair Display", serif;
    font-style: italic;
    font-weight: 500;
}
.issued {
    margin-top: 20px;
    font-size: 15px;
    font-weight: 500;
    text-align: center;
}
.line-item {
    display: flex;
    width: 100%;
    justify-content: flex-start;
    align-items: center;
    margin: 11px 0;
    
}  /*PRINT */

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
        @media print {
    .certificate {
        transform: scale(0.99); /* Scale to 98% */
        transform-origin: top left; /* Ensures scaling starts from the top left */
        width: 100%; /* Optional: ensures content still fills width */
    }
}

        @media print {
    @page {
        size: letter; /* Set page size to Letter (8.5 x 11 inches) */
        margin: 0.5in; /* Adjust margins as needed */
    }

    .certificate {
        width: 100%; /* Make sure content uses full width */
    }
}

</style>
</head>
<body>
<div class="print-button">
    <button  class="btn btn-primary  dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-expanded="false" onclick="window.print()">Print Certificate</button>
</div>
<div class="certificate">
<div class="certificate-inner">
    <div class="seal"></div>
    <div class="header">
    <img style="width:130px!important; height:130px;" src="../assets/img/mainlogonobg.png" alt="Logo Left" class="logo">
        <div class="maintitle">ST. MICHAEL THE ARCHANGEL PARISH CHURCH <br> ARGAO, CHURCH</div>
        <img  style= "height: 90px;width: 96px;"src="images/logo222.png" alt="Logo Right" class="logo">
    </div>
    <div class="content">
        <p style="font-weight: bold; text-align: center; margin:0;">____________________________________________________________________________</p>
        <h1>Certificate of Confirmation</h1>
        <div class="subtitle">This is to certify</div>
        
        <div class="details">
            <div class="line-item">
                <span class="leftext">that</span>
                <div class="underline-container">
                <span class="underline"><?php echo htmlspecialchars($confirmationRecord['fullname']); ?></span>
                <strong>Name of Child</strong>
            </div>
            </div>
            <div class="line-item">
                <span class="leftext">son/daughter of</span>
                <div class="underline-container">
                <span class="underline"><?php echo htmlspecialchars($confirmationRecord['father_fullname']); ?></span>
                <strong>Father's Name</strong>
            </div>
            </div>
            <div class="line-item">
                <span class="leftext">and</span>
                <div class="underline-container">
                <span class="underline"><?php echo htmlspecialchars($confirmationRecord['mother_fullname']); ?></span>
                <strong>Mother's Name</strong>
            </div>
            </div>
            <div class="line-item">
                <span class="leftext">was baptized</span>
                <div class="underline-container">
                <span class="underline"><?php echo htmlspecialchars(date('F j, Y', strtotime($confirmationRecord['date_of_baptism']))); ?> in <?php echo htmlspecialchars($confirmationRecord['church_address']); ?></span>
                <strong>Date, Place</strong>
            </div>
            </div>
            <div class="line-item">
                <span class="leftext">at</span>
                <div class="underline-container">
                <span class="underline"><?php echo htmlspecialchars($confirmationRecord['name_of_church']); ?></span>
                <strong>Church, City, State</strong>
            </div>
            </div>
            <div  class="subtitle">Sacrament of Confirmation</div>
            <div class="line-item">
                <span class="leftext">on</span>
                <div class="underline-container">
                <span class="underline"><?php echo htmlspecialchars(date('F j, Y', strtotime($confirmationRecord['confirmation_date']))); ?></span>
                <strong>Month, Day, Year</strong>
            </div>
        </div>
        </div>
        <p  style="font-size: 15px;
    text-align: center;"class="subtitle">
            in the church of Archdiocesan Shrine of San Miguel Arcangel at Argao Cebu, Philippines
        </p>
        <div class="line-item">
            <span style="margin-right: 0;" class="leftext">Date</span>
            <span style="margin-right: 155px;
    font-family: Style Script, cursive;
    font-weight: 600;
    font-size: 21px; " class="underline"><?php echo date('Y-m-d'); ?></span>
        </div>
        <div class="line-item">
            <span style="margin-right: 0;" class="leftext">Issued by:</span>
            <span style="margin-right: 155px;
    font-family: Style Script, cursive;
    font-weight: 600;
    font-size: 21px; letter-spacing:3px;" class="underline">Staff</span>
        </div>
    </div>
   
    </div>
</div>
</div>

</body>
</html>
