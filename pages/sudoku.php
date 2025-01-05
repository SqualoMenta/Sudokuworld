<?php
include_once("../includes/bootstrap.php");
include_once("../includes/functions.php");

include '../includes/header.php';
?>

<body>
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
                    <table class="table table-bordered border border-dark">
                        <tbody>
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
                        </tbody>
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
</body>
<?php
include '../includes/footer.php';
?>
<script type="module" src="/assets/js/sudoku.js"></script>