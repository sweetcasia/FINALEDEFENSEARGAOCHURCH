<?php
require_once '../../Model/staff_mod.php';
require_once '../../Model/db_connection.php';
$userManager = new Staff($conn);

// Use $userManager to call the methods
$recentCitizenUpdates = $userManager->getRecentCitizenUpdates();
$recentBaptismFills = $userManager->getRecentBaptismFills(); 
$recentConfirmationFills = $userManager->getRecentConfirmationFills();
$recentDefuctomFills = $userManager-> getRecentDefuctomFills();
$recentMarriageFills = $userManager-> getRecentMarriageFills();
$recentRequestFormFills = $userManager->getRecentRequestFormFills();
$recentPriestBaptismFormFills = $userManager->getRecentPriestBaptismFills();
$recentPriestConfirmationFormFills = $userManager->getRecentPriestConfirmationFills();
$recentPriestDefuctomFormFills = $userManager->getRecentPriestDefuctomFills();
$recentPriestMarriageFills = $userManager->getRecentPriestMarriageFills();
$recentPriestRequestFormFills = $userManager->getRecentPriestRequestFormFills();
// Merge all updates from different categories
$allUpdates = array_merge(
  $recentCitizenUpdates, 
  $recentBaptismFills,
  $recentConfirmationFills,
  $recentDefuctomFills,
  $recentMarriageFills,
  $recentRequestFormFills,
  $recentPriestBaptismFormFills,
  $recentPriestConfirmationFormFills,
  $recentPriestDefuctomFormFills,
  $recentPriestMarriageFills,
  $recentPriestRequestFormFills
);

// Sort the merged updates by the timestamp in descending order
usort($allUpdates, function($a, $b) {
  // Ensure that you are comparing the correct timestamp field
  return strtotime($b['c_current_time']) - strtotime($a['c_current_time']);
});

// Count the updates for display
$updatesCount = count($allUpdates);


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
    <link rel="icon" href="../assets/img/kaiadmin/favicon.ico" type="image/x-icon"
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
<style>
  .notification-item {
    display: flex;            /* Use flexbox for alignment */
    align-items: center;     /* Vertically center items */
    padding: 10px;           /* Add padding for spacing */
    border-bottom: 1px solid #e0e0e0; /* Bottom border for separation */
}

.notif-icon {
    margin-right: 10px;      /* Space between icon and text */
    font-size: 24px;         /* Adjust icon size */
    color: #007bff;          /* Icon color */
}

.notif-content {
    flex-grow: 1;            /* Allow content to take remaining space */
}

.notif-content .block {
    display: block;          /* Make the link block-level for better spacing */
    font-weight: 500;        /* Bold font for better visibility */
}

.notif-content .time {
    font-size: 12px;         /* Smaller font for timestamp */
    color: #888;             /* Lighter color for less emphasis */
}
/* This class will adjust the size of the notification icon */
.notification-icon {
    font-size: 20px; /* Adjust the size as needed */
}

