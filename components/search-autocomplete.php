<?php
/**
 * Composant Recherche avec Autocomplete
 * Usage: include avec optionnel $searchPlaceholder
 */

$placeholder = $searchPlaceholder ?? "Rechercher une ville...";
$urlSuffix = $searchUrlSuffix ?? '';
$searchId = uniqueId('search');
?>

<div x-data="{
    query: '',
    results: [],
    loading: false,
    showResults: false,
    selectedIndex: -1,

    async search() {
        if (this.query.length < 2) {
            this.results = [];
            this.showResults = false;
            return;
        }

        this.loading = true;
        this.showResults = true;

        try {
            const response = await fetch('/api/search.php?q=' + encodeURIComponent(this.query));
            this.results = await response.json();
        } catch (e) {
            this.results = [];
        }

        this.loading = false;
    },

    urlSuffix: '<?= e($urlSuffix) ?>',

    selectResult(result) {
        window.location.href = result.url + this.urlSuffix;
    },

    handleKeydown(e) {
        if (!this.showResults || this.results.length === 0) return;

        if (e.key === 'ArrowDown') {
            e.preventDefault();
            this.selectedIndex = Math.min(this.selectedIndex + 1, this.results.length - 1);
        } else if (e.key === 'ArrowUp') {
            e.preventDefault();
            this.selectedIndex = Math.max(this.selectedIndex - 1, 0);
        } else if (e.key === 'Enter' && this.selectedIndex >= 0) {
            e.preventDefault();
            this.selectResult(this.results[this.selectedIndex]);
        } else if (e.key === 'Escape') {
            this.showResults = false;
            this.selectedIndex = -1;
        }
    }
}"
     @click.away="showResults = false"
     class="relative w-full max-w-xl mx-auto">

    <div class="relative">
        <input type="text"
               x-model="query"
               @input.debounce.300ms="search()"
               @focus="if (results.length > 0) showResults = true"
               @keydown="handleKeydown"
               placeholder="<?= e($placeholder) ?>"
               class="w-full px-5 py-4 pr-12 text-lg bg-white border-2 border-gray-200 rounded-xl focus:border-primary-500 focus:ring-4 focus:ring-primary-100 outline-none transition-all shadow-sm">

        <div class="absolute right-4 top-1/2 -translate-y-1/2">
            <svg x-show="!loading" class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <svg x-show="loading" x-cloak class="w-6 h-6 text-primary-500 animate-spin" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        </div>
    </div>

    <!-- Results dropdown -->
    <div x-show="showResults && (results.length > 0 || (query.length >= 2 && !loading))"
         x-cloak
         x-transition
         class="absolute top-full left-0 right-0 mt-2 bg-white rounded-xl shadow-xl border border-gray-200 overflow-hidden z-50 max-h-96 overflow-y-auto">

        <template x-if="results.length > 0">
            <ul>
                <template x-for="(result, index) in results" :key="result.url">
                    <li>
                        <button @click="selectResult(result)"
                                @mouseenter="selectedIndex = index"
                                :class="{ 'bg-primary-50': selectedIndex === index }"
                                class="w-full flex items-center px-5 py-3 hover:bg-gray-50 transition-colors text-left">
                            <div class="flex-shrink-0 w-10 h-10 rounded-lg bg-primary-100 text-primary-600 flex items-center justify-center mr-4">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-medium text-gray-900 truncate" x-text="result.nom"></p>
                                <p class="text-sm text-gray-500" x-text="result.cp + ' - ' + result.dept"></p>
                            </div>
                        </button>
                    </li>
                </template>
            </ul>
        </template>

        <template x-if="results.length === 0 && query.length >= 2 && !loading">
            <div class="px-5 py-8 text-center text-gray-500">
                <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p>Aucune ville trouvée pour "<span x-text="query"></span>"</p>
            </div>
        </template>
    </div>
</div>
