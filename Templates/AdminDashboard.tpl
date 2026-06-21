<section class="section has-background-white-bis">
  <div class="container is-fluid">

    <div class="is-flex is-justify-content-space-between is-align-items-center mb-6">
      <div>
        <h1 class="title is-3 mb-1">Gestione Piattaforma</h1>
        <p class="subtitle is-6 has-text-grey">Dashboard operativa e controllo attività</p>
      </div>
      
      <a href="admin_statistiche.php" class="button is-info is-medium">
        <span class="icon"><i class="fas fa-chart-bar"></i></span>
        <span>Visualizza Statistiche</span>
      </a>
    </div>

    <div class="columns is-multiline is-mobile mb-6">
      
      <div class="column is-one-fifth-desktop is-half-tablet">
        <div class="box has-text-centered p-4" style="height: 100%;">
          <span class="icon is-medium has-text-link mb-2"><i class="fas fa-users fa-lg"></i></span>
          <p class="heading">Utenti Totali</p>
          <p class="title is-4 mb-2">{$dashboard.utenti_totali}</p>
          <p class="is-size-7 has-text-success">
            <i class="fas fa-arrow-up"></i> {$dashboard.utenti_perc}% vs prec.
          </p>
        </div>
      </div>

      <div class="column is-one-fifth-desktop is-half-tablet">
        <div class="box has-text-centered p-4 has-background-warning-light" style="height: 100%;">
          <span class="icon is-medium has-text-warning-dark mb-2"><i class="fas fa-user-clock fa-lg"></i></span>
          <p class="heading">In Attesa Verifica</p>
          <p class="title is-4 mb-2 has-text-warning-dark">{$dashboard.utenti_attesa}</p>
          <p class="is-size-7 has-text-grey">Azione richiesta</p>
        </div>
      </div>

      <div class="column is-one-fifth-desktop is-half-tablet">
        <div class="box has-text-centered p-4" style="height: 100%;">
          <span class="icon is-medium has-text-primary mb-2"><i class="fas fa-paint-brush fa-lg"></i></span>
          <p class="heading">Artisti Attivi</p>
          <p class="title is-4 mb-2">{$dashboard.artisti_attivi}</p>
          <p class="is-size-7 has-text-success">
            <i class="fas fa-arrow-up"></i> {$dashboard.artisti_perc}% vs prec.
          </p>
        </div>
      </div>

      <div class="column is-one-fifth-desktop is-half-tablet">
        <div class="box has-text-centered p-4" style="height: 100%;">
          <span class="icon is-medium has-text-danger mb-2"><i class="fas fa-flag fa-lg"></i></span>
          <p class="heading">Segnalazioni</p>
          <p class="title is-4 mb-2">{$dashboard.segnalazioni_aperte}</p>
          <p class="is-size-7 has-text-danger">
            <i class="fas fa-arrow-up"></i> {$dashboard.segnalazioni_perc}% vs prec.
          </p>
        </div>
      </div>

      <div class="column is-one-fifth-desktop is-half-tablet">
        <div class="box has-text-centered p-4" style="height: 100%;">
          <span class="icon is-medium has-text-danger mb-2"><i class="fas fa-comments fa-lg"></i></span>
          <p class="heading">Commenti Segnalati</p>
          <p class="title is-4 mb-2">{$dashboard.commenti_segnalati}</p>
          <p class="is-size-7 has-text-success">
            <i class="fas fa-arrow-down"></i> {$dashboard.commenti_perc}% vs prec.
          </p>
        </div>
      </div>

    </div>

    <div class="columns is-multiline mb-5">
      
      <div class="column is-8-desktop">
        <div class="box" style="height: 100%;">
          
          <div class="is-flex is-justify-content-space-between is-align-items-center mb-4">
            <h2 class="title is-5 mb-0"><i class="fas fa-user-clock has-text-warning mr-2"></i> Utenti in attesa di verifica</h2>
            <a href="admin_verifica_utenti.php" class="button is-small is-link is-outlined">Vedi tutti</a>
          </div>

          <div class="table-container">
            <table class="table is-fullwidth is-striped is-hoverable is-vcentered">
              <thead>
                <tr>
                  <th>Nickname</th>
                  <th>Data Registrazione</th>
                  <th>Stato</th>
                  <th class="has-text-right">Azione</th>
                </tr>
              </thead>
              <tbody>
                {foreach from=$utenti_in_attesa item=utente}
                  <tr>
                    <td><strong>@{$utente.nickname}</strong></td>
                    <td>{$utente.data_registrazione|date_format:"%d/%m/%Y"}</td>
                    <td><span class="tag is-warning is-light">In attesa</span></td>
                    <td class="has-text-right">
                      <a href="verifica_utente.php?id={$utente.id}" class="button is-small is-success">
                        <span class="icon"><i class="fas fa-check"></i></span>
                        <span>Verifica</span>
                      </a>
                    </td>
                  </tr>
                {foreachelse}
                  <tr>
                    <td colspan="4" class="has-text-centered has-text-grey py-4">Nessun utente in attesa di verifica.</td>
                  </tr>
                {/foreach}
              </tbody>
            </table>
          </div>
          
        </div>
      </div>

      <div class="column is-4-desktop">
        <div class="box" style="height: 100%;">
          
          <div class="is-flex is-justify-content-space-between is-align-items-center mb-4">
            <h2 class="title is-5 mb-0"><i class="fas fa-tags has-text-info mr-2"></i> Categorie Artisti</h2>
            <button class="button is-small is-success" title="Aggiungi Categoria">
              <span class="icon"><i class="fas fa-plus"></i></span>
            </button>
          </div>

          <div class="table-container mb-4">
            <table class="table is-fullwidth is-hoverable is-vcentered is-narrow">
              <thead>
                <tr>
                  <th>Categoria</th>
                  <th>Opere</th>
                  <th class="has-text-right">Azioni</th>
                </tr>
              </thead>
              <tbody>
                {foreach from=$categorie item=categoria}
                  <tr>
                    <td><strong>{$categoria.nome}</strong></td>
                    <td>{$categoria.num_opere}</td>
                    <td class="has-text-right">
                      <a href="#" class="button is-small is-ghost has-text-info px-1" title="Modifica">
                        <i class="fas fa-pencil-alt"></i>
                      </a>
                      <a href="#" class="button is-small is-ghost has-text-danger px-1" title="Rimuovi">
                        <i class="fas fa-trash"></i>
                      </a>
                    </td>
                  </tr>
                {/foreach}
              </tbody>
            </table>
          </div>
          
          <a href="admin_categorie.php" class="button is-small is-fullwidth is-info is-outlined">Gestisci tutte</a>

        </div>
      </div>

    </div>

    <div class="columns is-multiline">
      
      <div class="column is-8-desktop">
        <div class="box" style="height: 100%;">
          
          <div class="is-flex is-justify-content-space-between is-align-items-center mb-4">
            <h2 class="title is-5 mb-0"><i class="fas fa-flag has-text-danger mr-2"></i> Segnalazioni Recenti</h2>
            <a href="admin_segnalazioni.php" class="button is-small is-link is-outlined">Vedi tutte</a>
          </div>

          <div class="table-container">
            <table class="table is-fullwidth is-striped is-hoverable is-vcentered is-size-7">
              <thead>
                <tr>
                  <th>Tipo / Oggetto</th>
                  <th>Contenuto Segnalato</th>
                  <th>Segnalato da</th>
                  <th>Data</th>
                  <th>Stato</th>
                  <th class="has-text-right">Dettagli</th>
                </tr>
              </thead>
              <tbody>
                {foreach from=$segnalazioni item=segnalazione}
                  <tr>
                    <td><strong>{$segnalazione.tipo}</strong></td>
                    <td><span class="is-truncated" style="max-width: 150px; display: inline-block; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{$segnalazione.contenuto}</span></td>
                    <td>@{$segnalazione.autore_segnalazione}</td>
                    <td>{$segnalazione.data|date_format:"%d/%m/%Y"}</td>
                    <td>
                      {if $segnalazione.stato == 'Aperta'}
                        <span class="tag is-danger is-light is-small">Aperta</span>
                      {else}
                        <span class="tag is-success is-light is-small">Chiusa</span>
                      {/if}
                    </td>
                    <td class="has-text-right">
                      <a href="adminSegnalazioni.php?id={$segnalazione.id}" class="button is-small is-link is-light" title="Vedi Dettaglio">
                        <span class="icon"><i class="fas fa-eye"></i></span>
                      </a>
                    </td>
                  </tr>
                {foreachelse}
                  <tr>
                    <td colspan="6" class="has-text-centered has-text-grey py-4">Nessuna segnalazione recente.</td>
                  </tr>
                {/foreach}
              </tbody>
            </table>
          </div>
          
        </div>
      </div>

      <div class="column is-4-desktop">
        <div class="box" style="height: 100%;">
          
          <div class="is-flex is-justify-content-space-between is-align-items-center mb-4">
            <h2 class="title is-5 mb-0"><i class="fas fa-ban has-text-danger mr-2"></i> Utenti Bannati</h2>
            <a href="admin_bannati.php" class="button is-small is-link is-outlined">Vedi tutti</a>
          </div>

          <div class="table-container">
            <table class="table is-fullwidth is-striped is-hoverable is-narrow is-size-7">
              <thead>
                <tr>
                  <th>Utente</th>
                  <th>Motivo</th>
                  <th>Tipo</th>
                  <th>Inizio</th>
                  <th>Fine</th>
                </tr>
              </thead>
              <tbody>
                {foreach from=$bannati item=ban}
                  <tr>
                    <td><strong>@{$ban.utente}</strong></td>
                    <td title="{$ban.motivo}"><span class="is-truncated" style="max-width: 80px; display: inline-block; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{$ban.motivo}</span></td>
                    <td>{$ban.tipo}</td>
                    <td>{$ban.inizio|date_format:"%d/%m"}</td>
                    <td>{if $ban.fine}{$ban.fine|date_format:"%d/%m"}{else}<em>Perm.</em>{/if}</td>
                  </tr>
                {foreachelse}
                  <tr>
                    <td colspan="5" class="has-text-centered has-text-grey py-4">Nessun utente attualmente bannato.</td>
                  </tr>
                {/foreach}
              </tbody>
            </table>
          </div>
          
        </div>
      </div>

    </div>

  </div>
</section>