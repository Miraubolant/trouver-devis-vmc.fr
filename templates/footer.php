</main>

<!-- Footer -->
<footer class="bg-gray-900 text-gray-300 mt-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <!-- Logo & Description -->
            <div class="md:col-span-1">
                <a href="/" class="flex items-center space-x-2.5 mb-4 group">
                    <div
                        class="w-9 h-9 bg-gradient-to-br from-primary-600 to-accent-500 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M6 2h10a2 2 0 012 2v16a2 2 0 01-2 2H6a2 2 0 01-2-2V4a2 2 0 012-2zm0 2v16h10V4H6zm2 2h6v5H8V6zm0 7h6v5H8v-5zm5 2a1 1 0 110 2 1 1 0 010-2z" />
                        </svg>
                    </div>
                    <span class="font-semibold text-base tracking-tight uppercase">
                        <span class="text-white"><?= SITE_LOGO_TEXT ?></span><span
                            class="text-primary-400"><?= SITE_LOGO_TLD ?></span>
                    </span>
                </a>
                <p class="text-sm text-gray-400 mb-4">
                    <?= SITE_DESCRIPTION ?>
                </p>
                <div class="flex items-center space-x-1 text-sm">
                    <span class="text-yellow-400">&#9733;</span>
                    <span class="font-semibold text-white">4.9/5</span>
                    <span class="text-gray-500">sur +10 000 avis</span>
                </div>
            </div>

            <!-- Navigation -->
            <div>
                <h3 class="text-white font-semibold mb-4">Navigation</h3>
                <ul class="space-y-2 text-sm">
                    <li><a href="/" class="hover:text-white transition-colors">Accueil</a></li>
                    <li><a href="/#regions" class="hover:text-white transition-colors">Toutes les régions</a></li>
                    <li><a href="/#services" class="hover:text-white transition-colors">Nos services</a></li>
                    <li><a href="/#faq" class="hover:text-white transition-colors">FAQ</a></li>
                    <li><a href="<?= getVudUrl() ?>" target="_blank" rel="noopener nofollow"
                            class="hover:text-white transition-colors">Demander un devis</a></li>
                </ul>
            </div>

            <!-- Services -->
            <div>
                <h3 class="text-white font-semibold mb-4">Services</h3>
                <ul class="space-y-2 text-sm">
                    <?php
                    $footerServices = array_slice(SERVICES, 0, 5);
                    foreach ($footerServices as $service):
                        ?>
                        <li><a href="/#services" class="hover:text-white transition-colors"><?= e($service['titre']) ?></a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <!-- Toutes les régions -->
            <div>
                <h3 class="text-white font-semibold mb-4">Nos régions</h3>
                <ul class="space-y-2 text-sm">
                    <?php
                    $regions = getRegions();
                    foreach ($regions as $region):
                        ?>
                        <li>
                            <a href="<?= urlRelative($region['slug'] . '/') ?>" class="hover:text-white transition-colors">
                                <?= e($region['nom']) ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>

        <!-- Modèles / Services -->
        <div class="border-t border-gray-800 mt-8 pt-8">
            <h3 class="text-white font-semibold mb-4">Nos services</h3>
            <div class="flex flex-wrap gap-2">
                <?php
                $firstVille = TOP_VILLES[0] ?? null;
                foreach (MODELES as $footerModele):
                    if ($firstVille):
                        ?>
                        <a href="<?= urlRelative($firstVille['region'] . '/' . $firstVille['dept'] . '/' . $firstVille['slug'] . '-' . $firstVille['cp'] . '/' . $footerModele['slug'] . '/') ?>"
                            class="text-xs bg-gray-800 text-gray-400 hover:text-white hover:bg-gray-700 px-3 py-1 rounded-full transition-colors">
                            <?= $footerModele['emoji'] ?>         <?= e($footerModele['nom']) ?>
                        </a>
                    <?php else: ?>
                        <span class="text-xs bg-gray-800 text-gray-400 px-3 py-1 rounded-full">
                            <?= $footerModele['emoji'] ?>         <?= e($footerModele['nom']) ?>
                        </span>
                        <?php
                    endif;
                endforeach;
                ?>
            </div>
        </div>



        <!-- Bottom bar -->
        <div class="border-t border-gray-800 mt-8 pt-8">
            <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                <div class="text-sm text-gray-500">
                    &copy; <?= date('Y') ?> <?= SITE_NAME ?>. Tous droits réservés.
                </div>
                <div class="flex items-center space-x-6 text-sm">
                    <a href="/mentions-legales/" class="text-gray-500 hover:text-white transition-colors">Mentions
                        légales</a>
                    <a href="/politique-confidentialite/"
                        class="text-gray-500 hover:text-white transition-colors">Confidentialité</a>
                    <a href="/contact/" class="text-gray-500 hover:text-white transition-colors">Contact</a>
                </div>
            </div>
        </div>
    </div>
</footer>

<!-- Floating CTA Button -->
<?php include __DIR__ . '/../components/floating-cta.php'; ?>

<!-- Back to top button -->
<button x-data="{ show: false }" x-show="show" x-cloak @scroll.window="show = window.scrollY > 500"
    @click="window.scrollTo({ top: 0, behavior: 'smooth' })"
    class="fixed bottom-6 right-6 bg-primary-600 hover:bg-primary-700 text-white p-3 rounded-full shadow-lg transition-all z-40">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
    </svg>
</button>

</body>

</html>