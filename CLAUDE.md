# VintAnnuaire - Template Annuaire SEO Multi-Niche

## Vue d'ensemble

Template d'annuaire SEO français adaptable à n'importe quelle niche de métier. Conçu pour générer un maillage massif de pages géolocalisées pour le référencement naturel.

- **Stack** : PHP 8.2 natif + TailwindCSS (compilé) + Alpine.js
- **Monétisation** : ViteUnDevis (affiliation)
- **Données** : JSON (13 régions, 101 départements, ~10000 villes)
- **Déploiement** : Docker (Coolify self-hosted)

## Guide de démarrage rapide

### 1. Dupliquer le projet
```bash
cp -r VintAnnuaire MonNouveauProjet
cd MonNouveauProjet
```

### 2. Configurer `config.php`
Remplacer tous les `[PLACEHOLDER]` par vos valeurs :

```php
// Site
define('SITE_NAME', 'annuaire-plombier.fr');
define('SITE_DOMAIN', 'annuaire-plombier.fr');
define('SITE_URL', 'https://annuaire-plombier.fr');
define('SITE_EMAIL', 'contact@annuaire-plombier.fr');
define('SITE_TAGLINE', 'Votre Plombier Partout en France');

// Métier
define('METIER', 'plombier');
define('METIER_PLURAL', 'plombiers');
define('METIER_TITLE', 'Plombier');

// ViteUnDevis
define('VUD_PARTENAIRE_ID', '2372');
define('VUD_CATEGORIE_ID', '123');  // Trouver sur viteundevis.com

// Scraping
define('SCRAPE_QUERY', 'plombier dépannage');
define('SCRAPE_API_KEY', 'sk_xxx');
```

### 3. Configurer les contenus

#### MODELES (services/spécialités) — Stratégie de variantes

**Principe clé** : Multiplier les pages en créant des variantes de services sans inventer de nouvelles catégories VUD. Chaque variante réutilise le `vud_cat` de sa catégorie parente. Cela maximise le nombre de combinaisons ville x service pour le SEO tout en gardant la monétisation VUD fonctionnelle.

**Exemple** : La catégorie VUD #128 (Porte d'entrée) génère 6 variantes :
- `porte-d-entree` (générique), `porte-d-entree-aluminium`, `porte-d-entree-pvc`, `porte-d-entree-bois`, `porte-d-entree-vitree`, `porte-d-entree-composite`
- Toutes pointent vers `vud_cat => '128'`

```php
define('MODELES', [
    ['slug' => 'porte-d-entree', 'nom' => "Porte d'Entrée", 'emoji' => '🚪', 'vud_cat' => '128'],
    ['slug' => 'porte-d-entree-aluminium', 'nom' => "Porte d'Entrée Aluminium", 'emoji' => '🚪', 'vud_cat' => '128'],
    // ... variantes par catégorie VUD (8 catégories → 40 variantes)
]);
```

**Catégories VUD et nombre de variantes** :
| Catégorie VUD | ID | Variantes |
|--------------|-----|-----------|
| Porte d'entrée | #128 | 6 (alu, PVC, bois, vitrée, composite) |
| Porte de garage | #108 | 6 (sectionnelle, enroulable, battante, basculante, motorisée) |
| Porte blindée | #96 | 5 (appartement, maison, blindage, A2P) |
| Portes intérieures | #137 | 6 (coulissante, battante, pliante, galandage, verrière) |
| Serrurerie | #165 | 6 (changement, multipoints, cylindre, ouverture, connectée) |
| Portail | #71 | 6 (coulissant, battant, aluminium, motorisation, fer forgé) |
| Visiophone | #74 | 3 (connecté, sans fil) |
| Interphone | #73 | 3 (vidéo, collectif) |

#### STYLES (6 blocs page accueil)
```php
define('STYLES', [
    ['slug' => 'urgence', 'nom' => 'Urgence 24/7', 'emoji' => '🆘', 'desc' => 'Intervention rapide'],
    // ... 6 styles max
]);
```

