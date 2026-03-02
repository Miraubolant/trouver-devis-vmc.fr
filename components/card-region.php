<?php
/**
 * Composant Card Région
 * Usage: include avec $region (array)
 */
?>
<a href="<?= urlRelative($region['slug'] . '/') ?>"
   class="group block bg-white rounded-xl border border-gray-200 p-6 hover:border-primary-500 hover:shadow-lg transition-all duration-200">
    <div class="flex items-start justify-between">
        <div class="flex-1">
            <h3 class="font-semibold text-gray-900 group-hover:text-primary-600 transition-colors">
                <?= e($region['nom']) ?>
            </h3>
            <p class="text-sm text-gray-500 mt-1">
                <?= $region['departements_count'] ?> département<?= $region['departements_count'] > 1 ? 's' : '' ?>
            </p>
        </div>
        <div class="flex-shrink-0 ml-4">
            <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-primary-50 text-primary-600 group-hover:bg-primary-100 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </span>
        </div>
    </div>
    <div class="mt-4 pt-4 border-t border-gray-100">
        <span class="text-xs text-gray-400 uppercase tracking-wide">Experts qualifiés</span>
    </div>
</a>
