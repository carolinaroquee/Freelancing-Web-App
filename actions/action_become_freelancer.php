<?php
require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../database/connection.db.php');

$session = new Session();
if (!$session->isLoggedIn()) {
    header("Location: ../pages/login.php");
    exit();
}

if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) {
    die('Invalid CSRF token.');
}

$db = getDatabaseConnection();
$id = $session->getId();

$biography = $_POST['biography'];
$university = !empty($_POST['university']) ? $_POST['university'] : null;
$course = !empty($_POST['course']) ? $_POST['course'] : null;
$languages = $_POST['languages'];
$profession = $_POST['profession'];

$stmt = $db->prepare('INSERT OR REPLACE INTO Freelancer 
  (freelancer_id, biography, university, course, languages, profession) 
  VALUES (?, ?, ?, ?, ?, ?)');
$stmt->execute([$id, $biography, $university, $course, $languages, $profession]);

header('Location: ../pages/index.php');
exit();
