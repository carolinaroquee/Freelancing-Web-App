<?php
    require_once(__DIR__ . '/database/connection.db.php');

    $db = getDatabaseConnection();

    $username = 'admin01';
    $name = 'Administrador Principal';
    $birth_date = '1980-01-01';
    $email = 'admin@example.com';
    $password_plain = '1234'; 
    $usertype = 'admin';
    $address = 'Rua Central 123';
    $postal_code = '1234-567';
    $city = 'Lisboa';
    $registration_date = date('Y-m-d');
    $profile_image = '/docs/profile_img/admin_profile.jpg';


    $password_hash = password_hash($password_plain, PASSWORD_BCRYPT);


    $stmt = $db->prepare('INSERT INTO User (username, name, birth_date, email, password, usertype, address, postal_code, city, registration_date, profile_image) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');

    $stmt->execute([
        $username,
        $name,
        $birth_date,
        $email,
        $password_hash,
        $usertype,
        $address,
        $postal_code,
        $city,
        $registration_date,
        $profile_image
    ]);

?>