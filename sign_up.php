<?php
    $dbh= new PDO('sqlite:BrightMinds.db')
    $stmt= $dbh->prepare('INSERT INTO users(username, email, password) VALUES (:username,:email,:password)');
    $stmt->bindParam(':')


?>