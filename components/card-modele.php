<?php
/**
 * Composant Card Modèle Porte
 * Usage: include avec $modele (array), $regionSlug, $deptSlug, $villeSlug, $codePostal
 */
$modeleUrl = urlRelative($regionSlug . '/' . $deptSlug . '/' . $villeSlug . '-' . $codePostal . '/' . $modele['slug'] . '/');
?>
<a href="<?= $modeleUrl ?>"
   class="group flex items-center space-x-3 bg-white rounded-lg border border-gray-200 p-3 hover:border-primary-500 hover:shadow-md transition-all duration-200">
    <span class="text-2xl"><?= $modele['emoji'] ?></span>
    <span class="text-sm font-medium text-gray-700 group-hover:text-primary-600 transition-colors truncate">
        <?= e($modele['nom']) ?>
    </span>
</a>
