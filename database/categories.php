<?php

  function getAllCategories(PDO $db) {
    $stmt = $db->prepare('SELECT category_name
                          FROM Category');
                          
    $stmt->execute();
    return $stmt->fetchAll();
  }

  function categoryExists(PDO $db, string $name): bool {
    $stmt = $db->prepare('SELECT COUNT(*) FROM Category WHERE category_name = ?');
    $stmt->execute([$name]);
    $count = $stmt->fetchColumn();
    return $count > 0;
  }

  function addCategory(PDO $db, string $name){
    $stmt = $db->prepare('INSERT INTO Category (category_name) VALUES (?)');
    $stmt->execute([$name]);
  }

?>