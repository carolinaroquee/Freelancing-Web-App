<?php

require_once(__DIR__.'/../database/connection.db.php');
    

session_start();
$db = getDatabaseConnection();

//garante que o código é executado quando o formulário é enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {    


    // respostas do forms de sign up
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    //verificar se as senhas coincidem
    if ($password !== $confirm_password) {
        $_SESSION['error'] = "Passwords don't match!";
        header("Location: sign_up.php");
        exit;
    }

    // Hash da senha para segurança
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Verificar se o nome de utilizador ou e-mail já existem
    $stmt = $db->prepare("SELECT * FROM User WHERE username = :username OR email = :email");
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $user = $stmt->fetch();

    if ($user) {
        $_SESSION['error'] = "Username or email already exists!";
        header("Location: sign_up.php");
        exit;
    }

    // Inserir os dados na base de dados
    $stmt = $db->prepare('INSERT INTO User (username, email, password) VALUES (:username, :email, :password)');
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $hashed_password);

    $stmt->execute(); 

    //obtem o id do user que acabamos de criar
    $user_id = $db->lastInsertId();  
 
   // guarda o id do user na sessão e o username na sessão
   $_SESSION['user_id'] = $user_id;
   $_SESSION['username'] = $username;
   $_SESSION['success'] = "Account created successfully!";

    // depois de criar conta vai ter à homepage
    header("Location: homepage.php");
    exit;
}

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Sign Up</title>
        <link rel="stylesheet" href="login_signUp.css">
    </head>
    <body>
        <section class="signUp-block">
            <img id="logo" src="docs/BrightMinds_logo - Copy.png"/>
            <h2>Register your account</h2>
            <?php
            
            if (!empty($_SESSION['error'])) {
                echo '<p style="color:red;">' . $_SESSION['error'] . '</p>';
                unset($_SESSION['error']);
            }
            if (!empty($_SESSION['success'])) {
                echo '<p style="color:green;">' . $_SESSION['success'] . '</p>';
                unset($_SESSION['success']);
            }
            ?>
            <form action="sign_up.php" method="POST">
                <input type="text" name="username" placeholder="Username" required />
                <input type="email" name="email" placeholder="Email" required />
                <input type="password" name="password" placeholder="Password" required />
                <input type="password" name="confirm_password" placeholder="Password confirmation" required />
                <button type="submit">Create Account</button>
            </form>
            <p class="login-text">Already have an account? <a href="file_login.html"> Join here</a></p>
        </section> 
    </body>
</html>