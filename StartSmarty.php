<?php
require('Smarty/Smarty.class.php');

class StartSmarty{
    static function configuration(){
        $smarty=new Smarty\Smarty();
        $smarty->setTemplateDir('Smarty/Templates/');
        $smarty->setCompileDir('Smarty/TemplatesC/');
        $smarty->setConfigDir('Smarty/Configs/');
        $smarty->setCacheDir('Smarty/Cache/');
         $smarty->setCompileCheck(true);
         $sessione = USession::getInstance();
    $smarty->assign('utente_loggato', $sessione->getValore('utente_loggato'));
        return $smarty;
    }
}