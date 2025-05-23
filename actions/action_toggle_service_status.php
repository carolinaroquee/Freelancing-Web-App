<?php
declare(strict_types=1);

require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../database/connection.db.php');

$session = new Session();

if (!$session->isLoggedIn() || $session->getUserType() !== 'tutor') {
    header('Location: ../pages/login.php');
    exit;
}

$service_id = (int)$_GET['id'];
$action = $_GET['action'];
$freelancer_id = $session->getId();

$db = getDatabaseConnection();

// Verifica se o serviço pertence ao freelancer
$sql = "SELECT freelancer_id FROM Service WHERE service_id = ?";
$stmt = $db->prepare($sql);
$stmt->execute([$service_id]);
$stmt->fetch();


$sql = "UPDATE Service SET status = ? WHERE service_id = ?";
$stmt = $db->prepare($sql);
$stmt->execute([$action, $service_id]);

// Depois de executar o update
$session->addMessage('success', "Serviço atualizado com sucesso.");

header('Location: ../pages/services_manage.php');
exit;
?>
