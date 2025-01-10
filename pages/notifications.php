<?php
include_once("../includes/bootstrap.php");
include_once("../includes/functions.php");


if (!isUserLoggedIn()) {
    header("Location: login.php");
    exit;
}

$notifications = $db->getNotifications($_SESSION["email"]);

include_once("../includes/header.php");
?>

<div class="container my-4">
    <h1 class="mb-4">Notifiche</h1>
    <div class="list-group">
        <?php foreach ($notifications as $notify) : ?>
            <div class="list-group-item d-flex justify-content-between align-items-center <?= $notify['seen'] ? 'list-group-item-secondary' : '' ?>">
                <div>
                    <h5 class="mb-1"><?= htmlspecialchars($notify["title"]) ?></h5>
                    <p class="mb-1"><?= htmlspecialchars($notify["description"]) ?></p>
                </div>
                <form method="POST" action="mark_as_read.php">
                    <input type="hidden" name="id_notification" value="<?= htmlspecialchars($notify['id_notification']) ?>">
                    <?php if (!$notify['seen']) : ?>
                        <button type="submit" class="btn btn-primary btn-sm">Mark as Read</button>
                    <?php else : ?>
                        <button type="button" class="btn btn-secondary btn-sm" disabled>Read</button>
                    <?php endif; ?>
                </form>
            </div>
        <?php endforeach; ?>
    </div>
</div>