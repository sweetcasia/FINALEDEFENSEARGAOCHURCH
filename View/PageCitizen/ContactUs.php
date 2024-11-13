<?php
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
?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <title>ARGAO CHURCH MANAGEMENT SYSTEM</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta content="" name="keywords" />
    <meta content="" name="description" />
    <link rel="icon" href="../assets/img/mainlogo.jpg" type="image/x-icon"
    />

        <!-- Google Web Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&family=Inter:slnt,wght@-10..0,100..900&display=swap" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
        <!-- Icon Font Stylesheet -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

        <!-- Libraries Stylesheet -->
        <link rel="stylesheet" href="lib/animate/animate.min.css"/>
        <link href="lib/lightbox/css/lightbox.min.css" rel="stylesheet">
        <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <!-- Customized Bootstrap Stylesheet -->
        <link href="css/bootstrap.min.css" rel="stylesheet">

        <!-- Template Stylesheet -->
        <link href="css/style.css" rel="stylesheet">
        <style>
          body {
          font-family: "Public Sans", sans-serif!important;
        }
          .bg-breadcrumb {
  position: relative;
  overflow: hidden;
  background: linear-gradient(rgba(1, 94, 201, 0.616), rgba(0, 0, 0, 0.2)),
  url(../assets/img/contact.jpeg);
  background-position: bottom;
  background-repeat: no-repeat;
  background-size: cover;
  padding: 60px 0 60px 0;
  transition: 0.5s;
}

.bg-breadcrumb .breadcrumb {
  position: relative;
}

.bg-breadcrumb .breadcrumb .breadcrumb-item a {
  color: var(--bs-white);
}

.text-center  p{
    color:#3b3b3b; text-align: justify; text-justify: inter-word; font-size: 15px; line-height: 1.6; margin-top: 10px; margin-left: 10px;
}


        .back-button {
float:right;       
margin-right:110px;  
margin-top:20px;  

            padding: 0.5rem 1rem;
            background-color: #0066a8;
            color: #fff;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            font-size: 1rem;
            transition: background-color 0.3s ease;
        }
        .back-button:hover {
            background-color: #004a80;
        }
       
        .baptismalreq i{
            font-size:7px;
            margin-right:15px;
            color:black;
        }
        .contact_us_green * {
            font-family: 'Public Sans', sans-serif;
        }

.contact_us_green .responsive-container-block {
  min-height: 75px;
  height: fit-content;
  width: 100%;
  display: flex;
  flex-wrap: wrap;
  justify-content: flex-start;
  margin-top: 0px;
  margin-right: auto;
  margin-left: auto;
}

.contact_us_green input:focus {
  outline-color: initial;
  outline-style: none;
  outline-width: initial;
}

.contact_us_green textarea:focus {
  outline-color: initial;
  outline-style: none;
  outline-width: initial;
}

.contact_us_green .text-blk {
  margin-top: 0px;
  margin-right: 0px;
  margin-bottom: 0px;
  margin-left: 0px;
  line-height: 25px;
}

.contact_us_green .responsive-cell-block {
  min-height: 75px;
}

.contact_us_green .responsive-container-block.container {
  margin-top: 60px;
  margin-right: auto;
  margin-bottom: 60px;
  margin-left: auto;
}

.contact_us_green .responsive-container-block.big-container {
  padding-top: 0px;
  padding-right: 50px;
  padding-bottom: 0px;
  padding-left: 50px;
}

.contact_us_green .text-blk.contactus-head {
  font-size: 25px;
  line-height: 50px;
  font-weight: 700;
  margin-top: 0px;
  margin-right: 0px;
  margin-bottom: 10px;
  margin-left: 0px;
}

.contact_us_green .text-blk.contactus-subhead {
  max-width: 385px;
  color: #3b3b3b;
  font-size: 15px;
  margin-top: 0px;
  margin-right: 0px;
  margin-bottom: 50px;
  margin-left: 0px;
}

