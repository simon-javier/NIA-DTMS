<?php
    session_start();
    
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    require '../phpqrcode/qrlib.php';
    require '../connection.php';

    require '../PHPMailer/src/Exception.php';
    require '../PHPMailer/src/PHPMailer.php';
    require '../PHPMailer/src/SMTP.php';
    require '../connection.php';
    require '../model/tbl-login-account-model.php';
    require '../model/tbl-userinformation-model.php';
    require '../model/tbl-uploaded-docu-model.php';
 
    require '../model/tbl-document-tracking-model.php';
    require '../model/tbl-handler-incoming-model.php';
    require '../model/tbl-handler-outgoing-model.php';


    require '../model/tbl-notification-model.php';
    
    $uploadDocument = new UploadDocument($pdo);
    $accountModel = new AccountModel($pdo);
    $handlerIncomingModel = new HandlerIncoming($pdo);
    $handlerOutgoingModel = new HandlerOutgoing($pdo);
    $userInforamtion = new UserInformation($pdo);
    $documentTracking = new DocumentTracking($pdo);
    $createNotification = new NotificationModel($pdo);


    function generateQrCode($filename){
        global $env_basePath;
        $qrCodePath = "../assets/qr-codes/$filename.png";
        if (file_exists($qrCodePath)) {
            unlink($qrCodePath); 
        }
        $qrCodeData = $env_basePath."views/track-document.php?code=$filename";
        QRcode::png($qrCodeData, $qrCodePath);
        return $filename. ".png";
    }


    function sendNotification($createNotification, $message, $email, $user_id) {
        global $env_email_address, $env_password, $env_host, $env_smtp_security, $env_port, $env_set_from;
        $createNotification->insert($user_id, $message);
        // try {
          
        //     $mail = new PHPMailer(true);
        //     $mail->isSMTP();
        //     $mail->Host = $env_host;
        //     $mail->SMTPAuth = true;
        //     $mail->Username = $env_email_address;
        //     $mail->Password = $env_password;
        //     $mail->SMTPSecure = $env_smtp_security;
        //     $mail->Port = $env_port;
        //     $mail->setFrom($env_email_address, $env_set_from );
        //     $mail->addAddress($email);

        //     $mail->isHTML(true);
        //     $mail->Subject = 'New Notification';
        //     $mail->Body    = $message;
        //     $mail->send();
        //     return true;
        // } catch (\Throwable $th) {
        //     return $th;
        // }
    }

    if(isset($_POST['action']) && $_POST['action'] == "upload_document"){
        try {
            //code...

            $pdo->beginTransaction();
            $currentDate = date('Y-m-d');
            $randomNumber = str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
            $docu_code = $currentDate . '-' . $randomNumber;

            while ($uploadDocument->findCode($docu_code)) {
                // Increment the random number directly instead of regenerating it
                $randomNumber = str_pad(($randomNumber + 1) % 10000, 4, '0', STR_PAD_LEFT);
                $docu_code = $currentDate . '-' . $randomNumber;
            }


            $qr_filename = generateQrCode($docu_code);

            $subject = filter_var($_POST['subject'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $doc_type = filter_var($_POST['doc_type'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $description = filter_var($_POST['description'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $action = filter_var($_POST['required_action'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $source = filter_var($_POST['source'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $receiver_office = filter_var($_POST['receiver_office'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $document_date = filter_var($_POST['document_date'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
           
            $sender_id = null;
            if($source == 'guest'){
                $sender = filter_var($_POST['from_external'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $from_office = null;

            }
            elseif ($source == 'internal') {
                $sender = filter_var($_POST['from_internal'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $sender_id = filter_var($_POST['sender_id'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $from_office = $_SESSION['office'];
            }
           


            if (!isset($_FILES["file"])) {
               
                throw new Exception("File is not set");
            }

            if (!isset($_FILES["file"]["error"]) || $_FILES["file"]["error"] != UPLOAD_ERR_OK) {
                throw new Exception("Error uploading file: " . htmlspecialchars(basename($_FILES["file"]["name"])));
            }
            
            $targetDir = "../assets/uploaded-pdf/"; 
            $originalFileName = basename($_FILES["file"]["name"]);
            $uploadOk = 1;
            $fileType = strtolower(pathinfo($originalFileName, PATHINFO_EXTENSION));
            $fileSizeBytes = $_FILES["file"]["size"];
            $fileSizeKB = round($fileSizeBytes / 1024, 2)."kb";


            $pdfFileName = $docu_code . '.' . $fileType; 

            $destinationPath = $targetDir . $pdfFileName;
            $qrCodePath = "../assets/qr-codes/$qr_filename";

            if (file_exists($destinationPath)) {
                unlink($destinationPath);
            }
            $action_taken = "Document code created:  $docu_code";
            if (move_uploaded_file($_FILES["file"]["tmp_name"], $destinationPath)) {
                $lastid = $uploadDocument->uploadtDocu($qr_filename, $pdfFileName, $docu_code, $doc_type, $fileSizeKB, $sender_id, $sender, $subject, $description, $source, $action, $action_taken, $document_date, $from_office, 'ongoing');

                if(!$lastid){
                    throw new Exception("Failed to upload your file to the database. Try again.");
                }

                $fullname = $_SESSION['fullname'];
                $office_code = $_SESSION['office_code'];
                $insertToTracker = $documentTracking->insert($lastid, $action_taken, $fullname, $office_code);
                if (!$insertToTracker) {
                    throw new Exception("Failed to create a tracker for your document. Try again.");
                }
                $user_info = $userInforamtion->findUserInfoById($sender_id);
                if ($user_info === null) {
                    throw new Exception("User information not found for ID $sender_id.");
                }

                if ($source == 'internal') {
                    $passTohandler = $handlerOutgoingModel->insert($user_info['office'], $lastid);
            
                    if (!$passTohandler) {
                        throw new Exception("Failed to send to sender.");
                    }
                }
               
        
                $messageToReceiver  = "We are sending a new document with Document Tracking Code: $docu_code. Send by " . $_SESSION['fullname'] . ".";
                
                $officeInfo = $userInforamtion->getAllInfoByOfficeName($receiver_office);
                if ($officeInfo === null) {
                    throw new Exception("Office information not found for office: $receiver_office");
                }
            
             
                foreach($officeInfo as $info){
                    sendNotification($createNotification, $messageToReceiver, $info['email'], $info['id']);
                    $handlerIncomingModel->insert($info['id'], $lastid, $receiver_office);
                }
                $uploadDocument->updatePrevCur($lastid, "No previous office.", "No current office.");


                $pdo->commit();

                header('Content-Type: application/json');
                echo json_encode(['status' => 'success', 'message' => "The file " . htmlspecialchars(basename($_FILES["file"]["name"])) . " has been uploaded.", 'docu_code' => $docu_code]);
                exit;
            } else {
                $pdo->rollBack();
                unlink($destinationPath); 
                unlink($qrCodePath); 
                header('Content-Type: application/json');
                echo json_encode(['status' => 'error', 'message' => "Sorry, there was an error uploading ".  htmlspecialchars(basename($_FILES["file"]["name"])) ."."]);
                exit;
            }

        } catch (\Throwable $th) {
            //throw $th;
            $pdo->rollBack();
            if (file_exists($qrCodePath)) {
                unlink($qrCodePath); 
            }
            if (file_exists($destinationPath)) {
                unlink($destinationPath); 
            }
            header('Content-Type: application/json');
            echo json_encode(['status' => 'error', 'message' => $th]);
            exit;
        }
    }

    if(isset($_POST['action']) && $_POST['action'] == 'received_docu'){
        try {
            //code...
            $pdo->beginTransaction();
            $docu_id = $_POST['id'];
            $status = 'Received by '. $_SESSION['office'];
            $timestamp = date("Y-m-d H:i:s");

            $fullname = $_SESSION['fullname'];
            $office_code = $_SESSION['office_code'];
            $insertToTracker = $documentTracking->insert($lastid, $status, $fullname, $office_code);


            $updateDocuStatus = $uploadDocument->updateStatusByID($docu_id, $status);
            
         

            $updatehandlerStatus = $handlerDocument->updateStatusByID($_SESSION['userid'], $docu_id, 'received');

            $docuDetails = $uploadDocument->findbyID($docu_id);
            $uploader_info = $userInforamtion->getEmailById($docuDetails['uploader_id']);

            $message = $_SESSION['office']. " receives your document.";

            sendNotification($createNotification, $message, $uploader_info['email'], $docuDetails['uploader_id']);
            


            $pdo->commit();
            header('Content-Type: application/json');
            echo json_encode(['status' => 'success', 'message' => "Successfully received the document and notified the sender."]);
            exit;

        } catch (\Throwable $th) {
            //throw $th;
            $pdo->rollBack();
            header('Content-Type: application/json');
            echo json_encode(['status' => 'error', 'message' => $th->getMessage()]);
            exit;
        }

    }
    if(isset($_POST['action']) && $_POST['action'] == 'complete_docu'){
        try {
            //code...
            $pdo->beginTransaction();
            $docu_id = $_POST['id'];
            $status = 'Completed at '. $_SESSION['office'];
            $timestamp = date("Y-m-d H:i:s");

            $fullname = $_SESSION['fullname'];
            $office_code = $_SESSION['office_code'];
            $insertToTracker = $documentTracking->insert($lastid, $status, $fullname, $office_code);


            $updateDocuStatus = $uploadDocument->updateStatusByID($docu_id, $status);
            
         

            $updatehandlerStatus = $handlerDocument->updateStatusByID($_SESSION['userid'], $docu_id, 'completed');

            $docuDetails = $uploadDocument->findbyID($docu_id);
            $uploader_info = $userInforamtion->getEmailById($docuDetails['uploader_id']);

            $message = $_SESSION['office']. " mark your document as completed.";

            sendNotification($createNotification, $message, $uploader_info['email'], $docuDetails['uploader_id']);
            


            $pdo->commit();
            header('Content-Type: application/json');
            echo json_encode(['status' => 'success', 'message' => "Successfully mark as complete the document and notified the sender."]);
            exit;

        } catch (\Throwable $th) {
            //throw $th;
            $pdo->rollBack();
            header('Content-Type: application/json');
            echo json_encode(['status' => 'error', 'message' => $th->getMessage()]);
            exit;
        }

    }
    if(isset($_POST['action']) && $_POST['action'] == 'transfer_to_handler'){
        try {
            //code...
           


            $pdo->beginTransaction();
            $docu_id = $_POST['id'];
            $office_name = $_POST['office_name'];
            $status = 'Transfered to Document Handler';
            $timestamp = date("Y-m-d H:i:s");

            $docu_detail = $uploadDocument->findbyID($docu_id);

            $receiver_info = $userInforamtion->findUserInfoByOffice($office_name);
            $uploader_info = $userInforamtion->findUserInfoById($docu_detail['uploader_id']);

            $status = 'Transfered to ' .$office_name;
  
            $updateAdminIncoming = $adminIncoming->updateStatus($docu_id, $status);

            $fullname = $_SESSION['fullname'];
            $office_code = $_SESSION['office_code'];
            $insertToTracker = $documentTracking->insert($lastid, $status, $fullname, $office_code);

            $updateDocuStatus = $uploadDocument->updateStatusByID($docu_id, $status);



            $transferToOtherhandler = $handlerDocument->insert($receiver_info['id'], $docu_id, 'pending', $timestamp);

            // $officeIncomingInsert = $officeIncoming->insert($docu_id, $receiver_info['id']);
            
            
            //notification for uploader
            $message = "Your document has been transfered to ". $office_name;
            sendNotification($createNotification, $message, $uploader_info['email'], $uploader_info['id']);


            //notification for receiver
            $message = "New document has been transfered to you.";
            sendNotification($createNotification, $message, $receiver_info['email'], $receiver_info['id']);



            $pdo->commit();
            header('Content-Type: application/json');
            echo json_encode(['status' => 'success', 'message' => "Transfered successfully."]);
            exit;

        } catch (\Throwable $th) {
            //throw $th;
            $pdo->rollBack();
            header('Content-Type: application/json');
            echo json_encode(['status' => 'error', 'message' => $th]);
            exit;
        }

    }
    if(isset($_POST['action']) && $_POST['action'] == 'pull_document'){
        try {
            //code...
            $pdo->beginTransaction();
            $docu_id = $_POST['id'];
            $status = 'Document pulled';
            $timestamp = date("Y-m-d H:i:s");

          


            $updateDocuStatus = $uploadDocument->updateStatusByID($docu_id, $status);

          
           



            $pdo->commit();
            header('Content-Type: application/json');
            echo json_encode(['status' => 'success', 'message' => "Successfully pulled the document. "]);
            exit;

        } catch (\Throwable $th) {
            //throw $th;
            $pdo->rollBack();
            header('Content-Type: application/json');
            echo json_encode(['status' => 'error', 'message' => $th]);
            exit;
        }

    }
    if(isset($_POST['action']) && $_POST['action'] == 'receive_office'){
        try {
            //code...
            $pdo->beginTransaction();
            $docu_id = $_POST['id'];
            $office = $_SESSION['office'];
            $status = 'Received by ' . $office;
            $timestamp = date("Y-m-d H:i:s");

            $fullname = $_SESSION['fullname'];
            $office_code = $_SESSION['office_code'];
            $insertToTracker = $documentTracking->insert($lastid, $status, $fullname, $office_code);


            $updateDocuStatus = $uploadDocument->updateStatusByID($docu_id, $status);


            $updatehandlerStatus = $handlerDocument->updateStatusByID($_SESSION['userid'], $docu_id, $status);
            $updateOfficeIncomingStatus = $officeIncoming->updateStatusByID($docu_id, $status);


            $pdo->commit();
            header('Content-Type: application/json');
            echo json_encode(['status' => 'success', 'message' => "Successfully received the document and notified the sender."]);
            exit;

        } catch (\Throwable $th) {
            //throw $th;
            $pdo->rollBack();
            header('Content-Type: application/json');
            echo json_encode(['status' => 'error', 'message' => $th]);
            exit;
        }

    }

    if(isset($_POST['action']) && $_POST['action'] == 'transfer_docu'){
        try {
            //code...
            $pdo->beginTransaction();
            $docu_id = $_POST['id'];
            $office_name = $_POST['office_name'];

            $docu_detail = $uploadDocument->findbyID($docu_id);

            $receiver_info = $userInforamtion->findUserInfoByOffice($office_name);
            $uploader_info = $userInforamtion->findUserInfoById($docu_detail['uploader_id']);

            $status = 'Transfered to ' .$office_name;
            $timestamp = date("Y-m-d H:i:s");
            
            $fullname = $_SESSION['fullname'];
            $office_code = $_SESSION['office_code'];
            $insertToTracker = $documentTracking->insert($lastid, $status, $fullname, $office_code);

            $updateDocuStatus = $uploadDocument->updateStatusByID($docu_id, $status);

            $updatehandlerStatus = $handlerDocument->updateStatusByID($_SESSION['userid'], $docu_id, $status);

            $transferToOtherhandler = $handlerDocument->insert($receiver_info['id'], $docu_id, 'pending', $timestamp);

            // $officeIncomingInsert = $officeIncoming->insert($docu_id, $receiver_info['id']);
            
            
            //notification for uploader
            $message = "Your document has been transfered to ". $office_name;
            sendNotification($createNotification, $message, $uploader_info['email'], $uploader_info['id']);


            //notification for receiver
            $message = "New document has been transfered to you.";
            sendNotification($createNotification, $message, $receiver_info['email'], $receiver_info['id']);



            $pdo->commit();
            header('Content-Type: application/json');
            echo json_encode(['status' => 'success', 'message' => "Transfered successfully."]);
            exit;

        } catch (\Throwable $th) {
            //throw $th;
            $pdo->rollBack();
            header('Content-Type: application/json');
            echo json_encode(['status' => 'error', 'message' => "Error transfering the document: ".$th]);
            exit;
        }

    }
    if(isset($_POST['action']) && $_POST['action'] == 'confirm_receive'){
        try {
            //code...
            $pdo->beginTransaction();
            $docu_id = $_POST['id'];
            $office = $_SESSION['office'];
            $status = 'Document confirm by ' . $office;
            $timestamp = date("Y-m-d H:i:s");

            $fullname = $_SESSION['fullname'];
            $office_code = $_SESSION['office_code'];
            $insertToTracker = $documentTracking->insert($lastid, $status, $fullname, $office_code);


            $updateDocuStatus = $uploadDocument->updateStatusByID($docu_id, $status);


            $updatehandlerStatus = $handlerDocument->updateStatusByID($_SESSION['userid'], $docu_id, $status);
            $updateOfficeIncomingStatus = $officeIncoming->updateStatusByID($docu_id, $status);
            


            $pdo->commit();
            header('Content-Type: application/json');
            echo json_encode(['status' => 'success', 'message' => "Successfully confirmed the document and notified the sender."]);
            exit;

        } catch (\Throwable $th) {
            //throw $th;
            $pdo->rollBack();
            header('Content-Type: application/json');
            echo json_encode(['status' => 'error', 'message' => $th]);
            exit;
        }

    }
    if(isset($_POST['action']) && $_POST['action'] == 'disconfirm_receive'){
        try {
            //code...
            $pdo->beginTransaction();
            $docu_id = $_POST['id'];
            $office = $_SESSION['office'];
            $status = 'Document disconfirm by ' . $office;
            $timestamp = date("Y-m-d H:i:s");

            $fullname = $_SESSION['fullname'];
            $office_code = $_SESSION['office_code'];
            $insertToTracker = $documentTracking->insert($lastid, $status, $fullname, $office_code);


            $updateDocuStatus = $uploadDocument->updateStatusByID($docu_id, $status);


            $updatehandlerStatus = $handlerDocument->updateStatusByID($_SESSION['userid'], $docu_id, $status);
            $updateOfficeIncomingStatus = $officeIncoming->updateStatusByID($docu_id, $status);
           


            $pdo->commit();
            header('Content-Type: application/json');
            echo json_encode(['status' => 'success', 'message' => "Successfully disconfirmed the document and notified the sender."]);
            exit;

        } catch (\Throwable $th) {
            //throw $th;
            $pdo->rollBack();
            header('Content-Type: application/json');
            echo json_encode(['status' => 'error', 'message' => $th]);
            exit;
        }

    }


    if(isset($_POST['action']) && $_POST['action'] == "upload_document_external"){
        try {
            //code...

            $pdo->beginTransaction();
      
            $subject = filter_var($_POST['subject'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $doc_type = filter_var($_POST['doc_type'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $description = filter_var($_POST['description'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            if(isset($_POST['office_name'])){
                $office = $_POST['office_name'];
            }else{
                $office = null;
            }

            $source = $_POST['data_source'];
            $action = filter_var($_POST['required_action'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $sender = $_SESSION['fullname'];
            $sender_id = $_SESSION['userid'];
            $document_date = filter_var($_POST['document_date'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

           
            if (!isset($_FILES["file"])) {
                header('Content-Type: application/json');
                echo json_encode(['status' => 'error', 'message' => "Sorry, there was an error uploading ".  htmlspecialchars(basename($_FILES["file"]["name"])) ."."]);
                exit;
            }

            
            $targetDir = "../assets/uploaded-pdf/"; 
            $originalFileName = basename($_FILES["file"]["name"]);
            $uploadOk = 1;
            $fileType = strtolower(pathinfo($originalFileName, PATHINFO_EXTENSION));
            $fileSizeBytes = $_FILES["file"]["size"];
            $fileSizeKB = round($fileSizeBytes / 1024, 2)."kb";


            // Check if the file was uploaded successfully
            if (!isset($_FILES["file"]["error"]) || $_FILES["file"]["error"] != UPLOAD_ERR_OK) {
                header('Content-Type: application/json');
                echo json_encode(['status' => 'error', 'message' => "Sorry, there was an error uploading ".  htmlspecialchars(basename($_FILES["file"]["name"])) ."."]);
                exit;
            }


            $pdfFileName = time() . '.' . $fileType; 
            $destinationPath = $targetDir . $pdfFileName;


            if (file_exists($destinationPath)) {
                unlink($destinationPath);
            }

            if (move_uploaded_file($_FILES["file"]["tmp_name"], $destinationPath)) {
                
                $lastid = $uploadDocument->uploadtDocu(null, $pdfFileName, null, $doc_type, $fileSizeKB, $sender_id, $sender, $subject, $description, $source, $action, "pending", $document_date, $office, 'no');

                $officeInfo = $userInforamtion->getAllInfoByOfficeName("Administrative Section Records");
                if ($officeInfo === null) {
                    throw new Exception("Office information not found for office: Administrative Section Records");
                }
                $guestName = $_SESSION['fullname'];
                $notification = "$guestName uploaded new document.";
             
                foreach($officeInfo as $info){
                    sendNotification($createNotification, $notification, $info['email'], $info['id']);
                   
                }

                $pdo->commit();


                header('Content-Type: application/json');
                echo json_encode(['status' => 'success', 'message' => "The file " . htmlspecialchars(basename($_FILES["file"]["name"])) . " has been uploaded."]);
                exit;
            } else {
                $pdo->rollBack();
                unlink($destinationPath); 
                unlink($qrCodePath); 
                header('Content-Type: application/json');
                echo json_encode(['status' => 'error', 'message' => "Sorry, there was an error uploading ".  htmlspecialchars(basename($_FILES["file"]["name"])) ."."]);
                exit;
            }


        } catch (\Throwable $th) {
            //throw $th;
            $pdo->rollBack();
            if (file_exists($qrCodePath)) {
                unlink($qrCodePath); 
            }
            if (file_exists($destinationPath)) {
                unlink($destinationPath); 
            }
            header('Content-Type: application/json');
            echo json_encode(['status' => 'error', 'message' => $th->getMessage()]);
            exit;
        }
    }

    if(isset($_POST['action']) && $_POST['action'] == "pull_documents"){
        header('Content-Type: application/json');
        $id = $_POST['id'];
        $current_timestamp = date("Y-m-d H:i:s");
        $pullDocument = $uploadDocument->pullDocument($id, $current_timestamp);
        $delete_incomming = $handlerIncomingModel->pull($id);
        if(!$pullDocument){
            echo json_encode(['status' => 'failed', 'message' => "Something went wrong pulling the document."]);
            exit;
        }
        else{
            echo json_encode(['status' => 'success', 'message' => "Pulled successfully."]);
            exit;
        }
        
    }
    if(isset($_POST['action']) && $_POST['action'] == "update_document"){
        header('Content-Type: application/json');
        $id = $_POST['id'];
        $subject = $_POST['subject'];
        $doc_type = $_POST['doc_type'];
        $description = $_POST['description'];
        $required_action = $_POST['required_action'];
        if (!empty($_FILES['file']['name'])) {
            $targetDir = "../assets/uploaded-pdf/"; 
            $originalFileName = basename($_FILES["file"]["name"]);
            $uploadOk = 1;
            $fileType = strtolower(pathinfo($originalFileName, PATHINFO_EXTENSION));
            $fileSizeBytes = $_FILES["file"]["size"];
            $fileSizeKB = round($fileSizeBytes / 1024, 2)."kb";
            if (!isset($_FILES["file"]["error"]) || $_FILES["file"]["error"] != UPLOAD_ERR_OK) {
                echo json_encode(['status' => 'error', 'message' => "Sorry, there was an error uploading ".  htmlspecialchars(basename($_FILES["file"]["name"])) ."."]);
                exit;
            }


            $pdfFileName = time() . '.' . $fileType; 

            $destinationPath = $targetDir . $pdfFileName;


            if (file_exists($destinationPath)) {
                unlink($destinationPath);
            }

            if (move_uploaded_file($_FILES["file"]["tmp_name"], $destinationPath)) {

                $updateDocument = $uploadDocument->updateDocuWithFile($pdfFileName, $fileSizeKB, $id, $subject, $doc_type, $description, $required_action);

            }

        }else{
            $updateDocument = $uploadDocument->updateDocuWithoutFile($id, $subject, $doc_type, $description, $required_action);
            if(!$updateDocument){
                echo json_encode(['status' => 'failed', 'message' => "You don't have any changes made."]);
                exit;
            }
        }
        
        
        echo json_encode(['status' => 'success', 'message' => "Update successfully."]);
        exit;

    }

    if(isset($_POST['action']) && $_POST['action'] == "find_code"){
        header('Content-Type: application/json');
        $code = filter_var($_POST['code'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $result = $uploadDocument->findCode($code);
        if(!$result){
            echo json_encode(['status' => 'failed', 'message' => 'Tracking code not exists.']);
        }
        else{
            if(isset($_SESSION['office'])){
                $result = $handlerIncomingModel->findCode($result['id'], $_SESSION['office']);
                if(!$result){
                    echo json_encode(['status' => 'failed', 'message' => 'Tracking code exists but not for this office.']);
                }else{
                    $message = $_SESSION['office']. " scanned your document.";
                    $info = $uploadDocument->findCode($code);
                    sendNotification($createNotification, $message, null, $info['sender_id']);
                    echo json_encode(['status' => 'success', 'code' => $code]);
                }
            }else{
                echo json_encode(['status' => 'success', 'code' => $code]);
            }
           
        
        }

       
    }



?>