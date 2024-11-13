<?php
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
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <!-- Fonts and icons -->
    <script src="../assets/js/plugin/webfont/webfont.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<!-- Popper.js (for Bootstrap 4) -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<!-- Bootstrap JavaScript -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

  <!-- Sweet Alert -->
  <script src="../assets/js/plugin/sweetalert/sweetalert.min.js"></script>
    <!--   Core JS Files   -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<style>
      .error-message {
        color: red;
        font-size: 0.85em;
    }
</style>

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

    <!-- calendar JS Files -->
    <link rel="stylesheet" href="../assets/js/calendar.js" />
    <!-- CSS Files -->
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="../assets/css/plugins.min.css" />
    <link rel="stylesheet" href="../assets/css/kaiadmin.min.css" />
    <link rel="stylesheet" href="../assets/css/calendar.css" />

    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link rel="stylesheet" href="../assets/css/demo.css" />
  </head>
  <body>
      <!-- Modal -->
      <!-- jQuery -->

<!-- Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<?php  require_once 'sidebar.php'?>
      <div class="main-panel">
      <?php  require_once 'header.php'?>
        
        <div class="container">
            <div class="page-inner">
           
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Event</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="modalForm">
                <div class="modal-body">
                    <input type="hidden" name="addcalendar" value="addcalendar">

                    <div class="form-group">
                        <label for="eventName">Event Name</label>
                        <input type="text" class="form-control" id="eventName" name="cal_fullname" placeholder="Enter event name" required>
                        <span class="error-message" id="eventNameError"></span>
                    </div>

                    <div class="form-group">
                        <label for="eventCategory">Event Category</label>
                        <input type="text" class="form-control" id="eventCategory" name="cal_Category" placeholder="Enter event category" required>
                        <span class="error-message" id="eventCategoryError"></span>
                    </div>

                    <div class="form-group">
                        <label for="eventDate">Event Date</label>
                        <input type="date" class="form-control" id="eventDate" name="cal_date" placeholder="Enter event date" required>
                        <span class="error-message" id="eventDateError"></span>
                    </div>

                    <div class="form-group">
                        <label for="eventDescription">Description</label>
                        <input type="text" class="form-control" id="eventDescription" name="cal_description" placeholder="Enter description" required>
                        <span class="error-message" id="eventDescriptionError"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="submitEvent">Add Event</button>
                </div>
            </form>
        </div>
    </div>
</div>
     
<button style="position: absolute; top: 85px; right: 35px;" type="button" class="btn btn-primary " data-toggle="modal" data-target="#myModal">
  Add Event
</button>

    <!-- About calendar -->
    <?php require_once 'Calendar.php'?>
    </div>
    
</div>      </div>
        </div>
      </div>
    </div>   
    </div>
  <!-- Sweet Alert -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="../assets/js/core/jquery-3.7.1.min.js"></script>
    <script src="../assets/js/core/popper.min.js"></script>
    <script src="../assets/js/core/bootstrap.min.js"></script>
    <script src="../assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>
    <script src="../assets/js/plugin/datatables/datatables.min.js"></script>
    <script src="../assets/js/kaiadmin.min.js"></script>
    <script src="../assets/js/setting-demo2.js"></script>


    <script>
      document.addEventListener('DOMContentLoaded', function() {
    <?php
    if (isset($_SESSION['status']) && $_SESSION['status'] == 'success') {
        echo "Swal.fire({
            icon: 'success',
            title: 'Form submitted successfully!',
            text: 'Please Check your Information.',
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            customClass: {
                popup: 'wider-toast',
                icon: 'dark-green-check-icon'
            },
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer);
                toast.addEventListener('mouseleave', Swal.resumeTimer);
            }
        });";
        unset($_SESSION['status']);
    }
    ?>
});
document.getElementById('submitEvent').addEventListener('click', function(event) {
    let valid = true;

    // Clear previous error messages
    document.querySelectorAll('.error-message').forEach((el) => el.innerText = '');

    // Form validation
    const eventName = document.getElementById('eventName').value.trim();
    const eventCategory = document.getElementById('eventCategory').value.trim();
    const eventDate = document.getElementById('eventDate').value;
    const eventDescription = document.getElementById('eventDescription').value.trim();

    // Event Name validation
    if (eventName === '') {
        document.getElementById('eventNameError').innerText = 'Event Name is required.';
        valid = false;
    }

    // Event Category validation
    if (eventCategory === '') {
        document.getElementById('eventCategoryError').innerText = 'Event Category is required.';
        valid = false;
    }

    // Event Date validation
    if (eventDate === '') {
        document.getElementById('eventDateError').innerText = 'Event Date is required.';
        valid = false;
    }

    // Event Description validation
    if (eventDescription === '') {
        document.getElementById('eventDescriptionError').innerText = 'Description is required.';
        valid = false;
    }

    // If validation fails, prevent form submission
    if (!valid) {
        event.preventDefault();  // Prevent form submission
        return;
    }

    // If validation passes, proceed with fetch request
    const form = document.getElementById('modalForm');
    const formData = new FormData(form);

    fetch('../../Controller/addannounce_con.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        console.log("Server response:", data); // Debugging: log server response
        if (data.includes('successfully')) {
            // Success message using a simple alert
      
            form.reset(); // Reset the form fields
            $('#myModal').modal('hide'); // Hide the modal after toast
            location.reload(); // Refresh the page to see the new event
        } else {
            // Error message using a simple alert
            alert('Error: ' + data);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        // Error message using a simple alert
        alert('An error occurred. Please try again.');
    });
});


</script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  </body>
</html>
