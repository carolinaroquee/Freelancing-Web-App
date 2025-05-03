<?php
    require_once(__DIR__.'/../database/connection.db.php');
    require_once(__DIR__. '/../utils/session.php');
    require_once(__DIR__ . '/../database/user.class.php');

    $session = new Session();
    $db = getDatabaseConnection();

    $user = User::getUserWithPassword($db, $_POST['username'], $_POST['password']);

    if($user){
        $session->setId($user->id);
        $session->setUsername($user->username);
        $session->addMessage('success', 'Login successful!');
        header('Location: ../pages/index.php');  
    }
    else{
        $session->addMessage('error', 'Invalid username or password.');
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }

    /*
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $db->prepare("SELECT * FROM User WHERE username = :username AND password = :password");
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $password);
    $stmt->execute();
    $user = $stmt->fetch();

    if($user){
        $session->setId($user['user_id']);
        $session->setUsername($username);
        $session->addMessage('success', 'Login successful!');
        header('Location: ../pages/index.php');  
    }
    else{
        $session->addMessage('error', 'Invalid username or password.');
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }*/
?>