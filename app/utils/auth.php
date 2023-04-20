<?php
  function is_connected(): bool {
    if (session_status() === PHP_SESSION_NONE) {
      session_start();
    }

    return !empty($_SESSION['user_id']);
  }

  function connection_needed(): void {
    if (!is_connected()) {
      header('Location: /login.php');
      exit();
    }
  }

  function is_admin(): bool {
    if (session_status() === PHP_SESSION_NONE) {
      session_start();
    }

    return $_SESSION['role'] === 'admin';
  }
?>