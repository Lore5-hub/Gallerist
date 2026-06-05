<?php
/**
 * Classe di controllo per il Caso d'Uso: Esplorazione e Visualizzazione Catalogo.
 * @package Control
 */
class CCatalogo {

    /**
     * Operazione di sistema (Step 1a/1b): L'utente richiede l'esplorazione del catalogo.
     * Recupera le categorie per i filtri e l'elenco iniziale delle opere.
     */
    public function esploraCatalogo(): void {
        // 1. Recupero di tutte le categorie per popolare la sidebar dei filtri nella View
        // TODO: Chiamare il PersistentManager o FCategoria::loadAll() nella cartella /Foundation
        
        // 2. Recupero della griglia iniziale di opere (es. le opere pubblicate più recentemente)
        // Lo strato Foundation restituirà un array popolato interamente da oggetti EOpera
        // TODO: Chiamare FOpera::getOpereIniziali() nella cartella /Foundation
        
        // 3. Rendering della pagina di catalogo iniziale
        // TODO: Includere e istanziare la View VCatalogo dalla cartella /View
        // TODO: Chiamare $VCatalogo->mostraPaginaCatalogo($arrayCategorie, $arrayOpere)
    }

    /**
     * Operazione di sistema (Step 2a/2b): L'utente applica filtri o criteri di ricerca.
     * @param array $parametri Contiene le chiavi 'parola_chiave', 'categoria', 'ordinamento'
     */
    public function filtraCatalogo(array $parametri): void {
        // 1. Interrogazione dello strato di persistenza per ottenere i record filtrati
        // Lo strato Foundation si occuperà di mappare le righe del DB in un array di oggetti Entity (EOpera)
        // TODO: Chiamare FOpera::ricercaFiltrata($parametri) nella cartella /Foundation
        
        // 2. Passaggio dei risultati alla View per la visualizzazione delle "card" aggiornate
        // TODO: Instanziare VCatalogo dalla cartella /View
        // TODO: Chiamare $VCatalogo->mostraRisultatiFiltrati($opereFiltrate)
    }

    /**
     * Operazione di sistema (Step 3a/3b): L'utente clicca su un'opera per vederne la scheda di dettaglio.
     * @param int $idOpera Identificativo dell'opera da caricare
     */
    public function visualizzaDettagliOpera(int $idOpera): void {
        // 1. Caricamento dell'oggetto Entity principale (EOpera) comprensivo di EArtista e ECategoria associati
        // TODO: Chiamare FOpera::load($idOpera) nella cartella /Foundation
        
        // 2. Caricamento dei componenti subordinati/aggregati dell'opera per completare l'oggetto in RAM
        // TODO: Chiamare FImmagine::getImmaginiByOpera($idOpera) e iniettarle in EOpera tramite ciclo e $opera->addImmagine()
        // TODO: Chiamare FTag::getTagByOpera($idOpera) e iniettarle in EOpera tramite ciclo e $opera->addTag()
        // TODO: Chiamare FCommento::getCommentiByOpera($idOpera) e iniettarle in EOpera tramite ciclo e $opera->addCommento()
        
        // 3. Recupero delle altre opere del medesimo artista (richiesto esplicitamente dallo Step 3a)
        // TODO: Chiamare FOpera::getOpereByArtista($opera->getArtista()->getNickname(), $idOpera) per escludere l'opera corrente
        
        // 4. Invio dell'intero grafo di oggetti alla View preposta
        // TODO: Includere e istanziare VOpera dalla cartella /View
        // TODO: Chiamare $VOpera->mostraSchedaDettaglio($opera, $altreOpereArtista)
    }
}
?>