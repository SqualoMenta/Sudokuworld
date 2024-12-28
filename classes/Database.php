<?php
class Database
{
    private $db;

    public function __construct($servername, $username, $password, $dbname, $port)
    {
        $this->db = new mysqli($servername, $username, $password, $dbname, $port);
        if ($this->db->connect_error) {
            die("Connection failed: " . $this->db->connect_error);
        }
    }

    private function query($query, $param_types, ...$params)
    {
        $stmt = $this->db->prepare($query);
        $stmt->bind_param($param_types, ...$params);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    private function query2($query, $param_types, ...$params)
    {
        $stmt = $this->db->prepare($query);
        $stmt->bind_param($param_types, ...$params);
        $stmt->execute();
    }

    public function getProduct($id)
    {
        return $this->query("SELECT * FROM PRODUCT WHERE ID = ?", 'i', $id);
    }

    public function insertProduct($name, $price, $description, $img, $sellerId)
    {
        $query = "INSERT INTO PRODUCT (Name, Price, Description, Image, SEL_ID) VALUES (?, ?, ?, ?, ?)";
        $this->query2($query, 'sissi',$name, $price, $description, $img, $sellerId);
    }

    private function getUser($username)
    {
        return $this->query("SELECT Name, Email, Password FROM USER WHERE Email = ?", 's', $username);
    }
    public function checkLogin($username, $password)
    {
        $users = $this->getUser($username);
        if (count($users) == 0) {
            return [];
        }
        $user = $users[0];
        if (password_verify($password, $user['Password'])) {
            return [$user];
        }
        return [];
    }
}
