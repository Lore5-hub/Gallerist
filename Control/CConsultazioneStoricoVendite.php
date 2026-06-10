<?php
/**
 * Classe di controllo per il Caso d'Uso: UC6 - Monitoraggio Vendite e Analisi Performance (Esclusivo Artista).
 * @package Control
 */
class CConsultazioneStoricoVendite {

    /**
     * Operazione di sistema: L'artista richiede di visualizzare lo storico delle sue opere vendute.
     * Permette all'artista di monitorare le transazioni concluse, i collezionisti acquirenti e i singoli ricavi.
     * @param array $filtri Parametri facoltativi per filtrare le vendite (es. 'mese', 'anno', 'stato_spedizione')
     */
    public function visualizzaStorico(array $filtri = []): void {
        // 1. Controllo di sicurezza e identificazione dell'artista
        // TODO: Verificare tramite Foundation\Session che l'utente loggato abbia il ruolo di "Artista"
        // TODO: Recuperare il nickname o l'ID dell'artista dalla sessione attiva
        
        // 2. Recupero della cronologia delle vendite dallo strato di persistenza
        // Lo strato Foundation filtrerà la tabella degli ordini restituendo solo quelli relativi alle opere di questo artista
        // TODO: Chiamare FOrdine::getVenditeByArtista($idArtistaLoggato, $filtri) nella cartella /Foundation
        
        // 3. Rendering della pagina dello storico vendite
        // TODO: Includere e istanziare la View VStoricoArtista dalla cartella /View
        // TODO: Chiamare $VStoricoArtista->mostraElencoVendite($arrayVendite)
    }

    /**
     * Operazione di sistema: L'artista richiede un'analisi dettagliata (report grafico/statistico) dei propri guadagni.
     * Consente di visualizzare dati aggregati come il fatturato totale, l'opera più redditizia o i trend di vendita.
     * @param array $periodo Intervallo di tempo selezionato dall'artista (contiene 'data_inizio' e 'data_fine')
     */
    public function richiediAnalisi(array $periodo): void {
        // 1. Identificazione dell'artista tramite la sessione attiva per garantire la privacy dei dati finanziari
        // TODO: Recuperare l'ID dell'artista loggato da Foundation\Session
        
        // 2. Interrogazione del database per ottenere dati aggregati e statistici
        // In questo caso, Foundation non restituisce singole Entity "Ordine", ma un set di dati già calcolati (es. array associativo)
        // TODO: Chiamare FOrdine::getStatisticheGuadagni($idArtistaLoggato, $periodo['data_inizio'], $periodo['data_fine']) nella cartella /Foundation
        
        // 3. Passaggio dei dati alla View preposta alla generazione di grafici e report
        // TODO: Includere e istanziare la View VAnalisiArtista dalla cartella /View
        // TODO: Chiamare $VAnalisiArtista->mostraDashboardDati($datiAggregati)
    }
}
?>