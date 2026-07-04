{extends file='layout.tpl'}
{block name=content}
<section class="section">
  <div class="container">
    
    <h2 class="title is-3 mb-4">Il mio profilo</h2>
    <div class="box mb-6">
      <div class="columns is-vcentered">
        
        <div class="column is-narrow has-text-centered">
          <figure class="image is-128x128 is-inline-block artist-avatar-figure is-clickable" title="Cambia foto profilo">
  <img class="is-rounded" src="{$utente->getImmagineProfilo()|default:'/Gallerist/img/default_avatar.png'}">
  <div class="artist-avatar-overlay is-flex is-align-items-center is-justify-content-center is-rounded">
    <i class="fas fa-camera fa-2x has-text-white"></i>
  </div>
</figure>
        </div>

        <div class="column is-4">
          <div class="is-flex is-align-items-center mb-2">
            <h1 class="title is-4 mb-0 mr-2">{$utente->getNome()} {$utente->getCognome()}</h1>
            
          </div>
          
          <div class="is-flex is-align-items-center mb-2">
            <p class="subtitle is-6 mb-0 mr-2"><strong>Nickname:</strong> @{$utente->getNickname()}</p>
            <a href="#" class="icon has-text-grey-light" title="Modifica Nickname" onclick="document.getElementById('modal-nickname').classList.add('is-active'); return false;">
    <i class="fas fa-pencil-alt"></i>
</a>
          </div>

          <div class="is-flex is-align-items-center">
            <p class="is-size-6 mb-0 mr-2"><strong>Nazionalità:</strong> {$utente->getNazionalita()}</p>
            
          </div>
        </div>

        <div class="column">
          <div class="box has-background-light artist-bio-box pt-5">
  <a href="#" class="icon has-text-grey artist-bio-edit-btn" title="Modifica Biografia" 
   onclick="document.getElementById('modal-biografia').classList.add('is-active'); return false;">
    <i class="fas fa-pencil-alt"></i>
</a>
              <i class="fas fa-pencil-alt"></i>
            </a>
            <p class="is-size-6 pl-4 has-text-justified">
              {$utente->getBiografia()|default:"<em>Nessuna descrizione inserita. Clicca la matita per aggiungere la tua biografia.</em>"}
            </p>
          </div>
        </div>

      </div>
    </div>

    <div class="columns is-multiline is-mobile mb-6">
      
      <div class="column is-one-fifth-desktop is-half-tablet">
        <div class="box has-text-centered">
          <span class="icon is-large has-text-info mb-2"><i class="fas fa-palette fa-2x"></i></span>
          <p class="heading">Opere Pubblicate</p>
          <p class="title is-3">{$statistiche.pubblicate}</p>
        </div>
      </div>

      <div class="column is-one-fifth-desktop is-half-tablet">
        <div class="box has-text-centered">
          <span class="icon is-large has-text-primary mb-2"><i class="fas fa-tags fa-2x"></i></span>
          <p class="heading">In Vendita</p>
          <p class="title is-3">{$statistiche.in_vendita}</p>
        </div>
      </div>

      <div class="column is-one-fifth-desktop is-half-tablet">
        <div class="box has-text-centered">
          <span class="icon is-large has-text-danger mb-2"><i class="fas fa-heart fa-2x"></i></span>
          <p class="heading">Interazioni</p>
          <p class="title is-3">{$statistiche.interazioni}</p>
        </div>
      </div>

      <div class="column is-one-fifth-desktop is-half-tablet">
        <div class="box has-text-centered">
          <span class="icon is-large has-text-warning mb-2"><i class="fas fa-star fa-2x"></i></span>
          <p class="heading">Recensioni ({$statistiche.numero_recensioni})</p>
          <p class="title is-3">{$utente->getValutazioneMedia()|number_format:1:',':'.'}</p>
        </div>
      </div>

      <div class="column is-one-fifth-desktop is-half-tablet">
        <div class="box has-text-centered">
          <span class="icon is-large has-text-success mb-2"><i class="fas fa-euro-sign fa-2x"></i></span>
          <p class="heading">Guadagni Totali</p>
          <p class="title is-3">€ {$statistiche.guadagni|number_format:2:',':'.'}</p>
        </div>
      </div>

    </div>

    <div class="level mb-4">
      <div class="level-left">
        <div class="tabs is-medium is-toggle is-toggle-rounded">
          <ul>
            <li class="is-active"><a href="?tab=tutte">Le mie opere</a></li>
            <li><a href="?tab=vendita">Opere in vendita</a></li>
            <li><a href="?tab=vendute">Vendute</a></li>
          </ul>
        </div>
      </div>
      <div class="level-right">
        <a href="/Gallerist/gestioneProfiloPortfolio/mostraFormOpera" class="button is-success is-medium">
          <span class="icon"><i class="fas fa-plus"></i></span>
          <span>Nuova Opera</span>
        </a>
      </div>
    </div>

    <div class="columns is-multiline mb-6">
      {foreach from=$mie_opere item=opera}
        <div class="column is-3">
          <div class="card artist-work-card">
  <div class="card-image is-relative">
    <figure class="image is-4by3">
    {assign var='immagini' value=$opera->getImmagini()}
    {if $immagini|@count > 0}
        {assign var='prima' value=$immagini[0]}
        <img src="/Gallerist/uploads/opere/{$prima->getUrlFile()}" alt="{$opera->getTitolo()}">
    {else}
        <img src="/Gallerist/img/default_opera.png" alt="{$opera->getTitolo()}">
    {/if}
