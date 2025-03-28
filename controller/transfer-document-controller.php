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
   require '../model/tbl-office-document-model.php';
   require '../model/tbl-action-taken-model.php';
   
   $uploadDocument = new UploadDocument($pdo);
   $accountModel = new AccountModel($pdo);
   $handlerIncomingModel = new HandlerIncoming($pdo);
   $handlerOutgoingModel = new HandlerOutgoing($pdo);
   $userInforamtion = new UserInformation($pdo);
   $documentTracking = new DocumentTracking($pdo);
   $createNotification = new NotificationModel($pdo);
   $officeDocument = new OfficeDocument($pdo);
   $actionTakenTable = new ActionTaken($pdo);

   


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
    //    try {
           $createNotification->insert($user_id, $message);
    //        $mail = new PHPMailer(true);
    //        $mail->isSMTP();
    //        $mail->Host = $env_host;
    //        $mail->SMTPAuth = true;
    //        $mail->Username = $env_email_address;
    //        $mail->Password = $env_password;
    //        $mail->SMTPSecure = $env_smtp_security;
    //        $mail->Port = $env_port;
    //        $mail->setFrom($env_email_address, $env_set_from );
    //        $mail->addAddress($email);

    //        $mail->isHTML(true);
    //        $mail->Subject = 'New Notification';
    //        $mail->Body    = $message;
    //        $mail->send();
    //        return true;
    //    } catch (\Throwable $th) {
    //        return $th;
    //    }
   }
  
   if(isset($_POST['action']) && $_POST['action'] == "transfer_document"){
        header('Content-Type: application/json');
        $id = $_POST['id'];
        $receiver_office = $_POST['office'];
        $action_taken = $_POST['action_taken'];
        
        try {

            $pdo->beginTransaction();
            $current_timestamp = date("Y-m-d H:i:s");


            //docuinfo and sender info
            $docu_info = $uploadDocument->findbyID($id);
            $userinfo = $userInforamtion->findUserInfoById($docu_info['sender_id']);
     


            $officeInfo = $userInforamtion->getAllInfoByOfficeName($receiver_office);
            $messageToSender = "$action_taken.";
            $person = $_SESSION['fullname'];
            $office = $_SESSION['office_code'];
            $insertToTracking = $documentTracking->insert($id, $messageToSender, $person, $office);
            $insertAction = $actionTakenTable->insert($id, $action_taken);
            $uploadDocument->updatePrevCur($id, "No previous office.", "No current office.");

            $messageToReceiver = "We are transferring a new document with Document Tracking Code: " . $docu_info['document_code'] . ". Transferred by " . $_SESSION['fullname'] . ".";

            if($userinfo){
                sendNotification($createNotification, $messageToSender, $userinfo['email'], $userinfo['id']);
            }
            

            //to notify all in the office receiver
            foreach($officeInfo as $info){
                sendNotification($createNotification, $messageToReceiver, $info['email'], $info['id']);
                $handlerIncomingModel->insert($info['id'], $id, $receiver_office);
            }
            $officeDocument->delete($_SESSION['office'], $id);


            $handlerOutgoingModel->insert($_SESSION['office'], $id);


            $uploadDocument->updateActionTaken($id, $action_taken);

            $uploadDocument->appendStatus($id, $messageToSender, $current_timestamp);



            $pdo->commit();
            echo json_encode(['status' => 'success', 'message' => "Transferred successfully."]);
            exit;
        } catch (\Throwable $th) {
            //throw $th;
            $pdo->rollBack();
            echo $th;
            exit;
        }

    }
   if(isset($_POST['action']) && $_POST['action'] == "transfer_document_withqr_code"){
        header('Content-Type: application/json');
        $id = $_POST['id'];

        try {

            $pdo->beginTransaction();
            $current_timestamp = date("Y-m-d H:i:s");
            $currentDate = date('Y-m-d');
            $randomNumber = str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
            $docu_code = $currentDate . '-' . $randomNumber;

            while ($uploadDocument->findCode($docu_code)) {
                $randomNumber = str_pad(($randomNumber + 1) % 10000, 4, '0', STR_PAD_LEFT);
                $docu_code = $currentDate . '-' . $randomNumber;
            }
            $qr_filename = generateQrCode($docu_code);
            

            $messageToSender = "Your document has been accepted by Administrative Section Records, and already have a tracking code. Accept by" . $_SESSION['fullname'] . ".";

            //notify the sender
            $docu_info = $uploadDocument->findbyID($id);
            $userinfo = $userInforamtion->findUserInfoById($docu_info['sender_id']);
            if($userinfo){
                sendNotification($createNotification, $messageToSender, $userinfo['email'], $userinfo['id']);
            }


            $trackingStatus = "Document code created: $docu_code.";
            $updateDocu = $uploadDocument->updateTheUploadOfTheGuest($id, $qr_filename, $docu_code,$trackingStatus, $current_timestamp, "Document accepted", "ongoing");
            $person = $_SESSION['fullname']; 
            $office = $_SESSION['office_code'];
            $insertToTracking = $documentTracking->insert($id, $trackingStatus, $person, $office);



                   
            $uploadDocument->updatePrevCur($id, "No previous office.", $_SESSION['office']);


            $allOffice = $userInforamtion->getAllInfoByOfficeName("Administrative Section Records");
            foreach($allOffice as $officer){
                $handlerIncomingModel->insertWithStatus($officer['id'], $id, $officer['office']);
            }

            $pdo->commit();
            echo json_encode(['status' => 'success', 'message' => "Accepted successfully.", 'docu_code' => $docu_code]);
            exit;
        } catch (\Throwable $th) {
            //throw $th;
            $pdo->rollBack();
            echo $th;
            exit;
        }

        

        

   }
   if(isset($_POST['action']) && $_POST['action'] == "receive_document_qrcode"){
        header('Content-Type: application/json');
        $current_timestamp = date("Y-m-d H:i:s");
        try {
            //code...
            $pdo->beginTransaction();
            $code = $_POST['code'];
            $findQrCode = $uploadDocument->findCode($code);
            
            $id = $findQrCode['id'];
            $checkQrCode = $handlerIncomingModel->findCode($id, $_SESSION['office']);

            if(!$checkQrCode){
                echo json_encode(['status' => 'failed', 'message' => "Can't find this QR Code."]);
                exit;
            }

            // $messageToSender = $_SESSION['office']. " accepted your document. Accept by " .$_SESSION['fullname'] . ".";
            // $updateStatus = $handlerIncomingModel->update($_SESSION['office'], $id, 'pending', $current_timestamp);


           

                   
            $action_taken = $_SESSION['office'] .  " received the document.";
            $person = $_SESSION['fullname'];
            $office = $_SESSION['office_code'];
            $insertToTracking = $documentTracking->insert($id, $action_taken, $person, $office);
        

            $officeDocument->insert($_SESSION['office'], $id);
            $handlerIncomingModel->delete($_SESSION['office'], $id);
            $uploadDocument->appendStatus($id, $action_taken, $current_timestamp);
            $docInfo = $uploadDocument->findbyID($id);
            if($docInfo['cur_office'] == "No current office.")
            {
                $uploadDocument->updatePrevCur($id, "No previous office.", $_SESSION['office']);
            }else{
                $uploadDocument->updatePrevCur($id, $docInfo['cur_office'], $_SESSION['office']);
            }
           

            //notify the sender
            $docu_info = $uploadDocument->findbyID($id);
            $userinfo = $userInforamtion->findUserInfoById($docu_info['sender_id']);
            if($userinfo){
                sendNotification($createNotification, $action_taken, $userinfo['email'], $userinfo['id']);
            }

            $officeInfo = $userInforamtion->getAllInfoByOfficeName("Administrative Section Records");
            if ($officeInfo === null) {
                throw new Exception("Office information not found for office: Administrative Section Records");
            }
            
            $messageToRecordOffice = $_SESSION['office']. " received the document. Received by " .$_SESSION['fullname'] . ".";
            foreach($officeInfo as $info){
                sendNotification($createNotification, $messageToRecordOffice, $info['email'], $info['id']);
            }
           

            $pdo->commit();
            echo json_encode(['status' => 'success', 'message' => "Receive successfully."]);
            exit;
        } catch (\Throwable $th) {
            //throw $th;
            $pdo->rollBack();
            echo $th;
            exit;

        }
        
       

   }
   if(isset($_POST['action']) && $_POST['action'] == "decline_document"){
        header('Content-Type: application/json');
        $current_timestamp = date("Y-m-d H:i:s");
        $id = $_POST['id'];
        try {
            //code...
            $docuInfo = $uploadDocument->findbyID($id);
            $userinfo = $userInforamtion->findUserInfoById($docuInfo['sender_id']);
            $messageToSender = "Your document has been decline.";
            $declineBy = "Decline by : " . $_SESSION['office'] . " - " . $_SESSION['fullname'];
            if($userinfo){
                sendNotification($createNotification, $messageToSender, $userinfo['email'], $userinfo['id']);
            }
            $handlerIncomingModel->delete($_SESSION['office'], $id);
            $handlerOutgoingModel->delete($id);
            $uploadDocument->declineDocu($id, 'decline', $declineBy);
            echo json_encode(['status' => 'success', 'message' => "Decline successfully."]);
            exit;



        } catch (\Throwable $th) {
            //throw $th;
        }
   }
   if(isset($_POST['action']) && $_POST['action'] == "decline_document_code"){
        header('Content-Type: application/json');
        $current_timestamp = date("Y-m-d H:i:s");
        $code = $_POST['code'];
        try {
            //code...
            $docuInfo = $uploadDocument->findCode($code);
            $declineBy = "Decline by : " . $_SESSION['office'] . " - " . $_SESSION['fullname'];
            $userinfo = $userInforamtion->findUserInfoById($docuInfo['sender_id']);
            $messageToSender = "Your document has been decline.";
            if($userinfo){
                sendNotification($createNotification, $messageToSender, $userinfo['email'], $userinfo['id']);
            }
            $uploadDocument->declineDocuCode($code, 'decline', $declineBy);
            echo json_encode(['status' => 'success', 'message' => "Decline successfully."]);
            exit;



        } catch (\Throwable $th) {
            //throw $th;
        }
    }
    //handler accepting the document
    if(isset($_POST['action']) && $_POST['action'] == "accept_document"){
        header('Content-Type: application/json');
        $current_timestamp = date("Y-m-d H:i:s");

        $id = $_POST['id'];
        $docu_info = $uploadDocument->findbyID($id);
        $messageToSender = "The ".$_SESSION['office']. " accepted your document. Accept by " .$_SESSION['fullname'] . ".";
        $docu_info = $uploadDocument->findbyID($id);
        $userinfo = $userInforamtion->findUserInfoById($docu_info['sender_id']);
        if($userinfo){
            sendNotification($createNotification, $messageToSender, $userinfo['email'], $userinfo['id']);
        }

        $officeInfo = $userInforamtion->getAllInfoByOfficeName("Administrative Section Records");
        if ($officeInfo === null) {
            throw new Exception("Office information not found for office: Administrative Section Records");
        }
        
        $messageToRecordOffice = $_SESSION['office']. " accepted the document. Accept by " .$_SESSION['fullname'] . ".";
        foreach($officeInfo as $info){
            sendNotification($createNotification, $messageToRecordOffice, $info['email'], $info['id']);
        }
       
        
        $uploadDocument->updatePrevCur($id, "No previous office.", $_SESSION['office']);
    

        $updateStatus = $handlerIncomingModel->update($_SESSION['office'], $id, 'pending', $current_timestamp);



      
        echo json_encode(['status' => 'success', 'message' => "Added to incoming documents."]);
        exit;

    }
   if(isset($_POST['action']) && $_POST['action'] == "receive_document"){
        header('Content-Type: application/json');
        $current_timestamp = date("Y-m-d H:i:s");
        try {
            $pdo->beginTransaction();
            $id = $_POST['id'];
            $docu_info = $uploadDocument->findbyID($id);
            $messageToSender = "The ".$_SESSION['office']. " received your document. Received by " .$_SESSION['fullname'] . ".";
            $removeFromIncoming = $handlerIncomingModel->delete($_SESSION['office'], $id);


           
            $action_taken =  $_SESSION['office'] .  " received the document.";
            $person = $_SESSION['fullname'];
            $office = $_SESSION['office_code'];
            $insertToTracking = $documentTracking->insert($id, $action_taken, $person, $office);

            $officeDocument->insert($_SESSION['office'], $id);
            $handlerIncomingModel->delete($_SESSION['office'], $id);
            $handlerOutgoingModel->delete($id);
            $uploadDocument->appendStatus($id, $action_taken, $current_timestamp);
            $uploadDocument->updatePrevCur($id, $docu_info['cur_office'], $_SESSION['office']);

            //notify the sender
  
            $userinfo = $userInforamtion->findUserInfoById($docu_info['sender_id']);
            if($userinfo){
                sendNotification($createNotification, $messageToSender, $userinfo['email'], $userinfo['id']);
            }
            $officeInfo = $userInforamtion->getAllInfoByOfficeName("Administrative Section Records");
            if ($officeInfo === null) {
                throw new Exception("Office information not found for office: Administrative Section Records");
            }
            
            
            foreach($officeInfo as $info){
                sendNotification($createNotification, $action_taken, $info['email'], $info['id']);
                
            }

            
            

            $pdo->commit();
            echo json_encode(['status' => 'success', 'message' => "Receive successfully."]);
            exit;
        } catch (\Throwable $th) {
            //throw $th;
            $pdo->rollBack();
            echo $th;
            exit;
        }
        
   }
   
   if(isset($_POST['action']) && $_POST['action'] == "complete_document"){
        header('Content-Type: application/json');
        $id = $_POST['id'];

        $current_timestamp = date("Y-m-d H:i:s");
        try {
            //code...
            $pdo->beginTransaction();
             //notify the sender
     
             $fullname = $_SESSION['fullname'];
             $office_code = $_SESSION['office_code'];
          
             $messageToSender = "Transaction completed. Mark this by: $fullname";

             $docu_info = $uploadDocument->findbyID($id);
             $userinfo = $userInforamtion->findUserInfoById($docu_info['sender_id']);
             if($userinfo){
                sendNotification($createNotification, $messageToSender, $userinfo['email'], $userinfo['id']);
             }

          
     
             $insertToTracker = $documentTracking->insert($id, "complete", $fullname, $office_code);
          

            //insert to tracking
            $currentTimestamp = date("Y-m-d H:i:s", time());

            // Add 1 second to the current timestamp
            $currentTimestamp = date("Y-m-d H:i:s", strtotime($currentTimestamp) + 1);
             $insertToTracking = $documentTracking->insertCompleted($id, "Transaction Complete", $fullname, $currentTimestamp);
             
            $officeDocument->updateStatus($id, "completed");


            $uploadDocument->appendStatus($id, $messageToSender, $current_timestamp);
            $uploadDocument->updateCompleted($id, "complete");
             

            $pdo->commit();
            echo json_encode(['status' => 'success', 'message' => "Makr as complete successfully."]);
            exit;
        } catch (\Throwable $th) {
            //throw $th;
            $pdo->rollBack();
            echo $th;
            exit;
        }

   }


?>