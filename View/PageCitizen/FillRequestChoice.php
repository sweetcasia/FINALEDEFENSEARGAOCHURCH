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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <!-- Fonts and icons -->
    <script src="assets/js/plugin/webfont/webfont.min.js"></script>
    <style>
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
      


      document.addEventListener('DOMContentLoaded', function() {
    const selectedDate = sessionStorage.getItem('selectedDate');
    const selectedTimeRange = sessionStorage.getItem('selectedTime');

    if (selectedDate) {
        document.getElementById('date').value = selectedDate;
    }

    if (selectedTimeRange) {
        const [startTime, endTime] = selectedTimeRange.split('-');
        document.getElementById('start_time').value = startTime;
        document.getElementById('end_time').value = endTime;
    }

    // Optionally, clear the session storage if you don't want to persist the data
  //   sessionStorage.removeItem('selectedDate');
   //  sessionStorage.removeItem('selectedTime');
});

document.addEventListener('DOMContentLoaded', function() {
    document.querySelector('.btn-info').addEventListener('click', function() {
        // Select all input and textarea fields within the form
        document.querySelectorAll('.form-control').forEach(function(element) {
            console.log('Clearing element:', element.id, element.type, element.value); // Debug info
            // Clear text inputs, textareas, and date inputs
            if (element.type === 'text' || element.tagName === 'TEXTAREA' || element.type === 'date') {
                if (element.id !== 'date' && element.id !== 'start_time' && element.id !== 'end_time') {
                    element.value = ''; // Clear the value
                }
            } else if (element.type === 'radio' || element.type === 'checkbox') {
                element.checked = false; // Uncheck radio and checkbox inputs
            }
        });
    });
});

