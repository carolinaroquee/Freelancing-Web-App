<?php
    require_once(__DIR__.'/../database/connection.db.php');
    require_once(__DIR__. '/../utils/session.php');
    require_once(__DIR__ . '/../database/user.class.php');

    $session = new Session();
    $db = getDatabaseConnection();

    $user = User::getUser($db,$_POST['username'],'email');
    if($user){
        $user->user_type='admin';
        $user->updateUserType($db);
        $session->addMessage('success', 'User ' . $_POST['username'] . ' has been upgraded to admin');
    }
    else{
        $session->addMessage('error', 'User ' . $_POST['username'] . ' does not exist');
    }

    header('Location: ' . $_SERVER['HTTP_REFERER']);
?>