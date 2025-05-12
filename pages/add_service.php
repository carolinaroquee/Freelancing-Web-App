<?php
require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/categories.php');
require_once(__DIR__ . '/../templates/common.tpl.php');

$session = new Session();
if (!$session->isLoggedIn()) {
    header('Location: login.php');
    exit();
}

$db = getDatabaseConnection();
$categories = getAllCategories($db);

drawHeader($session);

add_service_form($session);
?>


