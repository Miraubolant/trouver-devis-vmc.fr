<?php
/**
 * ============================================
 * ANNUAIRE-VMC.FR - CONFIGURATION
 * ============================================
 */

define('SITE_NAME', 'trouver-devis-vmc.fr');
define('SITE_DOMAIN', 'trouver-devis-vmc.fr');
define('SITE_URL', 'https://trouver-devis-vmc.fr');
define('SITE_EMAIL', 'admin@miraubolant.com');
define('SITE_TAGLINE', "VMC & Ventilation Partout en France");
define('SITE_DESCRIPTION', "Trouvez un installateur de VMC simple ou double flux pour assainir l\'air de votre logement.");

define('SITE_LOGO_TEXT', 'TROUVER-DEVIS-VMC');
define('SITE_LOGO_TLD', '.FR');

define('METIER', "installateur de VMC");
define('METIER_PLURAL', "installateurs de VMC");
define('METIER_TITLE', "Artisan Ventilation");
define('METIER_ICON', "wind");

define('VUD_PARTENAIRE_ID', '2372');
define('VUD_CATEGORIE_ID', '98');
define('VUD_IFRAME_URL', 'https://www.viteundevis.com/widget/devis.php');

define('SCRAPE_QUERY', "installateur vmc ventilation double flux");
define('SCRAPE_API_KEY', '[CLE_API_SEMSCRAPER]');

define('ITEMS_PER_PAGE', 24);
define('NEARBY_CITIES_COUNT', 100);
define('NEARBY_DEPARTMENTS_COUNT', 6);
define('ARTISANS_PER_PAGE', 15);

define('DATA_PATH', __DIR__ . '/data/');
define('REGIONS_FILE', DATA_PATH . 'regions/regions.json');