#### SERVICES (3 blocs descriptifs)
```php
define('SERVICES', [
    [
        'titre' => 'Dépannage',
        'icon' => '🔧',
        'desc' => 'Intervention rapide...',
        'points' => ['Point 1', 'Point 2', 'Point 3']
    ],
    // ... 3 services
]);
```

#### FAQ_ACCUEIL (10 questions)
```php
define('FAQ_ACCUEIL', [
    ['question' => 'Combien coûte...?', 'reponse' => 'Le prix...'],
    // ... 10 questions
]);
```

### 4. Scraper les artisans
```bash
cd scripts
node scrape-artisans.js --query="plombier dépannage" --key="sk_xxx"
```

### 5. Lancer le site
```bash
npm install
npm run build:css
docker-compose up -d
```

## Configuration complète (config.php)

| Constante | Description | Exemple |
|-----------|-------------|---------|
| `SITE_NAME` | Nom du site | `annuaire-plombier.fr` |
| `SITE_DOMAIN` | Domaine sans https | `annuaire-plombier.fr` |
| `SITE_URL` | URL complète | `https://annuaire-plombier.fr` |
| `SITE_EMAIL` | Email contact | `contact@annuaire-plombier.fr` |
| `SITE_TAGLINE` | Slogan | `Votre Plombier Partout en France` |
| `SITE_DESCRIPTION` | Meta description (160 car.) | `Trouvez un plombier...` |
| `METIER` | Métier singulier minuscule | `plombier` |
| `METIER_PLURAL` | Métier pluriel | `plombiers` |
| `METIER_TITLE` | Métier avec majuscule | `Plombier` |
| `METIER_ICON` | Icône de référence | `wrench` |
| `VUD_PARTENAIRE_ID` | ID partenaire ViteUnDevis | `2372` |
| `VUD_CATEGORIE_ID` | ID catégorie ViteUnDevis | `44` |
| `SCRAPE_QUERY` | Requête Google Maps | `plombier dépannage` |
| `SCRAPE_API_KEY` | Clé API SemScraper | `sk_xxx` |
| `HERO_IMAGE` | URL image hero | `https://unsplash.com/...` |
| `MODELE_IMAGE` | URL image modèle | `https://unsplash.com/...` |


### Fonctionnement
1. Charge les départements depuis `data/departements/`
2. Pour chaque département, recherche sur Google Maps via SemScraper
3. Filtre les résultats par mot-clé pertinent
4. Sauvegarde dans `data/artisans/{code_dept}.json`
5. Fichier de progression pour reprise si interruption

### Gestion des erreurs
- Retry automatique avec backoff exponentiel (erreurs 502/503/504)
- Fichier de progression `scrape-artisans-progress.json`
- Option `--resume` pour reprendre

## Structure des URLs

| Route | Pattern | Exemple |
|-------|---------|---------|
| Accueil | `/` | `/` |
| Contact | `/contact/` | `/contact/` |
| Mentions légales | `/mentions-legales/` | `/mentions-legales/` |
| Confidentialité | `/politique-confidentialite/` | `/politique-confidentialite/` |
| Service | `/services/{modele-slug}/` | `/services/portail/` |
| Région | `/{region}/` | `/provence-alpes-cote-d-azur/` |
| Département | `/{region}/{dept}/` | `/provence-alpes-cote-d-azur/bouches-du-rhone/` |
| Ville | `/{region}/{dept}/{ville-CP}/` | `/provence-alpes-cote-d-azur/bouches-du-rhone/marseille-13000/` |
| Modèle | `/{region}/{dept}/{ville-CP}/{modele}/` | `.../marseille-13000/porte-d-entree/` |
| Artisan | `/{region}/{dept}/{ville-CP}/artisans/{slug}/` | `.../marseille-13000/artisans/martin-serrurerie/` |

## Maillage interne (SEO)

### Schéma global du maillage

