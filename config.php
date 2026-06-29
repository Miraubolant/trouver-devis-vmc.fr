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
    ['slug' => 'vmc-simple-flux', 'nom' => 'VMC Simple Flux', 'emoji' => "ðŸ’¨", 'vud_cat' => '98'],
    ['slug' => 'vmc-double-flux', 'nom' => 'VMC Double Flux', 'emoji' => "ðŸ”„", 'vud_cat' => '98'],
    ['slug' => 'vmc-hygro', 'nom' => 'VMC HygrorÃ©glable', 'emoji' => "ðŸ’§", 'vud_cat' => '98'],
    ['slug' => 'vmc-gaz', 'nom' => 'VMC Gaz', 'emoji' => "ðŸ”¥", 'vud_cat' => '98'],
    ['slug' => 'vmc-hygro-a', 'nom' => 'VMC Hygro A', 'emoji' => "ðŸŒ¬ï¸", 'vud_cat' => '98'],
    ['slug' => 'vmc-hygro-b', 'nom' => 'VMC Hygro B', 'emoji' => "ðŸ’§", 'vud_cat' => '98'],
    ['slug' => 'vmc-thermodynamique', 'nom' => 'VMC Thermodynamique', 'emoji' => "ðŸŒ¡ï¸", 'vud_cat' => '98'],
    ['slug' => 'vmi', 'nom' => 'Ventilation MÃ©canique InsufflÃ©e', 'emoji' => "ðŸ ", 'vud_cat' => '98'],
    ['slug' => 'vmr', 'nom' => 'Ventilation MÃ©canique RÃ©partie', 'emoji' => "ðŸšª", 'vud_cat' => '98'],
    ['slug' => 'puits-canadien', 'nom' => 'Puits Canadien', 'emoji' => "ðŸŒ", 'vud_cat' => '98'],
    ['slug' => 'entretien-vmc', 'nom' => 'Entretien VMC', 'emoji' => "ðŸ› ï¸", 'vud_cat' => '98'],
    ['slug' => 'depannage-vmc', 'nom' => 'DÃ©pannage VMC', 'emoji' => "ðŸš¨", 'vud_cat' => '98'],
    ['slug' => 'nettoyage-gaines', 'nom' => 'Nettoyage des Gaines', 'emoji' => "ðŸ§¹", 'vud_cat' => '98'],
    ['slug' => 'remplacement-moteur', 'nom' => 'Remplacement Moteur VMC', 'emoji' => "âš™ï¸", 'vud_cat' => '98'],
    ['slug' => 'installation-vmc-neuf', 'nom' => 'Installation VMC Neuf', 'emoji' => "ðŸ—ï¸", 'vud_cat' => '98'],
    ['slug' => 'renovation-vmc', 'nom' => 'RÃ©novation VMC', 'emoji' => "ðŸ”§", 'vud_cat' => '98'],
    ['slug' => 'extracteur-air', 'nom' => 'Extracteur d\'Air', 'emoji' => "ðŸŒ€", 'vud_cat' => '98'],
    ['slug' => 'diagnostic-ventilation', 'nom' => 'Diagnostic Ventilation', 'emoji' => "ðŸ”", 'vud_cat' => '98'],
    ['slug' => 'bouches-extraction', 'nom' => 'Bouches d\'Extraction', 'emoji' => "ðŸ•³ï¸", 'vud_cat' => '98'],
    ['slug' => 'entrees-air', 'nom' => 'EntrÃ©es d\'Air', 'emoji' => "ðŸªŸ", 'vud_cat' => '98'],
    ['slug' => 'filtration-air', 'nom' => 'Filtration de l\'Air', 'emoji' => "ðŸ¦ ", 'vud_cat' => '98'],
    ['slug' => 'caisson-vmc', 'nom' => 'Caisson de VMC', 'emoji' => "ðŸ“¦", 'vud_cat' => '98'],
    ['slug' => 'vmc-connectee', 'nom' => 'VMC ConnectÃ©e', 'emoji' => "ðŸ“±", 'vud_cat' => '98'],
    ['slug' => 'vmc-silencieuse', 'nom' => 'VMC Silencieuse', 'emoji' => "ðŸ¤«", 'vud_cat' => '98'],
    ['slug' => 'vmc-extra-plate', 'nom' => 'VMC Extra Plate', 'emoji' => "ðŸ“", 'vud_cat' => '98'],
    ['slug' => 'creation-regies', 'nom' => 'CrÃ©ation de Gaines', 'emoji' => "ðŸªš", 'vud_cat' => '98'],
    ['slug' => 'reglage-debits', 'nom' => 'RÃ©glage des DÃ©bits', 'emoji' => "ðŸŽ›ï¸", 'vud_cat' => '98'],
    ['slug' => 'desinfection-reseau', 'nom' => 'DÃ©sinfection RÃ©seau', 'emoji' => "âœ¨", 'vud_cat' => '98'],
    ['slug' => 'vmc-tertiaire', 'nom' => 'VMC Tertiaire', 'emoji' => "ðŸ¢", 'vud_cat' => '98'],
    ['slug' => 'etancheite-air', 'nom' => 'Ã‰tanchÃ©itÃ© Ã  l\'Air', 'emoji' => "ðŸ§±", 'vud_cat' => '98'],
]);

