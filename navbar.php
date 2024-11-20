<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>ARGAO CHURCH MANAGEMENT SYSTEM</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <link rel="icon" href="View/assets/img/mainlogo.jpg" type="image/x-icon" />

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


/* Ensure dropdown is hidden by default */
.navbar .dropdown-menu {
    display: none; /* Hide the dropdown */
    position: absolute;
    background-color: white; /* Ensure background color */
    z-index: 1050; /* Ensure dropdown stays above other content */
}

.navbar .nav-item.dropdown .dropdown-menu {
    display: none; /* Ensure it's hidden by default */
}

.navbar .nav-item.dropdown.show .dropdown-menu {
    display: block; /* Show the dropdown when the 'show' class is added */
}

/* Optional: Add some spacing or padding for better dropdown appearance */
.navbar .dropdown-menu {
    margin-top: 0;
}
.navbar-toggler-icon {
    background-image: url("data:image/svg+xml;charset=utf8,%3Csvg viewBox='0 0 30 30' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath stroke='rgba%28255, 255, 255, 0.5%29' stroke-width='2' stroke-linecap='round' stroke-miterlimit='10' d='M4 7h22M4 15h22M4 23h22'/%3E%3C/svg%3E");
}
.navbar {
    position: relative;
    z-index: 1050;
}
.collapse {
    display: none;
    transition: height 0.3s ease;
}

.collapse.show {
    display: block;
}
.navbar-brand img {
        max-height:60px;
    }
@media (max-width: 576px) {
    .navbar-brand img {
        max-height: 45px;
    }
}



    </style>
</head>

<body>
<nav class="navbar navbar-expand-lg bg-light" style="z-index: 1000;">
        <div class="container-fluid">
            <!-- Brand Logo -->
            <a href="index.php" class="navbar-brand" aria-label="Homepage"> 
                <img src="View/assets/img/argaochurch.png" alt="Logo" />
            </a>
            <button 
        class="navbar-toggler" 
        type="button" 
        aria-controls="navbarCollapse" 
        aria-expanded="false" 
        aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse"> 
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <!-- Home Link -->
                    <li class="nav-item">
                        <a href="index.php" class="nav-link">Home</a>
                    </li>

                    <!-- About Us Dropdown -->
                    <li class="nav-item dropdown">
                        <a 
                            href="#" 
                            class="nav-link dropdown-toggle" 
                            id="aboutDropdown" 
                            role="button" 
                            data-bs-toggle="dropdown" 
                            aria-expanded="false">
                            About Us
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="aboutDropdown">
                            <li><a href="View/PageLanding/history.php" class="dropdown-item">History</a></li>
                            <li><a href="View/PageLanding/architecture.php" class="dropdown-item">Architecture</a></li>
                        </ul>
                    </li>

                    <!-- Services Dropdown -->
                    <li class="nav-item dropdown">
                        <a 
                            href="#" 
                            class="nav-link dropdown-toggle" 
                            id="servicesDropdown" 
                            role="button" 
                            data-bs-toggle="dropdown" 
                            aria-expanded="false">
                            Services
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="servicesDropdown">
                            <li><a href="View/PageLanding/baptismal.php" class="dropdown-item">Baptismal</a></li>
                            <li><a href="View/PageLanding/Wedding.php" class="dropdown-item">Wedding</a></li>
                            <li><a href="View/PageLanding/Confirmation.php" class="dropdown-item">Confirmation</a></li>
                            <li><a href="View/PageLanding/Funeral.php" class="dropdown-item">Funeral</a></li>
                            <li><a href="View/PageLanding/requestform.php" class="dropdown-item">Request of Masses</a></li>
                            <li><a href="View/PageLanding/eucharistic.php" class="dropdown-item">Eucharistic Masses</a></li>
                        </ul>
                    </li>

                    <!-- Vicinity Map -->
                    <li class="nav-item">
                        <a href="View/PageLanding/map.php" class="nav-link">Vicinity Map</a>
                    </li>

                  
                </ul>

                <!-- Signin Button -->
                <div class="nav-btn">
                    <a href="View/PageLanding/signin.php" class="btn btn-primary py-2 px-4">Signin</a>
                </div>
            </div>
        </div>
    </nav>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
   document.addEventListener("DOMContentLoaded", function () {
        const navbarToggler = document.querySelector(".navbar-toggler");
        const navbarCollapse = document.querySelector(".navbar-collapse");
        const dropdowns = document.querySelectorAll('.navbar .nav-item.dropdown');

        // Toggle the navbar collapse when the hamburger icon is clicked
        navbarToggler.addEventListener("click", function () {
            navbarCollapse.classList.toggle("show");
        });

        // Prevent dropdown from closing the navbar
        dropdowns.forEach(function (dropdown) {
            const toggle = dropdown.querySelector(".dropdown-toggle");

            toggle.addEventListener("click", function (e) {
                e.preventDefault();  // Prevent the default link behavior

                // Stop propagation to avoid collapsing navbar when clicking the dropdown
                e.stopPropagation();

                // Toggle the 'show' class to control visibility
                dropdown.classList.toggle("show");

                // Close other dropdowns when one is opened
                dropdowns.forEach(function (otherDropdown) {
                    if (otherDropdown !== dropdown) {
                        otherDropdown.classList.remove("show");
                    }
                });
            });
        });

        // Close the navbar if clicking outside of it
        document.addEventListener("click", function (e) {
            if (!navbarCollapse.contains(e.target) && !navbarToggler.contains(e.target)) {
                navbarCollapse.classList.remove("show");
            }
        });

        // Prevent clicks inside the collapse from closing it
        navbarCollapse.addEventListener("click", function (e) {
            e.stopPropagation();
        });
    });
</script>
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

<script src="View/PageLanding/lib/wow/wow.min.js"></script>
<script src="View/PageLanding/lib/easing/easing.min.js"></script>
<script src="View/PageLanding/lib/waypoints/waypoints.min.js"></script>
<script src="View/PageLanding/lib/counterup/counterup.min.js"></script>
<script src="View/PageLanding/lib/lightbox/js/lightbox.min.js"></script>
<script src="View/PageLanding/lib/owlcarousel/owl.carousel.min.js"></script>
<script src="View/PageLanding/js/main.js"></script>
</body>
</html>
