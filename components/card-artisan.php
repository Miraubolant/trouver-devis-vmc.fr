<?php
/**
 * Composant Card Artisan
 * Usage: include avec $artisan (array), $regionSlug, $deptSlug, $villeSlug, $codePostal
 */
$nom = $artisan['nom'];
$note = $artisan['note'] ?? 0;
$avis = $artisan['avis'] ?? 0;
$tel = $artisan['telephone'] ?? null;
$adresse = $artisan['adresse'] ?? null;
$type = $artisan['type'] ?? null;
$slug = $artisan['slug'];
$artisanUrl = urlRelative($regionSlug . '/' . $deptSlug . '/' . $villeSlug . '-' . $codePostal . '/artisans/' . $slug . '/');
?>
<div class="bg-white rounded-xl border border-gray-200 p-6 hover:shadow-lg transition-shadow">
    <div class="flex items-start justify-between">
        <div class="flex-1">
            <a href="<?= $artisanUrl ?>" class="block">
                <h3 class="font-semibold text-gray-900 hover:text-primary-600 transition-colors">
                    <?= e($nom) ?>
                </h3>
            </a>
            <?php if ($type): ?>
            <p class="text-sm text-gray-500 mt-1"><?= e($type) ?></p>
            <?php endif; ?>
        </div>
        <?php if ($note > 0): ?>
        <div class="flex-shrink-0 ml-4 text-right">
            <div class="flex items-center space-x-1">
                <span class="text-yellow-400 text-lg">&#9733;</span>
                <span class="font-semibold text-gray-900"><?= number_format($note, 1) ?></span>
            </div>
            <?php if ($avis > 0): ?>
            <p class="text-xs text-gray-500"><?= $avis ?> avis</p>
            <?php endif; ?>
        </div>
        <?php endif; ?>
    </div>

    <?php if ($adresse): ?>
    <div class="flex items-center text-sm text-gray-600 mt-3">
        <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
        </svg>
        <span class="truncate"><?= e($adresse) ?></span>
    </div>
    <?php endif; ?>

    <div class="mt-4 pt-4 border-t border-gray-100 flex flex-wrap gap-2">
        <?php if ($tel): ?>
        <a href="tel:<?= preg_replace('/[^0-9+]/', '', $tel) ?>"
           class="inline-flex items-center px-4 py-2 bg-green-500 hover:bg-green-600 text-white text-sm font-medium rounded-lg transition-colors">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
            </svg>
            Appeler
        </a>
        <?php endif; ?>
        <a href="<?= $artisanUrl ?>"
           class="inline-flex items-center px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white text-sm font-medium rounded-lg transition-colors">
            Voir la fiche
            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </a>
    </div>
</div>
