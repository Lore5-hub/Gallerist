<?php
require('Smarty/Smarty.class.php');

class StartSmarty{
    static function configuration(){
        $smarty=new Smarty\Smarty();
        $smarty->setTemplateDir('Smarty/Templates/');
        $smarty->setCompileDir('Smarty/TemplatesC/');
        $smarty->setConfigDir('Smarty/Configs/');
        $smarty->setCacheDir('Smarty/Cache/');
        return $smarty;
    }
}