define('MODELES', [
    ['slug' => 'vmc-simple-flux', 'nom' => 'VMC Simple Flux', 'emoji' => "💨", 'vud_cat' => '98'],
    ['slug' => 'vmc-double-flux', 'nom' => 'VMC Double Flux', 'emoji' => "🔄", 'vud_cat' => '98'],
    ['slug' => 'vmc-hygro', 'nom' => 'VMC Hygroréglable', 'emoji' => "💧", 'vud_cat' => '98'],
    ['slug' => 'vmc-gaz', 'nom' => 'VMC Gaz', 'emoji' => "🔥", 'vud_cat' => '98'],
    ['slug' => 'vmc-hygro-a', 'nom' => 'VMC Hygro A', 'emoji' => "🌬️", 'vud_cat' => '98'],
    ['slug' => 'vmc-hygro-b', 'nom' => 'VMC Hygro B', 'emoji' => "💧", 'vud_cat' => '98'],
    ['slug' => 'vmc-thermodynamique', 'nom' => 'VMC Thermodynamique', 'emoji' => "🌡️", 'vud_cat' => '98'],
    ['slug' => 'vmi', 'nom' => 'Ventilation Mécanique Insufflée', 'emoji' => "🏠", 'vud_cat' => '98'],
    ['slug' => 'vmr', 'nom' => 'Ventilation Mécanique Répartie', 'emoji' => "🚪", 'vud_cat' => '98'],
    ['slug' => 'puits-canadien', 'nom' => 'Puits Canadien', 'emoji' => "🌍", 'vud_cat' => '98'],
    ['slug' => 'entretien-vmc', 'nom' => 'Entretien VMC', 'emoji' => "🛠️", 'vud_cat' => '98'],
    ['slug' => 'depannage-vmc', 'nom' => 'Dépannage VMC', 'emoji' => "🚨", 'vud_cat' => '98'],
    ['slug' => 'nettoyage-gaines', 'nom' => 'Nettoyage des Gaines', 'emoji' => "🧹", 'vud_cat' => '98'],
    ['slug' => 'remplacement-moteur', 'nom' => 'Remplacement Moteur VMC', 'emoji' => "⚙️", 'vud_cat' => '98'],
    ['slug' => 'installation-vmc-neuf', 'nom' => 'Installation VMC Neuf', 'emoji' => "🏗️", 'vud_cat' => '98'],
    ['slug' => 'renovation-vmc', 'nom' => 'Rénovation VMC', 'emoji' => "🔧", 'vud_cat' => '98'],
    ['slug' => 'extracteur-air', 'nom' => 'Extracteur d\'Air', 'emoji' => "🌀", 'vud_cat' => '98'],
    ['slug' => 'diagnostic-ventilation', 'nom' => 'Diagnostic Ventilation', 'emoji' => "🔍", 'vud_cat' => '98'],
    ['slug' => 'bouches-extraction', 'nom' => 'Bouches d\'Extraction', 'emoji' => "🕳️", 'vud_cat' => '98'],
    ['slug' => 'entrees-air', 'nom' => 'Entrées d\'Air', 'emoji' => "🪟", 'vud_cat' => '98'],
    ['slug' => 'filtration-air', 'nom' => 'Filtration de l\'Air', 'emoji' => "🦠", 'vud_cat' => '98'],
    ['slug' => 'caisson-vmc', 'nom' => 'Caisson de VMC', 'emoji' => "📦", 'vud_cat' => '98'],
    ['slug' => 'vmc-connectee', 'nom' => 'VMC Connectée', 'emoji' => "📱", 'vud_cat' => '98'],
    ['slug' => 'vmc-silencieuse', 'nom' => 'VMC Silencieuse', 'emoji' => "🤫", 'vud_cat' => '98'],
    ['slug' => 'vmc-extra-plate', 'nom' => 'VMC Extra Plate', 'emoji' => "📏", 'vud_cat' => '98'],
    ['slug' => 'creation-regies', 'nom' => 'Création de Gaines', 'emoji' => "🪚", 'vud_cat' => '98'],
    ['slug' => 'reglage-debits', 'nom' => 'Réglage des Débits', 'emoji' => "🎛️", 'vud_cat' => '98'],
    ['slug' => 'desinfection-reseau', 'nom' => 'Désinfection Réseau', 'emoji' => "✨", 'vud_cat' => '98'],
    ['slug' => 'vmc-tertiaire', 'nom' => 'VMC Tertiaire', 'emoji' => "🏢", 'vud_cat' => '98'],
    ['slug' => 'etancheite-air', 'nom' => 'Étanchéité à l\'Air', 'emoji' => "🧱", 'vud_cat' => '98'],
]);

