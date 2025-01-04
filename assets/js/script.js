let secondsElapsed = 0;
const timerElement = document.getElementById("timer");

const timerInterval = setInterval(() => {
    secondsElapsed++;

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

class Sudoku {
    #sudoku;
    #sudokuSolution;
    #playerSudoku;

    constructor(sudoku, sudokuSolution) {
        this.sudoku = sudoku;
        this.sudokuSolution = sudokuSolution;
        this.playerSudoku = sudoku;
    }

    isSudokuSolved() {
        return this.#playerSudoku === this.sudokuSolution;
    }

    insertNumber(row, column, number) {
        this.#playerSudoku[row*9 + column] = number;
    }
}


// // Aggiungi il controllo per verificare se l'utente ha risolto il Sudoku
// if ($sudokuSolved) {
//     // Marca come completato il Sudoku
//     if (isUserLoggedIn()) {
//         //$db->sudokuRunner->winSudoku($_SESSION["email"]);
//     }
//                     echo "<p class='alert alert-success'>Congratulazioni! Hai completato il Sudoku di oggi!</p>";
//                     // Ferma il timer
//                     echo "<script>clearInterval(timerInterval);</script>";
//                     echo "<script>document.getElementById('timer').classList.remove('text-success'); document.getElementById('timer').classList.add('text-danger');</script>";
//                     echo "<script>document.getElementById('timer').textContent = '00:00';</script>"; // Timer fermo
// }