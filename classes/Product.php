<?php

class Product
{
    private $id;
    private $name;
    private $price;
    private $description;
    private $img;
    private $seller_email;
    private $category_tag;
    private $discount;
    private $availability;
    private $removed;

    public function __construct($id_product, $name, $price, $description, $image, $email, $category_tag, $discount, $availability, $removed = 0)
    {
        $this->id = $id_product;
        $this->name = $name;
        $this->price = $price / 100;
        $this->description = $description;
        $this->img = $image;
        $this->seller_email = $email;
        $this->category_tag = $category_tag;
        $this->discount = $discount;
        $this->availability = $availability;
        $this->removed = $removed;
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

    public function getCategoryTag()
    {
        return $this->category_tag;
    }

    public function getDiscount()
    {
        return $this->discount;
    }

    public function getAvailability()
    {
        return $this->availability;
    }

    public function isRemoved()
    {
        return $this->removed;
    }

    public function displayEditForm($title, $categories)
    {
        echo '
    <form action="#" method="POST" enctype="multipart/form-data" class="container mt-2">
        <h2 class="mb-2">' . htmlspecialchars($title) . '</h2>
            <div class="col-md-6 mb-2">
                <label for="name">Nome:</label>
                <input type="text" id="name" name="name" class="form-control" value="' . htmlspecialchars($this->name) . '" />
            </div>
            <div class="col-md-6 mb-2">
                <label for="price">Prezzo:</label>
                <input type="number" id="price" name="price" class="form-control" value="' . number_format($this->price, 2) . '" />
            </div>
        <div class="mb-2">
            <label for="description">Descrizione:</label>
            <input type="text" id="description" name="description" class="form-control" value="' . htmlspecialchars($this->description) . '" />
        </div>
        <div class="mb-2">
            <label for="discount">Sconto:</label>
            <input type="number" id="discount" name="discount" class="form-control" value="' . htmlspecialchars($this->discount) . '" />
        </div>
        <div class="mb-2">
            <label for="availability">Disponibilit&agrave;:</label>
            <input type="number" id="availability" name="availability" class="form-control" value="' . htmlspecialchars($this->availability) . '" />
        </div>
        <div class="mb-2">
            <label for="category">Categoria:</label>
            <select id="category" name="category" class="form-control">';
        foreach ($categories as $category) {
            $tag = $category['category_tag'];
            $selected = ($this->category_tag === $tag) ? 'selected' : '';
            echo '<option value="' . htmlspecialchars($tag) . '" ' . $selected . '>' . htmlspecialchars($tag) . '</option>';
        }
        echo '</select>
         </div>';
        echo '
            <div class="mb-2">
                <label for="image">Immagine:</label><br>
                <img id="imagePreview" src="' . htmlspecialchars($this->img) . '" alt="Product Image" style="max-width: 130px;" class="mb-2" /><br>
                <input type="file" name="image" id="image" accept="image/*" class="form-control-file" onchange="previewImage(event)" />
            </div>
            <div class="mb-2 d-flex gap-1">
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


    public function displayPreview($sudoku_solved, $sellerActions = false)
    {
        echo '
        <div class="col-md-2 mb-4">  <!-- Added col-md-4 to display 3 items per row -->
            <div class="card" style="width: 100%;">  <!-- Set width to 100% to fill the column -->
                <img src="' . htmlspecialchars($this->img) . '" class="card-img-top" alt="' . htmlspecialchars($this->name) . '">
                <div class="card-body">
                    <h5 class="card-title">' . htmlspecialchars($this->name) . '</h5>
                    <p class="card-text"><strong>Prezzo:</strong> $' . number_format($this->price, 2) . '</p>';

        if ($this->discount > 0) {
            echo '<p class="card-text text-danger"><strong>Prezzo scontato:</strong> $' . number_format($this->getFinalPrice($sudoku_solved), 2) . ' (' . number_format($this->getFinalDiscount($sudoku_solved), 1) . '% off)</p>';
        }

        echo '
            <a href="product.php?id=' . $this->id . '" class="btn btn-info">Vedi dettagli</a>
            ';

        if ($sellerActions) {
            echo '
            <form method="get" action="/pages/edit_product.php">
                <input type="hidden" name="id_product" value="' . ($this->id) . '" />
                <input type="submit" value="Modifica" class="btn btn-warning" />
            </form>
            <form method="post" action="#" onsubmit="return confirm(\'Sei sicuro di voler rimuovere il prodotto? L\'azione è \')">
                <input type="hidden" name="id_product" value="' . ($this->id) . '" />
                <input type="submit" value="Elimina" class="btn btn-danger" name="delete" />
            </form>';
        }

        echo '
                </div>
            </div>
        </div>';
    }

    public function getFinalPrice($sudoku_solved)
    {
        $discountPrice = $this->price * (1 - $this->discount / 100);
        if ($sudoku_solved) {
            $discountPrice = $discountPrice * 0.9;
        }
        return $discountPrice;
    }

    public function getFinalDiscount($sudoku_solved)
    {
        return (1 - ($this->getFinalPrice($sudoku_solved) / $this->price)) * 100;
    }
}