```
Accueil (/)
├── STYLES (8 blocs) ──────────► Pages Service (/services/{slug}/)
│                                 ├── Recherche ville → redirige vers /{region}/{dept}/{ville-CP}/{modele}/
│                                 ├── 13 régions (liens vers /{region}/)
│                                 ├── TOP_VILLES (18 liens directs vers /{region}/{dept}/{ville-CP}/{modele}/)
│                                 └── Autres services (cross-links entre /services/)
│
├── TOP_VILLES (18) ───────────► Pages Ville (/{region}/{dept}/{ville-CP}/)
├── Régions (6 mises en avant) ► Pages Région (/{region}/)
│
Pages Région (/{region}/)
├── Départements (~10) ────────► Pages Département (/{region}/{dept}/)
│
Pages Département (/{region}/{dept}/)
├── Toutes les villes ─────────► Pages Ville (/{region}/{dept}/{ville-CP}/)
├── 6 départements voisins ────► Pages Département voisins
├── N modèles/services ────────► Pages Modèle (/{region}/{dept}/{ville-CP}/{modele}/)
│
Pages Ville (/{region}/{dept}/{ville-CP}/)
├── N modèles/services ────────► Pages Modèle (/{region}/{dept}/{ville-CP}/{modele}/)
├── 100 villes proches ────────► Pages Ville voisines
├── Artisans locaux ───────────► Pages Artisan (/{region}/{dept}/{ville-CP}/artisans/{slug}/)
│
Pages Modèle (/{region}/{dept}/{ville-CP}/{modele}/)
├── Autres modèles (N-1) ─────► Pages Modèle même ville
├── 100 villes proches ────────► Pages Modèle villes voisines (même modèle)
├── Artisans locaux ───────────► Pages Artisan
│
Pages Artisan (/{region}/{dept}/{ville-CP}/artisans/{slug}/)
├── Retour ville ──────────────► Page Ville
├── Autres artisans ───────────► Pages Artisan même ville
```

### Multiplicateur de pages (variantes x villes)

Avec 40 MODELES et ~35 000 villes, le site génère ~1 500 000 pages modèle uniques, en plus des pages ville, département et région. Chaque variante utilise le `vud_cat` de sa catégorie parente (8 catégories VUD seulement). Ne jamais inventer de nouvelles catégories VUD, uniquement créer des variantes de slug/nom.

### Détail par type de page

| Page | Liens sortants internes | Volume estimé |
|------|------------------------|---------------|
| **Accueil** | 8 STYLES + 18 TOP_VILLES + 6 régions + FAQ | ~32 liens |
| **Service** (`/services/{slug}/`) | 13 régions + 18 TOP_VILLES (vers modèle) + 39 autres services + recherche contextuelle | ~70 liens |
| **Région** | ~10 départements + breadcrumb | ~12 liens |
| **Département** | toutes villes (paginées) + 6 dept voisins + 40 modèles + breadcrumb | ~80+ liens |
| **Ville** | 8 STYLES (hero) + 40 modèles (section) + 100 villes proches + artisans + breadcrumb | ~150+ liens |
| **Modèle** | 39 autres modèles + 100 villes proches (même modèle) + artisans + breadcrumb | ~140+ liens |
| **Artisan** | retour ville + autres artisans + breadcrumb | ~10+ liens |

### Recherche autocomplete contextuelle

Le composant `search-autocomplete.php` supporte un suffixe d'URL via `$searchUrlSuffix` :
- **Pages classiques** (accueil, région, etc.) : redirige vers `/{region}/{dept}/{ville-CP}/`
- **Pages service** (`/services/{slug}/`) : redirige vers `/{region}/{dept}/{ville-CP}/{modele-slug}/` via `$searchUrlSuffix = $modele['slug'] . '/'`

### Cross-linking réseau partenaire

`NETWORK_SITES` dans `config.php` : 11 annuaires habitat partenaires affichés en footer (dofollow, `rel="noopener"`). Le site courant est automatiquement exclu via `parse_url()` + `SITE_DOMAIN`.

### Contenu anti-duplicate

- `getRegionIntroContent($regionSlug)` : texte d'introduction unique par région (hash-based)
- `getDeptIntroContent($deptSlug)` : texte d'introduction unique par département (hash-based)

## Structure des fichiers

