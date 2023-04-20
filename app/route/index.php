<?php
  # Guard
  require_once '../utils/auth.php';
  $connected = is_connected();

  # Fetching
  require_once '../utils/db.php';
  $error = null;

  $db_request = mysqli_query($con, "select * from Article order by publication_date desc limit 10");

  if (!$db_request) {
    $error = "Une erreur est survenue, veuillez reessayer";
  }
?>

<?php
  require_once '../components/header.php';
?>

<div class="card-home">
  <h1><span>Articles récent : </span></h1>
  <?php if ($error): ?>
    <div>
      <?= $error ?>
    </div>
  <?php else: ?>
    <ul>
      <?php while($row = $db_request->fetch_assoc()): ?>
        <a href="/detail.php?id=<?=$row['id']?>"><?=$row['name']?>, <?=$row['price']?> Euros, publié le <?=$row['publication_date']?></a>
      <?php endwhile ?>
    </ul>
  <?php endif ?>
</div>

<?php
  require_once '../components/footer.php';
?>