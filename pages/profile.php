<?php
    require_once(__DIR__. '/../templates/common.tpl.php');
    $session = new Session();
    $categories  = getAllCategories($db);
    drawHeader($session);
    
    drawFooter($categories);
?>