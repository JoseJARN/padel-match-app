<?= $this->extend('templates/layout') ?>

<?= $this->section('content') ?>
<h1>Registro</h1>
<form action="/register" method="POST">
  <label for="email">Correo electrónico</label>
  <input type="email" name="email" value="test@example.com" required><br>

  <label for="password">Contraseña</label>
  <input type="password" name="password" value="password123" required><br>

  <label for="first_name">Nombre</label>
  <input type="text" name="first_name" value="Test" required><br>

  <label for="last_name">Apellido</label>
  <input type="text" name="last_name" value="User" required><br>

  <button type="submit">Registrarse</button>
</form>

<?= $this->endSection() ?>