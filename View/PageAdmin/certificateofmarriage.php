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
    $weddingId = $_GET['id'];

    $admin = new Admin($conn);
    $weddingRecord = $admin->getWeddingRecordById($weddingId);

    if (!$weddingRecord) {
        echo "Record not found.";
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
    <title>Certificate of Marriage</title>

    <style>
   /* Import Google Fonts for Pinyon Script and Playfair Display */
   @import url('https://fonts.googleapis.com/css2?family=Style+Script&display=swap');
   @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Style+Script&display=swap');
   @import url('https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Style+Script&display=swap');
   @import url('https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap');

   /* Global Styles */
   body {
       font-family: Arial, sans-serif;
       text-align: center;
       margin: 0;
       background-color: #f9f6f1;
   }
   .certificate-inner {
    padding: 15px;
    border: 5px solid #d1a14d;
    border-radius: 10px;
       
    }
   .certificate {
       padding: 20px;
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
       border: 4px solid #D1A14D;
       border-radius: 20px;
       z-index: -1;
   }

   /* Header Styles */
   .header {
       display: flex;
       justify-content: space-between;
       align-items: center;
       margin-bottom: 20px;
   }

   
   .maintitle {
       font-size: 22px;
       text-align: center;
       font-family: "Playfair Display", serif;
       font-weight: bold;
       color: #6c5b3c;
   }

   /* Title Styles */
   h1 {
       font-family: "Great Vibes", cursive;
       font-size: 3.5rem;
       margin-bottom: 1rem;
       letter-spacing: 6px;
       margin-top: 23px;
       color: #4b3001;
   }

   .divider-line {
       text-align: center;
       font-weight: bold;
       margin: 10px 0;
   }

   .intro-text {
       text-align: center;
       margin-top: 20px;
   }

   /* Marriage Specific Content */
   .spacing {
       margin-top: 15px;
   }

   .underline {
       display: inline-block;
       border-bottom: 1px solid #000;
       width: 100%;
       padding: 0 10px;
       font-size: 30px;
              font-weight: 600;
       font-style: italic;
       font-family: "Style Script", cursive;
       letter-spacing: 3px;
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

   .details p {
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
   }

   /* Seal Styles */
   .seal {
       position: absolute;
       top: 50%;
       left: 50%;
       transform: translate(-50%, -50%);
       width: 600px;
       height: 600px;
       background-image: url('images/seal.png'); /* Path to your logo */
       background-size: contain;
       background-repeat: no-repeat;
       opacity: 0.1;
       z-index: 1;
   }

   /* Signature Styles */
   .signatures {
       display: flex;
       justify-content: space-between;
       align-items: center;
     
       flex-direction: column;
   }

   .signature-item {
       display: flex;
       flex-direction: column;
       align-items: center;
       text-align: center;
   }

   .signature-item span.underline {
       display: block;
       width: 150px;
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

 

    /*PRINT */

 
        .spacing {
    display: flex; /* Aligns the <p> and <span> horizontally */
    align-items: center; /* Ensures vertical alignment of <p> and <span> */
    justify-content: center; /* Keeps everything aligned to the left */
}

.spacing p {
    margin-right: 10px; /* Adds space between <p> and <span> */
    font-family: "Playfair Display", serif; /* Optional: Customize font */
    font-size: 16px; /* Optional: Adjust font size */
    font-weight: 700;
}

.underline {
    display: inline-block; /* Ensures the underline is inline with text */
    border-bottom: 1px solid #000; /* Underline style */
    padding-bottom: 2px; /* Adjust padding for better alignment */
    font-size: 16px; /* Same font size as the <p> */
}

.strong-container {
    text-align: center; /* Centers the <strong> text */
}

strong {
    display: inline-block;
    font-size: 18px;
    font-family: "Playfair Display", serif;
    font-weight: bold;
    font-style: italic;
}
.signatures {
    text-align: center; /* Centers the entire content */
    font-family: "Playfair Display", serif; /* Optional font */
}

.underline-line {
    text-align: center;
    font-size: 20px; /* Adjust size as needed */
    margin-bottom: 10px; /* Space between the underline and the "Dated" text */
}

.bold-container {
    margin-top: 10px; /* Adds space between elements */
}

.bold {
    font-weight: bold;
    font-size: 18px; /* Adjust size as needed */
}

.underline-container {
    margin-top: 35px;
}

.underline {
    display: inline-block; /* Keeps the underline text inline */
    border-bottom: 1px solid #000; /* Adds the underline */
    padding-bottom: 2px; /* Adjust for the desired look */
    font-size: 18px; /* Same font size as the bold text */
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
    <p style="font-weight: bold; text-align: center;">____________________________________________________________________________</p>
    <h1>Certificate of Marriage</h1>
    <p  style="    text-align: center;
    font-family: Playfair Display, serif;
    font-size: 19px;
    font-weight: 600;">This is to certify</p>
    
    <div style="margin-left: 45px;
    margin-right: 45px;" class="spacing">
    <p>That</p>
    <span  style="font-size: 25px;"class="underline"><?php echo htmlspecialchars($weddingRecord['groom_and_bride']); ?></span>
</div>
<div class="strong-container">
    <strong>Groom Name / Bride Name</strong>
</div>


    <p style="text-align: center;text-align: center;
    font-size: 20px;
    font-family: Playfair Display, serif;
    font-weight: 700;">were lawfully MARRIED</p>
    
    <div tyle="margin-left: 45px;
    margin-right: 45px;" class="spacing">
        <p>on the</p>
        <div class="line-item">
            <span class="small-underline"> <?php 
                    $weddingDate = $weddingRecord['s_date'];
                    $day = date('jS', strtotime($weddingDate));
                    echo htmlspecialchars($day);
                ?></span>
            <span class="leftext center-text">day of</span>
            <span class="small-underline"> <?php 
                    $monthYear = date('F Y', strtotime($weddingDate));
                    echo htmlspecialchars($monthYear);
                ?></span>
        </div>
    </div>

    <p style="    text-align: center;
    font-family: Playfair Display, serif;
    font-size: 19px;
    font-weight: 600; margin-left: 45px;
    margin-right: 45px;">According to the Rite of the Roman Catholic Church and in conformity with the laws of</p>

    <div style="margin-left: 45px;
    margin-right: 45px;" class="spacing">
        <p>the</p>
        <span class="underline">St. Michael The Archangel Church</span>
    </div>

    <div style="margin-left: 45px;
    margin-right: 45px;" class="spacing">
        <p>Rev. </p>
        <span class="underline"><?php echo htmlspecialchars($weddingRecord['priest_name']); ?></span>
    </div>

    <div class="signatures">
    <p class="underline-container"></p>
    <span style="width: 40%;" class="underline"> <?php echo date("F j, Y"); ?></span>
    </div>
    <div class="bold-container">
        <p  style="margin: 0;    text-align: center;
    font-family: Playfair Display, serif;
    font-size: 19px;
    font-weight: 600;" class="bold">Dated </p>
    </div>

    <div class="underline-container">
        <span style="width: 40%;" class="underline"></span>
    </div>
    <div class="bold-container">
        <p  style="margin: 0;    text-align: center;
    font-family: Playfair Display, serif;
    font-size: 19px;
    font-weight: 600;" class="bold">Pastor</p>
    </div>
</div>

</div>

</div>
</body>
</html>