<?php
/**
 * Générateur de Sitemaps - Annuaire Portes
 *
 * Routes:
 * /sitemap.xml          → Index des sitemaps
 * /sitemap-main.xml     → Pages principales (accueil, régions, départements, pages statiques)
 * /sitemap-villes-{dept}.xml  → Villes d'un département
 * /sitemap-modeles-{dept}.xml → Pages modèles d'un département
 * /sitemap-artisans-{dept}.xml → Artisans d'un département
 */

require_once __DIR__ . '/functions.php';

header('Content-Type: application/xml; charset=utf-8');
header('Cache-Control: public, max-age=86400'); // Cache 24h

$type = $_GET['type'] ?? 'index';
$dept = $_GET['dept'] ?? null;

switch ($type) {
    case 'index':
        generateSitemapIndex();
        break;
    case 'main':
        generateSitemapMain();
        break;
    case 'villes':
        if ($dept) generateSitemapVilles($dept);
        else generateSitemapIndex();
        break;
    case 'modeles':
        if ($dept) generateSitemapModeles($dept);
        else generateSitemapIndex();
        break;
    case 'artisans':
        if ($dept) generateSitemapArtisans($dept);
        else generateSitemapIndex();
        break;
    default:
        generateSitemapIndex();
}

/**
 * Génère l'index des sitemaps
 */
function generateSitemapIndex() {
    $regions = getRegions();
    $lastmod = date('Y-m-d');

    echo '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
    echo '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . PHP_EOL;

    // Sitemap principal
    echo '  <sitemap>' . PHP_EOL;
    echo '    <loc>' . SITE_URL . '/sitemap-main.xml</loc>' . PHP_EOL;
    echo '    <lastmod>' . $lastmod . '</lastmod>' . PHP_EOL;
    echo '  </sitemap>' . PHP_EOL;

    // Sitemaps par département
    foreach ($regions as $region) {
        foreach ($region['departements'] as $dept) {
            // Sitemap villes
            echo '  <sitemap>' . PHP_EOL;
            echo '    <loc>' . SITE_URL . '/sitemap-villes-' . $dept['code'] . '.xml</loc>' . PHP_EOL;
            echo '    <lastmod>' . $lastmod . '</lastmod>' . PHP_EOL;
            echo '  </sitemap>' . PHP_EOL;

            // Sitemap modèles
            echo '  <sitemap>' . PHP_EOL;
            echo '    <loc>' . SITE_URL . '/sitemap-modeles-' . $dept['code'] . '.xml</loc>' . PHP_EOL;
            echo '    <lastmod>' . $lastmod . '</lastmod>' . PHP_EOL;
            echo '  </sitemap>' . PHP_EOL;

            // Sitemap artisans
            echo '  <sitemap>' . PHP_EOL;
            echo '    <loc>' . SITE_URL . '/sitemap-artisans-' . $dept['code'] . '.xml</loc>' . PHP_EOL;
            echo '    <lastmod>' . $lastmod . '</lastmod>' . PHP_EOL;
            echo '  </sitemap>' . PHP_EOL;
        }
    }

    echo '</sitemapindex>' . PHP_EOL;
}

/**
 * Génère le sitemap principal (accueil, régions, départements)
 */
function generateSitemapMain() {
    $regions = getRegions();
    $lastmod = date('Y-m-d');

    echo '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
    echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . PHP_EOL;

    // Page d'accueil
    echo '  <url>' . PHP_EOL;
    echo '    <loc>' . SITE_URL . '/</loc>' . PHP_EOL;
    echo '    <lastmod>' . $lastmod . '</lastmod>' . PHP_EOL;
    echo '    <changefreq>daily</changefreq>' . PHP_EOL;
    echo '    <priority>1.0</priority>' . PHP_EOL;
    echo '  </url>' . PHP_EOL;

    // Pages statiques
    $staticPages = ['contact', 'mentions-legales', 'politique-confidentialite'];
    foreach ($staticPages as $page) {
        echo '  <url>' . PHP_EOL;
        echo '    <loc>' . SITE_URL . '/' . $page . '/</loc>' . PHP_EOL;
        echo '    <lastmod>' . $lastmod . '</lastmod>' . PHP_EOL;
        echo '    <changefreq>monthly</changefreq>' . PHP_EOL;
        echo '    <priority>0.3</priority>' . PHP_EOL;
        echo '  </url>' . PHP_EOL;
    }

    // Pages régions
    foreach ($regions as $region) {
        echo '  <url>' . PHP_EOL;
        echo '    <loc>' . urlRegion($region['slug']) . '</loc>' . PHP_EOL;
        echo '    <lastmod>' . $lastmod . '</lastmod>' . PHP_EOL;
        echo '    <changefreq>weekly</changefreq>' . PHP_EOL;
        echo '    <priority>0.9</priority>' . PHP_EOL;
        echo '  </url>' . PHP_EOL;

        // Pages départements
        foreach ($region['departements'] as $dept) {
            echo '  <url>' . PHP_EOL;
            echo '    <loc>' . urlDepartement($region['slug'], $dept['slug']) . '</loc>' . PHP_EOL;
            echo '    <lastmod>' . $lastmod . '</lastmod>' . PHP_EOL;
            echo '    <changefreq>weekly</changefreq>' . PHP_EOL;
            echo '    <priority>0.8</priority>' . PHP_EOL;
            echo '  </url>' . PHP_EOL;
        }
    }

    echo '</urlset>' . PHP_EOL;
}

