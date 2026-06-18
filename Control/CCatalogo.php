<?php
require_once __DIR__ . '/../Foundation/FOpera.php';
require_once __DIR__ . '/../Foundation/FCategoria.php';
require_once __DIR__ . '/../Entity/EOpera.php';
require_once __DIR__ . '/../Entity/ECategoria.php';
// require_once __DIR__ . '/../Foundation/FImmagine.php';
// require_once __DIR__ . '/../Foundation/FTag.php';
// require_once __DIR__ . '/../Foundation/FCommento.php';
// require_once __DIR__ . '/../View/VCatalogo.php';
// require_once __DIR__ . '/../View/VOpera.php';

/**
 * Classe di controllo per il Caso d'Uso: Esplorazione e Visualizzazione Catalogo.
 * @package Control
 */
class CCatalogo {

    /**
     * Operazione di sistema (Step 1): L'utente richiede l'esplorazione del catalogo.
     * Recupera le categorie per i filtri e la griglia iniziale delle opere recenti.
     */
    public function esploraCatalogo(): void {
        // 1. Recupero di tutte le categorie per popolare la sidebar dei filtri
        $categorie = FCategoria::loadAll();

        // 2. Recupero delle opere più recenti per la griglia iniziale
        $opere = FOpera::loadRecenti();

        // 3. Rendering della pagina di catalogo iniziale
        // TODO: Instanziare VCatalogo e chiamare $view->mostraPaginaCatalogo($categorie, $opere)
    }

    /**
     * Operazione di sistema (Step 2): L'utente applica filtri o criteri di ricerca.
     *
     * @param array $parametri Chiavi supportate:
     *   'parola_chiave' (string) — ricerca su titolo e descrizione
     *   'categoria'     (string) — filtro sulla categoria
     *   'ordinamento'   (string) — 'prezzo_asc', 'prezzo_desc', 'recenti' (default)
     */
    public function filtraCatalogo(array $parametri): void {
        // 1. Validazione minima dei parametri in ingresso
        $parametriPuliti = [
            'parola_chiave' => trim($parametri['parola_chiave'] ?? ''),
            'categoria'     => trim($parametri['categoria']     ?? ''),
            'ordinamento'   => trim($parametri['ordinamento']   ?? 'recenti'),
        ];

        // Verifica che l'ordinamento sia un valore atteso (whitelist)
        $ordinamentiValidi = ['recenti', 'prezzo_asc', 'prezzo_desc'];
        if (!in_array($parametriPuliti['ordinamento'], $ordinamentiValidi, true)) {
            $parametriPuliti['ordinamento'] = 'recenti';
        }

        // 2. Interrogazione dello strato di persistenza con i filtri puliti
        $opereFiltrate = FOpera::ricercaFiltrata($parametriPuliti);

        // 3. Passaggio dei risultati alla View
        // TODO: Instanziare VCatalogo e chiamare $view->mostraRisultatiFiltrati($opereFiltrate)
    }

    /**
     * Operazione di sistema (Step 3): L'utente clicca su un'opera per vederne la scheda di dettaglio.
     *
     * @param int $idOpera Identificativo dell'opera da caricare
     */
    public function visualizzaDettagliOpera(int $idOpera): void {
        // 1. Caricamento dell'oggetto EOpera (con EArtista annidato) tramite Foundation
        $opera = FOpera::loadByField('id', $idOpera);

        if ($opera === null) {
            // TODO: Instanziare VCatalogo e chiamare $view->mostraErrore("Opera non trovata.")
            return;
        }

        // 2. Caricamento dei componenti subordinati dell'opera
        // TODO: $immagini = FImmagine::getImmaginiByOpera($idOpera)
        //       foreach ($immagini as $img) { $opera->addImmagine($img); }

        // TODO: $tags = FTag::getTagByOpera($idOpera)
        //       foreach ($tags as $tag) { $opera->addTag($tag); }

        // TODO: $commenti = FCommento::getCommentiByOpera($idOpera)
        //       foreach ($commenti as $commento) { $opera->addCommento($commento); }

        // 3. Recupero delle altre opere dello stesso artista (esclusa quella corrente)
        $altreOpere = FOpera::loadByArtista(
            $opera->getArtista()->getId(),
            $idOpera
        );

        // 4. Invio del grafo di oggetti alla View
        // TODO: Instanziare VOpera e chiamare $view->mostraSchedaDettaglio($opera, $altreOpere)
    }
}
?>