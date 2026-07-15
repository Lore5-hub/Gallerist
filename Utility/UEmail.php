<?php
// NOTA: richiede che 'vendor/autoload.php' (Composer) sia stato incluso
// a monte in modo da
// avere disponibili le classi PHPMailer\PHPMailer\PHPMailer e Exception.

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception as PHPMailerException;

class UEmail {

    /**
     * Invia un'email tramite SMTP (Mailtrap in locale, secondo config.inc.php).
     *
     * @param string $destinatario Indirizzo email del destinatario
     * @param string $oggetto      Oggetto dell'email
     * @param string $corpoHtml    Corpo dell'email in HTML
     * @return bool True se l'invio è andato a buon fine, false altrimenti
     */
    public static function inviaEmail(string $destinatario, string $oggetto, string $corpoHtml): bool {
        $mail = new PHPMailer(true);

        try {
            // --- Configurazione server SMTP ---
            $mail->isSMTP();
            $mail->Host       = SMTP_HOST;
            $mail->SMTPAuth   = true;
            $mail->Username   = SMTP_USER;
            $mail->Password   = SMTP_PASS;
            $mail->SMTPSecure = defined('SMTP_SECURE') ? SMTP_SECURE : PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = SMTP_PORT;
            $mail->CharSet    = 'UTF-8';

            // --- Mittente e destinatario ---
            $mittenteEmail = defined('SMTP_FROM_EMAIL') ? SMTP_FROM_EMAIL : SMTP_USER;
            $mittenteNome  = defined('SMTP_FROM_NAME') ? SMTP_FROM_NAME : 'Gallerist';

            $mail->setFrom($mittenteEmail, $mittenteNome);
            $mail->addAddress($destinatario);

            // --- Contenuto ---
            $mail->isHTML(true);
            $mail->Subject = $oggetto;
            $mail->Body    = $corpoHtml;
            $mail->AltBody = strip_tags($corpoHtml);

            $mail->send();
            return true;

        } catch (PHPMailerException $e) {
            error_log("UEmail::inviaEmail - invio fallito verso {$destinatario}: " . $mail->ErrorInfo);
            return false;
        }
    }

    /**
     * Corpo HTML per l'email di benvenuto inviata al nuovo Utente registrato.
     */
    public static function corpoBenvenutoUtente(string $nome): string {
        $nomeEsc = htmlspecialchars($nome, ENT_QUOTES, 'UTF-8');
        return "
            <h2>Benvenuto su Gallerist, {$nomeEsc}!</h2>
            <p>La tua registrazione è stata completata con successo.</p>
            <p>Da ora puoi accedere al catalogo, seguire gli artisti che preferisci e acquistare opere direttamente dalla piattaforma.</p>
            <p>Grazie per esserti unito a noi.</p>
        ";
    }

    /**
     * Corpo HTML per la notifica all'amministratore quando un nuovo Artista
     * si registra e resta in attesa di validazione.
     */
    public static function corpoNotificaNuovoArtista(string $nome, string $cognome, string $email): string {
        $nomeEsc    = htmlspecialchars($nome, ENT_QUOTES, 'UTF-8');
        $cognomeEsc = htmlspecialchars($cognome, ENT_QUOTES, 'UTF-8');
        $emailEsc   = htmlspecialchars($email, ENT_QUOTES, 'UTF-8');
        return "
            <h2>Nuovo profilo artista in attesa</h2>
            <p><strong>Nome:</strong> {$nomeEsc} {$cognomeEsc}</p>
            <p><strong>Email:</strong> {$emailEsc}</p>
            <p>Il profilo è in stato di attesa e richiede validazione da parte dell'amministrazione.</p>
        ";
    }

