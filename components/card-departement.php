<?php
/**
 * Composant Card Département
 * Usage: include avec $dept (array), $regionSlug
 */
?>
<a href="<?= urlRelative($regionSlug . '/' . $dept['slug'] . '/') ?>"
   class="group block bg-white rounded-xl border border-gray-200 p-6 hover:border-primary-500 hover:shadow-lg transition-all duration-200">
    <div class="flex items-center space-x-4">
        <div class="flex-shrink-0 w-14 h-14 rounded-xl bg-gradient-to-br from-primary-500 to-primary-600 flex items-center justify-center text-white font-bold text-lg">
            <?= e($dept['code']) ?>
        </div>
        <div class="flex-1 min-w-0">
            <h3 class="font-semibold text-gray-900 group-hover:text-primary-600 transition-colors truncate">
                <?= e($dept['nom']) ?>
            </h3>
            <p class="text-sm text-gray-500">
                <?= $dept['villes_count'] ?? 0 ?> ville<?= ($dept['villes_count'] ?? 0) > 1 ? 's' : '' ?>
            </p>
        </div>
        <div class="flex-shrink-0">
            <svg class="w-5 h-5 text-gray-400 group-hover:text-primary-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </div>
    </div>
</a>
