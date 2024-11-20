<?php
session_start();
$errorMessage = isset($_SESSION['errorMessage']) ? $_SESSION['errorMessage'] : '';
unset($_SESSION['errorMessage']); // Clear the message after displaying it
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify OTP</title>
    <link rel="stylesheet" href="assets/fontawesome/css/all.min.css">
  
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
  <link rel="stylesheet" href="View/PageLanding/lib/animate/animate.min.css" />
  <link href="View/PageLanding/lib/lightbox/css/lightbox.min.css" rel="stylesheet" />
  <link href="View/PageLanding/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet" />

  <!-- Customized Bootstrap Stylesheet -->
  <link href="View/PageLanding/css/bootstrap.min.css" rel="stylesheet" />

  <!-- Template Stylesheet -->
  <link href="View/PageLanding/css/style.css" rel="stylesheet" />
  <link rel="stylesheet" href="View/PageLanding/css/rating.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

<style>
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
        height: 600px;
        max-width: 533px;
        width: 100%;
        padding: 20px;
        background: #ffffff; /* White background for the container */
        box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.1);
        text-align: center;
        transition: transform 0.3s ease; /* Animation on hover */
    }

  
    /* Title styling */
    h1 {
        font-size: 1.8em;
        margin-bottom: 16px;
        color: #333;
        transition: color 0.3s ease; /* Color transition */
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
        margin-bottom: 15px;
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

    input[type="text"]:focus {
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

/* Additional styles for focus effect */
.input-icon-container input[type="text"]:focus {
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
    font-size: 25px!important; /* Font size for both the title and "Required" */
    font-weight: 800!important; /* Font weight for both the title and "Required" */
    margin-bottom: 20px; /* Space below the title */
    padding-top: 20px; /* Add padding around the title */
    padding-left: 5px; /* Add padding around the title */
    padding-right: 5px; /* Add padding around the title */
    padding-bottom: 20px; /* Add padding around the title */

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
    <h1>Email Verification<br><span class="required-text">Required</span></h1>
        
        <!-- Explanation for OTP Verification -->
        <p>To confirm the email address you provided, please enter the OTP sent to your email.<strong>This verification step helps ensure your email is valid and secure.</strong></p>
        <p>By completing this step keeps your account safe and ensures you get important updates.</p>

        <!-- Error message -->
        <?php if ($errorMessage): ?>
            <p class="error-message"><?php echo $errorMessage; ?></p>
        <?php endif; ?>

        <!-- OTP verification form -->
        <form id="verifyForm" method="POST" action="Controller/otp_processing_con.php">
            <div class="form-group">
                <label for="otp">Enter OTP:</label>
                
                <div class="input-icon-container">
        <i class="uil uil-lock-access"></i>
        <input type="text" id="otp" name="otp" required>
    </div>
            </div>
            <button type="submit" class="button">Verify OTP</button>
        </form>

        <!-- Request new OTP button -->
        <form id="requestOtpForm" method="POST" action="Controller/otp_processing_con.php">
            <button type="submit" name="request_new_otp" class="button button-secondary">Request New OTP</button>
            <p style="margin-top: 8px; font-size: 0.9em;text-align:center!important;">
                <a href="login.php" style="color: #4285f4; text-decoration: none; ">Back to Login</a>
            </p>
        </form>
    </div>
</div>
    <?php require_once 'footer.php'?>

<?php
// Display error or success messages
if ($errorMessage) {
    echo "<p style='color:red;'>$errorMessage</p>";
}
?>

<script>
  let isSubmitting = false; // Track form submissions
  let isUnloading = false; // Track if the page is unloading

  // Track form submissions
  document.getElementById("verifyForm").addEventListener("submit", function () {
      isSubmitting = true;
  });

  document.getElementById("requestOtpForm").addEventListener("submit", function () {
      isSubmitting = true;
  });

  // Listen for the beforeunload event
  window.addEventListener("beforeunload", function (event) {
      // If the user is not submitting a form and the page is unloading, send the delete request
      if (!isSubmitting) {
          isUnloading = true;
          navigator.sendBeacon('Controller/delete_account_con.php');
      }
  });

  // Optional: reset the unloading state when the page loads
  window.addEventListener("load", function () {
      if (isUnloading) {
          isUnloading = false; // Reset if the page is loaded
      }
  });
</script>

</body>
</html>
