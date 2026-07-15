<?php

class VUtente 
{
    public $smarty;

    public function __construct() 
    {
        // Inizializziamo Smarty. 
        
        $this->smarty =StartSmarty::configuration();
        
        
    }

    /**
     * Carica e mostra il form di Login
     * @param string|null $errore Messaggio opzionale se le credenziali sono errate
     */
    public function mostraFormLogin($errore = null) 
    {
        // Se il controller ci passa un messaggio di errore, lo "assegniamo" a Smarty
        // così potremo mostrarlo dentro un box rosso Bulma nel template
        if ($errore !== null) {
            $this->smarty->assign('errore', $errore);
        }

        // Mostra il file login.tpl
        
        $this->smarty->display('Login.tpl');
    }

    /**
     * Carica e mostra il form di Registrazione
     * @param string|null $errore Messaggio opzionale se ci sono problemi (es. username già preso)
     */
    public function mostraFormRegistrazione($errore = null) 
    {
        if ($errore !== null) {
            $this->smarty->assign('errore', $errore);
        }

        // Mostra il file registrazione.tpl
        $this->smarty->display('Registrazione.tpl');
    }
}