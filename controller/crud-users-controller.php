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
require '../model/tbl-office-name-model.php';
$accountModel = new AccountModel($pdo);
$userInforamtion = new UserInformation($pdo);
$officeInfo = new OfficeNames($pdo);

if (isset($_POST['action']) && $_POST['action'] == 'update_information') {
    try {
        //code...
        $id = filter_var($_POST['id'], FILTER_SANITIZE_SPECIAL_CHARS);
        $firstname = filter_var($_POST['firstname'], FILTER_SANITIZE_SPECIAL_CHARS);
        $lastname = filter_var($_POST['lastname'], FILTER_SANITIZE_SPECIAL_CHARS);
        $contact = filter_var($_POST['contact'], FILTER_SANITIZE_SPECIAL_CHARS);
        $position = filter_var($_POST['position'], FILTER_SANITIZE_SPECIAL_CHARS);
        $email = filter_var($_POST['email'], FILTER_SANITIZE_SPECIAL_CHARS);

        $account_type = $_POST['account_type'];
        if ($account_type == "guest") {
            $office = null;
            $office_code = null;
        } else {
            $office = filter_var($_POST['office'], FILTER_SANITIZE_SPECIAL_CHARS);
            $office_info = $officeInfo->findOffice($office);
            $office_code = $office_info['office_code'];
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            header('Content-Type: application/json');
            echo json_encode(['status' => 'failed', 'message' => 'Email is not a valid format.']);
            exit();
        }
        $information = $userInforamtion->findUserInfoById($id);
        if (!$information) {
            header('Content-Type: application/json');
            echo json_encode(['status' => 'failed', 'message' => "Can't find the information."]);
            exit();
        }
        if ($email != $information['email']) {
            $emailExists = $userInforamtion->findEmail($email);
            if ($emailExists) {
                header('Content-Type: application/json');
                echo json_encode(['status' => 'failed', 'message' => "Email address already exists."]);
                exit();
            }
        }

        $result = $userInforamtion->updateInfoById($id, $firstname, $lastname, $contact, $position, $email, $office, $office_code);
        if (!$result) {
            header('Content-Type: application/json');
            echo json_encode(['status' => 'failed', 'message' => "Failed to update information."]);
            exit();
        } else {
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = $env_host;
            $mail->SMTPAuth = true;
            $mail->Username = $env_email_address;
            $mail->Password = $env_password;
            $mail->SMTPSecure = $env_smtp_security;
            $mail->Port = $env_port;
            $mail->setFrom($env_email_address, $env_set_from);
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'Account Update';
            $mail->Body    = 'Your account has been updated successfully.';
            $mail->send();
            header('Content-Type: application/json');
            echo json_encode(['status' => 'success', 'message' => "Update successfully."]);
            exit();
        }
    } catch (\Throwable $th) {
        //throw $th;
        header('Content-Type: application/json');
        echo json_encode(['status' => 'error', 'message' => $th->getMessage()]);
        exit();
    }
}

if (isset($_POST['action']) && $_POST['action'] == 'add_new_user') {
    try {
        //code...
        $username = filter_var($_POST['username'], FILTER_SANITIZE_SPECIAL_CHARS);
        $firstName = filter_var($_POST['firstName'], FILTER_SANITIZE_SPECIAL_CHARS);
        $lastName = filter_var($_POST['lastName'], FILTER_SANITIZE_SPECIAL_CHARS);
        $contact = filter_var($_POST['contact'], FILTER_SANITIZE_SPECIAL_CHARS);
        $position = filter_var($_POST['position'], FILTER_SANITIZE_SPECIAL_CHARS);
        $office = filter_var($_POST['office'], FILTER_SANITIZE_SPECIAL_CHARS);
        $office_code = filter_var($_POST['office_code'], FILTER_SANITIZE_SPECIAL_CHARS);
        $email = filter_var($_POST['email'], FILTER_SANITIZE_SPECIAL_CHARS);
        $role = filter_var($_POST['role'], FILTER_SANITIZE_SPECIAL_CHARS);
        $upperCaseLastName = strtoupper($lastName);
        $hashpassword = password_hash($upperCaseLastName, PASSWORD_DEFAULT);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            header('Content-Type: application/json');
            echo json_encode(['status' => 'failed', 'message' => 'Email is not a valid format.']);
            exit();
        }
        $emailExists = $userInforamtion->findEmail($email);
        if ($emailExists) {
            header('Content-Type: application/json');
            echo json_encode(['status' => 'failed', 'message' => 'Email address already exists.']);
            exit();
        }


        $usernameExists = $accountModel->findUsername($username);
        if ($usernameExists) {
            header('Content-Type: application/json');
            echo json_encode(['status' => 'failed', 'message' => 'Username already exists.']);
            exit();
        }
        $pdo->beginTransaction();
        $lastid = $accountModel->createNewAccount($username, $hashpassword, $role);
        if ($role == 'handler') {
            $userInforamtion->insertInforamtionHandler($lastid, $firstName, $lastName, $contact, $position, $office, $office_code, $email, $role);
        } else {
            $userInforamtion->insertInforamtionGuest($lastid, $firstName, $lastName, $contact, $email, $role);
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
        $mail->setFrom($env_email_address, $env_set_from);
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'Admin successfully created your account';
        $mail->Body    = 'Your username is: ' . $username . ', and password is: ' . $upperCaseLastName;
        $mail->send();

        header('Content-Type: application/json');
        echo json_encode(['status' => 'success', 'message' => "New user added successfully."]);
        exit;
    } catch (\Throwable $th) {
        //throw $th;
        $pdo->rollBack();
        header('Content-Type: application/json');
        echo json_encode(['status' => 'error', 'message' => $th->getMessage()]);
        exit();
    }
}
if (isset($_POST['action']) && $_POST['action'] == 'archive_account') {
    try {
        header('Content-Type: application/json');
        $id = $_POST['id'];
        $status = "archived";
        $userInforamtion->updateStatus($id, $status);
        $accountModel->updateStatus($id, $status);

        echo json_encode(['status' => 'success', 'message' => "Archive successfully."]);
        exit();
    } catch (\Throwable $th) {
        //throw $th;
        header('Content-Type: application/json');
        echo json_encode(['status' => 'error', 'message' => $th->getMessage()]);
        exit();
    }
}

