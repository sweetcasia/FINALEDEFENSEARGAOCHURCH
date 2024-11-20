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

// Database and model setup
require_once '../../Model/db_connection.php';
require_once '../../Model/staff_mod.php';
$staff = new Staff($conn);

// Fetch announcements
$announcements = $staff->getAnnouncements();
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title>ARGAO CHURCH MANAGEMENT SYSTEM</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta content="" name="keywords" />
    <meta content="" name="description" />
    <link rel="icon" href="../assets/img/mainlogo.jpg" type="image/x-icon"
    />
    <link rel="stylesheet" href="assets/fontawesome/css/all.min.css">
 <!-- Google Web Fonts -->
 <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&family=Inter:slnt,wght@-10..0,100..900&display=swap"
    rel="stylesheet"
  />
  <link
    rel="stylesheet"
    href="https://unicons.iconscout.com/release/v4.0.0/css/line.css"
  />
  <!-- Icon Font Stylesheet -->
  <link
    rel="stylesheet"
    href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"
  />
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css"
    rel="stylesheet"
  />

  <!-- Libraries Stylesheet -->
  <link rel="stylesheet" href="View/PageLanding/lib/animate/animate.min.css" />
  <link href="View/PageLanding/lib/lightbox/css/lightbox.min.css" rel="stylesheet" />
  <link href="View/PageLanding/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet" />

  <!-- Customized Bootstrap Stylesheet -->
  <link href="View/PageLanding/css/bootstrap.min.css" rel="stylesheet" />

  <!-- Template Stylesheet -->
 
  
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
 <!-- Google Web Fonts -->
 <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;700&family=Inter:wght@400;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="assets/fontawesome/css/all.min.css">
<!-- CSS Files --> 

  <!-- Bootstrap CSS -->
  <link href="../PageLanding/css/style.css" rel="stylesheet" />


<style>
   .days li{
        padding: 20px!important;
      }
      
        p {
          color:#3b3b3b;
      }
   
@media (max-width: 1024px) {
    .faq-image {
        display: none; /* Hide the image on smaller screens */
    }
}


/* Default caret pointing down (closed state) */
.accordion-button::after {
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%230156b5'%3e%3cpath fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1-.708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/%3e%3c/svg%3e"); /* Downward arrow icon */
    transform: rotate(0deg); /* Default rotation for closed state */
    transition: transform 0.3s ease; /* Smooth rotation */
}



    .static-header {
      position: relative;
      width: 100%; /* Ensure it spans the width of the container */
      margin: 0 auto; /* Center within container */
      overflow: hidden; /* Prevent overflow */
      background-image: url('assets/img/cover.jpeg');
      background-size: cover; /* Ensures the image covers the entire area */
      background-position: center; /* Centers the image */
      background-repeat: no-repeat; /* Prevents tiling */
    }

    /* Image Styling */
    .static-header img {
      width: 100%; /* Makes it responsive */
      height: auto; /* Keeps the aspect ratio */
      display: block; /* Removes extra space below the image */
    }
   
    </style>
  </head>

  <body>
    <!-- Spinner End -->
    <section class="home">
      
        <!-- Signup From -->
     

    <!-- Navbar & Hero Start -->
    <div class="container-fluid nav-bar px-0 px-lg-4 py-lg-0">
      <div class="container">
       
      <?php require_once 'header.php'?>

      </div>
    </div>
    <!-- Navbar & Hero End -->
    
   
    <div class="static-header">
    <img src="assets/img/cover.jpeg" alt="Static Cover Image">
  </div>
    
</div>
<!-- Feature Start -->
<div class="container-fluid feature bg-light py-5">
    <div class="container py-5" style="padding-bottom: 0 !important;">
        <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.2s">
            <h4 class="welcome-title mb-4" style="font-weight: 700;">WELCOME TO THE PARISH OFFICIAL WEBSITE</h4>
            <p class="welcome-text mb-2" style="color:#3b3b3b; text-justify: inter-word;">
                The Archdiocesan Shrine of San Miguel Arcangel, also known as Argao Church, is a Roman Catholic church located in Argao, Cebu, Philippines. Established as a parish in 1703 under the Augustinian order, the church stands as a significant religious site in the region. Construction of the stone church began in 1734 and was completed in 1788, serving as a center of faith and devotion dedicated to Saint Michael the Archangel.
            </p>
        </div>
        <hr>
    </div>
</div>
<!-- Feature End -->

