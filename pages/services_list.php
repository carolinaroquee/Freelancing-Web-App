<?php
    require_once(__DIR__. '/../templates/common.tpl.php');    
    require_once(__DIR__.'/../database/connection.db.php');
    require_once(__DIR__.'/../database/service.class.php');
    require_once(__DIR__.'/../database/categories.php');
    require_once(__DIR__. '/../templates/services.tpl.php');    


    $session = new Session();
    $db = getDatabaseConnection();
    $categories = getAllCategories($db);
    $category = (!empty ($_GET['category'])) ? $_GET['category'] : null;
    $service = (!empty ($_GET['service_type'])) ? $_GET['service_type'] : null;
    $min_price = (!empty($_GET['min_price'])) ? floatval($_GET['min_price']) : null;
    $max_price = (!empty($_GET['max_price'])) ? floatval($_GET['max_price']) : null;
    $min_rating = (isset($_GET['min_rating']) && is_numeric($_GET['min_rating'])) ? $_GET['min_rating'] : null;   
    $max_rating = (isset($_GET['max_rating']) && is_numeric($_GET['max_rating'])) ? $_GET['max_rating'] : null;


    $services = getServices($db,$category,$service,$min_price,$max_price,$min_rating,$max_rating);
    drawHeader($session);
    drawServices($services,$category,$service);
    drawFooter($categories);

    ?>