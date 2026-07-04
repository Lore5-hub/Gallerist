<?php

class CUtente 
{
    // Questo è il metodo chiamato dall'URL /Gallerist/utente/login
    public function login() 
    {
        // Se l'utente ha appena inviato il form di login (richiesta POST)
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';

            // Qui verificherai le credenziali sul Database tramite i tuoi Foundation
            // Se sono corrette, salvi l'utente in $_SESSION ed effettui un redirect alla homepage
        } 
        
        // Se l'utente ha solo cliccato sull'omino (richiesta GET)
        $vUtente = new VUtente(); 
        $vUtente->mostraFormLogin();
    }

    // Questo sarà il metodo chiamato dall'URL /Gallerist/utente/registrazione
    public function registrazione() 
    {
        $vUtente = new VUtente();
        $vUtente->mostraFormRegistrazione();
    }

    public function verifica() {
        // 1. Controlliamo se l'utente ha cliccato sul pulsante "Accedi" (Richiesta POST)
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            // Recuperiamo e puliamo i dati inviati dal form
            $email = isset($_POST['email']) ? trim($_POST['email']) : '';
            $password = isset($_POST['password']) ? trim($_POST['password']) : '';
            
            // 2. Interroghiamo il Database (Livello Foundation) per verificare le credenziali
            $utente = FUtente::verificaCredenziali($email, $password); 
            
            if ($utente !== null) {
    // ✅ Se è un artista, ricaricalo come EArtista
    if ($utente->getRuolo() === EUtente::RUOLO_ARTISTA) {
        $artista = FPersistentManager::load('EArtista', 'id', $utente->getId());
        if ($artista instanceof EArtista) {
            $utente = $artista;
        }
    }
     if ($utente->getStatoAccount() === EUtente::STATO_BANNATO) {
        $vUtente = new VUtente();
        $vUtente->smarty->assign('errore_login', true);
        $vUtente->smarty->assign('messaggio_errore_login', 'Il tuo account è stato sospeso. Contatta l\'amministratore per maggiori informazioni.');
        $vUtente->smarty->display('Login.tpl');
        return;
    }
    if ($utente instanceof EArtista && $utente->getStatoValidazione() === 'IN_ATTESA') {
        $vUtente = new VUtente();
        $vUtente->smarty->assign('errore_login', true);
        $vUtente->smarty->assign('messaggio_errore_login', 'Il tuo account è in attesa di validazione da parte dell\'amministratore.');
        $vUtente->smarty->display('Login.tpl');
        return;
    }
                // 🟢 CREDENZIALI CORRETTE!
                
                // Salviamo i dati dell'utente nella sessione
                $sessione = USession::getInstance();
                $sessione->setValue('utente_loggato', $utente);
                
                // ✨ FIX: Controlliamo il ruolo usando la stringa esatta dell'ENUM del DB ('Amministratore')
                if ($utente->getRuolo() === 'Amministratore') {
                    header('Location: /Gallerist/Admin/dashboard');
                } else {
                    header('Location: /Gallerist/catalogo/esploraCatalogo');
                }
                exit; 
                
            } else {
                // 🔴 CREDENZIALI ERRATE!
                $vUtente = new VUtente();
                $vUtente->smarty->assign('errore_login', true);
                $vUtente->smarty->assign('email_inserita', $email); 
                $vUtente->smarty->display('Login.tpl');
            }
            
        } else {
            // 🔵 RICHIESTA GET
            $vUtente = new VUtente();
            $vUtente->smarty->display('Login.tpl');
        }
    }

    public function verificaRegistrazione() {

        // Controlliamo prima di tutto se la richiesta è un POST

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

           

            $vUtente = new VUtente();



            // ✨ FIX: Spostato qui dentro il controllo del ruolo per evitare errori in GET

            $ruoloPost = $_POST['ruolo'] ?? '';

            if ($ruoloPost === 'utente') {

                $ruoloDB = 'Utente registrato';

            } elseif ($ruoloPost === 'artista') {

                $ruoloDB = 'Artista';

            } else {

                $ruoloDB = 'Utente registrato';

            }



            // 1. Recupero e pulizia dei dati testuali dal $_POST

            $nome             = isset($_POST['nome']) ? trim($_POST['nome']) : '';

            $cognome          = isset($_POST['cognome']) ? trim($_POST['cognome']) : '';

            $indirizzo        = isset($_POST['indirizzo']) ? trim($_POST['indirizzo']) : '';

            $nickname         = isset($_POST['nickname']) ? trim($_POST['nickname']) : '';

            $telefono         = isset($_POST['telefono']) ? trim($_POST['telefono']) : '';

            $email            = isset($_POST['email']) ? trim($_POST['email']) : '';

            $password_chiaro  = isset($_POST['password']) ? trim($_POST['password']) : '';

            $data_nascita_str = isset($_POST['data_nascita']) ? trim($_POST['data_nascita']) : '';



            // Controllo di sicurezza: l'email è già presente nel DB?

            if (FUtente::esisteEmail($email)) {

               

                $vUtente->smarty->assign('errore_registrazione', true);

                $vUtente->smarty->assign('messaggio_errore', 'Questa email è già registrata nel sistema.');

                $vUtente->smarty->display('Registrazione.tpl');

                return;

            }



            // Conversione della stringa data in oggetto DateTimeImmutable

            try {

                $dataDiNascita = new DateTimeImmutable($data_nascita_str);

            } catch (Exception $e) {

                $dataDiNascita = new DateTimeImmutable();

            }



            // Hashing sicuro della password prima di salvarla

            $passwordHash = password_hash($password_chiaro, PASSWORD_DEFAULT);



            // 2. Gestione del caricamento dell'immagine del profilo (File Upload)

            $immagineProfilo = null;

            if (isset($_FILES['immagine_profilo']) && $_FILES['immagine_profilo']['error'] === UPLOAD_ERR_OK) {

                $fileTmpPath = $_FILES['immagine_profilo']['tmp_name'];

                $fileName = $_FILES['immagine_profilo']['name'];

                $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));



                $estensioniPermesse = ['jpg', 'jpeg', 'png', 'webp'];

                if (in_array($fileExtension, $estensioniPermesse)) {

                    $nuovoNomeFile = md5(time() . $fileName) . '.' . $fileExtension;

                    $uploadFileDir = $_SERVER['DOCUMENT_ROOT'] . '/Gallerist/uploads/profilo/';

                   

                    if (!is_dir($uploadFileDir)) {

                        mkdir($uploadFileDir, 0755, true);

                    }



                    $destPath = $uploadFileDir . $nuovoNomeFile;

                    if (move_uploaded_file($fileTmpPath, $destPath)) {

                        $immagineProfilo = '/Gallerist/uploads/profilo/' . $nuovoNomeFile;

                    }

                }

            }

            // Dopo il codice dell'immagine profilo, aggiungi:
