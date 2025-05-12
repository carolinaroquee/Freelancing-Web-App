<?php
require_once(__DIR__.'/../utils/session.php');
require_once(__DIR__.'/../database/connection.db.php');

$session = new Session();
if (!$session->isLoggedIn()) {
    header('Location: ../pages/login.php');
    exit();
}

$db = getDatabaseConnection();
$user_id = $session->getId();

// Garante que o user é freelancer
$stmt = $db->prepare('INSERT OR IGNORE INTO Freelancer (freelancer_id) VALUES (?)');
$stmt->execute([$user_id]);

// Recolhe os dados do formulário
$title = $_POST['title'];
$category = $_POST['category_name'];
$description = $_POST['description'];
$duracao = $_POST['duracao'];
$price = $_POST['price'];
$service_type = $_POST['service_type'];
$num_sessoes = $_POST['num_sessoes'];
$max_students = $_POST['max_students'] !== '' ? $_POST['max_students'] : null;

$stmt = $db->prepare('INSERT INTO Service (
    freelancer_id, title, category_name, description, duracao, price,
    service_type, num_sessoes, max_students
) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)');

$stmt->execute([
    $user_id, $title, $category, $description, $duracao, $price,
    $service_type, $num_sessoes, $max_students
]);

header('Location: ../pages/profile.php');
exit();
