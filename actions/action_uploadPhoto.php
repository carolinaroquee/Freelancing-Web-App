<?php
  declare(strict_types = 1);
  require_once(__DIR__.'/../database/connection.db.php');
  require_once(__DIR__. '/../utils/session.php');
  require_once(__DIR__.'/../database/user.class.php');
  require_once(__DIR__.'/../utils/validator.php');

  $session = new Session();

  if (!valid_CSRF($_POST['csrf'])) {
    die(header());
  }

  if (!isset($_FILES['image'])) {
    $session->addMessage('warning', 'Select the desired photo first');
    die(header("Location: ../pages/profile.php"));
  }

  $tmpPath= $_FILES['image']['tmp_name'];
  $imageInfo = getimagesize($tmpPath);
  $fileName = "../docs/profile_img/profile" .  $session->getId() . ".png";
  move_uploaded_file($_FILES['image']['tmp_name'], $fileName);

  switch ($imageInfo['mime']) {
  case 'image/jpeg':
    $img = imagecreatefromjpeg($fileName);
    break;
  case 'image/png':
    $img = imagecreatefrompng($fileName);
    break;
  case 'image/gif':
    $img = imagecreatefromgif($fileName);
    break;
  default:
    $session->addMessage('error', 'Image format not support');
    die(header('Location: ../pages/profile.php'));
  }

  $width = imagesx($img);     // largura original
  $height = imagesy($img);    // altura original

  // 1. Lado do maior quadrado possível dentro da imagem
  $square = min($width, $height);

  // 2. Coordenadas de onde começar o corte (para centrar)
  $src_x = intval(($width - $square) / 2);
  $src_y = intval(($height - $square) / 2);

  // 3. Tamanho final desejado do avatar (opcional, aqui é 300x300)
  $finalSize = 300;

  // 4. Criar imagem nova
  $profile = imagecreatetruecolor($finalSize, $finalSize);

  // 5. Copiar o quadrado da imagem original, redimensionando se necessário
  imagecopyresampled(
    $profile,        // destino
    $img,            // origem
    0, 0,            // destino x, y
    $src_x, $src_y,  // origem x, y (centrado)
    $finalSize, $finalSize,  // tamanho destino
    $square, $square         // tamanho origem (corte quadrado)
  );

  // 6. Guardar imagem
  imagepng($profile, $fileName);


  $db = getDatabaseConnection();
  $user = User::getUserbyId($db,$session->getId());

  $user->updateProfileImage($db,$fileName);
  $session->setPhoto($fileName);
  $session->addMessage('success', 'Image uploaded successfully');
  header('Location: ../pages/profile.php');
?>