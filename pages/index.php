<?php
    require_once(__DIR__. '/../templates/common.tpl.php');    
    require_once(__DIR__.'/../database/connection.db.php');
    require_once(__DIR__.'/../database/categories.php');
    $session = new Session();
    $db = getDatabaseConnection();
    $categories  = getAllCategories($db);

    drawHeader($session);
?>
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
        <footer>
            <h4>Genius Academy</h4>
            <p>77% of our users improve</p>
            <p>Click <a href="">here</a> to check our best freelancers</p>
        </footer>



    </body>
</html>