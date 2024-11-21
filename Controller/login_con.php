<?php
ob_start(); // Start output buffering
session_start(); // Start the session at the beginning
require_once __DIR__ . '/../Model/db_connection.php';
require_once __DIR__ . '/../Model/login_mod.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['forgot_password_form'])) {
        $email = $_POST['email'];
        $user = new User($conn);
    
        // Check if the email exists in the database and get citizend_id
        $citizend_id = $user->checkEmailExistss($email);
        if ($citizend_id) {
            // Send OTP to the email
            if ($user->sendOTPs($email)) {  // sendOTPs handles OTP generation, insertion, and email sending
                $_SESSION['otp_email'] = $email;
             
                header('Location: ../../View/PageLanding/otp_verification.php'); // Redirect to OTP verification page
                exit;
            } else {
                $_SESSION['login_error'] = 'Please Fill your Gmail.';
                header('Location: ../../View/PageLanding/forgotstep1.php'); // Redirect back to the forgot password page
                exit;
            }
        } else {
            // Email not found
            $_SESSION['login_error'] = 'This email address is not registered.';
            header('Location: ../../View/PageLanding/forgotstep1.php'); // Redirect back to the forgot password page
            exit;
        }
    }
    
    if (isset($_POST['login_form'])) {
   
        $email = $_POST['email'];
        $password = $_POST['password'];
    
        $user = new User($conn);
    
        // Check if the email exists
        $userInfo = $user->getUserInfo($email);
        if ($userInfo) {
            // Validate password
            $loginResult = $user->login($email, $password);
            if ($loginResult === true) {
                $accountType = $userInfo['user_type'];
                $status = $userInfo['r_status'];
                $regId = $userInfo['citizend_id']; 
                $nme = $userInfo['fullname'];
                $gender = $userInfo['gender'];
                $valid_id = $userInfo['valid_id'];
                // Store user info in session
                $_SESSION['email'] = $email;
                $_SESSION['user_type'] = $accountType;
                $_SESSION['r_status'] = $status;
                $_SESSION['citizend_id'] = $regId; 
                $_SESSION['fullname'] = $nme;
                $_SESSION['gender'] = $gender;
                $_SESSION['valid_id'] = $valid_id;
    
                // Redirect based on the account type and status
                if ($accountType === 'Citizen') {
                    if ($status === 'Approved') {
                        header('Location: ../../View/PageCitizen/CitizenPage.php');
                        exit;
                    } elseif ($status === 'Pending') {
                        $_SESSION['login_error'] = 'Your account is pending approval. Please wait for confirmation from the management.';
                        header('Location: ../../View/PageLanding/signin.php');
                        exit;
                    } else {
                        $_SESSION['login_error'] = 'Unknown account status.';
                        header('Location: ../../View/PageLanding/signin.php');
                        exit;
                    }
                } elseif ($accountType === 'Admin') {
                    header('Location: ../../View/PageAdmin/AdminDashboard.php');
                    exit;
                } elseif ($accountType === 'Staff') {
                    if ($status === 'Active') {
                        header('Location: ../../View/PageStaff/StaffDashboard.php');
                        exit;
                    } else {
                        $_SESSION['login_error'] = 'Please contact Argao Parish Church; your account is inactive.';
                        header('Location: ../../View/PageLanding/signin.php');
                        exit;
                    }
                } elseif ($accountType === 'Priest') {
                    if ($status === 'Active') {
                        header('Location: ../../View/PagePriest/index.php');
                        exit;
                    } else {
                        $_SESSION['login_error'] = 'Please contact Argao Parish Church; your account is inactive.';
                        header('Location: ../../View/PageLanding/signin.php');
                        exit;
                    }
                } else {
                    $_SESSION['login_error'] = 'Unknown account type';
                    header('Location: ../../View/PageLanding/signin.php');
                    exit;
                }
            } else {
                // Invalid password
                $_SESSION['login_error'] = 'Incorrect credentials. Please try again.';
                header('Location: ../../View/PageLanding/signin.php');
                exit;
            }
        } else {
            // Email not found
            $_SESSION['login_error'] = 'Invalid credentials';
            header('Location: ../../View/PageLanding/signin.php');
            exit;
        }
} elseif (isset($_POST['signup_form'])) {
    $errors = [];
    // Assuming further validation here

    if (empty($errors)) {
        // Instantiate Registration class
        $registration = new User($conn);
        $registrationData = $_POST; // Perform further validation if necessary
        $registrationResult = $registration->registerUser($registrationData);

        // Check if registration was successful
        if (strpos($registrationResult, "successful") !== false) {
            // Check if the email is valid
            if (!filter_var($registrationData['email'], FILTER_VALIDATE_EMAIL)) {
                // Display an alert for invalid email
                echo '<script>alert("Registration successful, but the email provided is invalid. OTP was not sent.");</script>';
            } else {
                // Display an alert for valid email
                echo '<script>alert("Registration successful. An OTP has been sent to your email.");</script>';
            }

            // Proceed to OTP page regardless of email validity
            header('Location:../../otp_view.php'); // Adjust path as necessary
            exit();
        } else {
            // Display error message
            echo '<script>alert("' . $registrationResult . '");</script>';
        }
    } else {
        // Display error messages
        foreach ($errors as $error) {
            echo '<script>alert("' . $error . '");</script>';
        }
    }
}



