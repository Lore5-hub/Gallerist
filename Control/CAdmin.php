<?php

class CAdmin {

    /**
     * Metodo privato di controllo (Il "Buttafuori").
     * Verifica se l'utente è loggato ed è un amministratore.
     * @return bool
     */
    private static function checkAdmin(): bool {
        $sessione = USession::getInstance();
        
        // 1. Controlliamo se esiste un utente in sessione
        if (!$sessione->isSetKey('utente_loggato')) {
            return false;
        }
        
        $utente = $sessione->getValue('utente_loggato');
        
        // 2. Verifichiamo se l'utente ha il ruolo di admin
        // NOTA: Assicurati che la tua entità EUtente abbia il metodo getRuolo() 
        // o che restituisca 'admin'
        if ($utente instanceof EUtente && $utente->getRuolo() === 'admin') {
            return true;
        }
        
        return false;
    }

    /**
     * Mostra la Dashboard principale dell'Amministratore
     * Risponde all'URL: /Gallerist/Admin/dashboard
     */
    public function dashboard() {
    if (!self::checkAdmin()) {
        header('Location: /Gallerist/Utente/login');
        exit;
    }

    $vAdmin = new VAdmin();
    
    // Esempio: recuperiamo dei dati reali da mostrare nel pannello
    $dati = [
        'nome_admin' => USession::getInstance()->getValue('utente_loggato')->getNickname(),
        'data_oggi'  => date('d/m/Y')
    ];

    $vAdmin->showDashboard($dati);
}

    /**
     * Esempio di altra funzione protetta: Gestione degli Utenti
     * Risponde all'URL: /Gallerist/Admin/gestioneUtenti
     */
    public function gestioneUtenti() {
        if (!self::checkAdmin()) {
            header('Location: /Gallerist/Utente/login');
            exit;
        }

        // Codice per caricare tutti gli utenti dal DB e mostrarli all'admin...
    }
}