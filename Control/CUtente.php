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
    $recensioni = [];
foreach ($mieOpere as $opera) {
    $commentiOpera = FPersistentManager::load('ECommento', 'idOpera', $opera->getId());
    if ($commentiOpera !== null) {
        if (!is_array($commentiOpera)) $commentiOpera = [$commentiOpera];
        foreach ($commentiOpera as $commento) {
            $recensioni[] = $commento;
        }
    }
}
    if (count($recensioni) > 0) {
    $somma = array_reduce($recensioni, function($carry, $r) {
        return $carry + $r->getValutazione();
    }, 0);
    $utente->setValutazioneMedia(round($somma / count($recensioni), 1));
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
        $recensioniScritte = [];
    $commenti = FPersistentManager::load('ECommento', 'idAutore', $utente->getId());
    if ($commenti !== null) {
        if (!is_array($commenti)) $commenti = [$commenti];
        $recensioniScritte = $commenti;
    }

    // Conta acquisti
    $db = FDataBase::getInstance();
    $resAcquisti = $db->queryDB(
        "SELECT COUNT(*) as totale FROM ordine WHERE idUtente = :id",
        [':id' => $utente->getId()]
    );
    $numeroAcquisti = $resAcquisti ? (int)$resAcquisti[0]['totale'] : 0;

    $vUtente = new VUtente();
    $vUtente->smarty->assign('utente',             $utente);
    $vUtente->smarty->assign('opere',              []);
    $vUtente->smarty->assign('recensioni_scritte', $recensioniScritte);
    $vUtente->smarty->assign('numero_acquisti',    $numeroAcquisti);
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
public function cambiaFotoProfilo(): void {
    $sessione = USession::getInstance();

    if (!$sessione->esisteValore('utente_loggato')) {
        header('Location: /Gallerist/utente/login');
        exit;
    }

    $utente = $sessione->getValore('utente_loggato');

    if (isset($_FILES['immagine_profilo']) && $_FILES['immagine_profilo']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath   = $_FILES['immagine_profilo']['tmp_name'];
        $fileName      = $_FILES['immagine_profilo']['name'];
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
                $nuovoPath = '/Gallerist/uploads/profilo/' . $nuovoNomeFile;

                // Aggiorna nel DB
                $db = FDataBase::getInstance();
                $db->queryDB(
                    "UPDATE utente SET immagine_profilo = :img WHERE id = :id",
                    [':img' => $nuovoPath, ':id' => $utente->getId()]
                );

                // Aggiorna in sessione
                $utente->setImmagineProfilo($nuovoPath);
                $sessione->setValue('utente_loggato', $utente);
            }
        }
    }

    header('Location: /Gallerist/utente/profilo');
    exit;
}
public function storicoVendite(): void {
    $sessione = USession::getInstance();

    if (!$sessione->esisteValore('utente_loggato')) {
        header('Location: /Gallerist/utente/login');
        exit;
    }

    $artista = $sessione->getValore('utente_loggato');
    if ($artista->getRuolo() !== EUtente::RUOLO_ARTISTA) {
        header('Location: /Gallerist/catalogo/esploraCatalogo');
        exit;
    }
    $periodo = $_GET['periodo'] ?? 'all';
    $db = FDataBase::getInstance();
    $filtroData = '';
    $params = [':id' => $artista->getId()];
    
    if ($periodo !== 'all') {
        $filtroData = "AND ord.data >= :dataInizio";
        $params[':dataInizio'] = date('Y-m-d', strtotime("-{$periodo} days"));
    }
    // Storico vendite reale
    $resVendite = $db->queryDB(
        "SELECT o.titolo as titolo_opera, o.categoria, o.prezzo,
                ord.data,
                o.prezzo * 0.15 as commissione,
                o.prezzo * 0.85 as netto
         FROM ordine ord
         INNER JOIN opera o ON o.id = ord.idOpera
          WHERE o.idArtista = :id {$filtroData}
         ORDER BY ord.data DESC",
         $params
    
    );

    $storicoVendite = $resVendite ?? [];

    // Calcola statistiche
    $entrateLorde = 0.0;
    $commissioni  = 0.0;
    $ricavoNetto  = 0.0;
    $votiTotali   = 0;
    $numVoti      = 0;

    foreach ($storicoVendite as $v) {
        $entrateLorde += (float)$v['prezzo'];
        $commissioni  += (float)$v['commissione'];
        $ricavoNetto  += (float)$v['netto'];
    }

    // Valutazione media dalle recensioni
    $resVoti = $db->queryDB(
        "SELECT AVG(c.valutazione) as media, COUNT(*) as num
         FROM commento c
         INNER JOIN opera o ON o.id = c.idOpera
         WHERE o.idArtista = :id",
        [':id' => $artista->getId()]
    );
    $votoMedio = $resVoti ? round((float)$resVoti[0]['media'], 1) : 0.0;
$resTipi = $db->queryDB(
    "SELECT tipo, COUNT(*) as num
     FROM ordine ord
     INNER JOIN opera o ON o.id = ord.idOpera
     WHERE o.idArtista = :id
     GROUP BY tipo",
    [':id' => $artista->getId()]
);

$venditeDirette = 0;
$venditeOfferta = 0;
foreach ($resTipi ?? [] as $row) {
    if ($row['tipo'] === 'diretto')  $venditeDirette = (int)$row['num'];
    if ($row['tipo'] === 'offerta')  $venditeOfferta = (int)$row['num'];
}

// Aggiungi questa query in storicoVendite()
$resCategorie = $db->queryDB(
    "SELECT o.categoria, SUM(o.prezzo) as totale
     FROM ordine ord
     INNER JOIN opera o ON o.id = ord.idOpera
     WHERE o.idArtista = :id
     GROUP BY o.categoria",
    [':id' => $artista->getId()]
);

$labelsCategorie = [];
$datiCategorie   = [];
foreach ($resCategorie ?? [] as $row) {
    $labelsCategorie[] = $row['categoria'];
    $datiCategorie[]   = (float)$row['totale'];
}


    $statistiche = [
        'entrate_lorde'  => $entrateLorde,
        'numero_vendite' => count($storicoVendite),
        'voto_medio'     => $votoMedio,
        'ricavo_netto'   => $ricavoNetto,
        'commissioni'    => $commissioni,
    ];
$statistiche['vendite_dirette'] = $venditeDirette;
$statistiche['vendite_offerta'] = $venditeOfferta;
$statistiche['labels_categorie'] = $labelsCategorie;
$statistiche['dati_categorie']   = $datiCategorie;
    $vUtente = new VUtente();
    $vUtente->smarty->assign('statistiche',     $statistiche);
    $vUtente->smarty->assign('storico_vendite', $storicoVendite);
    $vUtente->smarty->assign('periodo_selezionato', $periodo);
    $vUtente->smarty->display('StoricoVendite.tpl');
}
/**
 * Mostra il form per il recupero password.
 * Risponde all'URL: /Gallerist/utente/recuperoPassword
 */
