<?php

function isActive($pagename)
{
    if (basename($_SERVER['PHP_SELF']) == $pagename) {
        echo " class='active' ";
    }
}

function getIdFromName($name)
{
    return preg_replace("/[^a-z]/", '', strtolower($name));
}

function isUserLoggedIn()
{
    return !empty($_SESSION['email']);
}

function registerLoggedUser($user)
{
    $_SESSION["email"] = $user["email"];
    $_SESSION["name"] = $user["name"];
    $_SESSION["is_seller"] = $user["seller"];
}

function logout()
{
    session_unset();
    session_destroy();
}

function getEmptyArticle()
{
    return array("idarticolo" => "", "titoloarticolo" => "", "imgarticolo" => "", "testoarticolo" => "", "anteprimaarticolo" => "", "categorie" => array());
}

function getAction($action)
{
    $result = "";
    switch ($action) {
        case 1:
            $result = "Inserisci";
            break;
        case 2:
            $result = "Modifica";
            break;
        case 3:
            $result = "Cancella";
            break;
    }

    return $result;
}


function uploadImage($path, $image)
{
    $imageName = basename($image["name"]);
    $fullPath = $path . $imageName;

    $maxKB = 500;
    $acceptedExtensions = array("jpg", "jpeg", "png", "gif");
    $result = 0;
    $msg = "";
    //Controllo se immagine è veramente un'immagine
    $imageSize = getimagesize($image["tmp_name"]);
    if ($imageSize === false) {
        $msg .= "File caricato non è un'immagine! ";
    }
    //Controllo dimensione dell'immagine < 500KB
    if ($image["size"] > $maxKB * 1024) {
        $msg .= "File caricato pesa troppo! Dimensione massima è $maxKB KB. ";
    }

    //Controllo estensione del file
    $imageFileType = strtolower(pathinfo($fullPath, PATHINFO_EXTENSION));
    if (!in_array($imageFileType, $acceptedExtensions)) {
        $msg .= "Accettate solo le seguenti estensioni: " . implode(",", $acceptedExtensions);
    }

    //Controllo se esiste file con stesso nome ed eventualmente lo rinomino
    if (file_exists($fullPath)) {
        $i = 1;
        do {
            $i++;
            $imageName = pathinfo(basename($image["name"]), PATHINFO_FILENAME) . "_$i." . $imageFileType;
        } while (file_exists($path . $imageName));
        $fullPath = $path . $imageName;
    }

    //Se non ci sono errori, sposto il file dalla posizione temporanea alla cartella di destinazione
    if (strlen($msg) == 0) {
        if (!move_uploaded_file($image["tmp_name"], $fullPath)) {
            $msg .= "Errore nel caricamento dell'immagine.";
        } else {
            $result = 1;
            $msg = $imageName;
        }
    }
    return array($result, $msg);
}

function handleProductAvailabilityUpd($db, $id_product)
{
    $product = $db->getProduct($id_product)[0];
    $availability = $product['availability'];
    $usersTooMany = $db->getUsersWithProductInCartMoreThan($id_product, $availability);
    foreach ($usersTooMany as $user) {
        $db->removeProductFromCart($user['email'], $id_product);
        $db->addNotification($user['email'], "Disponibilità prodotto cambiata", "La disponibilità del prodotto '"
            . $product['name'] . "' è cambiata, e non è più necessaria a soddisfare il tuo carrello. Il prodotto è stato rimosso dal carrello");
    }
}

function displayProductPreviews($id_products, $db, $sudoku_solved, $sellerActions = false, $is_wishlist = false, $is_prev_order = false, $is_cart = false)
{
    echo '<div class="container-fluid mt-4"><div class="row">';
    foreach ($id_products as $id_product) {
        $productData = $db->getProduct($id_product['id_product'])[0];
        $prod = new Product(...$productData);
        if (!array_key_exists('quantity', $id_product)) {
            displayPreview($prod, $sudoku_solved, $sellerActions, $is_wishlist, $is_prev_order, 0, $is_cart);
        } else {

            displayPreview($prod, $sudoku_solved, $sellerActions, $is_wishlist, $is_prev_order, $id_product['quantity'], $is_cart);
        }
    }
    echo '</div></div>';
}

