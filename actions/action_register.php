<?php
    
require_once(__DIR__.'/../database/connection.db.php');
require_once(__DIR__. '/../utils/session.php');
    

$session = new Session();
$db = getDatabaseConnection();

//garante que o código é executado quando o formulário é enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {    


    // respostas do forms de sign up
    $name= $_POST['name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $user_type= 'estudante';
    $data = date('Y-m-d');

    //verificar se as senhas coincidem
    if ($password !== $confirm_password) {
        $session->addMessage('error', "Passwords don't match!");
        header("Location: ../pages/sign_up.php");
        exit;
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Verificar se o nome de utilizador ou e-mail já existem
    
    $stmt = $db->prepare("SELECT * FROM User WHERE username = :username OR email = :email");
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $user = $stmt->fetch();

    if ($user) {
        $session->addMessage('error', 'Username or email already exists!');
        header("Location: ../pages/sign_up.php");
        exit;
    }

    // Inserir os dados na base de dados
    $stmt = $db->prepare('INSERT INTO User (username, name, email, password, usertype, data_registo) VALUES (:username,:name, :email, :password,:usertype,:data)');
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $hashed_password);
    $stmt->bindParam(':usertype', $user_type);
    $stmt->bindParam(':data', $data);
    

    $stmt->execute(); 

    //obtem o id do user que acabamos de criar
    $user_id = $db->lastInsertId();  
 
   // guarda o id do user na sessão e o username na sessão
   $session->setId($user_id);
   $session->setUsername($username);
   $session->setName($name);
   $session->addMessage('sucess','Account created successfully!');

    // depois de criar conta vai ter à homepage
    header("Location:../pages/index.php");
    exit;
}
?>