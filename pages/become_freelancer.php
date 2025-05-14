<?php
  require_once(__DIR__ . '/../utils/session.php');
  require_once(__DIR__ . '/../database/connection.db.php');
  require_once(__DIR__ . '/../templates/user.tpl.php');


  $session = new Session();
  if (!$session->isLoggedIn()) {
    //$_SESSION['redirect_after_signup'] =  '../pages/become_freelancer.php';
    header("Location: ../pages/sign_up.php");
    exit();
  }

  become_Tutor_Form($session);
?>

