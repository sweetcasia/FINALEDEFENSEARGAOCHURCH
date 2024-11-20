<?php
require_once '../../Model/staff_mod.php';
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
$staff = new Staff($conn);
$statusFilter = isset($_GET['status_filter']) ? $_GET['status_filter'] : null;
$pendingItems = $staff->getPendingCitizen();
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
    <link rel="stylesheet" href="../css/table.css" />
    <!-- CSS Just for demo purpose, don't include it in your project -->
<style></style>
  </head>
  <body>
  <?php  require_once 'sidebar.php'?>
      <div class="main-panel">
      <?php  require_once 'header.php'?>
        <div class="container">
          <div class="page-inner">
            
              <div class="col-md-12">
                <div class="card">
                  <div class="card-header">
                    <h4 class="card-title">Citizen Solo Scheduling</h4>
                    
                    <form method="GET" action="StaffSoloSched.php">
     
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                    <h6>
    <div class="dropdown">
        <button class="btn btn-primary dropdown-toggle" type="button" id="eventDropdownButton" data-bs-toggle="dropdown" aria-expanded="false">
            <?php
                // Show selected option as button label, default to "All"
                echo isset($_GET['event_filter']) ? $_GET['event_filter'] : 'All';
            ?>
        </button>
        <ul class="dropdown-menu" aria-labelledby="eventDropdownButton">
            <li><a class="dropdown-item" href="?event_filter=">All</a></li>
            <li><a class="dropdown-item" href="?event_filter=Baptism" <?php echo (isset($_GET['event_filter']) && $_GET['event_filter'] === 'Baptism') ? 'selected' : ''; ?>>Baptism</a></li>
            <li><a class="dropdown-item" href="?event_filter=Wedding" <?php echo (isset($_GET['event_filter']) && $_GET['event_filter'] === 'Wedding') ? 'selected' : ''; ?>>Wedding</a></li>
            <li><a class="dropdown-item" href="?event_filter=Funeral" <?php echo (isset($_GET['event_filter']) && $_GET['event_filter'] === 'Funeral') ? 'selected' : ''; ?>>Funeral</a></li>
            <li><a class="dropdown-item" href="?event_filter=Confirmation" <?php echo (isset($_GET['event_filter']) && $_GET['event_filter'] === 'Confirmation') ? 'selected' : ''; ?>>Confirmation</a></li>
        </ul>
    </div>
</h6>
                      <table
                        id="multi-filter-select"
                        class="display table table-striped table-hover"
                      >
                      
                        <thead>
                          <tr>
                            <th>ID NO.</th>
                            <th>Citizen Name</th>
                            <th>Event Name</th>

                      
                            <th>Schedule Type</th>
                            <th>Priest</th>
                 
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tfoot>
                          
                        <tbody>
                        <?php
                                    // Retrieve the selected event type from the GET request
                                    $eventFilter = isset($_GET['event_filter']) ? $_GET['event_filter'] : '';

                                    // Filter pending items based on the selected event type
                                    if (isset($pendingItems) && !empty($pendingItems)) {
                                        foreach ($pendingItems as $index => $item) {
                                            // Check if the event name matches the selected filter or if no filter is applied
                                            if ($eventFilter === '' || $item['event_name'] === $eventFilter) {
                                    ?>
            <tr>
                <td><?php echo htmlspecialchars($index + 1); ?></td>
                <td>
  <?php 
    $citizenName = htmlspecialchars($item['citizen_name']);
    if (strpos($citizenName, '&') !== false) {
      // If the name contains an '&', replace it with a line break
      echo str_replace('&', '<br>&', $citizenName);
    } else {
      // If no '&' is found, display the name normally
      echo $citizenName;
    }
  ?>
</td>

                <td><?php echo htmlspecialchars($item['event_name']); ?></td>
                <td><?php echo htmlspecialchars($item['roles']); ?></td>
                <td>
                  <?php
                  if ($item['priest_status'] == 'Approved') {
                      echo htmlspecialchars($item['Priest']);
                  } elseif ($item['priest_status'] == 'Pending') {
                      echo "Waiting for Approval";
                  } elseif ($item['priest_status'] == 'Declined') {
                      echo "Has been Declined";
                  }
                  ?>
              </td>


                <td>
                    <?php
                    $viewUrl = '';
                    if ($item['event_name'] === 'Baptism') {
                        $viewUrl = 'FillBaptismForm.php';
                    } elseif ($item['event_name'] === 'Wedding') {
                        $viewUrl = 'FillWeddingForm.php';
                    } elseif ($item['event_name'] === 'Funeral') {
                        $viewUrl = 'FillFuneralForm.php';
                    }elseif ($item['event_name'] === 'Confirmation') {
                      $viewUrl = 'FillConfirmationForm.php';
                  }
                    ?>
                    <a href="<?php echo htmlspecialchars($viewUrl . '?id=' . $item['id']); ?>" class="btn btn-secondary btn-xs" style="background-color: #31ce36!important; border-color:#31ce36!important;">View</a>
                  </td>
            </tr>
            <?php
                                            }
                                        }
                                    } else {
                                    ?>
        <tr>
            <td colspan="8">No pending Citizen found.</td>
        </tr>
        <?php } ?>
</tbody>

                      </table>
                    </div>
                  </div>
                </div>
              </div>

            

        
      </div>

   
    </div>
    <!--   Core JS Files   -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../assets/js/core/jquery-3.7.1.min.js"></script>
    <script src="../assets/js/core/popper.min.js"></script>
    <script src="../assets/js/core/bootstrap.min.js"></script>

    <!-- jQuery Scrollbar -->
    <script src="../assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>
    <!-- Datatables -->
    <script src="../assets/js/plugin/datatables/datatables.min.js"></script>
    <!-- Kaiadmin JS -->
    <script src="../assets/js/kaiadmin.min.js"></script>
    <!-- Kaiadmin DEMO methods, don't include it in your project! -->
    <script src="../assets/js/setting-demo2.js"></script>
    
    <script>
      
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
      $(document).ready(function () {
        $("#basic-datatables").DataTable({});

        $("#multi-filter-select").DataTable({
          pageLength: 5,
          initComplete: function () {
            this.api()
              .columns()
              .every(function () {
                var column = this;
                var select = $(
                  '<select class="form-select"><option value=""></option></select>'
                )
                  .appendTo($(column.footer()).empty())
                  .on("change", function () {
                    var val = $.fn.dataTable.util.escapeRegex($(this).val());

                    column
                      .search(val ? "^" + val + "$" : "", true, false)
                      .draw();
                  });

                column
                  .data()
                  .unique()
                  .sort()
                  .each(function (d, j) {
                    select.append(
                      '<option value="' + d + '">' + d + "</option>"
                    );
                  });
              });
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
