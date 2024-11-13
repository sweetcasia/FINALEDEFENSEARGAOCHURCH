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
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>ARGAO CHURCH MANAGEMENT SYSTEM</title>
    <meta
      content="width=device-width, initial-scale=1.0, shrink-to-fit=no"
      name="viewport"
    />
    <link rel="icon" href="../assets/img/mainlogo.jpg" type="image/x-icon"
    />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
    />
    <!-- Fonts and icons -->
    <script src="assets/js/plugin/webfont/webfont.min.js"></script>
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

      const currentDate = new Date();
    let currentMonth = currentDate.getMonth();
    let currentYear = currentDate.getFullYear();
    let selectedDateElement = null;

    function moveDate(direction) {
        currentMonth += direction;
        if (currentMonth < 0) {
            currentMonth = 11;
            currentYear--;
        } else if (currentMonth > 11) {
            currentMonth = 0;
            currentYear++;
        }
        renderCalendar();
    }

    function renderCalendar() {
        const daysElement = document.getElementById('days');
        daysElement.innerHTML = '';

        const monthYearElement = document.getElementById('monthYear');
        const months = [
            'January', 'February', 'March', 'April', 'May', 'June',
            'July', 'August', 'September', 'October', 'November', 'December'
        ];

        monthYearElement.innerHTML = ${months[currentMonth]}<br><span style="font-size:18px">${currentYear}</span>;

        const firstDay = new Date(currentYear, currentMonth, 1).getDay();
        const daysInMonth = new Date(currentYear, currentMonth + 1, 0).getDate();

        const today = new Date();
        const isCurrentMonth = today.getFullYear() === currentYear && today.getMonth() === currentMonth;

        for (let i = 1; i < firstDay; i++) {
            daysElement.innerHTML += '<li></li>';
        }

        for (let i = 1; i <= daysInMonth; i++) {
            const dayElement = document.createElement('li');
            dayElement.textContent = i;

            const dayDate = new Date(currentYear, currentMonth, i);

            if (isCurrentMonth && i === today.getDate() && !selectedDateElement) {
                dayElement.classList.add('active');
                selectedDateElement = dayElement;
            }

            if (dayDate < today) {
                dayElement.classList.add('past');
            } else {
                dayElement.addEventListener('click', () => selectDate(dayElement));
            }

            daysElement.appendChild(dayElement);
        }
    }

    function selectDate(dayElement) {
        if (selectedDateElement) {
            selectedDateElement.classList.remove('active');
        }
        dayElement.classList.add('active');
        selectedDateElement = dayElement;
    }

    document.addEventListener('DOMContentLoaded', renderCalendar);
    </script>
       <style>
          .unavailable {
    color: grey; /* Grey out text for unavailable times */
    cursor: not-allowed; /* Change cursor to indicate not clickable */
    pointer-events: none; /* Prevent clicks */
    text-decoration: line-through; /* Optional: add a line-through for extra emphasis */
}
   .past {
    color: lightgray!important; /* Make past dates light gray */
}

.disabled {
    color: gray!important; /* Make disabled dates gray */
    cursor: no-drop; /* Change cursor to indicate not clickable */
}
   body {
            margin: 0;
            background-color: #f4f4f9;
        }

        .container-cal {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            width: 100%;
            max-width: 1200px;
            margin: 20px auto;
            padding: 10px;
            box-sizing: border-box;
        }

        /* Calendar and time selection containers */
        .calendar, .schedule {
            flex: 1;
            margin: 10px;
            padding: 20px;
        }

        /* Calendar specific styles */
        .calendar h3 {
            text-align: center;
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
        }
.month{
  width:100%;
}
        .month ul {
            display: flex;
            justify-content: space-between;
            padding: 0;
            list-style-type: none;
            margin: 0;
            padding-top: 10px;
    padding-bottom: 20px;
    padding-left: 20px;
    padding-right: 20px;

        }

        .month ul li {
            font-size: 18px;
            cursor: pointer;
            color: #333;
        }

        .weekdays, .days {
            list-style-type: none;
            padding: 0;
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 5px;
    margin-bottom: -10px;
 

        }

        .days li {
            padding: 10px;
            text-align: center;
            font-weight: bold;
            color: #555;
            border-radius: 5px;
            cursor: pointer;
           
        }
        .weekdays li {
    padding: 14px;
    text-align: center;
    font-weight: bold;
    color: #555;
    border-radius: 5px;
    cursor: pointer;}

        .days li.active, .days li.selected {
            background-color: #3498db;
            color: #fff;
           
        }

        /* Time selection styles */
        .time h3 {
            margin-bottom: 20px;
            font-size: 22px;
            color: #333;
            margin-left: 86px;
        }

       
    .time-options {
      display: flex;
    flex-direction: row;
    gap: 60px;
    margin-top: 5px;
    }
    .time-option {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .time-selection button {
        width: 50%;
        padding: 10px;
        cursor: pointer;
        border: none;
        border-radius: 4px;
        background-color: #007bff;
        color: white;
        transition: background-color 0.3s;
    }
    .time-selection button:hover {
        background-color: #0056b3;
    }
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .container-cal {
                flex-direction: column;
                align-items: center;
            }

            .calendar, .time{
              width: 100%;
       
            }

            .weekdays li, .days li {
                padding: 8px!important;
                font-size: 14px;
            }

            .time-options button {
                font-size: 14px;
                padding: 8px;
            }
            .form-group {
          margin:0;  
          }

        }
