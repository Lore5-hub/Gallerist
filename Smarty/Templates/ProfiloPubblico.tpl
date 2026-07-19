{extends file='layout.tpl'}
{block name=content}
<div class="box mt-5 p-5 public-profile-box">
  <div class="is-flex is-justify-content-space-between is-align-items-flex-start">
    
    <article class="media">
      <figure class="media-left">
        <p class="image is-96x96">
          {if isset($utente_loggato) && $utente_loggato->getId() == $utente->getId()}
    <figure class="image is-96x96 is-clickable" 
            title="Cambia foto profilo"
            onclick="document.getElementById('input-avatar-profilo').click()">
        <img class="is-rounded public-profile-avatar" 
             src="{$utente->getImmagineProfilo()|default:'/img/default_avatar.png'}" alt="Profilo" />
    </figure>
    <form method="POST" action="/utente/cambiaFotoProfilo" 
          enctype="multipart/form-data" id="form-avatar-profilo">
        <input type="file" id="input-avatar-profilo" name="immagine_profilo" 
               accept="image/*" style="display:none"
               onchange="document.getElementById('form-avatar-profilo').submit()">
    </form>
{else}
    <img class="is-rounded public-profile-avatar" 
         src="{$utente->getImmagineProfilo()|default:'/img/default_avatar.png'}" alt="Profilo" />
{/if}
        </p>
      </figure>
      <div class="media-content">
        <div class="content">
          <h1 class="title is-3 mb-1">{$utente->getNome()} {$utente->getCognome()}</h1>
          
          <p class="subtitle is-5 mt-1 mb-2">
            {if $utente->isArtista()}
              <span class="tag is-primary is-light">Artista</span>
            {else}
              <span class="tag is-info is-light">Collezionista</span>
            {/if}
            
            
          </p>
          
          <p class="is-size-7 has-text-grey">Membro dal {$utente->getDataRegistrazione()|date_format:"%Y"}</p>
        </div>
      </div>
    </article>

    <div>
    {if $utente->getStatoAccount() == 'Bannato'}
        <div class="notification is-danger is-light mb-2">
            <span class="icon"><i class="fas fa-ban"></i></span>
            Questo account è stato sospeso.
        </div>
    {/if}

    {if isset($utente_loggato) && $utente_loggato->getId() != $utente->getId() 
        && $utente_loggato->getRuolo() != 'Amministratore'
        && $utente->getStatoAccount() != 'Bannato'}
        <button class="button is-danger is-outlined is-small" id="btn-apri-segnalazione">
            <span class="icon"><i class="fas fa-flag"></i></span>
            <span>Segnala Profilo</span>
        </button>
    {/if}
</div>

  </div>

  {if $utente->isArtista() && $utente->getBiografia()}
    <hr>
    <div class="content mt-4">
        <h3 class="title is-5">Biografia</h3>
        <p class="has-text-justified">{$utente->getBiografia()}</p>
        {if $utente->getStileArtistico()}
            <p class="has-text-grey is-size-6 mt-2">
                <span class="icon"><i class="fas fa-paint-brush"></i></span>
                <em>Stile: {$utente->getStileArtistico()}</em>
            </p>
        {/if}
    </div>
{/if}
</div>

{if $utente->isArtista()}
  
  <h3 class="title is-4 mt-6 mb-4">Il Portfolio di {$utente->getNome()}</h3>
  
  <div class="columns is-multiline">
    {foreach from=$opere item=opera}
      <div class="column is-4">
        <a href="/catalogo/visualizzaDettagliOpera/{$opera->getId()}">
          <div class="card is-shadowless" style="background: transparent;">
            
            <div class="card-image box p-1 is-relative portfolio-card-img-box">
              <figure class="image is-4by3">
                {assign var='immagini' value=$opera->getImmagini()}
{if $immagini|@count > 0}
    {assign var='prima' value=$immagini[0]}
    <img src="/uploads/opere/{$prima->getUrlFile()}" alt="{$opera->getTitolo()}" class="portfolio-card-img">
{else}
    <img src="/img/default_opera.png" alt="{$opera->getTitolo()}" class="portfolio-card-img">
{/if}
              </figure>
              
              <div class="is-overlay is-flex is-align-items-flex-end p-2">
                 <span class="has-text-white is-size-7 has-text-weight-bold px-2 py-1 portfolio-title-badge">
                   {$opera->getTitolo()}
                 </span>
              </div>
            </div>
            
          </div>
        </a>
      </div>
    {foreachelse}
      <div class="column is-12">
        <div class="notification is-light has-text-centered">
          Questo artista non ha ancora pubblicato opere.
        </div>
      </div>
    {/foreach}
  </div>

{else}
  
  <h3 class="title is-4 mt-6 mb-4">Attività</h3>

  {* Statistiche utente *}
  <div class="box mt-4 mb-4">
    <div class="level">
      <div class="level-item has-text-centered">
        <div>
          <p class="heading">Opere Acquistate</p>
          <p class="title">{$numero_acquisti}</p>
        </div>
      </div>
      <div class="level-item has-text-centered">
        <div>
          <p class="heading">Recensioni Scritte</p>
          <p class="title">{$recensioni_scritte|@count}</p>
        </div>
      </div>
    </div>
  </div>

  {* Recensioni scritte dall'utente *}
  {if $recensioni_scritte|@count > 0}
    <h3 class="title is-5 mt-5 mb-3">Recensioni scritte</h3>
    {foreach from=$recensioni_scritte item=rec}
      <div class="box mb-3">
        <div class="is-flex is-justify-content-space-between mb-2">
          <a href="/catalogo/visualizzaDettagliOpera/{$rec->getOpera()->getId()}" class="has-text-weight-bold">
            {$rec->getOpera()->getTitolo()}
          </a>
          <span class="has-text-warning">
            <i class="fas fa-star"></i> {$rec->getValutazione()}/5
          </span>
        </div>
        <p class="has-text-grey">{$rec->getTesto()}</p>
        <p class="is-size-7 has-text-grey mt-1">{$rec->getData()|date_format:"%d/%m/%Y"}</p>
      </div>
    {/foreach}
  {else}
    <div class="box has-background-light has-text-centered p-6 mt-4">
      <p class="has-text-grey">Questo utente non ha ancora scritto recensioni.</p>
    </div>
  {/if}

{/if}



<div id="modal-segnalazione" class="modal">
  <div class="modal-background chiudi-modale-segnalazione"></div>
  <div class="modal-card">
    <header class="modal-card-head">
      <p class="modal-card-title">Segnala {$utente->getNome()}</p>
      <button class="delete chiudi-modale-segnalazione" aria-label="close"></button>
    </header>
    <section class="modal-card-body">
      
      {include file="FormSegnalazione.tpl"}
      
    </section>
  </div>
</div>

<script src="/js/profiloPubblico.js"></script>
{/block}