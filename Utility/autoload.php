<?php
require_once __DIR__ . '/../vendor/autoload.php';

function my_autoloader($className)
{
    $baseDir = dirname(__DIR__) . '/';

    $cartelle = [
        'E' => 'Entity/',
        'F' => 'Foundation/',
        'V' => 'View/',
        'C' => 'Control/',
        'U' => 'Utility/',
    ];

    $iniziale = $className[0];

    if (isset($cartelle[$iniziale])) {
        $file = $baseDir . $cartelle[$iniziale] . $className . '.php';
        if (file_exists($file)) {
            require_once $file;
        }
    }
}

spl_autoload_register('my_autoloader');
?>