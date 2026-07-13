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
{if $immaginiOpera|@count > 0}
    <img id="immagine-principale-opera"
         src="data:{$immaginiOpera[0].type};base64,{$immaginiOpera[0].pic64}"
         alt="{$opera->getTitolo()}" />
{else}
    <img src="/Gallerist/img/default_opera.png" alt="{$opera->getTitolo()}" />
{/if}
</figure>

{if $immaginiOpera|@count > 1}
<div class="thumbnail-strip mb-4" style="display:flex; gap:0.5rem; flex-wrap:wrap;">
    {foreach from=$immaginiOpera item=img name=miniature}
        {if !$smarty.foreach.miniature.first}
        <img src="data:{$img.type};base64,{$img.pic64}"
             alt="Miniatura {$smarty.foreach.miniature.iteration}"
             class="thumbnail-opera"
             style="width:70px; height:70px; object-fit:cover; cursor:pointer; border-radius:4px; border:2px solid transparent;"
             onclick="document.getElementById('immagine-principale-opera').src=this.src;
                      document.querySelectorAll('.thumbnail-opera').forEach(t=>t.style.borderColor='transparent');
                      this.style.borderColor='#00d1b2';" />
        {/if}
    {/foreach}
</div>
{/if}
    
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
    {if isset($utente_loggato) && $utente_loggato->getRuolo() != 'Amministratore' && $utente_loggato->getId() != $opera->getArtista()->getId()}
    <button class="button is-danger is-outlined is-small mt-2" id="btn-segnala-opera">
        <span class="icon"><i class="fas fa-flag"></i></span>
        <span>Segnala Opera</span>
    </button>
{/if}
    <h2 class="subtitle is-4 mt-0">
      di <a href="/Gallerist/catalogo/visualizzaProfiloArtista/{$opera->getArtista()->getId()}" class="has-text-link">{$opera->getArtista()->getNome()}</a>
    </h2>

    <div class="tags are-medium mt-4">
      <span class="tag is-info is-light">{$opera->getCategoria()->getNome()}</span>
      <span class="tag is-light">Dimensioni: {$opera->getDimensioni()}</span>
      {foreach from=$opera->getTag() item=tag}
    <span class="tag is-primary is-light">#{$tag->getNomeTag()}</span>
{/foreach}
    </div>

   
{* Prezzo con selettore valuta *}
<div class="block mt-5">
    <p class="is-size-3 has-text-weight-bold">
        {if isset($prezzoConvertito)}
            {$prezzoConvertito->getValore()|number_format:2:',':'.'} {$prezzoConvertito->getValuta()}
            <span class="is-size-6 has-text-grey ml-2">(€ {$opera->getPrezzo()->getValore()|number_format:2:',':'.'})</span>
        {else}
            € {$opera->getPrezzo()->getValore()|number_format:2:',':'.'}
        {/if}
    </p>
    
    <form method="GET" action="/Gallerist/catalogo/visualizzaDettagliOpera/{$opera->getId()}" class="mt-2">
        <div class="field has-addons">
            <div class="control">
                <div class="select">
                    <select name="valuta">
                        <option value="EUR" {if !isset($valutaSelezionata) || $valutaSelezionata == 'EUR'}selected{/if}>EUR €</option>
                        <option value="USD" {if isset($valutaSelezionata) && $valutaSelezionata == 'USD'}selected{/if}>USD $</option>
                        <option value="GBP" {if isset($valutaSelezionata) && $valutaSelezionata == 'GBP'}selected{/if}>GBP £</option>
                        <option value="JPY" {if isset($valutaSelezionata) && $valutaSelezionata == 'JPY'}selected{/if}>JPY ¥</option>
                        <option value="CHF" {if isset($valutaSelezionata) && $valutaSelezionata == 'CHF'}selected{/if}>CHF</option>
                    </select>
                </div>
            </div>
            <div class="control">
                <button type="submit" class="button is-info">
                    <span class="icon"><i class="fas fa-exchange-alt"></i></span>
                    <span>Converti</span>
                </button>
            </div>
        </div>
    </form>
