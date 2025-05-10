<?php
    require_once(__DIR__. '/../utils/session.php');
    require_once(__DIR__.'/../database/user.class.php');
?>
<?php function drawEditProfile(User $user){ ?> 
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

    <form action="../actions/uploadProfileImage.action.php" method="post" enctype="multipart/form-data">
        <label>Profile Picture: <input type="file" name="image"></label>
        <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
        <input type="submit" value="Upload">
    </form>

  </section>
<?php } ?>