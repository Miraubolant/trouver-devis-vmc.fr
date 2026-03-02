<?php
/**
 * Composant CTA Devis (avec widget ViteUnDevis)
 * Usage: include avec optionnel $ville (string ou array), $codePostal, $modele
 */

// Gestion de $ville qui peut être un string ou un array
$ctaVille = null;
if (isset($ville)) {
    $ctaVille = is_array($ville) ? ($ville['nom_standard'] ?? null) : $ville;
}
$ctaCodePostal = $codePostal ?? null;
$ctaVudCat = getVudCatForModele($modele ?? null);
$ctaTitle = $ctaVille
    ? "Demandez vos devis " . METIER . " à " . e($ctaVille)
    : "Demandez vos devis " . METIER;
?>

<section id="devis" class="bg-gradient-to-br from-primary-600 to-primary-800 rounded-2xl p-6 shadow-xl">
    <div class="text-center mb-4">
        <h2 class="text-2xl font-bold text-white mb-2">
            <?= $ctaTitle ?>
        </h2>
        <p class="text-primary-100">
            Recevez jusqu'à 3 devis gratuits de <?= METIER_PLURAL ?> qualifiés près de chez vous
        </p>
    </div>

    <div class="bg-white text-gray-900 rounded-xl p-2 shadow-inner">
        <!-- Widget ViteUnDevis -->
        <div id="v2e29b6034ad"></div>
        <script>
            vud_partenaire_id = '<?= VUD_PARTENAIRE_ID ?>';
            vud_categorie_id = '<?= e($ctaVudCat) ?>';
            var vud_js = document.createElement('script');
            vud_js.type = 'text/javascript';
            vud_js.src = '//www.viteundevis.com/2e29b6034a/' + vud_partenaire_id + '/' + vud_categorie_id + '/';
            var s = document.getElementsByTagName('script')[0];
            s.parentNode.insertBefore(vud_js, s);
        </script>
    </div>

    <div class="mt-4 flex flex-wrap justify-center gap-4 text-sm text-primary-100">
        <div class="flex items-center space-x-2">
            <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            <span>100% gratuit</span>
        </div>
        <div class="flex items-center space-x-2">
            <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            <span>Sans engagement</span>
        </div>
        <div class="flex items-center space-x-2">
            <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            <span>Artisans vérifiés</span>
        </div>
    </div>
</section>
