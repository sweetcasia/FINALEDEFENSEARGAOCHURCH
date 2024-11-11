<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>ARGAO CHURCH MANAGEMENT SYSTEM</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <link rel="icon" href="../assets/img/mainlogo.jpg" type="image/x-icon" />

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;700&family=Inter:wght@400;700&display=swap" rel="stylesheet" />
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
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
    />
 <!-- CSS Files -->
 <link rel="stylesheet" href="../assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="../assets/css/plugins.min.css" />
    <link rel="stylesheet" href="../assets/css/kaiadmin.min.css" />

    <!-- Bootstrap CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet" />
    <link href="css/style.css" rel="stylesheet" />
    <link rel="stylesheet" href="css/rating.css">

    <style>
          .navbar .dropdown-menu {
    background-color: white!important;
}
.dropdown-menu[data-bs-popper] {
    top: 100%;
    left: 99px!important;
    margin-top: .125rem;
}
        .navbar .nav-link {
            position: relative;
            color: white;
            text-decoration: none;
            transition: all 0.3s ease;
            z-index: 1000;
        }

        .navbar .nav-link:after {
            position: absolute;
            bottom: -2px;
            left: 0;
            right: 0;
            margin: auto;
            width: 0%;
            content: '';
            background: white;
            height: 4px;
            transition: width 0.5s ease, opacity 0.9s ease;
            opacity: 0;
            z-index: -1;
        }

        .navbar .nav-link:hover,
        .navbar .nav-link.active {
            color: white;
        }

        .navbar .nav-link:hover:after,
        .navbar .nav-link.active:after {
            width: 100%;
            opacity: 1;
            z-index: 1;
        }

        .navbar .dropdown-menu {
            background-color: black;
        }.dropdown-menu {
    z-index: 1050; /* Bootstrap dropdowns usually use a z-index of 1050 */
}
    </style>
</head>

<body>
<nav class="navbar navbar-expand-lg" style="    z-index: 1000;" >
    <div class="container-fluid">
        <a href="#" class="navbar-brand">
            <img style="max-height: 60px; transition: 0.5s;" src="assets/img/argaochurch.png" alt="Logo" />
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a href="citizenpage.php" class="nav-link">Home</a>
                </li>
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link" id="aboutDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        About Us
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="aboutDropdown">
                        <li><a href="history.php" class="dropdown-item">History</a></li>
                        <li><a href="architecture.php" class="dropdown-item">Architecture</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link" id="servicesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Services
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="servicesDropdown">
                        <li><a href="baptismal.php" class="dropdown-item">Baptismal</a></li>
                        <li><a href="Wedding.php" class="dropdown-item">Wedding</a></li>
                        <li><a href="Confirmation.php" class="dropdown-item">Confirmation</a></li>
                        <li><a href="Funeral.php" class="dropdown-item">Funeral</a></li>
                        <li><a href="FillRequestChoice.php" class="dropdown-item">Request of Masses</a></li>
                        <li><a href="eucharistic.php" class="dropdown-item">Eucharistic Masses</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="map.php" class="nav-link">Vicinity Map</a>
                </li>
                <li class="nav-item">
                    <a href="ContactUs.php" class="nav-link">Contact Us</a>
                </li>
            </ul>
            <div class="nav-btn px-3">
          <div class="dropdown">
            <a href="" id="form-open" class="btn btn-primary py-2 px-4 ms-3 flex-shrink-0 dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
              <?php echo htmlspecialchars($nme); ?>
            </a>
            <ul class="dropdown-menu" aria-labelledby="form-open">
                <li><a class="dropdown-item" href="profile.php">My Profile</a></li>
                <li><a class="dropdown-item" href="">My Appointment </a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="../../index.php?action=logout">Sign Out</a></li>
            </ul>
          </div>
        </div>
        </div>
    </div>
</nav>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const currentPath = window.location.pathname.split('/').pop();

        // Get all main nav links
        const navLinks = document.querySelectorAll('.navbar-nav .nav-link');
        navLinks.forEach(link => {
            // Check if link href matches the current path and add 'active' class if it does
            if (link.getAttribute('href').includes(currentPath)) {
                link.classList.add('active');
            }
        });

        // Check for dropdowns and their sub-links
        const dropdowns = document.querySelectorAll('.nav-item.dropdown');
        dropdowns.forEach(dropdown => {
            const subLinks = dropdown.querySelectorAll('.dropdown-item');
            subLinks.forEach(subLink => {
                // Add 'active' to dropdown parent if any sub-link matches the current path
                if (subLink.getAttribute('href').includes(currentPath)) {
                    dropdown.querySelector('.nav-link').classList.add('active');
                    subLink.classList.add('active'); // Optionally add active to the sub-link as well
                }
            });
        });

        // Close navbar on small screens after a link click
        navLinks.forEach(link => {
            link.addEventListener('click', () => {
                if (window.innerWidth < 992 && navbarCollapse.classList.contains('show')) {
                    navbarCollapse.classList.remove('show');
                }
            });
        });
    });
</script>
<script>
  const navLinks = document.querySelectorAll('.navbar-nav .nav-link');
const navbarCollapse = document.getElementById('navbarCollapse');

navLinks.forEach(link => {
    link.addEventListener('click', () => {
        if (window.innerWidth < 992 && navbarCollapse.classList.contains('show')) {
            navbarCollapse.classList.remove('show');
        }
    });
});

</script>
<script

      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"
      integrity="sha384-KyZXEAg3QhqLMpG8r+8auK+4szKfEFbpLHsTf7iJgD/+ub2oU"
      crossorigin="anonymous"
    ></script>
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
   
</body>
</html>
