<?php
    require_once(__DIR__.'/../database/connection.db.php');
    require_once(__DIR__. '/../utils/session.php');
    require_once(__DIR__ . '/../database/user.class.php');

    $session = new Session();
    $db = getDatabaseConnection();
    $user = User::getUserbyId($db,$session->getId());
    $costumer = User::getUserWithPassword($db,$user->username, $_POST['password']);

    if($costumer){
        $hashed_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
        $costumer->updatePassword($db,$hashed_password);
        $session->addMessage('success', 'Your password has been updated sucessfully');
    }
    else{
        $session->addMessage('error', 'Wrong password');
    }
    header('Location: ' . $_SERVER['HTTP_REFERER']);
?>