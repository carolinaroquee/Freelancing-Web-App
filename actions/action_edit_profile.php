<?php
    require_once(__DIR__.'/../database/connection.db.php');
    require_once(__DIR__. '/../utils/session.php');
    require_once(__DIR__ . '/../database/user.class.php');

    $session = new Session();
    $db = getDatabaseConnection();

    $user = User::getUserbyId($db,$session->getId());

    if($user){
        $user->name = $_POST['name'];
        $user->username = $_POST['username'];
        $user->email =$_POST['email'];
        $user->address =$_POST['address'];
        $user->city =$_POST['city'];
        $user->postal_code =$_POST['postal_code'];
        $user->birth_data =$_POST['birth_data'];

        $user->update($db);
        $session->setName($user->name);
    }
    header('Location: ' . $_SERVER['HTTP_REFERER']);
?>