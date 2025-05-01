<?php
    function getDatabaseConnection() {
    $db = new PDO('sqlite:'.__DIR__.'/database.db');
    return $db;
  }
?>