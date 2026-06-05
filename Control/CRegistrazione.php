<?php
/**
 * Classe di controllo per il Caso d'Uso: Registrazione account.
 * @package Control
 */
class CRegistrazione {

    /**
     * Operazione di sistema (Step 1a/1b): L'utente chiede di registrarsi.
     * Il sistema mostra il form di registrazione.
     */
    public function avviaRegistrazione(): void {
        // TODO: Includere e instanziare la View VRegistrazione dalla cartella /View
        // TODO: Chiamare il metodo $VRegistrazione->mostraModuloRegistrazione()
    }

    /**
     * Operazione di sistema (Step 2a/2b): Registrazione di un Utente standard.
     * @param array $dati Array associativo proveniente dal form (es. $_POST)
     */
    public function registraUtente(array $dati): void {
        // 1. Validazione base dei dati (es. email già esistente)
        // TODO: Instanziare FUtente dalla cartella /Foundation e usare un metodo come FUtente::esisteEmail($dati['email'])
        
        // 2. Creazione dell'oggetto Entity
        $nuovoUtente = new EUtente(
            $dati['nome'],
            $dati['cognome'],
            $dati['dataNascita'],
            $dati['indirizzo'],
            $dati['nickname'],
            $dati['email'],
            $dati['password'] // TODO: Qui si dovrebbe chiamare una funzione hash prima dell'inserimento
        );

        // 3. Persistenza dei dati
        // TODO: Chiamare il PersistentManager o FUtente::store($nuovoUtente) nel package /Foundation
        
        // 4. Login automatico 
        // TODO: Includere la classe USession dal package Utility (o Foundation)
        // TODO: Chiamare USession::getInstance()->imposta_valore('utente_loggato', $nuovoUtente->getEmail())
        
        // 5. Invio email di avvenuta registrazione
        // TODO: Includere UEmail dal package Utility
        // TODO: Chiamare UEmail::invia_email($nuovoUtente->getEmail(), "Benvenuto!", "Registrazione completata.")

        // 6. Output visivo
        // TODO: Instanziare VHome dalla cartella /View per il reindirizzamento
        // TODO: Chiamare $VHome->mostraHomeConMessaggio("Registrazione effettuata con successo.")
    }

    /**
     * Operazione di sistema (Step 3a/3b): Registrazione come Artista (Flusso Alternativo).
     * @param array $dati Array associativo proveniente dal form
     */
    public function registraArtista(array $dati): void {
        // 1. Creazione dell'oggetto Entity Artista
        // Il costruttore imposta in automatico lo stato "In attesa di validazione"
        $nuovoArtista = new EArtista(
            $dati['nome'],
            $dati['cognome'],
            $dati['dataNascita'],
            $dati['indirizzo'],
            $dati['nickname'],
            $dati['email'],
            $dati['password'],
            $dati['immagineProfilo'] ?? "",
            $dati['biografia'],
            $dati['stileArtistico'],
            $dati['cartaIdentita']
        );

        // 2. Persistenza dei dati
        // TODO: Chiamare il PersistentManager o FArtista::store($nuovoArtista) nel package /Foundation
        
        // 3. Notifica al sistema di amministrazione
        // TODO: Questa logica potrebbe prevedere l'inserimento di un record in una tabella di notifiche tramite FNotifica
        
        // 4. Output visivo
        // TODO: Instanziare VRegistrazione dalla cartella /View
        // TODO: Chiamare $VRegistrazione->mostraMessaggio("Account creato. In attesa di validazione da parte dell'amministratore.")
    }
}
?>