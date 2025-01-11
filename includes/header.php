<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<link href="/assets/css/style.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="/pages/home.php">SudokuWorld</a>

        <form class="d-flex" action="/pages/search.php" method="post">
            <input class="form-control me-2" type="text" name="searched-product" placeholder="Search" value="<?php if (isset($_POST['searched-product'])) echo $_POST['searched-product']; ?>">
            <button class="btn btn-outline-success" type="submit">Cerca</button>
        </form>

        <ul class="navbar-nav ms-auto">
            <li class="nav-item">
                <a class="nav-link" href="/pages/sudoku.php">
                    <i class="fas fa-th"></i> Griglia
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/pages/wishlist.php">
                    <i class="fas fa-heart"></i> Cuore
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/pages/cart.php">
                    <i class="fas fa-shopping-cart"></i> Carrello
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/pages/profile.php">
                    <i class="fas fa-user"></i> Profilo
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/pages/notifications.php">
                    <i class="fas fa-bell"></i> Notifiche
                </a>
            </li>
        </ul>
    </div>
</nav>