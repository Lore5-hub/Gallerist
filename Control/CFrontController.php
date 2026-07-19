<?php
// Control/CFrontController.php

class CFrontController {

    public function run($path)
    { 
        //  Se nell'URL c'è un punto interrogativo (richiesta GET), 
        // tagliamo via tutto ciò che viene dopo prima di analizzare i segmenti.
        if (strpos($path, '?') !== false) {
            $path = explode('?', $path)[0];
        }

        // 1. Pulizia dell'URL: divide la stringa e rimuove gli elementi vuoti.
        $segments = array_values(array_filter(explode('/', $path)));

        // 2. Usiamo il WHILE al posto dell'IF per eliminare TUTTI i duplicati della cartella
        while (isset($segments[0]) && strtolower($segments[0]) === 'gallerist') {
            array_shift($segments);
        }

        // Se l'utente ha scritto "index.php" nell'URL, scartiamo anche questo segmento!
        if (isset($segments[0]) && strtolower($segments[0]) === 'index.php') {
            array_shift($segments);
        }
        
// Timeout sessione: 30 minuti di inattività
$timeoutMinuti = 30;
$sessione = USession::getInstance();

if ($sessione->esisteValore('ultimo_accesso')) {
    $inattivita = time() - $sessione->getValore('ultimo_accesso');
    if ($inattivita > ($timeoutMinuti * 60)) {
        $sessione->distruggi();
        header('Location: /utente/login?sessione=scaduta');
        exit;
    }
}
$sessione->setValue('ultimo_accesso', time());
         $estensioniStatiche = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'css', 'js'];
$estensione = strtolower(pathinfo($path, PATHINFO_EXTENSION));
if (!in_array($estensione, $estensioniStatiche)) {
    $visita = new EVisita(0, $path, new DateTimeImmutable(), session_id());
    FPersistentManager::store($visita);
}
        // 3. Identifica Controller, Metodo e Parametri
        $controllerName = "C" . ucfirst($segments[0] ?? "Catalogo");
        $method         = $segments[1] ?? "homepage";
        
        // Tutti gli elementi dal terzo in poi diventano parametri (se usati nell'URL path)
        $params         = array_slice($segments, 2);

        // 4. Deleghiamo il lavoro pesante all'Autoloader e a PHP!
        if (class_exists($controllerName)) {
            
            $controllerInstance = new $controllerName();

            // Verifichiamo che il metodo richiesto esista
            if (method_exists($controllerInstance, $method)) {
                
                // Invochiamo il metodo passando i parametri
                $controllerInstance->$method(...$params);
                return; // Tutto è andato bene, usciamo!
            }
        }

        // 5. Fallback: Se la classe o il metodo non esistono, mostriamo un Errore 404
        $this->mostraErrore404();
    }

    /**
     * Il Front Controller non chiama la View, ma delega a un Controller dedicato.
     */
    private function mostraErrore404()
    {
        if (class_exists('CErrore')) {
            $errorController = new CErrore();
            $errorController->mostra404();
        } else {
            header("HTTP/1.0 404 Not Found");
            echo "<h1>Errore 404 - Pagina non trovata</h1>";
        }
    }
}
?>