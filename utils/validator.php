<?php 
declare(strict_types = 1);
require_once(__DIR__.':/utils/session.php');

function valid_name(string $attempt): bool {
    if (!preg_match("/^[a-zA-Z\s]+$/", $attempt)) {
        $session = new Session();
        $session->addMessage('warning', "Invalid name format");
        return false;
    }
    return true;
}


function valid_email(string $attempt): bool {
    if (!filter_var($attempt, FILTER_VALIDATE_EMAIL)) {
        $session = new Session();
        $session->addMessage('warning', "Invalid email format");
        return false;
    }
    return true;
}

function valid_address(string $attempt): bool {
    if (!preg_match("/^[A-Za-z0-9\s\-,.]+$/", $attempt)) {
        $session = new Session();
        $session->addMessage('warning', "Invalid address format");
        return false;
    }
    return true;
}

function valid_text(string $attempt): bool {
    if (!preg_match("/^[a-zA-Z\s]+$/", $attempt)) {
        $session = new Session();
        $session->addMessage('warning', "Invalid text format");
        return false;
    }
    return true;
}

function valid_city(string $attempt): bool {
    return valid_text($attempt); // Reuse the function above
}

function valid_password(string $attempt): bool {
    $uppercase = preg_match('@[A-Z]@', $attempt);
    $lowercase = preg_match('@[a-z]@', $attempt);
    $number = preg_match('@[0-9]@', $attempt);

    if (!$uppercase || !$lowercase || !$number || strlen($attempt) < 8) {
        $session = new Session();
        $session->addMessage('warning', "The new password must be at least 8 characters long and include an uppercase letter, a lowercase letter, and a number");
        return false; 
    }
    return true;
}

function valid_CSRF(string $attempt): bool {
    if ($_SESSION['csrf'] !== $attempt) {
        $session = new Session();
        $session->addMessage('error', "Invalid operation");
        return false;
    }
    return true;
}
?>
