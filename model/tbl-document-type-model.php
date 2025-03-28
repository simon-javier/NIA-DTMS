<?php 
    


    
    class DocumentType{
        
        private $pdo;



        public function __construct($pdo) {
            $this->pdo = $pdo;


        }

        public function insert($document_type){
            
            $sql = "INSERT INTO tbl_document_type (document_type) VALUES (:document_type)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':document_type', $document_type);
            $stmt->execute();
            return true;
        }

        public function checkDocument($document_type) {
            $sql = "SELECT * FROM tbl_document_type WHERE TRIM(LOWER(document_type)) = TRIM(LOWER(:document_type))";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':document_type', $document_type);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
            return ($result !== false && $result !== null);
        }

        public function update($id, $document_type){
            $sql = "UPDATE tbl_document_type set document_type = :document_type where id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':document_type', $document_type);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return true;
        }
        
        
    }
?>