<?= $this->extend('templates/layout') ?>

<?= $this->section('content') ?>

<div class="container mx-auto px-4">
  <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
    <div class="bg-white shadow-xl rounded px-8 py-6">
      <h1 class="form__title text-2xl mb-3 font-semibold p-2 pl-4 bg-blue-50 border-l-2 border-blue-500">Registra tu usuario</h1>
      <?php
      if (isset($error_form)) {
        echo '<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-3" role="alert">';
        echo '<span class="block sm:inline">' . esc($error_form) . '</span>';
        echo '</div>';
      }
      ?>
      <form action="/register" method="POST" class="space-y-4">
        <div class="flex flex-col">
          <label for="email" class="mb-2 text-sm font-medium">Correo electrónico</label>
          <input type="email" name="email" value="" placeholder="test@example.com" required class="rounded-md border border-gray-300 p-2">
        </div>

        <div class="flex flex-col">
          <label for="password" class="mb-2 text-sm font-medium">Contraseña</label>
          <input type="password" name="password" value="" required class="rounded-md border border-gray-300 p-2">
        </div>

        <div class="flex flex-col">
          <label for="repeat_password" class="mb-2 text-sm font-medium">Repite tu contraseña</label>
          <input type="password" name="repeat_password" value="" required class="rounded-md border border-gray-300 p-2">
        </div>

        <div class="flex flex-col">
          <label for="first_name" class="mb-2 text-sm font-medium">Nombre</label>
          <input type="text" name="first_name" value="" placeholder="Jose" required class="rounded-md border border-gray-300 p-2">
        </div>

        <div class="flex flex-col">
          <label for="last_name" class="mb-2 text-sm font-medium">Apellido</label>
          <input type="text" name="last_name" placeholder="Rodríguez" value="" required class="rounded-md border border-gray-300 p-2">
        </div>

        <button type="submit" class="bg-blue-500 text-white hover:bg-blue-700 font-bold py-2 px-4 rounded">Registrarse</button>

        <p class="">¿Ya tienes cuenta? <a href="/login" rel="noopener noreferrer" class="font-bold hover:underline">Iniciar sesión</a></p>
      </form>
    </div>

    <div class="bg-white shadow-xl rounded px-8 py-6">
      <h2 class="text-2xl mb-3 font-semibold p-2 pl-4 bg-blue-50 border-l-2 border-blue-500">¿Por qué Pádel Match?</h2>
      <div class="box-content">
        <p class="mb-[16px]">Se trata de una aplicación <strong>totalmente gratuita</strong> que tiene como objetivo registrar tus partidos de pádel para guardar un histórico de los mismos y además llevar un control y estadísticas de los partidos ganados, perdidos y del dinero gastado.</p>
        <p class="mb-[16px]">¿Quiéres saber cuáles son las funciones que tiene?</p>
        <ul class="mb-[16px]">
          <li class="mb-2">📝 <strong>Registra tus partidos:</strong> Guarda un historial detallado de cada partido, incluyendo fecha, rivales y resultado.</li>
          <li class="mb-2">📈 <strong>Analiza tu progreso:</strong> Visualiza tus estadísticas de forma clara y sencilla. Lleva un control de tus partidos ganados, perdidos y el porcentaje de victorias.</li>
          <li>💶 <strong>Lleva un registro de tus gastos:</strong> Descubre cuanto dinero llevas gastado en partidos.</li>
        </ul>
        <p>¡Y mucho más! Pádel Match es tu compañero ideal para controlar tu inversión y progreso en este deporte.</p>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection() ?>