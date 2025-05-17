<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('../database/connection.db.php');
require_once('../database/service.class.php');
require_once('../database/user.class.php');
require_once('../database/review.class.php');
require_once('../utils/session.php');
require_once(__DIR__. '/../templates/services.tpl.php'); 
require_once('../database/categories.php'); 


$session = new Session();
$db = getDatabaseConnection();
$categories = getAllCategories($db);

if (!isset($_GET['id'])) {
    header('Location: services_list.php');
    exit;
}

$service_id = intval($_GET['id']);

$service = Service::getServiceById($db, $service_id);
if (!$service) {
    echo "Service not found";
    exit;
}

$freelancer = User::getUserbyId($db, $service->freelancer_id);

$reviews = Review::getReviewsByServiceId($db, $service_id);

drawHeader($session);
drawServiceDetail($service, $freelancer, $reviews);
drawFooter($categories);
?>
