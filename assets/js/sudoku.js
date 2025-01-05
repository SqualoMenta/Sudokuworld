class Sudoku {
    #sudoku;
    #sudokuSolution;
    #playerSudoku;

    constructor(sudoku, sudokuSolution) {
        this.#sudoku = sudoku;
        this.#sudokuSolution = sudokuSolution;
        this.#playerSudoku = sudoku.split("").map(Number);
    }

    isSudokuSolved() {
        return this.#playerSudoku.join('') === this.#sudokuSolution;
    }

    insertNumber(row, col, number) {
        let i = Number(row) * 9 + Number(col);
        this.#playerSudoku[i] = number;
        return this.isSudokuSolved();
    }

    validateInput(input, row, column) {
        let value = input.value;
        if (value < 1 || value > 9) {
            input.value = '';
            return false;
        } else {
            return this.insertNumber(row, column, value);
        }
    }

    initSudoku(row, col) {
        let i = Number(row) * 9 + Number(col);
        if (this.#sudoku[i] !== 0) {
            return this.#sudoku[i];
        } else {
            return '';
        }
    }
}

let sudoku = new Sudoku(sudokuGrid, sudokuSolution);
let solved = false;
const timerElement = document.getElementById("timer");

const inputs = document.querySelectorAll("input[type='number']");
inputs.forEach(input => {
    input.addEventListener("input", () => {
        handleInput(input);
    });
    const i = input.getAttribute("data-i");
    const j = input.getAttribute("data-j");
    // Chiama il metodo initSudoku per ogni cella
    let val = sudoku.initSudoku(i, j);
    if (val >= 1 && val <= 9) {
        input.value = val.toString();
        input.disabled = true;
    }
});

// Funzione che viene chiamata quando viene inserito un numero
function handleInput(input) {
    const i = input.getAttribute("data-i");
    const j = input.getAttribute("data-j");

    // Chiama il metodo insertNum della classe Sudoku
    solved = sudoku.validateInput(input, i, j);
    if (solved) {
        const data = {
            solved: 1
        };

        fetch('/api/api-sudoku.php', {
            method: 'POST', // Specify that we are using the POST method
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded' // Tell the server that we are sending URL-encoded data
            },
            body: new URLSearchParams(data) // Convert the data object to URL-encoded string
        })
            .then(response => response.text()) // Handle the response (as text in this case)
            .then(result => {
                console.log(result); // Log the result from the server
            })

        document.getElementById("success-message").innerHTML = "<p class='alert alert-success'>Congratulazioni! Hai completato il Sudoku di oggi!</p>";
    }

}

let secondsElapsed = 0;

const timerInterval = setInterval(() => {
    if (!solved) {
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
    }
}, 1000);

