<?php
  # Guard
  require_once '../utils/auth.php';

  connection_needed();
  if (!is_admin()) {
    header('Location: /');
    exit();
  }

  # Post
  require_once '../utils/db.php';

  if (isset($_POST['user']) && isset($_POST['id'])) {
    $id = $_POST['id'];
    mysqli_query($con, "delete from User where id = $id");
  }
  
  if (isset($_POST['article']) && isset($_POST['id'])) {
    $id = $_POST['id'];
    mysqli_query($con, "delete from Article where id = $id");
  }

  # Fetching
  require_once '../components/adminListItem.php';

  $db_request_user = mysqli_query($con, "select id, username, role from User");
  $db_users_html = "";

  if ($db_request_user) {
    while ($row = $db_request_user->fetch_assoc()) {
      $db_users_html .= UserItem($row['id'], $row['username'], $row['role']);
    }
  }

  $db_request_article = mysqli_query($con, "select id, name from Article");
  $db_article_html = "";

  if ($db_request_article) {
    while ($row = $db_request_article->fetch_assoc()) {
      $db_article_html .= ArticleItem($row['id'], $row['name']);
    }
  }

?>

<?php require_once '../components/header.php' ?>
<span>User List :</span>
<ul>
<?= $db_users_html ?>
</ul>
<span>Article List :</span>
<ul>
<?= $db_article_html ?>
</ul>
<?php require_once '../components/footer.php' ?>