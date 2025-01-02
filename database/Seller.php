<?php
class Seller{
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

    public function removeProductColor($id_product, $color)
    {
        $query = "DELETE FROM IS_COLOR WHERE id_product = ? AND color = ?";
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

    public function addProductCategory($id_product, $category)
    {
        $query = "INSERT INTO IS_CATEGORY (id_product, tag) VALUES (?, ?)";
        $this->db->query2($query, 'is', $id_product, $category);
    }

    public function removeProductCategory($id_product, $category)
    {
        $query = "DELETE FROM IS_CATEGORY WHERE id_product = ? AND tag = ?";
        $this->db->query2($query, 'is', $id_product, $category);
    }

    public function updateProductDescription($id_product, $description)
    {
        $query = "UPDATE PRODUCT SET description = ? WHERE id_product = ?";
        $this->db->query2($query, 'si', $description, $id_product);
    }

    public function updateProductPrice($id_product, $price)
    {
        $query = "UPDATE PRODUCT SET price = ? WHERE id_product = ?";
        $this->db->query2($query, 'ii', $price, $id_product);
    }

    public function updateProductImage($id_product, $img)
    {
        $query = "UPDATE PRODUCT SET image = ? WHERE id_product = ?";
        $this->db->query2($query, 'si', $img, $id_product);
    }

    public function addDiscount($id_product, $percentage)
    {
        $query="SELECT id_discount FROM DISCOUNT WHERE percentage = ?";
        $result = $this->db->query($query, 'i', $percentage);
        if(count($result) == 0)
        {
            $query = "INSERT INTO DISCOUNT (percentage) VALUES (?)";
            $this->db->query2($query, 'i', $percentage);
            $result = $this->db->insert_id;
        }
        $query ="UPDATE PRODUCT SET id_discount = ? WHERE id_product = ?";
        $this->db->query2($query, 'ii', $result, $id_product);
    }

    public function removeDiscount($id_product)
    {
        $query = "UPDATE PRODUCT SET id_discount = NULL WHERE id_product = ?";
        $this->db->query2($query, 'i', $id_product);
    }

    public function getProductsSoldBy($email){
        $query = "SELECT id_product FROM PRODUCT WHERE email = ?";
        return $this->db->query($query, 's', $email);
    }
}

?>