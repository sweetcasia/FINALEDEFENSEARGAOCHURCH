<?php
// Enable all error reporting
error_reporting(E_ALL); 

// Hide errors from displaying on the page
ini_set('display_errors', '0'); 

// Enable error logging
ini_set('log_errors', '1'); 

// Specify the path to the error log file (ensure this file is writable)
ini_set('error_log', __DIR__ . '/error.log'); 

use Twilio\Rest\Client;
require_once __DIR__ . '/../Controller/phpmailer/src/PHPMailer.php';
require_once __DIR__ . '/../Controller/phpmailer/src/Exception.php'; // Include Exception.php if needed
require_once __DIR__ . '/../Controller/phpmailer/src/SMTP.php'; // Include Exception.php if needed
require __DIR__ . "/../vendor/autoload.php";
require_once __DIR__ . '/../Controller/twilio-php-main/src/Twilio/autoload.php';
require_once __DIR__ . '/../Controller/twilio-php-main/src/Twilio/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


class User {
    
    private $conn;
    private $config;
    public function __construct($conn) {
        $this->conn = $conn;
        $this->config = include(__DIR__ . '/../config.php'); // Load config
    }
    public function updateCitizen($citizenId, $fullname, $gender, $phone, $email, $birthDate, $address) {
        // Prepare the SQL update statement
        $sql = "UPDATE citizen SET fullname = ?, gender = ?, phone = ?, email = ?, c_date_birth = ?, address = ? WHERE citizend_id = ?";

        // Prepare the statement
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            die('Prepare failed: ' . $this->conn->error);
        }

        // Bind parameters to the SQL statement
        $stmt->bind_param('ssssssi', $fullname, $gender, $phone, $email, $birthDate, $address, $citizenId);

        // Execute the statement
        $result = $stmt->execute();

        // Check for successful update
        if ($result) {
            return true; // Update successful
        } else {
            return false; // Update failed
        }

