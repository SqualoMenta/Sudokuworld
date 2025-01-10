<?php
include_once("../includes/bootstrap.php");
include_once("../includes/functions.php");


if (!isUserLoggedIn()) {
    header("Location: login.php");
    exit;
}

$notifies = $db->getNotifies($_SESSION["email"]);

?>

<div>
    <h1>Notifiche</h1>
    <?php foreach ($notifies as $notify) : ?>
        <label><?= $notify["message"] ?></label>
    <?php endforeach; ?>