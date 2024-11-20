<?php
require_once '../../Model/priest_mod.php';
require_once '../../Model/db_connection.php';
session_start();

// Check if user is logged in
if (!isset($_SESSION['email']) || !isset($_SESSION['user_type'])) {
    header("Location: ../../index.php");
    exit();
}

// Redirect based on user type
switch ($_SESSION['user_type']) {
    case 'Priest':
        // Allow access
        break;
    case 'Admin':
        header("Location: ../PageAdmin/AdminDashboard.php");
        exit();
    case 'Staff':
        header("Location: ../PageStaff/StaffDashboard.php");
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
$appointments = new Priest($conn);

$priestId = $regId; 
$appointmentSchedule = $appointments->getPriestAppointmentSchedule($priestId);
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
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
    />
    <!-- Fonts and icons -->
    <script src="../assets/js/plugin/webfont/webfont.min.js"></script>
    <!-- jQuery (required for Bootstrap's JavaScript plugins) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

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

    <!-- CSS Files -->
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="../assets/css/plugins.min.css" />
    <link rel="stylesheet" href="../assets/css/kaiadmin.min.css" />

    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link rel="stylesheet" href="../assets/css/demo.css" />
    <style>


.date-picker {
    text-align: center;
    margin-bottom: 20px;
}

.date-picker label, .date-picker input, .date-picker button {
    margin: 5px;
    padding:5px;
    border: none;   
}


  /* Style the date picker input on focus */
  .date-picker:focus {
            border-color: #007bff; /* Change border color on focus */
            outline: none;
            box-shadow: 0 0 4px rgba(0, 123, 255, 0.5); /* Optional shadow on focus */
        }

        /* Style the label associated with the date picker */
        .date-picker-label {
            color: #007bff; /* Change label color */
            font-weight: bold;
            margin-bottom: 5px;
            display: block;
        }
     
        .date-cell {
    background-color: #f8f9fa; /* Optional background color */
    font-weight: bold; /* Optional font weight */
    vertical-align: top; /* Align content to the top */
    padding-top: 10px; /* Adjust padding as needed */
    text-align: center; /* Optional: center text horizontally */
}
        
.date-cell-wrapper {
    display: flex;
    align-items: flex-start; /* Align content to the top */
}

.date-cell {
    background-color: #f8f9fa; /* Optional background color */
    font-weight: bold; /* Optional font weight */
    width: 30%; /* Ensure it spans the full width */
    padding: 10px; /* Adjust padding as needed */
}

.date-cell-wrapper span {
    display: block; /* Ensure date is displayed as block-level */
}

    </style>
  </head>
  <body>
  <div class="modal fade" id="declineModal" tabindex="-1" role="dialog" aria-labelledby="declineModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="declineModalLabel">Decline Appointment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="declineForm" method="POST" action="../../Controller/priest_con.php">
                <div class="modal-body">
                    <div id="confirmationStep">
                        <p>Are you sure you want to decline this appointment?</p>
                    </div>
                    <div id="reasonStep" class="d-none">
                        <div class="form-group">
                            <label for="declineReason">Reason for declining</label>
                            <input type="text" class="form-control" id="declineReason" name="declineReason" placeholder="Enter reason">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" id="confirmDeclineBtn" class="btn btn-danger">Yes, Decline</button>
                    <button type="submit" id="submitReasonBtn" class="btn btn-primary d-none">Submit Reason</button>
                </div>
            </form>
        </div>
    </div>
</div>


    

<?php  require_once 'sidebar.php'?>
      <div class="main-panel">
      <?php  require_once 'header.php'?>
       

        <div class="container">
            <div class="page-inner">
               
    <!-- Date Picker -->

                <div class="col-md-6">
                  <div class="card">
                    <div class="card-header">
                      <div class="card-title">Upcoming Schedule </div>
                    </div>
                    <div class="card-body">
                    <table class="table" style="border-collapse: collapse;" id="schedule-table">
    <thead>
        <tr>
            <th>Date</th>
            <th>Time</th>
  
            <th>Event</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($appointmentSchedule): ?>
            <?php
            $dateCounts = []; // Array to store counts for each date
            
            // Step 1: Calculate the rowspan for each date
            foreach ($appointmentSchedule as $appointment) {
                $date = date('Y-m-d', strtotime($appointment['schedule_date']));
                if (!isset($dateCounts[$date])) {
                    $dateCounts[$date] = 0;
                }
                $dateCounts[$date]++;
            }
            
            $previousDate = ''; // Variable to keep track of the previous date
            
            // Step 2: Render table rows with correct rowspan
            foreach ($appointmentSchedule as $appointment):
                $currentDate = date('Y-m-d', strtotime($appointment['schedule_date']));
                $currentTime = date('h:i A', strtotime($appointment['schedule_time']));
          
                $eventName = htmlspecialchars($appointment['Event_Name']);
            ?>
                <tr>
                    <?php if ($currentDate !== $previousDate): ?>
                        <!-- Display date cell with correct rowspan only once -->
                        <td rowspan="<?= $dateCounts[$currentDate] ?>" style="vertical-align: top!important;" class="date-cell">
                            <?= $currentDate ?>
                        </td>
                    <?php endif; ?>
                    <td><?= $currentTime ?></td>
               
                    <td><?= $eventName ?></td>
                    <td>
    <button class="btn btn-primary btn-xs approve-btn" 
        data-id="<?= htmlspecialchars($appointment['id'], ENT_QUOTES, 'UTF-8') ?>" 
        data-type="<?= htmlspecialchars($appointment['type'], ENT_QUOTES, 'UTF-8') ?>" 
        style="background-color: #31ce36!important; border-color:#31ce36!important;">
        Approve
    </button>
    <button class="btn btn-danger btn-xs decline-btn"  
        data-id="<?= htmlspecialchars($appointment['id'], ENT_QUOTES, 'UTF-8') ?>" 
        data-type="<?= htmlspecialchars($appointment['type'], ENT_QUOTES, 'UTF-8') ?>">
        Decline
</button>

</td>

                </tr>
                <?php $previousDate = $currentDate; // Update previous date to current ?>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="5" class="text-center">No appointments available.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

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
   
        <!-- jQuery first -->
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
 
    <!-- Kaiadmin DEMO methods, don't include it in your project! -->
    <script src="../assets/js/setting-demo.js"></script>
    <script src="../assets/js/demo.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Show form submission success message using SweetAlert
    <?php if (isset($_SESSION['status']) && $_SESSION['status'] == 'success') { ?>
        Swal.fire({
            icon: 'success',
            title: 'Form submitted successfully!',
            text: 'Waiting for Approval.',
        });
        <?php unset($_SESSION['status']); ?>
    <?php } ?>

    // Handle the approval button click
    document.querySelectorAll('.approve-btn').forEach(function(button) {
        button.addEventListener('click', function() {
            var appointmentId = this.getAttribute('data-id');
            var appointmentType = this.getAttribute('data-type'); // Get the type

            // SweetAlert confirmation dialog for approval
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to change this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, approve it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Send AJAX request to approve appointment
                    var xhr = new XMLHttpRequest();
                    xhr.open('POST', '../../Controller/priest_con.php', true);
                    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                    xhr.onload = function() {
                        if (xhr.status === 200) {
                            if (xhr.responseText === 'success') {
                                Swal.fire(
                                    'Approved!',
                                    'The appointment has been approved.',
                                    'success'
                                ).then(() => {
                                    location.reload(); // Optionally reload the page
                                });
                            } else {
                                Swal.fire(
                                    'Error!',
                                    'There was an issue approving the appointment.',
                                    'error'
                                );
                            }
                        } else {
                            Swal.fire(
                                'Error!',
                                'There was an issue processing the request.',
                                'error'
                            );
                        }
                    };
                    xhr.send('appointmentId=' + encodeURIComponent(appointmentId) + '&appointmentType=' + encodeURIComponent(appointmentType) + '&action=approve');
                }
            });
        });
    });
    document.querySelectorAll('.decline-btn').forEach(function(button) {
    button.addEventListener('click', function() {
        var appointmentId = this.getAttribute('data-id');
        var appointmentType = this.getAttribute('data-type'); // Get the type

        // Reset modal steps
        document.getElementById('confirmationStep').classList.remove('d-none');
        document.getElementById('reasonStep').classList.add('d-none');
        document.getElementById('confirmDeclineBtn').classList.remove('d-none');
        document.getElementById('submitReasonBtn').classList.add('d-none');

        // Show the modal
        $('#declineModal').modal('show');

        // Handle confirm decline button click
        document.getElementById('confirmDeclineBtn').onclick = function() {
            // Hide confirmation, show reason input
            document.getElementById('confirmationStep').classList.add('d-none');
            document.getElementById('reasonStep').classList.remove('d-none');
            document.getElementById('confirmDeclineBtn').classList.add('d-none');
            document.getElementById('submitReasonBtn').classList.remove('d-none');
        };

        // Handle form submission
        document.getElementById('declineForm').onsubmit = function(e) {
            e.preventDefault(); // Prevent the form from submitting normally

            var declineReason = document.getElementById('declineReason').value;

            // Send AJAX request to decline appointment with reason
            var xhr = new XMLHttpRequest();
            xhr.open('POST', '../../Controller/priest_con.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (xhr.status === 200) {
                    if (xhr.responseText === 'success') {
                        Swal.fire(
                            'Declined!',
                            'The appointment has been declined.',
                            'success'
                        ).then(() => {
                            location.reload(); // Optionally reload the page
                        });
                    } else {
                        Swal.fire(
                            'Error!',
                            'There was an issue declining the appointment.',
                            'error'
                        );
                    }
                } else {
                    Swal.fire(
                        'Error!',
                        'There was an issue processing the request.',
                        'error'
                    );
                }
            };

            // Send data: appointmentId, appointmentType, and reason
            xhr.send('appointmentId=' + encodeURIComponent(appointmentId) + 
                     '&appointmentType=' + encodeURIComponent(appointmentType) +
                     '&declineReason=' + encodeURIComponent(declineReason) + 
                     '&action=decline');
        };
    });
});

});



      document.getElementById('schedule-date').addEventListener('change', function() {
    const selectedDate = this.value;
    // AJAX call to fetch schedule data for the selected date
    fetch(`fetch_schedule.php?date=${selectedDate}`)
        .then(response => response.json())
        .then(data => {
            // Process and update the table with the fetched data
            updateScheduleTable(data);
        })
        .catch(error => console.error('Error fetching schedule:', error));
});

