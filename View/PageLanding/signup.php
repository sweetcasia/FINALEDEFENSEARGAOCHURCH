<?php 
require_once '../../Controller/login_con.php';

// Prevent browser from caching the login page
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0"); // HTTP 1.1.
header("Pragma: no-cache"); // HTTP 1.0.
header("Expires: 0"); // Proxies.

// Check if the user wants to log out
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
  // Destroy all session data to log the user out
  session_unset();
  session_destroy();
  
  // Redirect to login page after logout
  header("Location: ../../index.php");
  exit();
}

// Check if the user is already logged in
if (isset($_SESSION['email']) && isset($_SESSION['user_type'])) {
  // Retrieve user status from session or query it from the database, if necessary
  $userType = $_SESSION['user_type'];
  $r_status = $_SESSION['r_status']; // Assumes r_status is stored in session when logging in
  
  // Redirect based on user type and r_status
  switch ($userType) {
      case "Staff":
          if ($r_status === "Active") {
              header("Location: ../PageStaff/StaffDashboard.php");
              exit();
          }
          break;
      case "Citizen":
          if ($r_status === "Approved") {
              header("Location: ../PageCitizen/CitizenPage.php");
              exit();
          }
          break;
          case "Priest":
            if ($r_status === "Active") {
                header("Location: ../PagePriest/index.php");
                exit();
            }
            break;
            case "Admin":
                  header("Location: ../PageAdmin/AdminDashboard.php");
                  exit();
              
              break;
  }
}

?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <title>ARGAO CHURCH MANAGEMENT SYSTEM</title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <link rel="icon" href="../assets/img/mainlogo.jpg" type="image/x-icon" />
    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@100..1000&family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <!-- Icon Font Stylesheet -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Libraries Stylesheet -->
    <link rel="stylesheet" href="lib/animate/animate.min.css" />
    <link href="lib/lightbox/css/lightbox.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/sigin.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <style>
                   .error{
        color: red;
        font-size: 14px;
        margin-top: 5px;
        color: red;            /* Text color for error messages */
    font-size: 12px;      /* Font size for error messages */
    margin-top: 5px;      /* Space above the error message */
    display: block;        /* Ensures the error message is on a new line */
    line-height: 1.2;     /* Adjusts line height for better readability */
    }
             .error-message {
        color: red;
        font-size: 14px;
        margin-top: 5px;
        color: red;            /* Text color for error messages */
    font-size: 12px;      /* Font size for error messages */
    margin-top: 5px;      /* Space above the error message */
    display: block;        /* Ensures the error message is on a new line */
    line-height: 1.2;     /* Adjusts line height for better readability */
    }
    .input-error {
        border: 1px solid red;
    }
    .birthday-input {
    font-family: Arial, sans-serif;
    margin-bottom: 10px;
}

.birthday-input label {
    display: block;
    font-weight: bold;
    margin-bottom: 5px;
}

.birthday-selectors {
  display: flex;
    gap: 20px;
    width: 100%;
    justify-content: space-between;
    height: 37px;
}


.birthday-selectors select {
  height: 100%;
  width: 100%;
  border: none;
  outline: none;
  padding: 0px 4px  ;
    color: #333;
  transition: all 0.2s ease;
  border: none; /* Remove all borders initially */
border-bottom: 1.5px solid #0066a8; /* Add bottom border */
  border-radius: 5px;

}

.birthday-selectors select:focus {
  border-bottom-color: #ac0727cf; /* Change bottom border color on focus */
  box-shadow: 0 0 5px rgba(172, 7, 39, 0.5); /* Shadow with related red color on focus */
}


