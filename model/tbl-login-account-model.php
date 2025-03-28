<?php 
    
    
    class AccountModel{
        
        private $pdo;

        public function __construct($pdo) {
            $this->pdo = $pdo;
        }
        
        public function createNewAccount($username, $password, $role){
            
         
                //code...
                $sql = "INSERT INTO tbl_login_account (username, password, role, status) VALUES (:username, :password, :role, 'pending')";
                $stmt = $this->pdo->prepare($sql);
                $stmt->bindParam(':username', $username);
                $stmt->bindParam(':password', $password);
                $stmt->bindParam(':role', $role);
                $stmt->execute();
                $lastInsertedId = $this->pdo->lastInsertId();

                return $lastInsertedId;
            
        }

        public function findUsername($username){
          
                //code...
                $sql = "SELECT * from tbl_login_account where username = :username";
                $stmt = $this->pdo->prepare($sql);
                $stmt->bindParam(':username', $username);
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                return $result;
           
        }

        public function findId($id){
          
                $sql = "SELECT * from tbl_login_account where id = :id";
                $stmt = $this->pdo->prepare($sql);
                $stmt->bindParam(':id', $id);
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                return $result;
           
        }

    

        public function changePassword($id, $password){
         
                //code...
                $sql = "UPDATE tbl_login_account set password = :passsword where id = :id";
                $stmt = $this->pdo->prepare($sql);
                $stmt->bindParam(':passsword', $password);
                $stmt->bindParam(':id', $id);
                if($stmt->execute()){
                        return true;
                }else{
                        return false;
                }
       
            
        }

        public function decline($id){
         
                //code...
                $sql = "UPDATE tbl_login_account set status = 'decline' where id = :id";
                $stmt = $this->pdo->prepare($sql);
                $stmt->bindParam(':id', $id);
                if($stmt->execute()){
                        return true;
                }else{
                        return false;
                }
       
            
        }
        public function updateStatus($id, $status){
                $sql = "UPDATE tbl_login_account set status = :status where id = :id";
                $stmt = $this->pdo->prepare($sql);
                $stmt->bindParam(':id', $id);
                $stmt->bindParam(':status', $status);
                if($stmt->execute()){
                        return true;
                }else{
                        return false;
                }
        }

        public function getDBpassword($user_id){
                $sql = "SELECT password from tbl_login_account where id = :id";
                $stmt = $this->pdo->prepare($sql);
                $stmt->bindParam(':id', $user_id);
                if($stmt->execute()){
                        $result = $stmt->fetch(PDO::FETCH_ASSOC);
                        return $result;
                }else{
                        return false;
                }
                
        }

        
    }
    







?>