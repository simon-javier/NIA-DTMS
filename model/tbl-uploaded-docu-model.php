<?php 
    
    
    class UploadDocument{
        
        private $pdo;

        public function __construct($pdo) {
            $this->pdo = $pdo;
        }
        public function findCode($code){
          
                //code...
              
                $sql = "SELECT * from tbl_uploaded_document where document_code = :code";
                $stmt = $this->pdo->prepare($sql);
                $stmt->bindParam(':code', $code);
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                return $result;

        

        }
        public function findbyID($id){

                $sql = "SELECT * from tbl_uploaded_document where id = :id";
                $stmt = $this->pdo->prepare($sql);
                $stmt->bindParam(':id', $id);
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                return $result;

 

        }

        public function updateStatusByID($id, $status){
         
                $sql = "UPDATE tbl_uploaded_document SET status = :status where id = :id";
                $stmt = $this->pdo->prepare($sql);
                $stmt->bindParam(':status', $status);
                $stmt->bindParam(':id', $id);
                $stmt->execute();
                return true;


        }
        public function updateCompleted($id, $status){
         
            $sql = "UPDATE tbl_uploaded_document SET completed = :status where id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return true;


    }
        public function declineDocu($id, $status, $declineBy){
         
            $sql = "UPDATE tbl_uploaded_document SET status = :status, completed = :completed where id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':status', $declineBy);
            $stmt->bindParam(':completed', $status);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return true;


        }
        public function declineDocuCode($code, $status, $declineBy){
         
            $sql = "UPDATE tbl_uploaded_document SET status = :status, completed = :completed where document_code = :code";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':status', $declineBy);
            $stmt->bindParam(':completed', $status);
            $stmt->bindParam(':code', $code);
            $stmt->execute();
            return true;


        }


        public function uploadtDocu($qr_filename, $pdfFileName, $docu_code, $doc_type, $fileSizeKB, $sender_id, $sender, $subject, $description, $source, $action, $status, $document_date, $office, $completed){
          
                //code...
                $sql = "INSERT INTO tbl_uploaded_document (qr_filename, pdf_filename, document_code, document_type, document_size, sender_id, sender, subject, description, data_source, required_action, status, document_date, from_office, completed) VALUES (:qr_filename, :pdfFileName, :docu_code, :doc_type, :fileSizeKB, :sender_id, :sender, :subject, :description, :source, :action, :status, :document_date, :office, :completed)";
                $stmt = $this->pdo->prepare($sql);
                $stmt->bindParam(':qr_filename', $qr_filename);
                $stmt->bindParam(':pdfFileName', $pdfFileName);
                $stmt->bindParam(':docu_code', $docu_code);
                $stmt->bindParam(':doc_type', $doc_type);
                $stmt->bindParam(':fileSizeKB', $fileSizeKB);
                $stmt->bindParam(':sender_id', $sender_id);
                $stmt->bindParam(':sender', $sender);
                $stmt->bindParam(':subject', $subject);
                $stmt->bindParam(':description', $description);
                $stmt->bindParam(':source', $source);
                $stmt->bindParam(':action', $action);
                $stmt->bindParam(':status', $status);
                $stmt->bindParam(':document_date', $document_date);
                $stmt->bindParam(':office', $office);
                $stmt->bindParam(':completed', $completed);

                
                if($stmt->execute()){
                        $insertedId = $this->pdo->lastInsertId();

                        return $insertedId;
                }else{
                        return false;
                }
              

        }    

        public function pullDocument($id, $date){
                $sql = "UPDATE tbl_uploaded_document set status = 'pulled', completed = 'pulled', updated_at = :date where id = :id";
                $stmt = $this->pdo->prepare($sql);
                $stmt->bindParam(':id', $id);
                $stmt->bindParam(':date', $date);
                if($stmt->execute()){
                        return true;
                }else{
                        return false;
                }
        }

        public function updateDocuWithoutFile($id, $subject, $doc_type, $description, $required_action){
                $sql = "UPDATE tbl_uploaded_document set subject = :subject, document_type = :doc_type, description = :description, required_action = :required_action where id = :id";
                $stmt = $this->pdo->prepare($sql);

                $stmt->bindParam(':id', $id);
                $stmt->bindParam(':subject', $subject);
                $stmt->bindParam(':doc_type', $doc_type);
                $stmt->bindParam(':description', $description);
                $stmt->bindParam(':required_action', $required_action);
                $stmt->execute();

                // Check for success
                if ($stmt->rowCount() > 0) {
                    // Update successful
                    return true;
                } else {
                    // Update failed
                    return false;
                }
        }

        public function updateDocuWithFile($pdf_filename, $document_size, $id, $subject, $doc_type, $description, $required_action){
                $sql = "UPDATE tbl_uploaded_document set pdf_filename = :pdf_filename, document_size= :document_size, subject = :subject, document_type = :doc_type, description = :description, required_action = :required_action where id = :id";
                $stmt = $this->pdo->prepare($sql);
                $stmt->bindParam(':pdf_filename', $pdf_filename);
                $stmt->bindParam(':document_size', $document_size);
                $stmt->bindParam(':id', $id);
                $stmt->bindParam(':subject', $subject);
                $stmt->bindParam(':doc_type', $doc_type);
                $stmt->bindParam(':description', $description);
                $stmt->bindParam(':required_action', $required_action);
                $stmt->execute();

                // Check for success
                if ($stmt->rowCount() > 0) {
                    // Update successful
                    return true;
                } else {
                    // Update failed
                    return false;
                }
        }

        public function updateTheUploadOfTheGuest($id, $qr_filename, $document_code, $status, $current_timestamp, $action_requested, $completed){
                $sql = "UPDATE tbl_uploaded_document set qr_filename = :qr_filename, document_code = :document_code, status = :status, updated_at = :current_timestamp, action_requested = :action_requested, completed = :completed where id = :id";
                $stmt = $this->pdo->prepare($sql);
                $stmt->bindParam(':qr_filename', $qr_filename);
                $stmt->bindParam(':document_code', $document_code);
                $stmt->bindParam(':status', $status);
                $stmt->bindParam(':current_timestamp', $current_timestamp);
                $stmt->bindParam(':id', $id);
                $stmt->bindParam(':action_requested', $action_requested);
                $stmt->bindParam(':completed', $completed);
                $stmt->execute();

                // Check for success
                if ($stmt->rowCount() > 0) {
                    // Update successful
                    return true;
                } else {
                    // Update failed
                    return false;
                }
        }
        public function updateActionTaken($id, $actiontaken) {
            $sql = "UPDATE tbl_uploaded_document SET required_action = :required_action WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':required_action', $actiontaken);
            
            // Execute the prepared statement
            $stmt->execute();
        }
        
        public function appendStatus($id, $newStatus, $current_timestamp) {
                // Retrieve the current status from the database based on the document ID
                $sqlSelect = "SELECT status FROM tbl_uploaded_document WHERE id = :id";
                $stmtSelect = $this->pdo->prepare($sqlSelect);
                $stmtSelect->bindParam(':id', $id);
                $stmtSelect->execute();
                $resultSelect = $stmtSelect->fetch(PDO::FETCH_ASSOC);
            
                if ($resultSelect) {
                    // Concatenate the current status with the new status
                    $updatedStatus = $resultSelect['status'] . ', ' . $newStatus;
            
                    // Update the record with the concatenated status
                    $sqlUpdate = "UPDATE tbl_uploaded_document SET status = :status, updated_at = :current_timestamp WHERE id = :id";
                    $stmtUpdate = $this->pdo->prepare($sqlUpdate);
                    $stmtUpdate->bindParam(':id', $id);
                    $stmtUpdate->bindParam(':current_timestamp', $current_timestamp);
                    $stmtUpdate->bindParam(':status', $updatedStatus);
                    $stmtUpdate->execute();
            
                    // Check for success
                    if ($stmtUpdate->rowCount() > 0) {
                        // Update successful
                        return true;
                    } else {
                        // Update failed
                        return false;
                    }
                } else {
                    // Document not found
                    return false;
                }
            }
        public function updatePrevCur($docu_id, $prev, $cur){
            $query="UPDATE tbl_uploaded_document SET prev_office=:prev, cur_office=:cur WHERE id=:docu_id";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':prev', $prev);
            $stmt->bindParam(':cur', $cur);
            $stmt->bindParam(':docu_id', $docu_id);
            $stmt->execute();

            // Check for success
            if ($stmt->rowCount() > 0) {
                // Update successful
                return true;
            } else {
                // Update failed
                return false;
            }

        }

    }
?>