define('STYLES', [
    ['slug' => 'vmc-simple-flux', 'nom' => 'VMC Simple Flux', 'emoji' => "💨", 'desc' => 'Détails et installation'],
    ['slug' => 'vmc-double-flux', 'nom' => 'VMC Double Flux', 'emoji' => "🔄", 'desc' => 'Détails et installation'],
    ['slug' => 'vmc-hygro', 'nom' => 'VMC Hygroréglable', 'emoji' => "💧", 'desc' => 'Détails et installation'],
    ['slug' => 'vmc-gaz', 'nom' => 'VMC Gaz', 'emoji' => "🔥", 'desc' => 'Détails et installation'],
    ['slug' => 'vmc-hygro-a', 'nom' => 'VMC Hygro A', 'emoji' => "🌬️", 'desc' => 'Détails et installation'],
    ['slug' => 'vmc-hygro-b', 'nom' => 'VMC Hygro B', 'emoji' => "💧", 'desc' => 'Détails et installation'],
    ['slug' => 'vmc-thermodynamique', 'nom' => 'VMC Thermodynamique', 'emoji' => "🌡️", 'desc' => 'Détails et installation'],
    ['slug' => 'vmi', 'nom' => 'Ventilation Mécanique Insufflée', 'emoji' => "🏠", 'desc' => 'Détails et installation'],
    ['slug' => 'vmr', 'nom' => 'Ventilation Mécanique Répartie', 'emoji' => "🚪", 'desc' => 'Détails et installation'],
    ['slug' => 'puits-canadien', 'nom' => 'Puits Canadien', 'emoji' => "🌍", 'desc' => 'Détails et installation'],
    ['slug' => 'entretien-vmc', 'nom' => 'Entretien VMC', 'emoji' => "🛠️", 'desc' => 'Détails et installation'],
    ['slug' => 'depannage-vmc', 'nom' => 'Dépannage VMC', 'emoji' => "🚨", 'desc' => 'Détails et installation'],
    ['slug' => 'nettoyage-gaines', 'nom' => 'Nettoyage des Gaines', 'emoji' => "🧹", 'desc' => 'Détails et installation'],
    ['slug' => 'remplacement-moteur', 'nom' => 'Remplacement Moteur VMC', 'emoji' => "⚙️", 'desc' => 'Détails et installation'],
    ['slug' => 'installation-vmc-neuf', 'nom' => 'Installation VMC Neuf', 'emoji' => "🏗️", 'desc' => 'Détails et installation'],
    ['slug' => 'renovation-vmc', 'nom' => 'Rénovation VMC', 'emoji' => "🔧", 'desc' => 'Détails et installation'],
    ['slug' => 'extracteur-air', 'nom' => 'Extracteur d\'Air', 'emoji' => "🌀", 'desc' => 'Détails et installation'],
    ['slug' => 'diagnostic-ventilation', 'nom' => 'Diagnostic Ventilation', 'emoji' => "🔍", 'desc' => 'Détails et installation'],
    ['slug' => 'bouches-extraction', 'nom' => 'Bouches d\'Extraction', 'emoji' => "🕳️", 'desc' => 'Détails et installation'],
    ['slug' => 'entrees-air', 'nom' => 'Entrées d\'Air', 'emoji' => "🪟", 'desc' => 'Détails et installation'],
    ['slug' => 'filtration-air', 'nom' => 'Filtration de l\'Air', 'emoji' => "🦠", 'desc' => 'Détails et installation'],
    ['slug' => 'caisson-vmc', 'nom' => 'Caisson de VMC', 'emoji' => "📦", 'desc' => 'Détails et installation'],
    ['slug' => 'vmc-connectee', 'nom' => 'VMC Connectée', 'emoji' => "📱", 'desc' => 'Détails et installation'],
    ['slug' => 'vmc-silencieuse', 'nom' => 'VMC Silencieuse', 'emoji' => "🤫", 'desc' => 'Détails et installation'],
    ['slug' => 'vmc-extra-plate', 'nom' => 'VMC Extra Plate', 'emoji' => "📏", 'desc' => 'Détails et installation'],
    ['slug' => 'creation-regies', 'nom' => 'Création de Gaines', 'emoji' => "🪚", 'desc' => 'Détails et installation'],
    ['slug' => 'reglage-debits', 'nom' => 'Réglage des Débits', 'emoji' => "🎛️", 'desc' => 'Détails et installation'],
    ['slug' => 'desinfection-reseau', 'nom' => 'Désinfection Réseau', 'emoji' => "✨", 'desc' => 'Détails et installation'],
    ['slug' => 'vmc-tertiaire', 'nom' => 'VMC Tertiaire', 'emoji' => "🏢", 'desc' => 'Détails et installation'],
    ['slug' => 'etancheite-air', 'nom' => 'Étanchéité à l\'Air', 'emoji' => "🧱", 'desc' => 'Détails et installation'],
]);

