<?php 
// Set the time zone to Asia/Manila
date_default_timezone_set('Asia/Manila');


// PHPMailer configuration
$env_email_address = "danbsit4b@gmail.com";
$env_password = "dgtwxvvucrxjlknv";
$env_host = "smtp.gmail.com";
$env_smtp_security = "tls";
$env_port = 587;
$env_set_from = "NIA Document Tracking System";

$env_protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
//for hosting
//remove the document-tracking/ or adjust base on folder name
$env_basePath = $env_protocol . '://' . $_SERVER['HTTP_HOST'] . '/document-tracking/';




// Database configuration for localhost
$dbHost = 'localhost';
$dbName = 'document-tracking-db';
$dbUser = 'root'; 
$dbPassword = ''; 

// PDO connection string
$dsn = "mysql:host=$dbHost;dbname=$dbName;charset=utf8mb4";



try {
    $pdo = new PDO($dsn, $dbUser, $dbPassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Connection failed: ' . $e->getMessage());
}
?>