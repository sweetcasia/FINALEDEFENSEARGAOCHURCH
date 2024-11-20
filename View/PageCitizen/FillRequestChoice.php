<?php
require_once '../../Model/db_connection.php';
require_once '../../Controller/citizen_con.php';
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
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>ARGAO CHURCH MANAGEMENT SYSTEM</title>
    <meta
      content="width=device-width, initial-scale=1.0, shrink-to-fit=no"
      name="viewport"
    />
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
           .text-center p{
    color:#3b3b3b; text-align: justify; text-justify: inter-word;  line-height: 1.6; margin-top: 10px; margin-left: 10px;
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
        .bg-breadcrumb {
  position: relative;
  overflow: hidden;
  background: linear-gradient(rgba(1, 94, 201, 0.616), rgba(0, 0, 0, 0.2)),
  url(../assets/img/baptismal1.jpg);
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
    font-size: 1rem; /* Base font size for text */
    line-height: 1.6; /* Improved line spacing */
    text-indent: 1rem; /* Indent the first line */
    margin-bottom: 10px; /* Space between paragraphs */
    font-weight: 500;
}
/* Responsive Design */
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
                <h4 class="text-white display-4 mb-4 wow fadeInDown" data-wow-delay="0.1s">REQUEST OF MASSES</h4>
                  
            </div>
        </div>
        <!-- Header End -->
<!-- Service Start -->


<div class="container-fluid service py-5">
  
        <div class="container py-5" style="padding-top:0!important;">
        
        <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.2s">
        <div class="gallery">
            
            <img src="../assets/img/req2.jpg" alt="Etymology Image" class="float-right"> 
            <img src="../assets/img/req3.jpg" alt="Etymology Image" class="float-right">
            <img src="../assets/img/req4.jpg" alt="Etymology Image" class="float-right">
            <img src="../assets/img/eucha1.jpg" alt="Etymology Image" class="float-right">
            </div>
         
            <P style="">Welcome to the Request of Masses page of the Argao Parish Church, Cebu. Here, we offer you the opportunity to request Masses for various occasions, both inside and outside our church, allowing you to celebrate special events in a way that best suits your needs. Whether you wish to mark a joyous occasion or need the comfort of prayer during a time of mourning, we are here to help facilitate your spiritual needs. This page will guide you through the process of requesting Masses for various services, ensuring that you can celebrate and commemorate your significant moments with our faith community.
</P>
            

        </div>
        <div class="baptismalreq">
        <h5 style="font-weight: BOLDER; padding-left:10px;">CHOOSE YOUR REQUEST TYPE

</h5>
        <br>

        <h5 style="font-weight: BOLDER; padding-left:10px;">  &ensp;&ensp;Inside Request Form
            <br><br>
       <p >For Masses to be held within the sacred walls of the Argao Parish Church, this option is for individuals or groups who wish to request a Mass to be celebrated within the church premises. This includes all types of Masses such as regular Sunday Masses, special feasts, and seasonal liturgies. The Argao Parish Church, with its beautiful ambiance and rich tradition, serves as a central place for community gatherings, and we are honored to host your special Masses. Whether it's for a wedding, a baptism, a special prayer intention, or simply a spiritual reflection, this form is intended for events within our church, where the congregation can gather in prayer and worship.
</p>
&ensp;&ensp;<a style="font-size:15px;" href="FillScheduleForm.php?type=RequestForm" class="btn btn-primary  py-2 px-4" role="button">
    Inside Request Form
</a>

    <BR></BR>
<br>
<h5 style="font-weight: BOLDER; padding-left:10px;">  &ensp;&ensp;Outside Request Form
    <br><br>
       <p >This form is intended for those who wish to request a Mass to be held outside the Argao Parish Church, whether it be in homes, community gatherings, or at other locations within the parish area. Many of our parishioners seek to hold Masses at significant locations such as private residences, at a hospital for the sick, or even in cemeteries for the dearly departed. These Masses are equally important in our faith and allow us to bring the church’s presence and blessings wherever they are needed most. By choosing this form, you are ensuring that your requested Mass will be celebrated in a location outside of the church, bringing the sacredness of the liturgy to your chosen site.
 
</p>
&ensp;&ensp;<a style="font-size:15px;" href="FillRequestSchedule.php?type=RequestForm" class="btn btn-primary  py-2 px-4" role="button">
    Outside Request Form
</a>
<BR></BR>
<br>
<h5 style="font-weight: BOLDER; padding-left:10px;">  &ensp;&ensp;Special Request Form
    <br><br>
       <p >Special Request Formarry profound cultural and spiritual significance, with celebrations that frequently reach beyond church walls and involve the wider community. Among the most beloved of these is the Mass of Thanksgiving and Soul & Petition, cherished for its expressions of gratitude and requests for blessings, drawing people together in communal prayer and devotion.
 
</p>
&ensp;&ensp;<a style="font-size:15px;" href="FillRequestScheduleForm.php" class="btn btn-primary  py-2 px-4" role="button">
Special Request Form
</a>
</div>

<BR>
<br>    
<div class="baptismalreq">
        <h5 style="font-weight: BOLDER; padding-left:10px;">AVAILABLE MASSES:</h5>
        <br>
        <P>&ensp;&ensp;1.  &nbsp;
       <STRong> Fiesta Mass: </STRong>Celebrate the feast of the patron saint with a special Mass.</P>
        <P>&ensp;&ensp;2. &nbsp;
       <strong>Novena Mass:</strong>  A series of prayers and Masses leading up to a significant feast or event.</P>
        <P>&ensp;&ensp;3.&nbsp;
        <strong> Wake Mass:</strong> A Mass offered in remembrance of the deceased.</P>
        <P>&ensp;&ensp;4.&nbsp;
        <strong>Monthly Mass:</strong>  A recurring Mass held once every month for various intentions.</P>
        <P>&ensp;&ensp;5.&nbsp;
        <strong>1st Friday Mass:</strong>  A special Mass offered on the first Friday of each month.</P>
        <P>&ensp;&ensp;6.&nbsp;
        <strong>Cemetery Chapel Mass:</strong>  A Mass held at the cemetery chapel for the souls of the departed.</P>
        <P>&ensp;&ensp;7.&nbsp;
        <strong>Baccalaureate Mass:</strong>  A Mass celebrated in honor of graduates as they mark a significant milestone.</P>
        <P>&ensp;&ensp;8.&nbsp;
        <strong>Anointing of the Sick:</strong> A Mass and sacrament offering healing prayers for those in need.</P>
        <P>&ensp;&ensp;9.&nbsp;
        <strong> Blessing:</strong> A special Mass to invoke blessings for a home, event, or individual.</P>
        <P>&ensp;&ensp;10.&nbsp;
        <strong>Special Mass:</strong>  Custom Masses offered for unique occasions or intentions.</P>
     
      
        
    

</div>
<BR>
<br>



        </div>
    </div>


    <?php require_once 'footer.php'?>

<script>
    
function validateForm() {
    let isValid = true; 

    // Helper function to validate field
    function validateField(id, errorId, message) {
        const field = document.getElementById(id);
        const value = field.value.trim();
        if (value === '') {
            document.getElementById(errorId).innerText = message;
            field.classList.add('error');
            isValid = false;
        } else {
            document.getElementById(errorId).innerText = '';
            field.classList.remove('error');
        }
    }

    // Clear previous error messages and styles
    document.querySelectorAll('.error').forEach(e => e.innerHTML = '');
    document.querySelectorAll('.form-control').forEach(e => e.classList.remove('error'));

    // Validate fields
    validateField('firstname', 'firstnameError', 'Firstname is required');
    validateField('lastname', 'lastnameError', 'Lastname is required');
    validateField('address', 'addressError', 'Address is required');
    validateField('religion', 'religionError', 'Religion is required');
    validateField('pbirth', 'pbirthError', 'Place of Birth is required');
    validateField('father_name', 'fatherNameError', 'Father\'s Fullname is required');
    validateField('mother_name', 'motherNameError', 'Mother\'s Fullname is required');
    validateField('parents_residence', 'parentsResidenceError', 'Parents Residence is required');
    validateField('godparents', 'godparentsError', 'List Of Godparents is required');
    validateField('date', 'dateError', 'Date is required');
    validateField('start_time', 'startTimeError', 'Start Time is required');
    validateField('end_time', 'endTimeError', 'End Time is required');

    // Validate gender
    const gender = document.querySelector('input[name="gender"]:checked');
    if (!gender) {
        document.getElementById('genderError').innerText = 'Gender is required';
        document.querySelector('input[name="gender"]').classList.add('error');
        isValid = false;
    } else {
        document.getElementById('genderError').innerText = '';
        document.querySelector('input[name="gender"]').classList.remove('error');
    }

    // Validate date of birth
    const month = document.getElementById('months').value;
    const day = document.getElementById('days').value;
    const year = document.getElementById('years').value;
    if (month === '' || day === '' || year === '') {
        document.getElementById('dobError').innerText = 'Date of birth is required';
        isValid = false;
    } else {
        document.getElementById('dobError').innerText = '';
    }

    // Check if the form is valid
    if (!isValid) {
        console.log('Validation failed, form not submitted.');
        return false;  // Prevent form submission
    }

    console.log('Validation passed, form will be submitted.');
    return true;  // Allow form submission
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
