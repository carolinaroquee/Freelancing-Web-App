<?php
    require_once(__DIR__. '/../templates/common.tpl.php');
    require_once(__DIR__. '/../templates/user.tpl.php');
    require_once(__DIR__.'/../database/connection.db.php');
    require_once(__DIR__.'/../database/categories.php');


    $session = new Session();
    $db = getDatabaseConnection();
    $categories  = getAllCategories($db);
    $user = User::getUserbyId($db,intval($session->getId()));
    
    drawHeader($session);
    drawEditProfile($user, $session);
    drawFooter($categories);
?>