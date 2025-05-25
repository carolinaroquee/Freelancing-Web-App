<?php function drawChat(array $messages, User $otherUser, int $loggedUserId) { ?> 
  <section id="chat">
    <h2>Chat with <?= htmlspecialchars($otherUser->name) ?></h2>

    <div class="chat-messages">
      <?php foreach ($messages as $msg): ?>
        <div class="chat-message <?= $msg->sender_id == $loggedUserId ? 'sent' : 'received' ?>">
          <strong><?= $msg->sender_id == $loggedUserId ? 'You' : htmlspecialchars($otherUser->name) ?>:</strong>
          <p><?= nl2br(htmlspecialchars($msg->content)) ?></p>
          <small><?= $msg->timestamp ?></small>
        </div>
      <?php endforeach; ?>
    </div>

    <form method="POST" action="chat.php?freelancer=<?= urlencode($otherUser->id)?>" class="chat-form">
        <input type="hidden" name="csrf" value="<?= $_SESSION['csrf'] ?>">
        <textarea name="message" required placeholder="Type your message..."></textarea>
        <button type="submit">Send</button>
    </form>
  </section>
<?php } ?>