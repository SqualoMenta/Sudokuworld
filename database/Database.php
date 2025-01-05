<?php

require_once 'Seller.php';
require_once 'SudokuRunner.php';

class Database
{
    private $db;
    public $seller;
    public $sudokuRunner;

    public function __construct($servername, $username, $password, $dbname, $port)
    {
        $this->db = new mysqli($servername, $username, $password, $dbname, $port);
        if ($this->db->connect_error) {
            die("Connection failed: " . $this->db->connect_error);
        }

        $this->seller = new Seller($this);
        $this->sudokuRunner = new SudokuRunner($this);
    }

    public function query($query, $param_types, ...$params)
    {
        $stmt = $this->db->prepare($query);
        if ($param_types !== '') {
            $stmt->bind_param($param_types, ...$params);
        }
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function query2($query, $param_types, ...$params)
    {
        $stmt = $this->db->prepare($query);
        if ($param_types !== '') {
            $stmt->bind_param($param_types, ...$params);
        }
        $stmt->bind_param($param_types, ...$params);
        $stmt->execute();
    }

    public function isProductInCart($email, $id_product)
    {
        $query = "SELECT * FROM CART WHERE email = ? AND id_product = ?";
        return count($this->query($query, 'si', $email, $id_product)) > 0;
    }

    public function addProductToCart($email, $id_product)
    {
        $query = "INSERT INTO CART (email, id_product) VALUES (?, ?)";
        $this->query2($query, 'si', $email, $id_product);
    }

    public function removeProductFromCart($email, $id_product)
    {
        $query = "DELETE FROM CART WHERE email = ? AND id_product = ?";
        $this->query2($query, 'si', $email, $id_product);
    }

    public function emptyCart($email)
    {
        $query = "DELETE FROM CART WHERE email = ?";
        $this->query2($query, 's', $email);
    }

    public function getCart($email)
    {
        return $this->query("SELECT id_product FROM CART where email = ?", 's', $email);
    }

    // public function getProduct($id)
    // {
    //     $query = "SELECT * FROM PRODUCT p
    //     WHERE id_product = ?";
    //     return $this->query($query, 'i', $id);
    // }

    // TODO: le funzioni che ritornano dei prodotto non devono ritornare prodotti con removed = 1,
    // tranne la funzione getProduct.
    public function getProduct($id)
    {
        $query = "SELECT * FROM PRODUCT p WHERE id_product = ?";
        return $this->query($query, 'i', $id);
    }

    public function getProductDetailed($id) //TODO: wrong
    {
        $query = "SELECT * FROM PRODUCT p
        LEFT JOIN IS_COLOR ic ON ic.id_product = p.id_color 
        LEFT JOIN DIMENSION dim ON dim.id_product = p.id_color
        LEFT JOIN IS_CATEGORY icat ON icat.id_product = p.id_color
        WHERE id_product = ?";
        return $this->query($query, 'i', $id);
    }

    public function searchProducts()
    {
        $query = "SELECT p.id_product 
        FROM PRODUCT p 
        JOIN ORDERS_ITEM oi ON p.id_product = oi.id_product 
        GROUP BY p.id_product 
        ORDER BY COUNT(oi.id_product) DESC";
        return $this->query($query, '');
    }

    public function filteredSearchProduct($name = null, $minPrice = null, $maxPrice = null, $category = null, $color = null, $dimension = null, $is_discount = false, $seller = null)
    {
        // Inizia con la base della query
        $query = "SELECT p.id_product 
        FROM PRODUCT p 
        LEFT JOIN ORDERS_ITEM oi ON p.id_product = oi.id_product
        LEFT JOIN IS_COLOR ic ON p.id_product = ic.id_product 
        LEFT JOIN DIMENSION d ON p.id_product = d.id_product
        LEFT JOIN IS_CATEGORY icat ON p.id_product = icat.id_product 
        WHERE 1=1"; // 1=1 è una base sempre vera per concatenare le condizioni dinamiche

        // Array per raccogliere i parametri
        $params = [];
        $types = '';

        // Aggiungi le condizioni solo se i parametri non sono nulli o vuoti
        if (!empty($name)) {
            $query .= " AND p.name LIKE ?";
            $params[] = "%$name%";
            $types .= 's'; // Tipo stringa
        }

        if (!empty($minPrice)) {
            $query .= " AND p.price >= ?";
            $params[] = $minPrice;
            $types .= 'i'; // Tipo intero
        }

        if (!empty($maxPrice)) {
            $query .= " AND p.price <= ?";
            $params[] = $maxPrice;
            $types .= 'i';
        }

        if (!empty($color)) {
            $query .= " AND ic.color = ?";
            $params[] = $color;
            $types .= 's';
        }

        if (!empty($dimension)) {
            $query .= " AND d.dimension = ?";
            $params[] = $dimension;
            $types .= 's';
        }

        if ($is_discount) {
            $query .= " AND p.discount > 0";
        }

        if (!empty($category)) {
            $query .= " AND icat.tag = ?";
            $params[] = $category;
            $types .= 's';
        }

        if (!empty($seller)) {
            $query .= " AND p.email = ?";
            $params[] = $seller;
            $types .= 's';
        }

        // if (empty($name)) {
        //     $query .= "ORDER BY COUNT(oi.id_product) DESC";
        // } else {
        //     $query .= "ORDER BY 
        //         CASE 
        //             WHEN p.name = ? THEN 1 -- Nomi esatti
        //             WHEN p.name LIKE ? THEN 2 -- Nomi simili
        //         END,
        //         p.id_product";
        //     $params[] = $name;
        //     $params[] = "%$name%";
        //     $types .= 'ss';
        // }

        // Esegui la query con i parametri raccolti
        echo $query;
        echo $types;
        var_dump($params);
        return $this->query($query, $types, ...$params);
    }


    // public function searchProductsInDiscount()
    // {
    //     $query = "SELECT p.id_product 
    //     FROM PRODUCT p, DISCOUNT d 
    //     WHERE d.id_discount = p.id_discount";
    //     return $this->query($query, '');
    // }

    // public function searchProductByCategory($category)
    // {
    //     $query = "SELECT p.id_product 
    //     FROM PRODUCT p JOIN IS_CATEGORY ic ON p.id_product = ic.id_product 
    //     WHERE ic.tag = ?";
    //     return $this->query($query, 's', $category);
    // }

    public function searchProductByName($productName)
    {
        $query = "
            SELECT p.id_product
            FROM PRODUCT p
            WHERE p.name LIKE ?
            ORDER BY 
                CASE 
                    WHEN p.name = ? THEN 1 -- Nomi esatti
                    WHEN p.name LIKE ? THEN 2 -- Nomi simili
                END,
                p.id_product
        ";

        return $this->query($query, 'sss', "%$productName%", $productName, "%$productName%");
    }

    public function getUser($email)
    {
        return $this->query("SELECT * FROM USER WHERE email = ?", 's', $email);
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
    public function registerUser()
    {
        $query = "INSERT INTO USER (name, email, password, seller) VALUES (?, ?, ?, ?)";
        $this->query2($query, 'sssi', $_POST['name'], $_POST['email'], password_hash($_POST['password'], PASSWORD_DEFAULT), 0);
    }

    public function isProductInWishlist($email, $id_product)
    {
        $query = "SELECT * FROM WISHES WHERE id_product = ? AND email = ?";
        return count($this->query($query, 'is', $id_product, $email)) > 0;
    }

    public function addProductToWishlist($email, $id_product)
    {
        $query = "INSERT INTO WISHES (id_product, email) VALUES (?, ?)";
        $this->query2($query, 'is', $id_product, $email);
    }

    public function removeProductFromWishlist($email, $id_product)
    {
        $query = "DELETE FROM WISHES WHERE id_product = ? AND email = ?";
        $this->query2($query, 'is', $id_product, $email);
    }

    public function getWishlist($email)
    {
        return $this->query("SELECT p.id_product FROM WISHES w JOIN PRODUCT p ON w.id_product = p.id_product WHERE w.email = ?", 's', $email);
    }


    public function addOrder($email, $id_products, $price)
    {
        $query1 = "INSERT INTO ORDERS (day, email, price) VALUES (CURDATE(), ?, ?)";
        $this->query2($query1, 'si', $email, $price);
        $id_order = $this->db->insert_id;
        $query2 = "INSERT INTO ORDERS_ITEM (id_product, id_order) VALUES (?, ?)";
        foreach ($id_products as $id_product) {
            $this->query2($query2, 'is', $id_product['id_product'], $id_order);
        }
    }

    public function getOrders($email)
    {
        return $this->query("SELECT o.id_order, o.day, oi.id_product FROM ORDERS o JOIN ORDERS_ITEM oi ON o.id_order = oi.id_order WHERE o.email = ?", 's', $email);
    }

    public function deleteOrderIfPossible($email, $id_order)
    {
        $query = "SELECT * FROM ORDERS WHERE email = ? AND id_order = ?";
        $orders = $this->query($query, 'si', $email, $id_order);
        $order = $orders[0];
        $orderDate = new DateTime($order['day']);
        $currentDate = new DateTime();
        $interval = $currentDate->diff($orderDate);
        if ($interval->days > 3) {
            return;
        }
        $query = "DELETE FROM ORDERS WHERE email = ? AND id_order = ?";
        $this->query2($query, 'si', $email, $id_order);
    }

    public function addCreditCard($email, $number, $name, $surname, $expiration)
    {
        $query = "INSERT INTO CREDIT_CARD (email, number, name, surname, expiration) VALUES (?, ?, ?, ?, ?)";
        $this->query2($query, 'sssss', $email, $number, $name, $surname, $expiration);
    }

    public function removeCreditCard($email, $number)
    {
        $query = "DELETE FROM CREDIT_CARD WHERE email = ? AND number = ?";
        $this->query2($query, 'ss', $email, $number);
    }

    public function getCreditCards($email)
    {
        return $this->query("SELECT * FROM CREDIT_CARD WHERE email = ?", 's', $email);
    }

    public function getAllCategories()
    {
        return $this->query("SELECT tag FROM CATEGORY", '');
    }

    public function getAllColors()
    {
        return $this->query("SELECT color FROM COLOR", '');
    }

    public function getAllDimensions()
    {
        return $this->query("SELECT tag FROM SIZE", '');
    }
}
