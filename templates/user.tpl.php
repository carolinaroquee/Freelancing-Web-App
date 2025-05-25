<?php
  require_once(__DIR__. '/../utils/session.php');
  require_once(__DIR__.'/../database/user.class.php');
?>
<?php function drawEditProfile(User $user,Session $session){ ?> 
  <section id="editProfile">
    
    <h2>Profile</h2>
    <form action="../actions/action_edit_profile.php" method="post" class="profile">
        <label for="name">Name:</label>
        <input id="name" type="text" name="name" value="<?=htmlspecialchars($user->name)?>">

        <label for="username">Username:</label>
        <input id="username" type="text" name="username" value="<?=htmlspecialchars($user->username)?>">

        <label for="email">Email:</label>
        <input id="email" type="text" name="email" value="<?=htmlspecialchars($user->email)?>">

        <label for="address">Address:</label>
        <input id="address" type="text" name="address" value="<?=htmlspecialchars($user->address)?>">

        <label for="city">City:</label>
        <input id="city" type="text" name="city" value="<?=htmlspecialchars($user->city)?>">

        <label for="postal_code">Postal Code:</label>
        <input id="postal_code" type="text" name="postal_code" value="<?=htmlspecialchars($user->postal_code)?>">

        <label for="birth_date">Birth Date:</label>
        <input id="birth_date" type="date" name="birth_date" value="<?=htmlspecialchars($user->birth_date)?>">
        
        <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
        <button type="submit">Save</button>
    </form>

    <form action="../actions/action_uploadPhoto.php" method="post" enctype="multipart/form-data">
        <label>Profile Picture:</label>
          <input type="file" name="image">
        <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
        <input type="submit" value="Upload">
      </form>
      
      
      <img src="<?= $session->getPhoto() ?>" alt="Profile image" >
      <form action="../actions/action_changePassword.php" method="post">
        <label for="your_password">Your Password:</label>
        <input type="password" name="password" required>
        <label for="new_password">New Password:</label>
        <input type="password" name="new_password" required>
        <button type="submit">Change Password</button>
      </form>
      
  </section>
<?php } ?>

<?php function become_Tutor_Form(Session $session) {?>

  <!DOCTYPE html>
  <html>
    <head>
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

<?php } ?>