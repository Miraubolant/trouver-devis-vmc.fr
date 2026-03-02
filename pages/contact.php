<?php
/**
 * Page Contact - Annuaire Portes
 * URL: /contact/
 */

require_once __DIR__ . '/../functions.php';

// SEO
$pageTitle = seoTitle('Contact');
$pageDescription = seoDescription('Contactez l\'équipe ' . SITE_DOMAIN . '. Nous sommes à votre disposition pour répondre à vos questions sur nos services de mise en relation avec des ' . METIER_PLURAL . '.');
$canonical = SITE_URL . '/contact/';

// Breadcrumbs
$breadcrumbs = [
    ['name' => 'Accueil', 'url' => SITE_URL],
    ['name' => 'Contact', 'url' => $canonical]
];

// JSON-LD
$jsonLd = [
    jsonLdOrganization(),
    jsonLdBreadcrumb($breadcrumbs)
];

include __DIR__ . '/../templates/header.php';
?>

<!-- Breadcrumb -->
<?php include __DIR__ . '/../components/breadcrumb.php'; ?>

<!-- Contenu -->
<section class="py-12 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Contactez-nous</h1>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                Une question sur nos services ? Notre équipe est à votre disposition pour vous répondre.
            </p>
        </div>

        <div class="grid md:grid-cols-2 gap-12">
            <!-- Informations de contact -->
            <div>
                <h2 class="text-xl font-bold text-gray-900 mb-6">Nos coordonnées</h2>

                <div class="space-y-6">
                    <div class="flex items-start space-x-4">
                        <div class="w-12 h-12 bg-primary-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900">Email</h3>
                            <p class="text-gray-600"><?= SITE_EMAIL ?></p>
                            <p class="text-sm text-gray-500 mt-1">Réponse sous 24-48h</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-4">
                        <div class="w-12 h-12 bg-primary-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900">Horaires</h3>
                            <p class="text-gray-600">Du lundi au vendredi</p>
                            <p class="text-sm text-gray-500 mt-1">9h00 - 18h00</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-4">
                        <div class="w-12 h-12 bg-primary-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900">Zone d'intervention</h3>
                            <p class="text-gray-600">France métropolitaine & DOM-TOM</p>
                            <p class="text-sm text-gray-500 mt-1">Plus de 10 000 <?= METIER_PLURAL ?> référencés</p>
                        </div>
                    </div>
                </div>

                <!-- FAQ rapide -->
                <div class="mt-10 p-6 bg-gray-50 rounded-xl">
                    <h3 class="font-semibold text-gray-900 mb-4">Questions fréquentes</h3>
                    <ul class="space-y-3 text-sm text-gray-600">
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-primary-500 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Le service de mise en relation est-il gratuit ? <strong class="text-gray-900">Oui, 100% gratuit</strong>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-primary-500 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Combien de devis puis-je recevoir ? <strong class="text-gray-900">Jusqu'à 3 devis</strong>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-primary-500 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Suis-je engagé ? <strong class="text-gray-900">Non, sans engagement</strong>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- CTA Devis -->
            <div>
                <div class="bg-gradient-to-br from-primary-600 to-primary-800 rounded-2xl p-8 text-white">
                    <h2 class="text-xl font-bold mb-4">Besoin d'un devis ?</h2>
                    <p class="text-primary-100 mb-6">
                        Recevez gratuitement jusqu'à 3 devis de <?= METIER_PLURAL ?> qualifiés près de chez vous.
                    </p>

                    <ul class="space-y-3 mb-8">
                        <li class="flex items-center text-sm">
                            <svg class="w-5 h-5 text-green-400 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Service 100% gratuit
                        </li>
                        <li class="flex items-center text-sm">
                            <svg class="w-5 h-5 text-green-400 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Sans engagement
                        </li>
                        <li class="flex items-center text-sm">
                            <svg class="w-5 h-5 text-green-400 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Artisans vérifiés et certifiés
                        </li>
                        <li class="flex items-center text-sm">
                            <svg class="w-5 h-5 text-green-400 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Réponse sous 48h
                        </li>
                    </ul>

                    <a href="<?= getVudUrl() ?>"
                       target="_blank"
                       rel="noopener nofollow"
                       class="block w-full text-center bg-white text-primary-600 font-bold py-4 px-6 rounded-xl hover:bg-gray-50 transition-colors shadow-lg">
                        Demander mes devis gratuits
                    </a>
                </div>

                <!-- Infos légales -->
                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-500">
                        En nous contactant, vous acceptez notre
                        <a href="/politique-confidentialite/" class="text-primary-600 hover:underline">politique de confidentialité</a>.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include __DIR__ . '/../templates/footer.php'; ?>
