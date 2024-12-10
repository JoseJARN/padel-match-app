<?= $this->extend('templates/layout') ?>

<?= $this->section('content') ?>

<div class="container mx-auto px-4">
  <p class="welcome_message text-3xl font-bold mb-12">Bienvenid@, <?= session()->get('first_name') ?>! 👋</p>
  <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

    <div class="bg-white shadow-xl rounded px-8 py-6">
      <h1 class="form__title text-2xl mb-3 font-semibold p-2 pl-4 bg-blue-50 border-l-2 border-blue-500">Registrar Partido</h1>
      <?php if (session()->get('success')): ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-3" role="alert">
          <span class="block sm:inline"><?= esc(session()->get('success')) ?></span>
        </div>
      <?php elseif (session()->get('error')): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-3" role="alert">
          <span class="block sm:inline"><?= esc(session()->get('error')) ?></span>
        </div>
      <?php endif; ?>
      <form action="/board/add" method="POST" class="space-y-4">
        <div class="flex flex-col">
          <label for="partner" class="mb-2 text-sm font-medium">Compañero</label>
          <input type="text" name="partner" required class="rounded-md border border-gray-300 p-2">
        </div>

        <div class="flex flex-col">
          <label for="rivals" class="mb-2 text-sm font-medium">Rivales</label>
          <input type="text" name="rivals" required class="rounded-md border border-gray-300 p-2">
        </div>

        <div class="flex flex-col">
          <label for="result" class="mb-2 text-sm font-medium">Resultado</label>
          <input type="text" name="result" required class="rounded-md border border-gray-300 p-2">
        </div>

        <div class="flex flex-col">
          <label for="win" class="mb-2 text-sm font-medium">¿Ganado?</label>
          <select name="win" required class="rounded-md border border-gray-300 p-2">
            <option value="1">Sí</option>
            <option value="0">No</option>
          </select>
        </div>

        <div class="flex flex-col">
          <label for="category" class="mb-2 text-sm font-medium">Categoría</label>
          <select name="category" required class="rounded-md border border-gray-300 p-2">
            <option value="1ª">1ª</option>
            <option value="2ª">2ª</option>
            <option value="3ª">3ª</option>
            <option value="4ª">4ª</option>
            <option value="5ª">5ª</option>
          </select>
        </div>

        <div class="flex flex-col">
          <label for="mode" class="mb-2 text-sm font-medium">Modo</label>
          <select name="mode" required class="rounded-md border border-gray-300 p-2">
            <option value="amistoso">Amistoso</option>
            <option value="torneo">Torneo</option>
            <option value="liga">Liga</option>
            <option value="otro">Otro</option>
          </select>
        </div>

        <div class="flex flex-col">
          <label for="club" class="mb-2 text-sm font-medium">Club</label>
          <input type="text" name="club" required class="rounded-md border border-gray-300 p-2">
        </div>

        <div class="flex flex-col">
          <label for="location" class="mb-2 text-sm font-medium">Localidad</label>
          <input type="text" name="location" required class="rounded-md border border-gray-300 p-2">
        </div>

        <div class="flex flex-col">
          <label for="date" class="mb-2 text-sm font-medium">Fecha</label>
          <input type="datetime-local" name="date" required class="rounded-md border border-gray-300 p-2">
        </div>

        <div class="flex flex-col">
          <label for="cost" class="mb-2 text-sm font-medium">Coste</label>
          <input type="number" name="cost" step="0.01" required class="rounded-md border border-gray-300 p-2">
        </div>

        <button type="submit" class="bg-blue-500 text-white hover:bg-blue-700 font-bold py-2 px-4 rounded">Añadir Partido</button>
      </form>
    </div>

    <div class="bg-white shadow-xl rounded px-8 py-6">
      <h2 class="text-2xl mb-3 font-semibold p-2 pl-4 bg-blue-50 border-l-2 border-blue-500">Últimos 10 Partidos</h2>
      <?php if (empty($matches)): ?>
        <p class="text-gray-700">No tienes partidos registrados. ¡Añade uno!</p>
      <?php else: ?>
        <ul class="space-y-3">
          <?php foreach ($matches as $match):
            $matchClass = $match['win'] ? 'bg-green-100' : 'bg-red-100'; ?>
            <li class="<?= $matchClass ?> p-4 rounded-md">
              <div>
                <p><strong>👥 Compañero:</strong> <?= esc($match['partner']) ?></p>
                <p><strong>🆚 Rivales:</strong> <?= esc($match['rivals']) ?></p>
                <p><strong>🏅 Resultado:</strong> <?= esc($match['result']) ?> (<?= $match['win'] ? 'Ganado' : 'Perdido' ?>)</p>
                <p><strong>🏆 Categoría:</strong> <?= esc($match['category']) ?></p>
                <p><strong>🎾 Modo:</strong> <?= esc($match['mode']) ?></p>
                <p><strong>🏢 Club:</strong> <?= esc($match['club']) ?></p>
                <p><strong>📍 Localidad:</strong> <?= esc($match['location']) ?></p>
                <p><strong>🗓️ Fecha:</strong> <?= esc($match['date']) ?></p>
                <p><strong>💰 Costo:</strong> <?= esc($match['cost']) ?></p>
              </div>
              <div class="flex space-x-2 mt-4">
                <a href="/matches/edit/<?= esc($match['id']) ?>" class="bg-yellow-400 text-white px-3 py-1 rounded hover:bg-yellow-500">Editar</a>
                <a href="/matches/delete/<?= esc($match['id']) ?>" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600" onclick="return confirm('¿Estás seguro de eliminar este partido?')">Eliminar</a>
              </div>
            </li>
          <?php endforeach; ?>
        </ul>
      <?php endif; ?>
      <div class="mt-4">
        <a href="/matches" class="bg-blue-500 text-white hover:bg-blue-700 font-bold py-2 px-4 rounded">Ver todos los partidos</a>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection() ?>