$documento = '';
if (isset($_FILES['documento_identita']) && $_FILES['documento_identita']['error'] === UPLOAD_ERR_OK) {
    $fileTmpPath  = $_FILES['documento_identita']['tmp_name'];
    $fileName     = $_FILES['documento_identita']['name'];
    $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    $estensioniPermesse = ['jpg', 'jpeg', 'png', 'webp', 'pdf'];
    if (in_array($fileExtension, $estensioniPermesse)) {
        $nuovoNomeFile = md5(time() . $fileName) . '.' . $fileExtension;
        $uploadFileDir = $_SERVER['DOCUMENT_ROOT'] . '/Gallerist/uploads/documenti/';

        if (!is_dir($uploadFileDir)) {
            mkdir($uploadFileDir, 0755, true);
        }

        $destPath = $uploadFileDir . $nuovoNomeFile;
        if (move_uploaded_file($fileTmpPath, $destPath)) {
            $documento = $nuovoNomeFile;
        } 
    }
}

            // 3. Creazione dell'entità EUtente e salvataggio nel database

            try {

                $statoIniziale = EUtente::STATO_ATTIVO;

              if ($ruoloDB === 'Artista') {
                    // 🟢 GESTIONE ARTISTA: Recuperiamo i campi extra definiti nel form HTML
                    $biografia = isset($_POST['biografia']) ? trim($_POST['biografia']) : '';
                    $stile     = isset($_POST['stile']) ? trim($_POST['stile']) : '';
                    
                    // Recupero stringhe o percorsi dei file per i campi aggiuntivi
                    $portfolio = $_FILES['portfolio']['name'] ?? '';
                    //$documento = $_FILES['documento_identita']['name'] ?? '';
                    $statoValidazione = 'IN_ATTESA'; // Stato di default coerentemente con l'entità EArtista

                    // Istanziamo l'entità specifica EArtista rispettando l'ordine di creaEntitaDaArray
                    $nuovoArtista = new EArtista(
                        0,
                        $nome,
                        $cognome,
                        $dataDiNascita,
                        $indirizzo,
                        $nickname,
                        $telefono,
                        $email,
                        $passwordHash,
                        $immagineProfilo,
                        
                        $biografia,
                        $stile,
                        $documento, // mapped to carta_identita
                        $statoValidazione
                    );

                    // Scrittura persistente sequenziale (UTENTE + ARTISTA) tramite FArtista
                    $risultato = FArtista::store($nuovoArtista);

                } else {

                // ✨ FIX: Chiuso correttamente il costruttore passando la variabile $ruoloDB al posto di quella commentata!

                $nuovoUtente = new EUtente(

                    0,

                    $nome,

                    $cognome,

                    $dataDiNascita,

                    $indirizzo,

                    $nickname,

                    $telefono,

                    $email,

                    $passwordHash,

                    $immagineProfilo,

                    $statoIniziale,

                    $ruoloDB

                );



                // Scrittura persistente nel Database tramite il Foundation Layer

                $risultato = FUtente::store($nuovoUtente);}



                if ($risultato !== null) {

                    // 🟢 REGISTRAZIONE AVVENUTA CON SUCCESSO!
                   if ($ruoloDB === 'Artista') {
                        // ✨ Per l'artista attiviamo il banner "in attesa" che hai nel .tpl
                        $vUtente->smarty->assign('stato_registrazione', 'attesa');
                    } else {
                    $vUtente->smarty->assign('stato_registrazione', 'successo');}

                } else {

                    $vUtente->smarty->assign('errore_registrazione', true);

                    $vUtente->smarty->assign('messaggio_errore', 'Errore critico durante il salvataggio nel database.');

                }



            } catch (\InvalidArgumentException $e) {

                $vUtente->smarty->assign('errore_registrazione', true);

                $vUtente->smarty->assign('messaggio_errore', $e->getMessage());

            }

           

            // Ricarichiamo la pagina mostrando i banner di successo o di errore

            $vUtente->smarty->display('Registrazione.tpl');

           

        } else {

            // Richiesta GET: form pulito

            $vUtente = new VUtente();

            $vUtente->smarty->display('Registrazione.tpl');

        }

    }