<div class="container-fluid faq-section bg-light py-5">
            <div class="container py-5"  style="padding-top: 0 !important;padding-top: 0 !important;">
                <div class="row g-5 ">
                    <div class="col-xl-6 wow fadeInLeft" data-wow-delay="0.2s">
                        <div class="h-100">
                            <div class="mb-5">
                                <h4 class="text-primary">Some Important details</h4>
                                <h1 class="display-6 mb-6">EVENTS CALENDAR</h1>
                            </div>
                            <div class="accordion" id="accordionExample">
                               
                                <p class="mb-0">
                                Welcome to the <span style="font-weight:700;">Argao Church Event Calendar!</span> Here, you can find a comprehensive schedule of all upcoming events, services, and special celebrations happening at the Archdiocesan Shrine of San Miguel Arcangel.
<br><br>
Stay informed about our regular mass schedules, religious ceremonies, community gatherings, and festive occasions. Whether you're looking to participate in a sacrament, join a special event, or simply plan your visit, our calendar provides all the details you need, including dates, times, and locations.
<br><br>
We invite you to check back regularly to stay updated on the vibrant life of our parish community. Join us in celebrating faith and togetherness!
          </p>
                         
                            </div>

                        </div>
                    </div>
                    <div class="col-xl-6 wow fadeInRight" data-wow-delay="0.4s" style="margin-top:3px;">
                    <div class="CalendarIndexContainer">
    <!-- About calendar -->
    <?php require_once 'Calendar.php'?>
    </div>
        <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; margin-right:10px; "></div>
    </div>
  

                    </div>
                </div>
                
            </div>
            
        </div>
        
        <!-- FAQs End -->
  <!-- Service Start -->
<div class="container-fluid service py-5">
<div class="container py-5" style="padding-top: 0 !important;padding-top: 0 !important;">
<div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.2s">
      <h1 class="display-6 mb-6" >WE PROVIDE BEST SERVICES</h1>
      <p class="mb-0" style="color:#3b3b3b; text-justify: inter-word;">
       Explore our comprehensive system for managing and scheduling various
            church events, masses, and services. From mass events and solo
            events to feast days and special occasions, we've got you covered.
            Discover how our system can help you stay connected with your faith
            community and deepen your relationship with God.
      </p>
    </div>
    <div class="row g-4 justify-content-center">
      <div class="col-md-4 wow fadeInUp" data-wow-delay="0.2s">
        <div class="service-item">
          <div class="service-img">
            <img src="img/baptism (1).jpg" class="img-fluid rounded-top w-100" alt="" />
          </div>
          <div class="service-content p-4">
            <div class="service-content-inner">
              <a href="baptismal.php" class="d-inline-block h4 mb-4"><span style="font-weight: bold">Baptism</span></a>
              <p class="mb-4">Baptism holds a significant role within the Christian faith as it formally welcomes a new member into the church... </p>
              <a class="btn btn-primary  py-2 px-4" href="Baptismal.php">
           See More
        </a>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4 wow fadeInUp" data-wow-delay="0.4s">
        <div class="service-item">
          <div class="service-img">
            <img src="img/confirmation.jpg" class="img-fluid rounded-top w-100" alt="" />
          </div>
          <div class="service-content p-4">
            <div class="service-content-inner">
              <a href="confirmation.php" class="d-inline-block h4 mb-4"><span style="font-weight: bold">Confirmation</span></a>
              <p class="mb-4">Confirmation holds a profound and essential place within the Christian faith, marking the deepening of a believer’s...</p>
              <a class="btn btn-primary  py-2 px-4" href="Confirmation.php">
                   See More
                </a>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4 wow fadeInUp" data-wow-delay="0.6s">
        <div class="service-item">
          <div class="service-img">
            <img src="img/wedding.jpg" class="img-fluid rounded-top w-100" alt="" />
          </div>
          <div class="service-content p-4">
            <div class="service-content-inner">
              <a href="wedding.php" class="d-inline-block h4 mb-4"><span style="font-weight: bold">Wedding</span></a>
              <p class="mb-4">The sacrament of matrimony is a sacred union that binds a man and a woman together in the presence of God...</p>
              <a class="btn btn-primary  py-2 px-4" href="Wedding.php">
                 See More
                </a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row g-4 justify-content-center mt-4">
      <div class="col-md-4 wow fadeInUp" data-wow-delay="0.8s">
        <div class="service-item">
          <div class="service-img">
            <img src="img/funeral.jpg" class="img-fluid rounded-top w-100" alt="" />
          </div>
          <div class="service-content p-4">
            <div class="service-content-inner">
              <a href="funeral.php" class="d-inline-block h4 mb-4"><span style="font-weight: bold">Funeral</span></a>
              <p class="mb-4">As a religious institution, the church plays a vital role in offering support and solace to the departed...</p>
              <a class="btn btn-primary  py-2 px-4" href="Funeral.php">
                    See More
                </a>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4 wow fadeInUp" data-wow-delay="0.8s">
        <div class="service-item">
          <div class="service-img">
            <img src="../assets/img/open-book-near-sea.jpg" class="img-fluid rounded-top w-100" alt="" />
          </div>
          <div class="service-content p-4">
            <div class="service-content-inner">
              <a href="fillrequestchoice.php" class="d-inline-block h4 mb-4"><span style="font-weight: bold">Request of Masses</span></a>
              <p class="mb-4">The Catholic Church, as an esteemed institution, upholds the tradition of conducting Eucharistic...</p>
              <a class="btn btn-primary  py-2 px-4" href="FillRequestChoice.php">See More</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Service End -->


     <!-- Testimonial Start -->
     <div class="container-fluid testimonial pb-5"style="padding-bottom: 0 !important;" >
      <div class="container pb-5" style="padding-bottom: 0 !important;">
        <div
          class="text-center mx-auto pb-5 wow fadeInUp"
          data-wow-delay="0.2s" >
          <h1 class="display-6 mb-6">ANNOUNCEMENT</h1>
          <p class="mb-0">
            Upcoming Events in the Church: Mark your calendars for our upcoming
            Mass Wedding, Mass Confirmation, Baptism Seminar, and First
            Communion. Registration is required for each event.
          </p>
        </div>
        <div
          class="owl-carousel testimonial-carousel wow fadeInUp"
          data-wow-delay="0.2s"
        >
