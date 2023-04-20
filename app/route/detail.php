<?php
  # Guard
  require_once '../utils/auth.php';

  if (!isset($_GET['id'])) {
    header('Location: /');
    exit();
  }
  $request_id = $_GET['id'];

  $connected = is_connected();

  # Post
  require_once '../utils/db.php';
  $error = null;
  
  if (isset($_POST['cart'])) {
    $user_id = $_SESSION['user_id'];
    $article_id = $_GET['id'];

    $db_request_post = mysqli_query($con, "insert into Cart (article_id, user_id) values ($article_id, $user_id)");

    if ($db_request_post) {
      header('Location: /');
      exit();
    } else {
      $error = 'Une erreur est survenue, veuillez reessayer';
    }
  }

  if (isset($_POST['delete'])) {
    $article_id = $_GET['id'];

    $db_request_stock = mysqli_query($con, "delete from Stock where article_id = $article_id");
    $db_request_cart = mysqli_query($con, "delete from Cart where article_id = $article_id");
    $db_request_article = mysqli_query($con, "delete from Article where id = $article_id");

    if ($db_request_stock && $db_request_article && $db_request_cart) {
      header('Location: /account.php');
      exit();
    } else {
      $error = 'Une erreur est survenue, veuillez reessayer';
    }
  }

  # Fetching
  $db_article = null;
  $db_request = mysqli_query($con, "select * from Article join User join Stock where Article.id = $request_id limit 1");

  if ($db_request && $db_request->num_rows > 0) {
    $db_article = $db_request->fetch_assoc();
  } else {
    $error = "Une erreur c'est produite, cette article n'existe peut etre pas, veuillez reessayer plus tard";
  }
?>

<?php
  require_once '../components/header.php'
?>

<?php if ($error): ?>
  <div>
    <?= $error ?>
  </div>
<?php else : ?>
  <div class="card-detail">
  <ul>
    <li>Nom de l'article : <?= $db_article['name']?></li>
    <li>Auteur : <?= $db_article['username']?></li>
    <li>Date de publication : <?= $db_article['publication_date']?></li>
    <li>Description : <?= $db_article['description']?></li>
    <li>Prix : <?= $db_article['price']?></li>
    <li>Stock : <?= $db_article['quantity']?></li>
  </ul>

  <?php if ($connected && (strval($_SESSION['user_id']) === $db_article['author_id'] || $_SESSION['role'] === 'admin')): ?>
    <a id="registerbutton" href="/edit.php?id=<?= $request_id ?>">Editer l'article</a>
    <form action="" method="post">
      <input type="hidden" name="delete">
      <input type="submit" value="Supprimer">
    </form>
  <?php endif ?>
  <?php if ($connected): ?>
    <form action="" method="post">
      <input type="hidden" name="cart">
      <input id="registerbutton" type="submit" value="Ajouter au panier">
    </form>
  <?php endif ?>
  </div>
<?php endif ?>

<?php
  require_once '../components/footer.php'
?>