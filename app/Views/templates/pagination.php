<nav aria-label="Pagination" class="mt-4">
  <ul class="flex items-center space-x-2">

    <!-- Botón Anterior -->
    <?php if ($pager->hasPreviousPage()): ?>
      <li>
        <a href="<?= $pager->getPreviousPage() ?>"
          class="flex items-center justify-center w-10 h-10 text-gray-700 bg-white border border-gray-300 rounded-full hover:bg-blue-500 hover:text-white transition duration-200" style="width:24px;height:24px;border-radius:50%;display:grid;place-items:center">
          <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="height:16px;width:16px">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
          </svg>
        </a>
      </li>
    <?php endif; ?>

    <!-- Números de Paginación -->
    <?php foreach ($pager->links() as $link): ?>
      <li>
        <a href="<?= $link['uri'] ?>"
          class="flex items-center justify-center w-10 h-10 text-sm font-medium <?= $link['active'] ? 'bg-blue-500 text-white' : 'bg-white text-gray-700 border border-gray-300' ?> rounded-full hover:bg-blue-500 hover:text-white transition duration-200" style="width:24px;height:24px;border-radius:50%;display:grid;place-items:center">
          <?= $link['title'] ?>
        </a>
      </li>
    <?php endforeach; ?>

    <!-- Botón Siguiente -->
    <?php if ($pager->hasNextPage()): ?>
      <li>
        <a href="<?= $pager->getNextPage() ?>"
          class="flex items-center justify-center w-10 h-10 text-gray-700 bg-white border border-gray-300 rounded-full hover:bg-blue-500 hover:text-white transition duration-200" style="width:24px;height:24px;border-radius:50%;display:grid;place-items:center">
          <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="height:16px;width:16px">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
          </svg>
        </a>
      </li>
    <?php endif; ?>

  </ul>
</nav>