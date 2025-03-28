<?php 
    
    
    class ConversationModel{
        
        private $pdo;

        public function __construct($pdo) {
            $this->pdo = $pdo;
        }

        public function checkForConversationId($conversation_id){
            $sql = "SELECT conversation_id from tbl_conversation where conversation_id = :conversation_id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':conversation_id', $conversation_id);
            if($stmt->execute() && $stmt->rowCount() > 0){
                return true;
            }else{
                return false;
            }
        }

        public function insertToConversation($conversation_id, $user_id){
            
            //code...
            $sql = "INSERT INTO tbl_conversation (conversation_id, user_id) VALUES (:conversation_id, :user_id)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':conversation_id', $conversation_id);
            $stmt->bindParam(':user_id', $user_id);
            if($stmt->execute()){
                return true;
            }else{
                return false;
            }
           
            
        }
        public function insertMessage($conversation_id, $user_id, $message){
            
            //code...
            $sql = "INSERT INTO tbl_messages (conversation_id, user_id, message) VALUES (:conversation_id, :user_id, :message)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':conversation_id', $conversation_id);
            $stmt->bindParam(':user_id', $user_id);
            $stmt->bindParam(':message', $message);
            if($stmt->execute()){
                return true;
            }else{
                return false;
            }
            
        }
        
    }
?>