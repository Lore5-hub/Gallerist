document.addEventListener('DOMContentLoaded', () => {
    const btnApri = document.getElementById('btn-apri-segnalazione');
    const modal = document.getElementById('modal-segnalazione');
    const btnChiudi = document.querySelectorAll('.chiudi-modale-segnalazione');

    if (btnApri && modal) {
        // Apri
        btnApri.addEventListener('click', () => {
            modal.classList.add('is-active');
            document.documentElement.classList.add('is-clipped');
        });

        // Chiudi
        btnChiudi.forEach((btn) => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                modal.classList.remove('is-active');
                document.documentElement.classList.remove('is-clipped');
            });
        });
    }
});