<div class="columns is-variable is-5 mt-4">
  
  <div class="column is-3">
    <div class="box">
      <h3 class="title is-4 mb-4">Filtra Opere</h3>
      
      <form method="GET" action="catalogo.php">
        
        <div class="field">
          <label class="label">Categoria</label>
          <div class="control">
            <div class="select is-fullwidth">
              <select name="categoria">
                <option value="">Tutte le categorie</option>
                <option value="pittura">Pittura</option>
                <option value="scultura">Scultura</option>
                <option value="fotografia">Fotografia</option>
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
              <select name="ordine">
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
          <div class="card h-100 is-flex is-flex-direction-column">
            
            <div class="card-image">
              <figure class="image is-4by3">
                <img src="{$opera->getUrlImmagine()}" alt="{$opera->getTitolo()}" style="object-fit: cover;">
              </figure>
            </div>
            
            <div class="card-content is-flex-grow-1">
              <p class="title is-5 mb-1">{$opera->getTitolo()}</p>
              <p class="subtitle is-6 mb-3">di <a href="profilo.php?id={$opera->getAutore()->getId()}">{$opera->getAutore()->getNome()}</a></p>
              
              <div class="tags">
                <span class="tag is-light">{$opera->getDimensioni()}</span>
              </div>
              
              <p class="is-size-4 has-text-weight-bold mt-4">
                € {$opera->getPrezzo()|number_format:2:',':'.'}
              </p>
            </div>
            
            <footer class="card-footer">
              <a href="dettaglio_opera.php?id={$opera->getId()}" class="card-footer-item has-background-light has-text-dark has-text-weight-bold">
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