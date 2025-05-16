<?php
  declare(strict_types = 1);
  
  class Service {

    public int $freelancer_id;
    public string $title;
    public string $category_name;
    public string $description;
    public string $duracao;
    public int $price;
    public string $service_type;
    public int $num_sessoes;
    public ?int $max_students;
    public ?string $images;

    public function __construct(int $freelancer_id, string $title, string $category_name, string $description, string $duracao, int $price, string $service_type, int $num_sessoes, ?int $max_students, ?string $images) { 
        $this->freelancer_id = $freelancer_id;
        $this->title = $title;
        $this->category_name = $category_name;
        $this->description = $description;
        $this->duracao = $duracao;
        $this->price = $price;
        $this->service_type = $service_type;
        $this->num_sessoes= $num_sessoes;
        $this->max_students= $max_students;
        $this->images = $images;
    }

    function save($db) {
        $stmt = $db->prepare('INSERT INTO Service (freelancer_id, title, category_name, description, duracao, price,service_type, num_sessoes, max_students) VALUES (:freelancer_id, :title, :category_name, :description, :duracao, :price,:service_type, :num_sessoes, :max_students)');

        $stmt->bindParam(':freelancer_id', $this->freelancer_id);
        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':category_name', $this->category_name);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':duracao', $this->duracao);
        $stmt->bindParam(':price', $this->price);
        $stmt->bindParam(':service_type', $this->service_type);
        $stmt->bindParam(':num_sessoes', $this->num_sessoes);
        $stmt->bindParam(':max_students', $this->max_students);
        
        $stmt->execute(); 

    }

} 

function getServicesbyCategory(PDO $db, string $category): array {
    $stmt = $db->prepare('
        SELECT s.service_id, s.title, s.price, s.service_type,
               u.name AS freelancer_name, u.user_id,
               (SELECT AVG(r.rating) FROM Review r
                JOIN Booking b ON r.booking_id = b.booking_id
                WHERE b.service_id = s.service_id) AS avg_rating
        FROM Service s
        JOIN Freelancer f ON s.freelancer_id = f.freelancer_id
        JOIN User u ON f.freelancer_id = u.user_id
        WHERE s.category_name = :category AND s.status = "ativo"
    ');

    $stmt->bindParam(':category', $category, PDO::PARAM_STR);
    $stmt->execute();

    $services = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // Verificar se o user_id existe na tabela User
        $user = User::getUserbyId($db, intval($row['user_id']));
        
        // Verificar se o usuário foi encontrado corretamente
        if ($user) {
            // Chama a função getPhoto() para pegar a imagem de perfil
            $profileImage = $user->getPhoto();
            $row['profile_image'] = $profileImage;
            $services[] = $row;
        } else {
            // Caso o usuário não seja encontrado, adicionar um perfil padrão ou algum tratamento
            $row['profile_image'] = "../images/default-profile.png";  // Ou algum outro valor de fallback
            $services[] = $row;
        }
    }

    return $services;
}

?>