.contact_us_green .contact-svg {
  padding-top: 0px;
  padding-right: 25px;
  padding-bottom: 0px;
  padding-left: 0px;
  width: 65px;
  height: 40px;
}

.contact_us_green .social-media-links {
  margin-top: 80px;
  margin-right: auto;
  margin-bottom: 0px;
  margin-left: auto;
  width: 250px;
  display: flex;
  justify-content: space-evenly;
}

.contact_us_green .social-svg {
  width: 35px;
  height: 35px;
}

.contact_us_green .text-box {
  display: flex;
  margin-top: 0px;
  margin-right: 0px;
  margin-bottom: 50px;
  margin-left: 0px;
}

.contact_us_green .contact-text {
  color: #3b3b3b;
}

.contact_us_green .input,
.contact_us_green .textinput {
  border: none; /* Remove all borders initially */
  border-bottom: 2.5px solid #0066a8; /* Add bottom border */
  font-size: 16px;
  padding: 10px 15px; /* Adjusted padding for comfort */
  width: 90%; /* Width for input fields */
  transition: border-color 0.3s, box-shadow 0.3s; /* Smooth transition for focus effects */
}

.contact_us_green .input:focus,
.contact_us_green .textinput:focus {
  border-bottom-color: #ac0727cf; /* Change bottom border color on focus */
  box-shadow: 0 0 5px rgba(172, 7, 39, 0.5); /* Shadow with related red color on focus */
}

.contact_us_green .textinput {
  height: 200px; /* Retain height for text area */
  width: 95%; /* Adjusted for wider text area */
  padding: 20px; /* Added uniform padding */
}

.contact_us_green .submit-btn {
  min-width: 230px;
  height: 50px;
  background-color: #ac0727cf;
  font-size: 17px;
  font-weight: 700;
  color: white;
  border-top-width: 2px;
  border-right-width: 2px;
  border-bottom-width: 2px;
  border-left-width: 2px;
  border-top-style: none;
  border-right-style: none;
  border-bottom-style: none;
  border-left-style: none;
  border-top-color: #767676;
  border-right-color: #767676;
  border-bottom-color: #767676;
  border-left-color: #767676;
  border-image-source: initial;
  border-image-slice: initial;
  border-image-width: initial;
  border-image-outset: initial;
  border-image-repeat: initial;
  border-top-left-radius: 5px;
  border-top-right-radius: 5px;
  border-bottom-right-radius: 5px;
  border-bottom-left-radius: 5px;
  margin-top: 0px;
  margin-right: auto;
  margin-bottom: 0px;
  margin-left: auto;
  cursor: pointer;
}
.contact_us_green .submit-btn:hover {
  background-color: #df143ccf;
  color: var(--bs-white);
}

.contact_us_green .btn-wrapper {
  display: flex;
  justify-content: center;
}

.contact_us_green .text-blk.input-title {
  font-size: 15px;
  line-height: 28px;
  margin-top: 0px;
  margin-right: 0px;
  margin-bottom: 15px;
  margin-left: 0px;
}

.contact_us_green .responsive-cell-block.wk-ipadp-6.wk-tab-12.wk-mobile-12.wk-desk-6 {
  margin-top: 0px;
  margin-right: 0px;
  margin-bottom: 30px;
  margin-left: 0px;
}

.contact_us_green .responsive-cell-block.wk-tab-12.wk-mobile-12.wk-desk-5.wk-ipadp-10 {
  padding-top: 0px;
  padding-right: 0px;
  padding-bottom: 0px;
  padding-left: 60px;
  display: flex;
  flex-direction: column;
  align-items: center;
}

.contact_us_green .head-text-box {
  display: none;
}

.contact_us_green .line {
  border-right-width: 1.8px;
  border-right-style: solid;
  border-right-color: #013979;
}

.contact_us_green .responsive-cell-block.wk-tab-12.wk-mobile-12.wk-desk-7.wk-ipadp-10.line {
  padding-top: 16px;
  padding-right: 20px;
  padding-bottom: 0px;
  padding-left: 0px;
}

