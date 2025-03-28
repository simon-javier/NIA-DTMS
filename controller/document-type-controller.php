<?php 
    session_start();
        



    require '../connection.php';
    require '../model/tbl-document-type-model.php';
    $documentTypeModel = new DocumentType($pdo);



    if(isset($_POST['action']) && $_POST['action'] == 'create_document'){
        header('Content-Type: application/json');


        try {
            $document_type = filter_var($_POST['document_type'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $checkExists = $documentTypeModel->checkDocument($document_type);
            if($checkExists){
                echo json_encode(['status' => 'failed', 'message' => "Document already exists."]);
                exit;
            }
            $insert = $documentTypeModel->insert($document_type);
            if($insert){
                echo json_encode(['status' => 'success', 'message' => "New document type added."]);
                exit;
            }else{
                echo json_encode(['status' => 'failed', 'message' => "Failed to add the document."]);
                exit;
            }
            
        } catch (\Throwable $th) {

            echo $th;
            exit;
        }


        
    }

    if(isset($_POST['action']) && $_POST['action'] == 'edit_document'){
        header('Content-Type: application/json');
        $document_type = filter_var($_POST['edit_document_type'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $id = filter_var($_POST['document_id'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        try {
            $checkExists = $documentTypeModel->checkDocument($document_type);
            if($checkExists){
                echo json_encode(['status' => 'failed', 'message' => "No changes made."]);
                exit;
            }
            $update = $documentTypeModel->update($id, $document_type);
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