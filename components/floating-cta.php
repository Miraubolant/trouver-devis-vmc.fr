<?php
/**
 * Composant Bouton Flottant CTA - Demander un devis
 * Affiché en bas de l'écran (mobile friendly)
 */

$vudUrl = getVudUrl($modele ?? null);
?>

<!-- Floating CTA Button (visible on scroll) -->
<div x-data="{ visible: false }"
     x-show="visible"
     x-cloak
     @scroll.window="visible = window.scrollY > 300"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0 translate-y-4"
     x-transition:enter-end="opacity-100 translate-y-0"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100 translate-y-0"
     x-transition:leave-end="opacity-0 translate-y-4"
     class="fixed bottom-0 left-0 right-0 z-50 p-4 bg-gradient-to-t from-white via-white to-transparent md:hidden">
    <a href="<?= $vudUrl ?>"
       target="_blank"
       rel="noopener nofollow"
       class="flex items-center justify-center w-full px-6 py-4 bg-gradient-to-r from-primary-600 to-primary-700 text-white font-bold rounded-xl shadow-xl hover:from-primary-700 hover:to-primary-800 transition-all">
        <span class="mr-2 text-lg">&#128682;</span>
        Demander mon devis gratuit
        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
        </svg>
    </a>
</div>

<!-- Desktop floating button (bottom right) -->
<div x-data="{ visible: false }"
     x-show="visible"
     x-cloak
     @scroll.window="visible = window.scrollY > 500"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0 scale-90"
     x-transition:enter-end="opacity-100 scale-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100 scale-100"
     x-transition:leave-end="opacity-0 scale-90"
     class="hidden md:block fixed bottom-6 left-6 z-50">
    <a href="<?= $vudUrl ?>"
       target="_blank"
       rel="noopener nofollow"
       class="flex items-center px-6 py-3 bg-gradient-to-r from-primary-600 to-primary-700 text-white font-semibold rounded-full shadow-xl hover:from-primary-700 hover:to-primary-800 transition-all hover:shadow-2xl hover:scale-105">
        <span class="mr-2">&#128682;</span>
        Demander mon devis gratuit
    </a>
</div>
