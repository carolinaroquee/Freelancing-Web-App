<?php
require_once('../utils/session.php');
require_once('../database/connection.db.php');

$session = new Session();

if (!$session->isLoggedIn()) {
    header('Location: ../pages/login.php');
    exit;
}

$db = getDatabaseConnection();

$booking_id = (int)$_POST['booking_id'];
$rating = (int)$_POST['rating'];
$comment = $_POST['comment'] ?? '';
$client_id = $session->getId();

// Verifica se a reserva pertence ao cliente
$sql = "SELECT * FROM Booking WHERE booking_id = ? AND cliente_id = ?";
$stmt = $db->prepare($sql);
$stmt->execute([$booking_id, $client_id]);
$booking = $stmt->fetch(PDO::FETCH_ASSOC);

// Verifica se a reserva já foi avaliada
$sql = "SELECT * FROM Review WHERE booking_id = ?";
$stmt = $db->prepare($sql);
$stmt->execute([$booking_id]);
$existing_review = $stmt->fetch(PDO::FETCH_ASSOC);

if ($existing_review) {
    // Se já existe uma avaliação, atualiza a avaliação
    $sql = "UPDATE Review SET rating = ?, comment = ?, data_avaliacao = ? WHERE booking_id = ?";
    $stmt = $db->prepare($sql);
    $stmt->execute([$rating, $comment, date('Y-m-d'), $booking_id]);

    // Mensagem de sucesso
    $session->addMessage('success', 'Review updated successfully!');
} else {
    // Caso não haja uma avaliação, insere uma nova avaliação
    $sql = "INSERT INTO Review (booking_id, rating, comment, data_avaliacao) VALUES (?, ?, ?, ?)";
    $stmt = $db->prepare($sql);
    $stmt->execute([$booking_id, $rating, $comment, date('Y-m-d')]);

    // Mensagem de sucesso
    $session->addMessage('success', 'Review sent successfully!');
}


header('Location: ../pages/service_detail.php?id=' . $booking['service_id']);
exit;
?>
