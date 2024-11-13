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
    $defunctorumId = $_GET['id'];

    $admin = new Admin($conn);
    $defunctorumRecord = $admin->getDefunctorumRecordById($defunctorumId);
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
    <title>Certificate of DEFUNCTORUM</title>

    <style>
   /* Import Google Fonts for Pinyon Script and Open Sans */
   @import url('https://fonts.googleapis.com/css2?family=Style+Script&display=swap');
   @import url('https://fonts.googleapis.com/css2?family=Noto+Sans+Ethiopic:wght@100..900&family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Style+Script&display=swap');
   @import url('https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Noto+Sans+Ethiopic:wght@100..900&family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Style+Script&display=swap');
   @import url('https://fonts.googleapis.com/css2?family=Great+Vibes&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Noto+Sans+Ethiopic:wght@100..900&family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Style+Script&display=swap');
/* Bold style for any text */
.signatures {
    display: flex;
    justify-content: space-between;
    align-items: center;
    /* width: 100%; */
    margin-left: 72px;
    margin-right: 107px;
}

.signature-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
}

.signature-item span.underline {
    display: block;
    width: 150px; /* Set a fixed width for the underline */
    border-bottom: 1px solid #000;
    margin-bottom: 5px;
}

.signature-item p {
    margin: 0;
    padding: 0;
}

.signature-item p strong {
    display: block;
    margin-top: 5px;
}

/* Title-specific styling */
h1 {
    font-family: "Great Vibes", cursive;
    font-size: 3.5rem;
            margin-bottom: 1rem;
            letter-spacing:6px;
            margin-top: 23px;
            color:#4b3001;
}

.divider-line {
    text-align: center;
    font-weight: bold;
    margin: 10px 0;
}.intro-text {
    text-align: center;
    margin-top: 20px;
}

.line-item {
    display: flex;
    align-items: center;
    justify-content: flex-start;
    width: 100%;
    margin: 10px 0;
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
            margin-bottom: 10px;

        }
        .logo {
            width: 100px;
            height: 100px;
            object-fit: cover; /* Ensure the image fits within the circle */
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
    font-size: 15px;
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
    margin-top: 20px;
}


    .bold {
        font-weight: bold;
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


.date-label {
    font-size: 12px;
    font-weight: normal;
    margin-left: 10px;
    text-align: center;
}



.small-underline {
    display: inline-block;
    margin-bottom: 5px;
    font-size: 25px;
    font-weight: 600;
    font-style: italic;
    font-family: "Style Script", cursive;
    letter-spacing: 3px;
    min-width: 145px;
        border-bottom: 1px solid #000;
    

}
.center-text {
    display: inline-block;
    text-align: center;
    min-width: 145px;
        border-bottom: 1px solid #000;
    padding: 0 5px;
    font-size: 17px;
}/*PRINT */
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
    
    <p class="divider-line">____________________________________________________________________________</p>
    <h1>Certificate of Death</h1>
    
    <div class="subtitle">This is to certify</div>

    <div class="details">
    <div class="line-item">
        <span class="leftext">That</span>
        <div class="underline-container">
            <span class="underline"><?php echo htmlspecialchars($defunctorumRecord['fullname']); ?></span>
            <strong>Name of Deceased</strong>
        </div>
    </div>

    <div class="line-item">
        <span class="leftext">born at</span>
        <div class="underline-container">
            <span class="underline"><?php echo htmlspecialchars($defunctorumRecord['place_of_birth']); ?></span>
            <strong>Place of Birth</strong>
        </div>
    </div>

    <div class="line-item">
    <span class="leftext">on the</span>
    <span class="small-underline"><?php echo htmlspecialchars(date('jS', strtotime($defunctorumRecord['date_of_birth']))) ?></span>
    <span style="min-width: 95px;
    border-bottom: none;
    margin-left: 0;
    margin-right: 0;" class="leftext center-text">day of</span>
    <span style="    min-width: 140px;" class="small-underline"><?php echo htmlspecialchars(date('F Y', strtotime($defunctorumRecord['date_of_birth']))) ?></span>
</div>

    <div class="line-item">
        <span class="leftext">died at</span>
        <div class="underline-container">
            <span class="underline"><?php echo htmlspecialchars($defunctorumRecord['place_of_death']); ?></span>
            <strong>Place of Death</strong>
        </div>
    </div>

    <div class="line-item">
        <span class="leftext">on the</span>
            <span class="small-underline"><?php echo htmlspecialchars(date('jS', strtotime($defunctorumRecord['date_of_death']))); ?></span>
            <span style="min-width: 95px;
    border-bottom: none;
    margin-left: 0;
    margin-right: 0;" class="leftext center-text">day of</span>
            <span style="    min-width: 140px;" class="small-underline"><?php echo htmlspecialchars(date('F Y', strtotime($defunctorumRecord['date_of_death']))); ?></span>
    </div>

    <p class="subtitle"><strong>and was buried with the rites of</strong></p>
    <p class="subtitle" style="font-size: 25px;"><strong>The Roman Catholic Church</strong></p>
    
    <div class="line-item">
        <span class="leftext">in</span>
        <div class="underline-container">
            <span  style="    font-size: 22px;padding:4px;
"class="underline">St. Michael the Archangel Parish Church</span>
            <strong>Place of Burial</strong>
        </div>
    </div>

    <p  style="font-weight: 600;
    font-size: 15px;"class="subtitle">as it appears from the Death Register of this Church.</p>

<div class="signatures">
    <div Style="    margin-top: 50px;" class="signature-item">
        <span class="underline"></span>
        <p><strong>Rev.</strong></p>
    </div>
   
    <div Style="    margin-top: 30px;" class="signature-item">
    <p><?php echo date("F j, Y"); ?></p>

        <span class="underline"></span>
        <p><strong>Dated</strong></p>
    </div>
</div>


    
</div>
</div>
</div>

</body>
</html>