<?php
  declare(strict_types = 1);
  
  class User {

    public int $id;
    public string $username;
    public ?string $name;
    public string $email;
    public string $password; 
    /*public string $user_type;*/

    /*public string $birth_data,
    /*public string $address;
    public string $postalcode;
    public string $city;
    public string $country
    public string $phone;*/

    public function __construct(int $id, string $username, ?string $name, string $email, string $password, /*string $user_type string $address,string $postalcode, string $phone */) { 
      $this->id = $id;
      $this->username = $username;
      $this->name= $name;
      $this->email = $email;
      $this->password= $password;
      /*$this->user_type= $user_type;*/
      /*$this->address = $address;
      $this->postalcode = $postalcode;
      $this->city=$city;
      $this->country=$country;
      $this->phone = $phone;*/
    }

    function getName() : string {
      $names = explode(" ", $this->name);
      return count($names) > 1 ? $names[0] . " " . $names[count($names)-1] : $names[0];
    }

    function save($db) {
      $stmt = $db->prepare('
        UPDATE User SET username = ?, email = ?, password = ?
        WHERE user_id = ?
      ');

      $stmt->execute(array($this->username, $this->email, $this->password, $this->id 
                                    /*$this->address, ,$this->id*/));
    }


    static function getUserWithPassword(PDO $db, string $username, string $password) : ?User {

      $stmt = $db->prepare('SELECT * FROM User WHERE username = ?');
      
      $stmt->execute(array($username));
      
      $user = $stmt->fetch();

      if ($user !== false && password_verify($password, $user['password'])) {
        return new User(
          intval($user['id']),
          $user['username'],
          $user['name'],
          $user['email'],
          $user['password'],
          /*$user['user_type'],*/
          /*$user['address'],
          intval($user['phoneNumber']),*/
        );
      } else return null;
    }

    static function getUser(PDO $db, int $id) : User {

      $stmt = $db->prepare('SELECT user_id, username, email, password, user_type/*, address, phoneNumber*/ FROM User WHERE user_id = ?');
      $stmt->execute(array($id));
  
      $user = $stmt->fetch();
  
      return new User(
          intval($user['id']),
          $user['username'],
          $user['email'],
          $user['password'],
          $user['user_type'],
          /*$user['address'],
          intval($user['phoneNumber']),*/
      );
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
