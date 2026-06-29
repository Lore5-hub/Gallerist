{extends file='layout.tpl'}
{block name=content}
<div class="box has-background-light artwork-review-form">
  <h4 class="title is-4 mb-4 has-text-black">Lascia una recensione</h4>
  
  <form method="POST" action="salva_recensione.php">
    
    <input type="hidden" name="id_opera" value="{$opera->getId()}">

    <div class="field">
      <label class="label">Valutazione <span class="has-text-danger">*</span></label>
      <div class="control has-icons-left">
        <div class="select {if isset($errori.valutazione)}is-danger{/if}">
          <select name="valutazione" required>
            <option value="" disabled selected>Scegli un voto da 1 a 5...</option>
            <option value="5">5 - Eccellente</option>
            <option value="4">4 - Molto Buono</option>
            <option value="3">3 - Nella Media</option>
            <option value="2">2 - Scarso</option>
            <option value="1">1 - Pessimo</option>
          </select>
        </div>
        <span class="icon is-small is-left has-text-warning">
          <i class="fas fa-star"></i>
        </span>
      </div>
      {if isset($errori.valutazione)}<p class="help is-danger">{$errori.valutazione}</p>{/if}
    </div>

    <div class="field mt-4">
      <label class="label">Commento <span class="has-text-danger">*</span></label>
      <div class="control">
        <textarea class="textarea {if isset($errori.commento)}is-danger{/if}" 
                  name="commento" 
                  placeholder="Racconta cosa ti ha colpito di quest'opera..." 
                  required 
                  minlength="10" 
                  maxlength="500">{if isset($vecchi_dati.commento)}{$vecchi_dati.commento}{/if}</textarea>
      </div>
      {if isset($errori.commento)}
        <p class="help is-danger">{$errori.commento}</p>
      {else}
        <p class="help has-text-grey">Minimo 10 caratteri, massimo 500.</p>
      {/if}
    </div>

    <div class="field is-grouped mt-5">
      <div class="control">
        <button type="submit" class="button is-primary">
          <span class="icon"><i class="fas fa-paper-plane"></i></span>
          <span>Aggiungi commento</span>
        </button>
      </div>
      <div class="control">
        <button type="reset" class="button is-light">Annulla</button>
      </div>
    </div>

  </form>
</div>
{/block}