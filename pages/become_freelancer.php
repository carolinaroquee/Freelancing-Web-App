<?php
require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../database/connection.db.php');

$session = new Session();
if (!$session->isLoggedIn()) {
  header("Location: ../pages/sign_up.php");
}
?>

<!DOCTYPE html>
<html>
<head>>
  <title>Become a Tutor</title>
  <link rel="stylesheet" href="../css/profile.css">
</head>
<body>
  <div id="editProfile">
    <h2>Become a Tutor</h2>
    <form class="profile" action="../actions/action_become_freelancer.php" method="POST">
      <label for="biography">Biography:</label>
      <textarea name="biography" rows="4" required></textarea>

      <label for="university">University (optional):</label>
      <input type="text" name="university">

      <label for="course">Course (optional):</label>
      <input type="text" name="course">

      <label for="languages">Languages Spoken:</label>
      <input type="text" name="languages" required>

      <label for="profession">Profession:</label>
      <input type="text" name="profession" required>

      <input type="hidden" name="csrf" value="<?= $_SESSION['csrf'] ?>">
      <button type="submit">Submit</button>
    </form>
  </div>
</body>
</html>
