<?php
require_once('../utils/session.php');
require_once('../database/connection.db.php');

$session = new Session();
if (!$session->isLoggedIn()) {
    header('Location: ../pages/login.php');
    exit;
}

$db = getDatabaseConnection();

if (!isset($_GET['booking_id'])) {
    die('Unspecified reserve.');
}

$booking_id = (int)$_GET['booking_id'];
$client_id = $session->getId();

// Verifica se reserva pertence ao cliente e está pendente
$sql = "SELECT data_agendamento, status FROM Booking WHERE booking_id = ? AND cliente_id = ?";
$stmt = $db->prepare($sql);
$stmt->execute([$booking_id, $client_id]);
$booking = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$booking) {
    die('Reservation not found.');
}

if ($booking['status'] !== 'pendente') {
    die('Reservation cannot be cancelled.');
}

if ($booking['data_agendamento'] <= date('Y-m-d')) {
    die('You cannot cancel reservations with a past date or todays date.');
}

// Atualiza para cancelado
$sql = "UPDATE Booking SET status = 'cancelado' WHERE booking_id = ?";
$stmt = $db->prepare($sql);
$stmt->execute([$booking_id]);

$session->addMessage('success', 'Reservation cancelled successfully.');
header('Location: ../pages/client_bookings.php');
exit;
