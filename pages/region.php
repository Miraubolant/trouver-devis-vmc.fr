<?php
/**
 * Page Région - Annuaire Portes
 * URL: /{region}/
 */

require_once __DIR__ . '/../functions.php';

// Récupération du slug région depuis l'URL (défini par le routeur)
$regionSlug = $params['region'] ?? null;

if (!$regionSlug) {
    http_response_code(404);
    include __DIR__ . '/../templates/404.php';
    exit;
}

// Chargement des données
$region = getRegionBySlug($regionSlug);

if (!$region) {
    http_response_code(404);
    include __DIR__ . '/../templates/404.php';
    exit;
}

// SEO
$pageTitle = seoTitle(METIER_TITLE . ' en région ' . $region['nom']);
$pageDescription = seoDescription('Trouvez un ' . METIER . ' en région ' . $region['nom'] . '. ' . $region['departements_count'] . ' départements couverts. Devis gratuit pour votre projet.');
$canonical = urlRegion($regionSlug);

// Breadcrumbs
$breadcrumbs = [
    ['name' => 'Accueil', 'url' => SITE_URL],
    ['name' => 'Régions', 'url' => SITE_URL . '/#regions'],
    ['name' => $region['nom'], 'url' => $canonical]
];

// JSON-LD
$jsonLd = [
    jsonLdOrganization(),
    jsonLdBreadcrumb($breadcrumbs)
];

// Contenu unique anti-duplicate
$regionContent = getRegionIntroContent($region);

include __DIR__ . '/../templates/header.php';
?>

<!-- Breadcrumb -->
<?php include __DIR__ . '/../components/breadcrumb.php'; ?>

<!-- Hero -->
<section class="relative py-16 lg:py-20 overflow-hidden" style="min-height: 320px;">
    <!-- Image de fond -->
    <div class="absolute inset-0 z-0">
        <img src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?w=1920&q=80&auto=format"
             alt="Installation de portes"
             class="w-full h-full object-cover"
             loading="eager">
        <div class="absolute inset-0 bg-gradient-to-br from-primary-900/90 via-primary-800/85 to-primary-700/80"></div>
    </div>
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-4">
            <?= METIER_TITLE ?> en Région<br>
            <span class="text-primary-300"><?= e($region['nom']) ?></span>
        </h1>
        <p class="text-xl text-white/90 mb-8 max-w-2xl mx-auto">
            <?= $regionContent['heroSubtitle'] ?>
        </p>

        <!-- Search -->
        <div class="max-w-xl mx-auto">
            <?php $searchPlaceholder = "Entrez votre ville ou code postal (ex: 33000)..."; ?>
            <?php include __DIR__ . '/../components/search-autocomplete.php'; ?>
        </div>
    </div>
</section>

<!-- Liste des départements -->
<section class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900">
                <?= ucfirst(METIER_PLURAL) ?> par département
            </h2>
            <p class="text-gray-600 mt-2">
                Sélectionnez un département pour trouver des <?= METIER_PLURAL ?> près de chez vous
            </p>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <?php foreach ($region['departements'] as $dept): ?>
                <?php include __DIR__ . '/../components/card-departement.php'; ?>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Sidebar CTA -->
<section class="py-12 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <?php include __DIR__ . '/../components/cta-devis.php'; ?>
    </div>
</section>

<!-- Info région -->
<section class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-2xl p-8 border border-gray-200">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">
                Trouver un <?= METIER ?> en <?= e($region['nom']) ?>
            </h2>
            <div class="prose prose-gray max-w-none">
                <p><?= $regionContent['intro'] ?></p>
                <p><?= $regionContent['detail'] ?></p>
                <h3><?= $regionContent['benefitsTitle'] ?></h3>
                <ul>
                    <?php foreach ($regionContent['benefits'] as $benefit): ?>
                    <li><?= $benefit ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- Autres régions -->
<section class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-xl font-bold text-gray-900 mb-6">
            Autres régions
        </h2>
        <div class="flex flex-wrap gap-2">
            <?php foreach (getRegions() as $r): ?>
                <?php if ($r['slug'] !== $regionSlug): ?>
                <a href="<?= urlRelative($r['slug'] . '/') ?>"
                   class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-primary-100 hover:text-primary-700 text-gray-700 rounded-full text-sm transition-colors">
                    <?= e($r['nom']) ?>
                </a>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php include __DIR__ . '/../templates/footer.php'; ?>