    /**
     * Corpo HTML per l'email inviata all'Artista quando l'admin approva il suo profilo.
     * Destinatario: l'artista stesso (non l'admin) — tono diretto, nessun dato ridondante.
     */
    public static function corpoArtistaApprovato(string $nome): string {
        $nomeEsc = htmlspecialchars($nome, ENT_QUOTES, 'UTF-8');
        return "
            <h2>Il tuo profilo artista è stato approvato!</h2>
            <p>Ciao {$nomeEsc}, buone notizie: il tuo profilo su Gallerist è stato validato dall'amministrazione ed è ora attivo sulla piattaforma.</p>
            <p>Puoi iniziare a caricare le tue opere quando vuoi.</p>
        ";
    }
    public static function inviaEmailRecuperoPassword(string $destinatario, string $linkReset): bool {
    $oggetto = 'Recupero Password - Gallerist';
    $corpo   = "
        <h2>Recupero Password</h2>
        <p>Hai richiesto il reset della tua password su Gallerist.</p>
        <p>Clicca sul link qui sotto per impostare una nuova password:</p>
        <p><a href='{$linkReset}'>Reimposta la mia password</a></p>
        <p>Il link scadrà tra 1 ora.</p>
        <p>Se non hai richiesto il reset, ignora questa email.</p>
    ";
    return self::inviaEmail($destinatario, $oggetto, $corpo);
}
public static function corpoNotificaNuovaOfferta(string $nomeArtista, string $titoloOpera, float $cifra, string $nicknameMittente, string $nota = ''): string {
    $nomeEsc   = htmlspecialchars($nomeArtista, ENT_QUOTES, 'UTF-8');
    $titoloEsc = htmlspecialchars($titoloOpera, ENT_QUOTES, 'UTF-8');
    $noteEsc   = htmlspecialchars($nota, ENT_QUOTES, 'UTF-8');
    $cifraFormattata = number_format($cifra, 2, ',', '.');

    return "
        <h2>Hai ricevuto una nuova offerta, {$nomeEsc}!</h2>
        <p>L'utente <strong>{$nicknameMittente}</strong> ha proposto <strong>€ {$cifraFormattata}</strong> per la tua opera <strong>{$titoloEsc}</strong>.</p>
        " . (!empty($nota) ? "<p><em>Nota: {$noteEsc}</em></p>" : "") . "
        <p>Accedi alla tua dashboard per accettare o rifiutare l'offerta.</p>
    ";
}
public static function corpoConfermaAcquisto(string $nomeAcquirente, string $titoloOpera, float $prezzoTotale): string {
    $nomeEsc   = htmlspecialchars($nomeAcquirente, ENT_QUOTES, 'UTF-8');
    $titoloEsc = htmlspecialchars($titoloOpera, ENT_QUOTES, 'UTF-8');
    $prezzoFormattato = number_format($prezzoTotale, 2, ',', '.');

    return "
        <h2>Acquisto confermato, {$nomeEsc}!</h2>
        <p>Il tuo acquisto di <strong>{$titoloEsc}</strong> è stato completato con successo.</p>
        <p><strong>Totale pagato:</strong> € {$prezzoFormattato}</p>
        <p>Riceverai l'opera all'indirizzo di spedizione indicato.</p>
        <p>Grazie per aver acquistato su Gallerist!</p>
    ";
}
public static function corpoOffertaAccettata(string $nomeAcquirente, string $titoloOpera, float $cifra): string {
    $nomeEsc   = htmlspecialchars($nomeAcquirente, ENT_QUOTES, 'UTF-8');
    $titoloEsc = htmlspecialchars($titoloOpera, ENT_QUOTES, 'UTF-8');
    $cifraFormattata = number_format($cifra, 2, ',', '.');

    return "
        <h2>La tua offerta è stata accettata, {$nomeEsc}!</h2>
        <p>L'artista ha accettato la tua offerta di <strong>€ {$cifraFormattata}</strong> per l'opera <strong>{$titoloEsc}</strong>.</p>
        <p>L'acquisto è stato completato con successo.</p>
        <p>Grazie per aver acquistato su Gallerist!</p>
    ";
}
public static function corpoProvvedimento(string $nomeUtente, string $tipoBan, string $nota): string {
    $nomeEsc = htmlspecialchars($nomeUtente, ENT_QUOTES, 'UTF-8');
    $notaEsc = htmlspecialchars($nota, ENT_QUOTES, 'UTF-8');
    $tipo    = $tipoBan === 'permanente' ? 'permanente' : 'temporaneo';

    return "
        <h2>Provvedimento sul tuo account, {$nomeEsc}</h2>
        <p>Il tuo account su Gallerist è stato sospeso con un ban <strong>{$tipo}</strong>.</p>
        " . (!empty($nota) ? "<p><strong>Motivazione:</strong> {$notaEsc}</p>" : "") . "
        <p>Per contestare il provvedimento contatta l'amministrazione.</p>
    ";
}
}
?>