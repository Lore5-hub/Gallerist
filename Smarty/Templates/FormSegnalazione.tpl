{extends file='layout.tpl'}
{block name=content}
<div class="box report-form-box">
  <h4 class="title is-4 mb-4 has-text-danger-dark">
    <span class="icon mr-2"><i class="fas fa-exclamation-triangle"></i></span>Invia una Segnalazione
  </h4>
  
  <form method="POST" action="gestione_segnalazione.php">
    
    <div class="field">
      <label class="label">Cosa vuoi segnalare?</label>
      <div class="control">
        <div class="select is-fullwidth">
          <select name="tipo_segnalazione" required>
            <option value="" disabled selected>Seleziona una categoria...</option>
            <option value="opera">Un'opera specifica</option>
            <option value="account">Qualcosa su questo account</option>
            <option value="illegale">Segnala come illegale</option>
            <option value="messaggi">Messaggi recenti</option>
          </select>
        </div>
      </div>
    </div>

    <div class="field">
      <label class="label">Descrizione del problema</label>
      <div class="control">
        <textarea class="textarea" name="descrizione" placeholder="Descrivi il problema in dettaglio in modo che gli amministratori possano verificare..." required minlength="10"></textarea>
      </div>
    </div>

    <div class="field is-grouped mt-5">
      <div class="control">
        <button type="submit" class="button is-danger">Conferma Segnalazione</button>
      </div>
      <div class="control">
        <a href="javascript:history.back()" class="button is-light">Indietro</a>
      </div>
    </div>

  </form>
</div>
{/block}