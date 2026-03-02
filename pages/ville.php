<?php
/**
 * Page Ville (Page Lead) - Annuaire Portes
 * URL: /{region}/{departement}/{ville-CP}/
 */

require_once __DIR__ . '/../functions.php';

// Récupération des paramètres
$regionSlug = $params['region'] ?? null;
$deptSlug = $params['departement'] ?? null;
$villeSlugCP = $params['ville'] ?? null;

// Extraction slug ville et code postal
preg_match('/^(.+)-(\d{5})$/', $villeSlugCP, $matches);
$villeSlug = $matches[1] ?? null;
$codePostal = $matches[2] ?? null;

if (!$regionSlug || !$deptSlug || !$villeSlug || !$codePostal) {
    http_response_code(404);
    include __DIR__ . '/../templates/404.php';
    exit;
}

// Chargement des données
$region = getRegionBySlug($regionSlug);
$villeData = getVille($villeSlug, $codePostal);

if (!$region || !$villeData) {
    http_response_code(404);
    include __DIR__ . '/../templates/404.php';
    exit;
}

$ville = $villeData['ville'];
$dept = $villeData['departement'];
$villesProches = $villeData['villes_proches'] ?? [];

// Redirection 301 si le CP dans l'URL ne correspond pas au CP réel
$realCP = $ville['code_postal'];
if ($codePostal !== $realCP) {
    $correctUrl = urlRelative($regionSlug . '/' . $deptSlug . '/' . $villeSlug . '-' . $realCP . '/');
    header('Location: ' . $correctUrl, true, 301);
    exit;
}

// Artisans de la ville
$deptCode = getDeptCodeFromPostal($codePostal);
$artisans = getArtisansVille($deptCode, $villeSlug);

// SEO
$pageTitle = seoTitle(METIER_TITLE . ' ' . $ville['nom_standard'] . ' ' . $codePostal . ' : Devis Gratuit ' . date('Y'));
$pageDescription = seoDescription(METIER_TITLE . ' à ' . $ville['nom_standard'] . ' : ' . count($artisans) . ' professionnels qualifiés. Devis gratuit ' . $codePostal . '.');
$canonical = urlVille($regionSlug, $deptSlug, $villeSlug, $codePostal);

// Breadcrumbs
$breadcrumbs = [
    ['name' => 'Accueil', 'url' => SITE_URL],
    ['name' => $region['nom'], 'url' => urlRegion($regionSlug)],
    ['name' => $dept['nom'], 'url' => urlDepartement($regionSlug, $deptSlug)],
    ['name' => $ville['nom_standard'], 'url' => $canonical]
];

// FAQ ville
$faqVille = [
    [
        'question' => 'Quel est le budget pour un projet à ' . $ville['nom_standard'] . ' ?',
        'reponse' => 'Le prix varie selon le type de prestation et les spécificités de votre projet à ' . $ville['nom_standard'] . '. Demandez plusieurs devis à nos ' . METIER_PLURAL . ' pour comparer les tarifs.'
    ],
    [
        'question' => 'Combien de temps durent les travaux ?',
        'reponse' => 'Le délai dépend de la nature et de l\'ampleur de votre projet à ' . $ville['nom_standard'] . '. Nos ' . METIER_PLURAL . ' vous fourniront un planning précis lors du devis.'
    ],
    [
        'question' => 'Le devis est-il gratuit ?',
        'reponse' => 'Oui, la demande de devis est 100% gratuite et sans engagement. Vous recevrez jusqu\'à 3 propositions de ' . METIER_PLURAL . ' qualifiés à ' . $ville['nom_standard'] . '.'
    ],
    [
        'question' => 'Quand commencer les travaux à ' . $ville['nom_standard'] . ' ?',
        'reponse' => 'Le meilleur moment dépend de la nature de votre projet. Nos ' . METIER_PLURAL . ' à ' . $ville['nom_standard'] . ' vous conseilleront sur la période idéale pour vos travaux.'
    ],
    [
        'question' => 'Les ' . METIER_PLURAL . ' sont-ils assurés ?',
        'reponse' => 'Oui, tous nos ' . METIER_PLURAL . ' partenaires disposent des assurances obligatoires (décennale, RC Pro) pour garantir vos travaux.'
    ],
    [
        'question' => 'Faut-il un permis pour les travaux ?',
        'reponse' => 'Selon la nature et l\'ampleur des travaux, une déclaration préalable ou un permis de construire peut être nécessaire à ' . $ville['nom_standard'] . '. Votre ' . METIER . ' vous guidera dans les démarches administratives.'
    ]
];

