<?php
// Comprobamos si hay sesión activa
if (session()->get('isLoggedIn')) {
  // Si hay sesión, redirigir a /board
  header('Location: /board');
  exit;
} else {
  // Si no hay sesión, redirigir a /login
  header('Location: /login');
  exit;
}
