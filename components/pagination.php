<?php
/**
 * Composant Pagination
 * Usage: include avec $pagination = ['current' => 1, 'total' => 10, 'baseUrl' => '/region/dept/']
 */

if (!isset($pagination) || $pagination['total'] <= 1) return;

$current = $pagination['current'];
$total = $pagination['total'];
$baseUrl = rtrim($pagination['baseUrl'], '/');

// Calcul des pages à afficher
$range = 2;
$start = max(1, $current - $range);
$end = min($total, $current + $range);
?>

<nav aria-label="Pagination" class="flex justify-center mt-8">
    <ul class="flex items-center space-x-1">
        <!-- Previous -->
        <?php if ($current > 1): ?>
        <li>
            <a href="<?= $baseUrl ?>?page=<?= $current - 1 ?>"
               class="flex items-center justify-center w-10 h-10 rounded-lg border border-gray-300 bg-white text-gray-600 hover:bg-gray-50 hover:border-primary-500 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
        </li>
        <?php else: ?>
        <li>
            <span class="flex items-center justify-center w-10 h-10 rounded-lg border border-gray-200 bg-gray-100 text-gray-400 cursor-not-allowed">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </span>
        </li>
        <?php endif; ?>

        <!-- First page + ellipsis -->
        <?php if ($start > 1): ?>
        <li>
            <a href="<?= $baseUrl ?>?page=1"
               class="flex items-center justify-center w-10 h-10 rounded-lg border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 hover:border-primary-500 transition-colors">
                1
            </a>
        </li>
        <?php if ($start > 2): ?>
        <li><span class="px-2 text-gray-400">...</span></li>
        <?php endif; ?>
        <?php endif; ?>

        <!-- Page numbers -->
        <?php for ($i = $start; $i <= $end; $i++): ?>
        <li>
            <?php if ($i === $current): ?>
            <span class="flex items-center justify-center w-10 h-10 rounded-lg bg-primary-600 text-white font-semibold">
                <?= $i ?>
            </span>
            <?php else: ?>
            <a href="<?= $baseUrl ?>?page=<?= $i ?>"
               class="flex items-center justify-center w-10 h-10 rounded-lg border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 hover:border-primary-500 transition-colors">
                <?= $i ?>
            </a>
            <?php endif; ?>
        </li>
        <?php endfor; ?>

        <!-- Last page + ellipsis -->
        <?php if ($end < $total): ?>
        <?php if ($end < $total - 1): ?>
        <li><span class="px-2 text-gray-400">...</span></li>
        <?php endif; ?>
        <li>
            <a href="<?= $baseUrl ?>?page=<?= $total ?>"
               class="flex items-center justify-center w-10 h-10 rounded-lg border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 hover:border-primary-500 transition-colors">
                <?= $total ?>
            </a>
        </li>
        <?php endif; ?>

        <!-- Next -->
        <?php if ($current < $total): ?>
        <li>
            <a href="<?= $baseUrl ?>?page=<?= $current + 1 ?>"
               class="flex items-center justify-center w-10 h-10 rounded-lg border border-gray-300 bg-white text-gray-600 hover:bg-gray-50 hover:border-primary-500 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </li>
        <?php else: ?>
        <li>
            <span class="flex items-center justify-center w-10 h-10 rounded-lg border border-gray-200 bg-gray-100 text-gray-400 cursor-not-allowed">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </span>
        </li>
        <?php endif; ?>
    </ul>
</nav>
