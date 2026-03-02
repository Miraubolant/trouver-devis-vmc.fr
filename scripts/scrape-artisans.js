/**
 * ============================================
 * SCRIPT GENERIQUE D'EXTRACTION D'ARTISANS
 * ============================================
 *
 * Usage:
 *   node scrape-artisans.js --query="isolation RGE" --key="sk_xxx"
 *   node scrape-artisans.js --query="pisciniste construction" --key="sk_xxx"
 *   node scrape-artisans.js --query="débouchage canalisation" --key="sk_xxx"
 *
 * Options:
 *   --query    Requête de recherche Google Maps (obligatoire)
 *   --key      Clé API SemScraper (obligatoire)
 *   --output   Dossier de sortie (défaut: data/artisans)
 *   --batch    Taille des batches (défaut: 50)
 *   --resume   Reprendre depuis le fichier de progression
 */

const fs = require('fs');
const path = require('path');
const https = require('https');

// ============================================
// PARSE ARGUMENTS
// ============================================
function parseArgs() {
    const args = {};
    process.argv.slice(2).forEach(arg => {
        const [key, value] = arg.replace(/^--/, '').split('=');
        args[key] = value || true;
    });
    return args;
}

const ARGS = parseArgs();

// Validation des arguments obligatoires
if (!ARGS.query) {
    console.error('Erreur: --query est obligatoire');
    console.error('Usage: node scrape-artisans.js --query="isolation RGE" --key="sk_xxx"');
    process.exit(1);
}

if (!ARGS.key) {
    console.error('Erreur: --key (clé API SemScraper) est obligatoire');
    console.error('Usage: node scrape-artisans.js --query="isolation RGE" --key="sk_xxx"');
    process.exit(1);
}

// ============================================
// CONFIGURATION
// ============================================
const CONFIG = {
    API_KEY: ARGS.key,
    API_BASE: 'api.semscraper.com',

    // Requête de recherche
    SEARCH_QUERY: ARGS.query,
    SEARCH_ENGINE: 'google_maps',
    DEPTH: 1,

    // Chemins
    DATA_DIR: path.join(__dirname, '..', 'data'),
    OUTPUT_DIR: path.join(__dirname, '..', ARGS.output || 'data/artisans'),
    PROGRESS_FILE: path.join(__dirname, 'scrape-progress.json'),

    // Rate limiting
    BATCH_SIZE: parseInt(ARGS.batch) || 50,
    DELAY_BETWEEN_BATCHES: 5000,
    POLL_INTERVAL: 6000,
    MAX_POLL_ATTEMPTS: 20,
    MAX_STUCK_POLLS: 4,

    // Retry configuration
    MAX_RETRIES: 3,
    RETRY_DELAY: 10000,
    RETRY_BACKOFF: 1.5,

    // Localisation
    LOCATION: 'fr',
    LANGUAGE: 'fr'
};

// ============================================
// HELPERS
// ============================================

function sleep(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
}

function slugify(text) {
    return text
        .toString()
        .normalize('NFD')
        .replace(/[\u0300-\u036f]/g, '')
        .toLowerCase()
        .trim()
        .replace(/[^a-z0-9\s-]/g, '')
        .replace(/[\s_]+/g, '-')
        .replace(/-+/g, '-')
        .replace(/^-+|-+$/g, '');
}

function loadJSON(filePath) {
    try {
        return JSON.parse(fs.readFileSync(filePath, 'utf8'));
    } catch (e) {
        return null;
    }
}

function saveJSON(filePath, data) {
    fs.writeFileSync(filePath, JSON.stringify(data, null, 2), 'utf8');
}

// Extraire le premier mot de la requête pour le filtre
function getQueryKeyword() {
    return CONFIG.SEARCH_QUERY.split(' ')[0].toLowerCase();
}

// ============================================
// API SEMSCRAPER AVEC RETRY
// ============================================

