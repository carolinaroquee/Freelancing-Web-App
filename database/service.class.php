<?php
  declare(strict_types = 1);
  
  class Service {
    public int $service_id;
    public int $freelancer_id;
    public string $title;
    public string $category_name;
    public string $description;
    public int $duracao;
    public int $price;
    public string $service_type;
    public int $num_sessoes;
    public ?int $max_students;

    public function __construct(int $service_id, int $freelancer_id, string $title, string $category_name, string $description, int $duracao, int $price, string $service_type, int $num_sessoes, ?int $max_students) { 
        $this->service_id = $service_id;
        $this->freelancer_id = $freelancer_id;
        $this->title = $title;
        $this->category_name = $category_name;
        $this->description = $description;
        $this->duracao = $duracao;
        $this->price = $price;
        $this->service_type = $service_type;
        $this->num_sessoes= $num_sessoes;
        $this->max_students= $max_students;
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

        $this->service_id= (int)$db->lastInsertId();

    }

    public static function getServiceById(PDO $db, int $id): ?Service {
        $stmt = $db->prepare('SELECT * FROM Service WHERE service_id = ?');
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) return null;

        return new Service(
            intval($row['service_id']),
            intval($row['freelancer_id']),
            $row['title'],
            $row['category_name'],
            $row['description'],
            $row['duracao'],
            intval($row['price']),
            $row['service_type'],
            intval($row['num_sessoes']),
            isset($row['max_students']) ? intval($row['max_students']) : null,
        );
    }

} 

function getServices(PDO $db, ?string $category, ?string $service_type, ?float $min_price, ?float $max_price): array {
    $query = '
        SELECT s.service_id, s.title, s.price, s.service_type,
               u.name AS freelancer_name, u.user_id,
               (SELECT AVG(r.rating) FROM Review r
                JOIN Booking b ON r.booking_id = b.booking_id
                WHERE b.service_id = s.service_id) AS avg_rating
        FROM Service s
        JOIN Freelancer f ON s.freelancer_id = f.freelancer_id
        JOIN User u ON f.freelancer_id = u.user_id
        WHERE s.status = "ativo" 
        ';

    $params = [];

    if ($category !== null) {
        $query .= ' AND s.category_name = :category';
        $params[':category'] = $category;
    }
    if ($service_type !== null) {
        $query .= ' AND s.service_type = :service_type';
        $params[':service_type'] = $service_type;
    }
    if ($min_price !== null){
        $query .= ' AND s.price >= :min_price';
        $params[':min_price'] = $min_price;
    }
    if ($max_price !== null){
        $query .= ' AND s.price <= :max_price';
        $params[':max_price'] = $max_price;
    }

    $stmt = $db->prepare($query); 
    $stmt->execute($params);

    $services = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $user = User::getUserbyId($db, intval($row['user_id']));
          
        $profileImage = $user->getPhoto();
        $row['profile_image'] = $profileImage;
        $services[] = $row;
       
    }

    return $services;
}


function getServiceByFreelancerId(PDO $db, int $id) {
    $stmt = $db->prepare('SELECT * FROM Service WHERE freelancer_id = ?');
    $stmt->execute([$id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

?>
