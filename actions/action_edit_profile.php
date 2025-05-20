<?php
    declare(strict_types=1);
    require_once(__DIR__.'/../database/connection.db.php');
    require_once(__DIR__. '/../utils/session.php');
    require_once(__DIR__.'/../utils/validator.php');
    require_once(__DIR__ . '/../database/user.class.php');

    $session = new Session();

    if(!$session->isLoggedIn()){
        $session->addMessage('error',"Action not available");
    }
    
    if(!valid_CSRF($_POST['csrf'])){
        die(header('Location:../pages/profile.php'));
    }

    $db = getDatabaseConnection();
    $user = User::getUserbyId($db,intval($session->getId()));

    if($user){
        $user->name = $_POST['name'];
        $user->username = $_POST['username'];
        $user->email =$_POST['email'];
        $user->address =$_POST['address'];
        $user->city =$_POST['city'];
        $user->postal_code =$_POST['postal_code'];
        $user->birth_date =$_POST['birth_date'];

        $user->update($db);
        
        $session->setName($user->name);
    }
    header('Location: ' . $_SERVER['HTTP_REFERER']);
?>