async function apiRequestWithRetry(method, endpoint, data = null, retryCount = 0) {
    try {
        return await apiRequest(method, endpoint, data);
    } catch (error) {
        if (retryCount < CONFIG.MAX_RETRIES &&
            (error.message.includes('502') ||
             error.message.includes('503') ||
             error.message.includes('504') ||
             error.message.includes('Parse error'))) {

            const delay = CONFIG.RETRY_DELAY * Math.pow(CONFIG.RETRY_BACKOFF, retryCount);
            console.log(`  ⟳ Retry ${retryCount + 1}/${CONFIG.MAX_RETRIES} après ${delay/1000}s...`);
            await sleep(delay);
            return apiRequestWithRetry(method, endpoint, data, retryCount + 1);
        }
        throw error;
    }
}

function apiRequest(method, endpoint, data = null) {
    return new Promise((resolve, reject) => {
        const options = {
            hostname: CONFIG.API_BASE,
            path: endpoint,
            method: method,
            headers: {
                'Authorization': `Bearer ${CONFIG.API_KEY}`,
                'Content-Type': 'application/json'
            },
            timeout: 30000
        };

        const req = https.request(options, (res) => {
            let body = '';
            res.on('data', chunk => body += chunk);
            res.on('end', () => {
                try {
                    const json = JSON.parse(body);
                    if (res.statusCode >= 400) {
                        reject(new Error(`API Error ${res.statusCode}: ${JSON.stringify(json)}`));
                    } else {
                        resolve(json);
                    }
                } catch (e) {
                    reject(new Error(`Parse error (${res.statusCode}): ${body.substring(0, 200)}`));
                }
            });
        });

        req.on('error', reject);
        req.on('timeout', () => {
            req.destroy();
            reject(new Error('Request timeout'));
        });

        if (data) {
            req.write(JSON.stringify(data));
        }
        req.end();
    });
}

async function createSerpRequests(cities) {
    const requests = cities.map(city => ({
        search_engine: CONFIG.SEARCH_ENGINE,
        keyword: `${CONFIG.SEARCH_QUERY} ${city.nom}`,
        depth: CONFIG.DEPTH,
        location: CONFIG.LOCATION,
        language: CONFIG.LANGUAGE,
        geolocation: `${city.nom}, ${city.departement}, France`,
        priority: 5
    }));

    console.log(`  Envoi de ${requests.length} requêtes...`);
    const response = await apiRequestWithRetry('POST', '/v1/serp', requests);
    return response;
}

async function getPendingSerpIds() {
    const response = await apiRequestWithRetry('GET', '/v1/serp');
    return response;
}

async function getSerpResults(ids) {
    const idsString = ids.join(',');
    const response = await apiRequestWithRetry('GET', `/v1/serp?ids=${idsString}&output=json`);
    return response;
}

async function checkStatus() {
    const response = await apiRequestWithRetry('GET', '/v1/serp/status');
    return response;
}

async function checkCredit() {
    const response = await apiRequestWithRetry('GET', '/v1/billing/credit');
    return response;
}

// ============================================
// EXTRACTION DES ARTISANS
// ============================================

function extractArtisansFromResults(apiResponse) {
    const extracted = {};
    const results = apiResponse?.data || apiResponse || [];
    const queryKeyword = getQueryKeyword();

    for (const result of results) {
        if (!result.results || !Array.isArray(result.results) || result.results.length === 0) continue;

        const items = result.results[0]?.items || [];
        if (items.length === 0) continue;

        const keyword = result.keyword || '';
        const cityName = keyword.replace(CONFIG.SEARCH_QUERY, '').trim();
        const citySlug = slugify(cityName);

        if (!citySlug) continue;

        const artisans = [];

        for (const place of items.slice(0, 10)) {
            const artisan = {
                id: place.cid || String(Date.now() + Math.random()),
                nom: place.title || 'Inconnu',
                slug: slugify(place.title || 'inconnu'),
                telephone: null,
                site_web: place.website || null,
                adresse: place.address || null,
                note: place.rating ? parseFloat(place.rating) : null,
                avis: place.reviews ? parseInt(place.reviews) : null,
                type: place.type || CONFIG.SEARCH_QUERY
            };

            artisans.push(artisan);
        }

        if (artisans.length > 0) {
            extracted[citySlug] = { artisans };
        }
    }

    return extracted;
}

// ============================================
// TRAITEMENT PAR DÉPARTEMENT
// ============================================