</figure>
 <div class="artist-work-delete-wrapper">
 <form method="POST" action="/Gallerist/gestioneProfiloPortfolio/eliminaOpera" onsubmit="return confirm('Sei sicuro di voler eliminare questa opera?');">
                  <input type="hidden" name="id_opera" value="{$opera->getId()}">
                  <button type="submit" class="button is-danger is-small is-rounded" title="Elimina Opera">
                    <span class="icon"><i class="fas fa-trash"></i></span>
                  </button>
                </form>
                </div>
  </div>
              
              
                
              </div>
            </div>

            <div class="card-content p-3">
              <p class="title is-6 mb-1">{$opera->getTitolo()}</p>
              <p class="subtitle is-7 has-text-grey">
                {if $opera->isVenduta()}
                  <span class="has-text-danger"><i class="fas fa-gavel"></i> Venduta</span>
                {elseif $opera->isInVendita()}
                  <span class="has-text-success"><i class="fas fa-tag"></i> In vendita: € {$opera->getPrezzo()->getValore()|number_format:2:',':'.'}</span>
                {else}
                  <span><i class="fas fa-eye-slash"></i> Non in vendita</span>
                {/if}
              </p>
            </div>

          </div>
        </div>
      {foreachelse}
        <div class="column is-12 has-text-centered py-6">
          <p class="has-text-grey is-size-5">Non hai ancora pubblicato nessuna opera.</p>
        </div>
      {/foreach}
    </div>

    <h3 class="title is-4 mt-6">Recensioni Ricevute</h3>
    <div class="box mb-6">
      
      {foreach from=$recensioni item=recensione}
        <article class="media mb-5 artist-review-article">
          <figure class="media-left">
            <p class="image is-48x48">
              <img class="is-rounded" src="{$recensione->getAutore()->getImmagineProfilo()|default:'/Gallerist/img/default_avatar.png'}">
            </p>
          </figure>
          <div class="media-content">
            <div class="content">
              <p>
                <strong>{$recensione->getAutore()->getNome()}</strong> 
                <span class="has-text-warning ml-2">
                  <i class="fas fa-star"></i> {$recensione->getValutazione()}
                </span>
                <br>
                {$recensione->getTesto()}
              </p>
            </div>
            
            
            
          </div>
        </article>
      {foreachelse}
        <p class="has-text-grey text-center">Non hai ancora ricevuto recensioni.</p>
      {/foreach}

    </div>