small {
    display: block;
    color: #555;
    margin-top: 5px;
}
     .float-left{
        width:900px;
     }
        .back-button {
float:right;       
margin-right:110px;  
margin-top:20px;  

            padding: 0.5rem 1rem;
            background-color: #0066a8;
            color: #fff;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            font-size: 1rem;
            transition: background-color 0.3s ease;
        }  .back-button:hover {
            background-color: #004a80;
        }
        .clearfix::after {
    content: "";
    display: table;
    clear: both;
}p{
    color:#3b3b3b; text-align: justify; text-justify: inter-word; font-size: 15px; line-height: 1.6; margin-top: 10px; margin-left: 10px;
}
.button1 {
  padding: 6px 24px;
  border: 2px solid #fff;
  background: transparent;
  border-radius: 6px;
  cursor: pointer;
}
.button1:active {
  transform: scale(0.98);
} .form_container h2 {
  font-size: 22px;
  color: #0b0217;
  text-align: center;
}
.input_box {
  position: relative;
  margin-top: 35px;
  width: 100%;
  height: 40px;
  display: flex;
position: relative;
gap:25px;
}
.input_box input {
  height: 100%;
  width: 100%;
  border: none;
  outline: none;
  padding: 0 30px;
  color: #333;
  transition: all 0.2s ease;
  border: none; /* Remove all borders initially */
border: 1.5px solid #0066a8; /* Add bottom border */}

.input_box input:focus {
  border: 1px solid #ac0727cf; /* Change bottom border color on focus */
  box-shadow: 0 0 5px rgba(172, 7, 39, 0.5); /* Shadow with related red color on focus */
}

.input_box select {
  height: 100%; 
  width: 100%;
  border: none; /* Remove all borders initially */
  outline: none; /* Remove outline */
  color: #333; /* Text color */
  background-color: none!important; /* No background color */
  transition: all 0.2s ease; /* Smooth transition for focus effects */
border: 1.5px solid #0066a8; /* Add bottom border */
}

.input_box select:focus {
  border: 1px solid #ac0727cf; /* Change bottom border color on focus */
  box-shadow: 0 0 5px rgba(172, 7, 39, 0.5); /* Shadow with related red color on focus */
}
.input_box i {
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  font-size: 20px;
  color: #707070;
  padding-left: 7px;
}

.input_box i.email,
.input_box i.password {
  left: 0;
}
.input_box input:focus ~ i.email,
.input_box input:focus ~ i.password {
  color: #ac0727cf;
}
/* Style for all icons within .input_group when the input is focused */
.input_group input:focus ~ i.uil {
    color: #ac0727cf; /* Replace with your preferred focus color */
}

/* Optional: Add a transition effect for smoother color change */
i.uil {
    transition: color 0.3s ease;
}


.input_box i.pw_hide {
  right: 0;
  font-size: 18px;
  cursor: pointer;
  padding-right: 7px;
}
.option_field {
  margin-top: 14px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  position: relative;
    
    width: 100%;
    height: 40px;
}
.form_container a {
  color: #7d2ae8;
  font-size: 12px;
}
.form_container a:hover {
  text-decoration: underline;
}
.checkbox {
  display: flex;
  column-gap: 8px;
  white-space: nowrap;
}
.checkbox input {
  accent-color: #ac0727cf;
}
.checkbox label {
  font-size: 15px;
  cursor: pointer;
  user-select: none;
  color: #0b0217;
}
.form_container .button {
  background: #7d2ae8;
  margin-top: 30px;
  width: 100%;
  padding: 10px 0;
  border-radius: 10px;
}
.login_signup {
  font-size: 15px;
  text-align: center;
  margin-top: 15px;
}
.option_field a{
  color: #000;
  font-size: 15px;
}
.option_field a:hover {
  text-decoration: underline;
}
.input_group {
      /* display: flex; */
      flex-direction: column;
    /* position: relative; */
    /* margin-top: -21px; */
    width: 100%;
    height: 40px;
    /* display: flex; */
    position: relative;
}
  

  /* Label styling */
  .input_group label {
    font-size: 15px;
    font-weight: 500;
  }

  /* Input styling */
  .input_group input[type="date"],
  .input_group input[type="file"] {
    padding: 7px;    font-size: 16px;
    height: 100%;
    width: 100%;
  border: none;
  outline: none;
  color: #333;
  background-color: white!important; /* No background color */
  transition: all 0.2s ease; /* Smooth transition for focus effects */
  border: 1.5px solid #0066a8; /* Add bottom border */
  }
  @media (max-width: 950px) {
    .responsive-image {
        display: none;
    }
}
.signuphover {
  color: #0066a8; /* Initial text color */
  text-decoration: none; /* Remove default underline */
  transition: color 0.3s; /* Smooth transition for color changes */
  position: relative; /* Position relative to allow for pseudo-element */
}

.signuphover:hover {
  color: #ac0727cf; /* Change text color on hover */
}

.signuphover:hover::after {
  content: ''; /* Create a pseudo-element for the underline */
  position: absolute; /* Position it relative to the link */
  left: 0; /* Align it with the left of the link */
  bottom: -2px; /* Position it slightly below the text */
  width: 100%; /* Full width underline */
  height: 2px; /* Height of the underline */
  background-color: #ac0727cf; /* Color of the underline */
  transition: width 0.3s; /* Smooth transition for the underline */
}
.input_group {
  position: relative; /* Ensure the tooltip positions relative to this parent */
}

/* Tooltip icon styling */
.tooltip-icon {
    position: relative;
    cursor: pointer;
    font-size: 16px;
    color: #555;
}

/* Tooltip content styling */
.tooltip-content {
    visibility: hidden;
    opacity: 0;
    width: 180px; /* Adjust width to make it smaller */
    background-color: #333;
    color: #fff;
    padding: 8px; /* Adjust padding for smaller appearance */
    font-size: 0.85em; /* Smaller font size */
    border-radius: 5px;
    position: absolute;
    top: 50%;
    left: 22%; /* Position it to the right of the icon */
    transform: translateY(-50%);
    text-align: left;
    box-shadow: 0px 0px 8px rgba(0, 0, 0, 0.2);
    z-index: 1000;
    transition: opacity 0.3s ease;
}
/* Arrow pointing towards the icon */
.tooltip-content::before {
    content: "";
    position: absolute;
    top: 45%;
    left: -13px; /* Adjust this to move arrow closer or further from the icon */
    transform: translateY(-50%);
    border-width: 6px;
    border-style: solid;
    border-color: transparent #333 transparent transparent;
}
/* Show tooltip content on hover */
.tooltip-icon:hover + .tooltip-content {
    visibility: visible;
    opacity: 1;
}

/* Hover color for icons */

    </style>
    </head>

    <body>
 
    <div class="container-fluid nav-bar px-0 px-lg-4 py-lg-0">
      <div class="container">
      <?php require_once 'navbar.php'?>

      </div>
    </div>

      <div class="container1">
      <div class="forms-container">
        <div class="signin-signup">
          <form method="POST" action=""  class="sign-up-form">
          <input type="hidden" name="login_form" value="1">
          <h2 style="text-align:Center;"class="title">Log in</h2>
          <div class="error" id="login_error">
        <?php
        if (isset($_SESSION['login_error'])) {
            echo htmlspecialchars($_SESSION['login_error']);
            unset($_SESSION['login_error']); // Clear the message after displaying
        }
        ?>
    </div>
            <div class="input_box">
              <input type="text" name="email" class="form-control" id="email" placeholder="name@example.com"/>
              <i class="uil uil-envelope-alt email"></i>
            </div>
            <div class="input_box">
              <input type="password" name="password" class="form-control" id="password" placeholder="Password"/>
              <i class="uil uil-lock password"></i>
              <i class="uil uil-eye-slash pw_hide"></i>
            </div>
            <div class="option_field">
              <span class="checkbox">
                <input type="checkbox" id="check" />
                <label for="check">Remember me</label>
              </span>
              <a href="forgotstep1.php" class="forgot_pw">Forgot your password?</a> <!-- Updated link -->
            </div>
            <button type="submit" class="btn btn-primary py-3 w-100 mb-4">Log In</button>
            
            <div class="login_signup">Don't have an account? <a href="#"   id="sign-in-signbutton">Register here!</a></div>
           
          </form>


          <form method="POST" action=""  enctype="multipart/form-data" onsubmit="return validateForm()"class="sign-in-form">
          <input type="hidden" name="signup_form" value="1">
          <h2 style="text-align:Center;"class="title">Register</h2>
          <div class="input_box">
            <div class="input_group">
            <input type="text" class="form-control" name="first_name" id="first_name" placeholder="First Name">
            <i class="uil uil-user"></i>
        <div class="error" id="first_name_error"></div>  
            </div>
            <div class="input_group">
              <input type="text" class="form-control" name="last_name" id="last_name" placeholder="Last Name">
              <i class="uil uil-user"></i>
              <div class="error" id="last_name_error"></div>
              </div>
              <div class="input_group">
              <input type="text" class="form-control" name="middle_name" id="middle_name" placeholder="Middle Name">
              <i class="uil uil-user"></i>
              <div class="error" id="middle_name_error"></div>
              
              </div>
            </div>
           
            <div class="input_box">
            <div class="input_group">

            <select style="  background-color: #ffffff!important; " class="form-control" name="gender"  class="input_box" id="gender" placeholder="name@example.com">
    
            <option value="" disabled selected>Select gender</option>
            <option>Male</option>
            <option>Female</option>
        </select>
        <div class="error" id="gender_error"></div>

        </div>
      
        <div class="input_group">
        <input type="text" class="form-control" id="address" name="address" placeholder="Address">
        <i class="uil uil-map-marker-alt"></i>
        <div class="error" id="address_error"></div>

        </div>
      </div>

            <div class="input_box">
  <div class="input_group" style=" margin-top: -8px;">
  <div class="birthday-input">
 <label for="month">Date of Birth</label>
  <div class="birthday-selectors">
  <select id="month" name="month">
                <option value="">Month</option>
                <option value="01">January</option>
                <option value="02">February</option>
                <option value="03">March</option>
                <option value="04">April</option>
                <option value="05">May</option>
                <option value="06">June</option>
                <option value="07">July</option>
                <option value="08">August</option>
                <option value="09">September</option>
                <option value="10">October</option>
                <option value="11">November</option>
                <option value="12">December</option>
            </select>
            <select id="day" name="day">
                <option value="">Day</option>
                <!-- Generate options 1 to 31 -->
                <?php for ($i = 1; $i <= 31; $i++): ?>
                    <option value="<?php echo sprintf('%02d', $i); ?>"><?php echo $i; ?></option>
                <?php endfor; ?>
            </select>
            <select id="year" name="year">
                <option value="">Year</option>
                <!-- Generate options from 1900 to current year -->
                <?php for ($i = date('Y'); $i >= 1900; $i--): ?>
                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                <?php endfor; ?>
            </select>
  </div>
  </div>
  <div class="error" id="c_date_birth_error"></div>
  </div>

  <div class="input_group">
  <label for="validID">Valid ID</label>
  
  <!-- Tooltip icon with adjacent tooltip content -->
  <span class="tooltip-icon" id="tooltip-icon">
    &#9432; <!-- Info icon -->
  </span>
  <div class="tooltip-content">
    <strong>List of Valid IDs:</strong>
    <ul>
      <li>Driver's License</li>
      <li>Passport</li>
      <li>National ID</li>
      <li>Voter's ID</li>
      <li>Company ID</li>
      <li>School ID</li>
      <li>Senior Citizen ID</li>
    </ul>
  </div>

  <input type="file" class="form-control" id="valid_id" name="valid_id" accept="image/*" placeholder="Valid ID">
  <div class="error" id="valid_id_error"></div>
</div>

  </div>

  <div class="input_box" style="margin-top: 56px!important;">
  <div class="input_group">
    <input type="tel" class="form-control" name="phone" id="phone" placeholder="Phone number (e.g., +639xxxxxxxxx)" value="+63">
    <i class="uil uil-phone"></i>    <div class="error" id="phone_error"></div>
</div>

              <div class="input_group">
              <input type="text" class="form-control" name="email" id="emails" placeholder="name@example.com">
              <div class="error" id="email_error"></div>
              <i class="uil uil-envelope-alt email"></i>
              </div>
              </div>
          
            <div class="input_box">
            <div class="input_group">

            <input type="password" class="form-control" id="passwords" name="password" placeholder="Password">
            <div class="error" id="password_error"></div>
            <i class="uil uil-lock password"></i>
            </div>
            <div class="input_group">

          <input type="password" class="form-control" id="confirmpassword" name="confirmpassword" placeholder="Confirm Password">
          <div class="error" id="confirmpassword_error"></div>
          <i class="uil uil-lock password"></i>
            </div>

            </div>
            <br>
            <br>
            <button style="    width: 100%;" type="submit" class="btn btn-primary py-3 w-100 mb-4">Register</button>
            <div class="login_signup">Already have an account? <a href="#" id="sign-up-signbutton">Signin</a></div>

         
        </div>
        </form>
      </div>

      <div class="panels-container">
      <div class="panel left-panel">
    <div class="content">
        <h2 style="font-weight:bolder;">WELCOME TO ARGAO CHURCH OFFICIAL WEBSITE</h2>
        <p>
            Discover the rich history, faith, and community spirit of the Archdiocesan Shrine of San Miguel Arcangel. Our church has been a cornerstone of Argao, Cebu, for centuries, providing a place of worship, celebration, and connection for all. Log in to access church schedules, events, and services, and stay connected with our vibrant parish community. Thank you for being part of our journey of faith!
        </p>
    </div>
    <img src="img/log.svg" class="image responsive-image" alt="" />
</div>

        <div class="panel right-panel">
          <div class="content">
            <h3>JOIN OUR ARGAO CHURCH COMMUNITY</h3>
            <p>
            Become a part of the Archdiocesan Shrine of San Miguel Arcangel family by creating your account today. By signing up, you’ll gain access to our event schedules, church services, announcements, and more. Connect with our parish, stay updated on upcoming activities, and engage with a community that shares your faith. We look forward to welcoming you!
            </p>
           
          </div>
          <img src="img/register.svg" class="image" alt="" />
        </div>
      </div>
    </div>

    <script src="app.js"></script>
    <script>
      document.getElementById("sign-up-signbutton").addEventListener("click", function() {
    document.querySelector(".sign-in-form").style.display = "none";
    document.querySelector(".sign-up-form").style.display = "block";
});

document.getElementById("sign-in-signbutton").addEventListener("click", function() {
    document.querySelector(".sign-up-form").style.display = "none";
    document.querySelector(".sign-in-form").style.display = "block";
});

function showError(inputId, errorMessage) {
    const errorElement = document.getElementById(inputId + "_error");
    if (errorElement) {
        errorElement.textContent = errorMessage;
    }
}

function clearError(inputId) {
    const errorElement = document.getElementById(inputId + "_error");
    if (errorElement) {
        errorElement.textContent = "";
    }
}

function validatePhoneNumber() {
    const phoneInput = document.getElementById('phone');
    // Remove any non-numeric characters except the + sign
    phoneInput.value = phoneInput.value.replace(/[^0-9+]/g, '');

    // Ensure the input starts with +63
    if (!phoneInput.value.startsWith('+63')) {
        phoneInput.value = '+63';
    }

    // Limit the length to +63 and 10 digits (13 characters in total)
    if (phoneInput.value.length > 13) {
        phoneInput.value = phoneInput.value.slice(0, 13);
    }

    // Show error if the number of digits is incorrect
    const phoneError = document.getElementById('phone');
    if (phoneInput.value.length < 13) {
        phoneError.textContent = "Please enter a valid 10-digit phone number after +63.";
    } else {
        phoneError.textContent = "";
    }
}

      function validateForm() {
    // Clear previous errors
    clearErrors();

    let isValid = true;

    // Validate first name
    const firstName = document.getElementById("first_name").value.trim();
    if (firstName === "") {
        showError("first_name", "First Name is required");
        isValid = false;
    }

    // Validate last name
    const lastName = document.getElementById("last_name").value.trim();
    if (lastName === "") {
        showError("last_name", "Last Name is required");
        isValid = false;
    }

    const email = document.getElementById("emails").value.trim();
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (email === "") {
        showError("email", "Email is required");
        isValid = false;
    } else if (!emailPattern.test(email)) {
        showError("email", "Invalid email format");
        isValid = false;
    } else if (!email.endsWith("@gmail.com")) {
        showError("email", "Email must end with @gmail.com");
        isValid = false;
    } else {
        // Make an AJAX call to check if email exists
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "../../Controller/check_email.php", false); // Use synchronous request
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                if (xhr.responseText === "exists") {
                    showError("email", "Email already exists.");
                    isValid = false;
                }
            }
        };
        xhr.send("email=" + encodeURIComponent(email));
    }

    // Validate gender
    const gender = document.getElementById("gender").value;
    if (gender === "") {
        showError("gender", "Gender is required");
        isValid = false;
    }

    // Validate phone number
    const phone = document.getElementById("phone").value.trim();
    if (phone === "") {
        showError("phone", "Phone number is required");
        isValid = false;
    } else if (!phone.startsWith("+63") || phone.length !== 13) {
        showError("phone", "Phone number must be in the format +63 followed by 10 digits.");
        isValid = false;
    }

    // Validate date of birth
    const month = document.getElementById("month").value;
    const day = document.getElementById("day").value;
    const year = document.getElementById("year").value;
    if (month === "" || day === "" || year === "") {
        showError("c_date_birth", "Date of Birth is required");
        isValid = false;
    } else if (!isValidDate(month, day, year)) {
        showError("c_date_birth", "Invalid Date of Birth");
        isValid = false;
    } else if (!isAtLeast15YearsOld(year, month, day)) {
        showError("c_date_birth", "You must be at least 16 years old");
        isValid = false;
    }

    // Validate address
    const address = document.getElementById("address").value.trim();
    if (address === "") {
        showError("address", "Address is required");
        isValid = false;
    }

    // Validate valid ID
    const validId = document.getElementById("valid_id").value.trim();
    if (validId === "") {
        showError("valid_id", "Valid ID is required");
        isValid = false;
    }

    // Validate password
    const password = document.getElementById("passwords").value.trim();
    const passwordPattern = /^(?=.*[A-Z])(?=.*[0-9])(?=.*[.!@#]).{1,}$/; 
    if (password === "") {
        showError("password", "Password is required");
        isValid = false;
    }else if (!passwordPattern.test(password)) {
        showError("password", "Password must start with a capital letter and contain at least one number and one of these special characters: .!@#");
        isValid = false;
    }
  

    // Validate confirm password
    const confirmPassword = document.getElementById("confirmpassword").value.trim();
    if (confirmPassword !== password) {
        showError("confirmpassword", "ConfirmationPasswords do not match");
        isValid = false;
    }
    if (confirmPassword === "") {
        showError("confirmpassword", "ConfirmationPassword is required");
        isValid = false;
    }

    if (password !== confirmPassword) {
        showError("password", "Passwords do not match");
        isValid = false;
    }

    return isValid; // Ensure to return the overall validity
}


function showError(inputId, errorMessage) {
    const inputElement = document.getElementById(inputId);
    const errorElement = document.getElementById(inputId + "_error");

    if (inputElement) {
        inputElement.classList.add("input-error");
    }

    if (errorElement) {
        errorElement.textContent = errorMessage;
    }
}

function clearErrors() {
    const errorElements = document.querySelectorAll(".error");
    errorElements.forEach((element) => {
        element.textContent = "";
    });

    const inputElements = document.querySelectorAll(".form-control");
    inputElements.forEach((element) => {
        element.classList.remove("input-error");
    });
}

function isValidDate(month, day, year) {
    // Convert values to integers
    const monthInt = parseInt(month, 10);
    const dayInt = parseInt(day, 10);
    const yearInt = parseInt(year, 10);

    // Check if the date is valid
    if (monthInt < 1 || monthInt > 12) {
        return false;
    }

    const daysInMonth = new Date(yearInt, monthInt, 0).getDate();
    return dayInt > 0 && dayInt <= daysInMonth;
}

function isAtLeast15YearsOld(year, month, day) {
    const today = new Date();
    const birthDate = new Date(year, month - 1, day); // JavaScript months are 0-based
    const age = today.getFullYear() - birthDate.getFullYear();

    if (today.getMonth() + 1 < month || (today.getMonth() + 1 === month && today.getDate() < day)) {
        return age - 1 >= 16;
    }

    return age >= 16;
}

        const sign_in_signbutton = document.querySelector("#sign-in-signbutton");
const sign_up_signbutton = document.querySelector("#sign-up-signbutton");
const container = document.querySelector(".container1");

sign_up_signbutton.addEventListener("click", () => {
  container.classList.add("sign-up-mode");
});

sign_in_signbutton.addEventListener("click", () => {
  container.classList.remove("sign-up-mode");
});
    </script>
    <?php require_once 'footer.php'?>

    </div>
    </div>

        <!-- Back to Top -->
<script>
 const pwShowHide = document.querySelectorAll(".pw_hide");

pwShowHide.forEach((icon) => {
  icon.addEventListener("click", () => {
    // Select the input field that is inside the same parent as the icon
    let getPwInput = icon.parentElement.querySelector("input");
    
    if (getPwInput.type === "password") {
      getPwInput.type = "text"; // Show password
      icon.classList.replace("uil-eye-slash", "uil-eye"); // Toggle icon
    } else {
      getPwInput.type = "password"; // Hide password
      icon.classList.replace("uil-eye", "uil-eye-slash"); // Toggle icon
    }
  });
});


          
    var acc = document.getElementsByClassName("accordion");
    var i;

    for (i = 0; i < acc.length; i++) {
        acc[i].addEventListener("click", function() {
            this.classList.toggle("active");
            var panel = this.nextElementSibling;
            if (panel.style.display === "block") {
                panel.style.display = "none";
            } else {
                panel.style.display = "block";
            }
        });
    }
</script>
        <!-- JavaScript Libraries -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="lib/wow/wow.min.js"></script>
        <script src="lib/easing/easing.min.js"></script>
        <script src="lib/waypoints/waypoints.min.js"></script>
        <script src="lib/counterup/counterup.min.js"></script>
        <script src="lib/lightbox/js/lightbox.min.js"></script>
        <script src="lib/owlcarousel/owl.carousel.min.js"></script>
        

        <!-- Template Javascript -->
        <script src="js/main.js"></script>
    </body>

</html>