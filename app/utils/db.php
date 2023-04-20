<?php
  $host = $_ENV['DB_HOST'];
  $user = $_ENV['DB_USER'];
  $password = $_ENV['DB_PASS'];
  $db = $_ENV['DB_NAME'];
    

  if (!$con = mysqli_connect($host,$user,$password,$db)) {
    die('failed to connect to the database');
  }
?>