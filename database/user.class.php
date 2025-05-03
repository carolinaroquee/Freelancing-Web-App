<?php
  declare(strict_types = 1);
  
  class User {

    public int $id;
    public string $username;
    public string $name;
    public string $email;
    public string $password; /*nao sei se deve estar aqui*/
    public string $address;
    public string $postalcode;
    public string $phone;

    public function __construct(int $id, string $username, string $name, string $email, string $address,string $postalcode, string $phone ) { 
      $this->id = $id;
      $this->username = $username;
      $this->name= $name;
      $this->email = $email;
      $this->address = $address;
      $this->postalcode = $postalcode;
      $this->phone = $phone;
    }

    function getName() : string {
      $names = explode(" ", $this->name);
      return count($names) > 1 ? $names[0] . " " . $names[count($names)-1] : $names[0];
    }

    function save($db) {
      $stmt = $db->prepare('
        UPDATE User SET name = ?, email = ?, password = ?
        WHERE user_id = ?
      ');

      $stmt->execute(array($this->name, $this->email, $this->password, 
                                    $this->address, $this->phoneNumber, $this->id));
    }


    static function getUserWithPassword(PDO $db, string $username, string $password) : ?User {

      $stmt = $db->prepare('SELECT * FROM User WHERE username = ? ');
      
      $stmt->execute(array($username));
      
      $user = $stmt->fetch();

      if ($user !== false && password_verify($password, $user['password'])) {
        return new User(
          intval($user['id']),
          $user['username'],
          $user['email'],
          $user['password'],
          $user['address'],
          intval($user['phoneNumber']),
        );
      } else return null;
    }

    static function getUser(PDO $db, int $id) : User {

      $stmt = $db->prepare('SELECT id, name, email, password, address, phoneNumber FROM User WHERE id = ?');
      $stmt->execute(array($id));
  
      $user = $stmt->fetch();
  
      return new User(
          intval($user['id']),
          $user['name'],
          $user['email'],
          $user['password'],
          $user['address'],
          intval($user['phoneNumber']),
      );
    }  

    /*tentativa da função para ir buscar a foto de perfil*/
    function getPhoto() : string {
      $default = "../docs/default_profile_image.png";
      $attemp = "";
      if (file_exists(dirname(__DIR__).$attemp)) {
        $_SESSION['photo'] = $attemp;
        return $attemp;
      } else return $default;
    }  

    
  }
?>