```
├── config.php           # ⚡ CONFIGURATION PRINCIPALE
├── functions.php        # Helpers et fonctions utilitaires
├── index.php            # Page d'accueil
├── router.php           # Routeur principal
├── sitemap.php          # Générateur de sitemaps
├── robots.php           # Robots.txt dynamique
├── .htaccess            # URL rewriting Apache
├── docker-compose.yml   # Configuration Docker
├── Dockerfile           # Image PHP/Apache + Node.js
├── package.json         # Dépendances npm (Tailwind)
├── tailwind.config.js   # Configuration Tailwind
│
├── scripts/             # Scripts utilitaires
│   └── scrape-artisans.js  # Scraping Google Maps
│
├── src/                 # Sources CSS
│   └── input.css        # CSS source Tailwind
│
├── assets/              # Assets statiques
│   ├── css/style.css    # CSS compilé
│   └── img/
│
├── templates/           # Templates de base
│   ├── header.php
│   ├── footer.php
│   └── 404.php
│
├── components/          # Composants réutilisables
│   ├── breadcrumb.php
│   ├── pagination.php
│   ├── cta-devis.php
│   ├── hero-devis-form.php
│   ├── card-*.php
│   ├── faq.php
│   ├── floating-cta.php
│   └── search-autocomplete.php
│
├── pages/               # Pages dynamiques
│   ├── service.php          # Landing page par service (/services/{slug}/)
│   ├── region.php
│   ├── departement.php
│   ├── ville.php
│   ├── modele.php
│   ├── artisan.php
│   ├── contact.php
│   ├── mentions-legales.php
│   └── politique-confidentialite.php
│
├── api/                 # API
│   └── search.php       # Autocomplete villes
│
└── data/                # Données JSON
    ├── regions/regions.json
    ├── departements/{code}.json
    ├── villes/{slug-CP}.json
    ├── artisans/{code_dept}.json  # Généré par scraping
    └── stats.json
```

## Données JSON

### regions/regions.json
```json
[{
  "id": 19,
  "code": "18",
  "nom": "Provence-Alpes-Côte d'Azur",
  "slug": "provence-alpes-cote-d-azur",
  "departements": [...],
  "departements_count": 6
}]
```

### departements/{code}.json
```json
{
  "departement": { "code": "13", "nom": "Bouches-du-Rhône", "slug": "bouches-du-rhone" },
  "region": { ... },
  "voisins": [...],
  "villes": [{ "id", "nom_standard", "slug_ville", "code_postal", "population" }]
}
```

### villes/{slug-CP}.json
```json
{
  "ville": { ..., "latitude": 43.2965, "longitude": 5.3698 },
  "departement": { ... },
  "region": { ... },
  "villes_proches": [{ ..., "distance_km": 9.12 }]
}
```

### artisans/{code_dept}.json (généré)
```json
{
  "marseille": {
    "artisans": [{
      "id": "123",
      "nom": "Martin Plomberie",
      "slug": "martin-plomberie",
      "telephone": "+33 4 91 21 94 79",
      "note": 4.2,
      "avis": 173,
      "type": "Plumber"
    }]
  }
}
```

## Fonctions utilitaires (functions.php)

```php
// Données
getRegions()                    // Liste des 13 régions
getRegion($slug)                // Une région par slug
getDepartements($regionSlug)    // Départements d'une région
getVilles($deptCode)            // Villes d'un département
getVille($deptCode, $villeSlug) // Une ville

// URLs
urlRelative($path)              // URL relative depuis racine
urlVille($region, $dept, $ville, $cp) // URL complète ville

// SEO
seoTitle($title)                // Génère title avec SITE_NAME
seoDescription($desc)           // Limite à 160 caractères
jsonLdOrganization()            // JSON-LD Organization
jsonLdBreadcrumb($items)        // JSON-LD BreadcrumbList
jsonLdFAQ($items)               // JSON-LD FAQPage

// Affichage
renderStars($note)              // Étoiles SVG pour notes
formatTelephone($tel)           // Format téléphone français
e($string)                      // htmlspecialchars()

// Config
getModeleBySlug($slug)          // Un modèle par slug
getAllModeles()                  // Tous les modèles
getVudUrl($modele)              // URL ViteUnDevis (catégorie dynamique par modèle)
getVudCatForModele($modele)     // ID catégorie VUD selon le modèle (champ vud_cat)

// Contenu anti-duplicate
getRegionIntroContent($slug)    // Intro unique par région (hash-based)
getDeptIntroContent($slug)      // Intro unique par département (hash-based)
getRegionDeptSlugs($region, $dept) // Slugs région/dept pour URLs villes proches
```

