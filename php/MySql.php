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

    function fetchCategories()
    {
        try {
            $stmt = $this->conn->prepare("select categoryId, categoryName from Categories");
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $result = $stmt->fetchAll();
            return $result;
        } catch (PDOException $exp) {
            return $exp;
        }
    }

    function fetchStatuses()
    {
        try {
            $stmt = $this->conn->prepare("select statusId,statusValue from Status");
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $result = $stmt->fetchAll();
            return $result;
        } catch (PDOException $exp) {
            return $exp;
        }
    }

    function retreiveDataFromSimilarCategory($category, $status, $userId)
    {
        try {
            $stmt = $this->conn->prepare("select u.userId,u.userName,c.categoryName,s.statusValue from (((Categories c join UsersRelation r on c.categoryId = r.categoryId) join Users u on r.userId = u.userId) join Status s on s.statusId = r.statusId ) where c.parentId = :parentId and s.statusId=:statusId and u.userId != :userId");
            $stmt->bindParam(':parentId', $category);
            $stmt->bindParam(':statusId', $status);
            $stmt->bindParam(':userId', $userId);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $result = $stmt->fetchAll();
            return $result;
        } catch (PDOException $exp) {
            return $exp->getMessage();
        }
    }

    function allUsersDataForAdmin($offset, $limit, $type = 0)
    {
        try {
            $stmt = $this->conn->prepare("select r.userId , u.userName , u.password , c.categoryName, s.statusValue  from (((UsersRelation r join Users u on u.userId = r.userId) join Categories c on r.categoryId=c.categoryId) join Status s on r.statusId=s.statusId) where r.typeId!=:typeId order by userId limit $offset, $limit");
            $stmt->bindParam(":typeId", $type);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $result = $stmt->fetchAll();
            if (count($result) > 0) {
                return $result;
            } else {
                return $result;
            }
        } catch (PDOException $exp) {
            return $exp;
        }
    }

    function login($name, $password)
    {
        try {
            $stmt = $this->conn->prepare("select userId, password from Users where userName = :userName;");
            $stmt->bindParam(':userName', $name);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $result = $stmt->fetchAll();
            if (count($result) > 0) {
                if (password_verify($password, $result[0]["password"]) == 1) {
                    $stmt = $this->conn->prepare("select UsersRelation.typeId as tid, UsersRelation.statusId as stid, UsersRelation.categoryId as sid,Categories.parentId as cid from UsersRelation join Categories on UsersRelation.categoryId=Categories.categoryId where UsersRelation.userId=:userId limit 1;");
                    $stmt->bindParam(':userId', $result[0]["userId"]);
                    $stmt->execute();
                    $stmt->setFetchMode(PDO::FETCH_ASSOC);
                    $UserData = $stmt->fetchAll();
                    if (count($result > 0)) {
                        $user = new UserObj($result[0]["userId"]);
                        $user->setStatus($UserData[0]["stid"]);
                        $user->setSubCategory($UserData[0]["sid"]);
                        $user->setType($UserData[0]["tid"]);
                        $user->setCategory($UserData[0]["cid"]);
                        $user->setUserName($name);
                        return $user;
                    } else {
                        $result = array();
                        return $result;
                    }
                } else {
                    $result = array();
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
    private $category;
    private $name;
    private $password;

    function __construct($userId)
    {
        $this->userId = $userId;
    }

    public function setPassword($password)
    {
        $this->password = $password;
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

    public function getPassword()
    {
        return $this->password;
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