/* Style the radio button to be visible */
.styled-radio {
  width: 20px;
  height: 20px;
  accent-color: #007bff; /* Button color */
  cursor: pointer;
}


.radio-wrapper {
  display: flex;
  align-items: center;
  justify-content: flex-start;
}
.form-check-label.time-slot {
  width: 150px; /* Set a fixed width for the time column */
  text-align: left;
}
.form-check {
    display: flex;
    align-items: center;
}

/* Style the label with border and background */
.form-check-label {
  margin-left: 10px;
  font-size: 16px;
  cursor: pointer;
  color: #333;
 
  padding: 8px;  /* Padding for button-like appearance */
  border-radius: 4px;  /* Rounded corners */
  transition: background-color 0.3s ease, border-color 0.3s ease;
}



/* Hover effect for radio button */
.styled-radio:hover {
  border-color: #0056b3;
  box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
}

.form-check-label {
  margin-right: 10px; /* Space between label and h6 */
}

/* Style for the h6 element beside the label */
.time-status {
  font-size: 14px;
  margin-left: 20px; /* Ensure availability text is spaced properly */
  white-space: nowrap; /* Prevent the status text from wrapping */
  color: green;
  padding: 0;
  display: inline-block;
}
.form-check input{
  margin-top: 10px;
}
.col-sm-12{
  display:flex!important;
}


        /* Calendar container styling */
        .calendar-container {
            width: 100%; /* Use full width */
            max-width: 500px;
            background-color: #fff;
            border-radius: 10px;
            padding: 10px; /* Reduce padding for a more compact appearance */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: auto;
            height: 543px;
        }
.form-group{
  background:white;     width: 100%; /* Use full width */
            max-width: 500px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
           padding-left:100px!important;
            margin: auto;
            padding-bottom:23px!important;
            padding-right: 20px!important;
}
.form-check .form-group{
  margin-bottom: 0;
  padding: 0!important;
}
       .d-flex{
        display: flex;
    align-items: center;
    flex-wrap: wrap;
       }
    </style>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-KyZXEAg3QhqLMpG8r+Knujsl7/1L_dstPt3HV5HzF6Gvk/e3s4Wz6iJgD/+ub2oU"
      crossorigin="anonymous"
    />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
    />
    <!-- CSS Files -->
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="../assets/css/plugins.min.css" />
    <link rel="stylesheet" href="../assets/css/kaiadmin.min.css" />

    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link rel="stylesheet" href="../assets/css/demo.css" />
    <link rel="stylesheet" href="../assets/css/schedule.css" />
  </head>
  <body style="background: #9e9e9e47">
   <!-- Navbar & Hero Start -->
   <div class="container-fluid nav-bar px-0 px-lg-4 py-lg-0">
      <div class="container">
       
      <?php require_once 'header.php'?>

      </div>
    </div>    
    </div>
  </div>
  <form id="scheduleForm">
  <div class="container" style="height: 630px;
    margin-top: 35px;">
            <div class="col-sm-12">
                <div class="calendar-container bg-light rounded p-4" >
        <h3 style="padding-top: 20px;" class="fw-bold mb-3">Select Date</h3>
        <div class="month">
            <ul>
                <li class="prev" onclick="moveDate(-1)">&#10094;</li>
                <li id="monthYear">
                   <br>
                    <span style="font-size:18px">2024</span>
                </li>
                <li class="next" onclick="moveDate(1)">&#10095;</li>
              
            </ul>
        </div>

        <ul class="weekdays">
            <li>Su</li>
            <li>Mo</li>
            <li>Tue</li>
            <li>Wed</li>
            <li>Thu</li>
            <li>Fri</li>
            <li>Sat</li>
        </ul>

        <ul class="days" id="days">
            <!-- Days will be generated by JavaScript -->
        </ul>
    </div>


<div class="schedule">

