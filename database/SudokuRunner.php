<?php
class SudokuRunner
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function isTodaySudokuWon($email)
    {
        $query = "SELECT * FROM WINS WHERE email = ? AND day = CURDATE()";
        $result = $this->db->query($query, 's', $email);
        return is_array($result) && count($result) > 0;
    }

    public function seeLastMonthSudokuSolved($email)
    {
        $query = "SELECT w.day from WINS w, USER u WHERE w.email = u.email AND u.email = ? AND w.day > DATE_SUB(CURDATE(), INTERVAL 1 MONTH)";
        return $this->db->query($query, 's', $email);
    }

    public function getSudoku($day)
    {
        return $this->db->query("SELECT * FROM SUDOKU WHERE day = ?", 's', $day);
    }

    public function getTodaySudoku()
    {
        return $this->db->query("SELECT grid FROM SUDOKU WHERE day = CURDATE()", '');
    }

    public function winSudoku($email)
    {
        $query = "INSERT INTO WINS (email, day) VALUES (?, CURDATE())";
        $this->db->query2($query, 's', $email);
    }

    public function getTodaySolution()
    {
        return $this->db->query("SELECT solution FROM SUDOKU WHERE day = CURDATE()", '');
    }
}
?>