<?php
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
$current_page = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <title>ARGAO CHURCH MANAGEMENT SYSTEM</title>
  <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />
  <link rel="icon" href="../assets/img/kaiadmin/favicon.ico" type="image/x-icon" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
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
  <link rel="stylesheet" href="../assets/css/bootstrap.min.css" />
  <link rel="stylesheet" href="../assets/css/plugins.min.css" />
  <link rel="stylesheet" href="../assets/css/demo.css" />
</head>
<body>
<div class="wrapper">
  <div class="sidebar" data-background-color="dark">
    <div class="sidebar-logo">
      <div class="logo-header" data-background-color="dark">
        <a href="index.php" class="logo">
          <img src="../assets/img/argaochurch.png" alt="navbar brand" class="navbar-brand" height="46" />
        </a>
        <div class="nav-toggle">
          <button class="btn btn-toggle toggle-sidebar"><i class="gg-menu-right"></i></button>
          <button class="btn btn-toggle sidenav-toggler"><i class="gg-menu-left"></i></button>
        </div>
        <button class="topbar-toggler more"><i class="gg-more-vertical-alt"></i></button>
      </div>
    </div>
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
      <div class="sidebar-content">
        <ul class="nav nav-secondary">
          <li class="nav-item <?= ($current_page == 'StaffDashboard.php') ? 'active' : ''; ?>">
            <a href="StaffDashboard.php">
              <i class="fas fa-home"></i>
              <p>Dashboard</p>
            </a>
          </li>
          <li class="nav-item <?= ($current_page == 'StaffCalendar.php') ? 'active' : ''; ?>">
            <a href="StaffCalendar.php">
              <i class="fas fa-calendar-alt"></i>
              <p>Calendar</p>
            </a>
          </li>
          <li class="nav-item <?= ($current_page == 'StaffSoloSched.php') ? 'active' : ''; ?>">
            <a href="StaffSoloSched.php">
              <i class="fas fa-calendar-check"></i>
              <p>Citizens Scheduling</p>
            </a>
          </li>
          <li class="nav-item <?= ($current_page == 'StaffAppointment.php') ? 'active' : ''; ?>">
            <a href="StaffAppointment.php">
              <i class="fas fa-pen-square"></i>
              <p>Citizens Appointment</p>
            </a>
          </li>
          <li class="nav-item <?= ($current_page == 'StaffAnnouncement.php') ? 'active' : ''; ?>">
            <a href="StaffAnnouncement.php">
              <i class="fas fa-table"></i>
              <p>Announcement</p>
            </a>
          </li>
          <li class="nav-item <?= ($current_page == 'StaffMassSched.php') ? 'active' : ''; ?>">
            <a href="StaffMassSched.php">
              <i class="fas fa-calendar-alt"></i>
              <p>Mass Scheduling</p>
            </a>
          </li>
          <li class="nav-item <?= ($current_page == 'StaffMassSeminar.php') ? 'active' : ''; ?>">
            <a href="StaffMassSeminar.php">
              <i class="fas fa-calendar-alt"></i>
              <p>Mass Appointment</p>
            </a>
          </li>
          <li class="nav-item <?= ($current_page == 'StaffRequestSchedule.php') ? 'active' : ''; ?>">
            <a href="StaffRequestSchedule.php">
            <i class="fas fa-calendar-alt"></i>
            <p>Pending Request</p>
            </a>
          </li>
          <li class="nav-item <?= ($current_page == 'StaffRequestForm.php') ? 'active' : ''; ?>">
            <a href="StaffRequestForm.php">
              <i class="fas fa-pen-square"></i>
              <p>Request Form Schedule</p>
            </a>
          </li>
          <li class="nav-item <?= ($current_page == 'StaffCitizenAccounts.php') ? 'active' : ''; ?>">
            <a href="StaffCitizenAccounts.php">
              <i class="fas fa-user-alt"></i>
              <p>Citizen Accounts</p>
            </a>
          </li>
        </ul>
      </div>
    </div>
  </div>
</body>
</html>
