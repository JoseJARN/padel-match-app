<?= $this->extend('templates/layout') ?>

<?= $this->section('content') ?>

<div class="container mx-auto px-4">
  <h1 class="text-3xl font-bold mb-6">Editar Partido</h1>

  <a href="/matches" class="block text-blue-500 hover:underline mb-4 mt-4">Volver atrás</a>

  <?php if (session()->get('error')): ?>
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-3" role="alert">
      <span class="block sm:inline"><?= esc(session()->get('error')) ?></span>
    </div>
  <?php endif; ?>

  <form action="/matches/edit/<?= $match['id'] ?>" method="POST" class="space-y-4">
    <?= csrf_field() ?>

    <div class="flex flex-col">
      <label for="partner" class="mb-2 text-sm font-medium">Compañero</label>
      <input type="text" name="partner" value="<?= esc($match['partner']) ?>" required class="rounded-md border border-gray-300 p-2">
    </div>

    <div class="flex flex-col">
      <label for="rivals" class="mb-2 text-sm font-medium">Rivales</label>
      <input type="text" name="rivals" value="<?= esc($match['rivals']) ?>" required class="rounded-md border border-gray-300 p-2">
    </div>

    <div class="flex flex-col">
      <label for="result" class="mb-2 text-sm font-medium">Resultado</label>
      <input type="text" name="result" value="<?= esc($match['result']) ?>" required class="rounded-md border border-gray-300 p-2">
    </div>

    <div class="flex flex-col">
      <label for="win" class="mb-2 text-sm font-medium">¿Ganado?</label>
      <select name="win" required class="rounded-md border border-gray-300 p-2">
        <option value="1" <?= $match['win'] == 1 ? 'selected' : '' ?>>Sí</option>
        <option value="0" <?= $match['win'] == 0 ? 'selected' : '' ?>>No</option>
      </select>
    </div>

    <div class="flex flex-col">
      <label for="category" class="mb-2 text-sm font-medium">Categoría</label>
      <select name="category" required class="rounded-md border border-gray-300 p-2">
        <option value="1ª" <?= $match['category'] == '1ª' ? 'selected' : '' ?>>1ª</option>
        <option value="2ª" <?= $match['category'] == '2ª' ? 'selected' : '' ?>>2ª</option>
        <option value="3ª" <?= $match['category'] == '3ª' ? 'selected' : '' ?>>3ª</option>
        <option value="4ª" <?= $match['category'] == '4ª' ? 'selected' : '' ?>>4ª</option>
        <option value="5ª" <?= $match['category'] == '5ª' ? 'selected' : '' ?>>5ª</option>
      </select>
    </div>

    <div class="flex flex-col">
      <label for="mode" class="mb-2 text-sm font-medium">Modo</label>
      <select name="mode" required class="rounded-md border border-gray-300 p-2">
        <option value="amistoso" <?= $match['mode'] == 'amistoso' ? 'selected' : '' ?>>Amistoso</option>
        <option value="torneo" <?= $match['mode'] == 'torneo' ? 'selected' : '' ?>>Torneo</option>
        <option value="liga" <?= $match['mode'] == 'liga' ? 'selected' : '' ?>>Liga</option>
        <option value="otro" <?= $match['mode'] == 'otro' ? 'selected' : '' ?>>Otro</option>
      </select>
    </div>

    <div class="flex flex-col">
      <label for="club" class="mb-2 text-sm font-medium">Club</label>
      <input type="text" name="club" value="<?= esc($match['club']) ?>" required class="rounded-md border border-gray-300 p-2">
    </div>

    <div class="flex flex-col">
      <label for="location" class="mb-2 text-sm font-medium">Localidad</label>
      <input type="text" name="location" value="<?= esc($match['location']) ?>" required class="rounded-md border border-gray-300 p-2">
    </div>

    <div class="flex flex-col">
      <label for="date" class="mb-2 text-sm font-medium">Fecha</label>
      <input type="datetime-local" name="date" value="<?= date('Y-m-d\TH:i', strtotime($match['date'])) ?>" required class="rounded-md border border-gray-300 p-2">
    </div>

    <div class="flex flex-col">
      <label for="cost" class="mb-2 text-sm font-medium">Coste</label>
      <input type="number" name="cost" step="0.01" value="<?= esc($match['cost']) ?>" required class="rounded-md border border-gray-300 p-2">
    </div>

    <button type="submit" class="bg-blue-500 text-white hover:bg-blue-700 font-bold py-2 px-4 rounded">Actualizar Partido</button>
  </form>
</div>

<?= $this->endSection() ?>