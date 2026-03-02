<?php
/**
 * Page Service - Annuaire Portes
 * URL: /services/{modele-slug}/
 * Landing page par service avec recherche de ville
 */

require_once __DIR__ . '/../functions.php';

$serviceSlug = $params['service'] ?? null;

if (!$serviceSlug) {
    http_response_code(404);
    include __DIR__ . '/../templates/404.php';
    exit;
}

// Charger le modèle correspondant
$modele = getModeleBySlug($serviceSlug);

if (!$modele) {
    http_response_code(404);
    include __DIR__ . '/../templates/404.php';
    exit;
}

// Toutes les régions pour le maillage
$regions = getRegions();

// SEO
$pageTitle = seoTitle($modele['nom'] . ' - Trouvez un ' . METIER . ' près de chez vous');
$pageDescription = seoDescription($modele['nom'] . ' : trouvez un ' . METIER . ' qualifié dans votre ville. Devis gratuit et sans engagement pour votre projet de ' . mb_strtolower($modele['nom']) . '.');
$canonical = SITE_URL . '/services/' . $modele['slug'] . '/';

// Breadcrumbs
$breadcrumbs = [
    ['name' => 'Accueil', 'url' => SITE_URL],
    ['name' => 'Services', 'url' => SITE_URL . '/#services'],
    ['name' => $modele['nom'], 'url' => $canonical]
];

// JSON-LD
$jsonLd = [
    jsonLdOrganization(),
    jsonLdBreadcrumb($breadcrumbs)
];

// Autres services (tous sauf celui en cours)
$autresModeles = array_filter(MODELES, fn($m) => $m['slug'] !== $serviceSlug);

include __DIR__ . '/../templates/header.php';
?>

<!-- Breadcrumb -->
<?php include __DIR__ . '/../components/breadcrumb.php'; ?>

<!-- Hero -->
<section class="relative py-16 lg:py-24 overflow-hidden" style="min-height: 400px;">
    <div class="absolute inset-0 z-0">
        <img src="<?= HERO_IMAGE ?>"
             alt="<?= e($modele['nom']) ?>"
             class="w-full h-full object-cover"
             loading="eager">
        <div class="absolute inset-0 bg-gradient-to-br from-primary-900/90 via-primary-800/85 to-primary-700/80"></div>
    </div>
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <span class="text-6xl mb-4 block"><?= $modele['emoji'] ?></span>
        <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-4">
            <?= e($modele['nom']) ?>
        </h1>
        <p class="text-xl text-white/90 mb-8 max-w-2xl mx-auto">
            Trouvez un <?= METIER ?> spécialisé en <?= mb_strtolower(e($modele['nom'])) ?> dans votre ville. Devis gratuit et sans engagement.
        </p>

        <!-- Search -->
        <div class="max-w-xl mx-auto">
            <?php $searchPlaceholder = "Entrez votre ville ou code postal..."; ?>
            <?php $searchUrlSuffix = $modele['slug'] . '/'; ?>
            <?php include __DIR__ . '/../components/search-autocomplete.php'; ?>
        </div>
    </div>
</section>

<!-- Widget Devis -->
<section class="py-12 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <?php include __DIR__ . '/../components/cta-devis.php'; ?>
    </div>
</section>

<!-- Régions -->
<section class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-2">
                <?= e($modele['nom']) ?> par région
            </h2>
            <p class="text-gray-600">
                Sélectionnez votre région pour trouver un spécialiste en <?= mb_strtolower(e($modele['nom'])) ?>
            </p>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <?php foreach ($regions as $r): ?>
            <a href="<?= urlRelative($r['slug'] . '/') ?>"
               class="group bg-white rounded-xl p-5 border border-gray-200 hover:border-primary-500 hover:shadow-lg transition-all">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="font-semibold text-gray-900 group-hover:text-primary-600 transition-colors">
                            <?= e($r['nom']) ?>
                        </h3>
                        <p class="text-sm text-gray-500 mt-1">
                            <?= $r['departements_count'] ?> départements
                        </p>
                    </div>
                    <svg class="w-5 h-5 text-gray-400 group-hover:text-primary-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Villes populaires -->
<section class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">
            <?= e($modele['nom']) ?> dans les grandes villes
        </h2>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3">
            <?php foreach (TOP_VILLES as $tv): ?>
            <a href="<?= urlRelative($tv['region'] . '/' . $tv['dept'] . '/' . $tv['slug'] . '-' . $tv['cp'] . '/' . $modele['slug'] . '/') ?>"
               class="group text-center bg-gray-50 hover:bg-primary-50 rounded-xl p-4 border border-gray-200 hover:border-primary-500 transition-all">
                <span class="block font-semibold text-gray-900 group-hover:text-primary-600 text-sm transition-colors">
                    <?= e($tv['nom']) ?>
                </span>
                <span class="text-xs text-gray-500"><?= e($tv['cp']) ?></span>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Autres services -->
<section class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-xl font-bold text-gray-900 mb-6 text-center">
            Nos autres services
        </h2>
        <div class="flex flex-wrap justify-center gap-3">
            <?php foreach ($autresModeles as $am): ?>
            <a href="/services/<?= $am['slug'] ?>/"
               class="inline-flex items-center px-4 py-2 bg-white border border-gray-200 rounded-full text-sm hover:border-primary-500 hover:text-primary-600 transition-colors">
                <span class="mr-2"><?= $am['emoji'] ?></span>
                <?= e($am['nom']) ?>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php include __DIR__ . '/../templates/footer.php'; ?>
