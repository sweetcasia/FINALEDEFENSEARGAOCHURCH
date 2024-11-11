
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>ARGAO CHURCH MANAGEMENT SYSTEM</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <link rel="icon" href="../assets/img/mainlogo.jpg" type="image/x-icon" />

  
    <style>
         .navbar .nav-link {
    position: relative; /* Positioning for the pseudo-element */
    color: white; /* Ensure links are white */
    text-decoration: none; /* Remove default underline */
    transition: all 0.3s ease; /* Smooth transition for hover effects */
    z-index: 1000; /* Adjust this value if necessary */
}

.navbar .nav-link:after {
    position: absolute;
    bottom: -2px; /* Adjust this value for the default position */
    left: 0;
    right: 0;
    margin: auto;
    width: 0%; /* Start width */
    content: ''; /* Create the pseudo-element */
    background: white; /* Underline color */
    height: 4px; /* Adjust height as needed */
    transition: width 0.5s ease, opacity 0.9s ease; /* Transition for the width and opacity */
    opacity: 0; /* Start invisible */
    z-index: -1; /* Keep it behind the text */

}

.navbar .nav-link:hover {
    color:white; /* Change text color on hover */
  
}

.navbar .nav-link:hover:after,
    .navbar .nav-link.active:after {
        width: 100%;
        opacity: 1;
        z-index: 1;
    }

    .navbar .nav-link.active {
        color: white; /* Ensures active link text stays white */
    }


.navbar .dropdown-menu {
    background-color: black; /* Ensure dropdown has the same background */
}

    </style>
</head>

<body>
<nav class="navbar navbar-expand-lg">
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
                    <a href="../../index.php" class="nav-link">Home</a>
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
                        <li><a href="requestform.php" class="dropdown-item">Request of Masses</a></li>
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
            <div class="nav-btn"style="z-index:1000;">
                <a href="signin.php" class="btn btn-primary py-2 px-4" >Signin</a>
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
        const navbarCollapse = document.getElementById('navbarCollapse');
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
    // Collapse the navbar when a nav item is clicked
    const navLinks = document.querySelectorAll('.navbar-nav .nav-link');
    const navbarCollapse = document.getElementById('navbarCollapse');

    navLinks.forEach(link => {
        link.addEventListener('click', () => {
            if (navbarCollapse.classList.contains('show')) {
                navbarCollapse.classList.remove('show');
            }
        });
    });
</script>

<script src="lib/wow/wow.min.js"></script>
<script src="lib/easing/easing.min.js"></script>
<script src="lib/waypoints/waypoints.min.js"></script>
<script src="lib/counterup/counterup.min.js"></script>
<script src="lib/lightbox/js/lightbox.min.js"></script>
<script src="lib/owlcarousel/owl.carousel.min.js"></script>
<script src="js/main.js"></script>
</body>
</html>
