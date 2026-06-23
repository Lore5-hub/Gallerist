<?php
// Utility/USession.php

class USession {

    private static ?USession $instance = null;

    private function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    // 1. SIGILLO SINGLETON: Impedisce la clonazione dell'oggetto
    private function __clone() {}

    // 2. SIGILLO SINGLETON: Impedisce la deserializzazione (es. tramite unserialize)
    private function __wakeup() {}

    public static function getInstance(): USession {
        if (self::$instance === null) {
            self::$instance = new USession();
        }
        return self::$instance;
    }

    public function impostaValore(string $chiave, mixed $valore): void {
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