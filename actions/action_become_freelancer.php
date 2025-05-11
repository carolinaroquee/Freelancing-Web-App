<?php
  require_once(__DIR__ . '/../utils/session.php');
  require_once(__DIR__ . '/../database/connection.db.php');
  require_once(__DIR__ . '/../database/user.class.php');
  require_once(__DIR__ . '/../database/freelancer.class.php');

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

  $user= User::getUserbyId($db,intval($id));

  $biography = $_POST['biography'];
  $university = !empty($_POST['university']) ? $_POST['university'] : null;
  $course = !empty($_POST['course']) ? $_POST['course'] : null;
  $languages = $_POST['languages'];
  $profession = $_POST['profession'];

  $user->user_type='tutor';

  $freelancer= new Freelancer($id,$biography,$university,$course,$languages,$profession);
  $freelancer->save($db);
  $user->updateUserType($db);
  $session->setUserType('tutor');

  header('Location: ../pages/index.php');
  exit();
?>