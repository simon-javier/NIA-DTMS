<?php 
    
    
    class OfficeDocument{
        
        private $pdo;

        public function __construct($pdo) {
            $this->pdo = $pdo;
        }

        public function insert($office_name, $docu_id){
            
                //code...
                $sql = "INSERT INTO tbl_office_document (office_name, docu_id) VALUES (:office_name, :docu_id)";
                $stmt = $this->pdo->prepare($sql);
                $stmt->bindParam(':office_name', $office_name);
                $stmt->bindParam(':docu_id', $docu_id);
                $stmt->execute();
                return true;
            
        }

        public function updateStatus($id, $status){
            $sql = "UPDATE tbl_office_document set status = :status where docu_id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return true;
        }

        public function delete($office_name, $id){
            $sql = "DELETE FROM tbl_office_document where office_name = :office_name and docu_id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':office_name', $office_name);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return true;
        }
        
    }
?>