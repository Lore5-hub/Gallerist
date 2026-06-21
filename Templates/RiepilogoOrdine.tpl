<form method="POST" action="processa_pagamento.php">
  
  <input type="hidden" name="id_opera" value="{$ordine->getOpera()->getId()}">

  <div class="columns is-variable is-6 mt-4">
    
    <div class="column is-7">
      <h2 class="title is-3 mb-5">Riepilogo Ordine</h2>
      
      <div class="box">
        
        <div class="is-flex is-align-items-center mb-5">
          <h3 class="title is-4 mb-0 mr-3">{$ordine->getOpera()->getAutore()->getNome()}</h3>
          <span class="tag is-warning is-light is-medium">
            <span class="icon is-small mr-1"><i class="fas fa-star"></i></span>
            <strong>{$ordine->getOpera()->getAutore()->getValutazioneMedia()|number_format:1:',':'.'}</strong>
          </span>
        </div>

        <article class="media">
          <figure class="media-left">
            <p class="image is-128x128 box p-1 is-shadowless" style="border: 1px solid #eee;">
              <img src="{$ordine->getOpera()->getUrlImmagine()}" alt="Immagine dell'opera" style="object-fit: cover; height: 100%;">
            </p>
          </figure>
          
          <div class="media-content is-align-self-center">
            <div class="content">
              <p class="title is-5 mb-2">{$ordine->getOpera()->getTitolo()}</p>
              <p class="subtitle is-6 has-text-grey mb-3">{$ordine->getOpera()->getCategoria()}</p>
              
              <p class="is-size-6 mb-1">
                <span class="icon is-small has-text-grey mr-1"><i class="fas fa-ruler-combined"></i></span> 
                {$ordine->getOpera()->getDimensioni()}
              </p>
              <p class="is-size-6">
                <span class="icon is-small has-text-warning mr-1"><i class="fas fa-star"></i></span> 
                {$ordine->getOpera()->getValutazioneMedia()|number_format:1:',':'.'} / 5 (Valutazione Opera)
              </p>
            </div>
          </div>
        </article>
        
      </div>
    </div> <div class="column is-5">
      
      <h3 class="title is-5 mb-3">Indirizzo di Spedizione</h3>
      <div class="box is-flex is-justify-content-space-between is-align-items-center has-background-light">
        <div>
          <p class="has-text-weight-bold">{$ordine->getUtente()->getNome()} {$ordine->getUtente()->getCognome()}</p>
          <p class="is-size-6 has-text-grey">{$ordine->getUtente()->getIndirizzo()}</p>
        </div>
        <a href="modifica_profilo.php" class="button is-small is-ghost" title="Modifica Indirizzo">
          <span class="icon has-text-grey"><i class="fas fa-pencil-alt fa-lg"></i></span>
        </a>
      </div>

      <h3 class="title is-5 mt-5 mb-3">Metodo di Pagamento</h3>
      
      <label class="box is-flex is-align-items-center is-clickable mb-2 py-3">
        <input type="radio" name="metodo_pagamento" value="carta" checked>
        <span class="icon is-medium ml-3 has-text-info"><i class="fas fa-credit-card fa-lg"></i></span>
        <span class="ml-2 has-text-weight-bold">Carta di Credito / Debito</span>
      </label>
      
      <label class="box is-flex is-align-items-center is-clickable mb-2 py-3">
        <input type="radio" name="metodo_pagamento" value="paypal">
        <span class="icon is-medium ml-3 has-text-link"><i class="fab fa-paypal fa-lg"></i></span>
        <span class="ml-2 has-text-weight-bold">PayPal</span>
      </label>
      
      <label class="box is-flex is-align-items-center is-clickable mb-5 py-3">
        <input type="radio" name="metodo_pagamento" value="bonifico">
        <span class="icon is-medium ml-3 has-text-grey"><i class="fas fa-university fa-lg"></i></span>
        <span class="ml-2 has-text-weight-bold">Bonifico Bancario</span>
      </label>

      <div class="box">
        <div class="level is-mobile mb-2">
          <div class="level-left"><p class="has-text-grey">Totale articolo</p></div>
          <div class="level-right"><p class="has-text-weight-bold">€ {$ordine->getOpera()->getPrezzo()|number_format:2:',':'.'}</p></div>
        </div>
        
        <div class="level is-mobile mb-2">
          <div class="level-left"><p class="has-text-grey">Spedizione</p></div>
          <div class="level-right"><p class="has-text-weight-bold has-text-success">Gratis</p></div>
        </div>
        
        <hr class="my-3">
        
        <div class="level is-mobile">
          <div class="level-left"><p class="title is-4 mb-0">Totale</p></div>
          <div class="level-right">
            <p class="title is-3 has-text-primary mb-0">€ {$ordine->getOpera()->getPrezzo()|number_format:2:',':'.'}</p>
          </div>
        </div>
      </div>
      
      <button type="submit" class="button is-success is-large is-fullwidth mt-4 has-text-weight-bold">
        <span class="icon"><i class="fas fa-lock"></i></span>
        <span>Procedi al pagamento</span>
      </button>
      <p class="help has-text-centered mt-2 has-text-grey">
        <i class="fas fa-shield-alt"></i> Transazione sicura e crittografata
      </p>
      
    </div> </div>
</form>