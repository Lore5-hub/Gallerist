<?php



class VErrore {
    private $smarty;

    public function __construct() {
        // Inizializza Smarty una volta sola per tutta la classe
        $this->smarty = StartSmarty::configuration();
    }

    // Metodo generico per mostrare qualsiasi tipo di errore
    public function mostraErrore($titolo, $messaggio, $codice) {
        $this->smarty->assign('titolo', $titolo);
        $this->smarty->assign('messaggio', $messaggio);
        $this->smarty->assign('codice', $codice);
        $this->smarty->display('errore.tpl');
    }
}
?>