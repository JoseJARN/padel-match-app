<nav aria-label="Pagination" class="mt-4">
  <ul class="flex items-center space-x-2">

    <?php if ($pager->hasPreviousPage()): ?>
      <li>
        <a href="<?= $pager->getPreviousPage() ?>" class="flex items-center justify-center px-3 h-8 leading-tight text-white bg-white border border-gray-300 rounded hover:bg-gray-100 hover:text-gray-700">
          <svg class="w-4 h-4 rtl:rotate-180" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
          </svg>
        </a>
      </li>
    <?php endif; ?>

    <?php foreach ($pager->links() as $link): ?>
      <li>
        <a href="<?= $link['uri'] ?>"
          class="px-3 h-8 leading-tight text-white <?= $link['active'] ? 'bg-blue-500 text-white' : 'bg-white border border-gray-300' ?> rounded hover:bg-gray-100 hover:text-gray-700">
          <?= $link['title'] ?>
        </a>
      </li>
    <?php endforeach; ?>

    <?php if ($pager->hasNextPage()): ?>
      <li>
        <a href="<?= $pager->getNextPage() ?>" class="flex items-center justify-center px-3 h-8 leading-tight text-white bg-white border border-gray-300 rounded hover:bg-gray-100 hover:text-gray-700">
          <svg class="w-4 h-4 rtl:rotate-180" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
          </svg>
        </a>
      </li>
    <?php endif; ?>
  </ul>
</nav>