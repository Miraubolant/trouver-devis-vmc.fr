<?php
/**
 * Routeur principal - Annuaire Portes
 * Gère toutes les routes dynamiques
 */

require_once __DIR__ . '/functions.php';

// Récupération de la route
$route = $_GET['route'] ?? 'home';

// Paramètres de la route
$params = [
    'region' => $_GET['region'] ?? null,
    'departement' => $_GET['departement'] ?? null,
    'ville' => $_GET['ville'] ?? null,
    'modele' => $_GET['modele'] ?? null,
    'artisan' => $_GET['artisan'] ?? null,
    'service' => $_GET['service'] ?? null,
];

// Routage
switch ($route) {
    case 'home':
        include __DIR__ . '/index.php';
        break;

    case 'mentions-legales':
        include __DIR__ . '/pages/mentions-legales.php';
        break;

    case 'politique-confidentialite':
        include __DIR__ . '/pages/politique-confidentialite.php';
        break;

    case 'contact':
        include __DIR__ . '/pages/contact.php';
        break;

    case 'service':
        if (!$params['service']) {
            show404();
        }
        include __DIR__ . '/pages/service.php';
        break;

    case 'region':
        if (!$params['region']) {
            show404();
        }
        include __DIR__ . '/pages/region.php';
        break;

    case 'departement':
        if (!$params['region'] || !$params['departement']) {
            show404();
        }
        include __DIR__ . '/pages/departement.php';
        break;

    case 'ville':
        if (!$params['region'] || !$params['departement'] || !$params['ville']) {
            show404();
        }
        include __DIR__ . '/pages/ville.php';
        break;

    case 'modele':
        if (!$params['region'] || !$params['departement'] || !$params['ville'] || !$params['modele']) {
            show404();
        }
        // Vérifier si c'est bien un modèle et pas "artisans"
        if ($params['modele'] === 'artisans') {
            show404();
        }
        include __DIR__ . '/pages/modele.php';
        break;

    case 'artisan':
        if (!$params['region'] || !$params['departement'] || !$params['ville'] || !$params['artisan']) {
            show404();
        }
        include __DIR__ . '/pages/artisan.php';
        break;

    case '404':
    default:
        show404();
        break;
}

/**
 * Affiche la page 404
 */
function show404() {
    http_response_code(404);
    include __DIR__ . '/templates/404.php';
    exit;
}
