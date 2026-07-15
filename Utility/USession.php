<?php
// Utility/USession.php

class USession {

    private static ?USession $instance = null;

    private function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_set_cookie_params([
                'lifetime' => defined('COOKIE_EXP_TIME') ? COOKIE_EXP_TIME : 0,
                'path'     => '/',
                'domain'   => '',       // vuoto = dominio corrente
                'secure'   => isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
                'httponly' => true, //serve per evitare XSS con javascript che permetterebbe di leggere i cookie, così il coockie è visibile solo dal server nelle richieste HTTP
                'samesite' => 'Lax',
            ]);
            session_start();
        }
    }

    // 1. SIGILLO SINGLETON: Impedisce la clonazione dell'oggetto
    private function __clone() {}

    // 2. SIGILLO SINGLETON: Impedisce la deserializzazione (es. tramite unserialize)
    public function __wakeup() {}

    public static function getInstance(): USession {
        if (self::$instance === null) {
            self::$instance = new USession();
        }
        return self::$instance;
    }

    public function setValue(string $chiave, mixed $valore): void {
        $_SESSION[$chiave] = $valore;
    }

    public function getValore(string $chiave): mixed {
        return $_SESSION[$chiave] ?? null;
    }

    public function esisteValore(string $chiave): bool {
        return isset($_SESSION[$chiave]);
    }

    public function eliminaValore(string $chiave): void {
        unset($_SESSION[$chiave]);
    }

    public function distruggi(): void {
        // 1. Svuota l'array RAM in memoria
        $_SESSION = []; 
        
        // 2. Distrugge i dati fisici sul server
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_destroy();
        }
        
        self::$instance = null;
    }
}
?>