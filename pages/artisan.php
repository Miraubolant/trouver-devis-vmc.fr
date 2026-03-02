<?php
/**
 * Fiche Artisan - Annuaire Portes
 * URL: /{region}/{departement}/{ville-CP}/artisans/{slug}/
 */

require_once __DIR__ . '/../functions.php';

// Récupération des paramètres
$regionSlug = $params['region'] ?? null;
$deptSlug = $params['departement'] ?? null;
$villeSlugCP = $params['ville'] ?? null;
$artisanSlug = $params['artisan'] ?? null;

// Extraction slug ville et code postal
preg_match('/^(.+)-(\d{5})$/', $villeSlugCP, $matches);
$villeSlug = $matches[1] ?? null;
$codePostal = $matches[2] ?? null;

if (!$regionSlug || !$deptSlug || !$villeSlug || !$codePostal || !$artisanSlug) {
    http_response_code(404);
    include __DIR__ . '/../templates/404.php';
    exit;
}

// Chargement des données
$region = getRegionBySlug($regionSlug);
$villeData = getVille($villeSlug, $codePostal);
$deptCode = getDeptCodeFromPostal($codePostal);
$artisan = getArtisan($deptCode, $villeSlug, $artisanSlug);

if (!$region || !$villeData || !$artisan) {
    http_response_code(404);
    include __DIR__ . '/../templates/404.php';
    exit;
}

$ville = $villeData['ville'];
$dept = $villeData['departement'];

// Redirection 301 si le CP dans l'URL ne correspond pas au CP réel
$realCP = $ville['code_postal'];
if ($codePostal !== $realCP) {
    $correctUrl = urlRelative($regionSlug . '/' . $deptSlug . '/' . $villeSlug . '-' . $realCP . '/artisans/' . $artisanSlug . '/');
    header('Location: ' . $correctUrl, true, 301);
    exit;
}

// Autres artisans de la ville
$autresArtisans = array_filter(
    getArtisansVille($deptCode, $villeSlug),
    fn($a) => $a['slug'] !== $artisanSlug
);

// SEO
$pageTitle = seoTitle($artisan['nom'] . ' - ' . METIER_TITLE . ' à ' . $ville['nom_standard']);
$pageDescription = seoDescription($artisan['nom'] . ', ' . METIER . ' à ' . $ville['nom_standard'] . ' (' . $codePostal . '). ' . ($artisan['note'] ? 'Note : ' . $artisan['note'] . '/5. ' : '') . 'Contactez ce professionnel pour votre projet.');
$canonical = urlArtisan($regionSlug, $deptSlug, $villeSlug, $codePostal, $artisanSlug);

// Breadcrumbs
$breadcrumbs = [
    ['name' => 'Accueil', 'url' => SITE_URL],
    ['name' => $region['nom'], 'url' => urlRegion($regionSlug)],
    ['name' => $dept['nom'], 'url' => urlDepartement($regionSlug, $deptSlug)],
    ['name' => $ville['nom_standard'], 'url' => urlVille($regionSlug, $deptSlug, $villeSlug, $codePostal)],
    ['name' => $artisan['nom'], 'url' => $canonical]
];

// JSON-LD
$jsonLd = [
    jsonLdOrganization(),
    jsonLdBreadcrumb($breadcrumbs),
    jsonLdLocalBusiness($artisan, $ville)
];

include __DIR__ . '/../templates/header.php';
?>

<!-- Breadcrumb -->
<?php include __DIR__ . '/../components/breadcrumb.php'; ?>

