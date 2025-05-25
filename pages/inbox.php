<?php 
    require_once(__DIR__ . '/../database/connection.db.php');
    require_once(__DIR__ . '/../database/categories.php');
    require_once(__DIR__ . '/../database/user.class.php');
    require_once(__DIR__ . '/../database/message.class.php');
    require_once(__DIR__ . '/../templates/common.tpl.php');
    require_once(__DIR__ . '/../templates/chat.tpl.php');
    require_once(__DIR__ . '/../utils/session.php');
    require_once(__DIR__ . '/../utils/validator.php'); 


    $session = new Session();
    $db = getDatabaseConnection();
    $categories = getAllCategories($db);

    $logged_user_id = $session->getId();


    $user = User::getUserbyId($db, $logged_user_id);
    if ($session->getUserType()==="student") {
        die("Access denied.");
        exit;
    }


    $senders = Message::getDistinctSenders($db, $logged_user_id);

    drawHeader($session);?>

    <section class="inbox">
    <h2>Messages from clients</h2>
    <ul>
        <?php foreach ($senders as $sender): ?>
        <li>
            <a href="chat.php?user=<?= $sender->id ?>">
            <?= htmlspecialchars($sender->name) ?>
            </a>
        </li>
        <?php endforeach; ?>
    </ul>
    </section>

    <?php drawFooter($categories);?>
