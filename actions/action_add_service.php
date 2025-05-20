<?php
    require_once(__DIR__.'/../utils/session.php');
    require_once(__DIR__.'/../database/connection.db.php');
    require_once(__DIR__.'/../database/service.class.php');

    $session = new Session();
    if (!$session->isLoggedIn()) {
        header('Location: ../pages/login.php');
        exit();
    }

    $db = getDatabaseConnection();

    // Recolhe os dados do formulário
    $title = $_POST['title'];
    $category = $_POST['category_name'];
    $description = $_POST['description'];
    $duracao = $_POST['duracao'];
    $price = $_POST['price'];
    $service_type = $_POST['service_type'];
    $num_sessoes = $_POST['num_sessoes'];
    $max_students = $_POST['max_students'] !== '' ? $_POST['max_students'] : null;

    $freelancer_id = $session->getId();
    

    $service = new Service(0,$freelancer_id,$title,$category,$description,$duracao,$price,$service_type,$num_sessoes,$max_students);

    $service->save($db);

    header('Location: ../pages/index.php');
?>