<?php
require_once __DIR__ . '/vendor/autoload.php'; // Make sure the autoload is included

use Dotenv\Dotenv;

// Load the .env file
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();


return [
    'smtp' => [
        'host' => $_ENV['SMTP_HOST'],
        'username' => $_ENV['SMTP_USERNAME'],
        'password' => $_ENV['SMTP_PASSWORD'],
        'secure' => $_ENV['SMTP_SECURE'],
        'port' => $_ENV['SMTP_PORT'],
    ],
    'twilio' => [
        'sid' => $_ENV['TWILIO_SID'],
        'token' => $_ENV['TWILIO_TOKEN'],
        'from' => $_ENV['TWILIO_FROM'],
    ]
];
