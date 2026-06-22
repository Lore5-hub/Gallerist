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
        // Assumiamo che FSession sia la classe Foundation che gestisce le sessioni
        if (!FSession::isLogged() || FSession::getRuolo() !== 'Artista') {
            // Se non è loggato o non è un artista, lo reindirizziamo al login o alla home
            header('Location: /login');
            exit;
        }
        
        // Recupero l'ID dell'artista dalla sessione attiva
        $idArtistaLoggato = FSession::getId(); 
        
        // 2. Recupero della cronologia delle vendite dallo strato di persistenza
        // Lo strato Foundation filtrerà la tabella degli ordini
        $arrayVendite = FOrdine::getVenditeByArtista($idArtistaLoggato, $filtri);
        
        // 3. Rendering della pagina dello storico vendite
        // Grazie all'autoloader, posso istanziare direttamente la View
        $view = new VStoricoArtista();
        $view->mostraElencoVendite($arrayVendite);
    }

    /**
     * Operazione di sistema: L'artista richiede un'analisi dettagliata (report grafico/statistico) dei propri guadagni.
     * Consente di visualizzare dati aggregati come il fatturato totale, l'opera più redditizia o i trend di vendita.
     * @param array $periodo Intervallo di tempo selezionato dall'artista (contiene 'data_inizio' e 'data_fine')
     */
    public function richiediAnalisi(array $periodo): void {
        // 1. Identificazione dell'artista e controllo accessi
        if (!FSession::isLogged() || FSession::getRuolo() !== 'Artista') {
            header('Location: /login');
            exit;
        }
        
        $idArtistaLoggato = FSession::getId();
        
        // Estraggo le date passate dalla View (con un fallback di sicurezza nel caso siano vuote)
       $dataInizio = null;
$dataFine = null;

try {
    // Se la stringa esiste ed è valorizzata, creiamo l'oggetto DateTimeImmutable
    if (isset($periodo['data_inizio']) && $periodo['data_inizio'] !== '') {
        $dataInizio = new DateTimeImmutable($periodo['data_inizio']);
    }
    
    if (isset($periodo['data_fine']) && $periodo['data_fine'] !== '') {
        $dataFine = new DateTimeImmutable($periodo['data_fine']);
    }
} catch (Exception $e) {
    // Se l'utente inserisce una data in un formato assurdo o non valido, 
    // DateTimeImmutable lancia un'eccezione. Qui la intercettiamo per evitare il crash del sito.
    $dataInizio = null;
    $dataFine = null;
}


        
        // 2. Interrogazione del database per ottenere dati aggregati e statistici
        // Passiamo l'ID e il periodo scelto tramite il calendario
        $datiAggregati = FOrdine::getStatisticheGuadagni($idArtistaLoggato, $dataInizio, $dataFine);
        
        // 3. Passaggio dei dati alla View preposta alla generazione di grafici e report
        $view = new VAnalisiArtista();
        $view->mostraDashboardDati($datiAggregati);
    }
}
?>