<?php
/**
 * Fonctions utilitaires - Annuaire Portes
 */

require_once __DIR__ . '/config.php';

// ============================================
// CHARGEMENT DES DONNEES JSON
// ============================================

/**
 * Charge et décode un fichier JSON
 */
function loadJson($filepath) {
    if (!file_exists($filepath)) {
        return null;
    }
    $content = file_get_contents($filepath);
    return json_decode($content, true);
}

/**
 * Charge toutes les régions
 */
function getRegions() {
    static $regions = null;
    if ($regions === null) {
        $regions = loadJson(REGIONS_FILE);
    }
    return $regions ?: [];
}

/**
 * Récupère une région par son slug
 */
function getRegionBySlug($slug) {
    $regions = getRegions();
    foreach ($regions as $region) {
        if ($region['slug'] === $slug) {
            return $region;
        }
    }
    return null;
}

/**
 * Charge les données d'un département
 */
function getDepartement($code) {
    $filepath = DATA_PATH . "departements/{$code}.json";
    return loadJson($filepath);
}

/**
 * Récupère un département par son slug dans une région
 */
function getDepartementBySlug($regionSlug, $deptSlug) {
    $region = getRegionBySlug($regionSlug);
    if (!$region) return null;

    foreach ($region['departements'] as $dept) {
        if ($dept['slug'] === $deptSlug) {
            return getDepartement($dept['code']);
        }
    }
    return null;
}

/**
 * Charge les données d'une ville
 */
function getVille($slug, $codePostal) {
    // Tentative exacte slug-CP
    $filepath = DATA_PATH . "villes/{$slug}-{$codePostal}.json";
    $data = loadJson($filepath);
    if ($data) return $data;

    // Fallback : chercher un fichier avec le même slug (CP différent)
    $pattern = DATA_PATH . "villes/{$slug}-*.json";
    $files = glob($pattern);
    if (!empty($files)) {
        return loadJson($files[0]);
    }

    return null;
}

/**
 * Récupère une ville depuis les données département
 */
function getVilleFromDepartement($deptCode, $villeSlug, $codePostal) {
    $deptData = getDepartement($deptCode);
    if (!$deptData) return null;

    foreach ($deptData['villes'] as $ville) {
        if ($ville['slug_ville'] === $villeSlug && $ville['code_postal'] === $codePostal) {
            return $ville;
        }
    }
    return null;
}

/**
 * Charge les artisans d'un département
 */
function getArtisansDepartement($code) {
    $filepath = DATA_PATH . "artisans/{$code}.json";
    return loadJson($filepath);
}

/**
 * Récupère les artisans d'une ville
 */
function getArtisansVille($deptCode, $villeSlug) {
    $artisans = getArtisansDepartement($deptCode);
    if (!$artisans || !isset($artisans[$villeSlug])) {
        return [];
    }
    $list = $artisans[$villeSlug]['artisans'] ?? [];

    // Filtrer les artisans dont l'adresse ne correspond pas au département
    return array_values(array_filter($list, function($a) use ($deptCode) {
        if (empty($a['adresse'])) return true;
        // Extraire le code postal de l'adresse
        if (preg_match('/\b(\d{5})\b/', $a['adresse'], $m)) {
            $cpArtisan = $m[1];
            $deptFromCp = getDeptCodeFromPostal($cpArtisan);
            return $deptFromCp === $deptCode;
        }
        return true; // Pas de CP trouvé, on garde
    }));
}

/**
 * Récupère un artisan spécifique par son slug
 */
function getArtisan($deptCode, $villeSlug, $artisanSlug) {
    $artisans = getArtisansVille($deptCode, $villeSlug);
    foreach ($artisans as $artisan) {
        if ($artisan['slug'] === $artisanSlug) {
            return $artisan;
        }
    }
    return null;
}

/**
 * Récupère les villes proches depuis le fichier ville
 */
function getVillesProches($villeSlug, $codePostal, $limit = NEARBY_CITIES_COUNT) {
    $villeData = getVille($villeSlug, $codePostal);
    if (!$villeData || !isset($villeData['villes_proches'])) {
        return [];
    }
    return array_slice($villeData['villes_proches'], 0, $limit);
}

