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
  if (!empty($_POST['mail'])) {
    $request_mail = $_POST['mail'];
    $request_pass = $_POST['pass'];

    $db_raw_user = mysqli_query($con, "select * from User where email = '$request_mail' limit 1");
    
    if ($db_raw_user && $db_raw_user->num_rows > 0) {
      $db_user = $db_raw_user->fetch_assoc();

      if (password_verify($request_pass, $db_user['password'])) {
        create_session($db_user['id'], $db_user['username'], $db_user['role'], $db_user['solde'], $db_user['photo'] or '');

        header('Location: /');
        exit();
      } else {
        $error = 'Mauvais mot de passe';
      }
    } else {
      $error = "Aucun utilisateur n'est enregistré avec cette adresse email";
    }
  }
?>

<?php
  require_once '../components/header.php'
?>

<?php if ($error): ?>
  <div>
    <?= $error ?>
  </div>
<?php endif ?>

<form action="" method="post">
<div class="card-auth"> 
    <h2>Connectez-vous</h2>
    <div class="card-input">
      
      <label for="username">Email:</label>
      <input type="text" name="mail" id="mail_input" placeholder="votre@mail.com" required>

      <label for="password">Mot de passe:</label>
      <input type="password" name="pass" id="pass_input" placeholder="votre mot de passe">

      <input type="submit" id="registerbutton" value="Se connecter">
    </div>
  </div>
</form>

<?php
  require_once '../components/footer.php'
?>