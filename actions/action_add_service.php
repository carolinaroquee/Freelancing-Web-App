<?php
require_once(__DIR__.'/../utils/session.php');
require_once(__DIR__.'/../database/connection.db.php');

$session = new Session();
if (!$session->isLoggedIn()) {
    header('Location: ../pages/login.php');
    exit();
}

$db = getDatabaseConnection();
$user_id = $session->getId();

// Garante que o user é freelancer
$stmt = $db->prepare('INSERT OR IGNORE INTO Freelancer (freelancer_id) VALUES (?)');
$stmt->execute([$user_id]);

// Recolhe os dados do formulário
$title = $_POST['title'];
$category = $_POST['category_name'];
$description = $_POST['description'];
$duracao = $_POST['duracao'];
$price = $_POST['price'];
$service_type = $_POST['service_type'];
$num_sessoes = $_POST['num_sessoes'];
$max_students = $_POST['max_students'] !== '' ? $_POST['max_students'] : null;


// Processamento das imagens
$image_paths = [];
if (isset($_FILES['service_images']) && count($_FILES['service_images']['name']) > 0) {
    // Cria um diretório para armazenar as imagens, se não existir
    $upload_dir = '../uploads/services/';
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    // Processa cada imagem
    for ($i = 0; $i < count($_FILES['service_images']['name']); $i++) {
        $file_name = $_FILES['service_images']['name'][$i];
        $file_tmp = $_FILES['service_images']['tmp_name'][$i];
        $file_error = $_FILES['service_images']['error'][$i];
        $file_size = $_FILES['service_images']['size'][$i];

        // Verifica se houve erro no upload
        if ($file_error === 0) {
            // Gera um nome único para a imagem
            $file_extension = pathinfo($file_name, PATHINFO_EXTENSION);
            $file_new_name = uniqid('service_') . '.' . $file_extension;
            $file_path = $upload_dir . $file_new_name;

            // Move a imagem para o diretório
            if (move_uploaded_file($file_tmp, $file_path)) {
                // Adiciona o caminho da imagem ao array
                $image_paths[] = $file_path;
            } else {
                // Caso haja erro no upload
                echo "Erro ao fazer upload da imagem: $file_name";
                exit();
            }
        }
    }
}

// Converte os caminhos das imagens para uma string separada por vírgulas
$image_paths_str = implode(',', $image_paths);

$stmt = $db->prepare('INSERT INTO Service (
    freelancer_id, title, category_name, description, duracao, price,
    service_type, num_sessoes, max_students, images
) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');

$stmt->execute([
    $user_id, $title, $category, $description, $duracao, $price,
    $service_type, $num_sessoes, $max_students, $image_paths_str
]);

header('Location: ../pages/profile.php');
exit();
