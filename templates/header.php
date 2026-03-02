<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? seoTitle(SITE_TAGLINE) ?></title>
    <meta name="description" content="<?= $pageDescription ?? seoDescription(SITE_DESCRIPTION) ?>">
    <link rel="canonical" href="<?= $canonical ?? SITE_URL ?>">

    <!-- Open Graph -->
    <meta property="og:title" content="<?= $pageTitle ?? seoTitle(SITE_TAGLINE) ?>">
    <meta property="og:description" content="<?= $pageDescription ?? seoDescription(SITE_DESCRIPTION) ?>">
    <meta property="og:url" content="<?= $canonical ?? SITE_URL ?>">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="<?= SITE_NAME ?>">

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="/assets/img/favicon.svg">

    <!-- Tailwind CSS (compiled) -->
    <link rel="stylesheet" href="/assets/css/style.css">

    <!-- Alpine.js + Plugins -->
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- JSON-LD -->
    <?php if (isset($jsonLd)): ?>
        <?php foreach ((array) $jsonLd as $ld): ?>
            <script type="application/ld+json"><?= $ld ?></script>
        <?php endforeach; ?>
    <?php endif; ?>
</head>

<body class="bg-gray-50 text-gray-900 antialiased" x-data="{ mobileMenu: false, searchOpen: false }">

    <!-- Header -->
    <header class="bg-white shadow-sm sticky top-0 z-50">
        <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="/" class="flex items-center space-x-2.5 group">
                        <div
                            class="w-9 h-9 bg-gradient-to-br from-primary-600 to-accent-500 rounded-lg flex items-center justify-center shadow-sm group-hover:shadow-md transition-shadow">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M6 2h10a2 2 0 012 2v16a2 2 0 01-2 2H6a2 2 0 01-2-2V4a2 2 0 012-2zm0 2v16h10V4H6zm2 2h6v5H8V6zm0 7h6v5H8v-5zm5 2a1 1 0 110 2 1 1 0 010-2z" />
                            </svg>
                        </div>
                        <span class="font-semibold text-base tracking-tight uppercase">
                            <span class="text-gray-900"><?= SITE_LOGO_TEXT ?></span><span
                                class="text-primary-600"><?= SITE_LOGO_TLD ?></span>
                        </span>
                    </a>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-8">
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" @click.away="open = false"
                            class="flex items-center space-x-1 text-gray-700 hover:text-primary-600 font-medium">
                            <span>Zones</span>
                            <svg class="w-4 h-4 transition-transform" :class="{'rotate-180': open}" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div x-show="open" x-cloak x-transition
                            class="absolute top-full left-0 mt-2 w-72 bg-white rounded-lg shadow-xl border border-gray-100 py-2 max-h-96 overflow-y-auto">
                            <div class="px-4 py-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">Villes
                                populaires</div>
                            <?php foreach (TOP_VILLES as $topVille): ?>
                                <a href="<?= urlRelative($topVille['region'] . '/' . $topVille['dept'] . '/' . $topVille['slug'] . '-' . $topVille['cp'] . '/') ?>"
                                    class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-primary-50 hover:text-primary-600">
                                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    </svg>
                                    <?= METIER_TITLE ?>     <?= e($topVille['nom']) ?>
                                </a>
                            <?php endforeach; ?>
                            <div class="border-t border-gray-100 mt-2 pt-2">
                                <a href="/#regions"
                                    class="block px-4 py-2 text-sm font-medium text-primary-600 hover:bg-primary-50">
                                    Voir toutes les régions &rarr;
                                </a>
                            </div>
                        </div>
                    </div>

                    <a href="/#services" class="text-gray-700 hover:text-primary-600 font-medium">Services</a>

                    <a href="/#faq" class="text-gray-700 hover:text-primary-600 font-medium">FAQ</a>

                    <!-- Badge note -->
                    <div
                        class="flex items-center space-x-1 bg-yellow-50 text-yellow-700 px-3 py-1 rounded-full text-sm">
                        <span class="text-yellow-500">&#9733;</span>
                        <span class="font-semibold">4.9/5</span>
                    </div>

                    <!-- CTA -->
                    <a href="<?= getVudUrl() ?>" target="_blank" rel="noopener nofollow"
                        class="bg-primary-600 hover:bg-primary-700 text-white px-5 py-2.5 rounded-lg font-semibold transition-colors shadow-sm">
                        Demander un devis
                    </a>
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden flex items-center">
                    <button @click="mobileMenu = !mobileMenu"
                        class="p-2 rounded-lg text-gray-600 hover:text-gray-900 hover:bg-gray-100">
                        <svg x-show="!mobileMenu" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <svg x-show="mobileMenu" x-cloak class="w-6 h-6" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </nav>

        <!-- Mobile Menu -->
        <div x-show="mobileMenu" x-cloak x-transition class="md:hidden border-t border-gray-100">
            <div class="px-4 py-4 space-y-3">
                <a href="/#regions" class="block py-2 text-gray-700 font-medium">Zones d'intervention</a>
                <a href="/#services" class="block py-2 text-gray-700 font-medium">Nos services</a>
                <a href="/#faq" class="block py-2 text-gray-700 font-medium">Questions fréquentes</a>
                <div class="pt-3 border-t border-gray-100">
                    <a href="<?= getVudUrl() ?>" target="_blank" rel="noopener nofollow"
                        class="block w-full text-center bg-primary-600 hover:bg-primary-700 text-white px-5 py-3 rounded-lg font-semibold transition-colors">
                        Demander un devis gratuit
                    </a>
                </div>
            </div>
        </div>
    </header>

    <main>