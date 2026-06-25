{extends file='layout.tpl'}
{block name=content}
<section class="section has-background-white-bis">
  <div class="container">

    <div class="is-flex is-justify-content-space-between is-align-items-center mb-6">
      <h1 class="title is-3 mb-0">Storico Vendite e Guadagni</h1>
      
      <form method="GET" action="storico_vendite.php">
        <div class="field mb-0">
          <div class="control has-icons-left">
            <div class="select is-info">
              <select name="periodo" onchange="this.form.submit()">
                <option value="30">Ultimi 30 giorni</option>
                <option value="90">Ultimi 3 mesi</option>
                <option value="180">Ultimi 6 mesi</option>
                <option value="365">Ultimo anno</option>
                <option value="all" selected>Sempre</option>
              </select>
            </div>
            <span class="icon is-small is-left has-text-info">
              <i class="fas fa-calendar-alt"></i>
            </span>
          </div>
        </div>
      </form>
    </div>

    <!-- Statistiche Rapide -->
    <div class="columns is-multiline is-mobile mb-6">
      <div class="column is-one-fifth-desktop is-half-tablet">
        <div class="box has-text-centered p-4 stat-box">
          <span class="icon is-medium has-text-success mb-2"><i class="fas fa-money-bill-wave fa-lg"></i></span>
          <p class="heading">Entrate Totali</p>
          <p class="title is-4">€ {$statistiche.entrate_lorde|number_format:2:',':'.'}</p>
        </div>
      </div>

      <div class="column is-one-fifth-desktop is-half-tablet">
        <div class="box has-text-centered p-4 stat-box">
          <span class="icon is-medium has-text-info mb-2"><i class="fas fa-shopping-cart fa-lg"></i></span>
          <p class="heading">Vendite Totali</p>
          <p class="title is-4">{$statistiche.numero_vendite}</p>
        </div>
      </div>

      <div class="column is-one-fifth-desktop is-half-tablet">
        <div class="box has-text-centered p-4 stat-box">
          <span class="icon is-medium has-text-warning mb-2"><i class="fas fa-star fa-lg"></i></span>
          <p class="heading">Valutazione Media</p>
          <p class="title is-4">{$statistiche.voto_medio|number_format:1:',':'.'}</p>
        </div>
      </div>

      <div class="column is-one-fifth-desktop is-half-tablet">
        <div class="box has-text-centered p-4 stat-box">
          <span class="icon is-medium has-text-primary mb-2"><i class="fas fa-wallet fa-lg"></i></span>
          <p class="heading">Ricavo Netto</p>
          <p class="title is-4">€ {$statistiche.ricavo_netto|number_format:2:',':'.'}</p>
        </div>
      </div>

      <div class="column is-one-fifth-desktop is-half-tablet">
        <div class="box has-text-centered p-4 has-background-danger-light stat-box">
          <span class="icon is-medium has-text-danger mb-2"><i class="fas fa-percent fa-lg"></i></span>
          <p class="heading">Commissioni</p>
          <p class="title is-4 has-text-danger">- € {$statistiche.commissioni|number_format:2:',':'.'}</p>
          <p class="is-size-7 has-text-grey">(15% trattenuto)</p>
        </div>
      </div>
    </div>

    <!-- Grafici -->
    <div class="columns is-multiline mb-5">
      <div class="column is-8-desktop">
        <div class="box dashboard-card">
          <h2 class="title is-5 mb-4">Andamento Entrate</h2>
          <div class="chart-container"><canvas id="graficoAndamento"></canvas></div>
        </div>
      </div>
      <div class="column is-4-desktop">
        <div class="box dashboard-card">
          <h2 class="title is-5 mb-4">Entrate per Categoria</h2>
          <div class="chart-container"><canvas id="graficoTorta"></canvas></div>
        </div>
      </div>
    </div>

    <!-- Tabella Dettaglio -->
    <div class="columns is-multiline">
      <div class="column is-8-desktop">
        <div class="box dashboard-card">
          <h2 class="title is-5 mb-4">Dettaglio Vendite</h2>
          <div class="table-container">
            <table class="table is-fullwidth is-striped is-hoverable">
              <thead>
                <tr>
                  <th>Data</th>
                  <th>Opera</th>
                  <th>Tecnica</th>
                  <th class="has-text-right">Prezzo</th>
                  <th class="has-text-right">Commissioni</th>
                  <th class="has-text-right">Netto</th>
                </tr>
              </thead>
              <tbody>
                {foreach from=$storico_vendite item=vendita}
                  <tr>
                    <td>{$vendita.data|date_format:"%d/%m/%Y"}</td>
                    <td><strong>{$vendita.titolo_opera}</strong></td>
                    <td>{$vendita.categoria}</td>
                    <td class="has-text-right">€ {$vendita.prezzo|number_format:2:',':'.'}</td>
                    <td class="has-text-right has-text-danger">- € {$vendita.commissione|number_format:2:',':'.'}</td>
                    <td class="has-text-right has-text-success has-text-weight-bold">€ {$vendita.netto|number_format:2:',':'.'}</td>
                  </tr>
                {foreachelse}
                  <tr><td colspan="6" class="has-text-centered has-text-grey">Nessuna vendita registrata.</td></tr>
                {/foreach}
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <div class="column is-4-desktop">
        <div class="box dashboard-card">
          <h2 class="title is-5 mb-4">Modalità di Vendita</h2>
          <div class="chart-container"><canvas id="graficoBarre"></canvas></div>
        </div>
      </div>
    </div>

  </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
{/block}