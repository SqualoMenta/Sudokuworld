<?php
include_once("../includes/bootstrap.php");
include_once("../includes/functions.php");


if (!isUserLoggedIn()) {
    header("Location: login.php");
    exit;
}

if (isset($_POST["mark_as_read"])) {
    $db->markNotificationAsRead($_POST["id_notification"]);
}

$notifications = $db->getNotifications($_SESSION["email"]);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $queryString = $_SERVER['QUERY_STRING'];
    $url = $_SERVER['PHP_SELF'] . ($queryString ? '?' . $queryString : '');
    header("Location: " . $url);
}
include_once("../includes/header.php");
?>
<main>
    <div class="container my-4">
        <h1 class="mb-4">Notifiche</h1>
        <div class="list-group">
            <?php foreach ($notifications as $notify) : ?>
                <div class="list-group-item d-flex align-items-center <?= $notify['seen'] ? 'list-group-item-secondary' : '' ?>">
                    <div>
                        <p class="h5 mb-1 text-start "><?= htmlspecialchars($notify["title"]) ?></p>
                        <p class="mb-1 text-start"><?= htmlspecialchars($notify["description"]) ?></p>
                    </div>
                    <form method="POST" action="#">
                        <input type="hidden" name="mark_as_read" value="1">
                        <input type="hidden" name="id_notification" value="<?= htmlspecialchars($notify['id_notification']) ?>">
                        <?php if (!$notify['seen']) : ?>
                            <button type="submit" class="btn btn-primary btn-sm">Segna come letta</button>
                        <?php endif; ?>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</main>

<?php include_once("../includes/footer.php"); ?>