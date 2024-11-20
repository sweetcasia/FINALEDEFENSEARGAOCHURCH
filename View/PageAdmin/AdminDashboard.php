<?php
require_once '../../Model/admin_mod.php';
require_once '../../Model/db_connection.php';
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
$modelInstance = new Admin ($conn);
$totalBaptisms = $modelInstance->getTotalBaptisms(); 
$totalConfirmation = $modelInstance->getTotalConfirmationsDone(); 
$totalDefunctorum = $modelInstance->getTotalDefunctorumDone(); 
$totalWedding = $modelInstance->getTotalWeddingRecords(); 
$totalDonationData = $modelInstance->getDonationsTotal();
$totalDonationAmount = $totalDonationData['total_amount'] ?? 0; 
$totalAcknowledgementAmount = $modelInstance->getTotalPayableAmount();
 
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Fonts and icons -->
    <script src="../assets/js/plugin/webfont/webfont.min.js"></script>
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
  </head>
  <body>
     <!-- Modal -->
     <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Donation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="modalForm">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="donatorName">Donator's Name</label>
                        <input type="text" class="form-control" id="donatorName" placeholder="Enter name" required>
                    </div>
                    <div class="form-group">
                        <label for="amount">Amount</label>
                        <input type="tel" class="form-control" id="amount" placeholder="Enter amount" required>
                    </div>
                   
                    <div class="form-group">
                        <label for="description">Description</label>
                        <input type="text" class="form-control" id="description" placeholder="Enter description" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="submitDonation">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Donation Modal -->

<!-- Modal for General Report -->
<div class="modal fade" id="reportModal" tabindex="-1" aria-labelledby="reportModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reportModalLabel">Generate Report</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="reportForm" action="generatereport.php" method="GET">
                    <input type="hidden" name="type" id="reportTypeField" value="All">
                    <input type="hidden" name="days" id="dateRangeField" value="">

                    <h6>Filter by Type</h6>
                    <div class="dropdown mb-3">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="filterDropdownButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Select Report Type
                        </button>
                        <div class="dropdown-menu" aria-labelledby="filterDropdownButton">
                            <a class="dropdown-item" href="#" onclick="setReportType('All')">All</a>
                            <a class="dropdown-item" href="#" onclick="setReportType('Baptism')">Baptism</a>
                            <a class="dropdown-item" href="#" onclick="setReportType('Funeral')">Funeral</a>
                            <a class="dropdown-item" href="#" onclick="setReportType('Confirmation')">Confirmation</a>
                            <a class="dropdown-item" href="#" onclick="setReportType('Wedding')">Wedding</a>
                            <a class="dropdown-item" href="#" onclick="setReportType('RequestForm')">Request Form</a>
                        </div>
                    </div>

                    <h6>Filter by Date Range</h6>
                    <div class="btn-group btn-group-toggle mb-3" data-toggle="buttons">
                        <label class="btn btn-outline-primary" onclick="setDateRange('7')">
                            <input type="radio" name="dateRange" id="option1" autocomplete="off"> Last 7 Days
                        </label>
                        <label class="btn btn-outline-primary" onclick="setDateRange('15')">
                            <input type="radio" name="dateRange" id="option2" autocomplete="off"> Last 15 Days
                        </label>
                        <label class="btn btn-outline-primary" onclick="setDateRange('30')">
                            <input type="radio" name="dateRange" id="option3" autocomplete="off"> Last Month
                        </label>
                        <label class="btn btn-outline-primary" onclick="setDateRange('365')">
                            <input type="radio" name="dateRange" id="option4" autocomplete="off"> Last Year
                        </label>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="submitReportForm()">Generate Report</button>
            </div>
        </div>
    </div>
</div>



<?php require_once 'sidebar.php'?>

      <div class="main-panel">
      <?php require_once 'header.php'?>

        <div class="container">
          <div class="page-inner">
            <div
              class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4"
            >
              <div>
                
                <h3 class="fw-bold mb-3">Admin Dashboard</h3>
              <a href="#"  data-toggle="modal" data-target="#myModal" class="btn btn-primary ">Add Donator</a>
              
    <button class="btn btn-primary  dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-expanded="false">

            Add Account
        </button>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <li><a class="dropdown-item" href="Priest.php">Add Priest</a></li>
            <li><a class="dropdown-item" href="Staff.php">Add Staff</a></li>
            <li><a class="dropdown-item" href="Admin.php">Add Admin</a></li>
        </ul>
   


<!-- Button to trigger the second modal (Report Acknowledgement) -->
<button class="btn btn-primary" data-toggle="modal" data-target="#reportModal">
    Generate Report Acknowledgement
