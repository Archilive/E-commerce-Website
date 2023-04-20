<?php
  # Guard
  require_once '../../utils/auth.php';
  connection_needed();

  # Post
  require_once '../../utils/db.php';
  $user_id = $_SESSION['user_id'];
  $error = null;

  if (isset($_POST['delete']) && isset($_POST['article_id'])) {
    $article_id = $_POST['article_id'];
    
    $db_request_post = mysqli_query($con, "delete from Cart where user_id = $user_id and article_id = $article_id limit 1");

    if (!$db_request_post) {
      $error = "Une erreur est survenue, veuillez reessayer";
    }
  }


  # Fetching
  $db_request = mysqli_query($con, "select * from User join Cart on Cart.user_id = User.id join Article on Article.id = Cart.article_id join Stock on Stock.article_id = Article.id where User.id = $user_id");

  if (!$db_request) {
    $error = "Une erreur est survenue, veuillez reessayer";
  }
?>

<?php
  require_once '../../components/header.php'
?>
<h1>Articles : </h1>
<ul>
  <?php while($row_article = $db_request->fetch_assoc()): ?>
    <li class="articleWrapper"><a href="/detail.php?id=<?= $row_article['id'] ?>"><?= $row_article['name'] ?>: <?= $row_article['price'] ?> euros</a> <form action="" method="post"><input type="hidden" name="delete"><input type="hidden" name="article_id" value="<?= $row_article['id'] ?>"><input type="submit" value="Remove" class="but"></form></li>
  <?php endwhile; ?>
</ul>
<?php if(!$error && $db_request->num_rows > 0): ?>
  <a href="/cart/validate.php"><button class="finaliser">Finaliser la commande</button></a>
<?php endif ?>
<?php
  require_once '../../components/footer.php'
?>