</style>
    <!-- CSS Files -->
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="../assets/css/plugins.min.css" />
    <link rel="stylesheet" href="../assets/css/kaiadmin.min.css" />

    <!-- CSS Just for demo purpose, don't include it in your project -->
  </head> <body>
  <div class="main-header">
          <div class="main-header-logo">
            <!-- Logo Header -->
            <div class="logo-header" data-background-color="dark">
              <a href="index.html" class="logo">
                <img
                  src="assets/img/kaiadmin/logo_light.svg"
                  alt="navbar brand"
                  class="navbar-brand"
                  height="20"
                />
              </a>
              <div class="nav-toggle">
                <button class="btn btn-toggle toggle-sidebar">
                  <i class="gg-menu-right"></i>
                </button>
                <button class="btn btn-toggle sidenav-toggler">
                  <i class="gg-menu-left"></i>
                </button>
              </div>
              <button class="topbar-toggler more">
                <i class="gg-more-vertical-alt"></i>
              </button>
            </div>
            <!-- End Logo Header -->
          </div>
          <!-- Navbar Header -->
          <nav
            class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom"
          >
            <div class="container-fluid">
              <nav
                class="navbar navbar-header-left navbar-expand-lg navbar-form nav-search p-0 d-none d-lg-flex"
              >
                <div class="input-group">
                  <div class="input-group-prepend">
                  
                  </div>
                 
                </div>
              </nav>

              <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
                <li
                  class="nav-item topbar-icon dropdown hidden-caret d-flex d-lg-none"
                >
                  <a
                    class="nav-link dropdown-toggle"
                    data-bs-toggle="dropdown"
                    href="#"
                    role="button"
                    aria-expanded="false"
                    aria-haspopup="true"
                  >
                    <i class="fa fa-search"></i>
                  </a>
                  <ul class="dropdown-menu dropdown-search animated fadeIn">
                    <form class="navbar-left navbar-form nav-search">
                      <div class="input-group">
                        <input
                          type="text"
                          placeholder="Search ..."
                          class="form-control"
                        />
                      </div>
                    </form>
                  </ul>
                </li>
                
                 <!-- start for notification bell -->
                 <li class="nav-item topbar-icon dropdown hidden-caret">
                    <a class="nav-link dropdown-toggle" href="#" id="notifDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-bell notification-icon"></i> <!-- Apply the custom class here -->

                        <span class="notification"><?php echo $updatesCount; ?></span>
                    </a>
                    <ul class="dropdown-menu notif-box animated fadeIn" aria-labelledby="notifDropdown">
                        <li>
                            <div class="dropdown-title">
                                You have <?php echo $updatesCount; ?> new update(s)
                            </div>
                        </li>
                        <li>
                            <div class="notif-scroll scrollbar-outer">
                                <div class="notif-center">
                                <?php foreach ($allUpdates as $update): ?>
    <div class="notification-item">
        <div class="notif-icon notif-primary">
            <i class="fa fa-user-plus"></i>
        </div>

        <div class="notif-content">
            <span class="block">
                <?php
                // Check if it's a new citizen registration
                if (isset($update['citizend_id'])) {
                    echo '<a href="StaffCitizenAccounts.php">' . trim(htmlspecialchars($update['fullname'])) . ' - New Registered Account </a>';
                } else if (isset($update['baptism_id'])) {
                  if (isset($update['event_name']) && $update['event_name'] === 'Baptism') {
                      echo '<a href="StaffSoloSched.php">' . htmlspecialchars($update['fullname']) . ' - New Baptism Fill-up Information </a>';
                  } else if (isset($update['event_name']) && $update['event_name'] === 'MassBaptism') {
                      echo '<a href="StaffMassSched.php">' . htmlspecialchars($update['fullname']) . ' - New Mass Baptism Fill-up Information </a>';
                  }
              } else if (isset($update['confirmationfill_id'])) {
                if (isset($update['event_name']) && $update['event_name'] === 'Confirmation') {
                    echo '<a href="StaffSoloSched.php">' . htmlspecialchars($update['fullname']) . ' - New Confirmation Fill-up Information </a>';
                } else if (isset($update['event_name']) && $update['event_name'] === 'MassConfirmation') {
                    echo '<a href="StaffMassSched.php">' . htmlspecialchars($update['fullname']) . ' - New Mass Confirmation Fill-up Information </a>';
                }
            } else if (isset($update['defuctomfill_id'])) {
                echo '<a href="StaffSoloSched.php">' . htmlspecialchars($update['fullname']) . ' - New Defuctom Fill-up Information </a>';
            } else if (isset($update['marriagefill_id'])) {
                if (isset($update['event_name']) && $update['event_name'] === 'Marriage') {
                    echo '<a href="StaffSoloSched.php">' . htmlspecialchars($update['full_names']) . ' - New Marriage Fill-up Information </a>';
                } else if (isset($update['event_name']) && $update['event_name'] === 'MassWedding') {
                    echo '<a href="StaffMassSched.php">' . htmlspecialchars($update['full_names']) . ' - New Mass Wedding Fill-up Information </a>';
                }
            }else if (isset($update['req_id'])) {
              $category = htmlspecialchars($update['req_category']); // Sanitize req_category
              echo '<a href="StaffRequestSchedule.php">' . htmlspecialchars($update['req_person']) . ' - New ' . $category . ' Fill-up Information </a>';
          }
          else if (isset($update['priestbaptism'])) {
            $checkstatus = htmlspecialchars($update['checkstatus']); // Sanitize req_category
            if (isset($update['event_name']) && $update['event_name'] === 'Baptism') {
                echo '<a href="StaffSoloSched.php">' . htmlspecialchars($update['fullname']) . ' - Has Been '  . $checkstatus . ' Baptism Appointment Come and Check it  </a>';
            } 
        }   else if (isset($update['priestconfirmation'])) {
          $checkstatus = htmlspecialchars($update['checkstatus']); // Sanitize req_category
          if (isset($update['event_name']) && $update['event_name'] === 'Confirmation') {
              echo '<a href="StaffSoloSched.php">' . htmlspecialchars($update['fullname']) . ' - Has Been '  . $checkstatus . ' Confirmation Appointment Come and Check it  </a>';
          } 
      }
      else if (isset($update['priestdefuctom'])) {
        $checkstatus = htmlspecialchars($update['checkstatus']); // Sanitize req_category
        if (isset($update['event_name']) && $update['event_name'] === 'Funeral') {
            echo '<a href="StaffSoloSched.php">' . htmlspecialchars($update['fullname']) . ' - Has Been '  . $checkstatus . ' Funeral Appointment Come and Check it  </a>';
        } 
    }
    else if (isset($update['priestmarriage'])) {
      $checkstatus = htmlspecialchars($update['checkstatus']); // Sanitize req_category
      if (isset($update['event_name']) && $update['event_name'] === 'Wedding') {
          echo '<a href="StaffSoloSched.php">' . htmlspecialchars($update['fullname']) . ' - Has Been '  . $checkstatus . ' Wedding Appointment Come and Check it  </a>';
      } 
  }else if (isset($update['requestpriest'])) {
    $checkstatus = htmlspecialchars($update['checkstatus']); // Sanitize req_category
    $category = htmlspecialchars($update['req_category']); // Sanitize req_category
    echo '<a href="StaffRequestSchedule.php">' . htmlspecialchars($update['fullname']) . ' - Has Been '  . $checkstatus .  $category. ' RequestForm Appointment Come and Check it  </a>';
}
           else {
                echo "Unknown update";
            }
                ?>
            </span>
            <span class="time"><?php echo htmlspecialchars($update['c_current_time']); ?></span>
        </div>
    </div>
