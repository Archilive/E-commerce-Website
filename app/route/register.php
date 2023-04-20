<?php
  # Guard
  require_once '../utils/auth.php';
  if (is_connected()) {
    header('Location: /');
    exit();
  }

  # Verification
  require_once '../utils/db.php';
  require_once '../utils/session.php';

  $error = null;
  if (!empty($_POST['mail']) && !empty($_POST['pass']) && !empty($_POST['name'])) {
    $request_mail = $_POST['mail'];
    $request_pass = $_POST['pass'];
    $hashed_pass = password_hash($request_pass, PASSWORD_BCRYPT);
    $request_name = $_POST['name'];

    $db_check_info = mysqli_query($con, "select id from User where username = '$request_name' or email = '$request_mail'");

    if ($db_check_info->num_rows > 0) {
      $error = "Cette email ou ce nom d'utilisateur sont deja utilisé";
    } else {
      $db_request = mysqli_query($con, "insert into User (username, email, password, role, solde) values('$request_name', '$request_mail', '$hashed_pass', 'user', 0)");
      
      create_session(mysqli_insert_id($con), $request_name, 'user', 0, '');
  
      header('Location: /');
      exit();
    }
  }
?>

<?php
  require_once '../components/header.php';
?>

<?php if ($error): ?>
  <div>
    <?= $error ?>
  </div>
<?php endif ?>

<form action="" method="post">
  <div class="card-auth"> 
    <h2>Enregistrez-vous</h2>
    <div class="card-input">
      <label for="username">Nom d'utilisateur:</label>
      <input type="text" name="name" id="name_input" placeholder="votre nom/prenom" required>

      <label for="email">Email:</label>
      <input type="text" name="mail" id="mail_input" placeholder="votre@mail.com" required>

      <label for="password">Mot de passe:</label>
      <input type="password" name="pass" id="pass_input" placeholder="votre mot de passe" required>
      <input type="submit" id="registerbutton" value="S'enregistrer">
    </div>
  </div>
</form>

<?php
  require_once '../components/footer.php';
?>