<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../templates/common.tpl.php');


$session = new Session();
if (!$session->isLoggedIn()) {
  $_SESSION['redirect_after_signup'] =  '../pages/become_freelancer.php';
  header("Location: ../pages/sign_up.php");
  exit();
}

become_tutor_form($session);
?>