<div class="time" style="display: flex; flex-direction: column;">

  <div  class="form-group" >
    
  <h3 style="padding-top: 20px; font-family: 'Public Sans', sans-serif;
  font-size: 1.75rem;
    line-height: 1.2;
    color: #0066a8; font-weight: 700 !important;" class="fw-bold mb-3">Select Time</h3>

<div class="d-flex">
     
     <div class="form-check">
      
     <input
         class="form-check-input styled-radio"
         type="radio"
         name="flexRadioDefault"
         id="flexRadioDefault1"
         value="8:30 AM - 9:30 AM"
       />
      
       <div class="radio-wrapper">
   <label
   style="padding-right: 23px;padding-left:11px;"

     class="form-check-label radio-label"
         for="timeSlot1"
       >
         8:30 AM - 9:30 AM
       </label>
    
         <h6  class="time-status"style="font-size: 14px; color: green; padding:0; margin: 0;"></h6>
         </div>
     </div>
   </div>
   <div class="d-flex">
    
     <div class="form-check">
       <input
         class="form-check-input styled-radio"
         type="radio"
         name="flexRadioDefault"
         id="flexRadioDefault2"
         value="10:00 AM - 11:30 AM"
        
       />
       <div class="radio-wrapper">
       <label
         class="form-check-label radio-label"
         for="timeSlot2"
       >
       10:00 AM - 11:00 AM
       </label>
    
     <h6 class="time-status" style="font-size: 14px; color: red; padding:0; margin: 0;" ></h6>
    
     </div>
   </div>
   </div>
   <div class="d-flex">
    
     <div class="form-check">
       <input
         class="form-check-input"
         type="radio"
         name="flexRadioDefault"
         id="flexRadioDefault6"
         value="11:30 AM - 12:30 PM"
                 />
                 <div class="radio-wrapper">
       <label
         class="form-check-label"
         for="timeSlot6"
       >
       11:30 AM - 12:30 PM
             </label>
       <label
       for="flexRadioDefault2"
     >
     <h6 class="time-status"  style="font-size: 14px; color: green; padding:0; margin: 0;"></h6>
     </label>
     </div>
     </div>
   </div>

   <div class="d-flex">
     <div class="form-check">
       <input
         class="form-check-input"
         type="radio"
         name="flexRadioDefault"
         id="flexRadioDefault4"
         value="1:30 PM - 2:30 PM"
       />
       <div class="radio-wrapper">
       <label
       style="padding-right:14px;padding-left:14px;"
         class="form-check-label"
         for="timeSlot4"
       >
       1:30 PM - 2:30 PM
       </label>
       <label
       for="flexRadioDefault2"
     >
     <h6 style="font-size: 14px; color: green; padding:0; margin: 0;"></h6>
     </label>
     </div>
   </div>
   </div>
   <div class="d-flex">
    
     <div class="form-check">
       <input
         class="form-check-input"
         type="radio"
         name="flexRadioDefault"
         id="flexRadioDefault5"
         value="3:00 PM - 4:00 PM"
       />
       <div class="radio-wrapper">

       <label
       style="padding-right:14px;padding-left:14px;"
         class="form-check-label"
         for="timeSlot5"
       >
         3:00 PM - 4:00 PM
       </label>
       <label
       for="flexRadioDefault2"
     >
     <h6 style="font-size: 14px; color: green; padding:0; margin: 0;"></h6>
     </label>
     </div>
   </div>
   </div>
   <div class="d-flex">
    
     <div class="form-check">
       <input
         class="form-check-input"
         type="radio"
         name="flexRadioDefault"
         id="flexRadioDefault6"
         value="3:30 PM - 4:30 PM"
       />
       <div class="radio-wrapper">

       <label
       style="padding-right:14px;padding-left:14px;"
         class="form-check-label"
         for="timeSlot6"
       >
         4:30 PM - 5:30 PM
       </label>
       <label
       for="flexRadioDefault2"
     >
     <h6 style="font-size: 14px; color: green; padding:0; margin: 0;"></h6>
     </label>
    
     </div>
     
   </div>
   </div>
   <button type="submit" id="submitBtn" style="background: #1572e8; border: none; width: 100px; margin-top: 20px; margin-left: auto;" class="btn btn-primary">Submit</button>

 </div>

</div>

</div>

</div>

</div>

</form>
<?php require_once 'footer.php'?>
  <!-- container -->
    <script src="../assets/js/calendar.js"></script>
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

    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"
      integrity="sha384-KyZXEAg3QhqLMpG8r+8auK+4szKfEFbpLHsTf7iJgD/+ub2oU"
      crossorigin="anonymous"
    ></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.js"></script>
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

    <!-- Sweet Alert -->
    <script src="../assets/js/plugin/sweetalert/sweetalert.min.js"></script>

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