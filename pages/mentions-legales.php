<?php
/**
 * Page Mentions Légales - Annuaire Portes
 * URL: /mentions-legales/
 */

require_once __DIR__ . '/../functions.php';

// SEO
$pageTitle = seoTitle('Mentions Légales');
$pageDescription = seoDescription('Mentions légales du site ' . SITE_DOMAIN . '. Informations sur l\'éditeur, l\'hébergeur, la propriété intellectuelle et les conditions d\'utilisation.');
$canonical = SITE_URL . '/mentions-legales/';

// Breadcrumbs
$breadcrumbs = [
    ['name' => 'Accueil', 'url' => SITE_URL],
    ['name' => 'Mentions légales', 'url' => $canonical]
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
        <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-8">Mentions Légales</h1>

        <div class="prose prose-lg prose-gray max-w-none">
            <p class="text-gray-600 mb-8">
                Conformément aux dispositions des articles 6-III et 19 de la Loi n° 2004-575 du 21 juin 2004 pour la Confiance dans l'économie numérique,
                dite L.C.E.N., nous portons à la connaissance des utilisateurs et visiteurs du site <?= SITE_DOMAIN ?> les informations suivantes :
            </p>

            <h2 class="text-2xl font-bold text-gray-900 mt-10 mb-4">1. Édition du site</h2>
            <p>Le site <strong><?= SITE_DOMAIN ?></strong> est édité par :</p>
            <ul class="list-disc pl-6 space-y-2 text-gray-700">
                <li><strong>Nom du site :</strong> <?= SITE_NAME ?></li>
                <li><strong>URL :</strong> https://<?= SITE_DOMAIN ?></li>
                <li><strong>Email de contact :</strong> <?= SITE_EMAIL ?></li>
                <li><strong>Directeur de la publication :</strong> Le propriétaire du site</li>
            </ul>

            <h2 class="text-2xl font-bold text-gray-900 mt-10 mb-4">2. Hébergement</h2>
            <p>Le site <?= SITE_DOMAIN ?> est hébergé par :</p>
            <ul class="list-disc pl-6 space-y-2 text-gray-700">
                <li><strong>Hébergeur :</strong> [Nom de l'hébergeur]</li>
                <li><strong>Adresse :</strong> [Adresse de l'hébergeur]</li>
                <li><strong>Téléphone :</strong> [Téléphone de l'hébergeur]</li>
            </ul>

            <h2 class="text-2xl font-bold text-gray-900 mt-10 mb-4">3. Propriété intellectuelle</h2>
            <p>
                L'ensemble du contenu du site <?= SITE_DOMAIN ?> (textes, images, graphismes, logo, icônes, sons, logiciels, etc.)
                est protégé par les lois françaises et internationales relatives à la propriété intellectuelle.
            </p>
            <p>
                Toute reproduction, représentation, modification, publication, adaptation de tout ou partie des éléments du site,
                quel que soit le moyen ou le procédé utilisé, est interdite, sauf autorisation écrite préalable de l'éditeur.
            </p>
            <p>
                Toute exploitation non autorisée du site ou de l'un quelconque des éléments qu'il contient sera considérée comme
                constitutive d'une contrefaçon et poursuivie conformément aux dispositions des articles L.335-2 et suivants du Code de Propriété Intellectuelle.
            </p>

            <h2 class="text-2xl font-bold text-gray-900 mt-10 mb-4">4. Limitation de responsabilité</h2>
            <p>
                Le site <?= SITE_DOMAIN ?> ne pourra être tenu responsable des dommages directs et indirects causés au matériel de l'utilisateur,
                lors de l'accès au site, et résultant soit de l'utilisation d'un matériel ne répondant pas aux spécifications indiquées,
                soit de l'apparition d'un bug ou d'une incompatibilité.
            </p>
            <p>
                Le site <?= SITE_DOMAIN ?> ne pourra également être tenu responsable des dommages indirects (tels par exemple qu'une perte de marché
                ou perte d'une chance) consécutifs à l'utilisation du site.
            </p>
            <p>
                Les informations contenues sur ce site sont aussi précises que possible et le site est périodiquement mis à jour, mais peut toutefois
                contenir des inexactitudes, des omissions ou des lacunes. Si vous constatez une lacune, erreur ou ce qui paraît être un dysfonctionnement,
                merci de bien vouloir le signaler par email à contact@<?= SITE_DOMAIN ?>.
            </p>

            <h2 class="text-2xl font-bold text-gray-900 mt-10 mb-4">5. Données personnelles et RGPD</h2>
            <p>
                Conformément à la loi « Informatique et Libertés » du 6 janvier 1978 modifiée et au Règlement Général sur la Protection des Données (RGPD),
                vous disposez d'un droit d'accès, de rectification, de suppression et d'opposition aux données personnelles vous concernant.
            </p>
            <p>
                Pour exercer ces droits, vous pouvez nous contacter à l'adresse email suivante : <strong><?= SITE_EMAIL ?></strong>
            </p>
            <p>
                Pour plus d'informations sur la gestion de vos données personnelles, veuillez consulter notre
                <a href="/politique-confidentialite/" class="text-primary-600 hover:underline">Politique de Confidentialité</a>.
            </p>

            <h2 class="text-2xl font-bold text-gray-900 mt-10 mb-4">6. Cookies</h2>
            <p>
                Le site <?= SITE_DOMAIN ?> peut être amené à vous demander l'acceptation des cookies pour des besoins de statistiques et d'affichage.
                Un cookie est une information déposée sur votre disque dur par le serveur du site que vous visitez.
            </p>
            <p>
                Vous pouvez refuser les cookies en configurant les paramètres de votre navigateur. Toutefois, cela pourrait affecter
                le fonctionnement de certaines parties du site.
            </p>

            <h2 class="text-2xl font-bold text-gray-900 mt-10 mb-4">7. Liens hypertextes</h2>
            <p>
                Le site <?= SITE_DOMAIN ?> peut contenir des liens hypertextes vers d'autres sites présents sur le réseau Internet.
                Les liens vers ces autres ressources vous font quitter le site <?= SITE_DOMAIN ?>.
            </p>
            <p>
                Il est possible de créer un lien vers cette page sans autorisation expresse de l'éditeur.
                Aucune autorisation ou demande d'information préalable ne peut être exigée par l'éditeur à l'égard d'un site qui souhaite établir un lien
                vers le site de l'éditeur. Toutefois, les sites qui créent un lien ne doivent pas diffamer le site.
            </p>

            <h2 class="text-2xl font-bold text-gray-900 mt-10 mb-4">8. Droit applicable</h2>
            <p>
                Les présentes mentions légales sont régies par le droit français.
                En cas de litige, les tribunaux français seront seuls compétents.
            </p>

            <div class="mt-12 p-6 bg-gray-50 rounded-xl">
                <p class="text-sm text-gray-600">
                    <strong>Dernière mise à jour :</strong> <?= date('d/m/Y') ?>
                </p>
            </div>
        </div>
    </div>
</section>

<?php include __DIR__ . '/../templates/footer.php'; ?>
