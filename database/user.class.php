<?php
  declare(strict_types = 1);
  
  class User {

    public int $id;
    public string $username;
    public string $name;
    public string $email;
    public string $password; 
    public string $user_type;
    public string $data_registo;
    public ?string $birth_data;
    public ?string $address;
    public ?string $postal_code;
    public ?string $city;

    public function __construct(int $id, string $username, string $name, string $email, string $password, string $user_type, string $data_registo, ?string $birth_data, ?string $address, ?string $postal_code, ?string $city) { 
      $this->id = $id;
      $this->username = $username;
      $this->name= $name;
      $this->email = $email;
      $this->password= $password;
      $this->user_type= $user_type;
      $this->data_registo = $data_registo;
      $this->birth_data= $birth_data;
      $this->address = $address;
      $this->postal_code = $postal_code;
      $this->city=$city;
    }

    function getName() : string {
      $names = explode(" ", $this->name);
      return count($names) > 1 ? $names[0] . " " . $names[count($names)-1] : $names[0];
    }

    function save($db) {

      $stmt = $db->prepare('INSERT INTO User (username, name, email, password, usertype, data_registo) VALUES (:username,:name, :email, :password,:usertype,:data)');
      $stmt->bindParam(':username', $this->username);
      $stmt->bindParam(':name', $this->name);
      $stmt->bindParam(':email', $this->email);
      $stmt->bindParam(':password', $this->password);
      $stmt->bindParam(':usertype', $this->user_type);
      $stmt->bindParam(':data', $this->data_registo);
  
      $stmt->execute(); 
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
          $user['data_registo'],
          $user['birth_data'],
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
          $user['data_registo'],
          $user['birth_data'],
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
          $user['data_registo'],
          $user['birth_data'],
          $user['address'],
          $user['postal_code'],
          $user['city']
        );
    } 


    function update(PDO $db){
      $stmt = $db->prepare('
        UPDATE User SET username = ?,  name = ?, birth_data = ?, email = ?, address = ?, postal_code = ?, city = ?
        WHERE user_id = ?
      ');

      $stmt->execute(array($this->name, $this->username, $this->birth_data,$this->email,$this->address,$this->postal_code,$this->city));

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
