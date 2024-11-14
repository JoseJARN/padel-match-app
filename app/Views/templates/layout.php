<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="/dist/output.css">
  <title><?= isset($title) ? esc($title) : 'Pádel Match'; ?></title>
</head>

<header class="header" id="header">
  <nav class="bg-blue-500 text-white p-4">
    <div class="container mx-auto flex justify-between items-center">
      <a href="/" class="text-white font-bold">Pádel Match</a>
      <ul class="flex space-x-4">
        <li><a href="/login">Iniciar sesión</a></li>
        <li><a href="/register">Registrarse</a></li>
      </ul>
    </div>
  </nav>
</header>

<body>
  <main class="main bg-gray-50 pt-16 pb-16" id="main">
    <div class="container mx-auto px-4">
      <?= $this->renderSection('content') ?>
    </div>
  </main>
</body>

<footer class="footer bg-blue-500 p-4" id="footer">
  <div class="container mx-auto">
    <p class="text-center text-white text-sm font-bold"><?= date("Y") ?> &copy; Pádel Match</p>
  </div>
</footer>

</html>