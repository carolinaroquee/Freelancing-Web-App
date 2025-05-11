<?php
  declare(strict_types = 1);
  
  class Freelancer {

    public int $id;
    public string $biography;
    public ?string $university;
    public ?string $course;
    public ?string $languages;
    public ?string $profession;

    public function __construct(int $id, string $biography, ?string $university, ?string $course, ?string $languages, ?string $profession) { 
        $this->id = $id;
        $this->biography = $biography;
        $this->university= $university;
        $this->course = $course;
        $this->languages= $languages;
        $this->profession= $profession;
    }

    function save($db) {
      $stmt = $db->prepare('INSERT INTO Freelancer (freelancer_id, biography, university, course, languages, profession) VALUES (:freelancer_id,:biography, :university, :course,:languages,:profession)');
      $stmt->bindParam(':freelancer_id', $this->freelancer_id);
      $stmt->bindParam(':biography', $this->biography);
      $stmt->bindParam(':university', $this->university);
      $stmt->bindParam(':course', $this->course);
      $stmt->bindParam(':languages', $this->languages);
      $stmt->bindParam(':profession', $this->profession);

      $stmt->execute(); 
    }

  }

    

?>
