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

<?php function become_tutor_form(Session $session) {?>

<!DOCTYPE html>
<html>
<head>>
  <title>Become a Tutor</title>
  <link rel="stylesheet" href="../css/profile.css">
</head>
<body>
  <div id="editProfile">
    <h2>Become a Tutor</h2>
    <form class="profile" action="../actions/action_become_freelancer.php" method="POST">
      <label for="biography">Biography:</label>
      <textarea name="biography" rows="4" required></textarea>

      <label for="university">University (optional):</label>
      <input type="text" name="university">

      <label for="course">Course (optional):</label>
      <input type="text" name="course">

      <label for="languages">Languages Spoken:</label>
      <input type="text" name="languages" required>

      <label for="profession">Profession:</label>
      <input type="text" name="profession" required>

      <input type="hidden" name="csrf" value="<?= $_SESSION['csrf'] ?>">
      <button type="submit">Submit</button>
    </form>
  </div>
</body>
</html>

<?php } ?>


<?php function add_service_form(Session $session) {?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Service</title>
    <link rel="stylesheet" href="../css/add_service.css"> <!-- Cria este ficheiro ou cola o CSS que te dou já a seguir -->
</head>
<section class="form-wrapper">
    <h2>Add a New Service</h2>
    <form class="add-service-form" action="../actions/action_add_service.php" method="POST">
        <label for="title">Title:</label>
        <input type="text" name="title" required>

        <label for="category">Category:</label>
        <select name="category_name" required>
            <?php foreach ($categories as $category): ?>
                <option value="<?= htmlspecialchars($category['category_name']) ?>">
                    <?= htmlspecialchars($category['category_name']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="description">Description:</label>
        <textarea name="description" rows="4" required></textarea>

        <label for="duracao">Duration (minutes):</label>
        <input type="number" name="duracao" min="1" required>

        <label for="price">Price (€):</label>
        <input type="number" name="price" step="0.01" min="0" required>

        <label for="service_type">Service Type:</label>
        <select name="service_type" required>
            <option value="individual presencial">Individual Presencial</option>
            <option value="grupo presencial">Grupo Presencial</option>
            <option value="individual online">Individual Online</option>
            <option value="grupo online">Grupo Online</option>
            <option value="revisão trabalhos">Revisão de Trabalhos</option>
        </select>

        <label for="num_sessoes">Number of Sessions:</label>
        <input type="number" name="num_sessoes" min="1" required>

        <label for="max_students">Max Students (group services only):</label>
        <input type="number" name="max_students" min="1" placeholder="Optional">

        <label for="service_images">Upload Images:</label>
        <input type="file" name="service_images[]" id="service-images" accept="image/*" multiple> <!-- Permite múltiplos arquivos de imagem -->

        <button type="submit" class="submit-btn">Publish Service</button>
    </form>
</section>

<?php } ?>
