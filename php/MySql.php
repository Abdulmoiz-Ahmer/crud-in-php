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

    function retreiveDataFromSimilarCategory($category, $status,$userId)
    {
        try {
            $stmt = $this->conn->prepare("select u.userId,u.userName,c.categoryName,s.statusValue from (((Categories c join UsersRelation r on c.categoryId = r.categoryId) join Users u on r.userId = u.userId) join Status s on s.statusId = r.statusId ) where c.parentId = :parentId and s.statusId=:statusId and u.userId != :userId");
            $stmt->bindParam(':parentId', $category);
            $stmt->bindParam(':statusId', $status);
            $stmt->bindParam(':userId',$userId);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $result = $stmt->fetchAll();
            if (count($result) > 0) {
                return $result;
            } else {
                return $result;
            }
        } catch (PDOException $exp) {
            return $exp->getMessage();
        }
    }

    function login($name, $password)
    {
        try {
            $stmt = $this->conn->prepare("select Users.userId as uid, UsersRelation.typeId as tid, UsersRelation.statusId as stid, UsersRelation.categoryId as sid,Categories.parentId as cid from ((Users join UsersRelation on UsersRelation.userId=Users.userId) join Categories on UsersRelation.categoryId=Categories.categoryId) where Users.userName = :userName and Users.password = :password limit 1");
            $stmt->bindParam(':userName', $name);
            $stmt->bindParam(':password', $password);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $result = $stmt->fetchAll();
            if (count($result) > 0) {
                $user = new UserObj($result[0]["uid"]);
                $user->setStatus($result[0]["stid"]);
                $user->setSubCategory($result[0]["sid"]);
                $user->setType($result[0]["tid"]);
                $user->setCategory($result[0]["cid"]);
                $user->setUserName($name);
                return $user;
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
    private $category;
    private $name;

    function __construct($userId)
    {
        $this->userId = $userId;
    }

    public function setSubCategory($subcategory)
    {
        $this->subcategory = $subcategory;
    }

    public function setStatus($statusId)
    {
        $this->statusId = $statusId;
    }

    public function setType($typeId)
    {
        $this->typeId = $typeId;
    }

    public function setUserName($name)
    {
        $this->name = $name;
    }

    public function setCategory($category)
    {
        $this->category = $category;
    }

    public function getUserName()
    {
        return $this->name;
    }

    public function getCategory()
    {
        return $this->category;
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

?>