        // Close the statement
        $stmt->close();
    }
   
    public function sendOTPs($email) {
        // Retrieve citizend_id using checkEmailExistss()
        $citizend_id = $this->checkEmailExistss($email);
        if (!$citizend_id) {
            return false; // Email not found, return false
        }
    
        $otp = $this->generateOTP(); // Generate OTP
        $subject = "Your OTP Code";
        $body = "Your OTP code is: <strong>$otp</strong>. It is valid for 5 minutes.";
    
        // Call the insertOTP function with citizend_id
        if ($this->insertOTP($citizend_id, $otp)) {
            $_SESSION['citizend_id'] = $citizend_id; // Store citizend_id in session
            return $this->sendEmails($email, $subject, $body); // Send email if OTP inserted
        }
        return false; // Return false if OTP insertion fails
    }
    
    public function checkEmailExistss($email) {
        $sql = "SELECT `citizend_id` FROM `citizen` WHERE `email` = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['citizend_id']; // Return citizend_id if email exists
        } else {
            return false; // Email does not exist
        }
    }
    
    public function insertOTP($citizend_id, $otp) {
        $sql = "UPDATE `citizen` SET `otp_code` = ? WHERE `citizend_id` = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('si', $otp, $citizend_id);
        return $stmt->execute(); // Execute and return success/failure
    }
    private function sendEmails($email, $subject, $body) {
        try {
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = $config['smtp']['host'];
            $mail->SMTPAuth = true;
            $mail->Username = $config['smtp']['username'];
            $mail->Password = $config['smtp']['password'];
            $mail->SMTPSecure = $config['smtp']['secure'];
            $mail->Port = 587;
           
            $mail->setFrom($config['smtp']['username']);
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = "<div style='width: 100%; max-width: 400px; margin: auto; padding: 20px;'>
                           <div style='background: rgba(255, 255, 255, 0.8); padding: 20px;width:100%;height:auto;'>
                               {$body}
                           </div>
                       </div>";
            
            return $mail->send();
        } catch (Exception $e) {
            error_log("Error sending email notification: " . $e->getMessage());
            return false;
        }
    }
    public function regenerateAndSendOTPs($email) {
        // Retrieve citizend_id using checkEmailExistss()
        $citizend_id = $this->checkEmailExistss($email);
        if (!$citizend_id) {
            return false; // Email not found, return false
        }
    
        // Generate a new OTP
        $otp = $this->generateOTP(); 
        $subject = "Your New OTP Code";
        $body = "Your new OTP code is: <strong>$otp</strong>. It is valid for 5 minutes.";
        
        // Update OTP in the database
        if ($this->insertOTP($citizend_id, $otp)) {
            // Store the new OTP and citizen ID in the session
            $_SESSION['citizend_id'] = $citizend_id; 
            return $this->sendEmails($email, $subject, $body); // Send email if OTP inserted
        }
        return false; // Return false if OTP insertion fails
    }
    
    public function verifyOTPs($inputOtp) {
        $sql = "SELECT `otp_code` FROM `citizen` WHERE `citizend_id` = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i', $_SESSION['citizend_id']); // Assuming citizend_id is stored in session
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            // Debugging: log the OTP being checked
            error_log("Input OTP: $inputOtp, Stored OTP: " . $row['otp_code']);
            
            if ($row['otp_code'] === $inputOtp) {
                // OTP verified successfully
                return true;
            }
        }
        return false; // Invalid OTP
    }
    
    
    public function changePassword($citizend_id, $newPassword) {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $sql = "UPDATE `citizen` SET `password` = ? WHERE `citizend_id` = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('si', $hashedPassword, $citizend_id);
        return $stmt->execute(); // Execute and return success/failure
    }
    
    
    public function archiveCitizen($citizen_id, $status) {
        // Use the status passed to either archive or unarchive
        $sql = "UPDATE citizen SET r_status = ? WHERE citizend_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('si', $status, $citizen_id);  // 's' for status, 'i' for citizen_id
        
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
    public function getAdminAccount($statusFilter = '') {
        // Modify the SQL query to filter by r_status dynamically
        $sql = "SELECT `citizend_id`, `fullname`, `email`, `gender`, `phone`, `c_date_birth`, `age`, `address`, `valid_id`, `user_type`, `r_status`, `c_current_time`
                FROM `citizen` 
                WHERE `user_type` = 'Admin'";
        
        // Add condition based on the status filter
        if ($statusFilter === 'Unactive') {
            $sql .= " AND `r_status` = 'Unactive'";
        } else {
            $sql .= " AND `r_status` = 'Active'";
        }
        
        $sql .= " ORDER BY `c_current_time` ASC";
        
        // Prepare the statement
        $stmt = $this->conn->prepare($sql);
        
        if (!$stmt) {
            die('Prepare failed: ' . $this->conn->error);
        }
        
        // Execute the statement
        if (!$stmt->execute()) {
            die('Execute failed: ' . $stmt->error);
        }
        
        // Get the result set
        $result = $stmt->get_result();
        
        // Fetch all results as an associative array
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        
        // Close the statement
        $stmt->close();
        
        // Return the result
        return $data;
    }
    
    
    public function getPriestAccount($statusFilter = '') {
        // Modify the SQL query to filter by r_status dynamically
        $sql = "SELECT `citizend_id`, `fullname`, `email`, `gender`, `phone`, `c_date_birth`, `age`, `address`, `valid_id`, `user_type`, `r_status`, `c_current_time`
                FROM `citizen` 
                WHERE `user_type` = 'Priest'";
        
        // Add condition based on the status filter
        if ($statusFilter === 'Unactive') {
            $sql .= " AND `r_status` = 'Unactive'";
        } else {
            $sql .= " AND `r_status` = 'Active'";
        }
        
        $sql .= " ORDER BY `c_current_time` ASC";
        
        // Prepare the statement
        $stmt = $this->conn->prepare($sql);
        
        if (!$stmt) {
            die('Prepare failed: ' . $this->conn->error);
        }
        
        // Execute the statement
        if (!$stmt->execute()) {
            die('Execute failed: ' . $stmt->error);
        }
        
        // Get the result set
        $result = $stmt->get_result();
        
        // Fetch all results as an associative array
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        
        // Close the statement
        $stmt->close();
        
        // Return the result
        return $data;
    }
    public function getStaffAccount($statusFilter = '') {
        // Modify the SQL query to filter by r_status dynamically
        $sql = "SELECT `citizend_id`, `fullname`, `email`, `gender`, `phone`, `c_date_birth`, `age`, `address`, `valid_id`, `user_type`, `r_status`, `c_current_time`
                FROM `citizen` 
                WHERE `user_type` = 'Staff'";
        
        // Add condition based on the status filter
        if ($statusFilter === 'Unactive') {
            $sql .= " AND `r_status` = 'Unactive'";
        } else {
            $sql .= " AND `r_status` = 'Active'";
        }
        
        $sql .= " ORDER BY `c_current_time` ASC";
        
        // Prepare the statement
        $stmt = $this->conn->prepare($sql);
        
        if (!$stmt) {
            die('Prepare failed: ' . $this->conn->error);
        }
        
        // Execute the statement
        if (!$stmt->execute()) {
            die('Execute failed: ' . $stmt->error);
        }
        
        // Get the result set
        $result = $stmt->get_result();
        
        // Fetch all results as an associative array
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        
        // Close the statement
        $stmt->close();
        
        // Return the result
        return $data;
    }
    
    public function getAccount($statusFilter = '') {
        // Base SQL query for Citizen accounts
        $sql = "SELECT `citizend_id`, `fullname`, `email`, `gender`, `phone`, `c_date_birth`, `age`, `address`, `valid_id`, `user_type`, `r_status`, `c_current_time`
                FROM `citizen` 
                WHERE `user_type` = 'Citizen'";
        
        // Apply dynamic filter based on the provided status
        if ($statusFilter === 'Approved') {
            $sql .= " AND `r_status` = 'Approved'";
        } else {
            $sql .= " AND `r_status` = 'Pending'";
        }
        
        $sql .= " ORDER BY `c_current_time` ASC";
        
        // Prepare the statement
        $stmt = $this->conn->prepare($sql);
        
        if (!$stmt) {
            die('Prepare failed: ' . $this->conn->error);
        }
        
        // Execute the statement
        if (!$stmt->execute()) {
            die('Execute failed: ' . $stmt->error);
        }
        
        // Get the result set
        $result = $stmt->get_result();
        
        // Fetch all results as an associative array
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        
        // Close the statement
        $stmt->close();
        
        // Return the result
        return $data;
    }
    
    public function getCitizenDetails($citizendId) {
        // Prepare the SQL query
        $sql = "SELECT `citizend_id`, `fullname`, `email`, `gender`, `phone`, `c_date_birth`, `age`, `address`, `valid_id`, `user_type`, `r_status`, `c_current_time`
                FROM `citizen` 
                WHERE `citizend_id` = ?";
    
        // Prepare the statement
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            die('Prepare failed: ' . $this->conn->error);
        }
    
        // Bind the parameter
        $stmt->bind_param('i', $citizendId);
        
        // Execute the statement
        if (!$stmt->execute()) {
            die('Execute failed: ' . $stmt->error);
        }
    
        // Get the result set
        $result = $stmt->get_result();
    
        // Fetch the details as an associative array
        $data = $result->fetch_assoc();
    
        // Close the statement
        $stmt->close();
    
        // Return the result
        return $data;
    }
    public function sendSms($toPhoneNumber, $messageBody, $config) {
        try {
            $client = new Client($config['twilio']['sid'], $config['twilio']['token']);
            $message = $client->messages->create(
                $toPhoneNumber,
                [
                    'from' => $config['twilio']['from'],
                    'body' => $messageBody
                ]
            );
    
            if ($message->status == 'failed') {
                error_log("Failed to send SMS to {$toPhoneNumber}. Twilio Status: {$message->status}");
                return false;
            } else {
                error_log("SMS sent successfully to {$toPhoneNumber}. Status: {$message->status}");
                return true;
            }
        } catch (\Twilio\Exceptions\RestException $e) {
            error_log("Twilio Error: " . $e->getMessage());
            return false;
        } catch (\Exception $e) {
            error_log("General Error: " . $e->getMessage());
            return false;
        }
    }
    
    
    
    public function sendEmail($email, $citizen_name, $subject, $body) {
        try {
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = $this->config['smtp']['host'];
            $mail->SMTPAuth = true;
            $mail->Username = $this->config['smtp']['username'];
            $mail->Password = $this->config['smtp']['password'];
            $mail->SMTPSecure = $this->config['smtp']['secure'];
            $mail->Port = $this->config['smtp']['port'];
    
            $mail->setFrom($this->config['smtp']['username']);
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = "<div style='width: 100%; max-width: 400px; margin: auto; background: url(cid:background_img) no-repeat center center; background-size: cover; padding: 20px;'>
                               <div style='background: rgba(255, 255, 255, 0.8); padding: 20px;width:100%;height:auto;'>
                                   {$body}
                                   <img src='cid:signature_img' style='width: 200px; height: auto;'>
                               </div>
                           </div>";
    
            if ($mail->send()) {
                return true;
            } else {
                error_log("Email failed: " . $mail->ErrorInfo);
                return false;
            }
        } catch (Exception $e) {
            error_log("Error sending email notification: " . $e->getMessage());
            return false;
        }
    }
    
    public function approveCitizen($citizenId) {
        $sql = "UPDATE citizen SET r_status = 'Approved' WHERE citizend_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $citizenId);
    
        // Fetch citizen details for sending email and SMS
        $contactInfo = $this->getCitizenDetails($citizenId);
        if (!$contactInfo) {
            error_log("Citizen not found for ID: {$citizenId}");
            return false;
        }
        $_SESSION['status'] = "success";
        // Send Email notification and proceed if successful
        $emailSuccess = $this->sendEmail(
            $contactInfo['email'],
            $contactInfo['fullname'],
            "Your account has been approved.",
            "Dear {$contactInfo['fullname']},<br><br>Your account has been successfully approved.<br>Thank you for your patience.<br>"
        );
    
        if ($emailSuccess) {
            // Attempt to send SMS notification (not blocking approval if it fails)
            $smsMessage = "Dear {$contactInfo['fullname']}, Your account has been successfully approved. Thank you for your patience.";
            $smsSuccess = $this->sendSms($contactInfo['phone'], $smsMessage, $this->config);
    
            // Log SMS success or failure without affecting the approval
            if ($smsSuccess) {
                error_log("SMS sent successfully to {$contactInfo['phone']}");
            } else {
                error_log("SMS failed to send to {$contactInfo['phone']}");
            }
    
            // Proceed with updating approval status in the database
            if ($stmt->execute()) {
                error_log("Citizen approved successfully for ID: {$citizenId}");
                return true; // Approval successful
            } else {
                error_log("Failed to update citizen status for ID: {$citizenId}");
                return false;
            }
        } else {
            error_log("Email failed to send for citizen ID: {$citizenId}");
            return false; // Approval blocked due to email failure
        }
    }
    
    public function deleteCitizen($citizenId) {
        // Fetch citizen details before deletion
        $contactInfo = $this->getCitizenDetails($citizenId);
        if (!$contactInfo) {
            return "Error: Citizen not found"; // Citizen not found
        }
    
        $email = $contactInfo['email'] ?? null;
        $fullname = $contactInfo['fullname'];
        $phone = $contactInfo['phone'] ?? null; // Optional phone field
    
        // Validate email format
        if ($email && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return "Error: Invalid email address"; // Invalid email format
        }
    
        // Prepare SQL to delete citizen
        $sql = "DELETE FROM citizen WHERE citizend_id = ?";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            return "Error: SQL statement preparation failed";
        }
        $stmt->bind_param("i", $citizenId);
        
        // Try to send email notification only if the email is valid
        if ($email) {
            $emailSuccess = $this->sendEmail(
                $email,
                $fullname,
                "Your account has been approved.",
                "Dear {$fullname},<br><br>Your account has been successfully deleted.<br>Thank you for your patience.<br>"
            );
    
            if (!$emailSuccess) {
                error_log("Email failed to send for citizen ID: {$citizenId}");
                return false; // Approval blocked due to email failure
            }
        }
    
        $_SESSION['status'] = "success";
    
        // Attempt to send SMS notification (not blocking approval if it fails)
        $smsMessage = "Dear {$fullname}, Your account has been successfully deleted. Thank you for your patience.";
        $smsSuccess = $this->sendSms($phone, $smsMessage, $this->config);
    
        // Log SMS success or failure without affecting the approval
        if ($smsSuccess) {
            error_log("SMS sent successfully to {$phone}");
        } else {
            error_log("SMS failed to send to {$phone}");
        }
    
        // Proceed with deleting the citizen record in the database
        if ($stmt->execute()) {
            error_log("Citizen deleted successfully for ID: {$citizenId}");
            return true; // Deletion successful
        } else {
            error_log("Failed to delete citizen record for ID: {$citizenId}");
            return false;
        }
    }
    
    
    
    // Email sending function (no changes)
    private function sendEmailss($email, $fullname, $subject, $body) {
        // SMTP configuration
        $mail = new PHPMailer(true);
        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host = $this->config['smtp']['host'];
            $mail->SMTPAuth = true;
            $mail->Username = $this->config['smtp']['username'];
            $mail->Password = $this->config['smtp']['password'];
            $mail->SMTPSecure = $this->config['smtp']['secure'];
            $mail->Port = $this->config['smtp']['port'];
    
            // Recipients
            $mail->setFrom($this->config['smtp']['username']);
            $mail->addAddress($email, $fullname);
    
            // Content
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $body;
    
            $mail->send();
        } catch (Exception $e) {
            error_log("Email could not be sent. Mailer Error: {$mail->ErrorInfo}");
        }
    }
    
    // SMS sending function (no changes)
    private function sendSmss($phone, $message) {
        // Twilio SMS configuration
        $client = new Client($config['twilio']['sid'], $config['twilio']['token']);
    
        try {
            $client->messages->create(
                $phone, [
                    'from' => $config['twilio']['from'],
                    'body' => $message
                ]
            );
        } catch (Exception $e) {
            error_log("SMS could not be sent. Error: {$e->getMessage()}");
        }
    }
    

    public function login($email, $password) {
        // Sanitize input
        $email = mysqli_real_escape_string($this->conn, $email);
    
        // Use prepared statements to prevent SQL injection
        $stmt = $this->conn->prepare("SELECT * FROM citizen WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($result === false) {
            error_log("Database query error: " . mysqli_error($this->conn));
            return false;
        }
    
        if ($result->num_rows > 0) {
            // User found, verify password
            $user = $result->fetch_assoc();
            $hashedPassword = $user['password'];
    
            if (password_verify($password, $hashedPassword)) {
                // Check if the password needs to be rehashed
                if (password_needs_rehash($hashedPassword, PASSWORD_DEFAULT)) {
                    // Rehash the password and update it in the database
                    $newHashedPassword = password_hash($password, PASSWORD_DEFAULT);
                    $updateStmt = $this->conn->prepare("UPDATE citizen SET password = ? WHERE email = ?");
                    $updateStmt->bind_param("ss", $newHashedPassword, $email);
                    $updateResult = $updateStmt->execute();
    
                    if ($updateResult === false) {
                        error_log("Failed to update password hash: " . mysqli_error($this->conn));
                    }
                }
                return true; // Password is correct
            } else {
                return false; // Password is incorrect
            }
        } else {
            return false; // Email not found
        }
    }

    public function getUserInfo($email) {
        $email = mysqli_real_escape_string($this->conn, $email);
        $query = "SELECT citizend_id, user_type, r_status, fullname, gender,valid_id FROM citizen WHERE email = '$email'";
        $result = mysqli_query($this->conn, $query);
        
        // Check if query was successful and fetch user info
        if ($result && mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);
            return [
                'citizend_id' => $user['citizend_id'] ?? null,
                'user_type' => $user['user_type'] ?? null,
                'r_status' => $user['r_status'] ?? null,
                'fullname' => $user['fullname'] ?? null,
                'gender' => $user['gender'] ?? null,
                'valid_id' => $user['valid_id'] ?? null,
            ];
        } else {
            return null;
        }
    }
    public function deleteAccount($email) {
        $query = "DELETE FROM citizen WHERE email = ?";
        $stmt = $this->conn->prepare($query);

        if ($stmt) {
            $stmt->bind_param('s', $email);
            $stmt->execute();
            $stmt->close();
            return true; // Indicate success
        } else {
            // Optionally handle errors
            return false; // Indicate failure
        }
    }
    public function generateOTP($length = 6) {
        return random_int(100000, 999999); // Generates a random 6-digit number
    }
    
    public function sendOTP($email, $otp) {
        $subject = "Your OTP Code";
        $body = "<p>Your OTP code is: <strong>$otp</strong>. It is valid for 5 minutes.</p>";
        
        // Call the sendEmail function to send the OTP
        return $this->sendEmail($email, "Citizen", $subject, $body);
    }
    public function regenerateAndSendOTP() {
        // Generate a new OTP
        $newOtp = $this->regenerateOTP(); // This method updates the session and sends the OTP
        return $newOtp;
    }
    
    
    public function regenerateOTP() {
        // Generate a new OTP
        $newOtp = $this->generateOTP();
        
        // Update session with new OTP and reset the expiration time
        $_SESSION['otp_code'] = $newOtp;
        $_SESSION['c_current_time'] = time() + 300; // Set new expiration time for 5 minutes
        
        // Send the new OTP to the user's email
        $this->sendOTP($_SESSION['user_email'], $newOtp);
        
        // Update the OTP and current time in the database
        $query = "UPDATE citizen SET otp_code = ?, c_current_time = ? WHERE email = ?";
        $stmt = $this->conn->prepare($query);
        $currentTime = date("Y-m-d H:i:s"); // Format current time for database storage
        
        if ($stmt) {
            $stmt->bind_param('sss', $newOtp, $currentTime, $_SESSION['user_email']);
            $stmt->execute();
            $stmt->close();
        } else {
            // Optionally handle errors here
            return "Error updating OTP in database: " . $this->conn->error;
        }
        
        return $newOtp;
    }
    
    
    public function verifyOTP($inputOtp) {
        // Check if the user reached this method from registration
        if (!isset($_SESSION['otp_code']) || !isset($_SESSION['user_email'])) {
            return "Invalid access. Please register first.";
        }
    
        // Check if the expiry time is set in session
        if (!isset($_SESSION['c_current_time'])) {
            return "Session expired. Please register again.";
        }
    
        // Verify the OTP
        if (time() > $_SESSION['c_current_time']) {
            return "OTP has expired. Please request a new one.";
        } elseif ($inputOtp == $_SESSION['otp_code']) {
            // OTP is valid, update r_status to "Pending"
            $updateQuery = "UPDATE citizen SET r_status = 'Pending' WHERE email = ?";
            $stmt = $this->conn->prepare($updateQuery);
            if ($stmt === false) {
                return "Failed to prepare statement: " . $this->conn->error;
            }
    
            $stmt->bind_param('s', $_SESSION['user_email']);
            if ($stmt->execute()) {
                // Clean up
                unset($_SESSION['otp_code']); // Clear OTP from session
                unset($_SESSION['c_current_time']); // Clear expiry time
                unset($_SESSION['user_email']); // Clear email if necessary
    
                // Optionally redirect to a success page
                return "OTP verified successfully! Your account is now active.";
            } else {
                return "Error updating status: " . $stmt->error;
            }
        } else {
            return "Invalid OTP. Please try again.";
        }
    }
    
    
    public function registerUser($data) {
        // Automatically set user_type to 'Citizen'
        $data['user_type'] = 'Citizen';
    
        // Combine first name, last name, and middle name into a single fullname field
        $data['fullname'] = trim($data['first_name'] . ' ' . $data['middle_name'] . ' ' . $data['last_name']);
    
        // Ensure c_date_birth is set correctly before proceeding
        if (isset($data['year']) && isset($data['month']) && isset($data['day'])) {
            $year = intval($data['year']);
            $month = intval($data['month']);
            $day = intval($data['day']);
            
            if (checkdate($month, $day, $year)) {
                $data['c_date_birth'] = "$year-$month-$day";
            } else {
                return "Invalid date of birth";
            }
        } else {
            return "Date of birth is incomplete";
        }
    
        if (isset($_FILES['valid_id'])) {
            $validIdError = $_FILES['valid_id']['error'];
            $validIdTmpName = $_FILES['valid_id']['tmp_name'];
            $validIdName = $_FILES['valid_id']['name'];
            $uploadDir = 'img/';
        
            // Ensure upload directory exists
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
        
            $validIdUploadPath = $uploadDir . basename($validIdName);
        
            if ($validIdError === UPLOAD_ERR_OK) {
                // Skip file type check and directly upload the file
                if (move_uploaded_file($validIdTmpName, $validIdUploadPath)) {
                    $data['valid_id'] = $validIdUploadPath; // Save the image path in data
                } else {
                    return "Failed to upload valid ID image. Check directory permissions.";
                }
            } else {
                // Check for specific errors
                switch ($validIdError) {
                    case UPLOAD_ERR_INI_SIZE:
                    case UPLOAD_ERR_FORM_SIZE:
                        return "File size exceeds the allowed limit.";
                    case UPLOAD_ERR_PARTIAL:
                        return "File was only partially uploaded.";
                    case UPLOAD_ERR_NO_FILE:
                        return "No file was uploaded.";
                    case UPLOAD_ERR_NO_TMP_DIR:
                        return "Missing temporary folder.";
                    case UPLOAD_ERR_CANT_WRITE:
                        return "Failed to write file to disk.";
                    default:
                        return "Unknown error occurred during upload.";
                }
            }
        } else {
            return "No valid ID image uploaded.";
        }
        
    
        // Sanitize input data
        $sanitizedData = $this->sanitizeData($data);
    
        // Calculate age
        $sanitizedData['age'] = $this->calculateAge($sanitizedData['c_date_birth']);
    
        // Hash the password
        $sanitizedData['password'] = password_hash($sanitizedData['password'], PASSWORD_DEFAULT);
    
        // Get the current time
        $currentTime = date("Y-m-d H:i:s");
    
        // Prepare SQL query with placeholders
// Prepare SQL query with placeholders
$query = "INSERT INTO citizen (user_type, fullname, address, gender, c_date_birth, age, email, valid_id, phone, password, r_status, c_current_time, otp_code) 
          VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, '', ?, ?)";

