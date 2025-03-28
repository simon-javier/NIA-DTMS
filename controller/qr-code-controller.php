<?php
// qr-code-controller.php

// Include the QR code library
require '../phpqrcode/qrlib.php';
require '../connection.php';
require '../model/tbl-uploaded-docu-model.php';
$uploadDocument = new UploadDocument($pdo);



// Get the document code from the request
$docu_code = isset($_POST['docu_code']) ? $_POST['docu_code'] : '';
$codeExists = $uploadDocument->findCode($docu_code);
if($codeExists){
    header('Content-Type: application/json');
    echo json_encode(['status' => 'failed']);
    exit;
}

$filename = $docu_code;
// Construct the absolute path for the QR code
$qrCodePath = "../assets/qr-codes/$filename.png";
if (file_exists($qrCodePath)) {
    unlink($qrCodePath); 
}

// Generate the QR code
$qrCodeData = $env_basePath."views/track-document.php?code=$docu_code";
QRcode::png($qrCodeData, $qrCodePath);

// Return the absolute path to the generated QR code
echo json_encode(['status' => 'success', 'qrCodeData' => "$filename.png"]);







  



?>
