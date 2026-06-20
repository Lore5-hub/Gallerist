document.addEventListener('DOMContentLoaded', () => {

    // ==========================================
    // 1. GESTIONE VISIBILITÀ CAMPI ARTISTA
    // ==========================================
    const ruoloArtista = document.getElementById('ruolo-artista');
    const ruoloUtente = document.getElementById('ruolo-utente');
    const campiArtista = document.getElementById('campi-artista');

    function controllaVisibilitaRuolo() {
        if (ruoloArtista && ruoloArtista.checked) {
            campiArtista.classList.remove('is-hidden');
        } else if (campiArtista) {
            campiArtista.classList.add('is-hidden');
        }
    }

    // Ascolta i cambi di stato sui radio button
    if (ruoloArtista) ruoloArtista.addEventListener('change', controllaVisibilitaRuolo);
    if (ruoloUtente) ruoloUtente.addEventListener('change', controllaVisibilitaRuolo);


    // ==========================================
    // 2. FUNZIONE DI VALIDAZIONE GENERICA
    // ==========================================
    // Questa funzione evita di ripetere lo stesso codice per ogni campo.
    // Accetta l'elemento input, l'elemento di errore e una condizione (true/false).
    function validaCampo(inputEl, errorEl, condizioneValidita) {
        if (!inputEl) return;

        if (condizioneValidita) {
            inputEl.classList.remove('is-danger');
            inputEl.classList.add('is-success');
            if (errorEl) errorEl.classList.add('is-hidden');
        } else {
            inputEl.classList.add('is-danger');
            inputEl.classList.remove('is-success');
            if (errorEl) errorEl.classList.remove('is-hidden');
        }
    }


    // ==========================================
    // 3. VALIDAZIONE DEI SINGOLI CAMPI
    // ==========================================

    // Nome
    const nome = document.getElementById('nome');
    const errorNome = document.getElementById('error-nome');
    if (nome) {
        nome.addEventListener('input', () => {
            validaCampo(nome, errorNome, nome.checkValidity());
        });
    }

    // Cognome
    const cognome = document.getElementById('cognome');
    const errorCognome = document.getElementById('error-cognome');
    if (cognome) {
        cognome.addEventListener('input', () => {
            validaCampo(cognome, errorCognome, cognome.checkValidity());
        });
    }

    // Email
    const email = document.getElementById('email');
    const errorEmail = document.getElementById('error-email');
    if (email) {
        email.addEventListener('input', () => {
            validaCampo(email, errorEmail, email.checkValidity());
        });
    }

    // Password (almeno 8 caratteri)
    const password = document.getElementById('password');
    const errorPassword = document.getElementById('error-password');
    if (password) {
        password.addEventListener('input', () => {
            validaCampo(password, errorPassword, password.value.length >= 8);
        });
    }

    // Indirizzo (almeno 10 caratteri)
    const indirizzo = document.getElementById('indirizzo');
    const errorIndirizzo = document.getElementById('error-indirizzo');
    if (indirizzo) {
        indirizzo.addEventListener('input', () => {
            validaCampo(indirizzo, errorIndirizzo, indirizzo.value.length >= 10);
        });
    }

    // Nickname
    const nickname = document.getElementById('nickname');
    const errorNickname = document.getElementById('error-nickname');
    if (nickname) {
        nickname.addEventListener('input', () => {
            validaCampo(nickname, errorNickname, nickname.checkValidity());
        });
    }

    // Telefono
    const telefono = document.getElementById('telefono');
    const errorTelefono = document.getElementById('error-telefono');
    if (telefono) {
        telefono.addEventListener('input', () => {
            validaCampo(telefono, errorTelefono, telefono.checkValidity());
        });
    }

    // Data di Nascita (Controllo Maggiorenni 18+)
    const dataNascita = document.getElementById('data_nascita');
    const errorData = document.getElementById('error-data');
    if (dataNascita) {
        dataNascita.addEventListener('change', () => {
            const dataInserita = new Date(dataNascita.value);
            const oggi = new Date();
            
            let eta = oggi.getFullYear() - dataInserita.getFullYear();
            const mese = oggi.getMonth() - dataInserita.getMonth();
            
            if (mese < 0 || (mese === 0 && oggi.getDate() < dataInserita.getDate())) {
                eta--;
            }

            const èMaggiorenne = (eta >= 18 && !isNaN(eta));
            validaCampo(dataNascita, errorData, èMaggiorenne);
        });
    }


    // ==========================================
    // 4. TRUCCO BULMA: MOSTRARE IL NOME DEI FILE CARICATI
    // ==========================================
    // Bulma non aggiorna da solo il testo "Nessun file selezionato".
    // Questo blocco rileva il caricamento e stampa il nome del file reale.
    const fileInputs = document.querySelectorAll('.file-input');
    fileInputs.forEach(input => {
        input.addEventListener('change', () => {
            if (input.files.length > 0) {
                const fileNameContainer = input.closest('.file').querySelector('.file-name');
                if (fileNameContainer) {
                    fileNameContainer.textContent = input.files[0].name;
                }
            }
        });
    });

});