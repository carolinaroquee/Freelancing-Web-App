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
                <nav>
                    <a href="../pages/index.php"><img id="logo" src="../docs/BrightMinds_logo.png" alt="BrightMinds Logo"></a> 
                    <?php
                        if($session->isLoggedIn()) drawUserNav($session);
                        else drawVisitorNav();
                    ?>
                </nav>
            </header>
        </body> 
    </html>

<?php } ?>

<?php function drawVisitorNav() { ?>
    <ul class="nav-links">
        <li><a href="">Become a Seller</a></li>
        <li><a href="../pages/login.php">Sign In</a></li>
        <li><a href="../pages/sign_up.php" class="join-btn">Join</a></li>
    </ul>
<?php } ?>



<?php function drawUserNav(Session $session) { ?>
    <div class="nav-right">
        <a href="../pages/profile.php" ><img src="../docs/default_profile_image.png" alt="profile image" id="profile"></a>
        <form action="../actions/action_logout.php" method="post">
            <button type="submit" class="logout-btn">Logout</button>
        </form>
    </div>
<?php } ?>

<?php function drawMainPage(Session $session, array $categories){ ?>
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