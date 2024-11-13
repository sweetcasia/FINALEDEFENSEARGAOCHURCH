<?php
require_once '../../Model/staff_mod.php';
require_once '../../Model/db_connection.php';
require_once '../../Controller/profilefetchpending_con.php';
require_once '../../Model/citizen_mod.php';
$staff = new Staff($conn);
$citizen = new Citizen($conn);
$appointment_id = isset($_GET['appsched_id']) ? intval($_GET['appsched_id']) : null;

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


$step = 1;

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
    <script src="assets/js/plugin/webfont/webfont.min.js"></script>
    <style>
        .stepper-wrapper {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

/* Individual step */
.step {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
}

/* Step circle (icon) */
.step-icon {
    width: 40px;
    height: 40px;
    background-color: #e0e0e0;
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 18px;
    color: white;
}

/* Label below step */
.step-label p {
    margin: 5px 0;
    font-size: 14px;
    color: #333;
}

.step-label small {
    color: #999;
}

/* Line between steps */
.step-line {
    flex-grow: 1;
    height: 2px;
    background-color: #e0e0e0;
    margin: 0 10px;
}

/* Completed step styles */
.completed .step-icon {
    background-color: #28a745; /* Green for completed */
}

.completed .step-label small {
    color: #28a745; /* Green label for completed */
}

/* In-progress step styles */
.in-progress .step-icon {
    background-color: #007bff; /* Blue for in-progress */
}

.in-progress .step-label small {
    color: #007bff; /* Blue label for in-progress */
}

/* Pending step styles */
.pending .step-icon {
    background-color: #e0e0e0; /* Gray for pending */
    color: #007bff; /* Border or icon color for pending */
}
           .stepper .step {
        padding: 10px;
        border-radius: 5px;
        margin-right: 10px;
        font-weight: bold;
    }
    .stepper .active {
        background-color: #28a745; /* Green background for active step */
        color: white;
    }
        .birthday-input {
    font-family: Arial, sans-serif;
    margin-bottom: 10px;
}

.birthday-input label {
    display: block;
    font-weight: bold;
    margin-bottom: 5px;
}

.birthday-selectors {
    display: flex;
    gap: 5px;
}


.birthday-selectors select {
    padding: 5px;
    border: 1px solid #0a58ca;
    border-radius: 5px;
    width: 100px;
    font-size: 14px;
    color: #555;
}

.birthday-selectors select:focus {
    outline: none;
    border-color: #0a58ca;
}


small {
    display: block;
    color: #555;
    margin-top: 5px;
}
.error {
        color: red;
        font-size: 0.875em;
        margin-top: 0.25em;
    }
    .form-control.error {
        border: 1px solid red;
    }
    </style>
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
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
 integrity="sha384-KyZXEAg3QhqLMpG8r+Knujsl7/1L_dstPt3HV5HzF6Gvk/e3s4Wz6iJgD/+ub2oU" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <!-- CSS Files -->
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="../assets/css/plugins.min.css" />
    <link rel="stylesheet" href="../assets/css/kaiadmin.min.css" />

    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link rel="stylesheet" href="../assets/css/demo.css" />
   
  </head>
  <body> 
 <!-- Navbar & Hero Start -->
 <div class="container-fluid nav-bar px-0 px-lg-4 py-lg-0">
      <div class="container">
       
      <?php require_once 'header.php'?>

      </div>
    </div>
    <!-- Navbar & Hero End -->
    <div class="container" style="max-width: 500px; margin: 0 auto; padding: 20px; font-family: Arial, sans-serif;">

<div class="page-inner">
    <div class="row">
        <div class="col-md-12">
            <div class="card" style="height: auto;
    border: 1px solid #198754;
    border-radius: 8px;
    padding: 20px;
    background-color: #d9e5d921;
    box-shadow: 0 2px 5px rgba(53, 52, 44, 2.1);">
                <div class="card-header" style="margin-bottom: 20px; text-align: center;">
                    <h3 style="font-size: 30px; color: #01488f; margin-bottom: 10px; font-weight:900">EVENT REFERENCE</h3>
                    <p style="font-size: 12px; color: #666;">Keep this reference handy, as you'll need to present it to the church staff upon arrival. The reference number will help verify your scheduled event.</p>

                </div>

                <div class="stepper-wrapper">
                    <!-- Step 1 -->
                    <div class="step completed">
                        <div class="step-label">

                            <div class="receipt-details" style="margin-top: 15px; font-size: 14px; color: #555; text-align: center;">
                                <p><span style="font-weight: bold; color: #1572e8; font-size: 30px;"><?php echo $reference_number; ?></span></p>
                                
                                <div style="border-bottom: 1px solid #333; width: 50%; margin-bottom: 10px; margin: 0 auto; margin-top:-10px!important;"></div> <!-- Long underline -->
                                <p><span style="font-weight: bold; color: #333;">REFERENCE NUMBER</span></p>
                            </div>
                            
                            <p style="font-size: 14px; color: #333; margin-top: 20px;">Present this reference with the reference number to the staff when you arrive in person to verify and assist with your event.</p>


                            <!-- Button placed inside the container -->
                            <div style="text-align: center; margin-top: 20px;">
                            <button type="button" class="btn btn-success" style="padding: 8px 20px; font-size: 14px;  border-radius: 5px; color: white;" onclick="redirectToPaymentPage()">View Full Details</button>

                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>

</div>


<?php require_once 'footer.php'?>
<!-- JavaScript Libraries -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="lib/wow/wow.min.js"></script>
        <script src="lib/easing/easing.min.js"></script>
        <script src="lib/waypoints/waypoints.min.js"></script>
        <script src="lib/counterup/counterup.min.js"></script>
        <script src="lib/lightbox/js/lightbox.min.js"></script>
        <script src="lib/owlcarousel/owl.carousel.min.js"></script>
        

        <!-- Template Javascript -->
        <script src="js/main.js"></script>
        <script type="text/javascript">
    function redirectToPaymentPage() {
        window.location.href = "fillbaptismpayment.php";  // Redirect to the payment page
    }
</script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<!-- Popper.js (required for Bootstrap 4) -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<!-- Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <!-- Sweet Alert -->
  <script src="../assets/js/plugin/sweetalert/sweetalert.min.js"></script>
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


    <!-- Kaiadmin JS -->
    <script src="../assets/js/kaiadmin.min.js"></script>
  <!-- JavaScript Libraries -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="lib/wow/wow.min.js"></script>
        <script src="lib/easing/easing.min.js"></script>
        <script src="lib/waypoints/waypoints.min.js"></script>
        <script src="lib/counterup/counterup.min.js"></script>
        <script src="lib/lightbox/js/lightbox.min.js"></script>
        <script src="lib/owlcarousel/owl.carousel.min.js"></script>
        

        <!-- Template Javascript -->
        <script src="js/main.js"></script>
  </body>
</html>
