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
$pendingItems = $staff->getRequestSchedule();

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
                    <h4 class="card-title">Citizen Request Form Scheduling</h4>
                  </div>
                  <form method="GET" action="StaffRequestSchedule.php">
             
             <h6><div class="dropdown">
        <!-- Button to trigger dropdown -->
        <button style="margin-left: 25px;margin-top: 15px;" class="btn btn-primary dropdown-toggle" type="button" id="eventDropdown" data-bs-toggle="dropdown" aria-expanded="false">
            <?php 
                // Display the current selected filter or "All" if none is selected
                echo isset($_GET['event_filter']) && $_GET['event_filter'] ? htmlspecialchars($_GET['event_filter']) : 'All';
            ?>
        </button>

        <!-- Dropdown menu containing the select options -->
        <ul class="dropdown-menu" aria-labelledby="eventDropdown">
            <li><a class="dropdown-item" href="?event_filter=">All</a></li>
            <li><a class="dropdown-item" href="?event_filter=Fiesta Mass">Fiesta Mass</a></li>
            <li><a class="dropdown-item" href="?event_filter=Novena Mass">Novena Mass</a></li>
            <li><a class="dropdown-item" href="?event_filter=Wake Mass">Wake Mass</a></li>
            <li><a class="dropdown-item" href="?event_filter=Monthly Mass">Monthly Mass</a></li>
            <li><a class="dropdown-item" href="?event_filter=1st Friday Mass">1st Friday Mass</a></li>
            <li><a class="dropdown-item" href="?event_filter=Cemetery Chapel Mass">Cemetery Chapel Mass</a></li>
            <li><a class="dropdown-item" href="?event_filter=Baccalaureate Mass">Baccalaureate Mass</a></li>
            <li><a class="dropdown-item" href="?event_filter=Anointing Of The Sick">Anointing of the Sick</a></li>
            <li><a class="dropdown-item" href="?event_filter=Blessing">Blessing</a></li>
            <li><a class="dropdown-item" href="?event_filter=Thanksgiving">Thanksgiving</a></li>
            <li><a class="dropdown-item" href="?event_filter=Soul & Petition">Soul & Petition</a></li>
        </ul>
    </div>
                 </h6>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table
                        id="multi-filter-select"
                        class="display table table-striped table-hover"
                      >
                        <thead>
                          <tr>
                          <th>ID NO.</th>
            <th>Request Category</th>
            <th>Request Person</th>

   
            <th>Priest Name</th>
            <th>Status</th>
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
                                            if ($eventFilter === '' || $item['req_category'] === $eventFilter) {
                                    ?>
            <tr>
            <td><?php echo htmlspecialchars($index + 1); ?></td>
                    <td><?php echo htmlspecialchars($item['req_category']); ?></td>
                    <td><?php echo htmlspecialchars($item['req_person']); ?></td>

                    <td>
    <?php
    if ($item['pr_status'] == 'Pending') {
        echo 'Waiting for approval';
    } else {
        echo htmlspecialchars($item['priest_name']);
    }
    ?>
</td>

                     <td><?php echo htmlspecialchars($item['req_status']); ?></td>
                     <td>
    <?php
    $viewUrl = '';

    // Check if req_id exists
    if ($item['req_id']) {
        // Check if req_category is Thanksgiving or Soul & Petition
        if ($item['req_category'] == 'Thanksgiving' || $item['req_category'] == 'Soul & Petition') {
            $viewUrl = 'FillInsideSpecialRequestForm.php';  // URL for special categories
        } else {
            $viewUrl = 'FillInsideRequestForm.php';  // Default URL
        }
    }
    ?>

    <a href="<?php echo htmlspecialchars($viewUrl . '?req_id=' . $item['req_id']); ?>" class="btn btn-primary btn-xs" style="background-color: #31ce36!important; border-color:#31ce36!important;">View</a>
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
            title: 'Form submitted successfully!',
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
