{extends file='layout.tpl'}
{block name=content}
<form method="POST" action="/Gallerist/gestioneProfiloPortfolio/salvaOpera" enctype="multipart/form-data">
  
  <div class="columns is-variable is-6 mt-4">
    
    <div class="column is-7">
      <h2 class="title is-3 mb-5">Aggiungi nuova opera</h2>
      
      <div class="field">
        <label class="label">Titolo dell'opera <span class="has-text-danger">*</span></label>
        <div class="control">
          <input class="input {if isset($errori.titolo)}is-danger{/if}" type="text" name="titolo" value="{if isset($vecchi_dati.titolo)}{$vecchi_dati.titolo}{/if}" placeholder="Es. Notte Stellata" required>
        </div>
        {if isset($errori.titolo)}<p class="help is-danger">{$errori.titolo}</p>{/if}
      </div>

      <div class="field">
        <label class="label">Anno di Realizzazione <span class="has-text-danger">*</span></label>
        <div class="control has-icons-left">
          <input class="input {if isset($errori.anno)}is-danger{/if}" type="number" name="anno" value="{if isset($vecchi_dati.anno)}{$vecchi_dati.anno}{/if}" placeholder="Es. 2023" min="1000" max="2100" required>
          <span class="icon is-small is-left">
            <i class="fas fa-calendar-alt"></i>
          </span>
        </div>
        {if isset($errori.anno)}<p class="help is-danger">{$errori.anno}</p>{/if}
      </div>

      <div class="field">
        <label class="label">Tecnica <span class="has-text-danger">*</span></label>
        <div class="control">
          <input class="input {if isset($errori.tecnica)}is-danger{/if}" type="text" name="tecnica" value="{if isset($vecchi_dati.tecnica)}{$vecchi_dati.tecnica}{/if}" placeholder="Es. Olio su tela" required>
        </div>
        {if isset($errori.tecnica)}<p class="help is-danger">{$errori.tecnica}</p>{/if}
      </div>

      <div class="field">
        <label class="label">Dimensioni (Larghezza x Altezza x Profondità) <span class="has-text-danger">*</span></label>
        <div class="field has-addons">
          <p class="control is-expanded">
            <input class="input" type="number" step="0.1" name="larghezza" placeholder="Larg." required>
          </p>
          <p class="control is-expanded">
            <input class="input" type="number" step="0.1" name="altezza" placeholder="Alt." required>
          </p>
          <p class="control is-expanded">
            <input class="input" type="number" step="0.1" name="profondita" placeholder="Prof." required>
          </p>
          <p class="control">
            <span class="select">
              <select name="unita_misura">
                <option value="cm">cm</option>
                <option value="m">m</option>
              </select>
            </span>
          </p>
        </div>
      </div>

      <div class="field mt-4">
        <label class="label">Descrizione <span class="has-text-danger">*</span></label>
        <div class="control">
          <textarea class="textarea {if isset($errori.descrizione)}is-danger{/if}" name="descrizione" rows="5" placeholder="Racconta la storia e il significato della tua opera..." required>{if isset($vecchi_dati.descrizione)}{$vecchi_dati.descrizione}{/if}</textarea>
        </div>
        {if isset($errori.descrizione)}<p class="help is-danger">{$errori.descrizione}</p>{/if}
      </div>

      <div class="field mt-4">
        <label class="label">Categoria <span class="has-text-danger">*</span></label>
        <div class="control">
          <div class="select is-fullwidth {if isset($errori.categoria)}is-danger{/if}">
            <select name="categoria" required>
    <option value="" disabled selected>Seleziona una categoria...</option>
    {foreach from=$categorie item=categoria}
        <option value="{$categoria->getNome()}">{$categoria->getNome()}</option>
    {/foreach}
</select>
          </div>
        </div>
        {if isset($errori.categoria)}<p class="help is-danger">{$errori.categoria}</p>{/if}
      </div>

      <div class="field">
        <label class="label">Tag <span class="has-text-grey is-size-7 fw-normal">(Facoltativo)</span></label>
        <div class="control">
          <input class="input" type="text" name="tags" value="{if isset($vecchi_dati.tags)}{$vecchi_dati.tags}{/if}" placeholder="Es. paesaggio, astratto, bianco e nero (separati da virgola)">
        </div>
      </div>

    </div> <div class="column is-5">
      
      <div class="field">
        <label class="label">Immagini dell'opera <span class="has-text-danger">*</span></label>
        <div class="file is-boxed is-primary is-fullwidth">
          <label class="file-label">
            <input class="file-input" type="file" name="immagini_opera[]" accept="image/*" multiple required />
            <span class="file-cta has-text-centered">
              <span class="file-icon"><i class="fas fa-upload is-large"></i></span>
              <span class="file-label">Carica le foto dell'opera</span>
            </span>
          </label>
        </div>
        <p class="help">Seleziona fino a 4 immagini. La prima sarà la copertina.</p>
      </div>

      <div class="columns is-multiline is-mobile mt-3">
        <div class="column is-12">
          <figure class="image is-5by3 box p-1 artwork-upload-preview">
  <span class="tag is-primary artwork-cover-badge">Copertina</span>
  <div class="has-text-centered has-text-grey mt-6 pt-4">
    <i class="fas fa-image fa-2x mb-2"></i><br>Anteprima Copertina
  </div>
</figure>
        </div>
        <div class="column is-4">
  <figure class="image is-1by1 box p-1 artwork-extra-preview">
    <i class="fas fa-image fa-lg"></i>
  </figure>
</div>
        <div class="column is-4">
          <figure class="image is-1by1 box p-1 has-background-light has-text-centered has-text-grey">
            <br><i class="fas fa-image"></i>
          </figure>
        </div>
        <div class="column is-4">
          <figure class="image is-1by1 box p-1 has-background-light has-text-centered has-text-grey">
            <br><i class="fas fa-image"></i>
          </figure>
        </div>
      </div>

      <hr class="mt-5">

      <h3 class="title is-4">Stato e Vendita</h3>
      
      <div class="field mb-4">
        <label class="checkbox is-size-5">
          <input type="checkbox" id="check_vendita" name="in_vendita" value="1">
          <strong>L'opera è in vendita</strong>
        </label>
      </div>

      <div id="container_prezzo" class="field is-hidden">
        <label class="label">Prezzo di vendita (€)</label>
        <div class="control has-icons-left">
          <input class="input is-medium {if isset($errori.prezzo)}is-danger{/if}" type="number" id="input_prezzo" name="prezzo" step="0.01" min="1" placeholder="Es. 450.00">
          <span class="icon is-left"><i class="fas fa-euro-sign"></i></span>
        </div>
        {if isset($errori.prezzo)}<p class="help is-danger">{$errori.prezzo}</p>{/if}
      </div>

      <hr class="mt-6">

      <div class="field is-grouped is-grouped-right mt-5">
        <p class="control">
          <a href="javascript:history.back()" class="button is-light is-large">Annulla</a>
        </p>
        <p class="control">
          <button type="submit" class="button is-success is-large">
            <span class="icon"><i class="fas fa-check"></i></span>
            <span>Pubblica Opera</span>
          </button>
        </p>
      </div>

    </div> </div>
</form>
<script src="/Gallerist/js/formOpera.js"></script>
{/block}