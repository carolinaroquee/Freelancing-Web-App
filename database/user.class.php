<?php
  declare(strict_types = 1);
  
  class User {

    public int $id;
    public string $username;
    public string $name;
    public string $email;
    public string $password; 
    public string $user_type;
    public string $registration_date;
    public ?string $birth_date;
    public ?string $address;
    public ?string $postal_code;
    public ?string $city;

    public function __construct(int $id, string $username, string $name, string $email, string $password, string $user_type, string $registration_date, ?string $birth_date, ?string $address, ?string $postal_code, ?string $city) { 
      $this->id = $id;
      $this->username = $username;
      $this->name= $name;
      $this->email = $email;
      $this->password= $password;
      $this->user_type= $user_type;
      $this->registration_date = $registration_date;
      $this->birth_date= $birth_date;
      $this->address = $address;
      $this->postal_code = $postal_code;
      $this->city=$city;
    }

    function getName() : string {
      $names = explode(" ", $this->name);
      return count($names) > 1 ? $names[0] . " " . $names[count($names)-1] : $names[0];
    }

    function save($db) {

      $stmt = $db->prepare('INSERT INTO User (username, name, email, password, usertype, registration_date) VALUES (:username,:name, :email, :password,:usertype,:registration_date)');
      $stmt->bindParam(':username', $this->username);
      $stmt->bindParam(':name', $this->name);
      $stmt->bindParam(':email', $this->email);
      $stmt->bindParam(':password', $this->password);
      $stmt->bindParam(':usertype', $this->user_type);
      $stmt->bindParam(':registration_date', $this->registration_date);
  
      $stmt->execute(); 

      $this->id = (int)$db->lastInsertId(); // atualiza dentro do próprio objeto
    }

    static function getUserWithPassword(PDO $db, string $username, string $password) : ?User {
      
      $stmt = $db->prepare('SELECT * FROM User WHERE username = ?');
      
      $stmt->execute(array($username));
      
      $user = $stmt->fetch();

      if ($user !== false && password_verify($password, $user['password'])) {
        return new User(
          intval($user['user_id']),
          $user['username'],
          $user['name'],
          $user['email'],
          $user['password'],
          $user['usertype'],
          $user['registration_date'],
          $user['birth_date'],
          $user['address'],
          $user['postal_code'],
          $user['city']
        );
      } else return null;
    }

    static function getUser(PDO $db, string $username, string $email): ?User{

      $stmt = $db->prepare("SELECT * FROM User WHERE username = :username OR email = :email");
      $stmt->bindParam(':username', $username);
      $stmt->bindParam(':email', $email);

      $stmt->execute();

      $user = $stmt->fetch();
      if($user){
        return new User(
          intval($user['user_id']),
          $user['username'],
          $user['name'],
          $user['email'],
          $user['password'],
          $user['usertype'],
          $user['registration_date'],
          $user['birth_date'],
          $user['address'],
          $user['postal_code'],
          $user['city']
        );
      }
      else return null;
    }

    static function getUserbyId(PDO $db, int $id) : User {

      $stmt = $db->prepare('SELECT * FROM User WHERE user_id = ?');
      $stmt->execute(array($id));
  
      $user = $stmt->fetch();
  
      return new User(
          intval($user['user_id']),
          $user['username'],
          $user['name'],
          $user['email'],
          $user['password'],
          $user['usertype'],
          $user['registration_date'],
          $user['birth_date'],
          $user['address'],
          $user['postal_code'],
          $user['city']
        );
    } 


    function update(PDO $db){
      $stmt = $db->prepare('
        UPDATE User SET username = ?,  name = ?, birth_date = ?, email = ?, address = ?, postal_code = ?, city = ?
        WHERE user_id = ?
      ');

      $stmt->execute(array($this->username, $this->name, $this->birth_date,$this->email,$this->address,$this->postal_code,$this->city,$this->id));

    }

    function updateUserType(PDO $db){
      $stmt = $db->prepare('
        UPDATE User SET usertype= ?
        WHERE user_id = ?
      ');

      $stmt->execute(array($this->user_type, $this->id));

    }

    /*tentativa da função para ir buscar a foto de perfil
    function getPhoto() : string {
      $default = "../docs/default_profile_image.png";
      $attemp = "";
      if (file_exists(dirname(__DIR__).$attemp)) {
        $_SESSION['photo'] = $attemp;
        return $attemp;
      } else return $default;
    }  */

    
  }
?>
