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

        <!-- Icon Font Stylesheet -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
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
    body {
        font-family: 'Public Sans', sans-serif;
    }
    .text-center p {
        color: #3b3b3b;
        text-align: justify;
        text-justify: inter-word;
        line-height: 1.6;
        margin-top: 10px;
        margin-left: 10px;
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
    .back-button {
        float: right;
        margin-right: 110px;
        margin-top: 20px;
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
    .schedule {
        float: left;
        margin-left: 20px;
        padding: 10px;
        color: #3b3b3b;
        border: none;
        border-radius: 5px;
        text-decoration: none;
        font-size: 12px;
        transition: background-color 0.3s ease;
    }
    .schedule:hover {
        color: wheat !important;
    }
    .weddingreq i {
        font-size: 7px;
        margin-right: 15px;
        color: black;
    }
    .bg-breadcrumb {
        position: relative;
        overflow: hidden;
        background: linear-gradient(rgba(1, 94, 201, 0.616), rgba(0, 0, 0, 0.2)),
        url(../assets/img/wedding3.jpg);
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
    .baptismalreq p {
        font-size: 1rem;
        line-height: 1.6;
        text-indent: 1rem;
        margin-bottom: 10px;
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
      <?php require_once 'header.php'?>

      </div>
    </div>
    <!-- Navbar & Hero End -->
      

      <!-- Header Start -->
      <div class="container-fluid bg-breadcrumb">
            <div class="container text-center py-5" style="max-width: 900px;">
                <h4 class="text-white display-4 mb-4 wow fadeInDown" data-wow-delay="0.1s">WEDDING</h4>
               
            </div>
        </div>
        <!-- Header End -->
<!-- Service Start -->

<div class="container-fluid service py-5">
  
        <div class="container py-5" style="padding-top:0!important;">
        
        <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.2s">

          <div class="gallery">
            
          <img src="../assets/img/wedding4.jpg" alt="Etymology Image" class="float-right"> 
          <img src="../assets/img/wedding 1.jpg" alt="Etymology Image" class="float-right">
          <img src="../assets/img/wedding2.jpg" alt="Etymology Image" class="float-right">
          <img src="../assets/img/wedding3.jpg" alt="Etymology Image" class="float-right">
          </div>
            <P>The sacrament of matrimony is a sacred union that binds a man and a woman together in the presence of God and their community. Just like many other Catholic churches, the parish offers the sacrament of matrimony to eligible couples who are eager to embark on their journey as husband and wife.
</P>
            <P>Argao Church holds a special place in the hearts of many, often referred to as the "Argao Church" of Cebu. Much like the renowned Argao Church in Cebu, Argao Church is a sought-after location for couples seeking to join in holy matrimony. The church's popularity extends far and wide, attracting couples not only from various regions of the Philippines but also from overseas, including returning expatriates who choose to celebrate their weddings within its hallowed walls.
</P>
<p>This enduring appeal of Barasoain Church as a matrimonial venue underscores its significance as a place where couples come to profess their love and commitment to one another before God and their loved ones. The church's rich history and spiritual ambiance provide a truly remarkable backdrop for these joyous and sacred celebrations of love.

</p>

        </div>
        <div class="baptismalreq">
        <h5 style="font-weight: BOLDER; padding-left:10px;">REQUIREMENTS</h5>
        <br>

        <P>&ensp;&ensp;1.
        Book a reservation (preparation must be at least 1 month)</P>
        <P>&ensp;&ensp;2.
        Seminar (wait for text/email message for schedule)</P>
        <P>&ensp;&ensp;3.
        Baptismal Certificate (with annotation: "For Marriage Purposes")</P>
        <P>&ensp;&ensp;4. 
        Confirmation Certificate (with annotation: "For Marriage Purposes")</P>
        <P>&ensp;&ensp;5. 
        Wedding Banns for both parties</P>
        <P>&ensp;&ensp;6.
        Pre-Cana seminar (1st and 3rd Saturday of the month, 8:00 AM to 12:00 PM)</P>
        <P>&ensp;&ensp;7. 
        Marriage license (original and 3 copies of page 2; submit every Friday and Saturday only)</P>
        <P>&ensp;&ensp;8.
        Wedding invitation (write your email address and follow the format)</P>
        <P>&ensp;&ensp;9.
        Confession (any parish)</P>
        <P>&ensp;&ensp;10.
        Officiating priest / license (if needed)</P>
     
    
</div>
<BR>

<div class="baptismalreq">
        <h5 style="font-weight: BOLDER; padding-left:10px;">SCHEDULE ONLINE</h5>
        <br>

        &ensp;&ensp;   <a class="btn btn-primary  py-2 px-4" href="FillScheduleForm.php?type=Wedding">Schedule Now</a>
        
    
</div>
<BR>
<br>


<div class="baptismalreq">
        <h5 style="font-weight: BOLDER; padding-left:10px;">PROCEDURE IN APPLICATION FOR MARRIAGE
</h5>
       <br>
        <P>&ensp;&ensp;1. 
        Fill-up the application forms and submit them.        
        </p>
        <P>&ensp;&ensp;2. 
        Wait for the schedule of your Seminar (message will be sent through text/email message)        
        </p>
        <P>&ensp;&ensp;3. 
        After the interview, the marriage banns should be submitted to the couples' respective parishes.    
        </p>
        <P>&ensp;&ensp;4. 
        Furnish a copy of baptismal and confirmation certificates with annotation: "For Marriage Purposes"     
        </p>
        <P>&ensp;&ensp;6. 
        For those over the age of 25, apply and get a Certificate of No Marriage from the Philippine Statistics Authority     
        </p>
        <P>&ensp;&ensp;7. 
        After getting the Certificate of No Marriage, proceed to the city hall and apply for a Marriage License      
        </p>
        <P>&ensp;&ensp;8. 
        Attend the scheduled Pre-Cana seminar at the parish     
        </p>
        <P>&ensp;&ensp;9.
        Send the line-up of your wedding entourage using the format sent to your email address 
        </p>
        <P>&ensp;&ensp;10. 
        Settle the payments at the parish office 2 weeks before the wedding.      
        </p>
        <P>&ensp;&ensp;11.
        Go to Confession a day before the wedding.     
        </p>
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