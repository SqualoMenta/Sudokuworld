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

const generateSudokuTable = () => {
    const tableBody = document.createElement('tbody');

    for (let i = 0; i < 9; i++) {
        const row = document.createElement('tr');

        for (let j = 0; j < 9; j++) {
            const cell = document.createElement('td');
            const div = document.createElement('div');

            const input = document.createElement('input');
            input.type = 'number';
            input.min = 1;
            input.max = 9;
            input.id = `cell-${i}-${j}`;

            div.appendChild(input);
            cell.appendChild(div);
            row.appendChild(cell);

            let val = sudoku.initSudoku(i, j);
            if (val >= 1 && val <= 9) {
                input.value = val.toString();
                input.disabled = true;
            }
        }

        tableBody.appendChild(row);
    }

    return tableBody;
};

const table = document.getElementById("sudokuTable");
const tableBody = generateSudokuTable();

table.innerHTML = '';
table.appendChild(tableBody);

const inputs = document.querySelectorAll("input[type='number']");
inputs.forEach(input => {
    input.addEventListener("input", () => {
        handleInput(input);
    });
});

// Funzione che viene chiamata quando viene inserito un numero
function handleInput(input) {
    const i = input.id.split('-')[1];
    const j = input.id.split('-')[2];

    // Chiama il metodo insertNum della classe Sudoku
    solved = sudoku.validateInput(input, i, j);
    if (solved) {
        const data = {
            solved: 1
        };

        fetch('/api/api-sudoku.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: new URLSearchParams(data)
        })
            .then(response => response.text())
            .then(result => {
                console.log(result);
            })

        document.getElementById("success-message").classList.remove("d-none");
    }

}

let secondsElapsed = 0;

const timerInterval = setInterval(() => {
    if (!solved) {
        secondsElapsed++;

        const minutes = Math.floor(secondsElapsed / 60);
        const seconds = secondsElapsed % 60;

        timerElement.textContent = `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
        // Stoppa il timer a 99:00 minuti
        if (secondsElapsed >= 99 * 60) {
            clearInterval(timerInterval);
            timerElement.classList.remove("text-success");
            timerElement.classList.add("text-danger");
        }
    }
}, 1000);

