<?php
require_once '../../Model/login_mod.php';
require_once '../../Model/db_connection.php';
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
$getaccount = new User($conn);
$statusFilter = isset($_GET['status_filter']) ? $_GET['status_filter'] : 'Pending';
$userInfo = $getaccount->getAccount($statusFilter);
$email = $_SESSION['email'];

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
  <?php  require_once 'sidebar.php'?>
      <div class="main-panel">
      <?php  require_once 'header.php'?>
      <div class="container">
        <div class="page-inner">
          <!-- Separate form for status filter -->
          <form method="GET" action="StaffCitizenAccounts.php">
            <div class="col-md-6">
              <div class="card">
                <div class="card-header">
                  <div style="display: flex; justify-content: space-between;" class="card-title">
                    Citizen Account List
                    <div class="dropdown">
                      <!-- Button to trigger dropdown -->
                      <button class="btn btn-primary dropdown-toggle" type="button" id="statusDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <?php echo htmlspecialchars(isset($_GET['status_filter']) && $_GET['status_filter'] ? $_GET['status_filter'] : 'Pending'); ?>
                      </button>

                      <!-- Dropdown menu with status filter options -->
                      <ul class="dropdown-menu" aria-labelledby="statusDropdown">
                        <li><a class="dropdown-item" href="?status_filter=Pending">Pending</a></li>
                        <li><a class="dropdown-item" href="?status_filter=Approved">Approved</a></li>
                      </ul>
                    </div>
                  </div>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-hover" id="multi-filter-select">
                      <thead>
                        <tr>
                          <th scope="col">ID No.</th>
                          <th scope="col">Citizen Name</th>
                          <th scope="col">Phone Number</th>
                          <th scope="col">Email</th>
                          <th scope="col">Status</th>
                          <th scope="col">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        if (!empty($userInfo)) {
                          foreach ($userInfo as $index => $user) {
                            $citizendId = htmlspecialchars($user['citizend_id']);
                            $fullname = htmlspecialchars($user['fullname']);
                            $phone = htmlspecialchars($user['phone']);
                            $email = htmlspecialchars($user['email']);
                            $status = htmlspecialchars($user['r_status']);

                            $viewButton = '<a href="viewCitizen.php?id=' . $citizendId . '" class="btn btn-secondary">View</a>';
                            echo '<tr>';
                            echo '<td>' . ($index + 1) . '</td>';
                            echo '<td>' . $fullname . '</td>';
                            echo '<td>' . $phone . '</td>';
                            echo '<td>' . $email . '</td>';
                            echo '<td>' . $status . '</td>';
                            echo '<td>' . $viewButton . '</td>';
                            echo '</tr>';
                          }
                        } else {
                          echo '<tr>';
                          echo '<td colspan="6">No records found.</td>';
                          echo '</tr>';
                        }
                        ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
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

    <!-- Sweet Alert -->
    <script src="../assets/js/plugin/sweetalert/sweetalert.min.js"></script>

    <!-- Kaiadmin JS -->
    <script src="../assets/js/kaiadmin.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Kaiadmin DEMO methods, don't include it in your project! -->
    <script src="../assets/js/setting-demo.js"></script>
    <script src="../assets/js/demo.js"></script>
    <script>
                        document.addEventListener('DOMContentLoaded', function() {
    <?php
    if (isset($_SESSION['status']) && $_SESSION['status'] == 'success') {
        echo "Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: 'Your Have Been Approve The Citizen',
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
    <?php
    if (isset($_SESSION['status']) && $_SESSION['status'] == 'successs') {
        echo "Swal.fire({
            icon: 'success',
            title: 'Deleted Successful',
            text: 'Deleted Registered Citizen Account!',
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
     $(document).ready(function () {
    // Initialize the basic DataTable with sorting enabled only for the first column
    $("#basic-datatables").DataTable({
        searching: false, // Disable global search
        columnDefs: [
            { orderable: true, targets: 0 },  // Enable sorting for the first column
            { orderable: false, targets: "_all" }, // Disable sorting for all other columns
        ],
    });

    // Initialize the multi-filter table without filtering and sorting only on the first column
    $("#multi-filter-select").DataTable({
        pageLength: 5,
        searching: false, // Disable global search
        columnDefs: [
            { orderable: true, targets: 0 },  // Enable sorting for the first column
            { orderable: false, targets: "_all" }, // Disable sorting for all other columns
        ],
    });

    // Add Row functionality
    $("#add-row").DataTable({
        pageLength: 5,
        searching: false, // Disable global search
        columnDefs: [
            { orderable: true, targets: 0 },  // Enable sorting for the first column
            { orderable: false, targets: "_all" }, // Disable sorting for all other columns
        ],
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
