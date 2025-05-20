<?php
    require_once(__DIR__ . '/../utils/session.php');
    require_once(__DIR__.'/../database/connection.db.php');
    require_once(__DIR__.'/../database/categories.php');

    $session = new Session();
    
    if (!$session->isLoggedIn()) {
        header('Location: ../pages/login.php');
        exit();
    }

    $name = trim($_POST['name']);

    if (empty($name)) {
        $session->addMessage('error', 'Write a category name in the box');
        header('Location: ../pages/admin_panel.php');
        exit;
    }
    $db = getDatabaseConnection();

    if (!categoryExists($db, $name)) {
        $session->addMessage('error', 'There is not any category with that name');
    } else {
        removeCategory($db,$name);
        $session->addMessage('success', 'Category removed successfully');
    }

    header('Location:../pages/admin_panel.php');
    exit();
?>