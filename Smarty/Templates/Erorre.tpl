{extends file="layout.tpl"}
{block name="contenuto"}
    <div class="errore-container">
        <h1>{$codice}</h1>
        <h2>{$titolo}</h2>
        <p>{$messaggio}</p>
        <a href="/Gallerist">← Torna alla home</a>
    </div>
{/block}