define('SERVICES', [
    [
        'titre' => "Installation Neuf & Rénovation",
        'icon' => "✅",
        'desc' => "Pose de systèmes de ventilation (Simple, Double Flux, Hygroréglable) pour une qualité d'air optimale.",
        'points' => ["Étude de dimensionnement", "Garantie décennale et respect de la RT2012/RE2020", "Choix des meilleures marques"]
    ],
    [
        'titre' => "Entretien & Nettoyage",
        'icon' => "🛠️",
        'desc' => "Nettoyage complet des réseaux de gaines, du caisson et des bouches d'extraction pour prévenir les moisissures.",
        'points' => ["Intervention rapide", "Remplacement des filtres", "Vérification des moteurs"]
    ],
    [
        'titre' => "Dépannage Rapide",
        'icon' => "🚨",
        'desc' => "Réparation de votre VMC en panne, bruyante ou souffrant d'une baisse de débit.",
        'points' => ["Diagnostic de l'installation", "Réglage des débits de ventilation", "Pièces de rechange certifiées"]
    ],
]);

define('FAQ_ACCUEIL', [
    [
        'question' => "Pourquoi est-il obligatoire d'avoir une VMC ?",
        'reponse' => "La VMC (Ventilation Mécanique Contrôlée) est indispensable pour renouveler l'air intérieur, évacuer l'humidité (salle de bain, cuisine) et les polluants. Une maison mal ventilée favorise l'apparition de moisissures, d'acariens et peut nuire à la santé de ses occupants ainsi qu'au bâti."
    ],
    [
        'question' => "Quelle est la différence entre une VMC simple flux et double flux ?",
        'reponse' => "La VMC simple flux se contente d'extraire l'air vicié vers l'extérieur. La VMC double flux, elle, croise l'air extrait avec l'air neuf entrant pour récupérer la chaleur (jusqu'à 90%). Cela permet de faire des économies de chauffage importantes, car l'air froid de l'extérieur est préchauffé avant d'entrer dans la maison."
    ],
    [
        'question' => "À quelle fréquence faut-il entretenir sa VMC ?",
        'reponse' => "Il est recommandé de nettoyer les bouches d'extraction et d'insufflation tous les semestres. Un entretien complet par un professionnel (nettoyage du caisson, vérification des moteurs, nettoyage des gaines) doit être effectué tous les 2 à 3 ans pour maintenir les performances et éviter les risques d'incendie."
    ],
    [
        'question' => "Pourquoi ma VMC fait-elle beaucoup de bruit ?",
        'reponse' => "Un bruit anormal peut signifier que les gaines sont encrassées, que le moteur fatigue, ou que l'installation initiale (dimensionnement ou fixation) n'a pas été faite correctement. Il est conseillé de faire intervenir un spécialiste pour un diagnostic de ventilation."
    ],
    [
        'question' => "Quelles aides existent pour l'installation d'une VMC Double Flux ?",
        'reponse' => "L'installation d'une VMC double flux améliorant la performance énergétique de l'habitat, elle est éligible à MaPrimeRénov', la prime énergie (CEE), l'éco-PTZ et la TVA à taux réduit (5,5%). Il est impératif de faire appel à un installateur certifié RGE pour en bénéficier."
    ]
]);

