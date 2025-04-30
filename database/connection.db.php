<?php
    function getDatabaseConnection() {
    $db = new PDO('sqlite:database.bd');

    return $db;
  }
?>