@media (max-width: 1024px) {
  .contact_us_green .responsive-container-block.container {
    justify-content: center;
  }

  .contact_us_green .text-blk.contactus-subhead {
    max-width: 90%;
  }

  .contact_us_green .head-text-box {
    display: block;
  }

  .contact_us_green .responsive-cell-block.wk-tab-12.wk-mobile-12.wk-desk-7.wk-ipadp-10.line {
    padding-top: 0px;
    padding-right: 20px;
    padding-bottom: 60px;
    padding-left: 0px;
  }

  .contact_us_green .line {
    border-right-width: initial;
    border-right-style: none;
    border-right-color: initial;
    border-bottom-width: 1.8px;
    border-bottom-style: solid;
    border-bottom-color: #a2a2a2;
  }

  .contact_us_green .responsive-cell-block.wk-tab-12.wk-mobile-12.wk-desk-5.wk-ipadp-10 {
    margin-top: 60px;
    margin-right: 0px;
    margin-bottom: 0px;
    margin-left: 0px;
  }

  .contact_us_green .workik-contact-bigbox {
    display: flex;
  }

  .contact_us_green .responsive-cell-block.wk-tab-12.wk-mobile-12.wk-desk-5.wk-ipadp-10 {
    padding-top: 0px;
    padding-right: 0px;
    padding-bottom: 0px;
    padding-left: 0px;
  }
}

@media (max-width: 768px) {
  .contact_us_green .text-content {
    display: none;
  }

  .contact_us_green .input {
    width: 100%;
  }

  .contact_us_green .textinput {
    width: 100%;
  }

  .contact_us_green .text-blk.contactus-head {
    font-size: 30px;
  }
}

@media (max-width: 500px) {
  .contact_us_green .responsive-container-block.big-container {
    padding-top: 0px;
    padding-right: 20px;
    padding-bottom: 0px;
    padding-left: 20px;
  }

  .contact_us_green .workik-contact-bigbox {
    display: block;
  }

  .contact_us_green .text-blk.input-title {
    font-size: 16px;
  }

  .contact_us_green .text-blk.contactus-head {
    font-size: 26px;
  }

  .contact_us_green .text-blk.contactus-subhead {
    font-size: 16px;
    line-height: 23px;
  }

  .contact_us_green .input {
    height: 45px;
  }

  .contact_us_green .responsive-cell-block.wk-ipadp-6.wk-tab-12.wk-mobile-12.wk-desk-6 {
    margin: 0 0 25px 0;
  }
}

*,
*:before,
*:after {
  -moz-box-sizing: border-box;
  -webkit-box-sizing: border-box;
  box-sizing: border-box;
}

body {
  margin: 0;
}

.wk-desk-1 {
  width: 8.333333%;
}

.wk-desk-2 {
  width: 16.666667%;
}

.wk-desk-3 {
  width: 25%;
}

.wk-desk-4 {
  width: 33.333333%;
}

.wk-desk-5 {
  width: 41.666667%;
}

.wk-desk-6 {
  width: 50%;
}

.wk-desk-7 {
  width: 52.333333%;
}

.wk-desk-8 {
  width: 66.666667%;
}

.wk-desk-9 {
  width: 75%;
}

.wk-desk-10 {
  width: 83.333333%;
}

.wk-desk-11 {
  width: 91.666667%;
}

.wk-desk-12 {
  width: 100%;
}

@media (max-width: 1024px) {
  .wk-ipadp-1 {
    width: 8.333333%;
  }

  .wk-ipadp-2 {
    width: 16.666667%;
  }

  .wk-ipadp-3 {
    width: 25%;
  }

  .wk-ipadp-4 {
    width: 33.333333%;
  }

  .wk-ipadp-5 {
    width: 41.666667%;
  }

  .wk-ipadp-6 {
    width: 50%;
  }

  .wk-ipadp-7 {
    width: 58.333333%;
  }

  .wk-ipadp-8 {
    width: 66.666667%;
  }

  .wk-ipadp-9 {
    width: 75%;
  }

  .wk-ipadp-10 {
    width: 83.333333%;
  }

  .wk-ipadp-11 {
    width: 91.666667%;
  }

  .wk-ipadp-12 {
    width: 100%;
  }
}

