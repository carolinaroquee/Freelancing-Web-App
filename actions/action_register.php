<?php
    
require_once(__DIR__.'/../database/connection.db.php');
require_once(__DIR__. '/../utils/session.php');
require_once(__DIR__.'/../database/user.class.php'); 


$session = new Session();
$db = getDatabaseConnection();

if ($_SERVER["REQUEST_METHOD"] == "POST") {    

    $name= $_POST['name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $user_type= 'student';
    $data = date('Y-m-d');

    if ($password !== $confirm_password) {
        $session->addMessage('error', "Passwords don't match!");
        header("Location: ../pages/sign_up.php");
        exit;
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);


    $user = User::getUser($db,$username,$email); 

    if ($user) {
        $session->addMessage('error', 'Username or email already exists!');
        header("Location: ../pages/sign_up.php");
        exit;
    }

   

    $user = new User(0,$username,$name,$email,$hashed_password,$user_type,$data,null, null,null,null);
    $user->save($db);

    $user_id = $db->lastInsertId();  

    $session->setId($user_id);
    $session->setUsername($username);
    $session->setName($name);
    $session->setUserType($user_type);
    $session->addMessage('sucess','Account created successfully!');

    // header("Location:../pages/index.php");

    $redirect = $_SESSION['redirect_after_signup'] ?? '../pages/index.php';
    unset($_SESSION['redirect_after_signup']);
    header("Location: $redirect");
    exit();
}
?>