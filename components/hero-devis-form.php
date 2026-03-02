<?php
/**
 * Composant Formulaire Devis Hero (Widget ViteUnDevis)
 * Usage: include dans la section hero
 * Variables optionnelles: $modele (array avec vud_cat)
 */
$heroVudCat = getVudCatForModele($modele ?? null);
?>

<div class="bg-white text-gray-900 rounded-2xl p-2 shadow-2xl relative">
    <!-- Widget ViteUnDevis -->
    <div id="v2e29b6034ad"></div>
    <script>
        vud_partenaire_id = '<?= VUD_PARTENAIRE_ID ?>';
        vud_categorie_id = '<?= e($heroVudCat) ?>';
        var vud_js = document.createElement('script');
        vud_js.type = 'text/javascript';
        vud_js.src = '//www.viteundevis.com/2e29b6034a/' + vud_partenaire_id + '/' + vud_categorie_id + '/';
        var s = document.getElementsByTagName('script')[0];
        s.parentNode.insertBefore(vud_js, s);
    </script>
</div>
