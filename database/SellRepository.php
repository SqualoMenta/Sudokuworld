<?php
class SellRepository{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function insertProduct($name, $price, $description, $img, $sellerId, $category)
    {
        $query = "INSERT INTO PRODUCT (name, price, description, image, SEL_ID) VALUES (?, ?, ?, ?, ?)";
        $this->db->query2($query, 'sissi', $name, $price, $description, $img, $sellerId);
        $id_product = $this->db->insert_id;
        $query = "INSERT INTO IS_CATEGORY (id_product, tag) VALUES (?, ?)";
        $this->db->query2($query, 'is', $id_product, $category);
    }

    public function addProductColor($id_product, $color)
    {
        $query = "INSERT INTO IS_COLOR (id_product, color) VALUES (?, ?)";
        $this->db->query2($query, 'is', $id_product, $color);
    }

    public function addProductDimension($id_product, $dimension)
    {
        $query = "INSERT INTO DIMENSION (id_product, dimension) VALUES (?, ?)";
        $this->db->query2($query, 'is', $id_product, $dimension);
    }

    public function removeProductDimension($id_product, $dimension)
    {
        $query = "DELETE FROM DIMENSION WHERE id_product = ? AND dimension = ?";
        $this->db->query2($query, 'is', $id_product, $dimension);
    }
}

?>