<h3 class="title is-4 mt-6">Offerte Ricevute</h3>
<div class="box mb-6">
    {foreach from=$offerte_ricevute item=offerta}
        <article class="media mb-4">
            <div class="media-content">
                <div class="content">
                    <p>
                        <strong>{$offerta->getOfferente()->getNome()} {$offerta->getOfferente()->getCognome()}</strong>
                        <span class="tag is-warning is-light ml-2">In attesa</span>
                        <br>
                        Opera: <strong>{$offerta->getOpera()->getTitolo()}</strong>
                        <br>
                        Offerta: <strong>€ {$offerta->getCifraProposta()->getValore()|number_format:2:',':'.'}</strong>
                        {if $offerta->getNota()}
                            <br><em>"{$offerta->getNota()}"</em>
                        {/if}
                    </p>
                </div>
                <div class="buttons">
                    <form method="POST" action="/Gallerist/gestioneProfiloPortfolio/rispondiOfferta">
                        <input type="hidden" name="id_offerta" value="{$offerta->getId()}">
                        <input type="hidden" name="risposta" value="accettata">
                        <button type="submit" class="button is-success is-small">
                            <span class="icon"><i class="fas fa-check"></i></span>
                            <span>Accetta</span>
                        </button>
                    </form>
                    <form method="POST" action="/Gallerist/gestioneProfiloPortfolio/rispondiOfferta">
                        <input type="hidden" name="id_offerta" value="{$offerta->getId()}">
                        <input type="hidden" name="risposta" value="rifiutata">
                        <button type="submit" class="button is-danger is-small is-outlined">
                            <span class="icon"><i class="fas fa-times"></i></span>
                            <span>Rifiuta</span>
                        </button>
                    </form>
                </div>
            </div>
        </article>
    {foreachelse}
        <p class="has-text-grey has-text-centered">Nessuna offerta ricevuta al momento.</p>
    {/foreach}
</div>
    <hr class="mt-6 mb-5">
    <div class="has-text-centered pb-6">
      <form method="POST" action="/Gallerist/gestioneProfiloPortfolio/eliminaProfilo" onsubmit="return confirm('ATTENZIONE: Questa azione è irreversibile. Tutte le tue opere e i tuoi dati andranno persi. Vuoi davvero eliminare il tuo profilo?');">
        <button type="submit" class="button is-danger is-outlined">
          <span class="icon"><i class="fas fa-exclamation-triangle"></i></span>
          <span>Elimina definitivamente il mio profilo</span>
        </button>
      </form>
    </div>

  </div>
  <div id="modal-nickname" class="modal">
    <div class="modal-background" onclick="this.parentElement.classList.remove('is-active')"></div>
    <div class="modal-card">
        <header class="modal-card-head">
            <p class="modal-card-title">Modifica Nickname</p>
            <button class="delete" onclick="this.closest('.modal').classList.remove('is-active')"></button>
        </header>
        <section class="modal-card-body">
            <form method="POST" action="/Gallerist/utente/modificaNickname">
                <div class="field">
                    <label class="label">Nuovo Nickname</label>
                    <div class="control has-icons-left">
                        <input class="input" type="text" name="nickname" 
                               value="{$utente->getNickname()}" required>
                        <span class="icon is-left"><i class="fas fa-at"></i></span>
                    </div>
                </div>
                <button type="submit" class="button is-primary is-fullwidth mt-3">Salva</button>
            </form>
        </section>
    </div>
</div>
<div id="modal-biografia" class="modal">
    <div class="modal-background" onclick="this.parentElement.classList.remove('is-active')"></div>
    <div class="modal-card">
        <header class="modal-card-head">
            <p class="modal-card-title">Modifica Biografia</p>
            <button class="delete" onclick="this.closest('.modal').classList.remove('is-active')"></button>
        </header>
        <section class="modal-card-body">
            <form method="POST" action="/Gallerist/utente/modificaBiografia">
                <div class="field">
                    <label class="label">Biografia</label>
                    <div class="control">
                        <textarea class="textarea" name="biografia" rows="6" 
                                  placeholder="Racconta qualcosa di te...">{$utente->getBiografia()}</textarea>
                    </div>
                </div>
                <button type="submit" class="button is-primary is-fullwidth mt-3">Salva</button>
            </form>
        </section>
    </div>
</div>
</section>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const tabs = document.querySelectorAll('.tabs ul li');
    const opere = document.querySelectorAll('.artist-work-card').forEach;

    tabs.forEach(tab => {
        tab.addEventListener('click', (e) => {
            e.preventDefault();

            // Rimuovi is-active da tutti i tab
            tabs.forEach(t => t.classList.remove('is-active'));
            tab.classList.add('is-active');

            const filtro = tab.querySelector('a').getAttribute('href').replace('?tab=', '');

            document.querySelectorAll('.column.is-3').forEach(col => {
                const card = col.querySelector('.artist-work-card');
                if (!card) return;

                if (filtro === 'tutte') {
                    col.style.display = '';
                } else if (filtro === 'vendita') {
                    const isVendita = card.querySelector('.has-text-success') !== null;
                    col.style.display = isVendita ? '' : 'none';
                } else if (filtro === 'vendute') {
                    const isVenduta = card.querySelector('.has-text-danger') !== null;
                    col.style.display = isVenduta ? '' : 'none';
                }
            });
        });
    });
});
</script>
{/block}