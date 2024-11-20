<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';
require 'phpmailer/src/Exception.php';
require __DIR__ . "/../vendor/autoload.php";
$config = include('../config.php'); 
error_reporting(0); // Disable all error reporting

// Alternatively, if you only want to hide errors but log them
error_reporting(E_ALL); // Report all errors
ini_set('display_errors', '0'); // Hide errors from displaying on the page
ini_set('log_errors', '1'); // Enable error logging
ini_set('error_log', 'error.log'); // Specify the path to the error log file

session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form fields
    $firstName = $_POST['FirstName'];
    $lastName = $_POST['LastName'];
    $email = $_POST['Email'];
    $phoneNumber = $_POST['PhoneNumber'];
    $messageContent = $_POST['Message'];

    // PHPMailer setup
    try {
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = $config['smtp']['host'];
        $mail->SMTPAuth = true;
        $mail->Username = $config['smtp']['username'];
        $mail->Password = $config['smtp']['password'];
        $mail->SMTPSecure = $config['smtp']['secure'];
        $mail->Port = $config['smtp']['port'];

        // Set up recipient
        $mail->setFrom($email, "$firstName $lastName");
        $mail->addAddress($config['smtp']['username']);

        // Email content
        $mail->isHTML(true);
        $mail->Subject = 'New Contact Form Submission';

        $mail->Body    = "
            <html>
            <head>
                <style>
                    body {
                        font-family: Arial, sans-serif;
                        margin: 0;
                        padding: 0;
                        background-color: #f9f9f9;
                    }
                    .email-container {
                        width: 100%;
                        max-width: 600px;
                        margin: 0 auto;
                        padding: 20px;
                        background-color: #ffffff;
                        border-radius: 8px;
                        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
                    }
                    h2 {
                        color: #1e3a8a;
                    }
                    .content {
                        font-size: 14px;
                        color: #333;
                        line-height: 1.6;
                    }
                    .content b {
                        color: #1e3a8a;
                    }
                    .footer {
                        font-size: 12px;
                        color: #888;
                        text-align: center;
                        margin-top: 30px;
                    }
                    .footer p {
                        margin: 5px 0;
                    }
                </style>
            </head>
            <body>
                <div class='email-container'>
                    <h2>Contact Form Submission</h2>
                    <div class='content'>
                        <p><b>First Name:</b> $firstName</p>
                        <p><b>Last Name:</b> $lastName</p>
                        <p><b>Email:</b> $email</p>
                        <p><b>Phone Number:</b> $phoneNumber</p>
                        <p><b>Message:</b><br>$messageContent</p>
                    </div>
                    <div class='footer'>
                        <p>Thank you for contacting us. We will get back to you soon.</p>
                        <p>&copy; " . date("Y") . " Argao Parish Church. All rights reserved.</p>
                    </div>
                </div>
            </body>
            </html>
        ";

        $mail->send();
        $_SESSION['status'] = "success";
        header("Location: ../View/PageCitizen/ContactUs.php");
    } catch (Exception $e) {
        $_SESSION['error'] = "Message could not be sent. Error: {$mail->ErrorInfo}";
    }

    exit();
}
?>
