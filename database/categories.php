<?php

  function getAllCategories($db) {
    $stmt = $db->prepare('SELECT category_name
                          FROM Category');
                          
    $stmt->execute();
    return $stmt->fetchAll();
  }


?>