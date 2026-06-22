<?php
require('Smarty/Smarty.class.php');

class StartSmarty{
    static function configuration(){
        $smarty=new Smarty();
        $smarty->template_dir='Smarty/Templates/';
        $smarty->compile_dir='Smarty/TemplatesC/';
        $smarty->config_dir='Smarty/Configs/';
        $smarty->cache_dir='Smarty/Cache/';
        return $smarty;
    }
}