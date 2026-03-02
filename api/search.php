<?php
/**
 * API de recherche de villes - Annuaire Portes
 * Endpoint: /api/search.php?q=marseille
 */

require_once __DIR__ . '/../functions.php';

header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: public, max-age=3600');

// Récupération de la requête
$query = trim($_GET['q'] ?? '');
$limit = min(20, max(1, intval($_GET['limit'] ?? 10)));

if (strlen($query) < 2) {
    echo json_encode([]);
    exit;
}

// Normalisation de la requête
$queryNorm = mb_strtolower($query);
$queryNorm = str_replace(['é', 'è', 'ê', 'ë'], 'e', $queryNorm);
$queryNorm = str_replace(['à', 'â', 'ä'], 'a', $queryNorm);
$queryNorm = str_replace(['ù', 'û', 'ü'], 'u', $queryNorm);
$queryNorm = str_replace(['ô', 'ö'], 'o', $queryNorm);
$queryNorm = str_replace(['î', 'ï'], 'i', $queryNorm);
$queryNorm = str_replace(['ç'], 'c', $queryNorm);

// Recherche dans les régions pour trouver les villes
$results = [];
$regions = getRegions();

// Si la requête ressemble à un code postal
$isPostalCode = preg_match('/^\d{2,5}$/', $query);

foreach ($regions as $region) {
    if (count($results) >= $limit) break;

    foreach ($region['departements'] as $dept) {
        if (count($results) >= $limit) break;

        // Charger les données du département
        $deptData = getDepartement($dept['code']);
        if (!$deptData || empty($deptData['villes'])) continue;

        foreach ($deptData['villes'] as $ville) {
            if (count($results) >= $limit) break;

            // Normaliser le nom de la ville
            $villeNorm = mb_strtolower($ville['nom_standard']);
            $villeNorm = str_replace(['é', 'è', 'ê', 'ë'], 'e', $villeNorm);
            $villeNorm = str_replace(['à', 'â', 'ä'], 'a', $villeNorm);
            $villeNorm = str_replace(['ù', 'û', 'ü'], 'u', $villeNorm);
            $villeNorm = str_replace(['ô', 'ö'], 'o', $villeNorm);
            $villeNorm = str_replace(['î', 'ï'], 'i', $villeNorm);
            $villeNorm = str_replace(['ç'], 'c', $villeNorm);

            // Vérifier la correspondance
            $match = false;

            if ($isPostalCode) {
                // Recherche par code postal
                $match = strpos($ville['code_postal'], $query) === 0;
            } else {
                // Recherche par nom
                $match = strpos($villeNorm, $queryNorm) !== false;
            }

            if ($match) {
                $results[] = [
                    'nom' => $ville['nom_standard'],
                    'cp' => $ville['code_postal'],
                    'dept' => $dept['nom'],
                    'region' => $region['nom'],
                    'url' => urlRelative($region['slug'] . '/' . $dept['slug'] . '/' . $ville['slug_ville'] . '-' . $ville['code_postal'] . '/'),
                    'population' => $ville['population'] ?? 0
                ];
            }
        }
    }
}

// Trier par population (villes les plus grandes en premier)
usort($results, function($a, $b) {
    return $b['population'] - $a['population'];
});

// Limiter les résultats
$results = array_slice($results, 0, $limit);

echo json_encode($results, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
