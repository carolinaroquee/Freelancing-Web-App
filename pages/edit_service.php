<?php
declare(strict_types=1);

require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../templates/services.tpl.php');
require_once(__DIR__ . '/../templates/common.tpl.php');
require_once('../database/categories.php'); 


$session = new Session();

if (!$session->isLoggedIn() || $session->getUserType() !== 'tutor') {
    header('Location: ../pages/login.php');
    exit;
}

$db = getDatabaseConnection();
$categories  = getAllCategories($db);
$freelancer_id = $session->getId();

$service_id = (int)$_GET['id'];

// Buscar dados do serviço
$sql = "SELECT * FROM Service WHERE service_id = ?";
$stmt = $db->prepare($sql);
$stmt->execute([$service_id]);
$service = $stmt->fetch(PDO::FETCH_ASSOC);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $title = $_POST['title'] ?? '';
    $category_name = $_POST['category_name'] ?? '';
    $description = $_POST['description'] ?? '';
    $duracao = (int)($_POST['duracao'] ?? 0);
    $price = (float)($_POST['price'] ?? 0);
    $service_type = $_POST['service_type'] ?? '';
    $num_sessoes = (int)($_POST['num_sessoes'] ?? 0);
    $max_students = isset($_POST['max_students']) ? (int)$_POST['max_students'] : null;


    $sql = "UPDATE Service SET title = ?, category_name = ?, description = ?, duracao = ?, price = ?, service_type = ?, num_sessoes = ?, max_students = ? WHERE service_id = ?";
    $stmt = $db->prepare($sql);
    $stmt->execute([$title, $category_name, $description, $duracao, $price, $service_type, $num_sessoes, $max_students, $service_id]);

    header("Location: services_manage.php");
    exit;
}

drawHeader($session);
drawEditServiceForm($service, $categories);
drawFooter($categories);

?>