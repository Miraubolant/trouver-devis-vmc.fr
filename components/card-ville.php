<?php
/**
 * Composant Card Ville
 * Usage: include avec $villeCard (array), $regionSlug, $deptSlug
 */
$slug = $villeCard['slug_ville'];
$cp = $villeCard['code_postal'];
$nom = $villeCard['nom_standard'];
$pop = $villeCard['population'] ?? 0;
?>
<a href="<?= urlRelative($regionSlug . '/' . $deptSlug . '/' . $slug . '-' . $cp . '/') ?>"
   class="group block bg-white rounded-lg border border-gray-200 p-4 hover:border-primary-500 hover:shadow-md transition-all duration-200">
    <div class="flex items-center justify-between">
        <div class="flex-1 min-w-0">
            <h3 class="font-medium text-gray-900 group-hover:text-primary-600 transition-colors truncate">
                <?= e($nom) ?>
            </h3>
            <p class="text-sm text-gray-500"><?= e($cp) ?></p>
        </div>
        <?php if ($pop > 0): ?>
        <div class="flex-shrink-0 ml-2">
            <span class="text-xs text-gray-400"><?= number_format($pop, 0, ',', ' ') ?> hab.</span>
        </div>
        <?php endif; ?>
    </div>
</a>
