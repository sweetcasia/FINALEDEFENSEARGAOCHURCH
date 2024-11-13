<?php
require_once __DIR__ . '/../../Model/db_connection.php';
require_once __DIR__ . '/../../Model/citizen_mod.php';
session_start();

// Check if user is logged in
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
$citizenController = new Citizen($conn);
$pendingAppointments = $citizenController->getPendingCitizenss(null, $regId);


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
      <?php  require_once 'profheader.php'?>

        <div class="container">
          <div class="page-inner">
            
              <div class="col-md-12">
                <div class="card">
                  <div class="card-header">
                    <h4 class="card-title">My Event Scheduling</h4>
                    
                    <form method="GET" action="StaffSoloSched.php">
     
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                   
<table
                        id="multi-filter-select"
                        class="display table table-striped table-hover"
                      >
                        <thead>
                          <tr>
                            <th>ID NO.</th>
                            <th>Name of Applicant</th>
                            <th>Event Name</th>
                            <th>Appointment Date</th>
                            <th>Appointment Time</th>
                            <th>Schedule Type</th>
                            <th>Status</th>
                  
                          </tr>
                        </thead>
                        <tfoot>
                          
                        <tbody>
    <?php if (!empty($pendingAppointments)) {
        foreach ($pendingAppointments as $index => $appointment) {
            // Convert the schedule start and end times to 12-hour format
            $scheduleStart = date('g:i A', strtotime($appointment['schedule_start_time']));
            $scheduleEnd = date('g:i A', strtotime($appointment['schedule_end_time']));
            $scheduleTime = $scheduleStart . ' - ' . $scheduleEnd;
            
           
            ?>

            <tr>
                <td><?= $index + 1; ?></td>
                <td><?= htmlspecialchars($appointment['citizen_name']); ?></td>
                <td><?= htmlspecialchars($appointment['type']); ?></td>
                <td><?= htmlspecialchars(date('F j, Y', strtotime($appointment['schedule_date']))); ?></td>
                <td><?= htmlspecialchars($scheduleTime); ?></td>
                <td><?= htmlspecialchars($appointment['roles']); ?></td>
                <td>
                    <?php 
                    if ($appointment['approval_status'] === 'Pending') {
                        echo 'Waiting for Approval';
                    } else {
                        echo htmlspecialchars($appointment['approval_status']);
                    }
                    ?>
                </td>
               
            </tr>
            <?php
        }
    } else { ?>
        <tr>
            <td colspan="9">No pending appointments found.</td>
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
  <script>
    // Search function to filter the table
    document.getElementById('searchInput').addEventListener('input', function() {
        var searchTerm = this.value.toLowerCase(); // Get the search term in lowercase
        var tableRows = document.querySelectorAll('#appointmentsTable tbody tr'); // Get all rows in the table body

        tableRows.forEach(function(row) {
            var cells = row.getElementsByTagName('td'); // Get all cells of the current row
            var match = false;

            // Loop through each cell in the row
            for (var i = 0; i < cells.length; i++) {
                var cellText = cells[i].textContent.toLowerCase(); // Get the text content of the cell in lowercase
                if (cellText.indexOf(searchTerm) > -1) { // If the search term matches the cell text
                    match = true;
                    break; // If a match is found, no need to check further cells in the row
                }
            }

            // Show or hide the row based on whether there is a match
            if (match) {
                row.style.display = ''; // Show row
            } else {
                row.style.display = 'none'; // Hide row
            }
        });
    });
</script>
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
    // JavaScript function for search bar
    document.getElementById('searchInput').addEventListener('keyup', function () {
        const searchValue = this.value.toLowerCase();
        const table = document.getElementById('multi-filter-select');
        const rows = table.querySelectorAll('tbody tr');

        rows.forEach(row => {
            const rowText = row.textContent.toLowerCase();
            if (rowText.includes(searchValue)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
</script>

    <script>
         // Function to add 'active' class to the clicked link and remove it from others
    function setActiveLink() {
        // Get all custom links
        var links = document.querySelectorAll('.custom-nav-link');
        
        // Remove 'active' class from all links
        links.forEach(function(link) {
            link.classList.remove('active');
        });

        // Add 'active' class to the current link
        this.classList.add('active');
    }

    // Attach click event listeners to all custom-nav-link elements
    var links = document.querySelectorAll('.custom-nav-link');
    links.forEach(function(link) {
        link.addEventListener('click', setActiveLink);
    });

    // Optionally, set the active class based on the current page when loading the page
    window.addEventListener('load', function() {
        // Get the current URL
        var currentPage = window.location.pathname.split('/').pop();

        // Set the active class based on the current page
        links.forEach(function(link) {
            if (link.href.includes(currentPage)) {
                link.classList.add('active');
            }
        });
    });
          // JavaScript to trigger modal when the link is clicked
document.getElementById('viewValidID').addEventListener('click', function() {
    $('#validIDModal').modal('show');
});

        </script>
    <script>
  $(document).ready(function () {
  $("#multi-filter-select").DataTable({
    pageLength: 5,
    columnDefs: [
      { targets: '_all', orderable: false }  // Disable sorting for all columns
    ],
    initComplete: function () {
      this.api()
        .columns()
        .every(function () {
          var column = this;
          var select = $('<select class="form-select"><option value=""></option></select>')
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
              select.append('<option value="' + d + '">' + d + "</option>");
            });
        });
    },
  });
});


    </script>
      <!-- JavaScript Libraries -->
     
  </body>
</html>