async function processBatchWithRetry(batch, batchNum, maxRetries = 2) {
    const queryKeyword = getQueryKeyword();

    for (let attempt = 0; attempt <= maxRetries; attempt++) {
        try {
            if (attempt > 0) {
                console.log(`  ⟳ Tentative ${attempt + 1}/${maxRetries + 1} pour batch ${batchNum}`);
                await sleep(CONFIG.RETRY_DELAY * attempt);
            }

            await createSerpRequests(batch);
            console.log(`  ✓ Requêtes envoyées`);

            let attempts = 0;
            let allResults = [];
            let lastProcessing = -1;
            let stuckCount = 0;

            while (attempts < CONFIG.MAX_POLL_ATTEMPTS) {
                await sleep(CONFIG.POLL_INTERVAL);
                attempts++;

                try {
                    const statusResponse = await checkStatus();
                    const statusData = statusResponse.data || [];
                    const doneNotFetched = statusData.find(s => s.status === 'done' && s.fetched === false)?.count || 0;
                    const processing = statusData.find(s => s.status === 'processing')?.count || 0;
                    const pending = statusData.find(s => s.status === 'pending')?.count || 0;

                    console.log(`  Poll ${attempts}/${CONFIG.MAX_POLL_ATTEMPTS} - Ready: ${doneNotFetched}, Proc: ${processing}, Pend: ${pending}`);

                    const pendingResponse = await getPendingSerpIds();
                    const pendingIds = pendingResponse?.data || [];

                    if (pendingIds.length > 0) {
                        // Filtrer par le premier mot de la requête
                        const matchingIds = pendingIds
                            .filter(r => r.keyword && r.keyword.toLowerCase().includes(queryKeyword))
                            .map(r => r.id)
                            .slice(0, 100);

                        if (matchingIds.length > 0) {
                            const batchResults = await getSerpResults(matchingIds);
                            if (batchResults?.data) {
                                allResults = allResults.concat(batchResults.data);
                            }
                        }
                    }

                    if (processing === 0 && pending === 0 && doneNotFetched === 0) {
                        break;
                    }

                    if (processing === lastProcessing && processing <= 5) {
                        stuckCount++;
                        if (stuckCount >= CONFIG.MAX_STUCK_POLLS) {
                            console.log(`  → Processing bloqué à ${processing}, on continue`);
                            break;
                        }
                    } else {
                        stuckCount = 0;
                    }
                    lastProcessing = processing;

                } catch (pollError) {
                    console.log(`  ⚠ Erreur poll: ${pollError.message.substring(0, 50)}...`);
                }
            }

            const extracted = extractArtisansFromResults({ data: allResults });
            const count = Object.values(extracted).reduce((sum, v) => sum + v.artisans.length, 0);

            if (count > 0) {
                console.log(`  ✓ ${count} artisans extraits de ${Object.keys(extracted).length} villes`);
                return extracted;
            } else if (attempt < maxRetries) {
                console.log(`  ⚠ Aucun résultat, nouvelle tentative...`);
            }

        } catch (error) {
            console.error(`  ✗ Erreur batch: ${error.message}`);
            if (attempt >= maxRetries) {
                return {};
            }
        }
    }

    return {};
}

async function processDepartment(deptCode, deptData) {
    console.log(`\n${'='.repeat(50)}`);
    console.log(`Département ${deptCode}: ${deptData.departement.nom}`);
    console.log(`${deptData.villes.length} villes`);
    console.log('='.repeat(50));

    const departmentResults = {};
    const cities = deptData.villes.map(v => ({
        nom: v.nom_standard,
        slug: v.slug_ville,
        departement: deptData.departement.nom
    }));

    for (let i = 0; i < cities.length; i += CONFIG.BATCH_SIZE) {
        const batch = cities.slice(i, i + CONFIG.BATCH_SIZE);
        const batchNum = Math.floor(i / CONFIG.BATCH_SIZE) + 1;
        const totalBatches = Math.ceil(cities.length / CONFIG.BATCH_SIZE);

        console.log(`\n  Batch ${batchNum}/${totalBatches} (${batch.length} villes)  [${deptData.departement.nom}]`);

        const batchResults = await processBatchWithRetry(batch, batchNum);
        Object.assign(departmentResults, batchResults);

        if (i + CONFIG.BATCH_SIZE < cities.length) {
            console.log(`  ⏳ Pause ${CONFIG.DELAY_BETWEEN_BATCHES/1000}s...`);
            await sleep(CONFIG.DELAY_BETWEEN_BATCHES);
        }
    }

    return departmentResults;
}