if (isset($_POST['action']) && $_POST['action'] == 'unarchive_account') {
    try {
        header('Content-Type: application/json');
        $id = $_POST['id'];
        $status = "active";
        $userInforamtion->updateStatus($id, $status);
        $accountModel->updateStatus($id, $status);

        echo json_encode(['status' => 'success', 'message' => "Unarchive successfully."]);
        exit();
    } catch (\Throwable $th) {
        //throw $th;
        header('Content-Type: application/json');
        echo json_encode(['status' => 'error', 'message' => $th->getMessage()]);
        exit();
    }
}
if (isset($_POST['action']) && $_POST['action'] == 'decline_account') {
    try {
        //code...
        $id = $_POST['id'];
        $pdo->beginTransaction();
        $user_info = $userInforamtion->findUserInfoById($id);
        if (!$user_info) {
            header('Content-Type: application/json');
            echo json_encode(['status' => 'failed', 'message' => "Can't find the information."]);
            exit;
        }

        $loginaccount = $accountModel->findId($id);
        if (!$loginaccount) {
            header('Content-Type: application/json');
            echo json_encode(['status' => 'failed', 'message' => "Can't find the account."]);
            exit;
        }

        $updateStatus = $accountModel->updateStatus($id, 'decline');
        $updateStatus1 = $userInforamtion->updateStatus($id, 'decline');


        $pdo->commit();
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = $env_host;
        $mail->SMTPAuth = true;
        $mail->Username = $env_email_address;
        $mail->Password = $env_password;
        $mail->SMTPSecure = $env_smtp_security;
        $mail->Port = $env_port;
        $mail->setFrom($env_email_address, $env_set_from);
        $mail->addAddress($user_info['email']);

        $mail->isHTML(true);
        $mail->Subject = 'Account Decline';
        $mail->Body    = 'Registration declined.';
        $mail->send();

        header('Content-Type: application/json');
        echo json_encode(['status' => 'success', 'message' => "Account declined successfully."]);
        exit;
    } catch (\Throwable $th) {
        //throw $th;
        $pdo->rollBack();
        header('Content-Type: application/json');
        echo json_encode(['status' => 'error', 'message' => $th->getMessage()]);
        exit();
    }
}
if (isset($_POST['action']) && $_POST['action'] == 'approve_account') {
    try {
        //code...
        $id = $_POST['id'];
        $pdo->beginTransaction();
        $user_info = $userInforamtion->findUserInfoById($id);
        if (!$user_info) {
            header('Content-Type: application/json');
            echo json_encode(['status' => 'failed', 'message' => "Can't find the information."]);
            exit;
        }

        $loginaccount = $accountModel->findId($id);
        if (!$loginaccount) {
            header('Content-Type: application/json');
            echo json_encode(['status' => 'failed', 'message' => "Can't find the account."]);
            exit;
        }

        $updateStatus = $accountModel->updateStatus($id, 'active');
        $updateStatus1 = $userInforamtion->updateStatus($id, 'active');


        $pdo->commit();
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = $env_host;
        $mail->SMTPAuth = true;
        $mail->Username = $env_email_address;
        $mail->Password = $env_password;
        $mail->SMTPSecure = $env_smtp_security;
        $mail->Port = $env_port;
        $mail->setFrom($env_email_address, $env_set_from);
        $mail->addAddress($user_info['email']);

        $mail->isHTML(true);
        $mail->Subject = 'Account Approve';
        $mail->Body    = 'Registration approved.';
        $mail->send();

        header('Content-Type: application/json');
        echo json_encode(['status' => 'success', 'message' => "Account approved successfully."]);
        exit;
    } catch (\Throwable $th) {
        //throw $th;
        $pdo->rollBack();
        header('Content-Type: application/json');
        echo json_encode(['status' => 'error', 'message' => $th->getMessage()]);
        exit();
    }
}
if (isset($_POST['action']) && $_POST['action'] == 'retrieve_account') {
    try {
        //code...
        $id = $_POST['id'];
        $pdo->beginTransaction();
        $user_info = $userInforamtion->findUserInfoById($id);
        if (!$user_info) {
            header('Content-Type: application/json');
            echo json_encode(['status' => 'failed', 'message' => "Can't find the information."]);
            exit;
        }

        $loginaccount = $accountModel->findId($id);
        if (!$loginaccount) {
            header('Content-Type: application/json');
            echo json_encode(['status' => 'failed', 'message' => "Can't find the account."]);
            exit;
        }

        $lastname = strtoupper($user_info['lastname']);
        $email = $user_info['email'];
        $hashpassword = password_hash($lastname, PASSWORD_DEFAULT);
        $username = $loginaccount['username'];

        $login_account = $accountModel->changePassword($id, $hashpassword);

        if (!$login_account) {
            header('Content-Type: application/json');
            echo json_encode(['status' => 'failed', 'message' => "Something went wrong retrieving the account."]);
            exit;
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
        $mail->setFrom($env_email_address, $env_set_from);
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'Account Retrieved';
        $mail->Body    = 'Your username is: ' . $username . ', and password is: ' . $lastname;
        $mail->send();

        header('Content-Type: application/json');
        echo json_encode(['status' => 'success', 'message' => "Account retrieved successfully."]);
        exit;
    } catch (\Throwable $th) {
        //throw $th;
        $pdo->rollBack();
        header('Content-Type: application/json');
        echo json_encode(['status' => 'error', 'message' => $th->getMessage()]);
        exit();
    }
}

if (isset($_POST['action']) && $_POST['action'] == 'settings_update_info') {
    $profile_file_name = "";
    $firstname = filter_var($_POST['firstName'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $lastname = filter_var($_POST['lastName'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $contact = filter_var($_POST['contact'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    // $office = filter_var($_POST['office'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $position = filter_var($_POST['position'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);


    if (isset($_FILES['image-file']) && $_FILES['image-file']['error'] === UPLOAD_ERR_OK) {

        $allowedTypes = ['image/png', 'image/jpeg', 'image/jpg'];
        $fileType = $_FILES['image-file']['type'];

        if (in_array($fileType, $allowedTypes)) {

            $profile_file_name = time() . '_' . $_FILES['image-file']['name'];
            $uploadDirectory = '../assets/user-profile/';
            $uploadedFilePath = $uploadDirectory . $profile_file_name;

            move_uploaded_file($_FILES['image-file']['tmp_name'], $uploadedFilePath);
        } else {

            header('Content-Type: application/json');
            echo json_encode(['status' => 'failed', 'message' => 'Invalid file type. Please upload a PNG, JPEG, or JPG file.']);
            exit;
        }
    }



    if ($profile_file_name != "") {
        $updateprofile = $userInforamtion->settingsUpdateInfoWithPic($_SESSION['userid'], $profile_file_name, $firstname, $lastname, $contact, $position);
        if (!$updateprofile) {
            unlink($uploadedFilePath);
            header('Content-Type: application/json');
            echo json_encode(['status' => 'failed', 'message' => 'Something went wrong updating in the database.']);
            exit;
        }
    } else {
        $updateprofile = $userInforamtion->settingsUpdateInfoWithoutPic($_SESSION['userid'], $firstname, $lastname, $contact, $position);
        if (!$updateprofile) {
            unlink($uploadedFilePath);
            header('Content-Type: application/json');
            echo json_encode(['status' => 'failed', 'message' => 'Something went wrong updating in the database.']);
            exit;
        }
    }

    header('Content-Type: application/json');
    echo json_encode(['status' => 'success', 'message' => 'Updated successfully.']);
    exit;
}

if (isset($_POST['action']) && $_POST['action'] == 'settings_update_password') {
    $oldpassword = filter_var($_POST['oldpassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $newpassword = filter_var($_POST['newpassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $conpassword = filter_var($_POST['conpassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $dbpassword = $accountModel->getDBpassword($_SESSION['userid']);
    if (!$dbpassword) {
        header('Content-Type: application/json');
        echo json_encode(['status' => 'failed', 'message' => 'Failed to fetch old password.']);
        exit;
    }
    if (!(password_verify($oldpassword, $dbpassword['password']))) {
        header('Content-Type: application/json');
        echo json_encode(['status' => 'failed', 'message' => 'Old password is incorrect.']);
        exit;
    }

    if ($newpassword != $conpassword) {
        header('Content-Type: application/json');
        echo json_encode(['status' => 'failed', 'message' => 'New and confirm password not match.']);
        exit;
    }
    $hashed_password = password_hash($newpassword, PASSWORD_DEFAULT);

    $updatePassword = $accountModel->changePassword($_SESSION['userid'], $hashed_password);
    if (!$updatePassword) {
        header('Content-Type: application/json');
        echo json_encode(['status' => 'failed', 'message' => 'Failed to change the password.']);
        exit;
    }



    header('Content-Type: application/json');
    echo json_encode(['status' => 'success', 'message' => 'Password change successfully.']);
    exit;
}

