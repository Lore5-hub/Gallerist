{extends file='layout.tpl'}
{block name=content}
<div class="columns is-variable is-5 mt-4 page-catalog">
  
  <div class="column is-3">
    <div class="box filter-sidebar">
      <h3 class="title is-4 mb-4">Filtra Opere</h3>
      
      <form method="GET" action="/Gallerist/catalogo/filtraCatalogo">
        
        <div class="field">
          <label class="label">Categoria</label>
          <div class="control">
            <div class="select is-fullwidth {if isset($errori.categoria)}is-danger{/if}">
            <select name="categoria">
    <option value="">Tutte le categorie</option>
    {foreach from=$categorie item=categoria}
        <option value="{$categoria->getNome()}">{$categoria->getNome()}</option>
    {/foreach}
</select>
          </div>
          </div>
        </div>

        <div class="field">
          <label class="label">Prezzo Massimo (€)</label>
          <div class="control">
            <input class="input" type="number" name="prezzo_max" placeholder="Es. 500" min="0">
          </div>
        </div>

        <div class="field">
          <label class="label">Ordina per</label>
          <div class="control">
            <div class="select is-fullwidth">
              <select name="ordinamento">
                <option value="recenti">Più recenti</option>
                <option value="prezzo_asc">Prezzo: Crescente</option>
                <option value="prezzo_desc">Prezzo: Decrescente</option>
              </select>
            </div>
          </div>
        </div>

        <div class="field mt-5">
          <button type="submit" class="button is-primary is-fullwidth">
            Applica Filtri
          </button>
        </div>
        
      </form>
    </div>
  </div>


  <div class="column is-9">
    <h1 class="title is-3 mb-5">Scopri le opere disponibili</h1>

    <div class="columns is-multiline">
      
      {foreach from=$opere item=opera}
        
        <div class="column is-4">
          <div class="card h-full is-flex is-flex-direction-column artwork-card">
            
            <div class="card-image">
              <figure class="image is-4by3">
              
               {if $opera->getImmagini()|@count > 0}
    {assign var='immagini' value=$opera->getImmagini()}
    {assign var='prima' value=$immagini[0]}
    <img src="/Gallerist/uploads/opere/{$prima->getUrlFile()}" alt="{$opera->getTitolo()}" class="artwork-img">
{else}
    <img src="/Gallerist/img/default_opera.png" alt="{$opera->getTitolo()}" class="artwork-img">
{/if}
              </figure>
            </div>
            
            <div class="card-content is-flex-grow-1">
              <p class="title is-5 mb-1">{$opera->getTitolo()}</p>
              <p class="subtitle is-6 mb-3">di <a href="/Gallerist/catalogo/visualizzaProfiloArtista/{$opera->getArtista()->getId()}">{$opera->getArtista()->getNome()}</a></p>
              
              <div class="tags">
                <span class="tag is-light">{$opera->getDimensioni()}</span>
              </div>
              
              <p class="is-size-4 has-text-weight-bold mt-4">
                € {$opera->getPrezzo()->getValore()|number_format:2:',':'.'}
              </p>
            </div>
            
            <footer class="card-footer">
              <a href="/Gallerist/catalogo/visualizzaDettagliOpera/{$opera->getId()}" class="card-footer-item has-background-light has-text-dark has-text-weight-bold">
                Vedi Dettagli
              </a>
            </footer>
            
          </div>
        </div>
        
      {foreachelse}
        <div class="column is-12">
          <div class="notification is-warning is-light has-text-centered">
            <p>Nessuna opera trovata con questi filtri. Prova a modificare la tua ricerca.</p>
          </div>
        </div>
      {/foreach}
      </div>
  </div>
  
</div>
{/block}