@media (max-width: 768px) {
  .wk-tab-1 {
    width: 8.333333%;
  }

  .wk-tab-2 {
    width: 16.666667%;
  }

  .wk-tab-3 {
    width: 25%;
  }

  .wk-tab-4 {
    width: 33.333333%;
  }

  .wk-tab-5 {
    width: 41.666667%;
  }

  .wk-tab-6 {
    width: 50%;
  }

  .wk-tab-7 {
    width: 58.333333%;
  }

  .wk-tab-8 {
    width: 66.666667%;
  }

  .wk-tab-9 {
    width: 75%;
  }

  .wk-tab-10 {
    width: 83.333333%;
  }

  .wk-tab-11 {
    width: 91.666667%;
  }

  .wk-tab-12 {
    width: 100%;
  }
}

@media (max-width: 500px) {
  .wk-mobile-1 {
    width: 8.333333%;
  }

  .wk-mobile-2 {
    width: 16.666667%;
  }

  .wk-mobile-3 {
    width: 25%;
  }

  .wk-mobile-4 {
    width: 33.333333%;
  }

  .wk-mobile-5 {
    width: 41.666667%;
  }

  .wk-mobile-6 {
    width: 50%;
  }

  .wk-mobile-7 {
    width: 58.333333%;
  }

  .wk-mobile-8 {
    width: 66.666667%;
  }

  .wk-mobile-9 {
    width: 75%;
  }

  .wk-mobile-10 {
    width: 83.333333%;
  }

  .wk-mobile-11 {
    width: 91.666667%;
  }

  .wk-mobile-12 {
    width: 100%;
  }
}

    </style>
    </head>

    <body>
 <!-- Navbar & Hero Start -->
 <div class="container-fluid nav-bar px-0 px-lg-4 py-lg-0">
      <div class="container">
      <?php require_once 'header.php'?>

      </div>
    </div>
    <!-- Navbar & Hero End -->
      

        <!-- Header Start -->
        <div class="container-fluid bg-breadcrumb">
            <div class="container text-center py-5" style="max-width: 900px;">
                <h4 class="text-white display-4 mb-4 wow fadeInDown" data-wow-delay="0.1s">CONTACT US</h4>

            </div>
        </div>
        <!-- Header End -->
<!-- Service Start -->

<div class="contact_us_green">
  <div class="responsive-container-block big-container">
    <div class="responsive-container-block container">
      <div class="responsive-cell-block wk-tab-12 wk-mobile-12 wk-desk-7 wk-ipadp-10 line" id="i69b-2">
        <!-- Form with method POST and correct action -->
        <form method="post" action="../../Controller/contact_con.php">
          <div class="container-block form-wrapper">
            <div class="head-text-box">
              <p class="text-blk contactus-head">Contact us</p>
              <p class="text-blk contactus-subhead">
                We welcome your feedback, suggestions, and inquiries about our church services, events, and sacraments. 
                Whether you’re looking for information on mass schedules, weddings, baptisms, or other religious ceremonies, 
                feel free to reach out.
                <br><br>
                You can contact us using the details below or fill out the contact form, and we’ll get back to you as soon as possible.
              </p>
            </div>
            <div class="responsive-container-block">
              <div class="responsive-cell-block wk-ipadp-6 wk-tab-12 wk-mobile-12 wk-desk-6" id="i10mt-6">
                <p class="text-blk input-title">FIRST NAME</p>
                <input class="input" id="ijowk-6" name="FirstName" placeholder="Enter your first name" required>
              </div>
              <div class="responsive-cell-block wk-desk-6 wk-ipadp-6 wk-tab-12 wk-mobile-12">
                <p class="text-blk input-title">LAST NAME</p>
                <input class="input" id="indfi-4" name="LastName" placeholder="Enter your last name" required>
              </div>
              <div class="responsive-cell-block wk-desk-6 wk-ipadp-6 wk-tab-12 wk-mobile-12" style="display:none;">
    <p class="text-blk input-title">EMAIL</p>
    <input class="input" id="ipmgh-6" name="Email" placeholder="example@gmail.com" required value="<?php echo isset($_SESSION['email']) ? $_SESSION['email'] : ''; ?>">
