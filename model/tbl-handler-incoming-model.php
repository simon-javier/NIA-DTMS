<?php 
    


    
    class HandlerIncoming{
        
        private $pdo;



        public function __construct($pdo) {
            $this->pdo = $pdo;


        }

        public function insert($user_id, $docu_id, $receiver_office){
            
            $sql = "INSERT INTO tbl_handler_incoming (user_id, office_name, docu_id) VALUES (:user_id, :receiver_office, :docu_id)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':user_id', $user_id);
            $stmt->bindParam(':receiver_office', $receiver_office);
            $stmt->bindParam(':docu_id', $docu_id);
            if($stmt->execute()){
                return true;
            }
            else{
                return false;
            }
            
           
        }
        public function insertWithStatus($user_id, $docu_id, $receiver_office){
            
            $sql = "INSERT INTO tbl_handler_incoming (user_id, office_name, docu_id, status) VALUES (:user_id, :receiver_office, :docu_id, 'pending')";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':user_id', $user_id);
            $stmt->bindParam(':receiver_office', $receiver_office);
            $stmt->bindParam(':docu_id', $docu_id);
            if($stmt->execute()){
                return true;
            }
            else{
                return false;
            }
            
           
        }

        public function delete($officename, $docu_id){
            $sql = "DELETE from tbl_handler_incoming where docu_id = :id and office_name = :officename";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':officename', $officename);
            $stmt->bindParam(':id', $docu_id);
            if($stmt->execute()){
                return true;
            }
            else{
                return false;
            }
        }

        public function pull($docu_id){
            $sql = "DELETE from tbl_handler_incoming where docu_id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':id', $docu_id);
            if($stmt->execute()){
                return true;
            }
            else{
                return false;
            }
        }

        public function update($officename, $docu_id, $status, $timestamp){
            $sql = "UPDATE tbl_handler_incoming set status = :status, receive_at = :receive_at, updated_at = :updated_at  where docu_id = :id and office_name = :officename";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':officename', $officename);
            $stmt->bindParam(':id', $docu_id);
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':receive_at', $timestamp);
            $stmt->bindParam(':updated_at', $timestamp);
            if($stmt->execute()){
                return true;
            }
            else{
                return false;
            }
        }

        
        public function findCode($id, $officename){
            $sql = "SELECT * from tbl_handler_incoming where office_name = :officename and docu_id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':officename', $officename);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return $stmt->rowCount() > 0;
            
        }

        
        

        
        
        
    }
?>