/**
 * Mostra il profilo/dashboard dell'artista loggato.
 * Risponde all'URL: /Gallerist/utente/profilo
 */
public function profilo() {
    $sessione = USession::getInstance();

    // Solo utenti loggati
    if (!$sessione->esisteValore('utente_loggato')) {
        header('Location: /Gallerist/utente/login');
        exit;
    }

    $utente = $sessione->getValore('utente_loggato');

    // Solo artisti
    if ($utente->getRuolo() === EUtente::RUOLO_ARTISTA) {
        
    

    $artistaId = $utente->getId();

    // Opere dell'artista
    $mieOpere = FOpera::loadByArtista($artistaId, -1) ?? [];

    // Recensioni ricevute (tramite le opere dell'artista)
    $recensioni = FPersistentManager::load('ECommento', 'idAutore', $artistaId) ?? [];
    if (!is_array($recensioni)) {
        $recensioni = [$recensioni];
    }
    if (count($recensioni) > 0) {
    $somma = array_reduce($recensioni, function($carry, $r) {
        return $carry + $r->getValutazione();
    }, 0);
    $utente->setValutazioneMedia(round($somma / count($recensioni), 1));
}
$offerte = FOfferta::loadByField('idOpera', $artistaId) ?? [];
if (!is_array($offerte)) {
    $offerte = [$offerte];
}

// Filtra solo le offerte sulle opere dell'artista
$offerteRicevute = [];
foreach ($mieOpere as $opera) {
    $offerteOpera = FOfferta::loadByField('idOpera', $opera->getId());
    if ($offerteOpera !== null) {
        if (!is_array($offerteOpera)) $offerteOpera = [$offerteOpera];
        foreach ($offerteOpera as $offerta) {
            if ($offerta->getStato() === EOfferta::STATO_INVIATA) {
                $offerteRicevute[] = $offerta;
            }
        }
    }
}
    // Statistiche
    $pubblicate  = 0;
    $inVendita   = 0;
    $vendute     = 0;
    $guadagni    = 0.0;

    foreach ($mieOpere as $opera) {
        $stato = $opera->getStatoOpera()->getNomeStato();
if ($stato === 'pubblicata') $pubblicate++;
if ($stato === 'in_vendita') { $pubblicate++; $inVendita++; }
if ($stato === 'Venduta')    $guadagni += (float)$opera->getPrezzo()->getValore();
    }

    $statistiche = [
        'pubblicate'       => $pubblicate,
        'in_vendita'       => $inVendita,
        'interazioni'      => count($recensioni),
        'numero_recensioni' => count($recensioni),
        'guadagni'         => $guadagni,
    ];

    $vUtente = new VUtente();
    $vUtente->smarty->assign('utente',     $utente);
    $vUtente->smarty->assign('mie_opere',  $mieOpere);
    $vUtente->smarty->assign('recensioni', $recensioni);
    $vUtente->smarty->assign('offerte_ricevute', $offerteRicevute);
    $vUtente->smarty->assign('statistiche', $statistiche);
    $vUtente->smarty->display('DashboardArtista.tpl');
} else {
        // ✅ Utente normale → mostra profilo pubblico
        $vUtente = new VUtente();
        $vUtente->smarty->assign('utente', $utente);
        $vUtente->smarty->assign('opere',  []);
        $vUtente->smarty->display('ProfiloPubblico.tpl');
    }}
