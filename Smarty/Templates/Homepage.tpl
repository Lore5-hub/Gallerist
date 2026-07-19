{extends file='layout.tpl'}

{block name=content}

 
<section class="hero is-black is-medium">
  <div class="hero-body">
    <div class="container has-text-centered">
      <h1 class="title is-1 has-text-white">Gallerist</h1>
      <p class="subtitle is-4 mt-3 has-text-grey-light">
        Scopri, acquista e vendi opere d'arte uniche da tutto il mondo
      </p>
      <div class="columns is-centered mt-5">
        <div class="column is-6">
          <form action="/catalogo/filtraCatalogo" method="GET">
            <div class="field has-addons">
              <div class="control is-expanded has-icons-left">
                <input class="input is-medium" type="text" name="parola_chiave" placeholder="Cerca un'opera">
                <span class="icon is-small is-left">
                  <i class="fas fa-search"></i>
                </span>
              </div>
              <div class="control">
                <button type="submit" class="button is-primary is-medium has-text-weight-bold">Cerca</button>
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
      <a href="/catalogo/esploraCatalogo" class="button is-outlined is-link">
        Esplora Catalogo <i class="fas fa-arrow-right ml-2"></i>
      </a>
    </div>

    <div class="tile is-ancestor">
      <!-- Categoria Principale Grande -->
      <div class="tile is-parent is-8">
        <a href="/catalogo/filtraCatalogo?categoria=pittura" class="tile is-child box p-0 is-clipped home-category-tile is-main">
          <img src="https://wips.plug.it/cips/paginegiallecasa/cms/2025/01/pittura-effetti-2.jpg" alt="Pittura" class="home-category-tile-img">
          <div class="is-overlay is-flex is-align-items-flex-end p-5 home-category-tile-overlay">
            <h3 class="title is-2 has-text-white">Pittura</h3>
          </div>
        </a>
      </div>

      <!-- Colonne Laterali Piccole -->
      <div class="tile is-vertical is-4">
        <div class="tile is-parent">
          <a href="/catalogo/filtraCatalogo?categoria=scultura" class="tile is-child box p-0 is-clipped home-category-tile is-sub">
            <img src="https://www.datocms-assets.com/65765/1674835845-venere-di-roma.jpg?ar64=Nzo1&auto=format%2Ccompress&fit=crop" alt="Scultura" class="home-category-tile-img">
            <div class="is-overlay is-flex is-align-items-flex-end p-4 home-category-tile-overlay">
              <h3 class="title is-4 has-text-white">Scultura</h3>
            </div>
          </a>
        </div>
        
        <div class="tile is-parent">
          <a href="/catalogo/filtraCatalogo?categoria=fotografia" class="tile is-child box p-0 is-clipped home-category-tile is-sub">
            <img src="https://mundodasfotos.com.br/wp-content/uploads/2024/11/melhores-cameras-fotograficas-para-iniciantes-768x404.png" alt="Fotografia" class="home-category-tile-img">
            <div class="is-overlay is-flex is-align-items-flex-end p-4 home-category-tile-overlay">
              <h3 class="title is-4 has-text-white">Fotografia</h3>
            </div>
          </a>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="section has-background-green">
  <div class="container">
    <div class="has-text-centered mb-6">
      <h2 class="title is-3">Opere più apprezzate</h2>
      <p class="subtitle is-6 has-text-grey">I capolavori più votati dalla nostra community</p>
    </div>

    <div class="columns is-multiline">
      {foreach from=$opere_popolari item=opera}
        <div class="column is-3-desktop is-6-tablet">
          <a href="/catalogo/visualizzaDettagliOpera/{$opera->getId()}">
            <div class="card is-shadowless home-popular-card">
              <div class="card-image box p-1 home-popular-img-box">
                <figure class="image is-4by3">
                  {assign var='immagini' value=$opera->getImmagini()}
{if $immagini|@count > 0}
    {assign var='prima' value=$immagini[0]}
    <img src="/uploads/opere/{$prima->getUrlFile()}" alt="Opera: {$opera->getId()}">
{else}
    <img src="/img/default_opera.png" alt="Opera: {$opera->getId()}">
{/if}
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
   {/block}