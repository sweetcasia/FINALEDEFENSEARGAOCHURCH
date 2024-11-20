<?php

require_once '../../Model/db_connection.php';
require_once '../../Controller/citizen_con.php';
session_start();

// Check if user is logged in
if (!isset($_SESSION['email']) || !isset($_SESSION['user_type'])) {
    header("Location: ../../index.php");
    exit();
}

// Redirect based on user type
switch ($_SESSION['user_type']) {
    case 'Citizen':
        // Allow access
        break;
    case 'Admin':
        header("Location: ../PageAdmin/AdminDashboard.php");
        exit();
    case 'Staff':
        header("Location: ../PageStaff/StaffDashboard.php");
        exit();
    case 'Priest':
        header("Location: ../PagePriest/index.php");
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

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>ARGAO CHURCH MANAGEMENT SYSTEM</title>
    <meta
      content="width=device-width, initial-scale=1.0, shrink-to-fit=no"
      name="viewport"
    />
    <link rel="icon" href="../assets/img/mainlogo.jpg" type="image/x-icon"
    />
    
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
    <link rel="stylesheet" href="cs/rating.css">
    
    <style>
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
    gap: 5px;
}


.birthday-selectors select {
    padding: 5px;
    border: 1px solid #0a58ca;
    border-radius: 5px;
    width: 100px;
    font-size: 14px;
    color: #555;
}

.birthday-selectors select:focus {
    outline: none;
    border-color: #0a58ca;
}


small {
    display: block;
    color: #555;
    margin-top: 5px;
}
.error {
        color: red;
        font-size: 0.875em;
        margin-top: 0.25em;
    }
    .form-control.error {
        border: 1px solid red;
    }


    </style>
    <script>
document.addEventListener('DOMContentLoaded', function() {
    const selectedDate = sessionStorage.getItem('selectedDate');
    let selectedTimeRange = sessionStorage.getItem('selectedTime');

    if (selectedDate) {
        document.getElementById('date').value = selectedDate;
    }

    if (selectedTimeRange) {
        // Clean up the selectedTimeRange to ensure it doesn't contain unwanted text
        // Remove 'Available' if present
        selectedTimeRange = selectedTimeRange.replace('Available -', '').replace('Available', '').trim();

        const [startTime, endTime] = selectedTimeRange.split('-');
        
        // Ensure there are no leading or trailing spaces in the time values
        if (startTime) {
            document.getElementById('start_time').value = startTime.trim();
        }
        if (endTime) {
            document.getElementById('end_time').value = endTime.trim();
        }
    }

    // Optionally, clear the session storage if you don't want to persist the data
    // sessionStorage.removeItem('selectedDate');
    // sessionStorage.removeItem('selectedTime');
});



document.addEventListener('DOMContentLoaded', function() {
    document.querySelector('.btn-info').addEventListener('click', function() {
        // Loop through all input, textarea, and select elements within the form
        document.querySelectorAll('.form-control, select').forEach(function(element) {
            if (element.id !== 'date' && element.id !== 'start_time' && element.id !== 'end_time') {
                // Clear text inputs and textareas
                if (element.type === 'text' || element.tagName === 'TEXTAREA') {
                    element.value = '';
                }
                // Uncheck radio and checkbox inputs
                else if (element.type === 'radio' || element.type === 'checkbox') {
                    element.checked = false;
                }
                // Reset select elements to their first option
                else if (element.tagName === 'SELECT') {
                    element.selectedIndex = 0;
                }
            }
        });

        // Clear any error messages
        document.querySelectorAll('.error').forEach(function(error) {
            error.textContent = ''; // Clear error messages
        });
    });
});


