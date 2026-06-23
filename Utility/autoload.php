<?php

function my_autoloader($className)
{
    // dirname(__DIR__) ottiene la root del progetto (Gallerist) in modo pulito
    $baseDir = dirname(__DIR__) . '/';

    // Mappatura rigida delle cartelle consentite
    $cartelle = [
        'E' => 'Entity/',
        'F' => 'Foundation/',
        'V' => 'View/',
        'C' => 'Control/',
        'U' => 'Utility/',
    ];

    $iniziale = $className[0];

    // Cerca il file SOLO se la classe inizia con una lettera valida per il VCEF
    if (isset($cartelle[$iniziale])) {
        
        $file = $baseDir . $cartelle[$iniziale] . $className . '.php';

        // Se il file esiste fisicamente, lo include
        if (file_exists($file)) {
            require_once $file;
        }
    }
}

spl_autoload_register('my_autoloader');

?>