<?php
/**
 * Page 404 - Annuaire Portes
 */

require_once __DIR__ . '/../functions.php';

$pageTitle = seoTitle('Page non trouvée');
$pageDescription = seoDescription('La page que vous recherchez n\'existe pas ou a été déplacée.');
$canonical = SITE_URL;

include __DIR__ . '/header.php';
?>

<section class="py-20">
    <div class="max-w-2xl mx-auto px-4 text-center">
        <span class="text-8xl block mb-8">&#128166;</span>
        <h1 class="text-4xl font-bold text-gray-900 mb-4">Page non trouvée</h1>
        <p class="text-xl text-gray-600 mb-8">
            Oups ! La page que vous recherchez n'existe pas ou a été déplacée.
        </p>

        <div class="flex flex-col sm:flex-row justify-center gap-4 mb-12">
            <a href="/"
               class="inline-flex items-center justify-center px-6 py-3 bg-primary-600 hover:bg-primary-700 text-white font-semibold rounded-lg transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Retour à l'accueil
            </a>
            <a href="/#regions"
               class="inline-flex items-center justify-center px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-lg transition-colors">
                Explorer les régions
            </a>
        </div>

        <div class="bg-gray-50 rounded-xl p-8">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Recherchez un <?= METIER ?></h2>
            <?php $searchPlaceholder = "Entrez votre ville..."; ?>
            <?php include __DIR__ . '/../components/search-autocomplete.php'; ?>
        </div>
    </div>
</section>

<?php include __DIR__ . '/footer.php'; ?>
