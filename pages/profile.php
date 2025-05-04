<?php
    require_once(__DIR__. '/../templates/common.tpl.php');
    require_once(__DIR__.'/../database/connection.db.php');
    $session = new Session();
    $db = getDatabaseConnection();
    //$categories  = getAllCategories($db);
    $user = User::getUserbyId($db,$session->getId());
    //drawHeader($session);
    drawEditProfile($user);
    //drawFooter($categories);
?>