<?php endforeach; ?>


                                </div>
                            </div>
                        </li>
                        <li>
                         
                        </li>
                    </ul>
                </li>
                <!-- end for notification -->

              
               

                <li class="nav-item topbar-user dropdown hidden-caret">
                  <a
                    class="dropdown-toggle profile-pic"
                    data-bs-toggle="dropdown"
                    href="#"
                    aria-expanded="false"
                  >
                  <?php
$loggedInUserName = isset($nme) ? $nme : 'Guest'; // Assumes $nme is the logged-in user's name
$initial = strtoupper(substr($loggedInUserName, 0, 1)); // Gets the first letter and makes it uppercase
?>

<div class="avatar">
  <span class="avatar-title rounded-circle border border-white bg-primary">
    <?php echo $initial; ?>
  </span>
</div>
<span class="profile-username">
  <span class="op-7">Welcome,</span>
  <span class="fw-bold"><?php echo $loggedInUserName; ?> Staff</span>
</span>

<ul class="dropdown-menu dropdown-user animated fadeIn">
  <div class="dropdown-user-scroll scrollbar-outer">
    <li>
      <div class="user-box">
      <div class="avatar-lg">
  <div class="avatar-title rounded-circle border border-white bg-primary text-white d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; font-size: 24px;">
    <?php echo $initial; ?>
  </div>

        </div>
        <div class="u-text">
          <h4>Church Staff</h4>
          <p class="text-muted"><?php echo $email; ?></p>
          <a href="profile.php" class="btn btn-xs btn-secondary btn-sm">View Profile</a>
        </div>
      </div>
    </li>
                      <li>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="../../index.php?action=logout">Logout</a>
                      </li>
                    </div>
                  </ul>
                </li>
              </ul>
            </div>
          </nav>
          <!-- End Navbar -->
        </div>  
  </body>
  
    </body>
</html>