define('STYLES', [
    ['slug' => 'vmc-simple-flux', 'nom' => 'VMC Simple Flux', 'emoji' => "ðŸ’¨", 'desc' => 'DÃ©tails et installation'],
    ['slug' => 'vmc-double-flux', 'nom' => 'VMC Double Flux', 'emoji' => "ðŸ”„", 'desc' => 'DÃ©tails et installation'],
    ['slug' => 'vmc-hygro', 'nom' => 'VMC HygrorÃ©glable', 'emoji' => "ðŸ’§", 'desc' => 'DÃ©tails et installation'],
    ['slug' => 'vmc-gaz', 'nom' => 'VMC Gaz', 'emoji' => "ðŸ”¥", 'desc' => 'DÃ©tails et installation'],
    ['slug' => 'vmc-hygro-a', 'nom' => 'VMC Hygro A', 'emoji' => "ðŸŒ¬ï¸", 'desc' => 'DÃ©tails et installation'],
    ['slug' => 'vmc-hygro-b', 'nom' => 'VMC Hygro B', 'emoji' => "ðŸ’§", 'desc' => 'DÃ©tails et installation'],
    ['slug' => 'vmc-thermodynamique', 'nom' => 'VMC Thermodynamique', 'emoji' => "ðŸŒ¡ï¸", 'desc' => 'DÃ©tails et installation'],
    ['slug' => 'vmi', 'nom' => 'Ventilation MÃ©canique InsufflÃ©e', 'emoji' => "ðŸ ", 'desc' => 'DÃ©tails et installation'],
    ['slug' => 'vmr', 'nom' => 'Ventilation MÃ©canique RÃ©partie', 'emoji' => "ðŸšª", 'desc' => 'DÃ©tails et installation'],
    ['slug' => 'puits-canadien', 'nom' => 'Puits Canadien', 'emoji' => "ðŸŒ", 'desc' => 'DÃ©tails et installation'],
    ['slug' => 'entretien-vmc', 'nom' => 'Entretien VMC', 'emoji' => "ðŸ› ï¸", 'desc' => 'DÃ©tails et installation'],
    ['slug' => 'depannage-vmc', 'nom' => 'DÃ©pannage VMC', 'emoji' => "ðŸš¨", 'desc' => 'DÃ©tails et installation'],
    ['slug' => 'nettoyage-gaines', 'nom' => 'Nettoyage des Gaines', 'emoji' => "ðŸ§¹", 'desc' => 'DÃ©tails et installation'],
    ['slug' => 'remplacement-moteur', 'nom' => 'Remplacement Moteur VMC', 'emoji' => "âš™ï¸", 'desc' => 'DÃ©tails et installation'],
    ['slug' => 'installation-vmc-neuf', 'nom' => 'Installation VMC Neuf', 'emoji' => "ðŸ—ï¸", 'desc' => 'DÃ©tails et installation'],
    ['slug' => 'renovation-vmc', 'nom' => 'RÃ©novation VMC', 'emoji' => "ðŸ”§", 'desc' => 'DÃ©tails et installation'],
    ['slug' => 'extracteur-air', 'nom' => 'Extracteur d\'Air', 'emoji' => "ðŸŒ€", 'desc' => 'DÃ©tails et installation'],
    ['slug' => 'diagnostic-ventilation', 'nom' => 'Diagnostic Ventilation', 'emoji' => "ðŸ”", 'desc' => 'DÃ©tails et installation'],
    ['slug' => 'bouches-extraction', 'nom' => 'Bouches d\'Extraction', 'emoji' => "ðŸ•³ï¸", 'desc' => 'DÃ©tails et installation'],
    ['slug' => 'entrees-air', 'nom' => 'EntrÃ©es d\'Air', 'emoji' => "ðŸªŸ", 'desc' => 'DÃ©tails et installation'],
    ['slug' => 'filtration-air', 'nom' => 'Filtration de l\'Air', 'emoji' => "ðŸ¦ ", 'desc' => 'DÃ©tails et installation'],
    ['slug' => 'caisson-vmc', 'nom' => 'Caisson de VMC', 'emoji' => "ðŸ“¦", 'desc' => 'DÃ©tails et installation'],
    ['slug' => 'vmc-connectee', 'nom' => 'VMC ConnectÃ©e', 'emoji' => "ðŸ“±", 'desc' => 'DÃ©tails et installation'],
    ['slug' => 'vmc-silencieuse', 'nom' => 'VMC Silencieuse', 'emoji' => "ðŸ¤«", 'desc' => 'DÃ©tails et installation'],
    ['slug' => 'vmc-extra-plate', 'nom' => 'VMC Extra Plate', 'emoji' => "ðŸ“", 'desc' => 'DÃ©tails et installation'],
    ['slug' => 'creation-regies', 'nom' => 'CrÃ©ation de Gaines', 'emoji' => "ðŸªš", 'desc' => 'DÃ©tails et installation'],
    ['slug' => 'reglage-debits', 'nom' => 'RÃ©glage des DÃ©bits', 'emoji' => "ðŸŽ›ï¸", 'desc' => 'DÃ©tails et installation'],
    ['slug' => 'desinfection-reseau', 'nom' => 'DÃ©sinfection RÃ©seau', 'emoji' => "âœ¨", 'desc' => 'DÃ©tails et installation'],
    ['slug' => 'vmc-tertiaire', 'nom' => 'VMC Tertiaire', 'emoji' => "ðŸ¢", 'desc' => 'DÃ©tails et installation'],
    ['slug' => 'etancheite-air', 'nom' => 'Ã‰tanchÃ©itÃ© Ã  l\'Air', 'emoji' => "ðŸ§±", 'desc' => 'DÃ©tails et installation'],
]);

