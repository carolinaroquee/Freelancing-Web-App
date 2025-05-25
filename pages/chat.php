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
    $other_user_id= intval($_GET['user'] ?? 0);

    if ($other_user_id === 0 || $logged_user_id === $other_user_id || !$session->isLoggedIn()) {
        $session->addMessage('error','You cannot acess this chat');
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['message'])) {
        if( !valid_CSRF($_POST['csrf'])){
            $session->addMessage('error', 'Invalid CSRF token.');
            die(header('Location: chat.php?user=' . $other_user_id));
        }
        Message::send($db, $logged_user_id, $other_user_id, $_POST['message']);
        header("Location: chat.php?user=" . $other_user_id);
    
    }

    $messages = Message::getConversation($db, $logged_user_id, $other_user_id);
    $freelancer = User::getUserbyId($db, $other_user_id);

    drawHeader($session);
    drawChat($messages, $freelancer, $logged_user_id);
    drawFooter($categories);


?>

   
