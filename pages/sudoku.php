<?php
include_once("../includes/bootstrap.php");
include_once("../includes/functions.php");

include '../includes/header.php';
?>
<div class="row m-4">
    <div class="col-lg-8 mb-4">
        <section class="container border border-primary p-4 rounded">
            <h2 class="text-center">Sezione Principale</h2>
            <main>
                <?php
                // Verifica se l'utente ha già risolto il Sudoku di oggi
                if ($db->sudokuRunner->isTodaySudokuWon($_SESSION["email"])) {
                    echo "<p class='alert alert-success'>Hai già risolto il Sudoku di oggi!</p>";
                }
                ?>

                <?php
                // Recupera il Sudoku del giorno
                $sudoku = $db->sudokuRunner->getTodaySudoku();
                $sudokuSolved = $db->sudokuRunner->getTodaySudokuSolved();

                // Aggiungi il controllo per verificare se l'utente ha risolto il Sudoku
                if ($sudokuSolved) {
                    // Marca come completato il Sudoku
                    $db->sudokuRunner->winSudoku($_SESSION["email"]);
                    echo "<p class='alert alert-success'>Congratulazioni! Hai completato il Sudoku di oggi!</p>";
                    // Ferma il timer
                    echo "<script>clearInterval(timerInterval);</script>";
                    echo "<script>document.getElementById('timer').classList.remove('text-success'); document.getElementById('timer').classList.add('text-danger');</script>";
                    echo "<script>document.getElementById('timer').textContent = '00:00';</script>"; // Timer fermo
                }
                ?>
            </main>
        </section>
    </div>

    <div class="col-lg-4">
        <section class="container border border-dark p-4 rounded">
            <h4 class="text-center">Tempo trascorso</h4>
            <div id="timer" class="text-center display-4 text-success">00:00</div>
        </section>

        <?php if (!isUserLoggedIn()): ?>
            <section class="container me-4 border border-dark p-4 rounded ">
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

<script>
    let secondsElapsed = 0;
    const timerElement = document.getElementById("timer");

    const timerInterval = setInterval(() => {
        secondsElapsed++;

        // Converti i secondi in MM:SS
        const minutes = Math.floor(secondsElapsed / 60);
        const seconds = secondsElapsed % 60;

        // Mostra il timer
        timerElement.textContent = `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;

        // Stoppa il timer a 99:00 minuti
        if (secondsElapsed >= 99 * 60) {
            clearInterval(timerInterval);
            timerElement.classList.remove("text-success");
            timerElement.classList.add("text-danger");
        }
    }, 1000);
</script>
<?php
include '../includes/footer.php';
?>