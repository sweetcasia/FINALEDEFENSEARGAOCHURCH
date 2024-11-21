<?php
require_once '../../Model/admin_mod.php';
require_once '../../Model/db_connection.php';
$admin = new Admin ($conn);

$donations = $admin->getDonations();
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
          urls: ["../assets/css/fonts.min.css"],
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
    <style>/* Hide sorting arrows */
th.sorting, th.sorting_asc, th.sorting_desc {
    background-image: none !important;
    cursor: default !important; /* Prevent the cursor from changing to a pointer */
}

/* Optional: Remove the sort classes that show the arrows */
th.sorting::after, th.sorting_asc::after, th.sorting_desc::after {
    content: none !important;
}
</style>
  </head>
  <body>
    
  <?php require_once 'sidebar.php'?>
      <!-- End Sidebar -->

      <div class="main-panel">
      <?php require_once 'header.php'?>
      <div class="modal fade" id="donationModal" tabindex="-1" aria-labelledby="donationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="donationModalLabel">Generate Donation Report</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="donationReportForm" action="generatedonationreport.php" method="GET">
                    <input type="hidden" name="type" id="reportTypeField" value="Donation">
                    <input type="hidden" name="days" id="dateRangeField" value="">

                    <h6>Filter by Date Range</h6>
                    <div class="btn-group btn-group-toggle mb-3" data-toggle="buttons">
                        <label class="btn btn-outline-primary" onclick="setDateRanges('7')">
                            <input type="radio" name="dateRange" id="option1" autocomplete="off"> Last 7 Days
                        </label>
                        <label class="btn btn-outline-primary" onclick="setDateRanges('15')">
                            <input type="radio" name="dateRange" id="option2" autocomplete="off"> Last 15 Days
                        </label>
                        <label class="btn btn-outline-primary" onclick="setDateRanges('30')">
                            <input type="radio" name="dateRange" id="option3" autocomplete="off"> Last Month
                        </label>
                        <label class="btn btn-outline-primary" onclick="setDateRanges('365')">
                            <input type="radio" name="dateRange" id="option4" autocomplete="off"> Last Year
                        </label>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="submitDonationReportForm()">Generate Report</button>
            </div>
        </div>
    </div>
</div>
        <div class="container">
            <div class="page-inner">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-header">
                    <h4 class="card-title">Donation Reports</h4>
                    <button class="btn btn-primary" data-toggle="modal" data-target="#donationModal">
    Generate Donation Report
</button>

                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table
                        id="multi-filter-select"
                        class="display table table-striped table-hover"
                      >
                        <thead>
                          <tr>
                            <th>Donator's Name</th>
                            <th>Donation Type</th>
                            <th>Amount</th>
                            <th>Donated On </th>
                            <th>Description</th>
                     
                          </tr>
                        </thead>
                      
                        <tbody>
            <?php foreach ($donations as $donation): ?>
                <tr>
                    <td><?php echo htmlspecialchars($donation['d_name']); ?></td>
                    <td><?php echo htmlspecialchars($donation['description']); ?></td>
                    <td><span>&#8369;</span><?php echo htmlspecialchars($donation['amount']); ?></td>
                    <td><?php echo htmlspecialchars($donation['donated_on']); ?></td>
                    <td><?php echo htmlspecialchars($donation['description']); ?></td>
                    
                </tr>
            <?php endforeach; ?>
        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div> </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Popper.js (version compatible with Bootstrap 4.5.2) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js"></script>

<!-- Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
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

  $(document).ready(function () {
    $("#basic-datatables").DataTable();

    $("#multi-filter-select").DataTable({
        pageLength: 5,
        ordering: false, // Disable sorting arrows for all columns
        initComplete: function () {
            // No need to handle column filtering here anymore since we're disabling sorting
        },
    });

    // Add Row
    $("#add-row").DataTable({
        pageLength: 5,
    });

    var action =
        '<td> <div class="form-button-action"> <button type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task"> <i class="fa fa-edit"></i> </button> <button type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Remove"> <i class="fa fa-times"></i> </button> </div> </td>';

    $("#addRowButton").click(function () {
        $("#add-row")
            .dataTable()
            .fnAddData([
                $("#addName").val(),
                $("#addPosition").val(),
                $("#addOffice").val(),
                action,
            ]);
        $("#addRowModal").modal("hide");
    });
});

    </script>
  </body>
</html>