public function recuperoPassword(): void {
    $vUtente = new VUtente();
    $vUtente->smarty->display('RecuperoPassword.tpl');
}

/**
 * Invia il link di reset via email.
 * Risponde all'URL: /Gallerist/utente/inviaLinkReset
 */
public function inviaLinkReset(): void {
    $email = trim($_POST['email'] ?? '');
    $vUtente = new VUtente();

    if (empty($email)) {
        $vUtente->smarty->assign('errore', 'Inserisci un indirizzo email valido.');
        $vUtente->smarty->display('RecuperoPassword.tpl');
        return;
    }

    // Verifica che l'email esista nel DB
    $utente = FPersistentManager::load('EUtente', 'email', $email);
    
    // Per sicurezza mostriamo sempre lo stesso messaggio
    // anche se l'email non esiste (evita enumeration attack)
    if ($utente instanceof EUtente) {
        $token    = bin2hex(random_bytes(32));
        $scadenza = date('Y-m-d H:i:s', strtotime('+1 hour'));

        $db = FDataBase::getInstance();
        $db->queryDB(
            "INSERT INTO password_reset (email, token, scadenza, usato) 
             VALUES (:email, :token, :scadenza, 0)",
            [':email' => $email, ':token' => $token, ':scadenza' => $scadenza]
        );

        $linkReset = "http://localhost/Gallerist/utente/resetPassword?token=" . $token;
        UEmail::inviaEmailRecuperoPassword($email, $linkReset);
    }

    $vUtente->smarty->assign('successo', 'Se l\'email è registrata, riceverai il link di reset a breve.');
    $vUtente->smarty->display('RecuperoPassword.tpl');
}

/**
 * Mostra il form per inserire la nuova password.
 * Risponde all'URL: /Gallerist/utente/resetPassword?token=xxx
 */
public function resetPassword(): void {
    $token   = trim($_GET['token'] ?? '');
    $vUtente = new VUtente();

    if (empty($token)) {
        header('Location: /Gallerist/utente/login');
        exit;
    }

    // Verifica token
    $db     = FDataBase::getInstance();
    $result = $db->queryDB(
        "SELECT * FROM password_reset 
         WHERE token = :token AND usato = 0 AND scadenza > NOW()",
        [':token' => $token]
    );

    if (empty($result)) {
        $vUtente->smarty->assign('errore', 'Il link di reset non è valido o è scaduto.');
        $vUtente->smarty->display('RecuperoPassword.tpl');
        return;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nuovaPassword = trim($_POST['password'] ?? '');
        $conferma      = trim($_POST['conferma_password'] ?? '');

        if (strlen($nuovaPassword) < 8) {
            $vUtente->smarty->assign('errore', 'La password deve essere di almeno 8 caratteri.');
            $vUtente->smarty->assign('token', $token);
            $vUtente->smarty->display('ResetPassword.tpl');
            return;
        }

        if ($nuovaPassword !== $conferma) {
            $vUtente->smarty->assign('errore', 'Le password non coincidono.');
            $vUtente->smarty->assign('token', $token);
            $vUtente->smarty->display('ResetPassword.tpl');
            return;
        }

        $email        = $result[0]['email'];
        $passwordHash = password_hash($nuovaPassword, PASSWORD_BCRYPT);

        // Aggiorna password
        $db->queryDB(
            "UPDATE utente SET password = :password WHERE email = :email",
            [':password' => $passwordHash, ':email' => $email]
        );

        // Marca token come usato
        $db->queryDB(
            "UPDATE password_reset SET usato = 1 WHERE token = :token",
            [':token' => $token]
        );

        $vUtente->smarty->assign('successo', 'Password aggiornata con successo!');
        $vUtente->smarty->display('Login.tpl');
        return;
    }

    $vUtente->smarty->assign('token', $token);
    $vUtente->smarty->display('ResetPassword.tpl');
}
}