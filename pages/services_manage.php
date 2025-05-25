<?php
declare(strict_types=1);

require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/service.class.php');
require_once(__DIR__ . '/../templates/services.tpl.php');
require_once(__DIR__ . '/../templates/common.tpl.php');
require_once('../database/categories.php'); 

$session = new Session();

if (!$session->isLoggedIn() || $session->getUserType() === 'student') {
    header('Location: ../pages/login.php');
    exit;
}

$freelancer_id = $session->getId();
$db = getDatabaseConnection();
$categories = getAllCategories($db);

$services= getServiceByFreelancerId($db, $freelancer_id);

drawHeader($session);
drawServicesManageTable($services);
drawFooter($categories);

?>
