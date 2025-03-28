<?php 
    
    
    class DocumentTracking{
        
        private $pdo;

        public function __construct($pdo) {
            $this->pdo = $pdo;
        }

        public function insert($docu_id, $action, $person, $office){
    
                $sql = "INSERT INTO tbl_document_tracking (docu_id, action_taken, person, office) VALUES (:docu_id, :action, :person, :office)";
                $stmt = $this->pdo->prepare($sql);
                $stmt->bindParam(':docu_id', $docu_id);
                $stmt->bindParam(':action', $action);
                $stmt->bindParam(':person', $person);
                $stmt->bindParam(':office', $office);
                if($stmt->execute()){
                    return true;
                }
                else{
                    return false;
                }
       
            
        }

        public function insertCompleted($docu_id, $action, $person, $currentTimestamp){
            // Get the current timestamp and add 1 second
           
            
            // Prepare the SQL query
            $sql = "INSERT INTO tbl_document_tracking (docu_id, action_taken, person, timestamp) VALUES (:docu_id, :action, :person, :timestamp)";
            $stmt = $this->pdo->prepare($sql);
        
            // Bind parameters
            $stmt->bindParam(':docu_id', $docu_id);
            $stmt->bindParam(':action', $action);
            $stmt->bindParam(':person', $person);
            $stmt->bindParam(':timestamp', $currentTimestamp);
        
            // Execute the statement
            if($stmt->execute()){
                return true;
            } else {
                return false;
            }
        }
        
        
        
    }
?>