<?php

class CUtente 
{
    // Questo è il metodo chiamato dall'URL /Gallerist/utente/login
    public function login() 
    {
        // 1. Se l'utente ha appena inviato il form di login (richiesta POST)
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';

            // Qui verificherai le credenziali sul Database tramite i tuoi Foundation
            // Se sono corrette, salvi l'utente in $_SESSION ed effettui un redirect alla homepage
        } 
        
        // 2. Se l'utente ha solo cliccato sull'omino (richiesta GET)
        // mostri semplicemente la pagina con il form di login
        $vUtente = new VUtente(); // La View dell'utente
        $vUtente->mostraFormLogin();
    }

    // Questo sarà il metodo chiamato dall'URL /Gallerist/utente/registrazione
    public function registrazione() 
    {
        $vUtente = new VUtente();
        $vUtente->mostraFormRegistrazione();
    }
}