function updateScheduleTable(data) {
    const tbody = document.querySelector('#schedule-table tbody');
    tbody.innerHTML = ''; // Clear existing rows
    if (data.length) {
        data.forEach(appointment => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${appointment.schedule_date}</td>
                <td>${appointment.schedule_time}</td>
                <td>${appointment.citizen_name}</td>
                <td>${appointment.Event_Name}</td>
                <td>
                    <button class="btn btn-primary btn-xs" style="background-color: #31ce36!important; border-color:#31ce36!important;">Approve</button>
                    <button class="btn btn-primary btn-xs">Decline</button>
                </td>
            `;
            tbody.appendChild(row);
        });
    } else {
        tbody.innerHTML = `<tr><td colspan="5" class="text-center">No appointments available for the selected date.</td></tr>`;
    }
}

      $("#lineChart").sparkline([102, 109, 120, 99, 110, 105, 115], {
        type: "line",
        height: "70",
        width: "100%",
        lineWidth: "    2",
        lineColor: "#177dff",
        fillColor: "rgba(23, 125, 255, 0.14)",
      });

      $("#lineChart2").sparkline([99, 125, 122, 105, 110, 124, 115], {
        type: "line",
        height: "70",
        width: "100%",
        lineWidth: "2",
        lineColor: "#f3545d",
        fillColor: "rgba(243, 84, 93, .14)",
      });

      $("#lineChart3").sparkline([105, 103, 123, 100, 95, 105, 115], {
        type: "line",
        height: "70",
        width: "100%",
        lineWidth: "2",
        lineColor: "#ffa534",
        fillColor: "rgba(255, 165, 52, .14)",
      });
    </script>
     <script>
      //== Class definition
      var SweetAlert2Demo = (function () {
        //== Demos
        var initDemos = function () {
          //== Sweetalert Demo 1
        

        


          $("#alert_demo_6").click(function (e) {
            swal("Event added successfully!", {
              icon: "success",  
              buttons: false,
              timer: 1000,
            });
          });

       

        };

        return {
          //== Init
          init: function () {
            initDemos();
          },
        };
      })();

      //== Class Initialization
      jQuery(document).ready(function () {
        SweetAlert2Demo.init();
      });
    </script>
  </body>
</html>