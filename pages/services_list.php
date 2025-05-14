<?php
    require_once(__DIR__. '/../templates/common.tpl.php');    
    require_once(__DIR__.'/../database/connection.db.php');
    require_once(__DIR__.'/../database/service.class.php');
    require_once(__DIR__.'/../database/categories.php');
    require_once(__DIR__. '/../templates/services.tpl.php');    


    $session = new Session();
    $db = getDatabaseConnection();
    $categories = getAllCategories($db);
    $services = getAllServices($db);

    //drawHeader($session);
    drawServices($services);
    //drawFooter($categories); 
?>