<?php
class MySql
{

    private $conn = "";

    function create_instance()
    {
        $servername = "localhost";
        $username = "root";
        $password = "53cr3t";
        $dbname = "Colleagues";
        $dbtype = "mysql";
        try {
            $this->conn = new PDO("$dbtype:host=$servername;dbname=$dbname", $username, $password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return "ok";
        } catch (PDOException $exp) {
            return $exp->getMessage();
        }
    }

    function login($name, $password)
    {
        try {
            $stmt = $this->conn->prepare("select userId from Users where userName = :userName and password = :password limit 1");
            $stmt->bindParam(':userName', $name);
            $stmt->bindParam(':password', $password);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $result = $stmt->fetchAll();
            if (count($result) > 0) {
                $userId = $result[0]["userId"];
                $stmt = $this->conn->prepare("select typeId,statusId,subCategoryId  from UsersRelation where userId = :userId");
                $stmt->bindParam(':userId', $userId);
                $stmt->execute();
                $stmt->setFetchMode(PDO::FETCH_ASSOC);
                $result = $stmt->fetchAll();
                if (count($result) > 0) {
                    return new UserObj($userId, $result[0]["typeId"],$result[0]["statusId"],$result[0]["subCategoryId"]);
                } else {
                    return $result;
                }
            } else {
                return $result;
            }
        } catch (PDOException $exp) {
            return $exp->getMessage();
        }
    }

    function __destruct()
    {
        $conn = null;
    }
}


class UserObj
{
    private $userId;
    private $typeId;
    private $statusId;
    private $subcategory;

    function __construct($userId, $typeId, $statusId, $subcategory)
    {
        $this->userId = $userId;
        $this->typeId = $typeId;
        $this->statusId = $statusId;
        $this->subcategory = $subcategory;
    }
    public function getStatus()
    {
        return $this->statusId;
    }

    public function getSubCategory()
    {
        return $this->subcategory;
    }

    public function getId()
    {
        return $this->userId;
    }

    public function getType()
    {
        return $this->typeId;
    }
}
