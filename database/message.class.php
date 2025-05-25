<?php
class Message {
  public int $id;
  public int $sender_id;
  public int $receiver_id;
  public string $content;
  public string $timestamp;

  public function __construct(int $id, int $sender_id, int $receiver_id, string $content, string $timestamp) {
    $this->id = $id;
    $this->sender_id = $sender_id;
    $this->receiver_id = $receiver_id;
    $this->content = $content;
    $this->timestamp = $timestamp;
  }

  static function send(PDO $db, int $sender_id, int $receiver_id, string $content) {
    $stmt = $db->prepare("INSERT INTO Message (sender_id, receiver_id, content) VALUES (?, ?, ?)");
    $stmt->execute([$sender_id, $receiver_id, $content]);
  }

  static function getConversation(PDO $db, int $user1, int $user2): array {
    $stmt = $db->prepare("
        SELECT message_id, sender_id, receiver_id, content, timestamp 
        FROM Message
        WHERE (sender_id = ? AND receiver_id = ?)
            OR (sender_id = ? AND receiver_id = ?)
        ORDER BY timestamp ASC
    ");
    $stmt->execute([$user1, $user2, $user2, $user1]);
    $messages = [];

    while ($msg = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $messages[] = new Message(
        intval($msg['message_id']),
        intval($msg['sender_id']),
        intval($msg['receiver_id']),
        $msg['content'],
        $msg['timestamp']
      );
    }

    return $messages;
  }
} 
?>