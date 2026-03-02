<?php
/**
 * Page Département - Annuaire Portes
 * URL: /{region}/{departement}/
 */

require_once __DIR__ . '/../functions.php';

// Récupération des paramètres depuis l'URL
$regionSlug = $params['region'] ?? null;
$deptSlug = $params['departement'] ?? null;

if (!$regionSlug || !$deptSlug) {
    http_response_code(404);
    include __DIR__ . '/../templates/404.php';
    exit;
}

// Chargement des données
$region = getRegionBySlug($regionSlug);
$deptData = getDepartementBySlug($regionSlug, $deptSlug);

if (!$region || !$deptData) {
    http_response_code(404);
    include __DIR__ . '/../templates/404.php';
    exit;
}

$dept = $deptData['departement'];
$villes = $deptData['villes'] ?? [];
$voisins = $deptData['voisins'] ?? [];

// Contenu unique anti-duplicate
$deptContent = getDeptIntroContent($dept, $region['nom'], count($villes));

// SEO
$pageTitle = seoTitle(METIER_TITLE . ' ' . $dept['nom'] . ' (' . $dept['code'] . ') - Experts');
$pageDescription = seoDescription('Trouvez un ' . METIER . ' dans le ' . $dept['nom'] . ' (' . $dept['code'] . '). ' . count($villes) . ' villes couvertes. Devis gratuit et sans engagement.');
$canonical = urlDepartement($regionSlug, $deptSlug);

// Breadcrumbs
$breadcrumbs = [
    ['name' => 'Accueil', 'url' => SITE_URL],
    ['name' => 'Régions', 'url' => SITE_URL . '/#regions'],
    ['name' => $region['nom'], 'url' => urlRegion($regionSlug)],
    ['name' => $dept['nom'], 'url' => $canonical]
];

// JSON-LD
$jsonLd = [
    jsonLdOrganization(),
    jsonLdBreadcrumb($breadcrumbs)
];

include __DIR__ . '/../templates/header.php';
?>

<!-- Breadcrumb -->
<?php include __DIR__ . '/../components/breadcrumb.php'; ?>

<!-- Hero avec image de fond -->
<section class="relative py-16 lg:py-20 overflow-hidden">
    <!-- Image de fond -->
    <div class="absolute inset-0">
        <img src="https://images.unsplash.com/photo-1505693416388-ac5ce068fe85?w=1920&q=80"
             alt="Installation de portes"
             class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-br from-primary-900/90 via-primary-800/85 to-primary-700/80"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-4">
            <?= METIER_TITLE ?> <?= e($dept['nom']) ?><br>
            <span class="text-primary-300">(<?= e($dept['code']) ?>)</span>
        </h1>
        <p class="text-xl text-white/90 mb-8 max-w-2xl mx-auto">
            <?= $deptContent['heroSubtitle'] ?>
        </p>

        <!-- Search box -->
        <div class="max-w-xl mx-auto">
            <?php $searchPlaceholder = "Entrez votre ville ou code postal (ex: 33000)..."; ?>
            <?php include __DIR__ . '/../components/search-autocomplete.php'; ?>
        </div>
    </div>
</section>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="lg:grid lg:grid-cols-3 lg:gap-8">
        <!-- Main content -->
        <div class="lg:col-span-2">
            <!-- Introduction -->
            <section class="mb-10">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">
                    <?= $deptContent['title'] ?>
                </h2>
                <p class="text-gray-600 leading-relaxed">
                    <?= $deptContent['paragraph'] ?>
                </p>
            </section>

            <!-- Services / Modèles -->
            <section class="mb-12">
                <h2 class="text-xl font-bold text-gray-900 mb-6">
                    Nos services dans le <?= e($dept['nom']) ?>
                </h2>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                    <?php foreach (MODELES as $m): ?>
                    <a href="<?= urlRelative($regionSlug . '/' . $deptSlug . '/' . ($villes[0]['slug_ville'] ?? '') . '-' . ($villes[0]['code_postal'] ?? '') . '/' . $m['slug'] . '/') ?>"
                       class="group flex items-center space-x-3 bg-white rounded-lg border border-gray-200 p-4 hover:border-primary-500 hover:shadow-md transition-all">
                        <span class="text-2xl"><?= $m['emoji'] ?></span>
                        <span class="text-sm font-medium text-gray-700 group-hover:text-primary-600 transition-colors">
                            <?= e($m['nom']) ?>
                        </span>
                    </a>
                    <?php endforeach; ?>
                </div>
            </section>

            <!-- Liste des villes -->
            <section class="mb-12">
                <h2 class="text-xl font-bold text-gray-900 mb-6">
                    Villes du département <?= e($dept['nom']) ?>
                </h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-x-6 gap-y-2">
                    <?php foreach ($villes as $villeItem): ?>
                    <a href="<?= urlRelative($regionSlug . '/' . $deptSlug . '/' . $villeItem['slug_ville'] . '-' . $villeItem['code_postal'] . '/') ?>"
                       class="flex items-center py-2 text-gray-700 hover:text-primary-600 transition-colors group">
                        <span class="w-2 h-2 rounded-full bg-primary-400 mr-3 group-hover:bg-primary-600"></span>
                        <span class="flex-1">
                            <?= METIER_TITLE ?> <?= e($villeItem['nom_standard']) ?>
                        </span>
                        <span class="text-sm text-gray-400 ml-2">
                            <?= e($villeItem['code_postal']) ?>
                        </span>
                    </a>
                    <?php endforeach; ?>
                </div>
            </section>

            <!-- Départements voisins -->
            <?php if (!empty($voisins)): ?>
            <section class="mb-12">
                <h2 class="text-xl font-bold text-gray-900 mb-4">
                    Départements voisins
                </h2>
                <div class="flex flex-wrap gap-2">
                    <?php foreach (array_slice($voisins, 0, NEARBY_DEPARTMENTS_COUNT) as $voisin): ?>
                    <a href="<?= urlRelative($regionSlug . '/' . $voisin['dep_slug'] . '/') ?>"
                       class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-primary-100 hover:text-primary-700 text-gray-700 rounded-full text-sm transition-colors">
                        <span class="font-medium mr-1"><?= e($voisin['dep_code']) ?></span>
                        <?= e($voisin['dep_nom']) ?>
                    </a>
                    <?php endforeach; ?>
                </div>
            </section>
            <?php endif; ?>
        </div>

        <!-- Sidebar -->
        <aside class="lg:col-span-1 mt-8 lg:mt-0">
            <div class="lg:sticky lg:top-24 space-y-6">
                <!-- Zone d'intervention -->
                <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Zone d'intervention</h3>
                    <p class="text-gray-600 text-sm mb-6">
                        Nos experts interviennent dans tout le département <strong><?= e($dept['nom']) ?></strong> pour vos projets.
                    </p>

                    <div class="text-center mb-6">
                        <span class="text-4xl font-bold text-primary-600">6j/7</span>
                        <p class="text-sm text-gray-500 uppercase tracking-wider">Conseils & Devis</p>
                    </div>

                    <a href="<?= getVudUrl() ?>"
                       target="_blank"
                       rel="noopener nofollow"
                       class="block w-full text-center bg-primary-600 hover:bg-primary-700 text-white font-bold py-4 px-6 rounded-xl transition-colors shadow-lg">
                        Demander mes devis
                    </a>

                    <a href="/"
                       class="block text-center text-gray-500 hover:text-primary-600 text-sm mt-4 transition-colors">
                        Retour à l'accueil
                    </a>
                </div>
            </div>
        </aside>
    </div>
</div>

<?php include __DIR__ . '/../templates/footer.php'; ?>
