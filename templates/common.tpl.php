<?php
    require_once(__DIR__. '/../utils/session.php');
?>

<?php function drawHeader(Session $session){ ?>

<DOCTYPE html>
<html>
    <head>
        <title>Geninus Academy</title>
        <link rel="stylesheet" href="../css/style.css">
    </head>
    <body>
        <header>
            <?php
                if($session->isLoggedIn()) drawLogoutForm($session);
                else drawLoginForm($session);
            ?>
        </header>
    </body>
</html>

<?php } ?>

<?php function drawLoginForm() { ?>
    <nav>
        <a href=""><img id="logo" src="../docs/BrightMinds_logo.png" alt="Logo"></a> 
        <div class="nav-links">
            <a href="">Become a Seller</a>
            <a href="pages/file_login.php">Sign In </a>
            <a href="pages/file_signup.php" class="join-btn">Join</a>  
        </div>
    </nav>
<?php } ?>



<?php function drawLogoutForm() { ?>
  
<?php } ?>