document.addEventListener('DOMContentLoaded', () => {
  const modal = document.getElementById('modal-documento');
  const btnApri = document.getElementById('apri-modal-doc');
  const btnChiudi = document.getElementById('chiudi-modal-btn');
  const bgChiudi = document.getElementById('chiudi-modal-bg');

  if (btnApri) {
    btnApri.addEventListener('click', () => modal.classList.add('is-active'));
  }

  [btnChiudi, bgChiudi].forEach(elemento => {
    if (elemento) {
      elemento.addEventListener('click', () => modal.classList.remove('is-active'));
    }
  });
});