// Generate and send OTP
$otp = $this->generateOTP();
$this->sendOTP($sanitizedData['email'], $otp);

// Use prepared statements to prevent SQL injection
$stmt = $this->conn->prepare($query);
$stmt->bind_param(
    'ssssssssssss', // Change this to match the number of columns
    $sanitizedData['user_type'],
    $sanitizedData['fullname'],
    $sanitizedData['address'],
    $sanitizedData['gender'],
    $sanitizedData['c_date_birth'],
    $sanitizedData['age'],
    $sanitizedData['email'],
    $sanitizedData['valid_id'],
    $sanitizedData['phone'],
    $sanitizedData['password'],
    $currentTime,  // Store current time here
    $otp            // Bind OTP here
);

    
     // Execute the prepared statement
if ($stmt->execute()) {
    // On successful registration, set session variables
    session_start(); // Make sure the session is started
    $_SESSION['otp_code'] = $otp; // Store the generated OTP in session
    $_SESSION['user_email'] = $sanitizedData['email']; // Store the user email in session
    $_SESSION['c_current_time'] = time() + 300; // Set expiry time for OTP (5 minutes)

    // Optionally, you could redirect or return a success message
    return "Registration successful. An OTP has been sent to your email.";
} else {
    return "Error during registration: " . $stmt->error;
}

    }
    
    
    public function registerUsers($data) {
        // Automatically set user_type to 'Priest'
        $data['user_type'] = 'Priest';
        $data['r_status'] = 'Active';
    
        // Combine first name, last name, and middle name into a single fullname field
        $data['fullname'] = trim($data['first_name'] . ' ' . $data['middle_name'] . ' ' . $data['last_name']);
    
        // Create date of birth from year, month, and day
        $year = intval($data['year']);
        $month = intval($data['month']);
        $day = intval($data['day']);
        
        $data['c_date_birth'] = "$year-$month-$day";
    
        // Sanitize input data
        if (isset($_FILES['valid_id'])) {
            $validIdError = $_FILES['valid_id']['error'];
            $validIdTmpName = $_FILES['valid_id']['tmp_name'];
            $validIdName = $_FILES['valid_id']['name'];
            $validIdUploadPath = 'img/' . $validIdName;
    
            // Proceed with file upload if no error
            if ($validIdError === 0) {
                $imageFileType = strtolower(pathinfo($validIdName, PATHINFO_EXTENSION));
                $allowedFileTypes = ['jpg', 'jpeg', 'png', 'gif'];
    
                if (in_array($imageFileType, $allowedFileTypes)) {
                    if (move_uploaded_file($validIdTmpName, $validIdUploadPath)) {
                        $data['valid_id'] = $validIdUploadPath; // Save the image path in data
                    } else {
                        return "Failed to upload valid ID image";
                    }
                } else {
                    return "Only JPG, JPEG, PNG, and GIF files are allowed for valid ID";
                }
            } else {
                return "Error uploading valid ID image";
            }
        } else {
            return "No valid ID image uploaded";
        }
        $sanitizedData = $this->sanitizeData($data);
    
        // Calculate age
        $sanitizedData['age'] = $this->calculateAge($sanitizedData['c_date_birth']);
    
        // Hash the password
        $sanitizedData['password'] = password_hash($sanitizedData['password'], PASSWORD_DEFAULT);
    
        // Prepare SQL query with placeholders
        $query = "INSERT INTO citizen (user_type, r_status, fullname, address, gender, c_date_birth, age, email, phone, password,valid_id) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?)";
    
        // Use prepared statements to prevent SQL injection
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param(
            'sssssssssss',
            $sanitizedData['user_type'],
            $sanitizedData['r_status'],
            $sanitizedData['fullname'],
            $sanitizedData['address'],
            $sanitizedData['gender'],
            $sanitizedData['c_date_birth'],
            $sanitizedData['age'],
            $sanitizedData['email'],
            $sanitizedData['phone'],
            $sanitizedData['password'],
            $sanitizedData['valid_id']
        );
    
        if ($stmt->execute()) {
            // Return success message without notification
            return "Registration successful";
        } else {
            return "Registration failed";
        }
    }
 
    public function registerUserss($data) {
        // Automatically set user_type to 'Staff'
        $data['user_type'] = 'Staff';
        $data['r_status'] = 'Active';
    
        // Combine first name, last name, and middle name into a single fullname field
        $data['fullname'] = trim($data['first_name'] . ' ' . $data['middle_name'] . ' ' . $data['last_name']);
    
        // Create date of birth from year, month, and day
        $year = intval($data['year']);
        $month = intval($data['month']);
        $day = intval($data['day']);
        
        $data['c_date_birth'] = "$year-$month-$day";
    
        // Sanitize input data
        if (isset($_FILES['valid_id'])) {
            $validIdError = $_FILES['valid_id']['error'];
            $validIdTmpName = $_FILES['valid_id']['tmp_name'];
            $validIdName = $_FILES['valid_id']['name'];
            $validIdUploadPath = 'img/' . $validIdName;
    
            // Proceed with file upload if no error
            if ($validIdError === 0) {
                $imageFileType = strtolower(pathinfo($validIdName, PATHINFO_EXTENSION));
                $allowedFileTypes = ['jpg', 'jpeg', 'png', 'gif'];
    
                if (in_array($imageFileType, $allowedFileTypes)) {
                    if (move_uploaded_file($validIdTmpName, $validIdUploadPath)) {
                        $data['valid_id'] = $validIdUploadPath; // Save the image path in data
                    } else {
                        return "Failed to upload valid ID image";
                    }
                } else {
                    return "Only JPG, JPEG, PNG, and GIF files are allowed for valid ID";
                }
            } 
        } 
        $sanitizedData = $this->sanitizeData($data);
    
        // Calculate age
        $sanitizedData['age'] = $this->calculateAge($sanitizedData['c_date_birth']);
    
        // Hash the password
        $sanitizedData['password'] = password_hash($sanitizedData['password'], PASSWORD_DEFAULT);
    
        // Prepare SQL query with placeholders
        $query = "INSERT INTO citizen (user_type, r_status, fullname, address, gender, c_date_birth, age, email, phone, password,valid_id) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?)";
    
        // Use prepared statements to prevent SQL injection
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param(
            'sssssssssss',
            $sanitizedData['user_type'],
            $sanitizedData['r_status'],
            $sanitizedData['fullname'],
            $sanitizedData['address'],
            $sanitizedData['gender'],
            $sanitizedData['c_date_birth'],
            $sanitizedData['age'],
            $sanitizedData['email'],
            $sanitizedData['phone'],
            $sanitizedData['password'],
            $sanitizedData['valid_id']
        );
    
        if ($stmt->execute()) {
            // Return success message without notification
            return "Registration successful";
        } else {
            return "Registration failed";
        }
    }
    
    public function registerUsersss($data) {
        // Automatically set user_type to 'Staff'
        $data['user_type'] = 'Admin';
        $data['r_status'] = 'Active';
    
        // Combine first name, last name, and middle name into a single fullname field
        $data['fullname'] = trim($data['first_name'] . ' ' . $data['middle_name'] . ' ' . $data['last_name']);
    
        // Create date of birth from year, month, and day
        $year = intval($data['year']);
        $month = intval($data['month']);
        $day = intval($data['day']);
        
        $data['c_date_birth'] = "$year-$month-$day";
    
        // Sanitize input data
        if (isset($_FILES['valid_id'])) {
            $validIdError = $_FILES['valid_id']['error'];
            $validIdTmpName = $_FILES['valid_id']['tmp_name'];
            $validIdName = $_FILES['valid_id']['name'];
            $validIdUploadPath = 'img/' . $validIdName;
    
            // Proceed with file upload if no error
            if ($validIdError === 0) {
                $imageFileType = strtolower(pathinfo($validIdName, PATHINFO_EXTENSION));
                $allowedFileTypes = ['jpg', 'jpeg', 'png', 'gif'];
    
                if (in_array($imageFileType, $allowedFileTypes)) {
                    if (move_uploaded_file($validIdTmpName, $validIdUploadPath)) {
                        $data['valid_id'] = $validIdUploadPath; // Save the image path in data
                    } else {
                        return "Failed to upload valid ID image";
                    }
                } else {
                    return "Only JPG, JPEG, PNG, and GIF files are allowed for valid ID";
                }
            } else {
                return "Error uploading valid ID image";
            }
        } else {
            return "No valid ID image uploaded";
        }
        $sanitizedData = $this->sanitizeData($data);
    
        // Calculate age
        $sanitizedData['age'] = $this->calculateAge($sanitizedData['c_date_birth']);
    
        // Hash the password
        $sanitizedData['password'] = password_hash($sanitizedData['password'], PASSWORD_DEFAULT);
    
        // Prepare SQL query with placeholders
        $query = "INSERT INTO citizen (user_type, r_status, fullname, address, gender, c_date_birth, age, email, phone, password,valid_id) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?)";
    
        // Use prepared statements to prevent SQL injection
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param(
            'sssssssssss',
            $sanitizedData['user_type'],
            $sanitizedData['r_status'],
            $sanitizedData['fullname'],
            $sanitizedData['address'],
            $sanitizedData['gender'],
            $sanitizedData['c_date_birth'],
            $sanitizedData['age'],
            $sanitizedData['email'],
            $sanitizedData['phone'],
            $sanitizedData['password'],
            $sanitizedData['valid_id']
        );
    
        if ($stmt->execute()) {
            // Return success message without notification
            return "Registration successful";
        } else {
            return "Registration failed";
        }
    }
    private function calculateAge($birthday) {
        $birthDate = new DateTime($birthday);
        $today = new DateTime('today');
        return $birthDate->diff($today)->y;
    }

    private function sanitizeData($data) {
        foreach ($data as $key => $value) {
            $data[$key] = mysqli_real_escape_string($this->conn, $value);
        }
        return $data;
    }

    private function checkEmailExists($email) {
        $query = "SELECT * FROM citizen WHERE email = '$email'";
        $result = mysqli_query($this->conn, $query);
        return mysqli_num_rows($result) > 0;
    }

    
}
?>