// ============================================
// MAIN
// ============================================

async function main() {
    console.log('╔══════════════════════════════════════════════════╗');
    console.log('║  EXTRACTION ARTISANS - SCRIPT GÉNÉRIQUE          ║');
    console.log('╚══════════════════════════════════════════════════╝');
    console.log(`\nRequête: "${CONFIG.SEARCH_QUERY}"`);
    console.log(`Output: ${CONFIG.OUTPUT_DIR}`);

    try {
        const creditResponse = await checkCredit();
        const balance = creditResponse.data?.[0]?.balance || 0;
        console.log(`Crédit disponible: ${balance}€`);
    } catch (e) {
        console.log(`Impossible de vérifier le crédit: ${e.message}`);
    }

    if (!fs.existsSync(CONFIG.OUTPUT_DIR)) {
        fs.mkdirSync(CONFIG.OUTPUT_DIR, { recursive: true });
    }

    const progress = loadJSON(CONFIG.PROGRESS_FILE) || { completedDepartments: [], failedDepartments: [] };
    if (!progress.failedDepartments) progress.failedDepartments = [];

    console.log(`\nDépartements déjà traités: ${progress.completedDepartments.length}`);

    const deptFiles = fs.readdirSync(path.join(CONFIG.DATA_DIR, 'departements'))
        .filter(f => f.endsWith('.json'))
        .map(f => f.replace('.json', ''))
        .filter(d => !progress.completedDepartments.includes(d));

    console.log(`Départements restants: ${deptFiles.length}\n`);

    let totalArtisans = 0;
    let successCount = 0;
    let failCount = 0;

    for (const deptCode of deptFiles) {
        try {
            const deptFile = path.join(CONFIG.DATA_DIR, 'departements', `${deptCode}.json`);
            const deptData = loadJSON(deptFile);

            if (!deptData || !deptData.villes) {
                console.log(`[SKIP] Pas de données pour ${deptCode}`);
                continue;
            }

            const results = await processDepartment(deptCode, deptData);
            const count = Object.values(results).reduce((sum, v) => sum + v.artisans.length, 0);

            if (count > 0) {
                totalArtisans += count;
                successCount++;

                const outputFile = path.join(CONFIG.OUTPUT_DIR, `${deptCode}.json`);
                saveJSON(outputFile, results);
                console.log(`\n→ Sauvegardé: ${outputFile} (${count} artisans)`);

                progress.completedDepartments.push(deptCode);
                progress.failedDepartments = progress.failedDepartments.filter(d => d !== deptCode);
            } else {
                console.log(`\n⚠ Département ${deptCode}: Aucun artisan extrait`);
                failCount++;
                if (!progress.failedDepartments.includes(deptCode)) {
                    progress.failedDepartments.push(deptCode);
                }
            }

            saveJSON(CONFIG.PROGRESS_FILE, progress);

        } catch (error) {
            console.error(`\n✗ Erreur département ${deptCode}:`, error.message);
            failCount++;
            if (!progress.failedDepartments.includes(deptCode)) {
                progress.failedDepartments.push(deptCode);
            }
            saveJSON(CONFIG.PROGRESS_FILE, progress);
        }
    }

    console.log('\n' + '='.repeat(50));
    console.log('EXTRACTION TERMINÉE');
    console.log('='.repeat(50));
    console.log(`✓ Réussis: ${successCount} départements`);
    console.log(`✗ Échecs: ${failCount} départements`);
    console.log(`Total artisans extraits: ${totalArtisans}`);
    console.log(`Fichiers créés dans: ${CONFIG.OUTPUT_DIR}`);

    if (progress.failedDepartments.length > 0) {
        console.log(`\n⚠ Départements en échec:`);
        console.log(`  ${progress.failedDepartments.join(', ')}`);
    }

    console.log(`\n📁 Progression: ${CONFIG.PROGRESS_FILE}`);
}

main().catch(console.error);
