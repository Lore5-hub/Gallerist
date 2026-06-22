<div class="columns">
  <div class="column is-6">
    <figure class="image is-fullwidth">
      <img src="url_to_image" alt="Immagine Registrazione" />
    </figure>
  </div>

  <div class="column is-6">
    <div class="field">
      <label class="label">Tipo di Account</label>
      <div class="control">
        <label class="radio">
          <input type="radio" name="ruolo" value="artista" id="ruolo-artista" {if isset($vecchi_dati.ruolo) && $vecchi_dati.ruolo == 'artista'}checked{/if}>
          Artista
        </label>
        <label class="radio">
          <input type="radio" name="ruolo" value="utente" id="ruolo-utente" {if !isset($vecchi_dati.ruolo) || $vecchi_dati.ruolo != 'artista'}checked{/if}>
          Utente Standard
        </label>
      </div>
    </div>

    <div class="field is-grouped">
      <div class="control is-expanded">
        <label class="label">Nome</label>
        <input class="input {if isset($errori.nome)}is-danger{/if}" type="text" id="nome" name="nome" value="{if isset($vecchi_dati.nome)}{$vecchi_dati.nome}{/if}" required pattern="[A-Za-zÀ-ÿ\s']+" placeholder="Mario">
        <p id="error-nome" class="help is-danger is-hidden">Il nome può contenere solo lettere.</p>
        {if isset($errori.nome)}
          <p class="help is-danger">{$errori.nome}</p>
        {/if}
      </div>
      
      <div class="control is-expanded">
        <label class="label">Cognome</label>
        <input class="input {if isset($errori.cognome)}is-danger{/if}" type="text" id="cognome" name="cognome" value="{if isset($vecchi_dati.cognome)}{$vecchi_dati.cognome}{/if}" required pattern="[A-Za-zÀ-ÿ\s']+" placeholder="Rossi">
        <p id="error-cognome" class="help is-danger is-hidden">Il cognome può contenere solo lettere.</p>
        {if isset($errori.cognome)}
          <p class="help is-danger">{$errori.cognome}</p>
        {/if}
      </div>
    </div>
  </div>
</div>

<hr>

<div class="field">
  <label class="label">Email</label>
  <div class="control has-icons-left">
    <input class="input {if isset($errori.email)}is-danger{/if}" type="email" id="email" name="email" value="{if isset($vecchi_dati.email)}{$vecchi_dati.email}{/if}" required placeholder="esempio@dominio.com">
    <span class="icon is-small is-left">
      <i class="fas fa-envelope"></i>
    </span>
  </div>
  <p id="error-email" class="help is-danger is-hidden">Inserisci un indirizzo email valido.</p>
  {if isset($errori.email)}
    <p class="help is-danger">{$errori.email}</p>
  {/if}
</div>

<div class="field">
  <label class="label">Password</label>
  <div class="control has-icons-left">
    <input class="input {if isset($errori.password)}is-danger{/if}" type="password" id="password" name="password" minlength="8" required placeholder="••••••••">
    <span class="icon is-small is-left">
      <i class="fas fa-lock"></i>
    </span>
  </div>
  <p id="error-password" class="help is-danger is-hidden">La password deve contenere almeno 8 caratteri.</p>
  {if isset($errori.password)}
    <p class="help is-danger">{$errori.password}</p>
  {/if}
</div>

<div class="field">
  <label class="label">Data di Nascita</label>
  <div class="control has-icons-right">
    <input class="input {if isset($errori.data_nascita)}is-danger{/if}" type="date" id="data_nascita" name="data_nascita" value="{if isset($vecchi_dati.data_nascita)}{$vecchi_dati.data_nascita}{/if}" required>
    <span class="icon is-small is-right" style="pointer-events: none;">
      <i class="fas fa-calendar"></i>
    </span>
  </div>
  <p id="error-data" class="help is-danger is-hidden">Devi essere maggiorenne per registrarti.</p>
  {if isset($errori.data_nascita)}
    <p class="help is-danger">{$errori.data_nascita}</p>
  {/if}
</div>

<div class="field">
  <label class="label">Indirizzo di Spedizione</label>
  <div class="control">
    <input class="input {if isset($errori.indirizzo)}is-danger{/if}" type="text" id="indirizzo" name="indirizzo" value="{if isset($vecchi_dati.indirizzo)}{$vecchi_dati.indirizzo}{/if}" required minlength="10" placeholder="Via Roma 15, Roma (RM)">
  </div>
  <p id="error-indirizzo" class="help is-danger is-hidden">Inserisci un indirizzo completo (Via, Civico, Città).</p>
  {if isset($errori.indirizzo)}
    <p class="help is-danger">{$errori.indirizzo}</p>
  {/if}
