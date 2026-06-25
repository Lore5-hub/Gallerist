{extends file='layout.tpl'}
{block name=content}
<section class="section">
  <div class="container">
    
    <h2 class="title is-3 mb-4">Il mio profilo</h2>
    <div class="box mb-6">
      <div class="columns is-vcentered">
        
        <div class="column is-narrow has-text-centered">
          <figure class="image is-128x128 is-inline-block artist-avatar-figure is-clickable" title="Cambia foto profilo">
  <img class="is-rounded" src="...">
  <div class="artist-avatar-overlay is-flex is-align-items-center is-justify-content-center is-rounded">
    <i class="fas fa-camera fa-2x has-text-white"></i>
  </div>
</figure>
        </div>

        <div class="column is-4">
          <div class="is-flex is-align-items-center mb-2">
            <h1 class="title is-4 mb-0 mr-2">{$utente->getNome()} {$utente->getCognome()}</h1>
            <a href="#" class="icon has-text-grey-light" title="Modifica Nome"><i class="fas fa-pencil-alt"></i></a>
          </div>
          
          <div class="is-flex is-align-items-center mb-2">
            <p class="subtitle is-6 mb-0 mr-2"><strong>Nickname:</strong> @{$utente->getNickname()}</p>
            <a href="#" class="icon has-text-grey-light" title="Modifica Nickname"><i class="fas fa-pencil-alt"></i></a>
          </div>

          <div class="is-flex is-align-items-center">
            <p class="is-size-6 mb-0 mr-2"><strong>Nazionalità:</strong> {$utente->getNazionalita()}</p>
            <a href="#" class="icon has-text-grey-light" title="Modifica Nazionalità"><i class="fas fa-pencil-alt"></i></a>
          </div>
        </div>

        <div class="column">
          <div class="box has-background-light artist-bio-box pt-5">
  <a href="#" class="icon has-text-grey artist-bio-edit-btn" title="Modifica Biografia">...</a>
              <i class="fas fa-pencil-alt"></i>
            </a>
            <p class="is-size-6 pl-4 has-text-justified">
              {$utente->getDescrizione()|default:"<em>Nessuna descrizione inserita. Clicca la matita per aggiungere la tua biografia.</em>"}
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
        <a href="aggiungi_opera.php" class="button is-success is-medium">
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
    <figure class="image is-4by3"><img src="..."></figure> <div class="artist-work-delete-wrapper"><form method="POST" action="elimina_opera.php" onsubmit="return confirm('Sei sicuro di voler eliminare questa opera?');">
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
                  <span class="has-text-success"><i class="fas fa-tag"></i> In vendita: € {$opera->getPrezzo()}</span>
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
              <img class="is-rounded" src="{$recensione->getUtente()->getUrlImmagineProfilo()|default:'img/default-avatar.png'}">
            </p>
          </figure>
          <div class="media-content">
            <div class="content">
              <p>
                <strong>{$recensione->getUtente()->getNome()}</strong> 
                <span class="has-text-warning ml-2">
                  <i class="fas fa-star"></i> {$recensione->getValutazione()}
                </span>
                <br>
                {$recensione->getCommento()}
              </p>
            </div>
            
            {if $recensione->getRisposta()}
              <div class="notification is-light ml-4 p-3 mt-2">
                <strong>La tua risposta:</strong><br>
                {$recensione->getRisposta()}
              </div>
            {else}
              <form method="POST" action="rispondi_recensione.php" class="mt-2">
                <input type="hidden" name="id_recensione" value="{$recensione->getId()}">
                <div class="field has-addons">
                  <div class="control is-expanded">
                    <input class="input is-small" type="text" name="testo_risposta" placeholder="Rispondi a questa recensione..." required>
                  </div>
                  <div class="control">
                    <button type="submit" class="button is-info is-small">Rispondi</button>
                  </div>
                </div>
              </form>
            {/if}
            
          </div>
        </article>
      {foreachelse}
        <p class="has-text-grey text-center">Non hai ancora ricevuto recensioni.</p>
      {/foreach}

    </div>

    <hr class="mt-6 mb-5">
    <div class="has-text-centered pb-6">
      <form method="POST" action="elimina_profilo.php" onsubmit="return confirm('ATTENZIONE: Questa azione è irreversibile. Tutte le tue opere e i tuoi dati andranno persi. Vuoi davvero eliminare il tuo profilo?');">
        <button type="submit" class="button is-danger is-outlined">
          <span class="icon"><i class="fas fa-exclamation-triangle"></i></span>
          <span>Elimina definitivamente il mio profilo</span>
        </button>
      </form>
    </div>

  </div>
</section>
{/block}