document.getElementById('baptismForm').addEventListener('submit', function(event) {
    // Get the values of the first name, last name, and middle name
    var firstname = document.getElementById('firstname').value.trim();
    var lastname = document.getElementById('lastname').value.trim();
    var middlename = document.getElementById('middlename').value.trim();

    // Concatenate them into a full name
    var fullname = firstname + ' ' + middlename + ' ' + lastname;

    // Set the concatenated full name into the hidden fullname input
    document.getElementById('fullname').value = fullname;
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
   <STYle>
      .bg-breadcrumb {
  position: relative;
  overflow: hidden;
  background: linear-gradient(rgba(1, 94, 201, 0.616), rgba(0, 0, 0, 0.2)),
  url(../assets/img/funeral.jpeg);
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
   </STYle>
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
                <h4 class="text-white display-4 mb-4 wow fadeInDown" data-wow-delay="0.1s">REQUEST OF MASSES

</h4>
                  
            </div>
        </div>
        <!-- Header End -->
<!-- Service Start -->

<div class="container-fluid service py-5">
  
        <div class="container py-5" style="padding-top:0!important;">
        
        <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.2s">

          <div class="gallery">
            
         
          </div>
            <P style="TEXT-ALIGN: left;">Welcome to the Request of Masses page of the Argao Parish Church, Cebu. Here, we offer you the opportunity to request Masses for various occasions, both inside and outside our church, allowing you to celebrate special events in a way that best suits your needs. Whether you wish to mark a joyous occasion or need the comfort of prayer during a time of mourning, we are here to help facilitate your spiritual needs. This page will guide you through the process of requesting Masses for various services, ensuring that you can celebrate and commemorate your significant moments with our faith community.
</P>
            

        </div>
        <div class="baptismalreq">
        <h5 style="font-weight: BOLDER; padding-left:10px;">CHOOSE YOUR REQUEST TYPE

</h5>
        <br>

        <h5 style="font-weight: BOLDER; padding-left:10px;">Inside Request Form
            <br>
       <p style="font-weight: normal;">For Masses to be held within the sacred walls of the Argao Parish Church, this option is for individuals or groups who wish to request a Mass to be celebrated within the church premises. This includes all types of Masses such as regular Sunday Masses, special feasts, and seasonal liturgies. The Argao Parish Church, with its beautiful ambiance and rich tradition, serves as a central place for community gatherings, and we are honored to host your special Masses. Whether it's for a wedding, a baptism, a special prayer intention, or simply a spiritual reflection, this form is intended for events within our church, where the congregation can gather in prayer and worship.
</p>
<button  class="btn btn-primary btn-round" type="button" onclick="window.location.href='FillScheduleForm.php?type=RequestForm'">
       Inside Request Form
    </button>
    <BR></BR>
<br>

<h5 style="font-weight: BOLDER; padding-left:10px;">Outside Request Form
    <br>
       <p style="font-weight: normal;">This form is intended for those who wish to request a Mass to be held outside the Argao Parish Church, whether it be in homes, community gatherings, or at other locations within the parish area. Many of our parishioners seek to hold Masses at significant locations such as private residences, at a hospital for the sick, or even in cemeteries for the dearly departed. These Masses are equally important in our faith and allow us to bring the church’s presence and blessings wherever they are needed most. By choosing this form, you are ensuring that your requested Mass will be celebrated in a location outside of the church, bringing the sacredness of the liturgy to your chosen site.
 
</p>
<button  class="btn btn-primary btn-round" type="button" onclick="window.location.href='FillRequestSchedule.php?type=RequestForm'">
        Outside Request Form
    </button>
</div>

<br>
<BR>
<h5 style="font-weight: BOLDER; padding-left:10px;">Special Request Form
            <br>
       <p style="font-weight: normal;">Special Masses carry profound cultural and spiritual significance, with celebrations that frequently reach beyond church walls and involve the wider community. Among the most beloved of these is the Mass of Thanksgiving and Soul & Petition, cherished for its expressions of gratitude and requests for blessings, drawing people together in communal prayer and devotion.
</p>
<button  class="btn btn-primary btn-round" type="button" onclick="window.location.href='FillRequestScheduleForm.php'">
Special Request Form
    </button>
    <BR></BR>
<br>
<BR>
<br>
<div class="baptismalreq">
        <h5 style="font-weight: BOLDER; padding-left:10px;">AVAILABLE MASSES:</h5>
        <br>
        <P>1.  &nbsp;
       <STRong> Fiesta Mass: </STRong>Celebrate the feast of the patron saint with a special Mass.</P>
        <P>2. &nbsp;
       <strong>Novena Mass:</strong>  A series of prayers and Masses leading up to a significant feast or event.</P>
        <P>3.&nbsp;
        <strong> Wake Mass:</strong> A Mass offered in remembrance of the deceased.</P>
        <P>4.&nbsp;
        <strong>Monthly Mass:</strong>  A recurring Mass held once every month for various intentions.</P>
        <P>5.&nbsp;
        <strong>1st Friday Mass:</strong>  A special Mass offered on the first Friday of each month.</P>
        <P>6.&nbsp;
        <strong>Cemetery Chapel Mass:</strong>  A Mass held at the cemetery chapel for the souls of the departed.</P>
        <P>7.&nbsp;
        <strong>Baccalaureate Mass:</strong>  A Mass celebrated in honor of graduates as they mark a significant milestone.</P>
        <P>8.&nbsp;
        <strong>Anointing of the Sick:</strong> A Mass and sacrament offering healing prayers for those in need.</P>
        <P>9.&nbsp;
        <strong> Blessing:</strong> A special Mass to invoke blessings for a home, event, or individual.</P>
        <P>10.&nbsp;
        <strong>Special Request:</strong>  Custom Masses offered for unique occasions or intentions.</P>
     
      
        
    

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
        

        <!-- Template Javascript -->
        <script src="js/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"
        integrity="sha384-KyZXEAg3QhqLMpG8r+8auK+4szKfEFbpLHsTf7iJgD/+ub2oU" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.js"></script>
    <!--   Core JS Files   -->
    <script src="../assets/js/core/jquery-3.7.1.min.js"></script>
    <script src="../assets/js/core/popper.min.js"></script>
    <script src="../assets/js/core/bootstrap.min.js"></script>

    <!-- jQuery Scrollbar -->
    <script src="../assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>

  
    <!-- Kaiadmin JS -->
    <script src="../assets/js/kaiadmin.min.js"></script>

  
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
