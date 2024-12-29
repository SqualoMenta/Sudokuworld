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
        return $this->query("SELECT * FROM PRODUCT WHERE id_product = ?", 'i', $id);
    }

    public function insertProduct($name, $price, $description, $img, $sellerId)
    {
        $query = "INSERT INTO PRODUCT (name, price, description, image, SEL_ID) VALUES (?, ?, ?, ?, ?)";
        $this->query2($query, 'sissi',$name, $price, $description, $img, $sellerId);
    }

    public function getUser($email)
    {
        return $this->query("SELECT name, email, password FROM USER WHERE email = ?", 's', $email);
    }
    public function checkLogin($email, $password)
    {
        $users = $this->getUser($email);
        if (count($users) == 0) {
            return [];
        }
        $user = $users[0];
        if (password_verify($password, $user['password'])) {
            return [$user];
        }
        return [];
    }
    public function registerUser(){
        $query = "INSERT INTO USER (name, email, password, seller) VALUES (?, ?, ?, ?)";
        $this->query2($query, 'sssi', $_POST['name'], $_POST['email'], password_hash($_POST['password'], PASSWORD_DEFAULT), 0);
    }
}
