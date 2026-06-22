document.addEventListener('DOMContentLoaded', () => {

    // 1. Selezioniamo gli elementi chiave dal DOM
    const btnApriOfferta = document.getElementById('btn-apri-offerta');
    const modalOfferta = document.getElementById('modal-offerta');
    
    // Selezioniamo TUTTI i pulsanti che devono chiudere il modale 
    // (la 'X' in alto, il pulsante 'Annulla' e lo sfondo scuro)
    const bottoniChiusura = document.querySelectorAll('.chiudi-modale, .modal-background');

    // Controllo di sicurezza: eseguiamo il codice solo se il bottone e il modale esistono nella pagina
    if (btnApriOfferta && modalOfferta) {
        
        // 2. Aprire il modale
        btnApriOfferta.addEventListener('click', () => {
            modalOfferta.classList.add('is-active');
            
            // Opzionale: blocca lo scorrimento della pagina in background
            document.documentElement.classList.add('is-clipped');
        });

        // 3. Chiudere il modale
        // Usiamo un ciclo foreach perché ci sono più elementi che possono chiuderlo
        bottoniChiusura.forEach((bottone) => {
            bottone.addEventListener('click', (e) => {
                e.preventDefault(); // Evita comportamenti strani se è un link
                modalOfferta.classList.remove('is-active');
                
                // Sblocca lo scorrimento della pagina
                document.documentElement.classList.remove('is-clipped');
            });
        });

        // 4. Chicca per l'accessibilità: Chiudere con il tasto ESC
        document.addEventListener('keydown', (event) => {
            if (event.key === "Escape" && modalOfferta.classList.contains('is-active')) {
                modalOfferta.classList.remove('is-active');
                document.documentElement.classList.remove('is-clipped');
            }
        });
    }

});