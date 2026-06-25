<?php
// Control/CFrontController.php

class CFrontController {

    public function run($path)
    { 
       // 1. Pulizia dell'URL: divide la stringa e rimuove gli elementi vuoti.
$segments = array_values(array_filter(explode('/', $path)));

// 2. 🟢 MODIFICA: Usiamo il WHILE al posto dell'IF per eliminare TUTTI i duplicati della cartella
while (isset($segments[0]) && strtolower($segments[0]) === 'gallerist') {
    array_shift($segments);
}

// ⭐ Se l'utente ha scritto "index.php" nell'URL, scartiamo anche questo segmento!
if (isset($segments[0]) && strtolower($segments[0]) === 'index.php') {
    array_shift($segments);
}

        // 3. Identifica Controller, Metodo e Parametri
        // NOTA: Se la vostra homepage si trova in un controller diverso da "Catalogo" (es. "Home"), cambia la parola qui sotto!
        $controllerName = "C" . ucfirst($segments[0] ?? "Catalogo");
        $method         = $segments[1] ?? "homepage";
        
        // Tutti gli elementi dal terzo in poi diventano parametri
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
        // Se hai già creato CErrore, lo usa.
        if (class_exists('CErrore')) {
            $errorController = new CErrore();
            $errorController->mostra404();
        } else {
            // Un fallback di emergenza testuale finché non sviluppi CErrore
            header("HTTP/1.0 404 Not Found");
            echo "<h1>Errore 404 - Pagina non trovata</h1>";
        }
    }
}
?>