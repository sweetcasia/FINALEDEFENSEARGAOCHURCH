<?php 
session_start();

// Prevent browser from caching the login page
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0"); // HTTP 1.1.
header("Pragma: no-cache"); // HTTP 1.0.
header("Expires: 0"); // Proxies.

// Check if the user wants to log out
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    // Destroy all session data to log the user out
    session_unset();
    session_destroy();
    
    // Redirect to login page after logout
    header("Location: ../../index.php");
    exit();
}

// Check if the user is already logged in
if (isset($_SESSION['email']) && isset($_SESSION['user_type'])) {
  // Retrieve user status from session or query it from the database, if necessary
  $userType = $_SESSION['user_type'];
  $r_status = $_SESSION['r_status']; // Assumes r_status is stored in session when logging in
  
  // Redirect based on user type and r_status
  switch ($userType) {
      case "Staff":
          if ($r_status === "Active") {
              header("Location: ../PageStaff/StaffDashboard.php");
              exit();
          }
          break;
      case "Citizen":
          if ($r_status === "Approved") {
              header("Location: ../PageCitizen/CitizenPage.php");
              exit();
          }
          break;
          case "Priest":
            if ($r_status === "Active") {
                header("Location: ../PagePriest/index.php");
                exit();
            }
            break;
            case "Admin":
                  header("Location: ../PageAdmin/AdminDashboard.php");
                  exit();
              
              break;
  }
}


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

        <!-- Icon Font Stylesheet -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

        <!-- Libraries Stylesheet -->
        <link rel="stylesheet" href="lib/animate/animate.min.css"/>
        <link href="lib/lightbox/css/lightbox.min.css" rel="stylesheet">
        <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">


        <!-- Customized Bootstrap Stylesheet -->
        <link href="css/bootstrap.min.css" rel="stylesheet">

        <!-- Template Stylesheet -->
        <link href="css/style.css" rel="stylesheet">
        <style>
           body{
                font-family: 'Public Sans', sans-serif;
            }
         .text-center p{
    color:#3b3b3b; text-align: justify; text-justify: inter-word;  line-height: 1.7; margin-top: 10px; margin-left: 10px;
}


        .gallery {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            margin-top: 2rem;
            margin-bottom: 3rem;
        }
        .gallery img {
            width: 40%;
            max-width: calc(25% - 1rem);
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }
     
        .schedule {
float:left;       
margin-LEFT:20px;  

            padding: 10px;
            color: #3b3b3b;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            font-size: 12PX;
            transition: background-color 0.3s ease;
        }
       
        .schedule:hover{
            color:wheat!important;
        }
        .baptismalreq i{
            font-size:7px;
            margin-right:15px;
            color:black;
        }
    
.mass-schedule {
    width: 45%;
    border-collapse: collapse;
    background-color: #f2f5f9;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    text-align: center;
    margin: 20px 0;
}

.mass-schedule th {
    background-color: #003366;
   
    padding: 12px;
    font-size: 1.1em;
    
}

.mass-schedule td, 
.mass-schedule th {
    border: 1px solid gray;
    padding: 10px;
    color: #3b3b3b;

}

.mass-schedule tbody tr:nth-child(even) {
    background-color:#f2f5f9;
}



