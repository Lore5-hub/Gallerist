<?php

/**
 * Classe View per l'area Amministratore.
 * Gestisce la visualizzazione dei template relativi al pannello di controllo.
 */
class VAdmin {

    public $smarty;

    /**
     * Il costruttore inizializza Smarty tramite la classe StartSmarty
     * garantendo che i percorsi dei template siano corretti.
     */
    public function __construct() {
        $this->smarty = StartSmarty::configuration();
    }

    /**
     * Mostra la dashboard principale dell'admin.
     * @param array $dati_statistici Eventuali dati da mostrare (es. numero utenti, vendite)
     */
    public function showDashboard(array $dati_statistici = []) {
        // Se passiamo dei dati, li assegniamo a Smarty
        foreach ($dati_statistici as $key => $value) {
            $this->smarty->assign($key, $value);
        }
        
        $this->smarty->display('AdminDashboard.tpl');
    }

    /**
     * Esempio di metodo per mostrare la lista utenti all'admin
     */
    public function showGestioneUtenti($listaUtenti) {
        $this->smarty->assign('utenti', $listaUtenti);
        $this->smarty->display('AdminGestioneUtenti.tpl');
    }

    /**
     * Metodo generico per assegnare variabili a Smarty dal Controller
     */
    public function assegna($chiave, $valore) {
        $this->smarty->assign($chiave, $valore);
    }
}