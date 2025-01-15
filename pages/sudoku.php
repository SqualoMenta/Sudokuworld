<?php
include_once("../includes/bootstrap.php");
include_once("../includes/functions.php");

include '../includes/header.php';
?>

<style>
    /* Make the table smaller */
    table {
        width: 100%;
        height: 100%;
        table-layout: fixed;
        margin: 0 auto;
    }

    td {
        position: relative;
        text-align: center;
        vertical-align: middle;
    }

    td div {
        align-items: center;
    }

    input[type="number"] {
        width: 100%;
        height: 100%;
        text-align: center;
        border: none;
        outline: none;
        box-sizing: border-box;
        padding: 0;
        color: blue;
    }

    input[type="number"]:disabled {
        font-weight: bold;
        background: none;
        color:black;
    }

    @media (min-width: 580px) {
        input[type="number"] {
            font-size: 2rem;
        }
    }
</style>

<main>
    <div class="row m-4">
        <div class="col-lg-8 mb-4">
            <section class="container border border-primary p-4 rounded" style="">
                <h2 class=" text-center">!! Sudoku !!</h2>
                <?php
                // Verifica se l'utente ha già risolto il Sudoku di oggi
                if (isUserLoggedIn() && $db->sudokuRunner->isTodaySudokuWon($_SESSION["email"])) {
                    echo "<p class='alert alert-success'>Hai già risolto il Sudoku di oggi!</p>";
                }
                ?>

                <div id="winMessage" style="display: none;" class="alert alert-success text-center">
                    <strong>Complimenti!</strong> Hai risolto il Sudoku di oggi!
                </div>

                <?php
                // Recupera il Sudoku del giorno
                $sudoku = $db->sudokuRunner->getTodaySudoku()[0]["grid"];
                $sudokuSolved = $db->sudokuRunner->getTodaySolution()[0]["solution"];
                ?>
                <form>
                    <table id="sudokuTable" class="table table-bordered border border-dark " style="aspect-ratio: 1; max-width: 800px;">

                    </table>
                </form>
                <div id="success-message"></div>

            </section>
        </div>

        <div class="col-lg-4">
            <section class="container border border-dark p-4 rounded">
                <h4 class="text-center">Tempo trascorso</h4>
                <div id="timer" class="text-center display-4 text-success">00:00</div>
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
            // Pass PHP variables into JavaScript
            var sudokuGrid = <?= json_encode($sudoku) ?>;
            var sudokuSolution = <?= json_encode($sudokuSolved) ?>;
        </script>

    </div>
</main>
<?php
include '../includes/footer.php';
?>

<script type="module" src="/assets/js/sudoku.js"></script>