<?php 
session_start();
if (!isset($_SESSION['otp_verified']) || $_SESSION['otp_verified'] !== true) {
    header("Location: otp_verification.php");
    exit();
}
$errorMessage = isset($_SESSION['errorMessage']) ? $_SESSION['errorMessage'] : '';
unset($_SESSION['errorMessage']); // Clear the message after displaying it
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Change Password</title>
     <!-- Google Web Fonts -->
     <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&family=Inter:slnt,wght@-10..0,100..900&display=swap"
    rel="stylesheet"
  />
  <link
    rel="stylesheet"
    href="https://unicons.iconscout.com/release/v4.0.0/css/line.css"
  />
  <!-- Icon Font Stylesheet -->
  <link
    rel="stylesheet"
    href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"
  />
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css"
    rel="stylesheet"
  />

  <!-- Libraries Stylesheet -->
  <link rel="stylesheet" href="lib/animate/animate.min.css" />
  <link href="lib/lightbox/css/lightbox.min.css" rel="stylesheet" />
  <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet" />

  <!-- Customized Bootstrap Stylesheet -->
  <link href="css/bootstrap.min.css" rel="stylesheet" />

  <!-- Template Stylesheet -->
  <link href="css/style.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>



    <style>
        /* Optional: Style to make error messages more visible */
        #password_error_message, #confirm_password_error_message {
            color: red;
        }  /* Inline styling for simplicity, replace with your CSS file as needed */
         /* Reset some default styles */
          /* Reset some default styles */
          * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Arial', sans-serif;
    }

    /* Centering Wrapper */
    .center-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 80vh; /* Full height to center vertically */
        background-color: #f9f9f9; /* Light background for contrast */
        padding: 20px;
    }

    /* Styling for the OTP Container */
    .OTPContainer {
        height: 650px;
        max-width: 533px;
        width: 100%;
        padding: 20px;
        background: #ffffff; /* White background for the container */
        box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.1);
        text-align: center;
        transition: transform 0.3s ease; /* Animation on hover */
    }

  
  
    h1:hover {
        color: #4285f4; /* Change color on hover */
    }

    /* Explanation text styling */
    p {
        font-size: 1em;
        color: #666;
        margin-bottom: 20px;
    }

    /* Form styling */
    .form-group {
        margin-bottom: 30px;
                text-align: left;
    }

    label {
        font-size: 0.9em;
        color: #555;
    }

    input[type="text"] {
        width: 100%;
        padding: 12px;
        margin-top: 5px;
        font-size: 1em;
        border: 2px solid #ddd;
        border-radius: 8px;
        transition: border-color 0.3s ease, box-shadow 0.3s ease; /* Add transition effects */
    }
    input[type="password"] {
        width: 100%;
        padding: 12px;
        margin-top: 5px;
        font-size: 1em;
        border: 2px solid #ddd;
        border-radius: 8px;
        transition: border-color 0.3s ease, box-shadow 0.3s ease; /* Add transition effects */
    }

    input[type="text"]:focus {
        border-color: #4285f4; /* Change border color on focus */
        box-shadow: 0 0 5px rgba(66, 133, 244, 0.5); /* Add shadow on focus */
        outline: none; /* Remove outline */
    }
    input[type="password"]:focus {
        border-color: #4285f4; /* Change border color on focus */
        box-shadow: 0 0 5px rgba(66, 133, 244, 0.5); /* Add shadow on focus */
        outline: none; /* Remove outline */
    }

    /* Button styling */
    .button {
        width: 100%;
        padding: 12px;
        font-size: 1em;
        color: #fff;
        background-color: #4285f4; /* Google-like blue */
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: background-color 0.3s ease, transform 0.2s ease; /* Button hover effects */
    }

    .button:hover {
        background-color: #357ae8; /* Darker blue on hover */
        transform: translateY(-2px); /* Slight lift effect on hover */
    }

    /* Secondary button styling */
    .button-secondary {
        background-color: #f1f3f4;
        color: #202124;
        margin-top: 10px;
    }

    .button-secondary:hover {
        background-color: #e0e0e0; /* Darker gray on hover */
        transform: translateY(-2px); /* Slight lift effect on hover */
    }

    /* Error message styling */
    .error-message {
        color: #d93025; /* Error red color */
        font-size: 0.9em;
        margin-top: 10px;
    }

    /* Link styling for Back to Login */
    a {
        color: #4285f4; /* Blue link color */
        text-decoration: none; /* Remove underline */
        transition: color 0.3s ease; /* Link color transition */
    }

    a:hover {
        text-decoration: underline; /* Underline on hover */
    }
    /* Input icon container */
.input-icon-container {
    position: relative; /* To position the icon relative to the container */
}

.input-icon-container i {
    position: absolute; /* Position the icon absolutely within the container */
    left: 12px; /* Space from the left edge */
    top: 50%; /* Center vertically */
    transform: translateY(-50%); /* Adjust for vertical centering */
    color: #aaa; /* Icon color */
}

