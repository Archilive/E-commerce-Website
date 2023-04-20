<?php
  # Guard
  require_once '../utils/auth.php';

  connection_needed();

  $owner = true;

  if (isset($_GET['id'])) {
    $owner = false;
  }

  # Post
  require_once '../utils/db.php';
  require_once '../utils/session.php';
  $error = null;

  $id = null;

  if ($owner) {
    $id = $_SESSION['user_id'];
  } else {
    $id = $_GET['id'];
  }

  if (isset($_POST['name']) && isset($_POST['mail']) && isset($_POST['pass']) && isset($_POST['solde'])) {
    $request_name = $_POST['name'];
    $request_mail = $_POST['mail'];
    $request_pass = $_POST['pass'];
    $request_solde = $_POST['solde'];

    $request_pass_query = ($request_pass === '') ? ('') : (', password = ' . password_hash($request_pass, PASSWORD_BCRYPT));
    $request_role = (isset($_POST['role'])) ? (", role = " . $_POST['role']) : ('');

    $db_request = mysqli_query($con, "update User set username = '$request_name' $request_pass_query, email = '$request_mail', solde = $request_solde $request_role where id = $id");

    if (!$db_request) {
      $error = "Une erreur est survenue, veuillez reessayer";
    } else {
      create_session($_SESSION['user_id'], $request_name, $_SESSION['role'], $request_solde, $_SESSION['photo']);
    }
  }

  # Fetching
  require_once '../utils/db.php';

  $db_request_user = mysqli_query($con, "select * from User where id = $id");
  $db_request_article = mysqli_query($con, "select * from Article where author_id = $id");
  $db_request_invoice = mysqli_query($con, "select * from Invoice where user_id = $id");

  $db_user = null;
  if ($db_request_user && $db_request_user->num_rows > 0) {
    $db_user = $db_request_user->fetch_assoc();
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
<?php if ($owner || $_SESSION['role'] === 'admin'): ?>
  <div class="card-account">
    <h2><span>Details du compte : </span></h2>
    <div class="card-account-input">
      <form action="" method="post">
        <label for="username">
          <span>Nom d'utilisateur:</span>
          <input type="text" name="name" id="name_input" value="<?= $db_user['username'] ?>">
        </label>

        <label for="email">
          <span>Email:</span>
          <input type="text" name="mail" id="mail_input" value="<?= $db_user['email'] ?>">
        </label>

        <label for="password">
          <span>Mot de passe:</span>
          <input type="text" name="pass" id="pass_input">
        </label>

        <label for="solde">
          <span>Solde:</span>
          <input type="number" name="solde" id="solde_input" value="<?= $db_user['solde'] ?>">
        </label>

        <?php if($_SESSION['role'] === 'admin'): ?>
          <label for="role">
            <span>Role:</span>
            <input type="text" name="role" id="role_input" value="<?= $db_user['role'] ?>">
          </label>
        <?php endif ?>

        <input type="submit" id="registerbutton" value="Enregistrer les modifications">
      </form>
    </div>
  </div>
  <div class="card-account-factures">
      <h2><span>Factures :</span></h2>
    
    <ul>
      <?php while($row_invoice = $db_request_invoice->fetch_assoc()): ?>
        <li><?= $row_invoice['amount'] ?> euros, le <?= $row_invoice['transaction_date'] ?>, <?= $row_invoice['billing_address'] ?> <?= $row_invoice['billing_city'] ?> <?= $row_invoice['billing_postal_code'] ?></li>
      <?php endwhile; ?>
    </ul>
  </div>
  <div class="card-account-articles">
    <h2><span>Articles : </span></h2>
    <a href="/sell.php"><button>Ajouter un nouvelle article</button></a>
    <ul>
      <?php while($row_article = $db_request_article->fetch_assoc()): ?>
        <li><a href="/detail.php?id=<?= $row_article['id'] ?>"><?= $row_article['name'] ?>, <?= $row_article['price'] ?> euros, <?= $row_article['publication_date'] ?></a></li>
      <?php endwhile; ?>
    </ul>
  </div>
<?php else: ?>
  <span>Details du compte : </span>
  <ul>
    <li><?= $db_user['username'] ?></li>
    <li><?= $db_user['email'] ?></li>
    <li><?= $db_user['solde'] ?></li>
    <li><?= $db_user['role'] ?></li>
  </ul>
  <span>Articles : </span>
  <ul>
    <?php while($row_article = $db_request_article->fetch_assoc()): ?>
      <li><a href="/detail.php?id=<?= $row_article['id'] ?>"><?= $row_article['name'] ?>, <?= $row_article['price'] ?> euros, <?= $row_article['publication_date'] ?></a></li>
    <?php endwhile; ?>
  </ul>
<?php endif ?>

<?php
  require_once '../components/footer.php'
?>