<?php
/**
 * Composant FAQ Accordéon
 * Usage: include avec $faqItems = [['question' => '...', 'reponse' => '...'], ...]
 */

if (empty($faqItems)) return;

$faqId = uniqueId('faq');
?>

<section id="faq" class="py-12">
    <div class="max-w-3xl mx-auto">
        <h2 class="text-2xl font-bold text-gray-900 mb-8 text-center">
            Questions fréquentes
        </h2>

        <div class="space-y-4" x-data="{ openItem: null }">
            <?php foreach ($faqItems as $i => $item): ?>
            <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                <button @click="openItem = openItem === <?= $i ?> ? null : <?= $i ?>"
                        class="w-full flex items-center justify-between p-5 text-left hover:bg-gray-50 transition-colors">
                    <span class="font-medium text-gray-900 pr-4"><?= e($item['question']) ?></span>
                    <svg class="w-5 h-5 text-gray-500 flex-shrink-0 transition-transform duration-200"
                         :class="{ 'rotate-180': openItem === <?= $i ?> }"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div x-show="openItem === <?= $i ?>"
                     x-cloak
                     x-collapse
                     class="border-t border-gray-100">
                    <p class="p-5 text-gray-600 leading-relaxed">
                        <?= e($item['reponse']) ?>
                    </p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
