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
        try {
            $db = new PDO("mysql:host=127.0.0.1;", $_POST['nomeutente'], $_POST['password']);
            $db->beginTransaction();

            $query  = 'DROP DATABASE IF EXISTS ' . $_POST['nomedb'] . ';';
            $query .= 'CREATE DATABASE ' . $_POST['nomedb'] . ';';
            $query .= 'USE ' . $_POST['nomedb'] . ';';
            $query .= file_get_contents('gallerist.sql'); // ← nome del tuo file SQL

            $db->exec($query);
            $db->commit();

            // Scrittura di config.inc.php
            $file   = fopen('config.inc.php', 'c+');
            $script = '<?php '
                    . '$GLOBALS[\'database\'] = \'' . $_POST['nomedb']    . '\'; '
                    . '$GLOBALS[\'username\'] = \'' . $_POST['nomeutente'] . '\'; '
                    . '$GLOBALS[\'password\'] = \'' . $_POST['password']   . '\'; '
                    . '?>';
            fwrite($file, $script);
            fclose($file);

            $db = null;

        } catch (PDOException $e) {
            echo "Errore durante l'installazione: " . $e->getMessage();
            $db->rollBack();
            die;
        }
    }
}
?>