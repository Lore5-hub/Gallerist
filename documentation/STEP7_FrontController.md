# Step 7 — Realizzazione del Front Controller

## Obiettivo dello step

Come indicato nelle slide del corso, l'obiettivo dello Step 7 è realizzare un **unico punto di ingresso** per l'applicazione (`index.php`), capace di:

- ricevere ogni richiesta HTTP indipendentemente dall'URL invocata;
- interpretare l'URL per identificare risorsa, azione e parametri;
- istanziare il Controller responsabile e invocarne il metodo corretto;
- gestire i casi in cui la risorsa o l'azione richiesta non esistono (404).

Per ottenere un unico punto di ingresso è necessario attivare `mod_rewrite` di Apache e definire un file `.htaccess` che reindirizzi tutte le richieste verso `index.php`, ad eccezione delle risorse statiche reali (CSS, JS, immagini).

## Componenti realizzati

### 1. `.htaccess`

```apache
RewriteEngine On
RewriteBase /

# Serve i file statici reali (css, js, immagini) direttamente senza passare da index.php
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d

# Tutto il resto → index.php, preservando la query string
RewriteRule ^(.*)$ index.php [QSA,L]
```

Rispetto alla soluzione minimale proposta a lezione (`RewriteRule ^(.*)$ /index.php`), questa versione aggiunge due condizioni (`RewriteCond`) che escludono dal redirect i file e le cartelle realmente esistenti sul filesystem. In questo modo:

- le richieste a risorse statiche (`/css/style.css`, `/img/logo.png`, ecc.) vengono servite direttamente da Apache, senza inutile overhead di bootstrap dell'applicazione PHP;
- solo le URL "logiche" (che non corrispondono a file reali) vengono instradate verso `index.php`.

Il flag `QSA` (Query String Append) preserva eventuali parametri GET nella query string durante il rewrite; `L` (Last) indica ad Apache di fermare la catena di regole dopo questa.

### 2. `index.php` — punto di ingresso unico

```php
<?php
// Mostra gli errori per debug (togli in produzione)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Path assoluto alla root del progetto
define('BASE_PATH', __DIR__ . '/');

require_once BASE_PATH . 'Utility/autoload.php';
require_once BASE_PATH . 'StartSmarty.php';
require_once BASE_PATH . 'Installation.php';
require_once BASE_PATH . 'Smarty/Smarty.class.php';

// Avvia la sessione subito, prima di qualsiasi output
USession::getInstance();

// Usa path assoluto per verificare l'installazione
if (file_exists(BASE_PATH . 'config.inc.php')) {
    $fcontroller = new CFrontController();
    $fcontroller->run($_SERVER['REQUEST_URI']);
} else {
    Installation::begin();
}
```

Punti salienti:

- carica l'autoloader e le dipendenze comuni (Smarty, configurazione) una sola volta, prima di qualunque dispatch;
- avvia la sessione tramite il singleton `USession` prima di produrre qualsiasi output, come richiesto da PHP per l'uso corretto dei cookie di sessione;
- verifica la presenza di `config.inc.php` per distinguere tra applicazione già installata (→ `CFrontController`) e prima installazione (→ `Installation::begin()`).

> Nota: `display_errors` è attivo per facilitare il debug in ambiente di sviluppo (XAMPP locale). Va disattivato in un eventuale deploy in produzione, per evitare di esporre stack trace PHP ai client.

### 3. `Control/CFrontController.php` — dispatch delle richieste

```php
<?php
// Control/CFrontController.php

class CFrontController {

    public function run($path)
    {
        // Se nell'URL c'è un punto interrogativo (richiesta GET),
        // tagliamo via tutto ciò che viene dopo prima di analizzare i segmenti.
        if (strpos($path, '?') !== false) {
            $path = explode('?', $path)[0];
        }

        // 1. Pulizia dell'URL: divide la stringa e rimuove gli elementi vuoti.
        $segments = array_values(array_filter(explode('/', $path)));

        // 2. Usiamo il WHILE al posto dell'IF per eliminare TUTTI i duplicati della cartella
        while (isset($segments[0]) && strtolower($segments[0]) === 'gallerist') {
            array_shift($segments);
        }

        // Se l'utente ha scritto "index.php" nell'URL, scartiamo anche questo segmento!
        if (isset($segments[0]) && strtolower($segments[0]) === 'index.php') {
            array_shift($segments);
        }

        // Timeout sessione: 30 minuti di inattività
        $timeoutMinuti = 30;
        $sessione = USession::getInstance();

        if ($sessione->esisteValore('ultimo_accesso')) {
            $inattivita = time() - $sessione->getValore('ultimo_accesso');
            if ($inattivita > ($timeoutMinuti * 60)) {
                $sessione->distruggi();
                header('Location: /utente/login?sessione=scaduta');
                exit;
            }
        }
        $sessione->setValue('ultimo_accesso', time());

        $visita = new EVisita(0, $path, new DateTimeImmutable(), session_id());
        FPersistentManager::store($visita);

        // 3. Identifica Controller, Metodo e Parametri
        $controllerName = "C" . ucfirst($segments[0] ?? "Catalogo");
        $method         = $segments[1] ?? "homepage";
        // Tutti gli elementi dal terzo in poi diventano parametri (se usati nell'URL path)
        $params         = array_slice($segments, 2);

        // 4. Deleghiamo il lavoro pesante all'Autoloader e a PHP!
        if (class_exists($controllerName)) {
            $controllerInstance = new $controllerName();

            // Verifichiamo che il metodo richiesto esista
            if (method_exists($controllerInstance, $method)) {
                // Invochiamo il metodo passando i parametri
                $controllerInstance->$method(...$params);
                return; // Tutto è andato bene, usciamo!
            }
        }

        // 5. Fallback: Se la classe o il metodo non esistono, mostriamo un Errore 404
        $this->mostraErrore404();
    }

    /**
     * Il Front Controller non chiama la View, ma delega a un Controller dedicato.
     */
    private function mostraErrore404()
    {
        if (class_exists('CErrore')) {
            $errorController = new CErrore();
            $errorController->mostra404();
        } else {
            header("HTTP/1.0 404 Not Found");
            echo "<h1>Errore 404 - Pagina non trovata</h1>";
        }
    }
}
```

