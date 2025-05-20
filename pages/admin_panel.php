<?php 
    require_once(__DIR__ . '/../templates/admin.tpl.php');    
    require_once(__DIR__.'/../database/connection.db.php');
    require_once(__DIR__ . '/../templates/common.tpl.php');
    require_once(__DIR__.'/../database/categories.php');
    require_once(__DIR__.'/../utils/session.php');



    $session = new Session();
    $db = getDatabaseConnection();
    $categories = getAllCategories($db);

    drawHeader($session);
    drawAdminPanel($session);
    drawFooter($categories);

?>