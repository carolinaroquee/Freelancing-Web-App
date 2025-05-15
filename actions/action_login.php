<?php
    require_once(__DIR__.'/../database/connection.db.php');
    require_once(__DIR__. '/../utils/session.php');
    require_once(__DIR__ . '/../database/user.class.php');

    $session = new Session();
    $db = getDatabaseConnection();

    $user = User::getUserWithPassword($db, $_POST['username'], $_POST['password']);

    if($user){
        $session->setId($user->id);
        $session->setName($user->name);
        $session->setUsername($user->username);
        $session->setUserType($user->user_type);
        $session->setPhoto($user->getPhoto());
        $session->addMessage('success', 'Login successful! Welcome back, '. $user->getName() . '!');
        header('Location: ../pages/index.php');  
    }
    else{
        $session->addMessage('error', 'Invalid username or password.');
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
?>