define('SERVICES', [
    [
        'titre' => "Installation Neuf & RÃ©novation",
        'icon' => "âœ…",
        'desc' => "Pose de systÃ¨mes de ventilation (Simple, Double Flux, HygrorÃ©glable) pour une qualitÃ© d'air optimale.",
        'points' => ["Ã‰tude de dimensionnement", "Garantie dÃ©cennale et respect de la RT2012/RE2020", "Choix des meilleures marques"]
    ],
    [
        'titre' => "Entretien & Nettoyage",
        'icon' => "ðŸ› ï¸",
        'desc' => "Nettoyage complet des rÃ©seaux de gaines, du caisson et des bouches d'extraction pour prÃ©venir les moisissures.",
        'points' => ["Intervention rapide", "Remplacement des filtres", "VÃ©rification des moteurs"]
    ],
    [
        'titre' => "DÃ©pannage Rapide",
        'icon' => "ðŸš¨",
        'desc' => "RÃ©paration de votre VMC en panne, bruyante ou souffrant d'une baisse de dÃ©bit.",
        'points' => ["Diagnostic de l'installation", "RÃ©glage des dÃ©bits de ventilation", "PiÃ¨ces de rechange certifiÃ©es"]
    ],
]);

define('FAQ_ACCUEIL', [
    [
        'question' => "Pourquoi est-il obligatoire d'avoir une VMC ?",
        'reponse' => "La VMC (Ventilation MÃ©canique ContrÃ´lÃ©e) est indispensable pour renouveler l'air intÃ©rieur, Ã©vacuer l'humiditÃ© (salle de bain, cuisine) et les polluants. Une maison mal ventilÃ©e favorise l'apparition de moisissures, d'acariens et peut nuire Ã  la santÃ© de ses occupants ainsi qu'au bÃ¢ti."
    ],
    [
        'question' => "Quelle est la diffÃ©rence entre une VMC simple flux et double flux ?",
        'reponse' => "La VMC simple flux se contente d'extraire l'air viciÃ© vers l'extÃ©rieur. La VMC double flux, elle, croise l'air extrait avec l'air neuf entrant pour rÃ©cupÃ©rer la chaleur (jusqu'Ã  90%). Cela permet de faire des Ã©conomies de chauffage importantes, car l'air froid de l'extÃ©rieur est prÃ©chauffÃ© avant d'entrer dans la maison."
    ],
    [
        'question' => "Ã€ quelle frÃ©quence faut-il entretenir sa VMC ?",
        'reponse' => "Il est recommandÃ© de nettoyer les bouches d'extraction et d'insufflation tous les semestres. Un entretien complet par un professionnel (nettoyage du caisson, vÃ©rification des moteurs, nettoyage des gaines) doit Ãªtre effectuÃ© tous les 2 Ã  3 ans pour maintenir les performances et Ã©viter les risques d'incendie."
    ],
    [
        'question' => "Pourquoi ma VMC fait-elle beaucoup de bruit ?",
        'reponse' => "Un bruit anormal peut signifier que les gaines sont encrassÃ©es, que le moteur fatigue, ou que l'installation initiale (dimensionnement ou fixation) n'a pas Ã©tÃ© faite correctement. Il est conseillÃ© de faire intervenir un spÃ©cialiste pour un diagnostic de ventilation."
    ],
    [
        'question' => "Quelles aides existent pour l'installation d'une VMC Double Flux ?",
        'reponse' => "L'installation d'une VMC double flux amÃ©liorant la performance Ã©nergÃ©tique de l'habitat, elle est Ã©ligible Ã  MaPrimeRÃ©nov', la prime Ã©nergie (CEE), l'Ã©co-PTZ et la TVA Ã  taux rÃ©duit (5,5%). Il est impÃ©ratif de faire appel Ã  un installateur certifiÃ© RGE pour en bÃ©nÃ©ficier."
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
    ['titre' => 'RÃ©seau National', 'desc' => 'Des milliers de professionnels rÃ©fÃ©rencÃ©s dans toute la France.', 'icon' => "ðŸ—ºï¸"],
    ['titre' => 'Partenaires ExpÃ©rimentÃ©s', 'desc' => 'Trouvez le bon interlocuteur pour la rÃ©ussite de votre projet', 'icon' => "âœ…"],
    ['titre' => 'Mise en Relation Rapide', 'desc' => 'Obtenez gratuitement des devis adaptÃ©s Ã  vos besoins.', 'icon' => "ðŸ’°"],
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

