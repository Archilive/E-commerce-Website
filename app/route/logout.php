<?php
  require_once '../utils/session.php';

  clear_session();
  header('Location: /');
  exit();
?>