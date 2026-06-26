<?php
// Mostra gli errori per debug (togli in produzione)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Path assoluto alla root del progetto
define('BASE_PATH', __DIR__ . '/');

require_once BASE_PATH . 'Utility/autoload.php';
require_once BASE_PATH . 'StartSmarty.php';
require_once BASE_PATH . 'Installation.php';
require_once BASE_PATH . 'Smarty/Smarty.class.php';

// Avvia la sessione subito, prima di qualsiasi output
USession::getInstance();

// Usa path assoluto per verificare l'installazione
if (file_exists(BASE_PATH . 'config.inc.php')) {
    $fcontroller = new CFrontController();
    $fcontroller->run($_SERVER['REQUEST_URI']);
} else {
    Installation::begin();
}