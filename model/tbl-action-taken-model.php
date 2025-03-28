<?php 
    
    
    class ActionTaken{
        
        private $pdo;

        public function __construct($pdo) {
            $this->pdo = $pdo;
        }

    

        public function insert($docu_id, $action){
            
            //code...
            $sql = "INSERT INTO tbl_action_taken (docu_id, action_taken) VALUES (:docu_id, :action)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':docu_id', $docu_id);
            $stmt->bindParam(':action', $action);
            if($stmt->execute()){
                return true;
            }else{
                return false;
            }
           
            
        }
      
        
    }
?>