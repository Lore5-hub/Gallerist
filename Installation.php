<?php
class Installation {

    /**
     * Verifica se l'installazione è già avvenuta controllando l'esistenza di config.inc.php
     */
    public static function verificaInstallazione(): bool {
        return file_exists('config.inc.php');
    }

    /**
     * Gestisce il flusso di installazione:
     * - GET: invia cookie di verifica e mostra il form
     * - POST: controlla i requisiti e, se ok, procede con l'installazione
     */
    public static function begin(): void {
        $smarty = StartSmarty::configuration();

        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            setcookie('verifica_cookie', 'verifica', time() + 3600);
            $smarty->display('installazione.tpl');
        } else {
            $noPHP    = false;
            $noCookie = false;
            $noJS     = false;

            // Controllo versione PHP (minimo 8.0 per Gallerist, che usa union types e named args)
            if (version_compare(PHP_VERSION, '8.0.0', '<')) {
                $noPHP = true;
                $smarty->assign('nophpv', $noPHP);
            }

            // Controllo cookie
            if (!isset($_COOKIE['verifica_cookie'])) {
                $noCookie = true;
                $smarty->assign('nocookie', $noCookie);
            }

            // Controllo JavaScript
            if (!isset($_COOKIE['checkjs'])) {
                $noJS = true;
                $smarty->assign('nojs', $noJS);
            }

            if ($noPHP || $noCookie || $noJS) {
                $smarty->display('installazione.tpl');
            } else {
                // Pulizia cookie temporanei
                setcookie('verifica_cookie', '', time() - 3600);
                setcookie('checkjs', '', time() - 3600);

                static::install();
                header('Location: /Gallerist');
            }
        }
    }

    /**
     * Crea il database eseguendo gallerist.sql e scrive config.inc.php
     */
private static function install(): void {
    #preg_replace('/[^a-zA-Z0-9_]/', '', $_POST['nomedb']); // Sanitize database name
    $dbName = preg_replace('/[^a-zA-Z0-9_]/', '', $_POST['nomedb']);
    #preg_replace('/[^a-zA-Z0-9_]/', '', $_POST['nomeutente']); // sanitizza username mettendo \ davanti a eventuali caratteri speciali
    $dbUser = addslashes($_POST['nomeutente']);
    $dbPass = addslashes($_POST['password']);

    try {
        $db = new PDO("mysql:host=127.0.0.1;", $dbUser, $dbPass);
        $db->beginTransaction(); #da questo momento le modifiche al database non sono definitive finché non viene fatto il commit

        $query  = 'DROP DATABASE IF EXISTS `' . $dbName . '`;'; #cancella il database se esiste già
        $query .= 'CREATE DATABASE `' . $dbName . '`;'; #crea il database
        $query .= 'USE `' . $dbName . '`;'; #entra nel database appena creato
        $query .= file_get_contents('gallerist.sql'); #legge il file gallerist.sql e lo aggiunge alla query

        $db->exec($query); #esegue tutte le query in un'unica chiamata, utile per eseguire più query in una volta sola
        $db->commit(); #sal\va le modifiche al database rendendole definitive

        //
        $file   = fopen('config.inc.php', 'c+'); #apre il file config.inc.php in modalità scrittura, se non esiste lo crea
        $script = '<?php '
        # scrive il contenuto del file config.inc.php, definendo le costanti per la connessione al database e il tempo di scadenza dei cookie
                . 'define(\'COOKIE_EXP_TIME\', 3600); '
                . '$GLOBALS[\'database\'] = \'' . $dbName . '\'; '
                . '$GLOBALS[\'username\'] = \'' . $dbUser . '\'; '
                . '$GLOBALS[\'password\'] = \'' . $dbPass . '\'; '
                . '?>';
        fwrite($file, $script);
        fclose($file);

        $db = null; #chiude la connessione PDO al database

    } catch (PDOException $e) {
        echo "Errore durante l'installazione: " . $e->getMessage();
        if ($db && $db->inTransaction()) {
            $db->rollBack(); #annulla tutte le modifiche al database se c'è stato un errore durante l'esecuzione delle query
        }
        die; #interrompe l'esecuzione dello script
    }
}

}