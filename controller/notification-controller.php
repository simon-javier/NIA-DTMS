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
    require '../model/tbl-notification-model.php';
    
    $accountModel = new AccountModel($pdo);
    $userInforamtion = new UserInformation($pdo);
    $officeInfo = new OfficeNames($pdo);
    $notificationModel = new NotificationModel($pdo);

    $userid = $_SESSION['userid'];


    $conversationModel = new ConversationModel($pdo);

  

    if(isset($_POST['action']) && $_POST['action'] == 'mark_as_read'){
        try {
         
            header('Content-Type: application/json');
            $user_id = $_POST['userid'];
            $notificationModel->markAsReadbyUser($user_id);

            echo json_encode(['status' => 'success']);
            exit();
        } catch (\Throwable $th) {
            //throw $th;
            $pdo->rollBack();
            header('Content-Type: application/json');
            echo json_encode(['status' => 'error', 'message' => $th->getMessage()]);
            exit();
        }

    }

   


?>