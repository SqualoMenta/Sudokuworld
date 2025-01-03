
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <!-- Logo -->
        <a class="navbar-brand" href="/pages/home.php">SudokuWorld</a>

        <!-- Search Form -->
        <form class="d-flex" action="/pages/search.php" method="post">
            <input class="form-control me-2" type="text" name="searched-product" placeholder="Search" value="<?php if (isset($_POST['searched-product'])) echo $_POST['searched-product']; ?>">
            <button class="btn btn-outline-success" type="submit">Cerca</button>
        </form>

        <!-- Navbar Icons -->
        <ul class="navbar-nav ms-auto">
            <li class="nav-item">
                <a class="nav-link" href="#">Griglia</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Cuore</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/pages/cart.php">Carrello</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/pages/profile.php">Profilo</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Notifiche</a>
            </li>
        </ul>
    </div>
</nav>