document.getElementById('baptismForm').addEventListener('submit', function(event) {
    // Get the values of the first name, last name, and middle name
    var firstname = document.getElementById('firstname').value.trim();
    var lastname = document.getElementById('lastname').value.trim();
    var middlename = document.getElementById('middlename').value.trim();

    // Concatenate them into a full name
    var fullname = firstname + ' ' + middlename + ' ' + lastname;

    // Set the concatenated full name into the hidden fullname input
    document.getElementById('fullname').value = fullname;
});



    </script>
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
 integrity="sha384-KyZXEAg3QhqLMpG8r+Knujsl7/1L_dstPt3HV5HzF6Gvk/e3s4Wz6iJgD/+ub2oU" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <!-- CSS Files -->
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="../assets/css/plugins.min.css" />
    <link rel="stylesheet" href="../assets/css/kaiadmin.min.css" />

    
  </head>
  <body>
  
   <!-- Navbar & Hero Start -->
   <div class="container-fluid nav-bar px-0 px-lg-4 py-lg-0">
      <div class="container">
       
      <?php require_once 'header.php'?>

      </div>
    </div>
    <!-- Navbar & Hero End -->
    
  <div class="container">
    <div class="page-inner">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Baptism Fill-up Form</div>
                    </div>
                    <div class="card-body">
                    <form method="post" action="../../Controller/citizen_con.php" onsubmit="return validateForm()">
                    
                    <input type="hidden" name="baptism_id" name="form_type" value="baptism">
    <div class="row">
        <div class="col-md-6 col-lg-4">
            <div class="form-group">
                <label for="date">Date</label>
                <input type="text" class="form-control" id="date" name="date" placeholder="" readonly />
                <span class="error" id="dateError"></span>
            </div>
            <div class="form-group">
                <label for="firstname">Firstname of person to be baptized:</label>
                <input type="text" class="form-control" id="firstname" name="firstname" placeholder="Enter Firstname"  
        />
                <span class="error" id="firstnameError"></span>
            </div>
            <div class="form-group">
                <label for="lastname">Last Name of person to be baptized:</label>
                <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Enter Lastname" />
                <span class="error" id="lastnameError"></span>
            </div>
            <div class="form-group">
                <label for="middlename">Middle Name of person to be baptized:</label>
                <input type="text" class="form-control" id="middlename" name="middlename" placeholder="Enter Middlename"   />
                <span class="error" id="middlenameError"></span>
            </div>
            <input type="hidden" id="fullname" name="fullname" />
            <div class="form-group">
                <label for="address">Address</label>
                <textarea class="form-control" id="address" name="address" placeholder="Enter Address"><?php if (isset($userDetails)) echo htmlspecialchars($userDetails['address']); ?></textarea>
                <span class="error" id="addressError"></span>
            </div>
           
        </div>
        <div class="col-md-6 col-lg-4">
            <div class="form-group">
                <label for="start_time">Start Time</label>
                <input type="text" class="form-control" id="start_time" name="start_time" placeholder="" readonly />
              <span class="error" id="startTimeError"></span>
            </div>
            <div class="form-group">
                <label for="pbirth">Place of Birth</label>
                <input type="text" class="form-control" id="pbirth" name="pbirth" placeholder="Enter Place of Birth" />
                <span class="error" id="pbirthError"></span>
            </div>
            <div class="form-group">
    <div class="birthday-input">
        <label for="month">Date of Birth</label>
        <div class="birthday-selectors">
            <select id="months" name="month">
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

            <select id="days" name="day">
                <option value="">Day</option>
                <!-- Generate options 1 to 31 -->
                <?php for ($i = 1; $i <= 31; $i++): ?>
                    <option value="<?php echo sprintf('%02d', $i); ?>"><?php echo $i; ?></option>
                <?php endfor; ?>
            </select>

            <select id="years" name="year">
                <option value="">Year</option>
                <!-- Generate options from 1900 to current year -->
                <?php for ($i = date('Y'); $i >= 1900; $i--): ?>
                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                <?php endfor; ?>
            </select>
        </div>
      
                    <span class="error" id="dobError"></span>
                
    </div>
    
</div>
<div class="form-group">
    <label for="father_name">Father's Fullname</label>
    <input type="text" class="form-control" id="father_name" name="father_fullname" placeholder="Enter Father's Fullname"
        <?php
        // Display father's name if user is male
        if (isset($userDetails) && $userDetails['gender'] === 'Male') {
            echo 'value="' . htmlspecialchars($userDetails['fullname']) . '"';
        }
        ?> />
    <span class="error" id="fatherNameError"></span>
</div>

<div class="form-group">
    <label for="mother_name">Mother's Fullname</label>
    <input type="text" class="form-control" id="mother_name" name="mother_fullname" placeholder="Enter Mother's Fullname"
        <?php
        // Display mother's name if user is female
        if (isset($userDetails) && $userDetails['gender'] === 'Female') {
            echo 'value="' . htmlspecialchars($userDetails['fullname']) . '"';
        }
        ?> />
    <span class="error" id="motherNameError"></span>
