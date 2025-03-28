<?php 
    session_start();
        



    require '../connection.php';
    require '../model/tbl-office-name-model.php';
    $officeNameModel = new OfficeNames($pdo);



    if(isset($_POST['action']) && $_POST['action'] == 'add_office'){
        header('Content-Type: application/json');


        try {
            $office_name = filter_var($_POST['office_name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $office_code = filter_var($_POST['office_code'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $checkExists = $officeNameModel->checkOffice($office_name);
            if($checkExists){
                echo json_encode(['status' => 'failed', 'message' => "Office already exists."]);
                exit;
            }

            $checkExistsCode = $officeNameModel->checkCode($office_code);
            if($checkExistsCode){
                echo json_encode(['status' => 'failed', 'message' => "Office code already exists."]);
                exit;
            }
            $insert = $officeNameModel->insert($office_name, $office_code);
            if($insert){
                echo json_encode(['status' => 'success', 'message' => "New office added."]);
                exit;
            }else{
                echo json_encode(['status' => 'failed', 'message' => "Failed to add the office."]);
                exit;
            }
            
        } catch (\Throwable $th) {

            echo $th;
            exit;
        }


        
    }

    if(isset($_POST['action']) && $_POST['action'] == 'edit_office'){
        header('Content-Type: application/json');
        $office_name = filter_var($_POST['edit_office_name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $office_code = filter_var($_POST['edit_office_code'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $id = filter_var($_POST['office_id'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        try {
            $database_value = $officeNameModel->findId($id);
            if ($office_name === $database_value['office_name'] && $office_code === $database_value['office_code']) {
                // No changes made
                echo json_encode(['status' => 'failed', 'message' => "No changes made."]);
                exit;
            }

            if ($office_name !== $database_value['office_name'] && $officeNameModel->checkOffice($office_name)) {
                echo json_encode(['status' => 'failed', 'message' => "Office name already exists."]);
                exit;
            }

            if ($office_code !== $database_value['office_code'] && $officeNameModel->checkCode($office_code)) {
                echo json_encode(['status' => 'failed', 'message' => "Office code already exists."]);
                exit;
            }

            $update = $officeNameModel->update($id, $office_name, $office_code);
            if($update){
                echo json_encode(['status' => 'success', 'message' => "Update successfully."]);
                exit;
            }else{
                echo json_encode(['status' => 'failed', 'message' => "Failed to update the document."]);
                exit;
            }
        } catch (\Throwable $th) {
           
            echo $th;
            exit;
        }

    }


?>