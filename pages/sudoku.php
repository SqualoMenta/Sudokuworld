<?php
include_once("../includes/bootstrap.php");
include_once("../includes/functions.php");

include '../includes/header.php';
?>

<body>
    <div class="row">
        <div class="col-lg-8 mb-4">
            <section class="container border border-primary p-4 rounded">
                <h2 class="text-center">Sezione Principale</h2>
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
                    <table class="table table-bordered border border-dark">
                        <tbody>
                            <?php
                            for ($i = 0; $i < 9; $i++) : ?>
                                <tr>
                                    <?php for ($j = 0; $j < 9; $j++) : ?>
                                        <td scope="col">
                                            <div>
                                                <input type="text" value="">
                                            </div>
                                        </td>
                                    <?php endfor ?>
                                </tr>
                            <?php endfor ?>
                        </tbody>
                    </table>
                </form>
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
                        <button id="loginButton" class="btn btn-primary" href="login.php">Vai alla pagina di login</button>
                    </div>
                </section>
            <?php else:
                include '../includes/streak.php';
            ?>
            <?php endif; ?>
        </div>



    </div>
</body>
<?php
include '../includes/footer.php';
?>
<script src="/assets/js/script.js"></script>


</script>