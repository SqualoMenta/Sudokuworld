<?php
$streak = $db->sudokuRunner->seeLastMonthSudokuSolved($_SESSION["email"]);
// var_dump($streak);
$streakDates = [];
if (!empty($streak)) {
    foreach ($streak as $entry) {
        if (isset($entry['day'])) {
            $streakDates[] = $entry['day'];
        }
    }
}
?>
<section class="container mt-4 border border-dark p-4 rounded ">
    <h4 class="text-center">La tua streak degli ultimi 30 giorni</h4>
    <div id="streakContainer" class="row mt-4"></div>
</section>

<script>
    const isLoggedIn = <?= isUserLoggedIn() ? 'true' : 'false' ?>;
    const streak = <?= json_encode($streakDates) ?>;

    if (isLoggedIn) {
        renderStreak(streak);
    }

    function renderStreak(streak) {
        const container = document.getElementById('streakContainer');

        if (streak.length === 0) {
            container.innerHTML = `
                <div class="col-12">
                    <p class="text-center alert alert-info">Non ci sono risultati negli ultimi 30 giorni</p>
                </div>`;
            return;
        }

        const today = new Date();

        for (let i = 0; i < 30; i++) {
            const dayBox = document.createElement("div");
            dayBox.classList.add("col-1", "text-center", "border", "rounded", "py-2", "mx-1", "mb-2");

            const checkDate = new Date();
            checkDate.setDate(today.getDate() - i);

            const formattedDate = checkDate.toISOString().split('T')[0];

            if (streak.includes(formattedDate)) {
                dayBox.classList.add("bg-success", "text-white");
                dayBox.textContent = checkDate.getDate() + " ✓";
            } else {
                dayBox.classList.add("bg-light");
                dayBox.textContent = checkDate.getDate();
            }

            container.appendChild(dayBox);
        }
    }
</script>