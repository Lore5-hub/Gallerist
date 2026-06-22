<form method="POST" action="processa_moderazione.php">
  <input type="hidden" name="id_segnalazione" value="{$segnalazione.id}">
  <input type="hidden" name="id_utente_segnalato" value="{$autore_contenuto.id}">

  <section class="section has-background-white-bis">
    <div class="container is-fluid">

      <!-- ==========================================
           INTESTAZIONE
           ========================================== -->
      <div class="block mb-6">
        <h1 class="title is-3 mb-1">Dettaglio Segnalazione</h1>
        <p class="subtitle is-6 has-text-grey">Esamina il ticket e applica le necessarie misure di moderazione</p>
      </div>

      <!-- ==========================================
           RIGA 1: 3 COLONNE is-4 (Informazioni, Contenuto, Motivo)
           ========================================== -->
      <div class="columns is-desktop mb-5">
        
        <!-- Riquadro 1: Informazioni Segnalazione -->
        <div class="column is-4-desktop">
          <div class="box" style="height: 100%;">
            <h3 class="title is-5 mb-4 has-text-grey-dark">
              <span class="icon mr-2"><i class="fas fa-info-circle"></i></span>Informazioni
            </h3>
            <table class="table is-fullwidth is-striped is-narrow is-size-6">
              <tbody>
                <tr>
                  <td class="has-text-weight-semibold has-text-grey">Tipo Oggetto</td>
                  <td><span class="tag is-dark">{$segnalazione.tipo_oggetto}</span></td> <!-- Es: Commento o Opera -->
                </tr>
                <tr>
                  <td class="has-text-weight-semibold has-text-grey">Segnalato da</td>
                  <td><strong>@{$segnalazione.autore_segnalazione}</strong></td>
                </tr>
                <tr>
                  <td class="has-text-weight-semibold has-text-grey">Data</td>
                  <td>{$segnalazione.data_invio|date_format:"%d/%m/%Y %H:%M"}</td>
                </tr>
                <tr>
                  <td class="has-text-weight-semibold has-text-grey">Stato Ticket</td>
                  <td>
                    {if $segnalazione.stato == 'Aperta'}
                      <span class="tag is-danger is-light">In gestione</span>
                    {else}
                      <span class="tag is-success is-light">Risolta</span>
                    {/if}
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

        <!-- Riquadro 2: Contenuto Segnalato (Gestione Dinamica Commento / Opera) -->
        <div class="column is-4-desktop">
          <div class="box is-flex is-flex-direction-column is-justify-content-space-between" style="height: 100%;">
            <div>
              <h3 class="title is-5 mb-4 has-text-grey-dark">
                <span class="icon mr-2"><i class="fas fa-exclamation-triangle"></i></span>Contenuto Segnalato
              </h3>
              
              {if $segnalazione.tipo_oggetto == 'Commento'}
                <!-- Se è stato segnalato un commento -->
                <p class="subtitle is-6 mb-2">
                  <span class="icon has-text-info mr-1"><i class="fas fa-comment-dots"></i></span>
                  Commento su: <strong>{$segnalazione.titolo_opera}</strong>
                </p>
                <div class="box has-background-light p-3 is-shadowless" style="border-left: 4px solid #3273dc;">
                  <p class="is-italic is-size-6">"{$segnalazione.testo_incriminato}"</p>
                </div>
              {else}
                <!-- Se è stata segnalata direttamente l'opera -->
                <p class="subtitle is-6 mb-2">
                  <span class="icon has-text-primary mr-1"><i class="fas fa-palette"></i></span>
                  Opera: <strong>{$segnalazione.titolo_opera}</strong>
                </p>
                <p class="is-size-7 has-text-grey mb-2">Categoria: {$segnalazione.categoria_opera}</p>
                <div class="has-text-centered mb-2">
                  <figure class="image is-inline-block" style="max-height: 100px; overflow: hidden;">
                    <img src="{$segnalazione.url_anteprima_opera}" style="object-fit: contain; max-height: 100px;">
                  </figure>
                </div>
              {/if}
            </div>

            <!-- Il pulsante per vedere l'opera nel contesto del sito c'è sempre -->
            <a href="dettaglio_opera.php?id={$segnalazione.id_opera}" target="_blank" class="button is-small is-link is-light is-fullwidth mt-3">
              <span class="icon"><i class="fas fa-external-link-alt"></i></span>
              <span>Visualizza l'opera sul sito</span>
            </a>
          </div>
        </div>

        <!-- Riquadro 3: Motivo della Segnalazione -->
        <div class="column is-4-desktop">
          <div class="box" style="height: 100%;">
            <h3 class="title is-5 mb-3 has-text-grey-dark">
              <span class="icon mr-2"><i class="fas fa-gavel"></i></span>Motivazione Admin
            </h3>
            <p class="has-text-weight-bold has-text-danger mb-2">{$segnalazione.motivo_principale}</p>
            <div class="content is-size-6">
              <p class="has-text-grey"><strong>Dettagli aggiuntivi forniti dal segnalante:</strong></p>
              <p class="has-text-justified">{$segnalazione.dettagli_aggiuntivi|default:"<em>Nessun dettaglio extra specificato.</em>"}</p>
            </div>
          </div>
        </div>

      </div>

      <!-- ==========================================
           RIGA 2: AUTORE CONTENUTO (is-8) + OPZIONI MODERAZIONE (is-4)
           ========================================== -->
      <div class="columns is-desktop">
        
        <!-- COLONNA DESTRA/SINISTRA is-8: Informazioni sull'Autore del Contenuto -->
        <div class="column is-8-desktop">
          <div class="box">
            
            <!-- Intestazione Autore -->
            <div class="media is-align-items-center mb-4">
              <div class="media-left">
                <figure class="image is-48x48">
                  <img class="is-rounded" src="{$autore_contenuto.foto_profilo|default:'img/default-avatar.png'}" style="object-fit: cover; height: 48px;">
                </figure>
              </div>
              <div class="media-content">
                <h3 class="title is-5 mb-0">Autore del contenuto: @{$autore_contenuto.nickname}</h3>
                <p class="subtitle is-7 has-text-grey">ID Utente: #{$autore_contenuto.id}</p>
              </div>
            </div>

            <!-- Le 4 Mini-Box delle statistiche utente -->
            <div class="columns is-mobile is-multiline mb-4">
              <div class="column is-3-tablet is-6-mobile">
                <div class="notification is-light has-text-centered py-2 px-1 mb-0">
                  <span class="icon has-text-grey mb-1"><i class="fas fa-calendar-day"></i></span>
                  <p class="is-size-7 heading mb-0">Registrazione</p>
                  <p class="is-size-6 has-text-weight-bold">{$autore_contenuto.data_registrazione|date_format:"%d/%m/%y"}</p>
                </div>
              </div>
              <div class="column is-3-tablet is-6-mobile">
                <div class="notification is-light has-text-centered py-2 px-1 mb-0">
                  <span class="icon has-text-info mb-1"><i class="fas fa-user-shield"></i></span>
                  <p class="is-size-7 heading mb-0">Stato Account</p>
                  <p class="is-size-6 has-text-weight-bold">{$autore_contenuto.stato}</p>
                </div>
              </div>
              <div class="column is-3-tablet is-6-mobile">
                <div class="notification is-danger-light has-text-centered py-2 px-1 mb-0">
                  <span class="icon has-text-danger mb-1"><i class="fas fa-exclamation-circle"></i></span>
                  <p class="is-size-7 heading mb-0">Segnalazioni Rec.</p>
                  <p class="is-size-6 has-text-weight-bold has-text-danger">{$autore_contenuto.segnalazioni_ricevute}</p>
                </div>
              </div>
              <div class="column is-3-tablet is-6-mobile">
                <div class="notification is-light has-text-centered py-2 px-1 mb-0">
                  <span class="icon has-text-link mb-1"><i class="fas fa-comments"></i></span>
                  <p class="is-size-7 heading mb-0">Comm. Pubblicati</p>
                  <p class="is-size-6 has-text-weight-bold">{$autore_contenuto.commenti_pubblicati}</p>
                </div>
              </div>
            </div>

            <!-- Storico Segnalazioni dell'utente -->
            <h4 class="title is-6 mb-2">Storico Segnalazioni dell'utente</h4>
            <div class="table-container">
              <table class="table is-fullwidth is-striped is-hoverable is-narrow is-size-7">
                <thead>
                  <tr>
                    <th>Data</th>
                    <th>Tipo</th>
                    <th>Motivo</th>
                    <th>Stato Finale</th>
                  </tr>
                </thead>
                <tbody>
                  {foreach from=$storico_segnalazioni_utente item=past_ticket}
                    <tr>
                      <td>{$past_ticket.data|date_format:"%d/%m/%Y"}</td>
                      <td><span class="tag is-small is-light">{$past_ticket.tipo}</span></td>
                      <td>{$past_ticket.motivo}</td>
                      <td>
                        {if $past_ticket.stato_azione == 'Bannato'}
                          <span class="has-text-danger"><i class="fas fa-gavel"></i> Bannato</span>
                        {elseif $past_ticket.stato_azione == 'Contenuto Rimosso'}
                          <span class="has-text-warning"><i class="fas fa-trash-alt"></i> Contenuto Rimosso</span>
                        {else}
                          <span class="has-text-success"><i class="fas fa-check-circle"></i> Archiviata</span>
                        {/if}
                      </td>
                    </tr>
                  {foreachelse}
                    <tr>
                      <td colspan="4" class="has-text-centered has-text-grey py-3">L'utente non ha precedenti penali sulla piattaforma.</td>
                    </tr>
                  {/foreach}
                </tbody>
              </table>
            </div>

          </div>
        </div>

        <!-- COLONNA DESTRA is-4: Azioni di Moderazione -->
        <div class="column is-4-desktop">
          
          <!-- Riquadro Azioni Sanzioni -->
          <div class="box mb-4">
            <h3 class="title is-5 mb-4 has-text-grey-dark">
              <span class="icon mr-2"><i class="fas fa-shield-alt"></i></span>Azioni di Moderazione
            </h3>

            <!-- Opzione 1: Nessuna azione -->
            <label class="radio box is-flex is-align-items-center py-2 px-3 mb-3 is-clickable has-background-light is-shadowless">
              <input type="radio" name="azione_moderazione" value="nessuna" checked>
              <span class="icon has-text-grey ml-2 mr-1"><i class="fas fa-check-circle"></i></span>
              <span class="is-size-6 has-text-weight-medium">Non applicare azione</span>
            </label>

            <!-- Opzione 2: Banna Utente -->
            <div class="box py-2 px-3 mb-3 is-shadowless" style="border: 1px solid #dbdbdb;">
              <label class="radio is-flex is-align-items-center mb-2 is-clickable">
                <input type="radio" name="azione_moderazione" value="ban">
                <span class="icon has-text-danger ml-2 mr-1"><i class="fas fa-ban"></i></span>
                <span class="is-size-6 has-text-weight-medium">Banna utente</span>
              </label>

              <!-- Parametri del Ban (Menù a tendina richiesti) -->
              <div class="field is-horizontal mt-2">
                <div class="field-body">
                  <div class="field">
                    <div class="control is-expanded">
                      <div class="select is-small is-fullwidth">
                        <select name="tipo_ban">
                          <option value="temporaneo">Ban Temporaneo</option>
                          <option value="permanente">Ban Permanente</option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="field">
                    <div class="control is-expanded">
                      <div class="select is-small is-fullwidth">
                        <select name="durata_ban">
                          <option value="1">1 Giorno</option>
                          <option value="7">7 Giorni</option>
                          <option value="30">30 Giorni</option>
                          <option value="0">Permanente</option>
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Opzione 3: Rimuovi contenuto e avvisa -->
            <label class="checkbox box is-flex is-align-items-center py-2 px-3 mb-4 is-clickable has-background-light is-shadowless">
              <!-- Questo è un checkbox separato perché l'admin potrebbe voler rimuovere il contenuto SIA se non banna, SIA in combinazione con il ban! -->
              <input type="checkbox" name="rimuovi_e_avvisa" value="1" checked>
              <span class="icon has-text-warning ml-2 mr-1"><i class="fas fa-trash-alt"></i></span>
              <span class="is-size-6 has-text-weight-medium">Rimuovi contenuto e avvisa</span>
            </label>

            <!-- Nota di spiegazione per il Ban / Azione -->
            <div class="field">
              <label class="label is-size-7">Nota di motivazione (inviata all'utente via email)</label>
              <div class="control">
                <textarea class="textarea is-small" name="nota_moderazione" rows="3" placeholder="Specifica la regola violata (es. 'Linguaggio scurrile non tollerato')..."></textarea>
              </div>
            </div>
          </div>

          <!-- Pulsanti di Conferma / Annulla (Subito sotto il riquadro sanzioni) -->
          <div class="columns is-mobile">
            <div class="column is-6">
              <a href="admin_dashboard.php" class="button is-light is-fullwidth">Annulla</a>
            </div>
            <div class="column is-6">
              <button type="submit" class="button is-success is-fullwidth has-text-weight-bold">Conferma azione</button>
            </div>
          </div>

        </div> <!-- Fine colonna is-4 delle azioni -->
        
      </div>

    </div>
  </section>
</form>