</div>
    <div class="field mt-5">
      {* Acquisto e offerta — solo per utenti non admin *}
{if !$opera->getStatoOpera()->isVendibile()}
    <button class="button is-large is-fullwidth" disabled>Opera non disponibile</button>
{elseif isset($utente_loggato) && $utente_loggato->getRuolo() == 'Amministratore'}
    {* Admin non può comprare — non mostrare nulla *}
{elseif isset($utente_loggato) && $utente_loggato->getId() == $opera->getArtista()->getId()}
    <button class="button is-large is-fullwidth" disabled>Opera tua</button>
{else}
    <form method="POST" action="/Gallerist/compravendita/avviaAcquisto/{$opera->getId()}" class="mb-3">
        <button type="submit" class="button is-black is-large is-fullwidth">Acquista Ora</button>
    </form>
    <button id="btn-apri-offerta" class="button is-white is-large is-fullwidth has-border">Fai un'offerta</button>
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
      <form id="form-offerta" method="POST" action="/Gallerist/compravendita/avviaPropostaOfferta/{$opera->getId()}">
        
        <div class="field">
    <label class="label">La tua offerta (€)</label>
    <div class="control">
        <input class="input is-large" type="number" name="prezzo_offerto" 
       min="1" step="0.01" 
       max="{$opera->getPrezzo()->getValore()}"
       placeholder="Es. 150.00" required id="input_offerta">
    </div>
    {if isset($prezzoConvertito)}
        <p class="help has-text-grey mt-1">
            <span class="icon is-small"><i class="fas fa-exchange-alt"></i></span>
            Il prezzo dell'opera equivale a 
            <strong>{$prezzoConvertito->getValore()|number_format:2:',':'.'} {$prezzoConvertito->getValuta()}</strong>
            al tasso di cambio attuale
        </p>
    {/if}
    {if isset($smarty.get.errore) && $smarty.get.errore == 'offerta_troppo_alta'}
    <div class="notification is-warning is-light mb-4">
        <button class="delete" onclick="this.parentElement.remove()"></button>
        L'offerta non può essere superiore o uguale al prezzo dell'opera. Se vuoi pagare il prezzo pieno, acquistala direttamente.
    </div>
{/if}
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
      
      {foreach from=$commenti item=recensione}
    <div class="box mb-4 artwork-review-box">
        <div class="is-flex is-justify-content-space-between is-align-items-center">
            <p class="has-text-weight-bold">
                <a href="/Gallerist/catalogo/visualizzaProfiloArtista/{$recensione->getAutore()->getId()}">
                    {$recensione->getAutore()->getNome()} {$recensione->getAutore()->getCognome()}
                </a>
                <span class="has-text-grey is-size-7 ml-2">{$recensione->getData()|date_format:"%d/%m/%Y"}</span>
            </p>
            {if isset($utente_loggato) && $utente_loggato->getRuolo() != 'Amministratore' && $utente_loggato->getId() != $recensione->getAutore()->getId()}
    <form method="POST" action="/Gallerist/gestioneInterazioni/inviaSegnalazione" style="display:inline;">
        <input type="hidden" name="id_segnalato" value="{$recensione->getId()}">
        <input type="hidden" name="tipo_segnalazione" value="Commento">
        <input type="hidden" name="descrizione" value="Commento inappropriato segnalato dall'utente">
        <button type="submit" class="button is-small is-danger is-outlined"
                onclick="return confirm('Vuoi segnalare questo commento?')">
            <span class="icon"><i class="fas fa-flag"></i></span>
        </button>
    </form>
{/if}
        </div>
        <p class="mt-2">{$recensione->getTesto()}</p>
    </div>
{foreachelse}
    <p class="has-text-grey">Nessuna recensione presente per quest'opera.</p>
{/foreach}

      {if !isset($utente_loggato) || ($utente_loggato->getRuolo() != 'Amministratore' && $utente_loggato->getId() != $opera->getArtista()->getId())}
    <div class="mt-6">
        {include file="FormRecensione.tpl"}
    </div>
{/if}
    </div>
  </div>
</section>

<hr class="dropdown-divider my-6">


<section class="section px-0">
  <h3 class="title is-3 mb-5">Altro di {$opera->getArtista()->getNome()}</h3>
  
  <div class="columns is-multiline">
    {foreach from=$altreOpere item=altra_opera}
      <div class="column is-3">
        <div class="card h-full artwork-card">
  <div class="card-image">
    <figure class="image is-4by3">
      {assign var='immagini_altra' value=$altra_opera->getImmagini()}
{if $immagini_altra|@count > 0}
    {assign var='prima_altra' value=$immagini_altra[0]}
    <img src="/Gallerist/uploads/opere/{$prima_altra->getUrlFile()}" alt="{$altra_opera->getTitolo()}" class="artwork-img">
{else}
    <img src="/Gallerist/img/default_opera.png" alt="{$altra_opera->getTitolo()}" class="artwork-img">
{/if}
    </figure>
  </div>
          <div class="card-content">
            <p class="title is-5 mb-1">{$altra_opera->getTitolo()}</p>
            <p class="subtitle is-6 mb-3 has-text-grey">{$altra_opera->getDimensioni()}</p>
            <p class="is-size-5 has-text-weight-bold">€ {$altra_opera->getPrezzo()->getValore()|number_format:2:',':'.'}</p>
            <a href="/Gallerist/catalogo/visualizzaDettagliOpera/{$altra_opera->getId()}" class="button is-small is-outlined is-fullwidth mt-3">Vedi dettagli</a>
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
<div id="modal-segnalazione-opera" class="modal">
    <div class="modal-background" onclick="this.parentElement.classList.remove('is-active')"></div>
    <div class="modal-card">
        <header class="modal-card-head">
            <p class="modal-card-title">Segnala Opera</p>
            <button class="delete" onclick="this.closest('.modal').classList.remove('is-active')"></button>
        </header>
        <section class="modal-card-body">
            <form method="POST" action="/Gallerist/gestioneInterazioni/inviaSegnalazione">
                <input type="hidden" name="id_segnalato" value="{$opera->getId()}">
                <input type="hidden" name="tipo_segnalazione" value="Opera">
                
                <div class="field">
                    <label class="label">Descrizione del problema</label>
                    <div class="control">
                        <textarea class="textarea" name="descrizione" 
                                  placeholder="Descrivi il problema..." 
                                  required minlength="10"></textarea>
                    </div>
                </div>
                <button type="submit" class="button is-danger is-fullwidth mt-3">
                    Conferma Segnalazione
                </button>
            </form>
        </section>
    </div>
</div>

<script>
document.getElementById('btn-segnala-opera')?.addEventListener('click', () => {
    document.getElementById('modal-segnalazione-opera').classList.add('is-active');
});
</script>
<script src="/Gallerist/js/dettaglioOpera.js"></script>
{/block}