</div>

              <div class="responsive-cell-block wk-desk-6 wk-ipadp-6 wk-tab-12 wk-mobile-12">
                <p class="text-blk input-title">PHONE NUMBER</p>
                <input class="input" id="imgis-5" name="PhoneNumber" placeholder="09123456789" required>
              </div>
              <div class="responsive-cell-block wk-tab-12 wk-mobile-12 wk-desk-12 wk-ipadp-12" id="i634i-6">
                <p class="text-blk input-title">WHAT DO YOU HAVE IN MIND</p>
                <textarea class="textinput" id="i5vyy-6" name="Message" placeholder="Type your message here..." required></textarea>
              </div>
            </div>
            <div class="btn-wrapper">
              <button type="submit">Send Message</button>
            </div>
          </div>
        </form>
      </div>
      <div class="responsive-cell-block wk-tab-12 wk-mobile-12 wk-desk-5 wk-ipadp-10" id="ifgi">
        <div class="container-box">
          <div class="text-content">
            <p class="text-blk contactus-head">
              Contact us
            </p>
            <p class="text-blk contactus-subhead">
            We welcome your feedback, suggestions, and inquiries about our church services, events, and sacraments. Whether you’re looking for information on mass schedules, weddings, baptisms, or other religious ceremonies, feel free to reach out.  <br> <br>
            You can contact us using the details below or fill out the contact form, and we’ll get back to you as soon as possible.          </p>
           
          </div>
          <div class="workik-contact-bigbox">
            <div class="workik-contact-box">
              <div class="phone text-box">
              <i class="fas fa-map-marker-alt fa-2x" style="color: green;font-size: 2rem;padding-right: 20px;"></i>
              <p class="contact-text">
                (032) 367 7442
                </p>
              </div>
              <div class="address text-box">
              <i class="fa fa-phone-alt fa-2x" style="color: darkblue;font-size: 2rem;padding-right: 20px;"></i>
              <p class="contact-text">
                argaoparishchurchcebu@gmail.com
                            </p>
              </div>
              <div class="mail text-box">
              <i class="fas fa-envelope fa-2x" style="color: red;font-size: 2rem;padding-right: 20px;"></i>
              <p class="contact-text">
                Poblacion, Argao, Cebu
                </p>
              </div>
            </div>
           
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

    <?php require_once 'footer.php'?>



        <!-- Back to Top -->
        <a href="#" class="btn btn-primary btn-lg-square rounded-circle back-to-top"><i class="fa fa-arrow-up"></i></a>   
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
        <script>
                      document.addEventListener('DOMContentLoaded', function() {
    <?php
    if (isset($_SESSION['status']) && $_SESSION['status'] == 'success') {
      echo "Swal.fire({
        icon: 'success',
        title: 'Contact Form Submitted Successfully!',
        text: 'Your message has been sent. You will be notified once it is reviewed.',
    });";
    
        unset($_SESSION['status']);
    }
    ?>
});
    var acc = document.getElementsByClassName("accordion");
    var i;

    for (i = 0; i < acc.length; i++) {
        acc[i].addEventListener("click", function() {
            this.classList.toggle("active");
            var panel = this.nextElementSibling;
            if (panel.style.display === "block") {
                panel.style.display = "none";
            } else {
                panel.style.display = "block";
            }
        });
    }
</script>
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