</button>
              </div>
   
            </div>
            <div class="row">
              <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                  <div class="card-body">
                    <div class="row align-items-center">
                      <div class="col-icon">
                        <div
                          class="icon-big text-center icon-primary bubble-shadow-small"
                        >
                          <i class="fas fa-calendar-check"></i>
                        </div>
                      </div>
                      <div class="col col-stats ms-3 ms-sm-0">
                        <div class="numbers">
                          <p class="card-category">Total Baptism Completed</p>
                          <h4 class="card-title"><?php echo $totalBaptisms; ?></h4>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                  <div class="card-body">
                    <div class="row align-items-center">
                      <div class="col-icon">
                        <div
                          class="icon-big text-center icon-primary bubble-shadow-small"
                        >
                          <i class="fas fa-calendar-check"></i>
                        </div>
                      </div>
                      <div class="col col-stats ms-3 ms-sm-0">
                        <div class="numbers">
                        
                          <p class="card-category">Total Confirmation Completed</p>
                          <h4 class="card-title"><?php echo $totalConfirmation; ?></h4>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                  <div class="card-body">
                    <div class="row align-items-center">
                      <div class="col-icon">
                        <div
                          class="icon-big text-center icon-primary bubble-shadow-small"
                        >
                          <i class="fas fa-calendar-check"></i>
                        </div>
                      </div>
                      <div class="col col-stats ms-3 ms-sm-0">
                        <div class="numbers">
                          <p class="card-category">Total Defuctom Completed</p>
                          <h4 class="card-title"><?php echo $totalDefunctorum; ?></h4>
                    </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                  <div class="card-body">
                    <div class="row align-items-center">
                      <div class="col-icon">
                        <div
                          class="icon-big text-center icon-primary bubble-shadow-small"
                        >
                          <i class="fas fa-calendar-check"></i>
                        </div>
                      </div>
                      
                      <div class="col col-stats ms-3 ms-sm-0">
                        <div class="numbers">
                          <p class="card-category">Total Marriage Completed</p>
                          <h4 class="card-title"><?php echo $totalWedding; ?></h4>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                  <div class="card-body">
                    <div class="row align-items-center">
                      <div class="col-icon">
                        <div
                          class="icon-big text-center icon-info bubble-shadow-small"
                        >
                          <i class="fas fa-coins"></i>
                        </div>
                      </div>
                     
                      <div class="col col-stats ms-3 ms-sm-0">
                        <div class="numbers">
                          <p class="card-category">Annual Donation Amount</p>
                          <h4 class="card-title"><span>&#8369;</span><?php echo number_format($totalDonationAmount, 2); ?></h4>
                    </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                  <div class="card-body">
                    <div class="row align-items-center">
                      <div class="col-icon">
                        <div
                          class="icon-big text-center icon-success bubble-shadow-small"
                        >
                          <i class="fas fa-coins"></i>
                        </div>
                      </div>
                      <div class="col col-stats ms-3 ms-sm-0">
                        <div class="numbers">
                        <p class="card-category">Acknowledgement Amount</p>
<h4 class="card-title"><span>&#8369;</span><?php echo number_format($totalAcknowledgementAmount, 2); ?></h4>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          
        </div>
      </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Popper.js (version compatible with Bootstrap 4.5.2) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js"></script>

<!-- Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<!-- SweetAlert2 -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
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

    <!-- Sweet Alert -->
    <script src="assets/js/plugin/sweetalert/sweetalert.min.js"></script>

    <!-- Kaiadmin JS -->
    <script src="../assets/js/kaiadmin.min.js"></script>

    <!-- Kaiadmin DEMO methods, don't include it in your project! -->
    <script src="../assets/js/setting-demo.js"></script>
    <script src="../assets/js/demo.js"></script>
    <script>
  // For Donation Report Modal
function setDateRanges(days) {
    document.getElementById('dateRangeField').value = days; // Set the value of the hidden input
}

function submitDonationReportForm() {
    const dateRange = document.getElementById('dateRangeField').value;
    
    // Check if a date range is selected
    if (!dateRange) {
        alert('Please select a date range.');
        return; // Prevent form submission if no range is selected
    }

    // Submit the form
    document.getElementById('donationReportForm').submit();
}

// For General Report Modal
let selectedReportType = 'All'; // Default report type
let selectedDateRange = ''; // Default date range

function setReportType(type) {
    selectedReportType = type;
    document.getElementById('reportTypeField').value = type;
    document.getElementById('filterDropdownButton').innerText = type; // Update button text
}

function setDateRange(days) {
    selectedDateRange = days;
    document.getElementById('dateRangeField').value = days; // Set the hidden input value
}

function submitReportForm() {
    // Validate only the date range
    if (selectedDateRange === '') {
        // Use SweetAlert to show validation message
        Swal.fire({
            icon: 'warning',
            title: 'Incomplete Selection',
            text: 'Please select a date range before generating the report.',
            confirmButtonText: 'OK'
        });
    } else {
        // If validation passes, submit the form
        document.getElementById('reportForm').submit();
    }
}


    </script>
    <script>
$(document).ready(function() {
    $('#submitDonation').on('click', function() {
        // Get form data
        var donatorName = $('#donatorName').val();
        var amount = $('#amount').val();
   
        var description = $('#description').val();

        // Validate form inputs
        if (donatorName === '' || amount === '' || description === '') {
            Swal.fire("Validation Error", "All fields are required!", "error");
            return; // Exit the function if validation fails
        } else if (isNaN(amount) || parseFloat(amount) <= 0) {
            Swal.fire("Invalid Amount", "Please enter a valid donation amount!", "error");
            return; // Exit the function if validation fails
        }

        // Perform AJAX request
        $.ajax({
            url: '../../Controller/Donation_con.php', // Your PHP file
            type: 'POST',
            data: {
                action: 'add_donation',
                d_name: donatorName,
                amount: amount,
            
                description: description
            },
            success: function(response) {
                console.log(response); // Log the response
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'Donation added successfully!'
                }).then(() => {
                    $('#myModal').modal('hide'); // Close the modal
                    location.reload(); // Refresh the page or update the donation list
                });
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error: ", error); // Log the error
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error adding donation: ' + error
                });
            }
        });
    });
});
        document.addEventListener('DOMContentLoaded', function() {
    <?php
    if (isset($_SESSION['status']) && $_SESSION['status'] == 'success') {
        echo "Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: 'Action completed successfully!',
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