<?php foreach ($announcements as $announcement): ?>
  <div class="testimonial-item bg-light rounded" style="background-color: #f2f5f9 !important;">
            <div class="row g-0">
              <div class="col-8 col-lg-8 col-xl-9">
                <div class="d-flex flex-column my-auto text-start p-4" style="align-items: baseline!important;">
                  <div style="color:black;" class="small">
                    <span class="fa fa-calendar text-primary"></span> 
                    Event Date: <?php 
       $date = htmlspecialchars(date('F j, Y', strtotime($announcement['schedule_date'])));
        $startTime = htmlspecialchars(date('g:i a', strtotime($announcement['schedule_start_time'])));
        $endTime = htmlspecialchars(date('g:i a', strtotime($announcement['schedule_end_time'])));
        echo "$date - $startTime - $endTime ";
        ?>
                    </div>
                    <div style="color:black;" class="small">
                    <span class="fa fa-calendar text-primary"></span> 
                    Seminar Date:  <?php 
       $date = htmlspecialchars(date('F j, Y', strtotime($announcement['seminar_date'])));
        $startTime = htmlspecialchars(date('g:i a', strtotime($announcement['seminar_start_time'])));
        $endTime = htmlspecialchars(date('g:i a', strtotime($announcement['seminar_end_time'])));
        echo "$date - $startTime - $endTime ";
        ?>
                    </div>

                    <h4  style="padding-top: 15px;padding-bottom:10px;" class="text-dark mb-0">
                        <?php echo htmlspecialchars($announcement['title']); ?>
                    </h4>
                    <p class="mb-0">
                        <?php echo htmlspecialchars($announcement['description']); ?>
                    </p>

                    <h4 class="text-dark mb-0" style="    font-size: larger;
    padding: 5px 0 15px;">
                        Capacity: <span class="capacity-count" data-capacity="<?php echo htmlspecialchars($announcement['capacity']); ?>">
                            <?php echo htmlspecialchars($announcement['capacity']); ?>
                        </span>
                    </h4>

                    <?php
                        // Determine the form link based on event type
                        $eventType = htmlspecialchars($announcement['event_type']);
                        $formLink = '#'; // Default link in case none match

                        // Set form link based on event type
                        switch ($eventType) {
                            case 'MassBaptism':
                                $formLink = 'MassFillBaptismForm.php';
                                break;
                            case 'MassConfirmation':
                                $formLink = 'MassFillConfirmationForm.php';
                                break;
                            case 'MassMarriage':
                                $formLink = 'MassFillWeddingForm.php';
                                break;
                            // Add more cases as needed for other event types
                        }

                        // Check if capacity is zero
                        if ($announcement['capacity'] > 0) {
                            // Show Register button if capacity is available
                            echo '<a href="' . $formLink . '?announcement_id=' . htmlspecialchars($announcement['announcement_id']) . '" class="btn btn-primary btn-rounded btn-sm register-btn" data-announcement-id="' . htmlspecialchars($announcement['announcement_id']) . '">Register Now</a>';
                        } else {
                            // Show Fully Booked message in red if capacity is zero
                            echo '<p class="text-danger"><strong>Fully Booked</strong></p>';
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>

</div> </div>
      </div>
    </div>
    <!-- Testimonial End -->
 <!-- FAQs Start -->
 <div class="container-fluid faq-section bg-light py-5" style="background-color:white!important;">
 <div class="container py-5">
        <div class="row g-5 align-items-center">
            <div class="col-xl-6 wow fadeInLeft" data-wow-delay="0.2s">
                <div class="h-100">
                    <div class="mb-5">
                        <h4 class="text-primary">Some Important FAQs</h4>
                        <h1 class="display-6 mb-6">Common Frequently Asked Questions</h1>
                    </div>
                    <div class="accordion" id="accordionExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne">
                                <button  class="accordion-button border-0" type="button" onclick="toggleAccordion('collapseOne', this)" aria-expanded="true" aria-controls="collapseOne">
                                    Q: What are the different services and programs offered by the church?
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                <div class="accordion-body rounded" style="color:#3b3b3b;">
                                    A: At Argao Church, we offer a range of services including regular mass schedules, sacramental preparation (e.g., baptism, marriage), religious education, and community outreach programs. You can find more details on our website or by contacting the church office.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed border-0" type="button" onclick="toggleAccordion('collapseTwo', this)" aria-expanded="false" aria-controls="collapseTwo">
                                    Q: How can I donate to Argao Church?
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                <div class="accordion-body" style="color:#3b3b3b;">
                                    A: Donations to Argao Church can be made in person at the church office. Please contact the office for details on how to make a donation.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingThree">
                                <button class="accordion-button collapsed border-0" type="button" onclick="toggleAccordion('collapseThree', this)" aria-expanded="false" aria-controls="collapseThree">
                                    Q: What should I do if I need to cancel or reschedule a booking or event at the church?
                                </button>
                            </h2>
                            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                <div class="accordion-body" style="color:#3b3b3b;">
                                    A: If you need to cancel or reschedule an event, please inform the church office as soon as possible. They will assist you with the necessary changes and provide guidance on next steps.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 wow fadeInRight" data-wow-delay="0.4s">
                <div style="position: relative; display: inline-block;">
                    <img src="assets/img/FAQ.png" class="faq-image" style="display: block; width: 100%; height: auto;" alt="FAQ">
                    <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-color: #0066a8; opacity: 0.4; pointer-events: none;"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- FAQs End -->

        <?php require_once 'footer.php'?>

    <!-- Back to Top -->
    <a href="#" class="btn btn-primary btn-lg-square rounded-circle back-to-top"
      ><i class="fa fa-arrow-up"></i
    ></a>
      <!-- JavaScript Libraries -->
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
    <!-- Include jQuery (required for Owl Carousel) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Include Owl Carousel JS -->
<script src="https://cdn.jsdelivr.net/npm/owl.carousel@2.3.4/dist/owl.carousel.min.js"></script>


        <script>
function toggleAccordion(collapseId, button) {
    // Get the collapse element by its ID
    const collapseElement = document.getElementById(collapseId);
    
    // Check if the collapse is already open or closed
    const isExpanded = button.getAttribute('aria-expanded') === 'true';
    
    // Toggle the expanded state for the button
    button.classList.toggle('collapsed', isExpanded);
    button.setAttribute('aria-expanded', !isExpanded);
    
    // Toggle the visibility of the collapse element
    collapseElement.classList.toggle('show', !isExpanded);
    
    // Close all other accordion items
    document.querySelectorAll('.accordion-button').forEach((btn) => {
        if (btn !== button) {
            const targetCollapse = document.getElementById(btn.getAttribute('aria-controls'));
            targetCollapse.classList.remove('show');
            btn.classList.add('collapsed');
            btn.setAttribute('aria-expanded', 'false');
        }
    });
}

</script>
    <script>
            document.addEventListener('DOMContentLoaded', function() {
    <?php
    if (isset($_SESSION['status']) && $_SESSION['status'] == 'success') {
        echo "Swal.fire({
            icon: 'success',
            title: 'Form submitted successfully!',
            text: 'Waiting for Approval.',
        });";
        unset($_SESSION['status']);
    }
    ?>
});
      const formOpenBtn = document.querySelector("#form-open"),
        home = document.querySelector(".home"),
        formContainer = document.querySelector(".form_container"),
        formCloseBtn = document.querySelector(".form_close"),
        signupBtn = document.querySelector("#signup"),
        loginBtn = document.querySelector("#login"),
        pwShowHide = document.querySelectorAll(".pw_hide");

      formOpenBtn.addEventListener("click", () => home.classList.add("show"));
      formCloseBtn.addEventListener("click", () =>
        home.classList.remove("show")
      );

      pwShowHide.forEach((icon) => {
        icon.addEventListener("click", () => {
          let getPwInput = icon.parentElement.querySelector("input");
          if (getPwInput.type === "password") {
            getPwInput.type = "text";
            icon.classList.replace("uil-eye-slash", "uil-eye");
          } else {
            getPwInput.type = "password";
            icon.classList.replace("uil-eye", "uil-eye-slash");
          }
        });
      });

      signupBtn.addEventListener("click", (e) => {
        e.preventDefault();
        formContainer.classList.add("active");
      });
      loginBtn.addEventListener("click", (e) => {
        e.preventDefault();
        formContainer.classList.remove("active");
      });
    </script>
     <script>
      const openModalButton = document.getElementById("open-modal");
      const modal = document.getElementById("modal");
      const closeModalButton = document.querySelector('.close');

