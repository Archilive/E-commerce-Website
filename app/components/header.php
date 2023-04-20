<?php
  require_once __DIR__ . '/../utils/auth.php';
  $connected = is_connected();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="/static/style/header.css">
  <link rel="stylesheet" href="/static/style/loginRegister.css">
  <link rel="stylesheet" href="/static/style/account.css">
  <link rel="stylesheet" href="/static/style/home.css">
  <link rel="stylesheet" href="/static/style/detail.css">
  <title>Yamazon</title>
</head>
  
<body>
  <header>
    <nav>
      <a href="/">Accueil</a>
      <?php if ($connected): ?>
        <a href="/account.php"><span>Votre Compte
          <?= $_SESSION['name'] ?></span>
        </a>
        <a href="/cart">Panier</a>
        <a href="/logout.php">Logout</a>
      <?php else: ?>
        <a href="/login.php">Login</a>
        <a href="/register.php">Register</a>
      <?php endif ?>
      <?php if($connected && $_SESSION['role'] === 'admin'): ?>
        <a href="/admin.php">Admin panel</a>
      <?php endif ?>
    </nav>
  </header>