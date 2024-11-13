<?php
require_once '../../Controller/getCitizen_con.php';
$loggedInUserEmail = isset($_SESSION['email']) ? $_SESSION['email'] : null;
$r_status = isset($_SESSION['user_type']) ? $_SESSION['user_type'] : null;

if (!$loggedInUserEmail) {
  header("Location: ../../index.php");
  exit();
}

// Redirect staff users to the staff page, not the citizen page
if ($r_status === "Citizen") {
  header("Location: ../PageCitizen/CitizenPage.php"); // Change to your staff page
  exit();
}

if ($r_status === "Admin") {
  header("Location: ../PageAdmin/AdminDashboard.php"); // Change to your staff page
  exit();
}

if ($r_status === "Priest") {
  header("Location: ../PagePriest/index.php"); // Change to your staff page
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <title>ARGAO CHURCH MANAGEMENT SYSTEM</title>
  <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />
  <link rel="icon" href="../assets/img/mainlogo.jpg" type="image/x-icon" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
  <script src="assets/js/plugin/webfont/webfont.min.js"></script>
  <style>
    /* CSS to ensure the modal only shows the image with no extra white space */
    .modal-dialog {
      margin: 0;
      width: 100%;
      height: 100%;
      max-width: none;
    }
    .modal-content {
      height: 100%;
      border: none;
      border-radius: 0;
      background: transparent;
      box-shadow: none;
    }
    .modal-body {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100%;
      padding: 0;
      background: transparent;
    }
    .modal-body img {
      max-width: 200%;
      max-height: 200%;
      object-fit: contain;
    }
  </style>
</head>
<body>
<?php  require_once 'sidebar.php'?>
      <!-- End Sidebar -->

      <div class="main-panel">
      <?php  require_once 'header.php'?>
  <div class="container">
    <div class="page-inner">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <div class="card-title">Citizen Account Details</div>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-md-6 col-lg-4">
                  <div class="form-group">
                    <label for="fullname">Full Name:</label>
                    <input type="text" class="form-control" id="fullname" value="<?php echo $fullname; ?>" <?php echo $status === 'Approved' ? '' : 'readonly'; ?> />
                  </div>
                  <div class="form-group">
                    <label for="gender">Gender:</label>
                    <input type="text" class="form-control" id="gender" value="<?php echo $gender; ?>" <?php echo $status === 'Approved' ? '' : 'readonly'; ?> />
                  </div>
                  <div class="form-group">
                    <label for="phone">Phone:</label>
                    <input type="text" class="form-control" id="phone" value="<?php echo $phone; ?>" <?php echo $status === 'Approved' ? '' : 'readonly'; ?> />
                  </div>
                </div>

                <div class="col-md-6 col-lg-4">
                  <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="text" class="form-control" id="email" value="<?php echo $email; ?>" <?php echo $status === 'Approved' ? '' : 'readonly'; ?> />
                  </div>
                  <div class="form-group">
                    <label for="status">Birth Date:</label>
                    <input type="text" class="form-control" id="status" value="<?php echo $c_date_birth; ?>" <?php echo $status === 'Approved' ? '' : 'readonly'; ?> />
                  </div>
                  <div class="form-group">
                    <label for="address">Address:</label>
                    <textarea class="form-control" id="address" <?php echo $status === 'Approved' ? '' : 'readonly'; ?>><?php echo $address; ?></textarea>
                  </div>
                  <div class="form-group">
                    <label for="validId">Valid ID:</label>
                    <img class="form-control" src="<?php echo !empty($validId) ? '../PageLanding/' . htmlspecialchars($validId) : 'img/default-placeholder.png'; ?>" alt="Valid ID" style="max-width: 200px; max-height: 200px; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#imageModal">
                  </div>
                </div>
              </div>

              <div class="card-action">
  <?php
    // Set button properties based on status
    if ($status === 'Approved') {
      $buttonText = 'Edit';
      $buttonClass = 'btn btn-primary edit-btn';
    } else if ($status === 'Pending') {
      $buttonText = 'Accept';
      $buttonClass = 'btn btn-success approve-btn';
    }
  ?>
 <button id="editButton" class="<?php echo $buttonClass; ?>" data-id="<?php echo $citizenId; ?>"><?php echo $buttonText; ?></button>
  <button class="btn btn-danger delete-btn" data-id="<?php echo $citizenId; ?>">Delete</button>
  <button type="button" class="btn btn-danger" onclick="history.back()">Cancel</button>
</div>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal for viewing valid ID -->
  <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-body">
        <img src="<?php echo !empty($validId) ? '../PageLanding/' . htmlspecialchars($validId) : 'img/default-placeholder.png'; ?>" alt="Valid ID">
      </div>
    </div>
  </div>

  <script>
 const editButton = document.getElementById('editButton');
const fields = document.querySelectorAll('#fullname, #gender, #phone, #email, #status, #address');

// Initial setup: Ensure fields are readonly or editable based on the status
fields.forEach(field => {
  if (editButton.textContent === 'Edit') {
    field.setAttribute('readonly', 'readonly');
  } else {
    field.removeAttribute('readonly');
  }
});

// Event listener for Edit/Save button
editButton.addEventListener('click', function() {
  if (this.textContent === 'Edit') {
    // Enable editing and change button text to 'Save'
    fields.forEach(field => field.removeAttribute('readonly'));
    this.textContent = 'Save';
    this.classList.remove('btn-primary');
    this.classList.add('btn-success');
  } else if (this.textContent === 'Save') {
    // Handle Save logic
    const citizenId = this.getAttribute('data-id');
    const updatedData = {
      fullname: document.getElementById('fullname').value,
      gender: document.getElementById('gender').value,
      phone: document.getElementById('phone').value,
      email: document.getElementById('email').value,
      birthDate: document.getElementById('status').value,
      address: document.getElementById('address').value,
    };

    fetch('../../Controller/citizenupdate_con.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ citizenId, ...updatedData })
    })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        fields.forEach(field => field.setAttribute('readonly', 'readonly'));
        this.textContent = 'Edit';
        this.classList.remove('btn-success');
        this.classList.add('btn-primary');
      } else {
        alert('Failed to save changes.');
      }
    });
  }
});

  
document.addEventListener('DOMContentLoaded', function() {
    document.querySelector('.approve-btn').addEventListener('click', function() {
        // Existing approve functionality
    });

    document.querySelector('.delete-btn').addEventListener('click', function() {
        var citizenId = this.getAttribute('data-id');

        Swal.fire({
            title: 'Are you sure?',
            text: "This action will permanently delete the account!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                var xhr = new XMLHttpRequest();
                xhr.open('POST', '../../Controller/getCitizen_con.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        Swal.fire(
                            'Deleted!',
                            'The citizen account has been deleted.',
                            'success'
                        ).then(() => {
                            window.location.href = 'StaffCitizenAccounts.php'; // Redirect after deletion
                        });
                    } else {
                        Swal.fire(
                            'Error!',
                            'There was an issue deleting the account.',
                            'error'
                        );
                    }
                };
                xhr.send('citizenId=' + encodeURIComponent(citizenId) + '&action=delete');
            }
        });
    });
});