<!-- Hero avec formulaire devis -->
<section class="relative py-12 lg:py-16 overflow-hidden">
    <!-- Image de fond -->
    <div class="absolute inset-0">
        <img src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?w=1920&q=80"
             alt="Installation de portes"
             class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-br from-primary-900/90 via-primary-800/85 to-primary-700/80"></div>
    </div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="lg:grid lg:grid-cols-2 lg:gap-12 items-start">
            <!-- Colonne gauche : Informations artisan -->
            <div class="mb-8 lg:mb-0">
                <?php if ($artisan['note'] && $artisan['avis']): ?>
                <div class="flex items-center space-x-1 mb-4">
                    <div class="flex text-yellow-400">
                        <?= renderStars($artisan['note']) ?>
                    </div>
                    <span class="text-white font-semibold ml-2"><?= number_format($artisan['note'], 1) ?>/5</span>
                    <span class="text-white/70 text-sm">(<?= $artisan['avis'] ?> avis)</span>
                </div>
                <?php endif; ?>

                <div class="flex items-start space-x-4 mb-6">
                    <div class="flex-shrink-0 w-16 h-16 rounded-2xl bg-white/20 backdrop-blur-sm flex items-center justify-center text-white text-3xl">
                        &#128682;
                    </div>
                    <div class="flex-1 min-w-0">
                        <h1 class="text-3xl md:text-4xl font-bold text-white mb-2">
                            <?= e($artisan['nom']) ?>
                        </h1>
                        <p class="text-lg text-white/90">
                            <?= METIER_TITLE ?> à <?= e($ville['nom_standard']) ?> (<?= e($codePostal) ?>)
                        </p>
                        <?php if ($artisan['type']): ?>
                        <span class="inline-flex items-center px-3 py-1 bg-white/20 backdrop-blur-sm text-white text-sm rounded-full mt-3">
                            <?= e($artisan['type']) ?>
                        </span>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 rounded-lg bg-white/20 flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold text-white">Devis Gratuit</p>
                                <p class="text-sm text-white/70">Sans engagement</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 rounded-lg bg-white/20 flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold text-white">Garantie Décennale</p>
                                <p class="text-sm text-white/70">Artisan certifié</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex flex-wrap gap-3">
                    <?php if ($artisan['telephone']): ?>
                    <a href="tel:<?= preg_replace('/[^0-9+]/', '', $artisan['telephone']) ?>"
                       class="inline-flex items-center px-6 py-3 bg-green-500 hover:bg-green-600 text-white font-semibold rounded-xl transition-colors shadow-lg">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                        <?= formatTelephone($artisan['telephone']) ?>
                    </a>
                    <?php endif; ?>
                    <a href="<?= getVudUrl() ?>"
                       target="_blank"
                       rel="noopener nofollow"
                       class="inline-flex items-center px-6 py-3 bg-primary-500 hover:bg-primary-600 text-white font-semibold rounded-xl transition-colors shadow-lg">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Devis Gratuit
                    </a>
                </div>
            </div>

            <!-- Colonne droite : Formulaire devis -->
            <div>
                <?php include __DIR__ . '/../components/hero-devis-form.php'; ?>
            </div>
        </div>
    </div>
