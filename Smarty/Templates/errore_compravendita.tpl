{extends file='layout.tpl'}
{block name=content}
<section class="section">
    <div class="container has-text-centered">
        <span class="icon is-large has-text-danger mb-4">
            <i class="fas fa-exclamation-circle fa-4x"></i>
        </span>
        <h1 class="title is-2 mt-4">Si è verificato un errore</h1>
        <p class="subtitle is-5 has-text-grey mt-3">
            {$errore}
        </p>
        <a href="/catalogo/esploraCatalogo" class="button is-primary is-large mt-4">
            <span class="icon"><i class="fas fa-palette"></i></span>
            <span>Torna al Catalogo</span>
        </a>
    </div>
</section>
{/block}