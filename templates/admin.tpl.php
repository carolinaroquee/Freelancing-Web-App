<?php
    require_once(__DIR__. '/../utils/session.php');
?>

<?php function drawAdminPanel(Session $session) {?>
    
    <section class="admin-panel">
        <article id="add-category">
            <h2>Add New Category</h2>

            <form action="../actions/action_add_category.php" method="POST">
                <label for="name">Category Name:</label>
                <input id="name" type="text" name="name" required maxlength="100">

                <input type="submit" value="Add Category">
            </form>
        </article>
        <article id="remove-category">
            <h2>Remove Category</h2>

            <form action="../actions/action_remove_category.php" method="POST">
                <label for="name">Category Name:</label>
                <input id="name" type="text" name="name" required >

                <input type="submit" value="Remove Category">
            </form>
        </article>
        <section id="messages">
                <?php foreach ($session->getMessages() as $messsage) { ?>
                    <article class="<?=$messsage['type']?>">
                        <?=$messsage['text']?>
                    </article>
                <?php } ?>
        </section>
    </section>

<?php } ?>

