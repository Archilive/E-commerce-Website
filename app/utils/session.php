<?php
  function create_session(int $id, string $name, string $role, int $solde, string $photo): void {
    if (session_status() === PHP_SESSION_NONE) {
      session_start();
    }

    $_SESSION['name'] = $name;
    $_SESSION['photo'] = $photo;
    $_SESSION['role'] = $role;
    $_SESSION['solde'] = $solde;
    $_SESSION['user_id'] = $id;
  }

  function clear_session(): void {
    if (session_status() === PHP_SESSION_NONE) {
      session_start();
    }

    unset($_SESSION['name']);
    unset($_SESSION['photo']);
    unset($_SESSION['role']);
    unset($_SESSION['solde']);
    unset($_SESSION['user_id']);
  }
?>