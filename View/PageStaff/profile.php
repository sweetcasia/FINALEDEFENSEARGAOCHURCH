<?php
// Include database connection and controller
require_once '../../Model/db_connection.php';
require_once '../../Controller/citizen_con.php';
require_once '../../Model/login_mod.php';

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
    case 'Citizen':
        header("Location: ../PageCitizen/CitizenPage.php");
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
$citizenInfo = new User ($conn);
$citizenDetails = $citizenInfo->getCitizenDetails($citizenId);


?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
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
    <style>
     body{
      font-family: 'Public Sans', sans-serif;

     }





/* Styling for Input Fields */
.input {
  padding: 12px 15px;
    margin: 10px 0;
    width: 100%;
    background: transparent;
    font-size: 1rem;
    transition: all 0.3s ease;
    color: #16243d;
    border: none;
    border-bottom: 1px solid #014ca1;

}

/* Focus Effect on Input Fields */
.input:focus {
    border-color: #007bff;
    outline: none;
    box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
}

/* Styling for Title Text */
.text-blk.input-title {
    font-size: 1rem;
    color: #16243d; 
}

/* Responsive Flexbox Layout */
.responsive-container-block {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    justify-content: space-between;
    margin-top: 100px;}

.responsive-cell-block {
    flex: 1 1 48%; /* Makes two items per row */
    min-width: 280px; /* Minimum width for responsive design */
}

/* Styling for Each Box (input group) */
.custom-box {
    background-color: #f9f9f9;
    padding: 20px;
    border-radius: 10px;
    border: 1px solid #ddd;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease;
}

/* Hover Effect on Input Group */
.custom-box:hover {
  background-color: #f0f0f0; /* Change background color on hover */
  color: #007bff; /* Change text color on hover */
}

/* Responsive Adjustment for Smaller Screens */
@media (max-width: 768px) {
    .responsive-cell-block {
        flex: 1 1 100%; /* Stacks inputs vertically on small screens */
    }
}
/* Profile Image Container */
.profile-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    position: relative;
    margin-bottom: -145px;
    margin-top: -20px;
}

/* Profile Image Styling */
.profile-img {
  width: 278px;
    height: 281px;
    border-radius: 50%;
    object-fit: cover;
    z-index: 2; /* Ensure image stays on top */

}

.input-link {
    display: inline-block;
    padding: 12px 15px;
    margin: 10px 0;
    color: #16243d;
    font-size: 1rem;
    border-bottom: 1px solid #014ca1;
    text-decoration: none;
    cursor: pointer;
    transition: all 0.3s ease;
}

.input-link:hover,
.input-link:focus {
  box-shadow: 0 6px 6px -3px rgba(0, 123, 255, 0.5); /* Slightly stronger shadow on focus */
}
/* Account Title Styling */
/* Flexbox layout for box */
.box {
    display: flex;
    align-items: center;
    border: 1px solid #014ca1;
        padding: 20px;
    cursor: pointer;
    transition: background-color 0.3s, box-shadow 0.3s;
}


/* Text container styling */
.text-container {
    display: flex;
    flex-direction: column;
}

.text-container h5 {
    font-size: 16px;
    margin: 0;
}

.text-container .text-secondary {
    font-weight: bold;
    font-size: 24px;
    color: #5a5a5a;
}
/* Icon wrapper styling */
.icon-wrapper {
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: #ac0727cf; /* Background color for icon */
    width: 55px;
    height: 55px;
    margin-right: 15px; /* Space between icon and text */
}

.account-title {
    margin: 0; /* Remove margin */
    padding-bottom: 5px; /* Optional padding for spacing */
}

.responsive-container-block {
    margin-top: 0; /* Ensure no extra space at the top */
    /* Other existing styles */
}

  /* Override Bootstrap's default grid styles if necessary */
  .card-body .row {
    display: flex;
    flex-wrap: wrap;
  }

  .card-body .col-md-6 {
    flex: 1 1 50%; /* Make each column take 50% of the container width */
    padding: 10px; /* Add padding between columns */
  }

  /* Optionally, add responsiveness if you want columns to stack on small screens */
  @media (max-width: 767px) {
    .card-body .col-md-6 {
      flex: 1 1 100%; /* Stack columns on smaller screens */
    }
  }


    </style>
  </head>
  <body>
  <?php require_once 'sidebar.php'; ?>
  <div class="main-panel">
    <?php require_once 'header.php'; ?>

    <div class="container">
      <div class="page-inner">
      <div class="card">
  <div class="card-header text-center">
    
    <h4 class="card-title mt-3">Account Details</h4>
  </div>

    <div class="card-body">
    <div class="row g-4">
    <!-- Full Name -->
    <div class="col-md-6">
        <label for="fullName" class="form-label">Full Name</label>
        <input type="text" class="form-control" id="fullName" 
            value="<?php echo htmlspecialchars($nme); ?>" disabled>
    </div>

    <!-- Email -->
    <div class="col-md-6">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" 
            value="<?php echo htmlspecialchars($citizenDetails['email']); ?>" disabled>
    </div>

    <!-- Gender -->
    <div class="col-md-6">
        <label for="gender" class="form-label">Gender</label>
        <input type="text" class="form-control" id="gender" 
            value="<?php echo htmlspecialchars($citizenDetails['gender']); ?>" disabled>
    </div>

    <!-- Phone -->
    <div class="col-md-6">
        <label for="phone" class="form-label">Phone Number</label>
        <input type="text" class="form-control" id="phone" 
            value="<?php echo htmlspecialchars($citizenDetails['phone']); ?>" disabled>
    </div>

    <!-- Address -->
    <div class="col-md-6">
        <label for="address" class="form-label">Address</label>
        <input type="text" class="form-control" id="address" 
            value="<?php echo htmlspecialchars($citizenDetails['address']); ?>" disabled>
    </div>

    <!-- Valid ID -->
    <div class="col-md-6">

</div>

    </div>

  <!-- Modal -->
  <div class="modal fade" id="validIDModal" tabindex="-1" aria-labelledby="validIDModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="validIDModalLabel">Valid ID</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <img src="../PageLanding/<?php echo htmlspecialchars($citizenDetails['valid_id']); ?>" alt="Valid ID" class="img-fluid">
        </div>
      </div>
    </div>
  </div>

  <div class="row g-3 mt-4">
  <!-- My Event Scheduling -->


  <!-- Seminar Appointment -->

  <!-- My Booking History -->


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
    // Function to toggle contentEditable on the target element
    document.querySelectorAll('.edit-btn').forEach((button) => {
      button.addEventListener('click', function () {
        const editableContent = this.closest('.row').querySelector('.editable');
        
        // Toggle contentEditable attribute
        const isEditable = editableContent.getAttribute('contentEditable') === 'true';
        editableContent.setAttribute('contentEditable', !isEditable);
        
        // Add/remove visual indicator of edit mode
        editableContent.classList.toggle('edit-mode', !isEditable);
        
        // Optionally, change the button icon to indicate the current mode
        if (!isEditable) {
          this.classList.add('text-primary'); // Optional: Change icon color to show edit mode
        } else {
          this.classList.remove('text-primary');
        }
      });
    });
  </script>
 
  </body>
</html>