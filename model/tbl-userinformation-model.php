<?php 
    
    
    class UserInformation{
        
        private $pdo;

        public function __construct($pdo) {
            $this->pdo = $pdo;
        }
        public function insertInforamtionHandler($id, $firstname, $lastname, $contact, $position, $office, $office_code, $email, $role){
          
                //code...
                $sql = "INSERT INTO tbl_userinformation (id, firstname, lastname, contact, position, office, office_code, email, role, status) VALUES (:id, :firstname, :lastname, :contact, :position, :office, :office_code, :email, :role, 'pending')";
                $stmt = $this->pdo->prepare($sql);
                $stmt->bindParam(':id', $id);
                $stmt->bindParam(':firstname', $firstname);
                $stmt->bindParam(':lastname', $lastname);
                $stmt->bindParam(':contact', $contact);
                $stmt->bindParam(':position', $position);
                $stmt->bindParam(':office', $office);
                $stmt->bindParam(':office_code', $office_code);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':role', $role);
                $stmt->execute();

                return true;

            

        }

        public function insertInforamtionGuest($id, $firstname, $lastname, $contact, $email, $role){
          
                //code...
                $sql = "INSERT INTO tbl_userinformation (id, firstname, lastname, contact, email, role, status) VALUES (:id, :firstname, :lastname, :contact, :email, :role, 'pending')";
                $stmt = $this->pdo->prepare($sql);
                $stmt->bindParam(':id', $id);
                $stmt->bindParam(':firstname', $firstname);
                $stmt->bindParam(':lastname', $lastname);
                $stmt->bindParam(':contact', $contact);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':role', $role);
                $stmt->execute();

                return true;

            

        }
        public function updateInfoById($id, $firstname, $lastname, $contact, $position, $email, $office, $office_code){
         
                //code...
                $sql = "UPDATE tbl_userinformation SET firstname = :firstname, lastname = :lastname, contact = :contact, position = :position, email = :email, office = :office, office_code = :office_code WHERE id = :id";
                $stmt = $this->pdo->prepare($sql);
                $stmt->bindParam(':id', $id);
                $stmt->bindParam(':firstname', $firstname);
                $stmt->bindParam(':lastname', $lastname);
                $stmt->bindParam(':contact', $contact);
                $stmt->bindParam(':position', $position);
                $stmt->bindParam(':office_code', $office_code);
                $stmt->bindParam(':office', $office);
               
                $stmt->bindParam(':email', $email);
                $stmt->execute();
                return true;

        }

        public function findUserInfoById($id){
        
                $sql = "SELECT * from tbl_userinformation where id = :id";
                $stmt = $this->pdo->prepare($sql);
                $stmt->bindParam(':id', $id);
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);

                return $result;
                

        }
        
        public function findUserInfoByOffice($office){
        
                $sql = "SELECT * from tbl_userinformation where office = :office";
                $stmt = $this->pdo->prepare($sql);
                $stmt->bindParam(':office', $office);
                if($stmt->execute()){
                        $result = $stmt->fetch(PDO::FETCH_ASSOC);
                
                        return $result;
                }else{
                        return false;
                }
                
        }

        public function getInfobyRole(){
                $sql = "SELECT id, email from tbl_userinformation where role = 'admin'";
                $stmt = $this->pdo->prepare($sql);
                if($stmt->execute()){
                        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        return $result;
                }else{
                        return false;
                }
        }


        public function findEmail($email){
         
                $sql = "SELECT * from tbl_userinformation where email = :email";
                $stmt = $this->pdo->prepare($sql);
                $stmt->bindParam(':email', $email);
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);

                return $result;
                

        }

        public function getEmailById($id){
      
                $sql = "SELECT email from tbl_userinformation where id = :id";
                $stmt = $this->pdo->prepare($sql);
                $stmt->bindParam(':id', $id);
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);

                return $result;
                

        }
        public function getInfoByOfficeName($office){
 
                $sql = "SELECT * from tbl_userinformation where office = :office";
                $stmt = $this->pdo->prepare($sql);
                $stmt->bindParam(':office', $office);
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);

                return $result;
                

        }

        public function getAllInfoByOfficeName($office){
 
                $sql = "SELECT * from tbl_userinformation where office = :office";
                $stmt = $this->pdo->prepare($sql);
                $stmt->bindParam(':office', $office);
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                return $result;
                

        }
        
        public function getAllInfoByOfficeCode($office){
 
                $sql = "SELECT * from tbl_userinformation where office_code = :office";
                $stmt = $this->pdo->prepare($sql);
                $stmt->bindParam(':office', $office);
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                return $result;
                

        }

        public function settingsUpdateInfoWithPic($user_id, $profile, $firstname, $lastname, $contact, $position){
                $sql = "UPDATE tbl_userinformation SET user_profile = :profile, firstname = :firstname, lastname = :lastname, contact = :contact, position = :position WHERE id = :id";
                $stmt = $this->pdo->prepare($sql);
                $stmt->bindParam(':id', $user_id);
                $stmt->bindParam(':profile', $profile);
                $stmt->bindParam(':firstname', $firstname);
                $stmt->bindParam(':lastname', $lastname);
                $stmt->bindParam(':contact', $contact);
                $stmt->bindParam(':position', $position);
               
 
                if($stmt->execute()){
                        return true;
                }else{
                        return false;
                }
         
        }

        public function settingsUpdateInfoWithoutPic($user_id, $firstname, $lastname, $contact, $position){
                $sql = "UPDATE tbl_userinformation SET firstname = :firstname, lastname = :lastname, contact = :contact, position = :position WHERE id = :id";
                $stmt = $this->pdo->prepare($sql);
                $stmt->bindParam(':id', $user_id);
                $stmt->bindParam(':firstname', $firstname);
                $stmt->bindParam(':lastname', $lastname);
                $stmt->bindParam(':contact', $contact);
                $stmt->bindParam(':position', $position);
                
 
                if($stmt->execute()){
                        return true;
                }else{
                        return false;
                }
         
        }

        public function updateStatus($id, $status){
                $sql = "UPDATE tbl_userinformation set status = :status where id = :id";
                $stmt = $this->pdo->prepare($sql);
                $stmt->bindParam(':id', $id);
                $stmt->bindParam(':status', $status);
                if($stmt->execute()){
                        return true;
                }else{
                        return false;
                }
        }

     

        
    }

  
    







?>