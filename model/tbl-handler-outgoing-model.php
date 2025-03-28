<?php 
    


    
    class HandlerOutgoing{
        
        private $pdo;



        public function __construct($pdo) {
            $this->pdo = $pdo;


        }

        public function insert($office_name, $docu_id){
            
            $sql = "INSERT INTO tbl_handler_outgoing (office_name, docu_id) VALUES (:office_name, :docu_id)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':office_name', $office_name);
            $stmt->bindParam(':docu_id', $docu_id);
            if($stmt->execute()){
                return true;
            }
            else{
                return false;
            }
            
           
        }

        public function delete($docu_id){
            $sql = "DELETE from tbl_handler_outgoing where docu_id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':id', $docu_id);
            if($stmt->execute()){
                return true;
            }
            else{
                return false;
            }
        }
        
        
    }
?>