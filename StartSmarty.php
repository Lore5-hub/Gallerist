<?php
require('/home/vol15_1/infinityfree.com/if0_42435744/htdocs/vendor/autoload.php');

class StartSmarty {
    static function configuration() {
        $smarty = new Smarty\Smarty();
        $baseDir = '/home/vol15_1/infinityfree.com/if0_42435744/htdocs/';
        $smarty->setTemplateDir($baseDir . 'Smarty/Templates/');
        $smarty->setCompileDir($baseDir . 'Smarty/TemplatesC/');
        $smarty->setConfigDir($baseDir . 'Smarty/Configs/');
        $smarty->setCacheDir($baseDir . 'Smarty/Cache/');
        $smarty->setCompileCheck(true);
        $sessione = USession::getInstance();
        $smarty->assign('utente_loggato', $sessione->getValore('utente_loggato'));
        return $smarty;
    }
}