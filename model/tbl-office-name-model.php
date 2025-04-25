<?php




class OfficeNames
{

    private $pdo;



    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function insert($office_name, $office_code)
    {

        $sql = "INSERT INTO tbl_offices (office_name, office_code) VALUES (:office_name, :office_code)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':office_name', $office_name);
        $stmt->bindParam(':office_code', $office_code);
        $stmt->execute();
        return true;
    }

    public function checkOffice($office_name)
    {
        $sql = "SELECT * FROM tbl_offices WHERE TRIM(LOWER(office_name)) = TRIM(LOWER(:office_name))";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':office_name', $office_name);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return ($result !== false && $result !== null);
    }

    public function checkCode($office_code)
    {
        $sql = "SELECT * FROM tbl_offices WHERE TRIM(LOWER(office_code)) = TRIM(LOWER(:office_code))";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':office_code', $office_code);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return ($result !== false && $result !== null);
    }

    public function update($id, $office_name, $office_code)
    {
        $sql = "UPDATE tbl_offices set office_name = :office_name, office_code = :office_code where id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':office_name', $office_name);
        $stmt->bindParam(':office_code', $office_code);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return true;
    }

    public function findId($id)
    {
        $sql = "SELECT * from tbl_offices where id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function findOffice($office)
    {
        $sql = "SELECT * from tbl_offices where office_name = :office";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':office', $office);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }
}

