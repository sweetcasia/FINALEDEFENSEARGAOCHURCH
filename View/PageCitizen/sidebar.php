<?php
$current_page = basename($_SERVER['PHP_SELF']);

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <title>ARGAO CHURCH MANAGEMENT SYSTEM</title>
  <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />
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
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <!-- CSS Files -->
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="../assets/css/plugins.min.css" />
    <link rel="stylesheet" href="../assets/css/kaiadmin.min.css" />
    <link rel="stylesheet" href="../css/table.css" />
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
          <li class="nav-item <?= ($current_page == 'profile.php') ? 'active' : ''; ?>">
            <a href="profile.php">
              <i class="fas fa-home"></i>
              <p>My Profile</p>
            </a>
          </li>
          <li class="nav-item <?= ($current_page == 'eventschedule.php') ? 'active' : ''; ?>">
            <a href="eventschedule.php">
              <i class="fas fa-calendar-alt"></i>
              <p>My Event Scheduling</p>
            </a>
          </li>
          <li class="nav-item <?= ($current_page == 'appointmentseminar.php') ? 'active' : ''; ?>">
            <a href="appointmentseminar.php">
              <i class="fas fa-calendar-check"></i>
              <p>Seminar Appointments</p>
            </a>
          </li>
          <li class="nav-item <?= ($current_page == 'appointmentseminarcomplete.php') ? 'active' : ''; ?>">
            <a href="appointmentseminarcomplete.php">
              <i class="fas fa-pen-square"></i>
              <p>My Booking history</p>
            </a>
          </li>
          <li class="nav-item <?= ($current_page == 'citizenpage.php') ? 'active' : ''; ?>">
            <a href="citizenpage.php">
            <i class="fa-solid fa-circle-left"></i>
                          <p>Back to Landing Page</p>
            </a>
          </li>
        </ul>
      </div>
    </div>
  </div>
</body>
</html>