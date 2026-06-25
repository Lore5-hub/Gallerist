{extends file='layout.tpl'}
{block name=content}
{if isset($messaggio_successo)}
<div class="notification is-success">
  <button class="delete" onclick="this.parentElement.remove()"></button>
  {$messaggio_successo}
</div>
{/if}

{if isset($messaggio_errore)}
<div class="notification is-danger">
  <button class="delete" onclick="this.parentElement.remove()"></button>
  {$messaggio_errore}
</div>
{/if}

<div class="columns is-variable is-6 mt-4">
  
  <div class="column is-7">
    
    <figure class="image is-fullwidth artwork-detail-wrapper mb-2">
  <img src="{$opera->getUrlImmagine()}" alt="{$opera->getTitolo()}" />
</figure>
    
    <div class="has-text-centered mb-5">
      <span class="icon has-text-warning is-medium">
        <i class="fas fa-star fa-lg"></i>
      </span>
      <span class="has-text-weight-bold is-size-5 ml-1 is-v-middle">
        {$opera->getValutazioneMedia()|number_format:1:',':'.'} 
        <span class="has-text-grey is-size-6 fw-normal">/ 5</span>
      </span>
    </div>
    
    <div class="box mt-5">
      <h4 class="title is-5">Descrizione dell'opera</h4>
      <p class="has-text-justified">{$opera->getDescrizione()}</p>
    </div>
    
  </div>

  <div class="column is-5">
    
    <h1 class="title is-2 mb-2">{$opera->getTitolo()}</h1>
    
    <h2 class="subtitle is-4 mt-0">
      di <a href="profilo_artista.php?id={$opera->getAutore()->getId()}" class="has-text-link">{$opera->getAutore()->getNome()}</a>
    </h2>

    <div class="tags are-medium mt-4">
      <span class="tag is-info is-light">{$opera->getCategoria()}</span>
      <span class="tag is-light">Dimensioni: {$opera->getDimensioni()}</span>
    </div>

    <div class="block mt-5">
      <p class="is-size-3 has-text-weight-bold">€ {$opera->getPrezzo()|number_format:2:',':'.'}</p>
    </div>

    <div class="field mt-5">
      {if $opera->isDisponibile()}
        <form method="POST" action="checkout.php" class="mb-3">
          <input type="hidden" name="id_opera" value="{$opera->getId()}">
          <button type="submit" class="button is-black is-large is-fullwidth">Acquista Ora</button>
        </form>
        
        <button id="btn-apri-offerta" class="button is-white is-large is-fullwidth has-border">Fai un'offerta</button>
      {else}
        <button class="button is-large is-fullwidth" disabled>Opera Venduta</button>
      {/if}
    </div>

  </div> </div> <hr class="dropdown-divider my-6">


<div id="modal-offerta" class="modal">
  <div class="modal-background"></div>
  <div class="modal-card">
    <header class="modal-card-head">
      <p class="modal-card-title">Fai un'offerta per "{$opera->getTitolo()}"</p>
      <button class="delete chiudi-modale" aria-label="close"></button>
    </header>
    
    <section class="modal-card-body">
      <form id="form-offerta" method="POST" action="invia_offerta.php">
        <input type="hidden" name="id_opera" value="{$opera->getId()}">
        
        <div class="field">
          <label class="label">La tua offerta (€)</label>
          <div class="control">
            <input class="input is-large" type="number" name="prezzo_offerto" min="1" step="0.01" placeholder="Es. 150.00" required>
          </div>
        </div>
        
        <div class="field">
          <label class="label">Messaggio per l'artista (opzionale)</label>
          <div class="control">
            <textarea class="textarea" name="messaggio" placeholder="Scrivi qui il tuo messaggio..."></textarea>
          </div>
        </div>
      </form>
    </section>
    
    <footer class="modal-card-foot">
      <button type="submit" form="form-offerta" class="button is-primary">Invia Offerta</button>
      <button class="button chiudi-modale">Annulla</button>
    </footer>
  </div>
</div>


<section class="section px-0">
  <div class="columns">
    <div class="column is-8 is-offset-2">
      <h3 class="title is-3">Recensioni degli utenti</h3>
      
      {foreach from=$opera->getRecensioni() item=recensione}
        <div class="box mb-4 artwork-review-box">
          <p class="has-text-weight-bold">{$recensione->getNomeUtente()} <span class="has-text-grey is-size-7 ml-2">{$recensione->getData()|date_format:"%d/%m/%Y"}</span></p>
          <p class="mt-2">{$recensione->getTesto()}</p>
        </div>
      {foreachelse}
        <p class="has-text-grey">Nessuna recensione presente per quest'opera.</p>
      {/foreach}

      <div class="mt-6">
        {include file="form_recensione.tpl"}
      </div>
    </div>
  </div>
</section>

<hr class="dropdown-divider my-6">


<section class="section px-0">
  <h3 class="title is-3 mb-5">Altro di {$opera->getAutore()->getNome()}</h3>
  
  <div class="columns is-multiline">
    {foreach from=$altre_opere item=altra_opera}
      <div class="column is-3">
        <div class="card h-full artwork-card">
  <div class="card-image">
    <figure class="image is-4by3">
      <img src="{$altra_opera->getUrlImmagine()}" alt="..." class="artwork-img">
    </figure>
  </div>
          <div class="card-content">
            <p class="title is-5 mb-1">{$altra_opera->getTitolo()}</p>
            <p class="subtitle is-6 mb-3 has-text-grey">{$altra_opera->getDimensioni()}</p>
            <p class="is-size-5 has-text-weight-bold">€ {$altra_opera->getPrezzo()|number_format:2:',':'.'}</p>
            <a href="dettaglio_opera.php?id={$altra_opera->getId()}" class="button is-small is-outlined is-fullwidth mt-3">Vedi dettagli</a>
          </div>
        </div>
      </div>
    {foreachelse}
      <div class="column is-12">
        <p class="has-text-grey">Non ci sono altre opere di questo artista al momento.</p>
      </div>
    {/foreach}
  </div>
</section>
<script src="js/dettaglioOpera.js"></script>
{/block}