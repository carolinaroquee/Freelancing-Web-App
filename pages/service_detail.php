<?php
require_once('../database/connection.db.php');
require_once('../database/service.class.php');
require_once('../database/user.class.php');
require_once('../database/review.class.php');
require_once('../utils/session.php');
require_once(__DIR__. '/../templates/services.tpl.php'); 
require_once(__DIR__. '/../templates/booking.tpl.php'); 
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

$freelancer = User::getUserbyId($db, $service->freelancer_id);

$reviews = Review::getReviewsByServiceId($db, $service_id);

// Verifica a reserva do cliente (presumindo que o cliente já tenha feito a reserva)
$booking_sql = "SELECT * FROM Booking WHERE service_id = ? AND cliente_id = ?";
$booking_stmt = $db->prepare($booking_sql);
$booking_stmt->execute([$service_id, $session->getId()]);
$booking = $booking_stmt->fetch(PDO::FETCH_ASSOC);

drawHeader($session);
drawServiceDetail($service, $freelancer, $reviews);

drawReviewForm($booking);
drawFooter($categories);
?>