/**
 * Génère le sitemap des villes d'un département
 */
function generateSitemapVilles($deptCode) {
    $deptData = getDepartement($deptCode);
    if (!$deptData) {
        generateSitemapIndex();
        return;
    }

    $lastmod = date('Y-m-d');
    $region = $deptData['region'];
    $dept = $deptData['departement'];
    $villes = $deptData['villes'] ?? [];

    echo '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
    echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . PHP_EOL;

    foreach ($villes as $ville) {
        echo '  <url>' . PHP_EOL;
        echo '    <loc>' . urlVille($region['slug'], $dept['slug'], $ville['slug_ville'], $ville['code_postal']) . '</loc>' . PHP_EOL;
        echo '    <lastmod>' . $lastmod . '</lastmod>' . PHP_EOL;
        echo '    <changefreq>weekly</changefreq>' . PHP_EOL;
        echo '    <priority>0.7</priority>' . PHP_EOL;
        echo '  </url>' . PHP_EOL;
    }

    echo '</urlset>' . PHP_EOL;
}

/**
 * Génère le sitemap des modèles pour un département
 */
function generateSitemapModeles($deptCode) {
    $deptData = getDepartement($deptCode);
    if (!$deptData) {
        generateSitemapIndex();
        return;
    }

    $lastmod = date('Y-m-d');
    $region = $deptData['region'];
    $dept = $deptData['departement'];
    $villes = $deptData['villes'] ?? [];
    $modeles = MODELES;

    echo '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
    echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . PHP_EOL;

    // Pour chaque ville, générer les URLs de tous les modèles
    foreach ($villes as $ville) {
        foreach ($modeles as $modele) {
            echo '  <url>' . PHP_EOL;
            echo '    <loc>' . urlModele($region['slug'], $dept['slug'], $ville['slug_ville'], $ville['code_postal'], $modele['slug']) . '</loc>' . PHP_EOL;
            echo '    <lastmod>' . $lastmod . '</lastmod>' . PHP_EOL;
            echo '    <changefreq>monthly</changefreq>' . PHP_EOL;
            echo '    <priority>0.6</priority>' . PHP_EOL;
            echo '  </url>' . PHP_EOL;
        }
    }

    echo '</urlset>' . PHP_EOL;
}

/**
 * Génère le sitemap des artisans d'un département
 */
function generateSitemapArtisans($deptCode) {
    $deptData = getDepartement($deptCode);
    if (!$deptData) {
        generateSitemapIndex();
        return;
    }

    $lastmod = date('Y-m-d');
    $region = $deptData['region'];
    $dept = $deptData['departement'];
    $villes = $deptData['villes'] ?? [];
    $artisansData = getArtisansDepartement($deptCode);

    echo '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
    echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . PHP_EOL;

    if ($artisansData) {
        foreach ($villes as $ville) {
            $villeArtisans = $artisansData[$ville['slug_ville']]['artisans'] ?? [];
            foreach ($villeArtisans as $artisan) {
                if (empty($artisan['slug'])) continue;
                echo '  <url>' . PHP_EOL;
                echo '    <loc>' . urlArtisan($region['slug'], $dept['slug'], $ville['slug_ville'], $ville['code_postal'], $artisan['slug']) . '</loc>' . PHP_EOL;
                echo '    <lastmod>' . $lastmod . '</lastmod>' . PHP_EOL;
                echo '    <changefreq>monthly</changefreq>' . PHP_EOL;
                echo '    <priority>0.5</priority>' . PHP_EOL;
                echo '  </url>' . PHP_EOL;
            }
        }
    }

    echo '</urlset>' . PHP_EOL;
}
