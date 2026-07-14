{extends file='layout.tpl'}
{block name=content}
<section class="section admin-validation">
  <div class="container is-fluid">

    <!-- ==========================================
         INTESTAZIONE E PULSANTI DI AZIONE
         ========================================== -->
    <div class="is-flex is-justify-content-space-between is-align-items-center mb-6">
      <div>
        <h1 class="title is-3 has-text-dark mb-1">Verifica Utente</h1>
        <p class="subtitle is-6 has-text-grey">Revisione dei dati anagrafici e attivazione account</p>
      </div>
      
      <div class="buttons">
        <!-- Torna alla Dashboard (sezione utenti in attesa) -->
        <a href="/Gallerist/Admin/dashboard" class="button is-light">
          <span class="icon"><i class="fas fa-arrow-left"></i></span>
          <span>Torna indietro</span>
        </a>
        <!-- Approva e Attiva -->
        <a href="/Gallerist/Admin/verificaArtista?id={$utente.id}" class="button is-success">
          <span class="icon"><i class="fas fa-user-check"></i></span>
          <span>Approva e attiva</span>
        </a>
      </div>
    </div>

    <!-- ==========================================
         LAYOUT A DUE COLONNE (is-7 e is-5)
         ========================================== -->
    <div class="columns is-desktop">
      
      <!-- COLONNA SINISTRA (is-7): Informazioni Principali, Documenti e Opere -->
      <div class="column is-7-desktop">
        <div class="box p-5">
          
          <!-- Profilo e Stato -->
          <div class="media is-align-items-center mb-5">
            
            <div class="media-content">
              <h2 class="title is-4 mb-2">{$utente.nome} {$utente.cognome}</h2>
              <span class="tag is-warning is-light has-text-weight-semibold">In attesa di verifica</span>
            </div>
          </div>

          <!-- Contatti Rapidi e Registrazione -->
          <div class="block is-size-6 mb-5">
            <p class="mb-2">
              <span class="icon has-text-grey mr-2"><i class="fas fa-envelope"></i></span>
              <a href="mailto:{$utente.email}">{$utente.email}</a>
            </p>
            <p class="mb-2">
              <span class="icon has-text-grey mr-2"><i class="fas fa-calendar-alt"></i></span>
              <span>Registrato il <strong>{$utente.data_registrazione|date_format:"%d/%m/%Y"}</strong></span>
            </p>
          </div>

          <!-- Spaziatore visivo pulito senza usare tag hr -->
          <div class="my-5 admin-validation-divider"></div>

          <!-- Dettagli Artistici e Personali -->
          <div class="content">
            
            <div class="mb-5">
              <h3 class="title is-6 mb-2">Biografia</h3>
              <p class="has-text-grey-dark">{$utente.biografia|default:'Nessuna biografia inserita dall\'utente.'}</p>
            </div>

            <div class="mb-5">
              <h3 class="title is-6 mb-2">Stile Artistico Dichiarato</h3>
              <span class="tag is-info is-light is-medium">{$utente.stile_artistico|default:'Non specificato'}</span>
            </div>

            <div class="mb-5">
              <h3 class="title is-6 mb-2">Località</h3>
              <p class="has-text-grey-dark">
                <span class="icon has-text-danger mr-1"><i class="fas fa-map-marker-alt"></i></span>
                {$utente.localita|default:'Non specificata'}
              </p>
            </div>

            <!-- Sezione Documento d'Identità -->
            <div class="mb-6">
              <h3 class="title is-6 mb-2">Carta d'Identità</h3>
              <div class="notification is-light is-flex is-justify-content-space-between is-align-items-center py-3 px-4">
                <div>
                  <span class="icon has-text-info mr-2"><i class="fas fa-id-card"></i></span>
                  <span>Documento caricato il {$utente.data_documento|date_format:"%d/%m/%Y"}</span>
                </div>
                <!-- Pulsante che attiva la modale -->
                <button class="button is-small is-info is-outlined" id="apri-modal-doc">
                  <span class="icon"><i class="fas fa-eye"></i></span>
                  <span>Visualizza</span>
                </button>
              </div>
            </div>
{if $utente.url_portfolio}
    <div class="mt-4">
        <h4 class="title is-6">Portfolio Opere</h4>
        <a href="{$utente.url_portfolio}" target="_blank" class="button is-info is-outlined">
            <span class="icon"><i class="fas fa-download"></i></span>
            <span>Scarica Portfolio</span>
        </a>
    </div>
{/if}
           

          </div>
        </div>
      </div>

      <!-- COLONNA DESTRA (is-5): Dettagli Tecnici Account e Note interne -->
      <div class="column is-5-desktop">
        
        <!-- Box 1: Dettagli Account -->
        <div class="box p-5 mb-5">
          <h3 class="title is-5 mb-4">
            <span class="icon has-text-grey-dark mr-2"><i class="fas fa-user-cog"></i></span>Dettagli Account
          </h3>
          
          <table class="table is-fullwidth is-striped is-vcentered is-size-6">
            <tbody>
              <tr>
                <td class="has-text-weight-semibold has-text-grey">Nickname</td>
                <td><strong>@{$utente.nickname}</strong></td>
              </tr>
              <tr>
                <td class="has-text-weight-semibold has-text-grey">Data di Nascita</td>
                <td>{$utente.data_nascita|date_format:"%d/%m/%Y"}</td>
              </tr>
              <tr>
                <td class="has-text-weight-semibold has-text-grey">Telefono</td>
                <td>{$utente.telefono|default:'<em>Non fornito</em>'}</td>
              </tr>
              <tr>
                <td class="has-text-weight-semibold has-text-grey">Indirizzo</td>
                <td class="is-size-7">{$utente.indirizzo|default:'<em>Non fornito</em>'}</td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Box 2: Note Amministratore (Riservate) -->
        <div class="box p-5">
          <div class="is-flex is-justify-content-space-between is-align-items-center mb-3">
            <h3 class="title is-5 mb-0">
              <span class="icon has-text-warning-dark mr-2"><i class="fas fa-sticky-note"></i></span>Note Admin
            </h3>
            <span class="tag is-danger is-light">Solo Uso Interno</span>
          </div>
          
          <p class="is-size-7 has-text-grey mb-3">
            Queste annotazioni sono opzionali, salvate automaticamente e visibili esclusivamente al team di moderazione. L'utente non riceverà alcuna notifica al riguardo.
          </p>
          
          <div class="field">
            <div class="control">
              <textarea class="textarea is-small" name="note_admin" rows="6" placeholder="Aggiungi dettagli sulla validazione (es. 'Documento valido, stile confermato', oppure 'Sospetto profilo duplicato')...">{$utente.note_admin}</textarea>
            </div>
          </div>
        </div>

      </div>
    </div>

  </div>
</section>

<!-- ==========================================
     MODALE VISUALIZZAZIONE DOCUMENTO ID
     ========================================== -->
<div id="modal-documento" class="modal">
  <div class="modal-background" id="chiudi-modal-bg"></div>
  <div class="modal-content">
    <p class="image">
        {if $utente.carta_identita}
            <div class="has-text-centered p-4">
                <a href="/Gallerist/uploads/documenti/{$utente.carta_identita}" 
                   target="_blank" class="button is-info is-medium">
                    <span class="icon"><i class="fas fa-file-alt"></i></span>
                    <span>Apri documento</span>
                </a>
            </div>
        {else}
            <p class="has-text-centered has-text-grey p-4">Nessun documento caricato.</p>
        {/if}
    </p>
</div>
  <button class="modal-close is-large" aria-label="close" id="chiudi-modal-btn"></button>
</div>
<script src="/Gallerist/js/adminValidazione.js"></script>
{/block}