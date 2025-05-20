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
    $tmpPath = $_FILES['image']['tmp_name'];
  $imageInfo = getimagesize($tmpPath);

  $relativePath = "/docs/profile_img/profile" . $session->getId() . ".png";
  $absolutePath = __DIR__ . "/.." . $relativePath;

  // Criar imagem a partir do original (sem move_uploaded_file)
  switch ($imageInfo['mime']) {
    case 'image/jpeg':
      $img = imagecreatefromjpeg($tmpPath);
      break;
    case 'image/png':
      $img = imagecreatefrompng($tmpPath);
      break;
    case 'image/gif':
      $img = imagecreatefromgif($tmpPath);
      break;
    default:
      $session->addMessage('error', 'Formato de imagem não suportado');
      die(header('Location: ../pages/profile.php'));
  }

  // Recorte e redimensionamento
  $width = imagesx($img);
  $height = imagesy($img);
  $square = min($width, $height);
  $src_x = intval(($width - $square) / 2);
  $src_y = intval(($height - $square) / 2);
  $finalSize = 300;
  $profile = imagecreatetruecolor($finalSize, $finalSize);

  imagecopyresampled(
    $profile,
    $img,
    0, 0,
    $src_x, $src_y,
    $finalSize, $finalSize,
    $square, $square
  );

  // Salvar imagem processada
  imagepng($profile, $absolutePath);

  // Limpeza
  imagedestroy($img);
  imagedestroy($profile);
  

  $db = getDatabaseConnection();
  $user = User::getUserbyId($db,$session->getId());

  $user->profile_image=$relativePath;
  $user->updateProfileImage($db,$relativePath);

  $session->setPhoto($relativePath);
  $session->addMessage('success', 'Image uploaded successfully');
  header('Location: ../pages/profile.php');
?>