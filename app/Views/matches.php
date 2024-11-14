<?= $this->extend('templates/layout') ?>

<?= $this->section('content') ?>

<div class="container mx-auto px-4">
  <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
    <div class="bg-white shadow-xl rounded px-8 py-6">
      <h2 class="text-2xl mb-3 font-semibold p-2 pl-4 bg-blue-50 border-l-2 border-blue-500">Estadísticas Generales</h2>
      <ul class="space-y-3 text-gray-700">
        <li><strong>🟰 Total de Partidos:</strong> <?= esc($stats['total']) ?></li>
        <li><strong>👍🏼 Partidos Ganados:</strong> <?= esc($stats['wins']) ?></li>
        <li><strong>👎🏼 Partidos Perdidos:</strong> <?= esc($stats['losses']) ?></li>
        <li><strong>📊 % de Victorias:</strong> <?= esc($stats['winPercentage']) ?>%</li>
        <li><strong>💰 Dinero Total Gastado:</strong> €<?= esc(number_format($stats['totalCost'], 2)) ?></li>
        <li><strong>📅 Primer Partido:</strong> <?= esc($stats['firstMatch']) ?></li>
        <li><strong>📆 Último Partido:</strong> <?= esc($stats['lastMatch']) ?></li>
      </ul>
    </div>

    <div class="bg-white shadow-xl rounded px-8 py-6">
      <h2 class="text-2xl mb-3 font-semibold p-2 pl-4 bg-blue-50 border-l-2 border-blue-500">Listado de Partidos</h2>
      <?php if (empty($matches)): ?>
        <p class="text-gray-700">No tienes partidos registrados.</p>
      <?php else: ?>
        <ul class="space-y-3">
          <?php foreach ($matches as $match):
            $matchClass = $match['win'] ? 'bg-green-100' : 'bg-red-100'; ?>
            <li class="<?= $matchClass ?> p-4 rounded-md flex justify-between items-center">
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
            </li>
          <?php endforeach; ?>
        </ul>
        <div class="mt-4">
          <?= $pager->links() ?> <!-- Muestra la paginación -->
        </div>
      <?php endif; ?>
    </div>
  </div>

  <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-8">
    <div class="bg-white shadow-xl rounded px-8 py-6">
      <h3 class="text-xl mb-3 font-semibold p-2 pl-4 bg-blue-50 border-l-2 border-blue-500">📅 Última Semana</h3>
      <?php if ($stats['lastWeek']['total'] == 0): ?>
        <p class="text-gray-700">No hay partidos registrados en la última semana.</p>
      <?php else: ?>
        <ul>
          <li>🟰 Total: <?= esc($stats['lastWeek']['total']) ?></li>
          <li>👍🏼 Ganados: <?= esc($stats['lastWeek']['wins']) ?></li>
          <li>👎🏼 Perdidos: <?= esc($stats['lastWeek']['losses']) ?></li>
          <li>📊 % Victorias: <?= esc($stats['lastWeek']['winPercentage']) ?>%</li>
          <li>💰 Gastado: €<?= esc($stats['lastWeek']['totalCost']) ?></li>
        </ul>
      <?php endif; ?>
    </div>

    <div class="bg-white shadow-xl rounded px-8 py-6">
      <h3 class="text-xl mb-3 font-semibold p-2 pl-4 bg-blue-50 border-l-2 border-blue-500">📅 Último Mes</h3>
      <ul>
        <li>🟰 Total: <?= esc($stats['lastMonth']['total']) ?></li>
        <li>👍🏼 Ganados: <?= esc($stats['lastMonth']['wins']) ?></li>
        <li>👎🏼 Perdidos: <?= esc($stats['lastMonth']['losses']) ?></li>
        <li>📊 % Victorias: <?= esc($stats['lastMonth']['winPercentage']) ?>%</li>
        <li>💰 Gastado: €<?= esc($stats['lastMonth']['totalCost']) ?></li>
      </ul>
    </div>

    <div class="bg-white shadow-xl rounded px-8 py-6">
      <h3 class="text-xl mb-3 font-semibold p-2 pl-4 bg-blue-50 border-l-2 border-blue-500">📅 Último Año</h3>
      <ul>
        <li>🟰 Total: <?= esc($stats['lastYear']['total']) ?></li>
        <li>👍🏼 Ganados: <?= esc($stats['lastYear']['wins']) ?></li>
        <li>👎🏼 Perdidos: <?= esc($stats['lastYear']['losses']) ?></li>
        <li>📊 % Victorias: <?= esc($stats['lastYear']['winPercentage']) ?>%</li>
        <li>💰 Gastado: €<?= esc($stats['lastYear']['totalCost']) ?></li>
      </ul>
    </div>
  </div>

  <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-8">
    <div class="bg-white shadow-xl rounded px-8 py-6">
      <h3 class="text-xl mb-3 font-semibold p-2 pl-4 bg-blue-50 border-l-2 border-blue-500">🎮 Modalidades</h3>
      <ul class="space-y-2 text-gray-700">
        <li>🟰 <strong>Amistosos:</strong> <?= esc($modalities['amistoso']) ?> partidos</li>
        <li>🏆 <strong>Torneos:</strong> <?= esc($modalities['torneo']) ?> partidos</li>
        <li>📅 <strong>Ligas:</strong> <?= esc($modalities['liga']) ?> partidos</li>
        <li>⚙️ <strong>Otros:</strong> <?= esc($modalities['otro']) ?> partidos</li>
      </ul>
    </div>

    <div class="bg-white shadow-xl rounded px-8 py-6">
      <h3 class="text-xl mb-3 font-semibold p-2 pl-4 bg-blue-50 border-l-2 border-blue-500">🏅 Categorías</h3>
      <?php if (empty($categories)): ?>
        <p class="text-gray-700">No has jugado partidos en ninguna categoría.</p>
      <?php else: ?>
        <ul class="space-y-2 text-gray-700">
          <?php foreach ($categories as $category): ?>
            <li>🏷 <strong><?= esc($category['category']) ?> Categoría:</strong> <?= esc($category['total']) . ' ' . ($category['total'] > 1 ? 'partidos' : 'partido') ?></li>
          <?php endforeach; ?>
        </ul>
      <?php endif; ?>
    </div>
  </div>

</div>

<?= $this->endSection() ?>