document.addEventListener('DOMContentLoaded', function() {
    // Get all buttons with the 'approve-btn' class
    const approveButtons = document.querySelectorAll('.approve-btn');

    // Loop through the buttons to add event listeners
    approveButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            var citizenId = this.getAttribute('data-id');

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, approve it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    var xhr = new XMLHttpRequest();
                    xhr.open('POST', '../../Controller/getCitizen_con.php', true);
                    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                    xhr.onload = function() {
                        if (xhr.status === 200) {
                            Swal.fire(
                                'Approved!',
                                'The citizen has been approved.',
                                'success'
                            ).then(() => {
                                // Redirect to StaffCitizenAccounts.php after approval
                                window.location.href = 'StaffCitizenAccounts.php';
                            });
                        } else {
                            console.error("Error response: ", xhr.responseText); // Log error response
                            Swal.fire(
                                'Error!',
                                'There was an issue approving the citizen.',
                                'error'
                            );
                        }
                    };

                    xhr.send('citizenId=' + encodeURIComponent(citizenId));
                }
            });
        });
    });
});


  </script>

  <!-- Bootstrap CSS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<!-- Popper.js (required for Bootstrap 4) -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<!-- Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <!-- Sweet Alert -->
  <script src="../assets/js/plugin/sweetalert/sweetalert.min.js"></script>
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

    <!-- Chart Circle -->
    <script src="../assets/js/plugin/chart-circle/circles.min.js"></script>

    <!-- Datatables -->
    <script src="../assets/js/plugin/datatables/datatables.min.js"></script>


    <!-- jQuery Vector Maps -->
    <script src="../assets/js/plugin/jsvectormap/jsvectormap.min.js"></script>
    <script src="../assets/js/plugin/jsvectormap/world.js"></script>


    <!-- Kaiadmin JS -->
    <script src="../assets/js/kaiadmin.min.js"></script>
</body>
</html>
