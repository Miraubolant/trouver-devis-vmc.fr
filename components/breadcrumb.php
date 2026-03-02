<?php
/**
 * Composant Breadcrumb
 * Usage: include avec $breadcrumbs = [['name' => 'Accueil', 'url' => '/'], ...]
 */
?>
<nav aria-label="Fil d'Ariane" class="bg-gray-100 border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3">
        <ol class="flex flex-wrap items-center space-x-2 text-sm">
            <?php foreach ($breadcrumbs as $i => $item): ?>
                <?php $isLast = ($i === count($breadcrumbs) - 1); ?>
                <li class="flex items-center">
                    <?php if ($i > 0): ?>
                        <svg class="w-4 h-4 text-gray-400 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    <?php endif; ?>

                    <?php if ($isLast): ?>
                        <span class="text-gray-600 font-medium truncate max-w-[200px]" title="<?= e($item['name']) ?>">
                            <?= e($item['name']) ?>
                        </span>
                    <?php else: ?>
                        <a href="<?= e($item['url']) ?>"
                           class="text-primary-600 hover:text-primary-800 hover:underline truncate max-w-[150px]"
                           title="<?= e($item['name']) ?>">
                            <?= e($item['name']) ?>
                        </a>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ol>
    </div>
</nav>
