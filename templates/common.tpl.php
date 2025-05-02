<?php
    require_once(__DIR__. '/../utils/session.php');
?>

<?php function drawHeader(Session $session){ ?>

    <!DOCTYPE html>
    <html>
        <head>
            <title>Bright Minds</title>
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
    <!DOCTYPE html>
    <nav>
        <a href=""><img id="logo" src="../docs/BrightMinds_logo.png" alt="Logo"></a> 
        <div class="nav-links">
            <a href="">Become a Seller</a>
            <a href="login.php">Sign In </a>
            <a href="sign_up.php" class="join-btn">Join</a>  
        </div>
    </nav>
<?php } ?>



<?php function drawLogoutForm() { ?>
  
<?php } ?>

<?php function drawMainPage(Session $session, array $categories){ ?>
    <!DOCTYPE html>
    <html>
        <body>
            <main>
                <section class="search-services">
                    <h2>Learn from the best</h2>
                    <form>
                        <input class= "search-bar" type="search" placeholder="what service are you looking for?">
                    </form>
                    <form class="main-services">
                        <button>
                            Exp. individual
                        </button>
                        <button> 
                            Exp. grupo
                        </button>
                        <button>
                            Revisão de trabalhos
                        </button>
                    </form>
                </section>

                <section class = "product">
                    <section class="categories">
                        <h2>Explore categories</h2>
                        <?php foreach($categories as $category){ ?>

                            <button><?=$category['category_name']?></button>

                        <?php } ?>
                    </section>
                    <section class="services">
                        <h2>Popular services</h2>
                        <button>
                            <img src="../docs/exp-ind.jpg" alt="Explicação individual">
                            <span>Exp. individual</span>
                        </button>
                        <button>
                            <img src="../docs/exp-grp.jpg" alt="Explicação grupo">
                            <span>Exp. individual</span>
                        </button>
                        <button>
                            <img src="../docs/rev-trabalho.jpg" alt="Revisão de trabalho">
                            <span>Exp. individual</span>
                        </button>
                    </section>
                </section>

            </main>
        </body>
    </html>
<?php } ?> 

<?php function drawFooter(){ ?>
    <!DOCTYPE html>
    <footer>
        <h4>Genius Academy</h4>
        <p>77% of our users improve</p>
        <p>Click <a href="">here</a> to check our best freelancers</p>
    </footer>
<?php } ?>

<?php function drawLogin(Session $session){ ?>
    <!DOCTYPE html>
    <html>
        <head>
            <title>Sign Up</title>
            <link rel="stylesheet" href=" ../css/login_signUp.css">
        </head>
        <body>
            <section class="signUp-block">
                <img id="logo" src="../docs/BrightMinds_logo - Copy.png"/>
                <h2>Register your account</h2>
                
                <section id="messages">
                    <?php foreach ($session->getMessages() as $messsage) { ?>
                        <article class="<?=$messsage['type']?>">
                            <?=$messsage['text']?>
                        </article>
                    <?php } ?>

                </section>
                
                <form action="../actions/action_register.php" method="POST">
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
<?php } ?>