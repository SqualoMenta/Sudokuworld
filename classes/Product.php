<?php

class Product
{
    private $id;
    private $name;
    private $price;
    private $description;
    private $img;
    private $seller_email;
    private $discount;

    public function __construct($id_product, $name, $price, $description, $image, $email, $discount)
    {
        $this->id = $id_product;
        $this->name = $name;
        $this->price = $price / 100;
        $this->description = $description;
        $this->img = $image;
        $this->seller_email = $email;
        $this->discount = $discount;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getImg()
    {
        return $this->img;
    }

    public function getSellerEmail()
    {
        return $this->seller_email;
    }

    public function getDiscount()
    {
        return $this->discount;
    }

    public function displayEditForm($title)
    {
        echo '
        <form action="#" method="POST" enctype="multipart/form-data" class="container mt-4">
            <h2 class="mb-4">' . htmlspecialchars($title) . '</h2>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="name">Nome:</label>
                    <input type="text" id="name" name="name" class="form-control" value="' . htmlspecialchars($this->name) . '" />
                </div>
                <div class="col-md-6 mb-3">
                    <label for="price">Prezzo:</label>
                    <input type="number" id="price" name="price" class="form-control" value="' . number_format($this->price, 2) . '" />
                </div>
            </div>
            <div class="mb-3">
                <label for="description">Descrizione:</label>
                <input type="text" id="description" name="description" class="form-control" value="' . htmlspecialchars($this->description) . '" />
            </div>
            <div class="mb-3">
                <label for="discount">Sconto:</label>
                <input type="number" id="discount" name="discount" class="form-control" value="' . htmlspecialchars($this->discount) . '" />
            </div>
            <div class="mb-3">
                <label for="image">Immagine:</label><br>
                <img id="imagePreview" src="' . htmlspecialchars($this->img) . '" alt="Product Image" style="max-width: 100px;" class="mb-2" /><br>
                <input type="file" name="image" id="image" accept="image/*" class="form-control-file" onchange="previewImage(event)" />
            </div>
            <div class="mb-3 d-flex gap-1">
                <input type="submit" name="submit" value="Salva" class="btn btn-primary" />
                <input type="submit" value="Annulla" class="btn btn-danger" formmethod="GET" formaction="/pages/seller_dashboard.php"/>
            </div>
        </form>

    
        <script>
            function previewImage(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        // Update the image preview
                        document.getElementById("imagePreview").src = e.target.result;
                    };
                    reader.readAsDataURL(file);
                }
            }
        </script>';
    }




    // Display preview with minimal details (like an Amazon listing)
    public function displayPreview($sellerActions = false)
    {
        $discountPrice = $this->price * (1 - $this->discount / 100);

        echo '
        <div class="col-md-2 mb-4">  <!-- Added col-md-4 to display 3 items per row -->
            <div class="card" style="width: 100%;">  <!-- Set width to 100% to fill the column -->
                <img src="' . htmlspecialchars($this->img) . '" class="card-img-top" alt="' . htmlspecialchars($this->name) . '">
                <div class="card-body">
                    <h5 class="card-title">' . htmlspecialchars($this->name) . '</h5>
                    <p class="card-text"><strong>Prezzo:</strong> $' . number_format($this->price, 2) . '</p>';

        if ($this->discount > 0) {
            echo '<p class="card-text text-danger"><strong>Prezzo scontato:</strong> $' . number_format($discountPrice, 2) . ' (' . $this->discount . '% off)</p>';
        }

        echo '
                    <a href="product.php?id=' . $this->id . '" class="btn btn-info">View Details</a>';
        if ($sellerActions) {
            echo '
            <form method="get" action="/pages/edit_product.php">
                <input type="hidden" name="id_product" value="' . ($this->id) . '" />
                <input type="submit" value="Modifica" class="btn btn-warning" />
            </form>
            <form method="post" action="#">
                <input type="hidden" name="id_product" value="' . ($this->id) . '" />
                <input type="submit" value="Elimina" class="btn btn-danger" name="delete" />
            </form>';
        }

        echo '
                </div>
            </div>
        </div>';
    }


    public function displayFullPage($db)
    {
        $discountPrice = $this->price * (1 - $this->discount / 100);

        echo '
        <div class="container mt-4">
            <div class="row">
                <div class="col-md-6">
                    <img src="' . htmlspecialchars($this->img) . '" class="img-fluid" alt="' . htmlspecialchars($this->name) . '">
                </div>
                <div class="col-md-6">
                    <h2>' . htmlspecialchars($this->name) . '</h2>
                    <p><strong>Descrizione:</strong> ' . nl2br(htmlspecialchars($this->description)) . '</p>
                    <p><strong>Prezzo:</strong> $' . number_format($this->price, 2) . '</p>';

        if ($this->discount > 0) {
            echo '<p class="text-danger"><strong>Prezzo scontato:</strong> $' . number_format($discountPrice, 2) . ' (' . $this->discount . '% off)</p>';
        }

        echo '
                    <p><strong>Venditore:</strong> ' . htmlspecialchars($this->seller_email) . '</p>';

        if (isUserLoggedIn()) {
            if ($db->isProductInCart($_SESSION['email'], $this->id)) {
                echo '
                    <form action="#" method="post">
                        <input type="hidden" name="remove_from_cart" value="true">
                        <button type="submit" class="btn btn-danger">Rimuovi dal carrello</button>
                    </form>';
            } else {
                echo '
                    <form action="#" method="post">
                        <input type="hidden" name="add_to_cart" value="true">
                        <button type="submit" class="btn btn-primary">Aggiungi al carrello</button>
                    </form>';
            }
        }
        echo '
                </div>
            </div>
        </div>';
    }
}