## Tailwind CSS

### Commandes
```bash
npm install              # Installer dépendances
npm run build:css        # Build production (minifié)
npm run watch:css        # Mode développement (watch)
```

### Personnalisation couleurs
Modifier `tailwind.config.js` :
```js
theme: {
  extend: {
    colors: {
      primary: colors.blue,    // Changer la couleur principale
      accent: colors.cyan,     // Changer l'accent
    }
  }
}
```

Puis rebuilder : `npm run build:css`

## Docker

### Démarrer
```bash
docker-compose up -d
```
Accès : http://localhost:8000

### Commandes
```bash
docker-compose logs -f          # Voir les logs
docker-compose down             # Arrêter
docker-compose up -d --build    # Rebuild après modif
```

## Monétisation ViteUnDevis

### Trouver votre catégorie
1. Aller sur https://www.viteundevis.com/
2. Naviguer vers votre catégorie de métier
3. Noter l'ID de catégorie dans l'URL

### Catégories courantes
| Métier | ID Catégorie |
|--------|--------------|
| Piscine | 44 |
| Isolation | 12 |
| Débouchage | 61 |
| Plomberie | 20 |
| Électricité | 15 |
| Chauffage | 11 |

### URL d'affiliation
```
https://www.viteundevis.com/in/?pid={VUD_PARTENAIRE_ID}&c={VUD_CATEGORIE_ID}
```

## SEO

- **JSON-LD** : Organization, FAQPage, Service, LocalBusiness, BreadcrumbList
- **Meta** : Title, Description, Canonical, Open Graph
- **Sitemaps** : Index + sitemap par département

## Checklist nouveau projet

- [ ] Dupliquer VintAnnuaire
- [ ] Configurer `config.php` (SITE_*, METIER_*, VUD_*)
- [ ] Définir MODELES (services/spécialités)
- [ ] Définir STYLES (6 blocs accueil)
- [ ] Définir SERVICES (3 blocs descriptifs)
- [ ] Définir FAQ_ACCUEIL (10 questions)
- [ ] Définir TOP_VILLES (18 villes)
- [ ] Personnaliser couleurs Tailwind si besoin
- [ ] Choisir images hero/modele (Unsplash)
- [ ] Lancer scraping artisans
- [ ] Build CSS : `npm run build:css`
- [ ] Tester localement : `docker-compose up -d`
- [ ] Déployer

## Exemples de niches

### Pisciniste
```php
define('METIER', 'pisciniste');
define('VUD_CATEGORIE_ID', '44');
define('SCRAPE_QUERY', 'pisciniste construction piscine');
define('MODELES', [
    ['slug' => 'piscine-coque', 'nom' => 'Piscine Coque', 'emoji' => '🏊'],
    ['slug' => 'piscine-beton', 'nom' => 'Piscine Béton', 'emoji' => '🧱'],
    // ...
]);
```

### Isolation
```php
define('METIER', 'isolateur');
define('VUD_CATEGORIE_ID', '12');
define('SCRAPE_QUERY', 'isolation thermique RGE entreprise');
define('MODELES', [
    ['slug' => 'isolation-combles', 'nom' => 'Isolation Combles', 'emoji' => '🏠'],
    ['slug' => 'isolation-murs', 'nom' => 'Isolation Murs', 'emoji' => '🧱'],
    // ...
]);
```

### Débouchage
```php
define('METIER', 'déboucheur');
define('VUD_CATEGORIE_ID', '61');
define('SCRAPE_QUERY', 'débouchage canalisation');
define('MODELES', [
    ['slug' => 'debouchage-wc', 'nom' => 'Débouchage WC', 'emoji' => '🚽'],
    ['slug' => 'debouchage-evier', 'nom' => 'Débouchage Évier', 'emoji' => '🚰'],
    // ...
]);
```