.input-icon-container input[type="text"] {
    width: 100%;
    padding: 12px 12px 12px 50px; /* Add padding to the left to make space for the icon */
    margin-top: 5px;
    font-size: 1em;
    border: 2px solid #ddd;
    border-radius: 8px;
    transition: border-color 0.3s ease, box-shadow 0.3s ease; /* Add transition effects */
}
.input-icon-container input[type="password"] {
    width: 100%;
    padding: 12px 12px 12px 50px; /* Add padding to the left to make space for the icon */
    margin-top: 5px;
    font-size: 1em;
    border: 2px solid #ddd;
    border-radius: 8px;
    transition: border-color 0.3s ease, box-shadow 0.3s ease; /* Add transition effects */
}
/* Additional styles for focus effect */
.input-icon-container input[type="text"]:focus {
    border-color: #4285f4; /* Change border color on focus */
    box-shadow: 0 0 5px rgba(66, 133, 244, 0.5); /* Add shadow on focus */
    outline: none; /* Remove outline */
}
.input-icon-container input[type="password"]:focus {
    border-color: #4285f4; /* Change border color on focus */
    box-shadow: 0 0 5px rgba(66, 133, 244, 0.5); /* Add shadow on focus */
    outline: none; /* Remove outline */
}
.input-icon-container i {
    position: absolute; /* Position the icon absolutely within the container */
    left: 12px; /* Space from the left edge */
    top: 50%; /* Center vertically */
    transform: translateY(-50%); /* Adjust for vertical centering */
    color: #aaa; /* Icon color */
    font-size: 2em; /* Change this value to adjust the icon size */
}
h1 {
    letter-spacing: 1px;
    font-size: 35px!important; /* Font size for both the title and "Required" */
    font-weight: 800!important; /* Font weight for both the title and "Required" */
    margin-bottom: 20px; /* Space below the title */
    padding-top: 20px; /* Add padding around the title */
    padding-left: 5px; /* Add padding around the title */
    padding-right: 5px; /* Add padding around the title */
    padding-bottom: 10px; /* Add padding around the title */

    text-align: center; /* Center the title */
    color: #013979!important; /* Change the color as needed */
}

.required-text {
    display: block; /* Makes "Required" take up a full line */
    font-size: inherit; /* Inherit the font size from the h1 */
    font-weight: inherit; /* Inherit the font weight from the h1 */
    margin-top: 10px; /* Space between the main title and "Required" */
    color: #013979; /* Color for "Required" */
}
p {
    font-size: 0.9em; /* Smaller font size for the paragraphs */
    line-height: 1.4; /* Slightly less line-height for compactness */
    margin: 0; /* Removes default margin */
    padding: 5px 10px; /* Adds padding around the paragraph for better spacing */
    text-align: left; /* Centers the text */
    color: #555; /* Sets a medium grey color for contrast */
    border-radius: 3px; /* Slightly rounded corners */
    margin-bottom: 15px; /* Space below paragraphs */
}strong {
    font-weight: bold; /* Ensure it's bold */
}

    </style>
    <script>
function validatePassword() {
    const newPassword = document.getElementById('new_password').value.trim();
    const confirmPassword = document.getElementById('confirm_password').value.trim();
    const passwordErrorMessage = document.getElementById('password_error_message');
    const confirmPasswordErrorMessage = document.getElementById('confirm_password_error_message');

    // Updated regex pattern to include dot as a valid special character
    const passwordRegex = /^(?=.*[A-Z])(?=.*\d)(?=.*[!@#\$%\^&\*\.])[A-Za-z\d!@#\$%\^&\*\.]{8,}$/;

    // Clear previous error messages
    passwordErrorMessage.textContent = "";
    confirmPasswordErrorMessage.textContent = "";

    let valid = true; // Assume valid unless proven otherwise

    // Validate new password
    if (newPassword === '') {
        passwordErrorMessage.textContent = "Please enter a password.";
        valid = false; // Set valid to false
    } else if (!passwordRegex.test(newPassword)) {
        passwordErrorMessage.textContent = "Password must be at least 8 characters long, with an uppercase letter, a number, and a special character.";
        valid = false; // Set valid to false
    }

    // Validate confirm password
    if (confirmPassword === '') {
        confirmPasswordErrorMessage.textContent = "Please enter the password confirmation.";
        valid = false; // Set valid to false
    } else if (newPassword !== confirmPassword) {
        confirmPasswordErrorMessage.textContent = "The confirmation password must match the new password.";
        valid = false; // Set valid to false
    }

    return valid; // Allow form submission only if valid is still true
}


    </script>
    
</head>
<body>
<!-- Navbar & Hero Start -->
<div class="container-fluid nav-bar px-0 px-lg-4 py-lg-0">
      <div class="container">
      <?php require_once 'navbar.php'?>

      </div>
    </div>
    <!-- Navbar & Hero End -->
      
     <!-- Centering Wrapper --> 
<div class="center-wrapper">
    <div class="OTPContainer">
<h1 style="font-size:40px;"> Change Your Password</h1>
<p>To enhance the security of your account, you will be required to update your password after successfully verifying your identity through the One-Time Password (OTP) sent to your registered email.</p>

<p>Once both fields match and meet the security requirements, you can submit your new password to complete the process. This ensures your account is secure and ready for use.</p>
        <?php
// Display error or success messages
if ($errorMessage) {
    echo "<p style='color:red;'>$errorMessage</p>";
}
?>

    <form action="../../Controller/process_change_password.php" method="POST" onsubmit="return validatePassword()">
    <div class="form-group">
        <label for="new_password">New Password:</label>

        <div class="input-icon-container">
        <i class="uil uil-lock-access"></i>
         <input type="password" id="new_password" name="new_password">
         
         </div>
         <p id="password_error_message"></p>
    <label for="confirm_password">Confirm Password:</label>

    <div class="input-icon-container">
        <i class="uil uil-lock-access"></i>
        <input type="password" id="confirm_password" name="confirm_password">
       
        </div>
        <p id="confirm_password_error_message"></p>
        <button style="margin-top:10px;" type="submit" class="button">Change Password</button>
        <p style="margin-top: 8px; font-size: 0.9em;text-align:center!important;">
                <a href="otp_verification.php" style="color: #4285f4; text-decoration: none; ">Back</a>
            </p>
        </div>
 <!-- Specific error message for confirm password -->
        </div>
        </div>
        </form>
        </div>
        </div>
    </form>
    <?php require_once '../../footer.php'; ?>
</body>
</html>