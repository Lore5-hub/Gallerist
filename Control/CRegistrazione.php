<?php
// Control/CRegistrazione.php

class CRegistrazione {

    /**
     * Operazione di sistema (Step 1): L'utente chiede di registrarsi.
     */
    public function avviaRegistrazione(): void {
        $view = new VRegistrazione();
        $view->mostraModuloRegistrazione();
    }

    /**
     * Operazione di sistema (Step 2): Registrazione di un Utente standard.
     */
    public function registraUtente(array $dati): void {
        $view = new VRegistrazione();

        $campiObbligatori = ['nome', 'cognome', 'dataNascita', 'indirizzo', 'nickname', 'telefono', 'email', 'password'];

        if (!$this->validaDatiBase($dati, $campiObbligatori, 'utente', $view)) {
            return;
        }

        $passwordHash = password_hash($dati['password'], PASSWORD_BCRYPT);

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

        $id = FPersistentManager::store($nuovoUtente);
        if ($id === null) {
            error_log("CRegistrazione::registraUtente - store fallito per email: " . $dati['email']);
            $view->mostraErrore('errore_generico', 'utente', $dati);
            return;
        }

        USession::getInstance()->impostaValore('utente_loggato', $nuovoUtente->getEmail());
        USession::getInstance()->impostaValore('ruolo', 'utente');

        UEmail::inviaEmail(
            $nuovoUtente->getEmail(),
            "Benvenuto su Gallerist!",
            UEmail::corpoBenvenutoUtente($nuovoUtente->getNome())
);
        $view->mostraMessaggio('registrazione_completata');
    }

    /**
     * Operazione di sistema (Step 3): Registrazione come Artista.
     */
    public function registraArtista(array $dati): void {
        $view = new VRegistrazione();

        $campiObbligatori = ['nome', 'cognome', 'dataNascita', 'indirizzo', 'nickname', 'telefono', 'email', 'password', 'biografia', 'stileArtistico', 'cartaIdentita'];

        if (!$this->validaDatiBase($dati, $campiObbligatori, 'artista', $view)) {
            return;
        }

        $passwordHash = password_hash($dati['password'], PASSWORD_BCRYPT);

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

        $id = FPersistentManager::store($nuovoArtista);
        if ($id === null) {
            error_log("CRegistrazione::registraArtista - store fallito per email: " . $dati['email']);
            $view->mostraErrore('errore_generico', 'artista', $dati);
            return;
        }

        UEmail::inviaEmail(
            ADMIN_EMAIL,
            "Nuovo artista in attesa di validazione",
            UEmail::corpoNotificaNuovoArtista($nuovoArtista->getNome(), $nuovoArtista->getCognome(), $nuovoArtista->getEmail())
        );
        $view->mostraMessaggio('artista_in_attesa');
    }

    // -------------------------------------------------------------------------
    // Helper privato
    // -------------------------------------------------------------------------

    /**
     * Valida i dati comuni a Utente e Artista.
     * Mostra l'errore tramite la View e ritorna false se la validazione fallisce.
     */
    private function validaDatiBase(array $dati, array $campiObbligatori, string $tipo, VRegistrazione $view): bool {
        foreach ($campiObbligatori as $campo) {
            if (empty($dati[$campo])) {
                $view->mostraErrore('campo_obbligatorio', $tipo, $dati);
                return false;
            }
        }

        if (!filter_var($dati['email'], FILTER_VALIDATE_EMAIL)) {
            $view->mostraErrore('email_non_valida', $tipo, $dati);
            return false;
        }

        if (FPersistentManager::exist('EUtente', 'email', $dati['email'])) {
            $view->mostraErrore('email_duplicata', $tipo, $dati);
            return false;
        }

        return true;
    }
}
?>