openModalButton.addEventListener('click', () => {
    modal.style.display = 'flex';
});

closeModalButton.addEventListener('click', () => {
    modal.style.display = 'none';
});
      openModalButton.addEventListener("click", () => {
        modal.style.display = "block";
      });

      closeModalButton.addEventListener("click", () => {
        modal.style.display = "none";
      });
      const stars = document.querySelectorAll(".star");
      const rating = document.getElementById("rating");
      const reviewText = document.getElementById("review");
      const submitBtn = document.getElementById("submit");
      const reviewsContainer = document.getElementById("reviews");

      stars.forEach((star) => {
        star.addEventListener("click", () => {
          const value = parseInt(star.getAttribute("data-value"));
          rating.innerText = value;

          // Remove all existing classes from stars
          stars.forEach((s) =>
            s.classList.remove("one", "two", "three", "four", "five")
          );

          // Add the appropriate class to
          // each star based on the selected star's value
          stars.forEach((s, index) => {
            if (index < value) {
              s.classList.add(getStarColorClass(value));
            }
          });

          // Remove "selected" class from all stars
          stars.forEach((s) => s.classList.remove("selected"));
          // Add "selected" class to the clicked star
          star.classList.add("selected");
        });
      });

      submitBtn.addEventListener("click", () => {
        const review = reviewText.value;
        const userRating = parseInt(rating.innerText);

        if (!userRating || !review) {
          alert(
            "Please select a rating and provide a review before submitting."
          );
          return;
        }

        if (userRating > 0) {
          const reviewElement = document.createElement("div");
          reviewElement.classList.add("review");
          reviewElement.innerHTML = `<p><strong>Rating: ${userRating}/5</strong></p><p>${review}</p>`;
          reviewsContainer.appendChild(reviewElement);

          // Reset styles after submitting
          reviewText.value = "";
          rating.innerText = "0";
          stars.forEach((s) =>
            s.classList.remove(
              "one",
              "two",
              "three",
              "four",
              "five",
              "selected"
            )
          );
        }
      });

      function getStarColorClass(value) {
        switch (value) {
          case 1:
            return "one";
          case 2:
            return "two";
          case 3:
            return "three";
          case 4:
            return "four";
          case 5:
            return "five";
          default:
            return "";
        }
      }
    </script>
    <script>
function validateLoginForm() {
    var email = document.getElementById("email").value;
    var password = document.getElementById("password").value;
    var errorMessage = document.getElementById("error_message");
    
    if (email === "" || password === "") {
        errorMessage.textContent = "Please fill in both email and password.";
        return false;
    }
    errorMessage.textContent = "";
    return true;
}

</script>
  
    <!-- JavaScript Libraries -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../PageLanding/lib/wow/wow.min.js"></script>
    <script src="../PageLanding/lib/easing/easing.min.js"></script>
    <script src="../PageLanding/lib/waypoints/waypoints.min.js"></script>
    <script src="../PageLanding/lib/counterup/counterup.min.js"></script>
    <script src="../PageLanding/lib/lightbox/js/lightbox.min.js"></script>
    <script src="../PageLanding/lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Template Javascript -->
    <script src="../PageLanding/js/main.js"></script>
  </body>
</html>
