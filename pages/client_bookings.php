<?php
declare(strict_types=1);

require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../templates/common.tpl.php');
require_once(__DIR__ . '/../templates/services.tpl.php');
require_once(__DIR__ . '/../templates/booking.tpl.php');
require_once(__DIR__.'/../database/categories.php');

$session = new Session();
$db = getDatabaseConnection();
$categories = getAllCategories($db);

if (!$session->isLoggedIn()) {
    header('Location: ../pages/login.php');
    exit;
}

$db = getDatabaseConnection();

$client_id = $session->getId();

$sql = "
    UPDATE Booking
    SET status = 'completo'
    WHERE status = 'pendente' AND data_agendamento < DATE('now') AND cliente_id = ?
";

$stmt = $db->prepare($sql);
$stmt->execute([$client_id]);

// Busca todas as reservas do cliente, ordenadas pela data
$sql = "
    SELECT b.booking_id, b.service_id, b.data_agendamento, b.status, s.title 
    FROM Booking b
    JOIN Service s ON b.service_id = s.service_id
    WHERE b.cliente_id = ?
    ORDER BY b.data_agendamento DESC
";

$stmt = $db->prepare($sql);
$stmt->execute([$client_id]);
$bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);

drawHeader($session);
drawClientBookingsTable($bookings);
drawFooter($categories);

?>
