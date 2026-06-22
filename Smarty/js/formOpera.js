document.addEventListener('DOMContentLoaded', () => {

    // Seleziona gli elementi dal DOM
    const checkVendita = document.getElementById('check_vendita');
    const containerPrezzo = document.getElementById('container_prezzo');
    const inputPrezzo = document.getElementById('input_prezzo');

    // Funzione che accende/spegne il prezzo
    function aggiornaVisibilitaPrezzo() {
        if (checkVendita.checked) {
            // Mostra il campo prezzo
            containerPrezzo.classList.remove('is-hidden');
            // Rende il prezzo obbligatorio (required)
            inputPrezzo.setAttribute('required', 'required');
        } else {
            // Nasconde il campo
            containerPrezzo.classList.add('is-hidden');
            // Toglie l'obbligatorietà
            inputPrezzo.removeAttribute('required');
            // Pulisce il valore se l'utente aveva scritto qualcosa e poi ha tolto la spunta
            inputPrezzo.value = '';
        }
    }

    // Assicura che l'evento scatti quando clicchi la checkbox
    if (checkVendita) {
        checkVendita.addEventListener('change', aggiornaVisibilitaPrezzo);
        
        // Lo esegue anche all'avvio nel caso il browser abbia ricordato la spunta ricaricando la pagina
        aggiornaVisibilitaPrezzo();
    }
});