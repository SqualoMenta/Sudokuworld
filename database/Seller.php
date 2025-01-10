<?php
class Seller
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function insertProduct($name, $description, $price, $image, $email, $discount, $availability)
    {
        $query = "INSERT INTO PRODUCT (name, price, description, image, email, discount, availability, removed) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $this->db->query2($query, 'sisssii', $name, $price, $description, $image, $email, $discount, $availability, 0);
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
        $query = "INSERT INTO IS_CATEGORY (id_product, category_tag) VALUES (?, ?)";
        $this->db->query2($query, 'is', $id_product, $category);
    }

    public function removeProductCategory($id_product, $category)
    {
        $query = "DELETE FROM IS_CATEGORY WHERE id_product = ? AND category_tag = ?";
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
        $query = "UPDATE PRODUCT SET discount = ? WHERE id_product = ?";
        $this->db->query2($query, 'ii', $percentage, $id_product);
    }

    public function removeDiscount($id_product)
    {
        $query = "UPDATE PRODUCT SET discount = 0 WHERE id_product = ?";
        $this->db->query2($query, 'i', $id_product);
    }

    public function getProductsSoldBy($email)
    {
        $query = "SELECT id_product FROM PRODUCT WHERE email = ?";
        return $this->db->query($query, 's', $email);
    }

    public function deleteProduct($id_product)
    {
        // TODO: rimuovere dal carrello e whishlist?
        $query = "UPDATE PRODUCT SET removed = 1 WHERE id_product = ?";
        $this->db->query2($query, 'i', $id_product);
    }

    public function updateProduct($id_product, $name = null, $description = null, $price = null, $img = null, $category = null, $discount = -1, $availability = null)
    {
        $query = "UPDATE PRODUCT SET id_product = id_product";

        $params = [];
        $types = '';

        if ($name != null) {
            $query .= ", name = ?";
            $params[] = $name;
            $types .= 's';
        }

        if ($description != null) {
            $query .= ", description = ?";
            $params[] = $description;
            $types .= 's';
        }

        if ($price != null) {
            $query .= ", price = ?";
            $params[] = $price;
            $types .= 'i';
        }

        if ($img != null) {
            $query .= ", image = ?";
            $params[] = $img;
            $types .= 's';
        }

        if ($category != null) {
            $query .= ", category_tag = ?";
            $params[] = $category;
            $types .= 's';
        }
        
        if ($discount != -1) {
            $query .= ", discount = ?";
            $params[] = $discount;
            $types .= 'i';
        }

        if ($availability != null) {
            $query .= ", availability = ?";
            $params[] = $availability;
            $types .= 'i';
        }

        $query .= " WHERE id_product = ?";
        $params[] = $id_product;
        $types .= 'i';

        $this->db->query2($query, $types, ...$params);
    }
}
