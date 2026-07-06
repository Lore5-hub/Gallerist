{extends file="layout.tpl"}

{block name=content}
<section class="hero is-fullheight-with-navbar error-hero">
  <div class="hero-body">
    <div class="container has-text-centered">
      
      <!-- Codice Errore -->
      <h1 class="error-code">{$codice}</h1>
      
      <!-- Titolo e Messaggio -->
      <h2 class="title is-2">{$titolo}</h2>
      <p class="subtitle is-5 error-message has-text-grey">{$messaggio}</p>
      
      <!-- Call to Action -->
      <div class="mt-5">
        <a href="/Gallerist" class="button is-link is-large is-rounded">
          <span class="icon"><i class="fas fa-home"></i></span>
          <span>Torna alla Home</span>
        </a>
      </div>
      
    </div>
  </div>
</section>
{/block}