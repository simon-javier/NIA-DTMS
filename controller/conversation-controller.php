<?php 
    session_start();
        



    require '../connection.php';
    require '../model/tbl-conversation-message-model.php';
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require '../PHPMailer/src/Exception.php';
    require '../PHPMailer/src/PHPMailer.php';
    require '../PHPMailer/src/SMTP.php';
    require '../connection.php';
    require '../model/tbl-login-account-model.php';
    require '../model/tbl-userinformation-model.php';
    require '../model/tbl-office-name-model.php';
    $accountModel = new AccountModel($pdo);
    $userInforamtion = new UserInformation($pdo);
    $officeInfo = new OfficeNames($pdo);

    $userid = $_SESSION['userid'];


    $conversationModel = new ConversationModel($pdo);

    if(isset($_POST['action']) && $_POST['action'] == 'create_new_conversation'){
        try {
            
            $pdo->beginTransaction();
                $randomNumber = rand(1, 1000000);
                while($conversationModel->checkForConversationId($randomNumber)){
                    $randomNumber = rand(1, 1000000);
                }
        
                $createNewConversation = $conversationModel->insertToConversation($randomNumber, $userid);
                if(!$createNewConversation){
                    header('Content-Type: application/json');
                    echo json_encode(['status' => 'failed', 'message' => 'Something went wrong starting the conversation.']);
                    exit(); 
                }
                //for admin static palang
                $createNewConversation1 = $conversationModel->insertToConversation($randomNumber, 'recordoffice');
                if(!$createNewConversation1){
                    header('Content-Type: application/json');
                    echo json_encode(['status' => 'failed', 'message' => 'Something went wrong starting the conversation.']);
                    exit(); 
                }
            $pdo->commit();


            header('Content-Type: application/json');
            echo json_encode(['status' => 'success', 'message' => 'You started the conversation successfully.']);
            exit();
        } catch (\Throwable $th) {
           
            $pdo->rollBack();
            header('Content-Type: application/json');
            echo json_encode(['status' => 'error', 'message' => $th->getMessage()]);
            exit(); 
        }
       
        
    }

    if(isset($_POST['action']) && $_POST['action'] == 'send_message'){
        try {
            //code...
            $pdo->beginTransaction();
            $conversation_id = $_POST['conversation_id'];
            $message = $_POST['message'];
            if($_SESSION['office'] == 'Administrative Section Records'){
                $user_id = 'recordoffice';
            }else{
                $user_id = $_SESSION['userid'];
            }
       

            $createNewMessage = $conversationModel->insertMessage($conversation_id, $user_id, $message);
            if(!$createNewMessage){
                header('Content-Type: application/json');
                echo json_encode(['status' => 'error', 'message' => "Something went wrong sending the message."]);
                exit();
            }
            $pdo->commit();
            header('Content-Type: application/json');
            echo json_encode(['status' => 'success']);
            exit();
        } catch (\Throwable $th) {
            //throw $th;
            $pdo->rollBack();
            header('Content-Type: application/json');
            echo json_encode(['status' => 'error', 'message' => $th->getMessage()]);
            exit();
        }


        // header('Content-Type: application/json');
        // echo json_encode(['status' => 'success', 'message' => "send success"]);
        // exit(); 
    }

    if(isset($_POST['action']) && $_POST['action'] == 'retrieve'){
        try {
            //code...
            $convoid = $_POST['convoid'];
            $getAllConversation = "SELECT * FROM tbl_messages where conversation_id = :conversation_id ORDER BY timestamp ASC";
            $stmt = $pdo->prepare($getAllConversation);
            $stmt->bindParam(':conversation_id', $convoid);
            $stmt->execute();
            $allConvo = $stmt->fetchAll(PDO::FETCH_ASSOC);
            header('Content-Type: application/json');
            echo json_encode(['status' => 'success', 'data' => $allConvo]);
            exit(); 
        } catch (\Throwable $th) {
        
            echo "Error getting the messages: " .$th;
            exit;
        }
        
    }

    if(isset($_POST['action']) && $_POST['action'] == 'send_notification'){
        header('Content-Type: application/json');
 
        try {
            //code...
            $office = $_POST['office'];
            $users = $userInforamtion->getAllInfoByOfficeCode($office);
            if (empty($users)) {
                throw new Exception("No valid recipients found.");
            }

            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = $env_host;
            $mail->SMTPAuth = true;
            $mail->Username = $env_email_address;
            $mail->Password = $env_password;
            $mail->SMTPSecure = $env_smtp_security;
            $mail->Port = $env_port;
            $mail->setFrom($env_email_address, $env_set_from );
            // Add recipients
            foreach($users as $user) {
                $mail->addAddress($user['email']);
            }

            

            $mail->isHTML(true);
            $mail->Subject = 'New Notification';
            $mail->Body    = "There is a file stuck in your office.";
            $mail->send();

            echo json_encode(['status' => 'success', 'message' => "Send successfully."]);
            exit(); 
        } catch (\Throwable $th) {
            //throw $th;
            echo "Error getting the messages: " .$th;
            exit;
        }
       
    }


?>