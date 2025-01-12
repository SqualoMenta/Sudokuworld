<?php
include_once("../includes/bootstrap.php");
include_once("../includes/functions.php");

include '../includes/header.php';
// TODO: testare che lo sconto del 10% se hai risolto il sudoku funzioni
?>

<style>
    /* Make the table smaller */
    table {
        width: 100%;
        height: 100%;
        table-layout: fixed;
        /* Adjust this to make the table smaller, e.g., 50% of viewport height */
        margin: 0 auto;
        /* Centers the table */
    }

    /* Make each cell square */
    td {
        padding: 0;
        width: 11.1%;
        position: relative;
        padding-bottom: 11.1%;
        text-align: center;
        vertical-align: middle;
    }

    /* Input field inside the table cell */
    td div {
        align-items: center;
        justify-content: center;
        height: 100%;
    }

    input[type="number"] {
        width: 100%;
        height: 100%;
        text-align: center;
        border: none;
        outline: none;
        box-sizing: border-box;
        font-size: 2rem;
        padding: 0;
    }
</style>

<main>
    <div class="row m-4">
        <div class="col-lg-8 mb-4">
            <section class="container border border-primary p-4 rounded">
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
                <form class="container" style="aspect-ratio: 1; max-width: 800px;">
                    <table id="sudokuTable" class="table table-bordered border border-dark">
                        <!-- <tbody>
                            <?php
                            for ($i = 0; $i < 9; $i++) : ?>
                                <tr>
                                    <?php for ($j = 0; $j < 9; $j++) : ?>
                                        <td scope="col" class="text-center">
                                            <div>
                                                <input type="number" min="1" max="9" class="w-100 h-100 text-center" value="" data-i="<?= $i ?>"
                                                    data-j="<?= $j ?>">
                                            </div>
                                        </td>
                                    <?php endfor ?>
                                </tr>
                            <?php endfor ?>
                        </tbody> -->
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