function displayPreview($product, $sudoku_solved, $sellerActions = false, $is_wishlist = false, $is_prev_order = false, $quantity = NULL, $is_cart = false)
{

    echo '
    <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-3">
        <div class="card' . ($product->isRemoved() ? '-removed' : '') . '"> 
            <img src="' . htmlspecialchars($product->getImg()) . '" class="card-img-top" alt="' . htmlspecialchars($product->getName()) . '">
            <div class="card-body">
                <h2 class="card-title">' . htmlspecialchars($product->getName()) . '</h2>';
    if (!$is_prev_order) {
        echo '
                    <p class="card-text"><strong>Prezzo:</strong> $' . number_format($product->getPrice(), 2) . '</p>';
        if ($product->getFinalDiscount($sudoku_solved) > 0) {
            echo '<p class="card-text text-danger"><strong>Prezzo scontato:</strong> $' . number_format($product->getFinalPrice($sudoku_solved), 2) . ' (' . number_format($product->getFinalDiscount($sudoku_solved), 1) . '% off)</p>';
        }
    } else {
        echo '
                    <p class="card-text"><strong>Quantità:</strong> ' . $quantity . '</p>';
    }


    echo '
        <a href="product.php?id=' . $product->getId() . '" class="btn btn-info">Vedi dettagli</a>
        ';
    if ($is_wishlist) {
        echo '<form method="post" action="#" onsubmit="return confirm(\'Sei sicuro di voler rimuovere il prodotto dalla lista desideri?\')">
            <input type="hidden" name="id_product" value="' . ($product->getId()) . '" />
            <input type="submit" value="Rimuovi dalla lista desideri" class="btn btn-danger" name="remove_wishlist" />';
    }
    if ($is_cart) {
        echo '<form method="post" action="#" onsubmit="return confirm(\'Sei sicuro di voler rimuovere il prodotto dal carrello?\')">
            <input type="hidden" name="id_product" value="' . ($product->getId()) . '" />
            <input type="submit" value="Rimuovi dal carrello" class="btn btn-danger" name="remove_cart" />
            </form>';

        echo '<form method="POST" class="d-inline-block">
            <input type="hidden" name="id_product" value="' . ($product->getId()) . '" />
                        <div class="d-flex align-items-center">
                            <button type="submit" name="action" value="decrease_cart" class="btn btn-danger me-3"' . ($quantity <= 1 ? "disabled" : "") . ' >-</button>
                            <label class="display-6 mb-0">' . $quantity . '</label>
                            <button type="submit" name="action" value="increase_cart" class="btn btn-success ms-3"' . ($product->getAvailability() <= $quantity ? "disabled" : "") . '>+</button>
                        </div>
                    </form>';
    }

    if ($sellerActions) {
        echo '
        <form method="get" action="/pages/edit_product.php">
            <input type="hidden" name="id_product" value="' . ($product->getId()) . '" />
            <input type="submit" value="Modifica" class="btn btn-warning" />
        </form>
        <form method="post" action="#" onsubmit="return confirm(\'Sei sicuro di voler rimuovere il prodotto? Questa azione è irreversibile\')">
            <input type="hidden" name="id_product" value="' . ($product->getId()) . '" />
            <input type="submit" value="Elimina" class="btn btn-danger" name="delete" />
        </form>';
    }

    echo '
            </div>
        </div>
    </div>';
}



function displayEditForm($product, $title, $categories)
{
    echo '
    <form action="#" method="POST" enctype="multipart/form-data" class="container mt-2">
        <h2 class="mb-2">' . htmlspecialchars($title) . '</h2>
            <div class="col-md-6 mb-2">
                <label for="name">Nome:</label>
                <input type="text" id="name" name="name" class="form-control" value="' . htmlspecialchars($product->getName()) . '" />
            </div>
            <div class="col-md-6 mb-2">
                <label for="price">Prezzo:</label>
                <input type="number" id="price" name="price" class="form-control" value="' . number_format($product->getPrice(), 2) . '" />
            </div>
        <div class="mb-2">
            <label for="description">Descrizione:</label>
            <input type="text" id="description" name="description" class="form-control" value="' . htmlspecialchars($product->getDescription()) . '" />
        </div>
        <div class="mb-2">
            <label for="discount">Sconto:</label>
            <input type="number" id="discount" name="discount" class="form-control" value="' . htmlspecialchars($product->getDiscount()) . '" />
        </div>
        <div class="mb-2">
            <label for="availability">Disponibilit&agrave;:</label>
            <input type="number" id="availability" name="availability" class="form-control" value="' . htmlspecialchars($product->getAvailability()) . '" />
        </div>
        <div class="mb-2">
            <label for="category">Categoria:</label>
            <select id="category" name="category" class="form-control">';
    foreach ($categories as $category) {
        $tag = $category['category_tag'];
        $selected = ($product->getCategoryTag() === $tag) ? 'selected' : '';
        echo '<option value="' . htmlspecialchars($tag) . '" ' . $selected . '>' . htmlspecialchars($tag) . '</option>';
    }
    echo '</select>
         </div>';
    echo '
            <div class="mb-2">
                <label for="image">Immagine:</label><br>
                <img class="img-review mb-2" id="imagePreview" src="' . htmlspecialchars($product->getImg()) . '" alt="Product Image"/><br>
                <input type="file" name="image" id="image" accept="image/*" class="form-control-file" onchange="previewImage(event)" />
            </div>
            <div class="mb-2 d-flex gap-1">
                <input type="submit" name="submit" value="Salva" class="btn btn-primary" formaction="/pages/seller_dashboard.php"/>
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



// function displayProductPreviewsWithQuantity($id_product, $db, $sudoku_solved, $sellerActions = false)
// {
//     echo '<div class="container-fluid mt-4"><div class="row">';
//     // foreach ($id_products as $id_product) {
//         $productData = $db->getProduct($id_product['id_product'])[0];
//         $prod = new Product(...$productData);
//         $prod->displayPreview($sudoku_solved, $sellerActions);
//         // echo '<p>Quantità: ' . $quantity . '</p>';
//     // }
//     echo '</div></div>';
// }