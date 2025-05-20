<?php
    require_once(__DIR__ . '/../utils/session.php');
    require_once(__DIR__.'/../database/connection.db.php');
    require_once(__DIR__.'/../database/categories.php');

    $session = new Session();


    $name = trim($_POST['name']);

    if (empty($name)) {
        $session->addMessage('error', 'Write a category name in the box');
        header('Location: ../pages/admin_panel.php');
        exit;
    }
    $db = getDatabaseConnection();

    if (categoryExists($db, $name)) {
        $session->addMessage('error', 'There is already a category with that name');
    } else {
        addCategory($db,$name);
        $session->addMessage('success', 'Category added successfully');
    }

    header('Location:../pages/admin_panel.php');
    exit();
?>