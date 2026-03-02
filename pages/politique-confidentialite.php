<?php
/**
 * Page Politique de Confidentialité - Annuaire Portes
 * URL: /politique-confidentialite/
 */

require_once __DIR__ . '/../functions.php';

// SEO
$pageTitle = seoTitle('Politique de Confidentialité');
$pageDescription = seoDescription('Politique de confidentialité du site ' . SITE_DOMAIN . '. Découvrez comment nous collectons, utilisons et protégeons vos données personnelles.');
$canonical = SITE_URL . '/politique-confidentialite/';

// Breadcrumbs
$breadcrumbs = [
    ['name' => 'Accueil', 'url' => SITE_URL],
    ['name' => 'Politique de confidentialité', 'url' => $canonical]
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
        <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-8">Politique de Confidentialité</h1>

        <div class="prose prose-lg prose-gray max-w-none">
            <p class="text-gray-600 mb-8">
                La protection de vos données personnelles est une priorité pour <?= SITE_DOMAIN ?>.
                Cette politique de confidentialité vous informe sur la manière dont nous collectons, utilisons et protégeons vos informations
                conformément au Règlement Général sur la Protection des Données (RGPD).
            </p>

            <h2 class="text-2xl font-bold text-gray-900 mt-10 mb-4">1. Collecte des informations</h2>
            <p>Nous collectons des informations lorsque vous utilisez notre site, notamment :</p>
            <ul class="list-disc pl-6 space-y-2 text-gray-700">
                <li><strong>Données de contact :</strong> nom, prénom, adresse email, numéro de téléphone, code postal</li>
                <li><strong>Données de navigation :</strong> adresse IP, type de navigateur, pages visitées, durée de visite</li>
                <li><strong>Données relatives à votre projet :</strong> informations sur votre projet (type, description, budget estimé)</li>
            </ul>
            <p>Ces informations sont collectées lorsque vous :</p>
            <ul class="list-disc pl-6 space-y-2 text-gray-700">
                <li>Remplissez un formulaire de demande de devis</li>
                <li>Utilisez notre moteur de recherche</li>
                <li>Naviguez sur notre site</li>
                <li>Nous contactez par email</li>
            </ul>

            <h2 class="text-2xl font-bold text-gray-900 mt-10 mb-4">2. Utilisation des informations</h2>
            <p>Les informations que nous collectons sont utilisées pour :</p>
            <ul class="list-disc pl-6 space-y-2 text-gray-700">
                <li>Transmettre vos demandes de devis à nos <?= METIER_PLURAL ?> partenaires</li>
                <li>Personnaliser votre expérience et répondre à vos besoins</li>
                <li>Améliorer notre site web et nos services</li>
                <li>Vous envoyer des informations relatives à votre demande</li>
                <li>Effectuer des statistiques anonymes sur l'utilisation du site</li>
            </ul>

            <h2 class="text-2xl font-bold text-gray-900 mt-10 mb-4">3. Protection des informations</h2>
            <p>
                Nous mettons en œuvre des mesures de sécurité appropriées pour protéger vos informations personnelles contre tout accès,
                modification, divulgation ou destruction non autorisés :
            </p>
            <ul class="list-disc pl-6 space-y-2 text-gray-700">
                <li>Utilisation du protocole HTTPS pour sécuriser les échanges de données</li>
                <li>Accès aux données limité aux personnes autorisées</li>
                <li>Mise à jour régulière de nos systèmes de sécurité</li>
                <li>Sauvegarde régulière des données</li>
            </ul>

            <h2 class="text-2xl font-bold text-gray-900 mt-10 mb-4">4. Partage avec des tiers</h2>
            <p>
                Vos informations personnelles ne sont pas vendues, échangées ou transférées à des tiers sans votre consentement,
                à l'exception des cas suivants :
            </p>
            <ul class="list-disc pl-6 space-y-2 text-gray-700">
                <li><strong><?= ucfirst(METIER_PLURAL) ?> partenaires :</strong> lorsque vous effectuez une demande de devis, vos coordonnées sont transmises aux professionnels sélectionnés</li>
                <li><strong>Prestataires techniques :</strong> hébergement, maintenance du site</li>
                <li><strong>Obligations légales :</strong> si la loi l'exige ou pour protéger nos droits</li>
            </ul>

            <h2 class="text-2xl font-bold text-gray-900 mt-10 mb-4">5. Cookies</h2>
            <p>Notre site utilise des cookies pour :</p>
            <ul class="list-disc pl-6 space-y-2 text-gray-700">
                <li><strong>Cookies essentiels :</strong> nécessaires au fonctionnement du site</li>
                <li><strong>Cookies analytiques :</strong> pour analyser l'utilisation du site et améliorer nos services</li>
                <li><strong>Cookies de préférences :</strong> pour mémoriser vos choix</li>
            </ul>
            <p>
                Vous pouvez paramétrer votre navigateur pour refuser les cookies ou être alerté lorsqu'un cookie est envoyé.
                Toutefois, certaines fonctionnalités du site pourraient ne pas fonctionner correctement sans cookies.
            </p>

            <h2 class="text-2xl font-bold text-gray-900 mt-10 mb-4">6. Vos droits (RGPD)</h2>
            <p>Conformément au RGPD, vous disposez des droits suivants concernant vos données personnelles :</p>
            <ul class="list-disc pl-6 space-y-2 text-gray-700">
                <li><strong>Droit d'accès :</strong> obtenir la confirmation que des données vous concernant sont traitées et en recevoir une copie</li>
                <li><strong>Droit de rectification :</strong> demander la correction de données inexactes ou incomplètes</li>
                <li><strong>Droit à l'effacement :</strong> demander la suppression de vos données dans certaines conditions</li>
                <li><strong>Droit à la limitation :</strong> demander la limitation du traitement de vos données</li>
                <li><strong>Droit d'opposition :</strong> vous opposer au traitement de vos données pour des motifs légitimes</li>
                <li><strong>Droit à la portabilité :</strong> recevoir vos données dans un format structuré et les transférer à un autre responsable</li>
            </ul>
            <p>
                Pour exercer ces droits, contactez-nous à : <strong><?= SITE_EMAIL ?></strong>
            </p>
            <p>
                Vous pouvez également introduire une réclamation auprès de la CNIL (Commission Nationale de l'Informatique et des Libertés) :
                <a href="https://www.cnil.fr" target="_blank" rel="noopener" class="text-primary-600 hover:underline">www.cnil.fr</a>
            </p>

            <h2 class="text-2xl font-bold text-gray-900 mt-10 mb-4">7. Conservation des données</h2>
            <p>
                Vos données personnelles sont conservées pendant une durée limitée, nécessaire aux finalités pour lesquelles elles ont été collectées :
            </p>
            <ul class="list-disc pl-6 space-y-2 text-gray-700">
                <li>Données de demande de devis : 3 ans à compter de la dernière interaction</li>
                <li>Données de navigation (cookies) : 13 mois maximum</li>
                <li>Données de contact : supprimées sur demande ou après 3 ans d'inactivité</li>
            </ul>

            <h2 class="text-2xl font-bold text-gray-900 mt-10 mb-4">8. Modifications de la politique</h2>
            <p>
                Nous nous réservons le droit de modifier cette politique de confidentialité à tout moment.
                Les modifications entrent en vigueur dès leur publication sur cette page.
                Nous vous encourageons à consulter régulièrement cette page pour rester informé des éventuelles mises à jour.
            </p>

            <h2 class="text-2xl font-bold text-gray-900 mt-10 mb-4">9. Contact</h2>
            <p>Pour toute question concernant cette politique de confidentialité ou vos données personnelles, contactez-nous :</p>
            <ul class="list-disc pl-6 space-y-2 text-gray-700">
                <li><strong>Email :</strong> <?= SITE_EMAIL ?></li>
                <li><strong>Formulaire de contact :</strong> <a href="/contact/" class="text-primary-600 hover:underline">Page contact</a></li>
            </ul>

            <div class="mt-12 p-6 bg-gray-50 rounded-xl">
                <p class="text-sm text-gray-600">
                    <strong>Dernière mise à jour :</strong> <?= date('d/m/Y') ?>
                </p>
            </div>
        </div>
    </div>
</section>

<?php include __DIR__ . '/../templates/footer.php'; ?>