</div>

<div class="field">
  <label class="label">Nickname</label>
  <div class="control">
    <input class="input {if isset($errori.nickname)}is-danger{/if}" type="text" id="nickname" name="nickname" value="{if isset($vecchi_dati.nickname)}{$vecchi_dati.nickname}{/if}" required minlength="3" pattern="[A-Za-z0-9_]+" placeholder="art_lover99">
  </div>
  <p id="error-nickname" class="help is-danger is-hidden">Usa almeno 3 caratteri (solo lettere, numeri e underscore).</p>
  {if isset($errori.nickname)}
    <p class="help is-danger">{$errori.nickname}</p>
  {/if}
</div>

<div class="field">
  <label class="label">Numero di Telefono</label>
  <div class="control">
    <input class="input {if isset($errori.telefono)}is-danger{/if}" type="tel" id="telefono" name="telefono" value="{if isset($vecchi_dati.telefono)}{$vecchi_dati.telefono}{/if}" required pattern="[0-9]{9,11}" placeholder="3331234567">
  </div>
  <p id="error-telefono" class="help is-danger is-hidden">Inserisci un numero di telefono valido (9-11 cifre, solo numeri).</p>
  {if isset($errori.telefono)}
    <p class="help is-danger">{$errori.telefono}</p>
  {/if}
</div>


<div id="campi-artista" class="{if !isset($vecchi_dati.ruolo) || $vecchi_dati.ruolo != 'artista'}is-hidden{/if}">
  <h3 class="title is-4 has-text-info mt-5">Sezione Artista</h3>

  <div class="field">
    <label class="label">Biografia</label>
    <div class="control">
      <textarea class="textarea {if isset($errori.biografia)}is-danger{/if}" name="biografia" id="biografia" minlength="50" maxlength="1000" placeholder="Racconta la tua storia...">{if isset($vecchi_dati.biografia)}{$vecchi_dati.biografia}{/if}</textarea>
    </div>
    {if isset($errori.biografia)}
      <p class="help is-danger">{$errori.biografia}</p>
    {/if}
  </div>

  <div class="field">
    <label class="label">Stile Artistico</label>
    <div class="control">
      <input class="input {if isset($errori.stile)}is-danger{/if}" type="text" name="stile" value="{if isset($vecchi_dati.stile)}{$vecchi_dati.stile}{/if}" pattern="[A-Za-zÀ-ÿ\s,]+" maxlength="50" placeholder="Es. Astrattismo, Impressionismo">
    </div>
    {if isset($errori.stile)}
      <p class="help is-danger">{$errori.stile}</p>
    {/if}
  </div>

  <div class="field">
    <label class="label">Portfolio Opere (PDF o ZIP)</label>
    <div class="file has-name is-fullwidth">
      <label class="file-label">
        <input class="file-input" type="file" name="portfolio" />
        <span class="file-cta">
          <span class="file-icon"><i class="fas fa-upload"></i></span>
          <span class="file-label">Aggiungi opere al portfolio</span>
        </span>
        <span class="file-name">Nessun file selezionato</span>
      </label>
    </div>
  </div>

  <div class="field">
    <label class="label">Documento d'Identità (Fronte/Retro)</label>
    <div class="file has-name is-fullwidth">
      <label class="file-label">
        <input class="file-input" type="file" name="documento_identita" />
        <span class="file-cta">
          <span class="file-icon"><i class="fas fa-upload"></i></span>
          <span class="file-label">Carica documento</span>
        </span>
        <span class="file-name">Nessun file selezionato</span>
      </label>
    </div>
  </div>
</div>

<hr>

<div class="field">
  <div class="control">
    <label class="checkbox">
      <input type="checkbox" required />
      Accetto i <a href="#">termini e le condizioni</a>
    </label>
  </div>
</div>

<div class="field">
  <button class="button is-large is-primary is-fullwidth">Registrati</button>
</div>

{if isset($stato_registrazione) && $stato_registrazione == 'successo'}
  <div class="notification is-success">
    <button class="delete" onclick="this.parentElement.remove()"></button>
    Registrazione avvenuta con successo! Benvenuto.
  </div>
{/if}

{if isset($stato_registrazione) && $stato_registrazione == 'attesa'}
  <div class="notification is-warning">
    <button class="delete" onclick="this.parentElement.remove()"></button>
    Registrazione in attesa di approvazione da parte dell'amministratore. Riceverai una notifica via email.
  </div>
{/if}

<div class="has-text-centered mt-5">
  <p class="has-text-grey">
    Hai già un account? 
    <a href="login.php" class="has-text-link has-text-weight-bold">Accedi qui</a>
  </p>
</div>

<script src="js/registrazione.js"></script>