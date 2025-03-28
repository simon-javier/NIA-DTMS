<?php 
    


    
    class NotificationModel{
        
        private $pdo;



        public function __construct($pdo) {
            $this->pdo = $pdo;


        }

        public function insert($user_id, $content){
            
            $sql = "INSERT INTO tbl_notification (user_id, content) VALUES (:user_id, :content)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':user_id', $user_id);
            $stmt->bindParam(':content', $content);
            if($stmt->execute()){
                return true;
            }
            else{
                return false;
            }
            
           
        }

        public function markAsReadbyUser($user_id){
            
            $sql = "UPDATE tbl_notification set status = 'read' where user_id = :user_id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':user_id', $user_id);
            if($stmt->execute()){
                return true;
            }
            else{
                return false;
            }
            
           
        }
        
        
    }
?>