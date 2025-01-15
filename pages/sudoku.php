<?php
include_once("../includes/bootstrap.php");
include_once("../includes/functions.php");

include '../includes/header.php';
?>
<main>
    <div class="row m-4">
        <div class="col-lg-8 mb-4">
            <section class="container border border-primary p-4 rounded">
                <h1 class="container border border-black p-2 mb-4 rounded text-center">!! Sudoku !!</h1>
                <?php
                // Verifica se l'utente ha già risolto il Sudoku di oggi
                if (isUserLoggedIn() && $db->sudokuRunner->isTodaySudokuWon($_SESSION["email"])) {
                    echo "<p class='alert alert-success'>Hai già risolto il Sudoku di oggi!</p>";
                }
                ?>
                <?php
                // Recupera il Sudoku del giorno
                $sudoku = $db->sudokuRunner->getTodaySudoku()[0]["grid"];
                $sudokuSolved = $db->sudokuRunner->getTodaySolution()[0]["solution"];
                ?>
                <form>
                    <table class="sudokuTable table table-bordered border border-dark">

                    </table>
                </form>
                <div class="alert alert-success mt-4 d-none">
                    <p>Complimenti! Hai risolto il Sudoku!</p>
                </div>

            </section>
        </div>

        <div class="col-lg-4">
            <section class="container border border-dark p-4 rounded">
                <h2 class="text-center">Tempo trascorso</h2>
                <div class="timer text-center display-4 text-success">00:00</div>
            </section>

            <?php if (!isUserLoggedIn()): ?>
                <section class="container mt-4 border border-dark p-4 rounded">
                    <div class="text-center">
                        <p class="alert alert-warning">Accedi per salvare i risultati</p>
                        <a class="btn btn-primary" href="login.php">Vai alla pagina di login</a>
                    </div>
                </section>
            <?php else:
                include '../includes/streak.php';
            ?>
            <?php endif; ?>
        </div>

        <script>
            var sudokuGrid = <?= json_encode($sudoku) ?>;
            var sudokuSolution = <?= json_encode($sudokuSolved) ?>;
        </script>

    </div>
</main>
<script type="module" src="/assets/js/sudoku.js"></script>

<?php
include '../includes/footer.php';
?>