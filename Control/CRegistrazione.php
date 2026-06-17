<?php
require_once __DIR__ . '/../Foundation/FUtente.php';
require_once __DIR__ . '/../Foundation/FArtista.php';
require_once __DIR__ . '/../Entity/EUtente.php';
require_once __DIR__ . '/../Entity/EArtista.php';
// require_once __DIR__ . '/../Utility/USession.php';
// require_once __DIR__ . '/../Utility/UEmail.php';
// require_once __DIR__ . '/../View/VRegistrazione.php';
// require_once __DIR__ . '/../View/VHome.php';

/**
 * Classe di controllo per il Caso d'Uso: Registrazione account.
 * @package Control
 */
class CRegistrazione {

    /**
     * Operazione di sistema (Step 1): L'utente chiede di registrarsi.
     * Il sistema mostra il form di registrazione.
     */
    public function avviaRegistrazione(): void {
        // TODO: Instanziare VRegistrazione e chiamare $view->mostraModuloRegistrazione()
    }

    /**
     * Operazione di sistema (Step 2): Registrazione di un Utente standard.
     * @param array $dati Array associativo proveniente dal form (es. $_POST)
     */
    public function registraUtente(array $dati): void {
        // 1. Validazione dei dati in ingresso
        $campiObbligatori = ['nome', 'cognome', 'dataNascita', 'indirizzo', 'nickname', 'telefono', 'email', 'password'];
        foreach ($campiObbligatori as $campo) {
            if (empty($dati[$campo])) {
                // TODO: Instanziare VRegistrazione e chiamare $view->mostraErrore("Il campo '$campo' è obbligatorio.")
                return;
            }
        }

        if (!filter_var($dati['email'], FILTER_VALIDATE_EMAIL)) {
            // TODO: Instanziare VRegistrazione e chiamare $view->mostraErrore("Formato email non valido.")
            return;
        }

        // Controllo email duplicata tramite Foundation
        if (FUtente::esisteEmail($dati['email'])) {
            // TODO: Instanziare VRegistrazione e chiamare $view->mostraErrore("Email già registrata.")
            return;
        }

        // 2. Hash della password (nel Control, prima di passarla all'Entity)
        $passwordHash = password_hash($dati['password'], PASSWORD_BCRYPT);

        // 3. Creazione dell'oggetto Entity
        // id=0 → AUTO_INCREMENT sul DB; stato_account=STATO_ATTIVO di default
        $nuovoUtente = new EUtente(
            0,
            $dati['nome'],
            $dati['cognome'],
            $dati['dataNascita'],
            $dati['indirizzo'],
            $dati['nickname'],
            $dati['telefono'],
            $dati['email'],
            $passwordHash,
            $dati['immagineProfilo'] ?? null,
            EUtente::STATO_ATTIVO
        );

        // 4. Persistenza dei dati tramite Foundation
        $id = FUtente::store($nuovoUtente);
        if ($id === null) {
            error_log("CRegistrazione::registraUtente - store fallito per email: " . $dati['email']);
            // TODO: Instanziare VRegistrazione e chiamare $view->mostraErrore("Errore durante la registrazione.")
            return;
        }

        // 5. Login automatico post-registrazione
        // TODO: USession::getInstance()->impostaValore('utente_loggato', $nuovoUtente->getEmail())
        // TODO: USession::getInstance()->impostaValore('ruolo', 'utente')

        // 6. Invio email di benvenuto
        // TODO: UEmail::inviaEmail($nuovoUtente->getEmail(), "Benvenuto!", "Registrazione completata.")

        // 7. Redirect alla home con messaggio di successo
        // TODO: Instanziare VHome e chiamare $view->mostraHomeConMessaggio("Registrazione effettuata con successo.")
    }

    /**
     * Operazione di sistema (Step 3 - Flusso Alternativo): Registrazione come Artista.
     * @param array $dati Array associativo proveniente dal form
     */
    public function registraArtista(array $dati): void {
        // 1. Validazione dei dati in ingresso
        $campiObbligatori = ['nome', 'cognome', 'dataNascita', 'indirizzo', 'nickname', 'telefono', 'email', 'password', 'biografia', 'stileArtistico', 'cartaIdentita'];
        foreach ($campiObbligatori as $campo) {
            if (empty($dati[$campo])) {
                // TODO: Instanziare VRegistrazione e chiamare $view->mostraErrore("Il campo '$campo' è obbligatorio.")
                return;
            }
        }

        if (!filter_var($dati['email'], FILTER_VALIDATE_EMAIL)) {
            // TODO: Instanziare VRegistrazione e chiamare $view->mostraErrore("Formato email non valido.")
            return;
        }

        // Controllo email duplicata tramite Foundation
        if (FUtente::esisteEmail($dati['email'])) {
            // TODO: Instanziare VRegistrazione e chiamare $view->mostraErrore("Email già registrata.")
            return;
        }

        // 2. Hash della password (nel Control, prima di passarla all'Entity)
        $passwordHash = password_hash($dati['password'], PASSWORD_BCRYPT);

        // 3. Creazione dell'oggetto Entity
        // id=0 → AUTO_INCREMENT sul DB; stato_validazione=STATO_IN_ATTESA di default
        $nuovoArtista = new EArtista(
            0,
            $dati['nome'],
            $dati['cognome'],
            $dati['dataNascita'],
            $dati['indirizzo'],
            $dati['nickname'],
            $dati['telefono'],
            $dati['email'],
            $passwordHash,
            $dati['immagineProfilo'] ?? null,
            EUtente::STATO_ATTIVO,
            $dati['biografia'],
            $dati['stileArtistico'],
            $dati['cartaIdentita'],
            EArtista::STATO_IN_ATTESA
        );

        // 4. Persistenza dei dati (UTENTE + ARTISTA in sequenza) tramite Foundation
        $id = FArtista::store($nuovoArtista);
        if ($id === null) {
            error_log("CRegistrazione::registraArtista - store fallito per email: " . $dati['email']);
            // TODO: Instanziare VRegistrazione e chiamare $view->mostraErrore("Errore durante la registrazione.")
            return;
        }

        // 5. Notifica all'amministratore
        // TODO: FNotifica::store(...) oppure UEmail::inviaEmail(ADMIN_EMAIL, ...)

        // 6. Output visivo (l'artista non viene loggato: deve attendere validazione admin)
        // TODO: Instanziare VRegistrazione e chiamare $view->mostraMessaggio("Account creato. In attesa di validazione.")
    }
}
?>