public function logout() {
    USession::getInstance()->distruggi();
    header('Location: /Gallerist/utente/login');
    exit;
}
public function modificaNickname(): void {
    $sessione = USession::getInstance();

    if (!$sessione->esisteValore('utente_loggato')) {
        header('Location: /Gallerist/utente/login');
        exit;
    }

    $utente   = $sessione->getValore('utente_loggato');
    $nickname = trim($_POST['nickname'] ?? '');

    if (!empty($nickname)) {
        $db = FDataBase::getInstance();
        $db->queryDB(
            "UPDATE utente SET nickname = :nickname WHERE id = :id",
            [':nickname' => $nickname, ':id' => $utente->getId()]
        );

        // Aggiorna la sessione
        $utente->setNickname($nickname);
        $sessione->setValue('utente_loggato', $utente);
    }

    header('Location: /Gallerist/utente/profilo');
    exit;
}
public function modificaBiografia(): void {
    $sessione = USession::getInstance();

    if (!$sessione->esisteValore('utente_loggato')) {
        header('Location: /Gallerist/utente/login');
        exit;
    }

    $utente    = $sessione->getValore('utente_loggato');
    $biografia = trim($_POST['biografia'] ?? '');

    $db = FDataBase::getInstance();
    $db->queryDB(
        "UPDATE artista SET biografia = :biografia WHERE idUtente = :id",
        [':biografia' => $biografia, ':id' => $utente->getId()]
    );

    // Aggiorna la sessione se è un EArtista
    if ($utente instanceof EArtista) {
        $utente->setBiografia($biografia);
        $sessione->setValue('utente_loggato', $utente);
    }

    header('Location: /Gallerist/utente/profilo');
    exit;
}
}