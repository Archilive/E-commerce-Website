<?php
  # Guard
  require_once '../utils/auth.php';

  connection_needed();

  # Post
  require_once '../utils/db.php';

  $error = null;
  if (isset($_POST['name']) && isset($_POST['description']) && isset($_POST['price']) && isset($_POST['stock'])) {
    
    $name = $_POST['name'];
    $desc = $_POST['description'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $user_id = $_SESSION['user_id'];

    $db_request_article = mysqli_query($con, "insert into Article (name, description, price, author_id) values ('$name', '$desc', $price, $user_id)");
    
    if ($db_request_article) {
      $article_id = mysqli_insert_id($con);
      $db_request_stock = mysqli_query($con, "insert into Stock (article_id, quantity) values ($article_id, $stock)");

      if ($db_request_stock) {
        header('Location: /account.php');
        exit();
      } else {
        $error = "une erreur c'est produit avec la base de données, veuillez reessayer plus tard";
      }
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
  <label>
    <span>Nom : </span>
    <input type="text" name="name" id="name_input">
  </label>
  <label>
    <span>Description : </span>
    <textarea name="description" id="description_input" cols="20" rows="5"></textarea>
  </label>
  <label>
    <span>Prix : </span>
    <input type="number" name="price" id="price_input">
  </label>
  <label>
    <span>Stock : </span>
    <input type="number" name="stock" id="stock_input" value="1">
  </label>
  <input type="submit" value="Vendre">
</form>
<?php
  require_once '../components/footer.php'
?>