## Convenzione di mapping URL → azione

Data un'URL del tipo:

```
/<risorsa>/<metodo>/<param1>/<param2>/...
```

il Front Controller la traduce in una chiamata PHP secondo questa convenzione:

| Segmento URL          | Ruolo                          | Trasformazione                         |
|------------------------|---------------------------------|------------------------------------------|
| `gallerist`            | prefisso cartella applicazione | rimosso (anche se ripetuto)             |
| segmento 1 (`risorsa`) | nome della risorsa/controller  | `"C" . ucfirst($risorsa)` → nome classe |
| segmento 2 (`metodo`)  | azione richiesta               | usato come nome del metodo da invocare, default `homepage` |
| segmenti successivi    | parametri posizionali          | passati al metodo con `...$params`      |

Esempio pratico:

```
GET /opera/dettaglio/42
```

viene tradotta in:

```php
$controller = new COpera();
$controller->dettaglio('42');
```

Se nessun segmento è presente (`GET /`), il Front Controller instrada di default verso `CCatalogo::homepage()`.

Questo approccio corrisponde alla "Soluzione 2" descritta nelle slide del corso (uso minimale di `mod_rewrite` + parsing dell'URL via software), con dispatch realizzato tramite le funzioni di riflessione base di PHP (`class_exists`, `method_exists`) invece di costrutti `if`/`switch` espliciti per ogni rotta.

## Estensioni rispetto alle slide del corso

Oltre a quanto richiesto dallo step, l'implementazione del Front Controller integra due funzionalità trasversali comuni a tutte le richieste:

1. **Timeout di sessione** — ogni richiesta aggiorna un timestamp `ultimo_accesso` in sessione; se sono trascorsi più di 30 minuti di inattività, la sessione viene distrutta e l'utente reindirizzato al login. Essendo centralizzato nel Front Controller, questo controllo si applica automaticamente a tutte le rotte, senza doverlo replicare in ogni singolo Controller.
2. **Logging delle visite** — ogni richiesta viene registrata come entità `EVisita` (path, timestamp, id di sessione) tramite `FPersistentManager::store()`, utile per statistiche d'uso e per analisi successive.

## Gestione degli errori

Se la risorsa richiesta non corrisponde a nessuna classe Controller esistente, oppure la classe esiste ma non espone il metodo richiesto, il Front Controller delega la generazione della risposta a `CErrore::mostra404()`, mantenendo coerente il pattern MVC anche per la gestione degli errori (il Front Controller non produce output HTML direttamente, se non come fallback in assenza del Controller di errore).

## Confronto con l'approccio delle slide (note per la discussione orale)

Durante il confronto con l'esempio di codice presentato a lezione sono emerse due differenze di design, volute e motivabili:

**Mapping azione → metodo, non verbo HTTP → metodo.** Le slide propongono, per uno scenario CRUD, di comporre il nome del metodo a partire dal verbo HTTP (`$_SERVER['REQUEST_METHOD']`) unito al nome della risorsa (es. `getArticles`, `postArticles`). In Gallerist l'azione è invece il secondo segmento del path (`/opera/dettaglio/42`), indipendentemente dal verbo HTTP usato per la richiesta. La scelta è motivata dal fatto che le operazioni dell'applicazione (login, registrazione, dettaglio opera, proposta offerta, validazione artista...) non sono operazioni CRUD pure su una singola risorsa, ma azioni applicative eterogenee: il mapping per segmento di path si adatta meglio a questo caso rispetto a un mapping rigido sui 4 verbi HTTP.

**Un solo codice di errore (404) invece di 404/405.** Nell'esempio a verbi HTTP del professore, un 405 (`Method Not Allowed`) ha senso quando la risorsa esiste ma non supporta il verbo HTTP usato nella richiesta. Nel routing di Gallerist, basato su segmenti di path e non su verbi HTTP, "azione non trovata per quella risorsa" resta semanticamente un caso di risorsa/rotta inesistente: si è quindi scelto di mantenere un unico 404 per class-not-found e method-not-found, per coerenza con lo schema di mapping adottato, evitando di introdurre un 405 che nel nostro contesto non avrebbe un verbo HTTP a cui riferirsi.


