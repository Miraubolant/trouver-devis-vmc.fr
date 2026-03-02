<?php
/**
 * Robots.txt dynamique - Annuaire Portes
 */

require_once __DIR__ . '/functions.php';

header('Content-Type: text/plain; charset=utf-8');
header('Cache-Control: public, max-age=86400');

echo "# Robots.txt - " . SITE_NAME . PHP_EOL;
echo "# " . SITE_URL . PHP_EOL;
echo PHP_EOL;

echo "User-agent: *" . PHP_EOL;
echo "Allow: /" . PHP_EOL;
echo PHP_EOL;

// Interdire l'accès aux dossiers système
echo "Disallow: /data/" . PHP_EOL;
echo "Disallow: /templates/" . PHP_EOL;
echo "Disallow: /components/" . PHP_EOL;
echo "Disallow: /pages/" . PHP_EOL;
echo "Disallow: /api/" . PHP_EOL;
echo "Disallow: /*.php$" . PHP_EOL;
echo PHP_EOL;

// Autoriser les sitemaps
echo "Allow: /sitemap.xml" . PHP_EOL;
echo "Allow: /sitemap-*.xml" . PHP_EOL;
echo PHP_EOL;

// Sitemap
echo "Sitemap: " . SITE_URL . "/sitemap.xml" . PHP_EOL;