// JSON-LD
$jsonLd = [
    jsonLdOrganization(),
    jsonLdBreadcrumb($breadcrumbs),
    jsonLdService($ville),
    jsonLdFAQ($faqVille)
];

include __DIR__ . '/../templates/header.php';
?>

<!-- Breadcrumb -->
<?php include __DIR__ . '/../components/breadcrumb.php'; ?>

<!-- Hero avec formulaire -->
<section class="relative py-12 lg:py-16 overflow-hidden">
    <!-- Image de fond -->
    <div class="absolute inset-0">
        <img src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?w=1920&q=80" alt="Installation de portes"
            class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-br from-primary-900/90 via-primary-800/85 to-primary-700/80"></div>
    </div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="lg:grid lg:grid-cols-2 lg:gap-12 items-start">
            <!-- Colonne gauche : Informations -->
            <div class="mb-8 lg:mb-0">
                <div class="flex items-center space-x-1 mb-4">
                    <div class="flex text-yellow-400">
                        <span>&#9733;</span><span>&#9733;</span><span>&#9733;</span><span>&#9733;</span><span>&#9733;</span>
                    </div>
                    <span class="text-white font-semibold ml-2">4.9/5</span>
                    <span class="text-white/70 text-sm">sur +150 projets à <?= e($ville['nom_standard']) ?></span>
                </div>

                <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-white mb-4">
                    <?= METIER_TITLE ?> à<br>
                    <span class="text-primary-200"><?= e($ville['nom_standard']) ?></span>
                </h1>

                <p class="text-lg text-white/90 mb-8">
                    Votre partenaire de confiance sur le code postal <?= e($codePostal) ?>
                </p>

                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 rounded-lg bg-white/20 flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold text-white">Devis Gratuit</p>
                                <p class="text-sm text-white/70">Sous 48 heures</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 rounded-lg bg-white/20 flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold text-white">Artisans Locaux</p>
                                <p class="text-sm text-white/70">Certifiés & Qualifiés</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Services disponibles -->
                <div class="mt-6">
                    <p class="text-sm text-white/70 mb-3">Nos services à <?= e($ville['nom_standard']) ?> :</p>
                    <div class="flex flex-wrap gap-2">
                        <?php foreach (array_slice(STYLES, 0, 5) as $s): ?>
                            <a href="<?= urlRelative($regionSlug . '/' . $deptSlug . '/' . $villeSlug . '-' . $codePostal . '/' . $s['slug'] . '/') ?>"
                                class="inline-flex items-center px-4 py-2 sm:px-5 sm:py-2.5 bg-white/10 backdrop-blur-sm border border-white/20 rounded-full text-sm sm:text-base text-white hover:bg-white/20 transition-colors">
                                <span class="mr-2 sm:mr-2.5 text-base sm:text-lg"><?= $s['emoji'] ?></span>
                                <?= e($s['nom']) ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
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
        <div class="lg:col-span-2 space-y-12">

            <!-- Liste des artisans -->
            <section id="artisans">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">
                    Les <?= METIER_PLURAL ?> recommandés à <?= e($ville['nom_standard']) ?>
                </h2>

                <?php if (!empty($artisans)): ?>
                    <div class="space-y-4">
                        <?php foreach (array_slice($artisans, 0, ARTISANS_PER_PAGE) as $artisan): ?>
                            <?php include __DIR__ . '/../components/card-artisan.php'; ?>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="bg-gray-50 rounded-xl p-8 text-center">
                        <span class="text-4xl block mb-4">&#128682;</span>
                        <p class="text-gray-600 mb-4">
                            Aucun <?= METIER ?> référencé à <?= e($ville['nom_standard']) ?> pour le moment.
                        </p>
                        <a href="<?= getVudUrl() ?>" target="_blank" rel="noopener nofollow"
                            class="text-primary-600 font-semibold hover:underline">
                            Demandez un devis pour être mis en relation &rarr;
                        </a>
                    </div>
                <?php endif; ?>
            </section>

            <!-- Services -->
            <section>
                <h3 class="text-xl font-bold text-gray-900 mb-6">
                    Nos services à <?= e($ville['nom_standard']) ?>
                </h3>
                <div class="grid sm:grid-cols-2 gap-4">
                    <div class="bg-white rounded-xl border border-gray-200 p-6 flex items-start space-x-4">
                        <div class="w-12 h-12 rounded-xl bg-primary-100 flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900">Réalisation</h4>
                            <p class="text-sm text-gray-600">Conception et réalisation de votre projet sur mesure.</p>
                        </div>
                    </div>
                    <div class="bg-white rounded-xl border border-gray-200 p-6 flex items-start space-x-4">
                        <div class="w-12 h-12 rounded-xl bg-primary-100 flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900">Entretien</h4>
                            <p class="text-sm text-gray-600">Maintenance et suivi de votre installation.</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Zone d'intervention (carte) -->
            <section>
                <h3 class="text-xl font-bold text-gray-900 mb-6">
                    Zone d'intervention : <?= e($ville['nom_standard']) ?>
                </h3>
                <div class="bg-gray-100 rounded-xl overflow-hidden h-64 flex items-center justify-center">
                    <?php if (!empty($ville['latitude']) && !empty($ville['longitude'])): ?>
                        <iframe width="100%" height="100%" frameborder="0" style="border:0" loading="lazy" allowfullscreen
                            referrerpolicy="no-referrer-when-downgrade"
                            src="https://maps.google.com/maps?q=<?= $ville['latitude'] ?>,<?= $ville['longitude'] ?>&z=13&output=embed"
                            class="rounded-xl">
                        </iframe>
                    <?php else: ?>
                        <iframe width="100%" height="100%" frameborder="0" style="border:0" loading="lazy" allowfullscreen
                            referrerpolicy="no-referrer-when-downgrade"
                            src="https://maps.google.com/maps?q=<?= urlencode($ville['nom_standard'] . ', France') ?>&z=13&output=embed"
                            class="rounded-xl">
                        </iframe>
                    <?php endif; ?>
                </div>
            </section>

            <!-- Modèles / Services -->
            <section>
                <h3 class="text-xl font-bold text-gray-900 mb-4">
                    Nos services à <?= e($ville['nom_standard']) ?>
                </h3>
                <p class="text-gray-600 mb-6">
                    Découvrez nos solutions personnalisées. Nos partenaires locaux vous accompagnent pour donner vie à
                    votre projet.
                </p>
                <div class="flex flex-wrap gap-2">
                    <?php foreach (MODELES as $modele): ?>
                        <a href="<?= urlRelative($regionSlug . '/' . $deptSlug . '/' . $villeSlug . '-' . $codePostal . '/' . $modele['slug'] . '/') ?>"
                            class="inline-flex items-center px-3 py-2 bg-white border border-gray-200 rounded-lg text-sm hover:border-primary-500 hover:text-primary-600 transition-colors">
                            <span class="mr-2"><?= $modele['emoji'] ?></span>
                            <?= e($modele['nom']) ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </section>

            <!-- Section expert -->
            <section>
                <h2 class="text-2xl font-bold text-gray-900 mb-6">
                    Votre <?= METIER ?> expert à <?= e($ville['nom_standard']) ?> (<?= e($codePostal) ?>)
                </h2>

                <div class="prose prose-gray max-w-none mb-8">
                    <p>
                        Besoin d'un devis à <strong><?= e($ville['nom_standard']) ?></strong> ?
                        Nos partenaires interviennent rapidement pour l'étude de votre projet et sa réalisation selon
                        vos besoins.
                    </p>
                </div>

                <!-- Pourquoi choisir -->
                <div class="bg-white rounded-xl border border-gray-200 p-6 mb-8">
                    <h3 class="font-bold text-gray-900 mb-4">Pourquoi choisir nos partenaires à
                        <?= e($ville['nom_standard']) ?> ?
                    </h3>
                    <ul class="space-y-3">
                        <li class="flex items-center">
                            <span class="text-green-500 mr-3">&#9989;</span>
                            <span>Garantie décennale incluse</span>
                        </li>
                        <li class="flex items-center">
                            <span class="mr-3">&#128205;</span>
                            <span>Artisans locaux vérifiés</span>
                        </li>
                        <li class="flex items-center">
                            <span class="mr-3">&#128182;</span>
                            <span>Prix justes et transparents</span>
                        </li>
                        <li class="flex items-center">
                            <span class="mr-3">&#9889;</span>
                            <span>Devis gratuit sous 48h</span>
                        </li>
                    </ul>
                </div>

                <!-- Étapes du projet -->
                <h3 class="font-bold text-gray-900 mb-4">Les étapes de votre projet à <?= e($ville['nom_standard']) ?>
                </h3>
                <div class="grid sm:grid-cols-3 gap-4 mb-8">
                    <div class="bg-white rounded-xl border border-gray-200 p-6 text-center">
                        <div
                            class="w-10 h-10 rounded-full bg-primary-600 text-white flex items-center justify-center font-bold mx-auto mb-3">
                            01</div>
                        <h4 class="font-bold text-gray-900 mb-2">Conception</h4>
                        <p class="text-sm text-gray-600">Étude et planification adaptées à
                            <?= e($ville['nom_standard']) ?>.
                        </p>
                    </div>
                    <div class="bg-white rounded-xl border border-gray-200 p-6 text-center">
                        <div
                            class="w-10 h-10 rounded-full bg-primary-600 text-white flex items-center justify-center font-bold mx-auto mb-3">
                            02</div>
                        <h4 class="font-bold text-gray-900 mb-2">Réalisation</h4>
                        <p class="text-sm text-gray-600">Intervention par des équipes qualifiées.</p>
                    </div>
                    <div class="bg-white rounded-xl border border-gray-200 p-6 text-center">
                        <div
                            class="w-10 h-10 rounded-full bg-primary-600 text-white flex items-center justify-center font-bold mx-auto mb-3">
                            03</div>
                        <h4 class="font-bold text-gray-900 mb-2">Livraison</h4>
                        <p class="text-sm text-gray-600">Finalisation et conseils pour profiter de votre projet.</p>
                    </div>
                </div>
            </section>

            <!-- FAQ -->
            <section>
                <h3 class="text-xl font-bold text-gray-900 mb-6">Questions Fréquentes (FAQ)</h3>
                <?php $faqItems = $faqVille; ?>
                <?php include __DIR__ . '/../components/faq.php'; ?>
            </section>

            <!-- Villes proches -->
            <?php if (!empty($villesProches)): ?>
                <section>
                    <h3 class="text-xl font-bold text-gray-900 mb-6">
                        <?= ucfirst(METIER_PLURAL) ?> à proximité de <?= e($ville['nom_standard']) ?>
                    </h3>
                    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3">
                        <?php foreach (array_slice($villesProches, 0, NEARBY_CITIES_COUNT) as $vp): ?>
                            <?php
                            $vpSlugs = getRegionDeptSlugs($vp['code_postal']);
                            $vpRegion = $vpSlugs ? $vpSlugs['regionSlug'] : $regionSlug;
                            $vpDept = $vpSlugs ? $vpSlugs['deptSlug'] : $deptSlug;
                            ?>
                            <a href="<?= urlRelative($vpRegion . '/' . $vpDept . '/' . $vp['slug_ville'] . '-' . $vp['code_postal'] . '/') ?>"
                                class="bg-white rounded-lg border border-gray-200 p-3 hover:border-primary-500 hover:shadow-md transition-all text-center">
                                <div
                                    class="w-8 h-8 rounded-full bg-primary-100 text-primary-600 flex items-center justify-center mx-auto mb-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    </svg>
                                </div>
                                <p class="text-sm font-medium text-gray-900 truncate"><?= METIER_TITLE ?>
                                    <?= e($vp['nom_standard']) ?>
                                </p>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </section>
            <?php endif; ?>
        </div>

        <!-- Sidebar -->
        <aside class="lg:col-span-1 space-y-8 mt-12 lg:mt-0">
            <!-- CTA Sidebar sticky -->
            <div class="lg:sticky lg:top-24">
                <?php include __DIR__ . '/../components/sidebar-cta.php'; ?>

                <!-- Info ville -->
                <div class="bg-white rounded-xl border border-gray-200 p-6 mt-8">
                    <h3 class="font-bold text-gray-900 mb-4">
                        <?= e($ville['nom_standard']) ?> en bref
                    </h3>
                    <ul class="space-y-3 text-sm">
                        <li class="flex justify-between">
                            <span class="text-gray-500">Code postal</span>
                            <span class="font-medium text-gray-900"><?= e($codePostal) ?></span>
                        </li>
                        <li class="flex justify-between">
                            <span class="text-gray-500">Département</span>
                            <span class="font-medium text-gray-900"><?= e($dept['nom']) ?></span>
                        </li>
                        <li class="flex justify-between">
                            <span class="text-gray-500">Région</span>
                            <span class="font-medium text-gray-900"><?= e($region['nom']) ?></span>
                        </li>
                        <?php if (!empty($ville['population'])): ?>
                            <li class="flex justify-between">
                                <span class="text-gray-500">Population</span>
                                <span
                                    class="font-medium text-gray-900"><?= number_format($ville['population'], 0, ',', ' ') ?>
                                    hab.</span>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </aside>
    </div>
</div>

<?php include __DIR__ . '/../templates/footer.php'; ?>