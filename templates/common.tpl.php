<?php
    require_once(__DIR__. '/../utils/session.php');
    require_once(__DIR__.'/../database/user.class.php');
?>

<?php function drawHeader(Session $session){ ?>

    <!DOCTYPE html>
    <html>
        <head>
            <title>Bright Minds</title>
            <meta
                name="LTW Project"
                enconding= "utf-8"
                author= "Ana Alves, Carolina Roque, Mateus Guerra"
            >
            <link rel="stylesheet" href="../css/style.css">
            <link rel="stylesheet" href="../css/profile.css">
            <link rel="stylesheet" href="../css/services.css">
            <script src="../javascript/script.js"> href</script>
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
                <section id="messages">
                    <?php foreach ($session->getMessages() as $messsage) { ?>
                        <article class="<?=$messsage['type']?>">
                            <?=$messsage['text']?>
                        </article>
                    <?php } ?>
                </section>
            </header>
            <main>
<?php } ?>



<?php function drawVisitorNav() { ?>
    <ul class="visitor-nav-links">
        <li><a href="../pages/sign_up.php">Become a Tutor</a></li>
        <li><a href="../pages/login.php">Sign In</a></li>
        <li><a href="../pages/sign_up.php" class="join-btn">Join</a></li>
    </ul>
<?php } ?>



<?php function drawUserNav(Session $session) { ?>
    <div class="user-nav">
        <?php if($session->getUserType()==='student'){ ?>
            <a href="../pages/become_freelancer.php">Become a Tutor</a>
        <?php } else{ ?>
            <a href="../pages/add_service.php">Add Service</a>
        <?php } ?>
        
        <div class="profile-dropdown">
            <button type="button" class="profile-button" onclick="toggleProfileMenu()">
                <img src="../docs/default_profile_image.png" alt="Profile image" class="profile-image">
            </button>
            <div id='profile-menu'>
                <a href="../pages/profile.php">Profile</a>
                <a href="../actions/action_logout.php">Logout</a>
            </div>
        </div> 
        <!--<form action="../actions/action_logout.php" method="post">
            <button type="submit" class="logout-btn">Logout</button>
        </form>
        <a href="../pages/profile.php"><Profile></a>
        <a href="../pages/profile.php" ><img src="../docs/default_profile_image.png" alt="profile image" id="profile"></a>-->
    </div>
<?php } ?>

    
<?php function drawMainPage(Session $session, array $categories){ ?>
    
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
                    <a href="../pages/services_list.php">
                        <button type = "submit"> <?=$category['category_name']?> </button>
                    </a>
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
    
<?php } ?> 

<?php function drawFooter(array $categories){ ?>

            </main>
            <footer>
                <div class="footer-content">
                    <section class="footer-column">
                        <h3>About</h3>
                        <ul>
                            <li><a href="">Who we are?</a></li>
                            <li><a href="">Legal Notice</a></li>
                            <li><a href="">Privacy Policy</a></li>
                            <li><a href="">Districts</a></li>
                            <li><a href="">Work with us</a></li>
                        </ul>
                    </section>
                    <section class="footer-column">
                        <h3>Categories</h3>
                        <ul>
                            <?php foreach($categories as $category){ ?>
                                <li>
                                    <a href=""><?=$category['category_name']?>
                                    </a>
                                </li>
                            <?php } ?>
            
                        </ul>
                    </section>
                    <section class="footer-column">
                        <h3>Support</h3>
                        <ul>
                            <li><a href="#">Help Center</a></li>
                            <li><a href="#">Contact</a></li>
                        </ul>
                    </section>

                    <section class="footer-column">
                        <h3>Follow us</h3>
                        <div class="social-icons">
                            <a href="#"><i class="fab fa-facebook-f"></i></a>
                            <a href="#"><i class="fab fa-twitter"></i></a>
                            <a href="#"><i class="fab fa-instagram"></i></a>
                        </div>
                    </section>
                    <div class="footer-bottom">
                        <hr>
                        <p>© 2025 Bright Minds, where curious minds meet brilliant teachers.</p>
                    </div>
                </div>   
            </footer>
        </body>
    </html>
<?php } ?>

<?php function drawSignUp(Session $session){ ?>
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
                    <input type="text" name="name" placeholder="Name" required />
                    <input type="text" name="username" placeholder="Username" required />
                    <input type="email" name="email" placeholder="Email" required />
                    <input type="password" name="password" placeholder="Password" required />
                    <input type="password" name="confirm_password" placeholder="Password confirmation" required />
                    <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
                    <button type="submit">Create Account</button>
                </form>
                <p class="login-text">Already have an account? <a href="../pages/login.php">Sign in here</a></p>
            </section> 
        </body>
    </html>
<?php } ?>

<?php function drawLogin(Session $session) {?>
    <!DOCTYPE html>
    <html>
        <head>
            <title>Login</title>
            <link rel="stylesheet" href="../css/login_signUp.css">
        </head>
        <body>
            <section class="login-block">
                <img id="logo" src="../docs/BrightMinds_logo - Copy.png"/>
                <h1>Enter with your account</h1>

                <section id="messages">
                    <?php foreach ($session->getMessages() as $messsage) { ?>
                        <article class="<?=$messsage['type']?>">
                            <?=$messsage['text']?>
                        </article>
                    <?php } ?>

                </section>
                <!-- post pq assim os dados são enviados de forma invisível na msg http -->
                <form action="../actions/action_login.php" method="post"> 
                    <input type="text" name="username" placeholder="Username" required />
                    <input type="password" name="password" placeholder="Password" required />
                    <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
                    <button type="submit">Login</button> 
                </form>
                <p> or sign in with </p>
                <form action="../actions/action_login.php" method="post">
                    <button type="submit" class="google-btn">
                        <img id="google-logo" src="../docs/google_logo.png" alt="Google logo"/>Continue with Google</button>
                </form>
                <p class="signup-text">Don't have an account? <a href="../pages/sign_up.php">Join here</a></p>
                
            </section>    
        </body>
    </html>

<?php } ?>