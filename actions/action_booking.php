<?php
require_once('../database/connection.db.php');
require_once('../utils/session.php');

$session = new Session();
$db = getDatabaseConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $service_id = intval($_POST['service_id']);
    $dates = $_POST['dates']; // array de datas
    $payment_method = $_POST['payment_method'];
    $cliente_id = $session->getId();

    foreach ($dates as $date) {
        // Insere um booking por data
        $stmt = $db->prepare('INSERT INTO Booking (cliente_id, service_id, data_agendamento, status) VALUES (?, ?, ?, ?)');
        $stmt->execute([$cliente_id, $service_id, $date, 'pendente']);
        $booking_id = intval($db->lastInsertId());

        
        $stmtPrice = $db->prepare('SELECT price FROM Service WHERE service_id = ?');
        $stmtPrice->execute([$service_id]);
        $price = $stmtPrice->fetchColumn();

        
        $stmt2 = $db->prepare('INSERT INTO Transfer (booking_id, valor, data_transacao, metodo_pagamento) VALUES (?, ?, ?, ?)');
        $stmt2->execute([$booking_id, $price, date('Y-m-d'), $payment_method]);
    }

    $session->addMessage('success', 'Reserva efetuada com sucesso!');
    header('Location: ../pages/service_detail.php?id=' . $service_id);
    exit;
}


?>