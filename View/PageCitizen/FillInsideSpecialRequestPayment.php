<?php
require_once '../../Model/staff_mod.php';
require_once '../../Model/db_connection.php';
require_once '../../Controller/profilefetchpending_con.php';
require_once '../../Model/citizen_mod.php';
$staff = new Staff($conn);
$citizen = new Citizen($conn);
$appointment_id = isset($_GET['appsched_id']) ? intval($_GET['appsched_id']) : null;

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


$step = 1;
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <!-- Fonts and icons -->
    <script src="assets/js/plugin/webfont/webfont.min.js"></script>
    <script>
      WebFont.load({
        google: { families: ["Public Sans:300,400,500,600,700"] },
        custom: {
          families: [
            "Font Awesome 5 Solid",
            "Font Awesome 5 Regular",
            "Font Awesome 5 Brands",
            "simple-line-icons",
          ],
          urls: ["assets/css/fonts.min.css"],
        },
        active: function () {
          sessionStorage.fonts = true;
        },
      });

      document.addEventListener('DOMContentLoaded', function() {
    const selectedDate = sessionStorage.getItem('selectedDate');
    const selectedTimeRange = sessionStorage.getItem('selectedTime');

    if (selectedDate) {
        document.getElementById('date').value = selectedDate;
    }

    if (selectedTimeRange) {
        const [startTime, endTime] = selectedTimeRange.split('-');
        document.getElementById('start_time').value = startTime;
        document.getElementById('end_time').value = endTime;
    }

    // Optionally, clear the session storage if you don't want to persist the data
  //   sessionStorage.removeItem('selectedDate');
   //  sessionStorage.removeItem('selectedTime');
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
function toggleChapelInput() {
    const select = document.getElementById('exampleFormControlSelect1');
    const chapelInputGroup = document.getElementById('chapelInputGroup');
    
    if (select.value === 'Fiesta Mass') {
      chapelInputGroup.style.display = 'block';
    } else {
      chapelInputGroup.style.display = 'none';
    }
  }

    </script>
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
 integrity="sha384-KyZXEAg3QhqLMpG8r+Knujsl7/1L_dstPt3HV5HzF6Gvk/e3s4Wz6iJgD/+ub2oU" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <!-- CSS Files -->
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="../assets/css/plugins.min.css" />
    <link rel="stylesheet" href="../assets/css/kaiadmin.min.css" />

    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link rel="stylesheet" href="../assets/css/demo.css" />
   
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
    <div class="card-header bg-light border-bottom">
    <div class="d-flex justify-content-between align-items-center">
        <h4 class="card-title mb-0">Check Your Information</h4>
    
    </div>
</div>
<div class="card-body">
<div class="card border-light shadow-sm p-4 mb-4">

        <div class="stepper-wrapper">
            <!-- Step Details -->
            <div class="step-info py-3">
                <div class="alert alert-info">
                    <strong>Note:</strong> Present this reference with the reference Code to the staff when you arrive in person to verify and assist with your event.
                </div>

                <div class="reference-info text-center mb-3">
                    <h5 class="text-uppercase text-muted">Reference Code</h5>
                    <p class="text-primary display-6 fw-bold"><?php echo $reference_number; ?></p>
                </div>

                <?php if (!empty($speaker_app)) : ?>
                    <div class="speaker-info text-center mt-3">
                        <p class="text-muted">Speaker for Seminar:</p>
                        <p class="text-success fw-bold"><?php echo htmlspecialchars($speaker_app); ?></p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
 

  
    </div>
   
    <div class="card-body">

<div class="card-title"><?php echo $pendingItem['event_name'] ?? ''; ?> Request Form</div>
<input type="hidden" name="form_type" value="confirmation">
<div class="row">
<div class="col-md-6 col-lg-4">
<div class="form-group">
                    <label for="date">Date</label>
                    <input type="text" class="form-control" id="date" name="date" 
    placeholder="Enter date"  
    value="<?php echo isset($pendingItem['schedule_date']) && $pendingItem['schedule_date'] !== null ? $pendingItem['schedule_date'] : 'null'; ?>" 
    readonly />
    
                    <span class="error" id="dateError"></span>
                </div>

                <div class="form-group">
                    <label for="selectrequests">Select Type of Request Form</label>
                    <select class="form-select" name="selectrequest" id="selectrequests">
                        <option value="">Select</option>
                        <option <?php echo ($req_category === 'Fiesta Mass') ? 'selected' : ''; ?>>Fiesta Mass</option>
                        <option <?php echo ($req_category === 'Novena Mass') ? 'selected' : ''; ?>>Novena Mass</option>
                        <option <?php echo ($req_category === 'Wake Mass') ? 'selected' : ''; ?>>Wake Mass</option>
                        <option <?php echo ($req_category === 'Monthly Mass') ? 'selected' : ''; ?>>Monthly Mass</option>
                        <option <?php echo ($req_category === '1st Friday Mass') ? 'selected' : ''; ?>>1st Friday Mass</option>
                        <option <?php echo ($req_category === 'Cemetery Chapel Mass') ? 'selected' : ''; ?>>Cemetery Chapel Mass</option>
                        <option <?php echo ($req_category === 'Baccalaureate Mass') ? 'selected' : ''; ?>>Baccalaureate Mass</option>
                        <option <?php echo ($req_category === 'Anointing of the Sick') ? 'selected' : ''; ?>>Anointing of the Sick</option>
                        <option <?php echo ($req_category === 'Blessing') ? 'selected' : ''; ?>>Blessing</option>
                        <option <?php echo ($req_category === 'Special Mass') ? 'selected' : ''; ?>>Special Mass</option>
                    </select>
                    <span class="error" id="selectRequestError"></span>
                </div>

                <div class="form-group">
                    <label for="chapel">Chapel</label>
                    <input type="text" class="form-control" id="chapel" name="chapel" placeholder="Enter Chapel Name" value="<?php echo htmlspecialchars($req_chapel); ?>" />
                    <span class="error" id="chapelError"></span>
                </div>

                <div class="form-group">
<label for="firstname">Firstname of Person Requesting</label>
<input type="text" class="form-control" id="firstname" name="firstname" placeholder="Enter Firstname" value="<?php echo htmlspecialchars($first_name_req); ?>" />
<span id="firstnameError" class="error text-danger"></span>
</div>

<div class="form-group">
<label for="lastname">Last Name of Person Requesting</label>
<input type="text" class="form-control" id="lastname" name="lastname" placeholder="Enter Lastname" value="<?php echo htmlspecialchars($last_name_req); ?>" />
<span id="lastnameError" class="error text-danger"></span>
</div>

<div class="form-group">
<label for="middlename">Middle Name of Person Requesting</label>
<input type="text" class="form-control" id="middlename" name="middlename" placeholder="Enter Middlename" value="<?php echo htmlspecialchars($middle_name_req); ?>" />
<span id="middlenameError" class="error text-danger"></span>
</div>

            </div>

            <div class="col-md-6 col-lg-4">
                <div class="form-group">
                    <label for="start_time">Start Time</label>
                    <input type="text" class="form-control" id="start_time" name="start_time" placeholder="" value="<?php echo htmlspecialchars($startTime); ?>" readonly />
                    <span class="error" id="startTimeError"></span>
                </div>

                <div class="form-group">
                    <label for="address">Address</label>
                    <input type="text" class="form-control" name="address" id="address" placeholder="Enter Address" value="<?php echo htmlspecialchars($req_address); ?>" />
                    <span class="error" id="addressError"></span>
                </div>

                <div class="form-group">
<label for="cal_date">Calendar Date</label>
<input type="date" class="form-control" id="cal_date" name="cal_date" value="<?php echo htmlspecialchars($cal_date); ?>" />
<span class="error" id="calDateError"></span>
</div>


                <div class="form-group">
                    <label for="cpnumber">Contact Number</label>
                    <label for="cpnumber">Ex:09*********</label>
                    <input type="number" class="form-control" id="cpnumber" name="cpnumber" placeholder="Enter Contact Number" value="<?php echo htmlspecialchars($req_pnumber); ?>" />
                    <span id="cpnumberError" class="error text-danger"></span>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="form-group">
                    <label for="end_time">End Time</label>
                    <input type="text" class="form-control" id="end_time" name="end_time" placeholder="" value="<?php echo htmlspecialchars($endTime); ?>" readonly />
                    <span class="error" id="endTimeError"></span>
                </div>

                <div class="form-group">
<label for="firstnames">Firstname of Person (Pamisahan)</label>
<input type="text" class="form-control" id="firstnames" name="firstnames" placeholder="Enter Firstname" value="<?php echo htmlspecialchars($first_name); ?>" />
<span id="firstnamesError" class="error text-danger"></span>
</div>

<div class="form-group">
<label for="lastnames">Last Name of Person (Pamisahan)</label>
<input type="text" class="form-control" id="lastnames" name="lastnames" placeholder="Enter Lastname" value="<?php echo htmlspecialchars($last_name); ?>" />
<span id="lastnamesError" class="error text-danger"></span>
</div>

<div class="form-group">
<label for="middlenames">Middle Name of Person (Pamisahan)</label>
<input type="text" class="form-control" id="middlenames" name="middlenames" placeholder="Enter Middlename" value="<?php echo htmlspecialchars($middle_name); ?>" />
<span id="middlenamesError" class="error text-danger"></span>
</div>
                                    
                                </div>
                                
                            </div>
   
                            <div class="card-action">
             <button type="button" class="btn btn-success" onclick="window.history.back();">Back</button>
      
             </div>
    </div>
</div>

    </div>
</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require_once 'footer.php'?>
    <script>
      // Get today's date
      
    const today = new Date();
    // Format the date as YYYY-MM-DD
    const yyyy = today.getFullYear();
    const mm = String(today.getMonth() + 1).padStart(2, '0'); // Months are zero-based
    const dd = String(today.getDate() + 1).padStart(2, '0'); // Add 1 to the current date
    const nextDay = `${yyyy}-${mm}-${dd}`;

    // Set the min attribute of the input field
    document.getElementById('datetofollowup').setAttribute('min', nextDay);
    function validateForm() {
    let isValid = true;

    // Helper function to validate field
    function validateField(id, errorId, message) {
        const field = document.getElementById(id);
        const value = field.value.trim();
        if (value === '') {
            document.getElementById(errorId).innerText = message;
            field.classList.add('error', 'text-danger');
            isValid = false;
        } else {
            document.getElementById(errorId).innerText = '';
            field.classList.remove('error', 'text-danger');
        }
    }

    // Clear previous error messages and styles
    document.querySelectorAll('.error.text-danger').forEach(e => e.innerHTML = '');
    document.querySelectorAll('.form-control').forEach(e => e.classList.remove('error', 'text-danger'));

    // Validate fields in the form
    validateField('firstname', 'firstnameError', 'Firstname is required');
    validateField('lastname', 'lastnameError', 'Lastname is required');

    validateField('address', 'addressError', 'Address is required');
  
    validateField('chapel', 'chapelError', 'Chapel is required');
    validateField('datetofollowup', 'dobError', 'Date must required');

    // Validate contact number specifically
    const cpnumberInput = document.getElementById('cpnumber');
    const cpnumberValue = cpnumberInput.value.trim();
    const cpnumberError = document.getElementById('cpnumberError');

    // Check if contact number is empty
    if (cpnumberValue === '') {
        cpnumberError.innerText = 'Contact Number is required';
        cpnumberInput.classList.add('error', 'text-danger');
        isValid = false;
    } 
    // Validate contact number format
    else if (cpnumberValue.length !== 11 || !cpnumberValue.startsWith('09')) {
        cpnumberError.innerText = 'Contact number must be 11 digits and start with "09".';
        cpnumberInput.classList.add('error', 'text-danger');
        isValid = false;
    } else {
        cpnumberError.innerText = '';
        cpnumberInput.classList.remove('error', 'text-danger');
    }

    // Validate request selection
    const selectrequest = document.getElementById('selectrequests').value;
    if (selectrequest === '') {
        document.getElementById('selectRequestError').innerText = 'Selected Request is required';
        isValid = false;
    } else {
        document.getElementById('selectRequestError').innerText = '';
    }

    return isValid;
}


    </script>
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
.error {
        color: red;
        font-size: 0.875em;
        margin-top: 0.25em;
    }
    .form-control.error {
        border: 1px solid red;
    }
    </style>

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
