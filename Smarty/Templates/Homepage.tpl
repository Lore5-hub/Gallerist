<section class="hero is-black is-medium">
  <div class="hero-body">
    <div class="container has-text-centered">
      
      <h1 class="title is-1 has-text-white">Gallerist</h1>
      <p class="subtitle is-4 mt-3 has-text-grey-light">
        Scopri, acquista e vendi opere d'arte uniche da tutto il mondo
      </p>
      
      <div class="columns is-centered mt-5">
        <div class="column is-6">
          <form action="catalogo.php" method="GET">
            <div class="field has-addons">
              <div class="control is-expanded has-icons-left">
                <input class="input is-medium" type="text" name="ricerca" placeholder="Cerca un'opera, un artista o una tecnica...">
                <span class="icon is-small is-left">
                  <i class="fas fa-search"></i>
                </span>
              </div>
              <div class="control">
                <button type="submit" class="button is-primary is-medium has-text-weight-bold">
                  Cerca
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>

    </div>
  </div>
</section>

<section class="section">
  <div class="container">
    
    <div class="is-flex is-justify-content-space-between is-align-items-flex-end mb-5">
      <h2 class="title is-3 mb-0">Esplora per Categorie</h2>
      <a href="catalogo.php" class="button is-outlined is-link">
        Esplora Catalogo <i class="fas fa-arrow-right ml-2"></i>
      </a>
    </div>

    <div class="tile is-ancestor">
      
      <div class="tile is-parent is-8">
        <a href="catalogo.php?categoria=pittura" class="tile is-child box p-0 is-clipped is-relative" style="min-height: 400px;">
          <img src="img/categoria-pittura.jpg" alt="Pittura" style="object-fit: cover; width: 100%; height: 100%; position: absolute; top: 0; left: 0;">
          <div class="is-overlay is-flex is-align-items-flex-end p-5" style="background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);">
            <h3 class="title is-2 has-text-white">Pittura</h3>
          </div>
        </a>
      </div>

      <div class="tile is-vertical is-4">
        
        <div class="tile is-parent">
          <a href="catalogo.php?categoria=scultura" class="tile is-child box p-0 is-clipped is-relative" style="min-height: 190px;">
            <img src="img/categoria-scultura.jpg" alt="Scultura" style="object-fit: cover; width: 100%; height: 100%; position: absolute; top: 0; left: 0;">
            <div class="is-overlay is-flex is-align-items-flex-end p-4" style="background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);">
              <h3 class="title is-4 has-text-white">Scultura</h3>
            </div>
          </a>
        </div>
        
        <div class="tile is-parent">
          <a href="catalogo.php?categoria=fotografia" class="tile is-child box p-0 is-clipped is-relative" style="min-height: 190px;">
            <img src="img/categoria-fotografia.jpg" alt="Fotografia" style="object-fit: cover; width: 100%; height: 100%; position: absolute; top: 0; left: 0;">
            <div class="is-overlay is-flex is-align-items-flex-end p-4" style="background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);">
              <h3 class="title is-4 has-text-white">Fotografia</h3>
            </div>
          </a>
        </div>

      </div>

    </div>
  </div>
</section>

<section class="section has-background-light">
  <div class="container">
    
    <div class="has-text-centered mb-6">
      <h2 class="title is-3">Opere più apprezzate</h2>
      <p class="subtitle is-6 has-text-grey">I capolavori più votati dalla nostra community</p>
    </div>

    <div class="columns is-multiline">
      
      {foreach from=$opere_popolari item=opera}
        
        <div class="column is-3-desktop is-6-tablet">
          <a href="dettaglio_opera.php?id={$opera->getId()}">
            <div class="card is-shadowless" style="background: transparent;">
              
              <div class="card-image box p-1" style="transition: transform 0.3s; cursor: pointer;" onmouseover="this.style.transform='scale(1.03)'" onmouseout="this.style.transform='scale(1)'">
                <figure class="image is-4by3">
                  <img src="{$opera->getUrlImmagine()}" alt="Opera: {$opera->getId()}" style="object-fit: cover; border-radius: 4px;">
                </figure>
              </div>
              
            </div>
          </a>
        </div>
        
      {foreachelse}
        <div class="column is-12 has-text-centered">
          <p class="has-text-grey">Al momento non ci sono opere popolari da mostrare.</p>
        </div>
      {/foreach}
      </div>

  </div>
</section>