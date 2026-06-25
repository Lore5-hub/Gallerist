<?php
require_once 'Utility/autoload.php';
require_once 'StartSmarty.php';
require_once 'Installation.php';
require_once 'Smarty/Smarty.class.php';
 // si verifica se l'installazione è avvenuta, altrimenti viene effettuata (ramo else)
if (Installation::verificaInstallazione()){
    $fcontroller=new CFrontController();
    $fcontroller->run($_SERVER['REQUEST_URI']);
}
else
  Installation::begin();