</section>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="lg:grid lg:grid-cols-3 lg:gap-8">
        <!-- Main content -->
        <div class="lg:col-span-2 space-y-8">

            <!-- Informations -->
            <section class="bg-white rounded-xl border border-gray-200 p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-6">Informations</h2>

                <div class="space-y-4">
                    <?php if ($artisan['adresse']): ?>
                    <div class="flex items-start space-x-4">
                        <div class="flex-shrink-0 w-10 h-10 rounded-lg bg-gray-100 flex items-center justify-center">
                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Adresse</p>
                            <p class="font-medium text-gray-900"><?= e($artisan['adresse']) ?></p>
                        </div>
                    </div>
                    <?php endif; ?>

                    <?php if ($artisan['telephone']): ?>
                    <div class="flex items-start space-x-4">
                        <div class="flex-shrink-0 w-10 h-10 rounded-lg bg-gray-100 flex items-center justify-center">
                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Téléphone</p>
                            <a href="tel:<?= preg_replace('/[^0-9+]/', '', $artisan['telephone']) ?>"
                               class="font-medium text-primary-600 hover:text-primary-700">
                                <?= formatTelephone($artisan['telephone']) ?>
                            </a>
                        </div>
                    </div>
                    <?php endif; ?>

                    <div class="flex items-start space-x-4">
                        <div class="flex-shrink-0 w-10 h-10 rounded-lg bg-gray-100 flex items-center justify-center">
                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Zone d'intervention</p>
                            <p class="font-medium text-gray-900"><?= e($ville['nom_standard']) ?> et environs</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Services proposés -->
            <section class="bg-white rounded-xl border border-gray-200 p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-6">Services proposés</h2>

                <div class="grid sm:grid-cols-2 gap-4">
                    <?php foreach (SERVICES as $service): ?>
                    <div class="flex items-start space-x-3">
                        <div class="flex-shrink-0 w-8 h-8 rounded-lg bg-primary-100 text-primary-600 flex items-center justify-center">
                            <?= $service['icon'] ?>
                        </div>
                        <div>
                            <h3 class="font-medium text-gray-900"><?= e($service['titre']) ?></h3>
                            <p class="text-sm text-gray-600"><?= e($service['desc']) ?></p>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </section>

            <!-- Carte Google Maps -->
            <section class="bg-white rounded-xl border border-gray-200 p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Localisation</h2>
                <?php
                    $mapQuery = $artisan['adresse'] ? $artisan['adresse'] : $ville['nom_standard'] . ' ' . $codePostal;
                ?>
                <div class="rounded-lg overflow-hidden border border-gray-200">
                    <iframe
                        src="https://www.google.com/maps?q=<?= urlencode($mapQuery) ?>&output=embed"
                        width="100%"
                        height="350"
                        style="border:0;"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                        title="Localisation de <?= e($artisan['nom']) ?> à <?= e($ville['nom_standard']) ?>">
                    </iframe>
                </div>
                <?php if ($artisan['adresse']): ?>
                <p class="mt-3 text-sm text-gray-600 flex items-center">
                    <svg class="w-4 h-4 mr-2 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                    </svg>
                    <?= e($artisan['adresse']) ?>
                </p>
                <?php endif; ?>
            </section>

            <!-- Garanties -->
            <section class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-6">Garanties</h2>

                <div class="grid sm:grid-cols-3 gap-4">
                    <div class="flex items-center space-x-3">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                        <span class="font-medium text-gray-900">Garantie décennale</span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="font-medium text-gray-900">Assurance RC Pro</span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span class="font-medium text-gray-900">Devis gratuit</span>
                    </div>
                </div>
            </section>

            <!-- Autres artisans -->
            <?php if (!empty($autresArtisans)): ?>
            <section>
                <h2 class="text-xl font-bold text-gray-900 mb-6">
                    Autres <?= METIER_PLURAL ?> à <?= e($ville['nom_standard']) ?>
                </h2>
                <div class="space-y-4">
                    <?php foreach (array_slice($autresArtisans, 0, 5) as $autre): ?>
                    <?php $artisan = $autre; ?>
                    <?php include __DIR__ . '/../components/card-artisan.php'; ?>
                    <?php endforeach; ?>
                </div>
            </section>
            <?php endif; ?>
        </div>

        <!-- Sidebar -->
        <aside class="lg:col-span-1 space-y-8 mt-12 lg:mt-0">
            <div class="lg:sticky lg:top-24">
                <!-- CTA simplifié -->
                <div class="bg-gradient-to-br from-primary-600 to-primary-800 rounded-2xl p-6 shadow-xl text-center">
                    <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">Besoin d'un devis ?</h3>
                    <p class="text-primary-100 text-sm mb-4">
                        Comparez les offres des meilleurs <?= METIER_PLURAL ?> de <?= e($ville['nom_standard']) ?>
                    </p>
                    <a href="<?= getVudUrl() ?>"
                       target="_blank"
                       rel="noopener nofollow"
                       class="block w-full bg-white text-primary-600 font-semibold py-3 px-4 rounded-lg hover:bg-gray-100 transition-colors">
                        Demander mes devis gratuits
                    </a>
                    <div class="mt-4 flex justify-center gap-4 text-xs text-primary-100">
                        <span class="flex items-center"><svg class="w-4 h-4 mr-1 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>Gratuit</span>
                        <span class="flex items-center"><svg class="w-4 h-4 mr-1 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>Sans engagement</span>
                    </div>
                </div>

                <!-- Retour ville -->
                <div class="mt-8">
                    <a href="<?= urlVille($regionSlug, $deptSlug, $villeSlug, $codePostal) ?>"
                       class="flex items-center justify-center space-x-2 text-primary-600 hover:text-primary-700 font-medium">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                        <span>Tous les <?= METIER_PLURAL ?> à <?= e($ville['nom_standard']) ?></span>
                    </a>
                </div>
            </div>
        </aside>
    </div>
</div>

<?php include __DIR__ . '/../templates/footer.php'; ?>
