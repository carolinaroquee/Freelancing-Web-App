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
        $stmt = $db->prepare('INSERT INTO Service (freelancer_id, title, category_name, description, duracao, price,service_type, num_sessoes, max_students, images) VALUES (:freelancer_id, :title, :category_name, :description, :duracao, :price,:service_type, :num_sessoes, :max_students, :images)');

        $stmt->bindParam(':freelancer_id', $this->freelancer_id);
        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':category_name', $this->category_name);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':duracao', $this->duracao);
        $stmt->bindParam(':price', $this->price);
        $stmt->bindParam(':service_type', $this->service_type);
        $stmt->bindParam(':num_sessoes', $this->num_sessoes);
        $stmt->bindParam(':max_students', $this->max_students);
        $stmt->bindParam(':images', $this->images); 
        
        $stmt->execute(); 

    }

} 
    function getServicesbyCategory(PDO $db, string $category) {
        $stmt = $db->prepare('SELECT * FROM Service WHERE category_name = :category ');   
        $stmt->bindParam(':category', $category);           
        $stmt->execute();

        return $stmt->fetchAll();
    }

?>
