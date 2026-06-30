{extends file='layout.tpl'}
{block name=content}
<section class="section admin-validation">
  <div class="container is-fluid">

    <!-- ==========================================
         INTESTAZIONE E PULSANTI DI AZIONE
         ========================================== -->
    <div class="is-flex is-justify-content-space-between is-align-items-center mb-6">
      <div>
        <h1 class="title is-3 mb-1">Verifica Utente</h1>
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
            <div class="media-left">
              <figure class="image is-96x96">
                <img class="is-rounded admin-validation-avatar" src="...">
              </figure>
            </div>
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

            <!-- Portfolio di esempio -->
            <div>
              <h3 class="title is-6 mb-3">Esempi di Portfolio Opere</h3>
              <div class="columns is-mobile is-multiline">
                {foreach from=$opere_portfolio item=opera}
                  <div class="column is-4-tablet is-12-mobile">
                    <div class="card admin-validation-portfolio-card">
                      <div class="card-image">
                        <figure class="image is-4by3">
                          <img src="{$opera.src}" alt="{$opera.titolo}">
                      </div>
                      <div class="p-2 has-text-centered">
                        <p class="is-size-7 has-text-weight-semibold is-truncated" title="{$opera.titolo}">{$opera.titolo}</p>
                      </div>
                    </div>
                  </div>
                {foreachelse}
                  <div class="column is-12">
                    <p class="has-text-grey is-italic">Nessuna opera caricata nel portfolio di prova.</p>
                  </div>
                {/foreach}
              </div>
              
              {if $opere_portfolio}
                <div class="has-text-right mt-3">
                  <a href="admin_portfolio_completo.php?id={$utente.id}" class="is-size-7 has-text-link has-text-weight-bold">Visualizza tutto <i class="fas fa-chevron-right ml-1"></i></a>
                </div>
              {/if}
            </div>

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
      <!-- Immagine composita fronte/retro caricata dal backend -->
      <img src="..." alt="Documento Identità Fronte Retro" class="admin-validation-doc-preview">
    </p>
  </div>
  <button class="modal-close is-large" aria-label="close" id="chiudi-modal-btn"></button>
</div>
<script src="js/adminValidazione.js"></script>
{/block}