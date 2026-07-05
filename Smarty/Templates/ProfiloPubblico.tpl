{extends file='layout.tpl'}
{block name=content}
<div class="box mt-5 p-5 public-profile-box">
  <div class="is-flex is-justify-content-space-between is-align-items-flex-start">
    
    <article class="media">
      <figure class="media-left">
        <p class="image is-96x96">
          <img class="is-rounded public-profile-avatar" src="{$utente->getImmagineProfilo()|default:'img/default-avatar.png'}" alt="Profilo" />
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
          
          <p class="is-size-7 has-text-grey">Membro dal {$utente->getDataDiNascita()|date_format:"%Y"}</p>
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
    </div>
  {/if}
</div>

{if $utente->isArtista()}
  
  <h3 class="title is-4 mt-6 mb-4">Il Portfolio di {$utente->getNome()}</h3>
  
  <div class="columns is-multiline">
    {foreach from=$opere item=opera}
      <div class="column is-4">
        <a href="/Gallerist/catalogo/visualizzaDettagliOpera/{$opera->getId()}">
          <div class="card is-shadowless" style="background: transparent;">
            
            <div class="card-image box p-1 is-relative portfolio-card-img-box">
              <figure class="image is-4by3">
                {assign var='immagini' value=$opera->getImmagini()}
{if $immagini|@count > 0}
    {assign var='prima' value=$immagini[0]}
    <img src="/Gallerist/uploads/{$prima->getUrlFile()}" alt="{$opera->getTitolo()}" class="portfolio-card-img">
{else}
    <img src="/Gallerist/img/default_opera.png" alt="{$opera->getTitolo()}" class="portfolio-card-img">
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
  
  <div class="box has-background-light has-text-centered p-6 mt-4">
    <span class="icon is-large has-text-grey-light mb-3">
      <i class="fas fa-lock fa-3x"></i>
    </span>
    <p class="is-size-5 has-text-grey has-text-weight-bold">Collezione Privata</p>
    <p class="has-text-grey">Le opere acquistate e preferite dai collezionisti sono mantenute private per motivi di riservatezza.</p>
  </div>

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

<script src="/Gallerist/js/profiloPubblico.js"></script>
{/block}