/**
 * Récupère les départements voisins
 */
function getDepartementsVoisins($deptCode, $limit = NEARBY_DEPARTMENTS_COUNT) {
    $deptData = getDepartement($deptCode);
    if (!$deptData || !isset($deptData['voisins'])) {
        return [];
    }
    return array_slice($deptData['voisins'], 0, $limit);
}

// ============================================
// GENERATION D'URLs
// ============================================

/**
 * Génère l'URL d'une région
 */
function urlRegion($regionSlug) {
    return SITE_URL . "/{$regionSlug}/";
}

/**
 * Génère l'URL d'un département
 */
function urlDepartement($regionSlug, $deptSlug) {
    return SITE_URL . "/{$regionSlug}/{$deptSlug}/";
}

/**
 * Génère l'URL d'une ville
 */
function urlVille($regionSlug, $deptSlug, $villeSlug, $codePostal) {
    return SITE_URL . "/{$regionSlug}/{$deptSlug}/{$villeSlug}-{$codePostal}/";
}

/**
 * Génère l'URL d'un modèle de porte pour une ville
 */
function urlModele($regionSlug, $deptSlug, $villeSlug, $codePostal, $modeleSlug) {
    return SITE_URL . "/{$regionSlug}/{$deptSlug}/{$villeSlug}-{$codePostal}/{$modeleSlug}/";
}

/**
 * Génère l'URL d'un artisan
 */
function urlArtisan($regionSlug, $deptSlug, $villeSlug, $codePostal, $artisanSlug) {
    return SITE_URL . "/{$regionSlug}/{$deptSlug}/{$villeSlug}-{$codePostal}/artisans/{$artisanSlug}/";
}

/**
 * Génère l'URL relative (sans domaine)
 */
function urlRelative($path) {
    return '/' . ltrim($path, '/');
}

// ============================================
// SEO - META TAGS & JSON-LD
// ============================================

/**
 * Génère le titre SEO de la page
 */
function seoTitle($title) {
    return htmlspecialchars($title) . ' | ' . SITE_NAME;
}

/**
 * Génère la meta description
 */
function seoDescription($desc, $maxLength = 160) {
    $desc = strip_tags($desc);
    if (strlen($desc) > $maxLength) {
        $desc = substr($desc, 0, $maxLength - 3) . '...';
    }
    return htmlspecialchars($desc);
}

/**
 * Génère le JSON-LD Organization
 */
