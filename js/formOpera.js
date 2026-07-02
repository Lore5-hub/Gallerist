document.addEventListener('DOMContentLoaded', () => {

    // Gestione checkbox prezzo
    const checkVendita = document.getElementById('check_vendita');
    const containerPrezzo = document.getElementById('container_prezzo');
    const inputPrezzo = document.getElementById('input_prezzo');

    function aggiornaVisibilitaPrezzo() {
        if (checkVendita.checked) {
            containerPrezzo.classList.remove('is-hidden');
            inputPrezzo.setAttribute('required', 'required');
        } else {
            containerPrezzo.classList.add('is-hidden');
            inputPrezzo.removeAttribute('required');
            inputPrezzo.value = '';
        }
    }

    if (checkVendita) {
        checkVendita.addEventListener('change', aggiornaVisibilitaPrezzo);
        aggiornaVisibilitaPrezzo();
    }

    // Gestione anteprima immagini
    const inputImmagini = document.querySelector('.file-input');
    const previewCopertina = document.querySelector('.artwork-upload-preview');


    if (inputImmagini && previewCopertina) {
        inputImmagini.addEventListener('change', function() {
            
            const files = Array.from(this.files).slice(0, 4);

            files.forEach((file, index) => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    if (index === 0) {
                        previewCopertina.innerHTML = `
                            <span class="tag is-primary" style="position:absolute; top:8px; left:8px;">Copertina</span>
                            <img src="${e.target.result}" style="width:100%; height:100%; object-fit:cover; border-radius:4px;">
                        `;
                        previewCopertina.style.position = 'relative';
                    } else {
                        const extra = document.querySelectorAll('.column.is-4 figure');
                        if (extra[index - 1]) {
                            extra[index - 1].innerHTML = `
                                <img src="${e.target.result}" style="width:100%; height:100%; object-fit:cover; border-radius:4px;">
                            `;
                        }
                    }
                };
                reader.readAsDataURL(file);
            });
        });
    } else {
        console.log('Elementi non trovati!');
    }
});