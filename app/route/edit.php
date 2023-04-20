<?php
  # Guard
  require_once '../utils/auth.php';

  connection_needed();

  if (!isset($_GET['id'])) {
    header('Location: /account.php');
    exit();
  }

  if (!$_SESSION['role'] === 'admin' && $_SESSION['user_id'] !== $_GET['id']) {
    header('Location: /account.php');
    exit();
  }

  # Post
  require_once '../utils/db.php';
  $article_id = $_GET['id'];

  $error = null;
  if (isset($_POST['name']) && isset($_POST['description']) && isset($_POST['price']) && isset($_POST['stock'])) {
    $request_name = $_POST['name'];
    $request_desc = $_POST['description'];
    $request_price = $_POST['price'];
    $request_stock = $_POST['stock'];    

    $db_request_post_article = mysqli_query($con, "update Article set name = '$request_name', description = '$request_desc', price = $request_price where id = $article_id");

    $db_request_post_stock = mysqli_query($con, "update Stock set quantity = '$request_stock' where article_id = $article_id");

    if ($db_request_post_article && $db_request_post_stock) {
      header('Location: /account.php');
      exit();
    } else {
      $error = 'Une erreur  est survenue, veuillez reessayer';
    }
  }
  
  # Fetching
  $db_request = mysqli_query($con, "select * from Article join Stock where Article.id = $article_id limit 1");
  $db_article = null;

  if ($db_request && $db_request->num_rows > 0) {
    $db_article = $db_request->fetch_assoc();
  } else {
    $error = "Cette article n'existe pas";
  }
?>

<?php
  require_once '../components/header.php'
?><?php if ($error): ?>
  <div>
    <?= $error ?>
  </div>
<?php else : ?>
  <form class="card-account-input" action="" method="post">
    <label>
      <span>Nom : </span>
      <input type="text" name="name" id="name_input" value="<?=$db_article['name']?>">
    </label>
    <label>
      <span>Description : </span>
      <textarea name="description" id="description_input" cols="20" rows="5"><?=$db_article['description']?></textarea>
    </label>
    <label>
      <span>Prix : </span>
      <input type="number" name="price" id="price_input"  value="<?=$db_article['price']?>">
    </label>
    <label>
      <span>Stock : </span>
      <input type="number" name="stock" id="stock_input"  value="<?=$db_article['quantity']?>">
    </label>
    <input class="but" type="submit" value="Enregistrer">
  </form>
<?php endif ?>
<?php
  require_once '../components/footer.php'
?>