</div>
        </div>
        <div class="col-md-6 col-lg-4">
            <div class="form-group">
                <label for="end_time">End Time</label>
                <input type="text" class="form-control" id="end_time" name="end_time" placeholder="" readonly />
                  <span class="error" id="endTimeError"></span>
            </div>
            <div class="form-group">
                <label>Gender</label><br />
                <div class="d-flex">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="gender" id="flexRadioDefault1" value="Male" />
                        <label class="form-check-label" for="flexRadioDefault1">Male</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="gender" id="flexRadioDefault2" value="Female" />
                        <label class="form-check-label" for="flexRadioDefault2">Female</label>
                    </div>
                </div>
                <span class="error" id="genderError"></span>
            </div>
            <div class="form-group">
                <label for="parents_residence">Parents Residence</label>
                <textarea class="form-control" id="parents_residence" name="parent_resident" placeholder="Enter Parents Residence"></textarea>
                <span class="error" id="parentsResidenceError"></span>
            </div>
            <div class="form-group">
                <label for="godparents">List Of GodParents</label>
                <textarea class="form-control" id="godparents" name="godparent" placeholder="Enter List Of GodParents"></textarea>
                <span class="error" id="godparentsError"></span>
            </div>
            
            <div class="form-group">
                <label for="religion">Religion</label>
                <input type="text" class="form-control" id="religion" name="religion" placeholder="Enter Religion" />
                <span class="error" id="religionError"></span>
            </div>
        </div>
    </div>
    <div class="card-action">
        <button type="submit" class="btn btn-success">Submit</button>
        <a href="javascript:history.back()" class="btn btn-danger">Cancel</a>
        <button type="button" class="btn btn-info" onclick="clearForm()">Clear</button>
    </div>
</form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require_once 'footer.php'?>

<script>

function validateForm() {
    let isValid = true; 

    // Helper function to validate field
    function validateField(id, errorId, message) {
        const field = document.getElementById(id);
        const value = field.value.trim();
        if (value === '') {
            document.getElementById(errorId).innerText = message;
            field.classList.add('error');
            isValid = false;
        } else {
            document.getElementById(errorId).innerText = '';
            field.classList.remove('error');
        }
    }

    // Clear previous error messages and styles
    document.querySelectorAll('.error').forEach(e => e.innerHTML = '');
    document.querySelectorAll('.form-control').forEach(e => e.classList.remove('error'));

    // Validate fields
    validateField('firstname', 'firstnameError', 'Firstname is required');
    validateField('lastname', 'lastnameError', 'Lastname is required');
    validateField('address', 'addressError', 'Address is required');
    validateField('religion', 'religionError', 'Religion is required');
    validateField('pbirth', 'pbirthError', 'Place of Birth is required');
    validateField('father_name', 'fatherNameError', 'Father\'s Fullname is required');
    validateField('mother_name', 'motherNameError', 'Mother\'s Fullname is required');
    validateField('parents_residence', 'parentsResidenceError', 'Parents Residence is required');
    validateField('godparents', 'godparentsError', 'List Of Godparents is required');
    validateField('date', 'dateError', 'Date is required');
    validateField('start_time', 'startTimeError', 'Start Time is required');
    validateField('end_time', 'endTimeError', 'End Time is required');

    // Validate gender
    const gender = document.querySelector('input[name="gender"]:checked');
    if (!gender) {
        document.getElementById('genderError').innerText = 'Gender is required';
        document.querySelector('input[name="gender"]').classList.add('error');
        isValid = false;
    } else {
        document.getElementById('genderError').innerText = '';
        document.querySelector('input[name="gender"]').classList.remove('error');
    }

    // Validate date of birth
    const month = document.getElementById('months').value;
    const day = document.getElementById('days').value;
    const year = document.getElementById('years').value;
    if (month === '' || day === '' || year === '') {
        document.getElementById('dobError').innerText = 'Date of birth is required';
        isValid = false;
    } else {
        document.getElementById('dobError').innerText = '';
    }

    // Check if the form is valid
    if (!isValid) {
        console.log('Validation failed, form not submitted.');
        return false;  // Prevent form submission
    }

    console.log('Validation passed, form will be submitted.');
    return true;  // Allow form submission
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"
        integrity="sha384-KyZXEAg3QhqLMpG8r+8auK+4szKfEFbpLHsTf7iJgD/+ub2oU" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.js"></script>
    <!--   Core JS Files   -->
    <script src="../assets/js/core/jquery-3.7.1.min.js"></script>
    <script src="../assets/js/core/popper.min.js"></script>
    <script src="../assets/js/core/bootstrap.min.js"></script>

    <!-- jQuery Scrollbar -->
    <script src="../assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>

  
    <!-- Kaiadmin JS -->
    <script src="../assets/js/kaiadmin.min.js"></script>

  
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