.mass-schedule th[colspan="2"] {
    background-color: #f2f5f9;
    font-weight: bold;
    color: #3b3b3b;

}
.tableflex{
    display: flex;
    justify-content: space-between;
}
.bg-breadcrumb {
  position: relative;
  overflow: hidden;
  background: linear-gradient(rgba(1, 94, 201, 0.616), rgba(0, 0, 0, 0.2)),
  url(../assets/img/map.jpeg);
  background-position: center;
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
.map-container {
    position: relative;
    width: 100%; /* Full width */
    padding-bottom: 56.25%; /* Maintain 16:9 aspect ratio (height / width = 9/16 = 56.25%) */
    height: 0;
    overflow: hidden;
}

.map-container iframe {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    border: 0;
}

@media screen and (max-width: 1200px) {
        .accordion {
            font-size: 1.1rem;
        }

        .baptismalreq p {
            font-size: 15px;
        }

        .container-fluid.service.py-5{
        padding-top: 0.6rem !important;
        padding-bottom: 0!important;
       }

        .text-center h1 {
            font-size: 2rem;
        }
        .responsive-paragraph{
            font-size: 15px;

        }
    }

    @media screen and (max-width: 992px) {
        .panel img {
            width: 100%;
            max-width: 50%;
        }

       
        .text-center h1 {
            font-size: 1.8rem;
        }

        .accordion {
            font-size: 1rem;
        }

        .container.py-5 {
            padding: 20px;
        }
    }

    @media screen and (max-width: 768px) {
        .mass-schedule {
        max-width: 100%; /* Take full width on smaller screens */
    }
        .panel img {
            width: 100%;
            max-width: 80%;
        }

        .gallery img {
            max-width: 90%;
            margin-bottom: 20px;
        }

        .text-center h1 {
            font-size: 1.5rem;
        }

        .accordion {
            font-size: 1rem;
            padding: 0.8rem;
        }

        .back-button {
            font-size: 0.9rem;
        }

        .container.py-5 {
            padding: 15px;
        }
    }

    @media screen and (max-width: 576px) {
        .mass-schedule th, .mass-schedule td {
        font-size: 12px; /* Adjust font size for small screens */
        padding: 8px;
    }
        .panel img {
            width: 100%;
        }

        .gallery img {
            max-width: 100%;
            margin-bottom: 20px;
        }

        .accordion {
            font-size: 0.9rem;
            padding: 0.8rem;
        }

        .text-center h1 {
            font-size: 1.2rem;
        }

        .back-button {
            font-size: 0.8rem;
            margin-right: 50px;
        }
        @media screen and (max-width: 425px) {
            .bg-breadcrumb{
                padding:0;
            }
        .panel img {
            width: 100%;
        }

        .gallery img {
            max-width: 100%;
            margin-bottom: 20px;
        }

        .accordion {
            font-size: 0.9rem;
            padding: 0.8rem;
        }

        .text-center h1 {
            font-size: 1.2rem;
        }

        .back-button {
            font-size: 0.8rem;
            margin-right: 50px;
        }
        .text-center p {
            font-size: 12px;
        }
        .baptismalreq p{
            font-size: 12px;
        }
        .container-fluid.service.py-5{
        padding-top: 0.6rem !important;
        padding-bottom: 0!important;
       }

        .text-center h1 {
            font-size: 2rem;
        }
        .responsive-paragraph{
            font-size: 12px;

        }
        .gallery{
            margin-bottom:0!important;
        }
    }
}
    </style>
    </head>

    <body>
 <!-- Navbar & Hero Start -->
 <div class="container-fluid nav-bar px-0 px-lg-4 py-lg-0">
      <div class="container">
      <?php require_once 'navbar.php'?>

      </div>
    </div>
    <!-- Navbar & Hero End -->
      

        <!-- Header Start -->
        <div class="container-fluid bg-breadcrumb">
            <div class="container text-center py-5" style="max-width: 900px;">
                <h4 class="text-white display-4 mb-4 wow fadeInDown" data-wow-delay="0.1s">MAP</h4>
                
            </div>
        </div>
        <!-- Header End -->
<!-- Service Start -->

<div class="container-fluid service py-5"style="padding-bottom:0!important;" >
  
        <div class="container py-5" style="padding-top:30px!important;padding-bottom:0!important;">
        
        <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.2s">

         
            <P>Argao Church, officially known as the Archdiocesan Shrine and Parish of Saint Michael the Archangel, is a historical and cultural landmark located in the heart of Argao, Cebu. To visit this iconic church, you can easily find it along the main highway that runs through the town, approximately 68 kilometers south of Cebu City. If you’re traveling by car, the journey offers scenic views of coastal landscapes and lush greenery, taking about two hours from Cebu City via the South Road Properties (SRP) route. For those using public transportation, buses and vans heading towards Oslob or Dalaguete from Cebu City South Bus Terminal will drop you off near the church. Once you arrive in Argao, the church’s distinctive coral stone façade and towering belfry will guide you to its location, making it an unmissable destination for both spiritual reflection and appreciation of Cebu’s rich heritage."
</P>
         

<div class="card-body">
    <div class="map-container">
        <iframe 
            src="https://www.google.com/maps/embed?pb=!1m16!1m12!1m3!1d3930.622300315624!2d123.60556722560331!3d9.88202052505255!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!2m1!1sArchdiocesan%20Shrine%20and%20Parish%20of%20Saint%20Michael%20the%20Archangel%2C%20Argao%2C%20Cebu!5e0!3m2!1sen!2sph!4v1725941798155!5m2!1sen!2sph&z=20" 
            style="border: 0;" 
            allowfullscreen="" 
            loading="lazy" 
            referrerpolicy="no-referrer-when-downgrade">
        </iframe>
    </div>
</div>

        </div>
    </div>

    </div>
    </div>
    <?php require_once 'footer.php'?>



        <!-- Back to Top -->
        <a href="#" class="btn btn-primary btn-lg-square rounded-circle back-to-top"><i class="fa fa-arrow-up"></i></a>   

        <script>
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