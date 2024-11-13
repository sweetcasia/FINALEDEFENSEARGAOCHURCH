<?php
require_once '../../Model/login_mod.php';
require_once '../../Model/db_connection.php';
$priest = new User ($conn);
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
$statusFilter = isset($_GET['status_filter']) ? $_GET['status_filter'] : '';
$getpriest = $priest->getAdminAccount($statusFilter);

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
    <link rel="stylesheet" href="assets/css/demo.css" />
  </head>
  <body>
  <?php require_once 'sidebar.php'?>
      <!-- End Sidebar -->

      <div class="main-panel">
      <?php require_once 'header.php'?>
      <div class="container">
    <div class="page-inner">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Admin Records</h4>
                </div>
                <!-- Dropdown Form to filter between Default and Archive -->
               
                
                <div class="card-body">
                <form method="GET" action="PriestRecords.php">
                <div class="dropdown">
        <button class="btn btn-primary dropdown-toggle" type="button" id="statusDropdown" data-bs-toggle="dropdown" aria-expanded="false">
            <?php 
                // Display the selected status filter or "Default" if none is selected
                echo isset($_GET['status_filter']) && $_GET['status_filter'] ? htmlspecialchars($_GET['status_filter']) : 'Default';
            ?>
        </button>

        <!-- Dropdown menu with status filter options -->
        <ul class="dropdown-menu" aria-labelledby="statusDropdown">
            <li><a class="dropdown-item" href="?status_filter=">Default</a></li>
            <li><a class="dropdown-item" href="?status_filter=Unactive">Archive</a></li>
            <!-- Add more options if needed -->
        </ul>
    </div>
                </form>
                    <div class="table-responsive">
                        <table
                            id="multi-filter-select"
                            class="display table table-striped table-hover"
                        >
                            <thead>
                                <tr>
                                    <th>Citizen's Name</th>
                                    <th>Phone Number</th>
                                    <th>Address</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
// Check if the status filter is set to "Unactive" (archived) or not
$statusFilter = isset($_GET['status_filter']) ? $_GET['status_filter'] : '';

// Filter logic for displaying priests
foreach ($getpriest as $getpriests):
    // If the filter is 'Unactive' show the "Unarchive" button, otherwise show "Archive"
    if (!isset($_GET['status_filter']) || ($_GET['status_filter'] === 'Unactive' && $getpriests['r_status'] === 'Unactive') || ($_GET['status_filter'] === '' && $getpriests['r_status'] !== 'Unactive')):
?>
    <tr data-id="priest-<?php echo $getpriests['citizend_id']; ?>">
        <td><?php echo htmlspecialchars($getpriests['fullname']); ?></td>
        <td><?php echo htmlspecialchars($getpriests['phone']); ?></td>
        <td><?php echo htmlspecialchars($getpriests['address']); ?></td>
        <td>
            <button class="btn btn-label-info btn-m status-btn" data-id="<?php echo $getpriests['citizend_id']; ?>">
                <i class="fa fa-<?php echo $statusFilter === 'Unactive' ? 'check' : 'archive'; ?>"></i>
                <span class="btn-label">
                    <?php echo $statusFilter === 'Unactive' ? 'Unarchive' : 'Archive'; ?>
                </span>
            </button>
        </td>
    </tr>
<?php
    endif;
endforeach;
?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>


    <!-- Kaiadmin JS -->
    <script src="../assets/js/kaiadmin.min.js"></script>


    <!-- Kaiadmin DEMO methods, don't include it in your project! -->
    <script src="../assets/js/setting-demo.js"></script>
    <script src="../assets/js/demo.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

   <script>
    $(document).ready(function() {
    $('.status-btn').on('click', function() {
        var citizenId = $(this).data('id');
        var action = $(this).find('.btn-label').text().trim(); // Get the button label (Archive/Unarchive)

        Swal.fire({
            title: 'Are you sure?',
            text: "You are about to " + action.toLowerCase() + " this citizen.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, ' + action.toLowerCase() + ' it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '../../Controller/archive_citizen.php',
                    type: 'POST',
                    data: { citizen_id: citizenId, action: action.toLowerCase() }, // Pass action as 'archive' or 'unarchive'
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            Swal.fire(
                                action + 'd!',
                                response.message,
                                'success'
                            ).then(() => {
                                location.reload(); // Reload the page to reflect changes
                            });
                        } else {
                            Swal.fire(
                                'Error!',
                                response.message,
                                'error'
                            );
                        }
                    },
                    error: function() {
                        Swal.fire(
                            'Error!',
                            'Failed to process request.',
                            'error'
                        );
                    }
                });
            }
        });
    });
});

$(document).ready(function() {
    $('.archive-btn').on('click', function() {
        var citizenId = $(this).data('id');

        Swal.fire({
            title: 'Are you sure?',
            text: "You are about to archive this citizen.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, archive it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '../../Controller/archive_citizen.php',
                    type: 'POST',
                    data: { citizen_id: citizenId },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            Swal.fire(
                                'Archived!',
                                response.message,
                                'success'
                            ).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire(
                                'Error!',
                                response.message,
                                'error'
                            );
                        }
                    },
                    error: function() {
                        Swal.fire(
                            'Error!',
                            'Failed to process request.',
                            'error'
                        );
                    }
                });
            }
        });
    });
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
