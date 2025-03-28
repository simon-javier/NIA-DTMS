<?php 
    session_start();
    
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require '../PHPMailer/src/Exception.php';
    require '../PHPMailer/src/PHPMailer.php';
    require '../PHPMailer/src/SMTP.php';
    require '../connection.php';
    require '../model/tbl-login-account-model.php';
    require '../model/tbl-userinformation-model.php';
    $accountModel = new AccountModel($pdo);
    $userInforamtion = new UserInformation($pdo);
    require '../model/tbl-notification-model.php';
    $createNotification = new NotificationModel($pdo);

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

    if(isset($_POST['action']) && $_POST['action'] == "login-check"){
        try {
            //code...
            $username = filter_var($_POST['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $password = filter_var($_POST['password'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $result = $accountModel->findUsername($username);
            
            if ($result) {
                $checkPassword = password_verify($password, $result['password']);
                if($checkPassword){
                    $userinfo = $userInforamtion->findUserInfoById($result['id']);
                    if($userinfo){
                        if($userinfo['status'] == 'archived'){
                            header('Content-Type: application/json');
                            echo json_encode(['status' => 'failed', 'message' => 'Your account has been archived.']);
                            exit;
                        }
                        if($userinfo['status'] == 'pending'){
                            header('Content-Type: application/json');
                            echo json_encode(['status' => 'failed', 'message' => 'Your account still under verification.']);
                            exit;
                        }
                        $_SESSION['userid'] = $userinfo['id'];
                        $_SESSION['fullname'] = $userinfo['firstname'] . ' ' .$userinfo['lastname'];
                        $_SESSION['role'] = $userinfo['role'];
                        $_SESSION['office'] = $userinfo['office'];
                        $_SESSION['office_code'] = $userinfo['office_code'];
                        header('Content-Type: application/json');
                        echo json_encode(['status' => 'success', 'message' => 'Login success', 'role' => $userinfo['role'], 'office' => $userinfo['office']]);
                    }else{
                        header('Content-Type: application/json');
                        echo json_encode(['status' => 'failed', 'message' => 'User information not found.']);
                    }
                    
                }
                else{
                    header('Content-Type: application/json');
                    echo json_encode(['status' => 'failed', 'message' => 'Incorrect password']);
                }

                
            } else {
                header('Content-Type: application/json');
                echo json_encode(['status' => 'failed', 'message' => 'Username not exists']);
            }
            exit();
        } catch (\Throwable $th) {
            //throw $th;
            header('Content-Type: application/json');
            echo json_encode(['status' => 'error', 'message' => $th->getMessage()]);
            exit;
        }
        
    }

    if(isset($_POST['action']) && $_POST['action'] == "check-email"){
        try {
            //code...
            $email = filter_var($_POST['email'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $checkEmail = filter_var($email, FILTER_VALIDATE_EMAIL);
            if (!$checkEmail) {
                header('Content-Type: application/json');
                echo json_encode(['status' => 'failed', 'message' => 'Invalid email address format.']);
                exit();
            } 
            $result = $userInforamtion->findEmail($email);

            if ($result) {
                $randonCode = rand(100000, 999999);
                $subject = "Verification Code";
                $body = "Here is your verification code: '.$randonCode . '. It remains valid for a duration of 5 minutes.";
                $mail = new PHPMailer(true);

                $mail->isSMTP();
                $mail->Host = $env_host;
                $mail->SMTPAuth = true;
                $mail->Username = $env_email_address;
                $mail->Password = $env_password;
                $mail->SMTPSecure = $env_smtp_security;
                $mail->Port = $env_port;
                $mail->setFrom($env_email_address, $env_set_from );
                $mail->addAddress($email);

                $mail->isHTML(true);
                $mail->Subject = $subject;
                $mail->Body    = $body;
                $mail->send();


                $_SESSION['verification_code'] = $randonCode;
                $_SESSION['account_id'] = $result['id'];
                $_SESSION['expiration'] = time() + 300;
                header('Content-Type: application/json');
                echo json_encode(['status' => 'success', 'message' => 'Verification has been sent to your email address.']);

                
                exit;
                
            } else {
                header('Content-Type: application/json');
                echo json_encode(['status' => 'failed', 'message' => 'Email address not found.']);
            }
            
            exit();
        } catch (\Throwable $th) {
            //throw $th;
            header('Content-Type: application/json');
            echo json_encode(['status' => 'error', 'message' => $th->getMessage()]);
            exit;
        }

        
        
        
    }

    if(isset($_POST['action']) && $_POST['action'] == "get-new-code"){
        try {
            //code...
            $result = $userInforamtion->getEmailById($_SESSION['account_id']);
            if ($result) {
                $randonCode = rand(100000, 999999);

                $mail = new PHPMailer(true);

                $mail->isSMTP();
                $mail->Host = $env_host;
                $mail->SMTPAuth = true;
                $mail->Username = $env_email_address;
                $mail->Password = $env_password;
                $mail->SMTPSecure = $env_smtp_security;
                $mail->Port = $env_port;
                $mail->setFrom($env_email_address, $env_set_from );
                $mail->addAddress($result['email']);

                $mail->isHTML(true);
                $mail->Subject = 'New verification code';
                $mail->Body    = ' Here is your verification code: '.$randonCode . '. It remains valid for a duration of 5 minutes.';
                $mail->send();

                $_SESSION['verification_code'] = $randonCode;
                $_SESSION['expiration'] = time() + 300;
                header('Content-Type: application/json');
                echo json_encode(['status' => 'success', 'message' => 'Verification has been sent to your email address.']);
                exit;
            } else {
                header('Content-Type: application/json');
                echo json_encode(['status' => 'failed', 'message' => 'Email address not found.']);
                exit;
            }
        } catch (\Throwable $th) {
            //throw $th;
            header('Content-Type: application/json');
            echo json_encode(['status' => 'error', 'message' => $th->getMessage()]);
            exit;
        }
        
        
    }

    if(isset($_POST['action']) && $_POST['action'] == "verify-code"){
        try {
            //code...
            $session_code = $_SESSION['verification_code'];
            $account_id = $_SESSION['account_id'];
            $session_time = $_SESSION['expiration'];
            $input_code = filter_var($_POST['code'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            if(time() > $session_time){
                session_destroy();
                header('Content-Type: application/json');
                echo json_encode(['status' => 'failed', 'message' => 'Verification expired.']);
                exit;
            }
            if($session_code != $input_code){
                header('Content-Type: application/json');
                echo json_encode(['status' => 'failed', 'message' => 'Verification code not match.']);
                exit;
            }

            $result = $accountModel->findId($account_id);
            if($result){
                $_SESSION['change_password'] = "You can now change your password.";
                header('Content-Type: application/json');
                echo json_encode(['status' => 'success', 'message' => 'You can now change your password.']);
            }else{
                header('Content-Type: application/json');
                echo json_encode(['status' => 'failed', 'message' => 'Account not found.']);
            }
            exit;
            
        
        } catch (\Throwable $th) {
            //throw $th;
            header('Content-Type: application/json');
            echo json_encode(['status' => 'error', 'message' => $th->getMessage()]);
            exit;
        }
    }

    if (isset($_POST['action']) && $_POST['action'] == "change-password") {
        try {
            //code...
            $newpass = filter_var($_POST['newpass'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $conpass = filter_var($_POST['conpass'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $account_id = $_SESSION['account_id'];
        
            if ($newpass != $conpass) {
                header('Content-Type: application/json');
                echo json_encode(['status' => 'failed', 'message' => 'Password not match.']);
            } else {
                $result = $accountModel->findId($account_id);
        
                if ($result) {
                    // Assuming you want to check the existing password
                    if (password_verify($newpass, $result['password'])) {
                        header('Content-Type: application/json');
                        echo json_encode(['status' => 'failed', 'message' => 'New password cannot be the same as the old password.']);
                    } else {
                        $hashvalue = password_hash($newpass, PASSWORD_DEFAULT);
                        $result = $accountModel->changePassword($account_id, $hashvalue);
                        if($result){
                            header('Content-Type: application/json');
                            echo json_encode(['status' => 'success', 'message' => 'Password changed successfully.']);
                        }else{
                            header('Content-Type: application/json');
                            echo json_encode(['status' => 'failed', 'message' => 'Something went wrong.']);
                        }
                    }
                } else {
                    header('Content-Type: application/json');
                    echo json_encode(['status' => 'failed', 'message' => 'Account not found.']);
                }
            }
        
            exit;
        } catch (\Throwable $th) {
            //throw $th;
            header('Content-Type: application/json');
            echo json_encode(['status' => 'error', 'message' => $th->getMessage()]);
            exit;
        }
        
    }


    if(isset($_POST['action']) && $_POST['action'] == "check-credentials"){
        try {
            //code...
            $firstname = filter_var($_POST['firstname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $lastname = filter_var($_POST['lastname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $number = filter_var($_POST['number'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $position = filter_var($_POST['position'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $office = filter_var($_POST['office'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $office_code = filter_var($_POST['office_code'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $email = filter_var($_POST['email'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $username = filter_var($_POST['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $password = filter_var($_POST['password'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $accountype = filter_var($_POST['accountype'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

          

            $checkEmail = filter_var($email, FILTER_VALIDATE_EMAIL);
            if (!$checkEmail) {
                header('Content-Type: application/json');
                echo json_encode(['status' => 'failed', 'message' => 'Invalid email address format.']);
                exit();
            } 

            $chechExistsEmail = $userInforamtion->findEmail($email);
            if($chechExistsEmail){
                header('Content-Type: application/json');
                echo json_encode(['status' => 'failed', 'message' => 'Email address already exists.']);
                exit();
            }


            

            $checkExistsUsername = $accountModel->findUsername($username);
            if($checkExistsUsername){
                header('Content-Type: application/json');
                echo json_encode(['status' => 'failed', 'message' => 'Username already exists.']);
                exit();
            }
            $randonCode = rand(100000, 999999);

            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = $env_host;
            $mail->SMTPAuth = true;
            $mail->Username = $env_email_address;
            $mail->Password = $env_password;
            $mail->SMTPSecure = $env_smtp_security;
            $mail->Port = $env_port;
            $mail->setFrom($env_email_address, $env_set_from );
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'Your verification Code';
            $mail->Body    = ' Here is your verification code: '.$randonCode . '. It remains valid for a duration of 5 minutes.';
            $mail->send();
            if($accountype == 'guest'){
                $_SESSION['office'] = null;
                $_SESSION['office_code'] = null;
            }else{
                $_SESSION['office'] = $office;
                $_SESSION['office_code'] = $office_code;
            }

            $_SESSION['firstname'] = $firstname;
            $_SESSION['lastname'] = $lastname;
            $_SESSION['number'] = $number;
            $_SESSION['position'] = $position;
            $_SESSION['email'] = $email;
            $_SESSION['username'] = $username;
            $_SESSION['accountype'] = $accountype;
            $_SESSION['password'] = $password;
            $_SESSION['reg-code-expiration'] = time() + 300;
            $_SESSION['verification_code'] = $randonCode;

            header('Content-Type: application/json');
            echo json_encode(['status' => 'success', 'message' => "Verification code has been sent to your email address."]);
            exit;


        } catch (\Throwable $th) {
            //throw $th;
            header('Content-Type: application/json');
            echo json_encode(['status' => 'error', 'message' => $th->getMessage()]);
            exit;
        }
        

    }
    if(isset($_POST['action']) && $_POST['action'] == "reg_verify_code"){
        try {
            //code...
            $expiration = $_SESSION['reg-code-expiration'];
            $verification_code = $_SESSION['verification_code'];
            $code = $_POST['code'];
            if(time() > $expiration){
                session_destroy();
                header('Content-Type: application/json');
                echo json_encode(['status' => 'failed', 'message' => 'Verification code expires.']);
                exit();
            }
            if($verification_code != $code){
                header('Content-Type: application/json');
                echo json_encode(['status' => 'failed', 'message' => 'Incorrect verification code.']);
                exit();
            }
            $firstname = $_SESSION['firstname'];
            $lastname = $_SESSION['lastname'];
            $number = $_SESSION['number'];
            $position = $_SESSION['position'];
            $office = $_SESSION['office'];
            $office_code = $_SESSION['office_code'];
            $email = $_SESSION['email'];
            $username = $_SESSION['username'];
            $password = $_SESSION['password'];
            $accountype = $_SESSION['accountype'];
            $hashpassword = password_hash($password, PASSWORD_DEFAULT);
            $pdo->beginTransaction();
            
            $lastid = $accountModel->createNewAccount($username, $hashpassword, $accountype);
            if($accountype == 'handler'){
                $userInforamtion->insertInforamtionHandler($lastid, $firstname, $lastname, $number, $position, $office, $office_code, $email, $accountype);
            }else{
                $userInforamtion->insertInforamtionGuest($lastid, $firstname, $lastname, $number, $email, $accountype);
            }
           

            $pdo->commit();


            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = $env_host;
            $mail->SMTPAuth = true;
            $mail->Username = $env_email_address;
            $mail->Password = $env_password;
            $mail->SMTPSecure = $env_smtp_security;
            $mail->Port = $env_port;
            $mail->setFrom($env_email_address, $env_set_from );
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'Registered successfully';
            $mail->Body    = 'Wait for the admins to verify your account.';
            $mail->send();
            $messageToSender = "New user registered.";
            
            sendNotification($createNotification, $messageToSender, "asdasd@asdasd.com", 2);
            

            session_destroy();
            header('Content-Type: application/json');
            echo json_encode(['status' => 'success', 'message' => "Registered successfully"]);
            exit;
        } catch (\Throwable $th) {
            //throw $th;
            $pdo->rollBack();
            header('Content-Type: application/json');
            echo json_encode(['status' => 'error', 'message' => $th->getMessage()]);
            exit;
        }


    }
   
    

?>