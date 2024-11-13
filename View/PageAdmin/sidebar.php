<?php
$loggedInUserEmail = isset($_SESSION['email']) ? $_SESSION['email'] : null;
$r_status = isset($_SESSION['user_type']) ? $_SESSION['user_type'] : null;

if (!$loggedInUserEmail) {
    header("Location: ../../index.php");
    exit();
}

// Redirect based on user type
if ($r_status === "Staff") {
    header("Location: ../PageStaff/StaffDashboard.php");
    exit();
}
if ($r_status === "Citizen") {
    header("Location: ../PageCitizen/CitizenPage.php");
    exit();
}
if ($r_status === "Priest") {
    header("Location: ../PagePriest/index.php");
    exit();
}

// Detect current page
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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">



    <link rel="stylesheet" href="../assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="../assets/css/plugins.min.css" />
    <link rel="stylesheet" href="../assets/css/kaiadmin.min.css" />
    <link rel="stylesheet" href="../assets/css/demo.css" />
    <style>
      /* Hover and active state for sidebar links */
      .sidebar .nav-item a:hover {
          background-color: #4c5c68;
          color: #fff;
          border-radius: 5px;
      }
      /* Active page styling */
      .sidebar .nav-item.active a {
          background-color: #007bff;
          color: #fff;
          font-weight: bold;
          border-radius: 5px;
      }
    </style>
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
                    <li class="nav-item <?= ($current_page == 'AdminDashboard.php') ? 'active' : ''; ?>">
                        <a href="AdminDashboard.php">
                            <i class="fas fa-home"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li class="nav-item <?= ($current_page == 'BaptismRecords.php') ? 'active' : ''; ?>">
                        <a href="BaptismRecords.php">
                        <i class="fa-solid fa-file-lines"></i>
                                                 <p>Baptism  Records</p>
                        </a>
                    </li>
                    <!-- Continue similarly for other items -->
                    <li class="nav-item <?= ($current_page == 'ConfirmationRecords.php') ? 'active' : ''; ?>">
                        <a href="ConfirmationRecords.php">
                        <i class="fa-solid fa-file-lines"></i>
                            <p>Confirmation  Records</p>
                        </a>
                    </li>
                    <li class="nav-item <?= ($current_page == 'DefunctorumRecords.php') ? 'active' : ''; ?>">
                        <a href="DefunctorumRecords.php">
                        <i class="fa-solid fa-file-lines"></i>
                            <p>Deceased  Records</p>
                        </a>
                    </li>
                    <li class="nav-item <?= ($current_page == 'WeddingRecords.php') ? 'active' : ''; ?>">
                        <a href="WeddingRecords.php">
                        <i class="fa-solid fa-file-lines"></i>
                            <p>Wedding Records</p>
                        </a>
                    </li>
                    <li class="nav-item <?= ($current_page == 'AdminDonation.php') ? 'active' : ''; ?>">
                        <a href="AdminDonation.php">
                        <i class="fa-solid fa-file-invoice"></i>
                            <p>Donation Reports</p>
                        </a>
                    </li>
                    <li class="nav-item <?= ($current_page == 'AdminFinancial.php') ? 'active' : ''; ?>">
                        <a href="AdminFinancial.php">
                        
                        <i class="fa-solid fa-receipt"></i>
                                                    <p>Acknowledge Receipt</p>
                        </a>
                    </li>
                    <li class="nav-item <?= ($current_page == 'PriestRecords.php') ? 'active' : ''; ?>">
                        <a href="PriestRecords.php">
                        <i class="fa-solid fa-user-group"></i>
                                                    <p>Priest Personnel</p>
                        </a>
                    </li>
                    <li class="nav-item <?= ($current_page == 'StaffRecords.php') ? 'active' : ''; ?>">
                        <a href="StaffRecords.php">

                        <i class="fa-solid fa-user-group"></i>                        <p>Staff Personnel</p>
                        </a>
                    </li>
                    <li class="nav-item <?= ($current_page == 'AdminRecords.php') ? 'active' : ''; ?>">
                        <a href="AdminRecords.php">

                        <i class="fa-solid fa-user-group"></i>                        <p>Admin Personnel</p>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</body>
</html>
