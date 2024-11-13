<?php
require_once '../../Model/staff_mod.php';
require_once '../../Controller/fetchrequestpending_con.php';
require_once '../../Model/db_connection.php';
require_once '../../Model/citizen_mod.php';
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
$citizen = new Citizen($conn);
$staff = new Staff($conn);
$request_id = isset($_GET['req_id']) ? intval($_GET['req_id']) : null;
$request_ids = isset($_GET['req_id']) ? intval($_GET['req_id']) : null;
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
  <body style="background: #eee; ">
  
     
  <?php  require_once 'sidebar.php'?>
      <div class="main-panel">
      <?php  require_once 'header.php'?>
        
     
      <div class="container">
      <div class="page-inner">
  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Approval for Schedule Baptism</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="modalForm" method="POST" action="../../Controller/addbaptism_con.php">
                <div class="modal-body">
            <input type="hidden" name="specialrequestform_ids" value="<?php echo htmlspecialchars($request_id); ?>" />
            <div class="form-group">
    <label for="eventTitle1">Payable Amount</label>
    <input type="number" class="form-control" id="eventTitle" name="eventTitle" placeholder="Enter Amount">
    <span id="amountError" class="text-danger"></span> <!-- Error message span -->
</div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Second Modal -->



    <div class="page-inner">
 
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">SPECIAL MASSES REQUEST FORM</div>
                    </div>
  

                    <div class="card-body">
        
                            <div class="row">
                                <div class="col-md-6 col-lg-4">
                       

                                    <div class="form-group">
                                        <label for="selectrequests">Select Type of Request Form</label>
                                        <select class="form-select" name="selectrequest" id="selectrequests">
                                                  <option <?php echo ($req_category === 'Thanksgiving') ? 'selected' : ''; ?>>Thanksgiving</option>
                                            <option <?php echo ($req_category === 'Soul & Petition') ? 'selected' : ''; ?>>Soul & Petition</option>
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
                            <?php
$event_name = isset($pendingItem['role']) ? $pendingItem['role'] : '';

if ($event_name === 'Online') {
    // Button for online approval (triggers modal)
    echo '<button type="button" data-toggle="modal" data-target="#myModal" class="btn btn-success">Approve</button>';
} else if ($event_name === 'Walkin') {
    // Button for walk-in approval (automatic approval)
    echo '<button type="button" class="btn btn-success approve-btn" data-id="' . $request_id . '">Approve</button>';

}
?><button type="button" class="btn btn-danger decline-btn" data-id="<?php echo htmlspecialchars($request_id); ?>" >Decline</button>
<button type="button" class="btn btn-danger" onclick="window.location.href='your_cancel_url.php'">Cancel</button>
    </div>
              
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
     document.getElementById("modalForm").addEventListener("submit", function(event) {
    // Clear previous error messages
   
    document.getElementById("amountError").innerText = "";
  

    let isValid = true;

    // Validate the Select Seminar field


    // Validate the Payable Amount field
    const amountInput = document.getElementById("eventTitle");
    if (amountInput.value.trim() === "") {
        event.preventDefault();
        document.getElementById("amountError").innerText = "Please enter the payable amount.";
        amountInput.classList.add("is-invalid");
        isValid = false;
    } else {
        amountInput.classList.remove("is-invalid");
    }

    return isValid;
});

     document.addEventListener('DOMContentLoaded', function() {
        <?php
    if (isset($_SESSION['status']) && $_SESSION['status'] == 'success') {
        echo "Swal.fire({
            icon: 'success',
            title: ' successfully! Change',
            text: 'Has Been Successful.',
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer);
                toast.addEventListener('mouseleave', Swal.resumeTimer);
            }
        });";
        unset($_SESSION['status']);
    }
    ?>
});
             document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.approve-btn').forEach(function(button) {
        button.addEventListener('click', function() {
            var request_ids = this.getAttribute('data-id');

            // Automatic approval for walk-in
            Swal.fire({
                title: 'Are you sure?',
                text: "This action will approve the request!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, approve it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    var xhr = new XMLHttpRequest();
                    xhr.open('POST', '../../Controller/updatepayment_con.php', true);
                    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                    xhr.onload = function() {
                        if (xhr.status === 200) {
                            Swal.fire(
                                'Approved!',
                                'The baptism request has been approved.',
                                'success'
                            ).then(() => {
                                window.location.href = 'StaffRequestSchedule.php';
                            });
                        } else {
                            Swal.fire(
                                'Error!',
                                'There was an issue approving the request.',
                                'error'
                            );
                        }
                    };
                    xhr.send('request_ids=' + encodeURIComponent(request_ids));
                }
            });
        });
    });

    // Decline button logic remains the same
});

  document.addEventListener('DOMContentLoaded', function() {
    document.querySelector('.decline-btn').addEventListener('click', function() {
        var request_id = this.getAttribute('data-id');
       

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, decline it!'
        }).then((result) => {
            if (result.isConfirmed) {
                var xhr = new XMLHttpRequest();
                xhr.open('POST', '../../Controller/updatepayment_con.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        Swal.fire(
                            'Declined!',
                            'The baptism request has been declined.',
                            'success'
                        ).then(() => {
                            // Redirect after approval
                            window.location.href = 'StaffRequestSchedule.php';
                        });
                    } else {
                        console.error("Error response: ", xhr.responseText); // Log error response
                        Swal.fire(
                            'Error!',
                            'There was an issue declining the request.',
                            'error'
                        );
                    }
                };

                // Send both baptismfill_id and citizen_id
                xhr.send('request_id=' + encodeURIComponent(request_id));
            }
        });
    });
});
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
<script src="../assets/js/plugin/sweetalert/sweetalert.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<!-- Popper.js (required for Bootstrap 4) -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<!-- Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <!-- Sweet Alert -->
  <script src="../assets/js/plugin/sweetalert/sweetalert.min.js"></script>
    <!--   Core JS Files   -->
    <script src="../assets/js/core/jquery-3.7.1.min.js"></script>
    <script src="../assets/js/core/popper.min.js"></script>
    <script src="../assets/js/core/bootstrap.min.js"></script>

    <!-- jQuery Scrollbar -->
    <script src="../assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>

    <!-- Chart JS -->
    <script src="../assets/js/plugin/chart.js/chart.min.js"></script>

    <!-- jQuery Sparkline -->
    <script src="../assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js"></script>

    <!-- Chart Circle -->
    <script src="../assets/js/plugin/chart-circle/circles.min.js"></script>

    <!-- Datatables -->
    <script src="../assets/js/plugin/datatables/datatables.min.js"></script>


    <!-- jQuery Vector Maps -->
    <script src="../assets/js/plugin/jsvectormap/jsvectormap.min.js"></script>
    <script src="../assets/js/plugin/jsvectormap/world.js"></script>


    <!-- Kaiadmin JS -->
    <script src="../assets/js/kaiadmin.min.js"></script>

  </body>
</html>
