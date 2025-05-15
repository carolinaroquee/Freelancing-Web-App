<?php
  class Session {
    private array $messages;

    public function __construct() {
      session_start();
      if(!isset($_SESSION['csrf'])){
        $_SESSION['csrf']=$this->generate_random_token();
      }

      $this->messages = isset($_SESSION['messages']) ? $_SESSION['messages'] : array();
      unset($_SESSION['messages']);
    }

    public function isLoggedIn() : bool {
      return isset($_SESSION['id']);    
    }

    public function logout() {
      session_destroy();
    }

    public function getId() : ?int {
      return isset($_SESSION['id']) ? $_SESSION['id'] : null;    
    }
    public function getName() : ?string {
      return isset($_SESSION['name']) ? $_SESSION['name'] : null;
    }

    public function getUsername() : ?string {
      return isset($_SESSION['username']) ? $_SESSION['Username'] : null;
    }

    public function setId(int $id) {
      $_SESSION['id'] = $id;
    }
    
    public function setName(string $name) {
      $_SESSION['name'] = $name;
    }

    public function setUsername(string $username) {
      $_SESSION['username'] = $username;
    }
    
    public function setUserType(string $user_type){
      $_SESSION['user_type']= $user_type;
    }

    public function getUserType() : ?string {
      return isset($_SESSION['user_type']) ? $_SESSION['user_type'] : null;
    }

    public function setPhoto(string $photo){
      $_SESSION['photo']= $photo;
    }

    public function getPhoto(): ?string{
      return isset($_SESSION['photo']) ? $_SESSION['photo'] : null;
    }

    public function addMessage(string $type, string $text) {
      $_SESSION['messages'][] = array('type' => $type, 'text' => $text);
    }

    public function getMessages() {
      return $this->messages;
    }

    public function generate_random_token() {
      return bin2hex(openssl_random_pseudo_bytes(32));
    }
  }
?>