elseif(isset($_POST['signup_forms']) && $_POST['signup_forms'] == 1) {

    // Collect form data
    $data = [
        'first_name' => $_POST['first_name'],
        'last_name' => $_POST['last_name'],
        'middle_name' => $_POST['middle_name'],
        'address' => $_POST['address'],
        'month' => $_POST['month'],
        'day' => $_POST['day'],
        'year' => $_POST['year'],
        'phone' => $_POST['phone'],
        'email' => $_POST['email'],
        'password' => $_POST['password'],
        'confirmpassword' => $_POST['confirmpassword']
    ];

    // Create an instance of the Staff model
    $registration = new User($conn);  // Assuming 'StaffModel' is the name of your model class and '$conn' is your DB connection

    // Call the registerUsers method to handle registration logic
    $result = $registration->registerUsers($data);

    // Check if registration was successful and set the session message
    if ($result === "Registration successful") {
        $_SESSION['message'] = "Registration was successful!";
        // Redirect to a success page or show a success message
        header("Location: success_page.php");
        exit;
    } else {
        $_SESSION['message'] = "Registration failed: " . $result;
        // Optionally, redirect back to the registration page or show an error message
        header("Location: registrationpriest.php");
        exit;
    }
}
elseif (isset($_POST['signup_formss'])) {
    $errors = [];
    // Assuming further validation here

    if (empty($errors)) {
        // Instantiate Registration class
        $registration = new User($conn);
        $registrationData = $_POST; // Perform further validation if necessary
        $registrationResult = $registration->registerUserss($registrationData);

        // Check if registration was successful
        if ($registrationResult === "Registration successful") {
            // Redirect to success page or login page
            $_SESSION['status'] = "success";
            header('Location: ../PageAdmin/AdminDashboard.php');
            exit();
        } else {
            // Display error message
            echo '<script>alert("' . $registrationResult . '");</script>';
        }
    } else {
        // Display error messages
        foreach ($errors as $error) {
            echo '<script>alert("' . $error . '");</script>';
        }
    }
}elseif (isset($_POST['signup_formsss'])) {
    $errors = [];
    // Assuming further validation here

    if (empty($errors)) {
        // Instantiate Registration class
        $registration = new User($conn);
        $registrationData = $_POST; // Perform further validation if necessary
        $registrationResult = $registration->registerUsersss($registrationData);

        // Check if registration was successful
        if ($registrationResult === "Registration successful") {
            // Redirect to success page or login page
            $_SESSION['status'] = "success";
            header('Location: ../PageAdmin/AdminDashboard.php');
            exit();
        } else {
            // Display error message
            echo '<script>alert("' . $registrationResult . '");</script>';
        }
    } else {
        // Display error messages
        foreach ($errors as $error) {
            echo '<script>alert("' . $error . '");</script>';
        }
    }
}

}
?>
