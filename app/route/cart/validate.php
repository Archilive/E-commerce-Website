<?php
  # Guard
  require_once '../../utils/auth.php';

  connection_needed();

  # Fetching
  require_once '../../utils/db.php';
  $error = null;
  $user_id = $_SESSION['user_id'];

  $db_request = mysqli_query($con, "select Article.id as article_id, quantity, price from Cart join Article on Article.id = Cart.article_id join Stock on Stock.article_id = Article.id where Cart.user_id = $user_id");
  $db_cart_total = 0;
  $article_id_list = array();
  if ($db_request) {
    while ($row = $db_request->fetch_assoc()) {
      if ($row['quantity'] < 1) {
        $error = "Une erreur est survenue, veuillez reessayer";
        break;
      }
      
      array_push($article_id_list, $row['article_id']);
      $db_cart_total += $row['price'];
    }
  } else {
    $error = "Une erreur est survenue, veuillez reessayer";
  }

  # Post
  if (isset($_POST['billing_address']) && isset($_POST['billing_city']) && isset($_POST['billing_postal']) && !$error && $_SESSION['solde'] > $db_cart_total) {
    $billing_address = $_POST['billing_address'];
    $billing_city = $_POST['billing_city'];
    $billing_postal = $_POST['billing_postal'];

    $db_request_post = mysqli_query($con, "insert into Invoice (user_id, amount, billing_address, billing_city, billing_postal_code) values ($user_id, $db_cart_total, '$billing_address', '$billing_city', '$billing_postal')");

    if ($db_request_post && $db_request) {
      $string_article_id_list = implode(', ', $article_id_list);

      $req1 = mysqli_query($con, "update Stock set quantity = quantity - 1 where article_id in ($string_article_id_list)");
      $req2 = mysqli_query($con, "delete from Cart where user_id = $user_id");
      $req3 = mysqli_query($con, "update User set solde = solde - $db_cart_total where id = $user_id");

      if ($req1 && $req2 && $req3) {
        header('Location: /');
        exit();
      }
      
      $error = "Une erreur est survenue, veuillez reessayer";
    } else {
      $error = "Une erreur est survenue, veuillez reessayer";
    }
  }
?>

<?php
  require_once '../../components/header.php'
?>
<?php if ($error): ?>
  <div>
    <?= $error ?>
  </div>
<?php else: ?>
  <div class="validationMoneyWrapper">
    <span>Votre Solde : <?= $_SESSION['solde'] ?></span>
    <span>Votre panier : <?= $db_cart_total ?></span>
  </div>
  

  <form class="formWrapper" action="" method="post" >
    <label class="formElement">
      <span>Adresse de facturation :</span>
      <input type="text" name="billing_address" id="bill_addr_input">
    </label>
    <label class="formElement">
      <span>Ville :</span>
      <input type="text" name="billing_city" id="bill_city_input">
    </label>
    <label class="formElement">
      <span>Code postal :</span>
      <input type="text" name="billing_postal" id="bill_post_input">
    </label>
    <input class="finaliser" type="submit" value="Valider" <?php if ($db_cart_total > $_SESSION['solde']): ?>disabled<?php endif ?>>
  </form>
<?php endif ?>
<?php
  require_once '../../components/footer.php'
?>