function jsonLdOrganization() {
    return json_encode([
        '@context' => 'https://schema.org',
        '@type' => 'Organization',
        'name' => SITE_NAME,
        'url' => SITE_URL,
        'logo' => SITE_URL . '/assets/img/logo.png',
        'description' => SITE_DESCRIPTION,
        'areaServed' => [
            '@type' => 'Country',
            'name' => 'France'
        ]
    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
}

/**
 * Génère le JSON-LD FAQPage
 */
function jsonLdFAQ($questions) {
    $mainEntity = [];
    foreach ($questions as $q) {
        $mainEntity[] = [
            '@type' => 'Question',
            'name' => $q['question'],
            'acceptedAnswer' => [
                '@type' => 'Answer',
                'text' => $q['reponse']
            ]
        ];
    }

    return json_encode([
        '@context' => 'https://schema.org',
        '@type' => 'FAQPage',
        'mainEntity' => $mainEntity
    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
}

/**
 * Génère le JSON-LD LocalBusiness pour un artisan
 */
function jsonLdLocalBusiness($artisan, $ville) {
    $data = [
        '@context' => 'https://schema.org',
        '@type' => 'LocalBusiness',
        'name' => $artisan['nom'],
        'description' => METIER_TITLE . ' à ' . $ville['nom_standard'],
        'address' => [
            '@type' => 'PostalAddress',
            'addressLocality' => $ville['nom_standard'],
            'postalCode' => $ville['code_postal'],
            'addressCountry' => 'FR'
        ]
    ];

    if (!empty($artisan['telephone'])) {
        $data['telephone'] = $artisan['telephone'];
    }

    if (!empty($artisan['note']) && !empty($artisan['avis'])) {
        $data['aggregateRating'] = [
            '@type' => 'AggregateRating',
            'ratingValue' => $artisan['note'],
            'reviewCount' => $artisan['avis']
        ];
    }

    return json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
}

/**
 * Génère le JSON-LD BreadcrumbList
 */
function jsonLdBreadcrumb($items) {
    $listItems = [];
    foreach ($items as $i => $item) {
        $listItems[] = [
            '@type' => 'ListItem',
            'position' => $i + 1,
            'name' => $item['name'],
            'item' => $item['url']
        ];
    }

    return json_encode([
        '@context' => 'https://schema.org',
        '@type' => 'BreadcrumbList',
        'itemListElement' => $listItems
    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
}

/**
 * Génère le JSON-LD Service
 */
function jsonLdService($ville, $modele = null) {
    $serviceName = $modele
        ? $modele['nom'] . ' à ' . $ville['nom_standard']
        : METIER_TITLE . ' à ' . $ville['nom_standard'];

    return json_encode([
        '@context' => 'https://schema.org',
        '@type' => 'Service',
        'serviceType' => $modele ? $modele['nom'] : 'Installation et pose de portes',
        'name' => $serviceName,
        'provider' => [
            '@type' => 'Organization',
            'name' => SITE_NAME
        ],
        'areaServed' => [
            '@type' => 'City',
            'name' => $ville['nom_standard'],
            'postalCode' => $ville['code_postal']
        ]
    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
}

// ============================================
// HELPERS DIVERS
// ============================================

/**
 * Formate un numéro de téléphone français
 */
function formatTelephone($tel) {
    if (empty($tel)) return '';
    // Nettoie le numéro
    $tel = preg_replace('/[^0-9+]/', '', $tel);
    // Formate en XX XX XX XX XX
    if (strlen($tel) === 10) {
        return implode(' ', str_split($tel, 2));
    }
    return $tel;
}

/**
 * Génère les étoiles de notation
 */
function renderStars($note, $maxStars = 5) {
    $note = floatval($note);
    $fullStars = floor($note);
    $halfStar = ($note - $fullStars) >= 0.5;
    $emptyStars = $maxStars - $fullStars - ($halfStar ? 1 : 0);

    $html = '';
    for ($i = 0; $i < $fullStars; $i++) {
        $html .= '<span class="text-yellow-400">&#9733;</span>';
    }
    if ($halfStar) {
        $html .= '<span class="text-yellow-400">&#9734;</span>';
    }
    for ($i = 0; $i < $emptyStars; $i++) {
        $html .= '<span class="text-gray-300">&#9734;</span>';
    }
    return $html;
}

/**
 * Génère le slug d'une chaîne
 */
function slugify($string) {
    $string = transliterator_transliterate('Any-Latin; Latin-ASCII; Lower()', $string);
    $string = preg_replace('/[^a-z0-9]+/', '-', $string);
    return trim($string, '-');
}

/**
 * Pagination helper
 */
function paginate($items, $page, $perPage = ITEMS_PER_PAGE) {
    $total = count($items);
    $totalPages = ceil($total / $perPage);
    $page = max(1, min($page, $totalPages));
    $offset = ($page - 1) * $perPage;

    return [
        'items' => array_slice($items, $offset, $perPage),
        'current' => $page,
        'total' => $totalPages,
        'count' => $total,
        'hasNext' => $page < $totalPages,
        'hasPrev' => $page > 1
    ];
}

/**
 * Génère l'URL ViteUnDevis avec iframe
 */
function vudIframeUrl($ville = null, $codePostal = null, $modele = null) {
    $params = [
        'part' => VUD_PARTENAIRE_ID,
        'cat' => getVudCatForModele($modele),
    ];

    if ($codePostal) {
        $params['cp'] = $codePostal;
    }

    return VUD_IFRAME_URL . '?' . http_build_query($params);
}

/**
 * Génère le HTML de l'iframe ViteUnDevis
 */
function vudIframe($ville = null, $codePostal = null, $height = 600) {
    $url = vudIframeUrl($ville, $codePostal);
    return '<iframe src="' . htmlspecialchars($url) . '" width="100%" height="' . $height . '" frameborder="0" scrolling="auto" class="w-full rounded-lg shadow-lg"></iframe>';
}

/**
 * Extrait le code département du code postal
 */
function getRegionDeptSlugs($codePostal) {
    static $cache = [];
    $deptCode = getDeptCodeFromPostal($codePostal);
    if (!$deptCode) return null;
    if (isset($cache[$deptCode])) return $cache[$deptCode];

    $regions = getRegions();
    foreach ($regions as $region) {
        foreach ($region['departements'] as $dept) {
            if ($dept['code'] === $deptCode) {
                $cache[$deptCode] = [
                    'regionSlug' => $region['slug'],
                    'deptSlug' => $dept['slug']
                ];
                return $cache[$deptCode];
            }
        }
    }
    return null;
}

/**
 * Extrait le code département du code postal
 */
function getDeptCodeFromPostal($codePostal) {
    if (strlen($codePostal) === 5) {
        $prefix = substr($codePostal, 0, 2);
        // Gestion Corse
        if ($prefix === '20') {
            $next = substr($codePostal, 0, 3);
            return ($next >= '201' && $next <= '209') ? '2A' : '2B';
        }
        // DOM-TOM
        if ($prefix === '97') {
            return substr($codePostal, 0, 3);
        }
        return $prefix;
    }
    return null;
}

/**
 * Compte le nombre total d'artisans dans un département
 */
function countArtisansDepartement($deptCode) {
    $artisans = getArtisansDepartement($deptCode);
    if (!$artisans) return 0;

    $count = 0;
    foreach ($artisans as $villeArtisans) {
        $count += count($villeArtisans['artisans'] ?? []);
    }
    return $count;
}

/**
 * Sécurise les sorties HTML
 */
function e($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

/**
 * Génère un ID unique pour Alpine.js
 */
function uniqueId($prefix = 'el') {
    static $counter = 0;
    return $prefix . '_' . (++$counter);
}

/**
 * Vérifie si on est sur mobile (approximatif)
 */
function isMobile() {
    return isset($_SERVER['HTTP_USER_AGENT']) &&
           preg_match('/Mobile|Android|iPhone|iPad/', $_SERVER['HTTP_USER_AGENT']);
}

// ============================================
// CONTENU UNIQUE PAR PAGE (anti-duplicate)
// ============================================

/**
 * Génère un contenu d'introduction unique pour chaque page région
 */
function getRegionIntroContent($region) {
    $nom = e($region['nom']);
    $count = $region['departements_count'];
    $metier = METIER;
    $metierPlural = METIER_PLURAL;

    $deptNames = [];
    foreach (array_slice($region['departements'], 0, 3) as $d) {
        $deptNames[] = e($d['nom']);
    }
    $dept1 = $deptNames[0] ?? '';
    $dept2 = $deptNames[1] ?? $dept1;
    $dept3 = $deptNames[2] ?? $dept2;

    $modeles = MODELES;
    $m1 = mb_strtolower($modeles[0]['nom']);
    $m2 = mb_strtolower($modeles[1]['nom']);
    $m3 = mb_strtolower($modeles[2]['nom']);
    $m4 = mb_strtolower($modeles[3]['nom'] ?? $modeles[0]['nom']);

    $hash = abs(crc32($region['slug']));

    $heroSubtitles = [
        "Trouvez les meilleurs $metierPlural en $nom. Devis gratuits et experts locaux.",
        "Comparez les $metierPlural certifiés en $nom. Service gratuit et sans engagement.",
        "$count départements couverts en $nom. Demandez vos devis gratuits.",
        "Des $metierPlural de confiance dans toute la région $nom.",
        "Experts en portes disponibles dans les $count départements de $nom.",
    ];

    $intros = [
        "La région <strong>$nom</strong> regroupe $count départements où nos $metierPlural partenaires assurent l'installation et la pose de tous types de portes. Que vous résidiez dans le $dept1, le $dept2 ou le $dept3, des artisans qualifiés sont disponibles pour concrétiser votre projet.",
        "Avec ses $count départements, <strong>$nom</strong> bénéficie d'un maillage dense de $metierPlural certifiés. Du $dept1 au $dept3, en passant par le $dept2, chaque territoire dispose de professionnels expérimentés dans la pose de portes.",
        "En <strong>$nom</strong>, notre réseau couvre l'intégralité des $count départements de la région. Que votre chantier se situe dans le $dept1, le $dept2 ou le $dept3, nos $metierPlural partenaires se déplacent rapidement pour vos travaux.",
        "Notre annuaire référence des $metierPlural dans les $count départements de la région <strong>$nom</strong>. Les professionnels intervenant dans le $dept1, le $dept2 ou encore le $dept3 sont tous sélectionnés pour leur savoir-faire et leur fiabilité.",
        "Trouver un $metier compétent en <strong>$nom</strong> n'a jamais été aussi simple. Nos partenaires, répartis sur les $count départements de la région — du $dept1 au $dept3 — garantissent un service de proximité et des délais maîtrisés.",
    ];

    $details = [
        "De la $m1 à la $m2, en passant par la $m3, nos artisans maîtrisent l'ensemble des techniques d'installation. Chaque intervention comprend le conseil, la prise de mesures, la dépose de l'ancienne porte et la pose soignée de votre nouveau modèle.",
        "Nos $metierPlural en $nom sont spécialisés dans la pose de $m1, $m2 et $m3. Ils assurent également le remplacement d'anciennes menuiseries et le blindage de portes existantes, avec des matériaux adaptés au climat local.",
        "L'expertise de nos partenaires couvre un large éventail de prestations : installation de $m1, pose de $m2, mise en place de $m3. Chaque artisan en $nom dispose de sa garantie décennale et d'une assurance responsabilité civile professionnelle.",
        "Besoin d'une $m1 performante, d'une $m2 sécurisée ou de $m4 élégantes ? Les $metierPlural référencés en $nom vous proposent des solutions adaptées à votre budget et à vos exigences en matière d'isolation et de sécurité.",
        "En $nom, les projets les plus demandés concernent l'installation de $m1, le remplacement de $m2 et la pose de $m3. Nos professionnels locaux vous conseillent sur les meilleurs matériaux et finitions pour votre habitat.",
    ];

    $benefitsTitles = [
        "Les avantages de faire appel à un professionnel en $nom",
        "Pourquoi choisir un $metier certifié en $nom ?",
        "Ce que garantissent nos $metierPlural en $nom",
        "Nos engagements qualité en $nom",
    ];

    $benefitsSets = [
        [
            '<strong>Expertise technique</strong> : connaissance des normes DTU et réglementations locales en vigueur',
            '<strong>Étude personnalisée</strong> : analyse de vos besoins en isolation, sécurité et esthétique',
            '<strong>Garantie décennale</strong> : couverture obligatoire sur tous les travaux réalisés',
            '<strong>Un seul interlocuteur</strong> : suivi complet du devis à la réception des travaux',
        ],
        [
            '<strong>Conseil sur mesure</strong> : choix du matériau (PVC, aluminium, bois, composite) adapté à votre projet',
            '<strong>Dépose et recyclage</strong> : retrait de l\'ancienne porte et évacuation des déchets inclus',
            '<strong>Certifications</strong> : artisans qualifiés Qualibat et assurés en responsabilité civile',
            '<strong>Intervention rapide</strong> : prise en charge sous 48h pour les cas urgents',
        ],
        [
            '<strong>Prise de mesures précise</strong> : relevé technique pour une pose parfaitement ajustée',
            '<strong>Isolation renforcée</strong> : amélioration des performances thermiques et acoustiques de votre habitat',
            '<strong>Devis détaillé</strong> : transparence totale sur les coûts de fourniture et de main-d\'œuvre',
            '<strong>SAV réactif</strong> : support après installation pour tout ajustement ou question',
        ],
        [
            '<strong>Artisans locaux</strong> : professionnels implantés dans votre département, réactifs et disponibles',
            '<strong>Large choix</strong> : accès aux gammes des principaux fabricants français et européens',
            '<strong>Conformité</strong> : respect des normes RT2012/RE2020 pour les travaux d\'isolation',
            '<strong>Accompagnement aides</strong> : information sur MaPrimeRénov\', éco-PTZ et TVA réduite',
        ],
    ];

    return [
        'heroSubtitle' => $heroSubtitles[$hash % count($heroSubtitles)],
        'intro' => $intros[($hash >> 3) % count($intros)],
        'detail' => $details[($hash >> 6) % count($details)],
        'benefitsTitle' => $benefitsTitles[($hash >> 9) % count($benefitsTitles)],
        'benefits' => $benefitsSets[($hash >> 12) % count($benefitsSets)],
    ];
}

/**
 * Génère un contenu d'introduction unique pour chaque page département
 */
function getDeptIntroContent($dept, $regionNom, $villeCount) {
    $nom = e($dept['nom']);
    $code = e($dept['code']);
    $region = e($regionNom);
    $metier = METIER;
    $metierPlural = METIER_PLURAL;
    $metierTitle = METIER_TITLE;

    $modeles = MODELES;
    $m1 = mb_strtolower($modeles[0]['nom']);
    $m2 = mb_strtolower($modeles[1]['nom']);
    $m3 = mb_strtolower($modeles[2]['nom']);
    $m4 = mb_strtolower($modeles[3]['nom'] ?? $modeles[0]['nom']);

    $hash = abs(crc32($dept['slug'] ?? $dept['nom']));

    $heroSubtitles = [
        "$villeCount villes desservies par nos $metierPlural dans le $nom.",
        "Artisans certifiés pour vos portes dans les $villeCount communes du $nom.",
        "$villeCount communes couvertes pour l'installation de vos portes.",
        "Des experts locaux interviennent dans tout le $nom ($villeCount villes).",
        "Pose et remplacement de portes dans les $villeCount villes du département.",
        "Réseau de $metierPlural couvrant $villeCount communes du $nom.",
    ];

    $titles = [
        "{$metierTitle}s disponibles dans le département $nom ($code)",
        "Trouvez votre $metier dans le $nom ($code)",
        "Pose de portes dans le $nom ($code) : nos experts",
        "Votre projet de porte dans le $nom ($code)",
        "Réseau de $metierPlural dans le $nom ($code)",
    ];

    $paragraphs = [
        "Le département <strong>$nom</strong> ($code), en région $region, est couvert par notre réseau sur $villeCount villes. Nos $metierPlural partenaires interviennent pour l'installation de $m1, la pose de $m2 et le remplacement de $m3. Chaque professionnel référencé dispose de sa garantie décennale.",
        "Avec $villeCount communes dans notre annuaire, le <strong>$nom</strong> ($code) offre un choix étendu de $metierPlural qualifiés. Situé en $region, ce département bénéficie d'artisans spécialisés en $m1, $m2 et $m3, capables de s'adapter à tous les types de bâti.",
        "Dans le <strong>$nom</strong> ($code), nos partenaires assurent la pose et la dépose de portes dans $villeCount villes du département. Spécialistes de la $m1 comme de la $m2, ils vous conseillent sur les matériaux, l'isolation et la sécurité adaptés à la région $region.",
        "Notre annuaire couvre $villeCount villes du département <strong>$nom</strong> ($code) en région $region. Que vous cherchiez un spécialiste en $m1, un artisan pour votre $m2 ou un expert en $m3, vous trouverez le professionnel qu'il vous faut près de chez vous.",
        "Le <strong>$nom</strong> ($code) compte parmi les départements bien couverts de la région $region, avec $villeCount communes référencées. Nos $metierPlural locaux réalisent tous types de travaux : installation neuve, remplacement, blindage et rénovation de portes.",
        "En <strong>$nom</strong> ($code), $villeCount communes bénéficient de notre réseau de $metierPlural qualifiés. Implantés en $region, ces artisans maîtrisent aussi bien la pose de $m1 que l'installation de $m2 ou de $m4.",
    ];

    return [
        'heroSubtitle' => $heroSubtitles[$hash % count($heroSubtitles)],
        'title' => $titles[($hash >> 4) % count($titles)],
        'paragraph' => $paragraphs[($hash >> 8) % count($paragraphs)],
    ];
}