define('TOP_VILLES', [
    ['nom' => 'Paris', 'slug' => 'paris', 'cp' => '75000', 'region' => 'ile-de-france', 'dept' => 'paris'],
    ['nom' => 'Marseille', 'slug' => 'marseille', 'cp' => '13000', 'region' => 'provence-alpes-cote-d-azur', 'dept' => 'bouches-du-rhone'],
    ['nom' => 'Lyon', 'slug' => 'lyon', 'cp' => '69000', 'region' => 'auvergne-rhone-alpes', 'dept' => 'rhone'],
    ['nom' => 'Toulouse', 'slug' => 'toulouse', 'cp' => '31100', 'region' => 'occitanie', 'dept' => 'haute-garonne'],
    ['nom' => 'Nice', 'slug' => 'nice', 'cp' => '06000', 'region' => 'provence-alpes-cote-d-azur', 'dept' => 'alpes-maritimes'],
    ['nom' => 'Nantes', 'slug' => 'nantes', 'cp' => '44200', 'region' => 'pays-de-la-loire', 'dept' => 'loire-atlantique'],
    ['nom' => 'Montpellier', 'slug' => 'montpellier', 'cp' => '34080', 'region' => 'occitanie', 'dept' => 'herault'],
    ['nom' => 'Bordeaux', 'slug' => 'bordeaux', 'cp' => '33300', 'region' => 'nouvelle-aquitaine', 'dept' => 'gironde'],
    ['nom' => 'Lille', 'slug' => 'lille', 'cp' => '59260', 'region' => 'hauts-de-france', 'dept' => 'nord'],
    ['nom' => 'Strasbourg', 'slug' => 'strasbourg', 'cp' => '67000', 'region' => 'grand-est', 'dept' => 'bas-rhin'],
    ['nom' => 'Rennes', 'slug' => 'rennes', 'cp' => '35700', 'region' => 'bretagne', 'dept' => 'ille-et-vilaine'],
    ['nom' => 'Toulon', 'slug' => 'toulon', 'cp' => '83000', 'region' => 'provence-alpes-cote-d-azur', 'dept' => 'var'],
    ['nom' => 'Grenoble', 'slug' => 'grenoble', 'cp' => '38000', 'region' => 'auvergne-rhone-alpes', 'dept' => 'isere'],
    ['nom' => 'Dijon', 'slug' => 'dijon', 'cp' => '21000', 'region' => 'bourgogne-franche-comte', 'dept' => 'cote-d-or'],
    ['nom' => 'Angers', 'slug' => 'angers', 'cp' => '49000', 'region' => 'pays-de-la-loire', 'dept' => 'maine-et-loire'],
    ['nom' => 'Nimes', 'slug' => 'nimes', 'cp' => '30000', 'region' => 'occitanie', 'dept' => 'gard'],
    ['nom' => 'Clermont-Ferrand', 'slug' => 'clermont-ferrand', 'cp' => '63000', 'region' => 'auvergne-rhone-alpes', 'dept' => 'puy-de-dome'],
    ['nom' => 'Le Havre', 'slug' => 'le-havre', 'cp' => '76600', 'region' => 'normandie', 'dept' => 'seine-maritime'],
]);

define('AVANTAGES', [
    ['titre' => 'Réseau National', 'desc' => 'Des milliers de professionnels référencés dans toute la France.', 'icon' => "🗺️"],
    ['titre' => 'Partenaires Expérimentés', 'desc' => 'Trouvez le bon interlocuteur pour la réussite de votre projet', 'icon' => "✅"],
    ['titre' => 'Mise en Relation Rapide', 'desc' => 'Obtenez gratuitement des devis adaptés à vos besoins.', 'icon' => "💰"],
]);

define('HERO_IMAGE', 'https://images.unsplash.com/photo-1579549594162-811c79cd6243?w=1920&q=80&auto=format&fit=crop');
define('MODELE_IMAGE', 'https://images.unsplash.com/photo-1582294246133-72215c0e0b3c?w=1920&q=80&auto=format&fit=crop');


function getModeleBySlug($slug)
{
    foreach (MODELES as $modele) {
        if ($modele['slug'] === $slug) {
            return $modele;
        }
    }
    return null;
}

function getAllModeles()
{
    return MODELES;
}

function getVudUrl($modele = null)
{
    $catId = VUD_CATEGORIE_ID;
    if ($modele && isset($modele['vud_cat'])) {
        $catId = $modele['vud_cat'];
    }
    return 'https://www.viteundevis.com/in/?pid=' . VUD_PARTENAIRE_ID . '&c=' . $catId;
}

function getVudCatForModele($modele = null)
{
    if ($modele && isset($modele['vud_cat'])) {
        return $modele['vud_cat'];
    }
    return VUD_CATEGORIE_ID;
}
