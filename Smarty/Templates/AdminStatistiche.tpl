{extends file='layout.tpl'}
{block name=content}
<section class="section admin-stats">
  <div class="container is-fluid"> <div class="is-flex is-justify-content-space-between is-align-items-center mb-6">
      
      <div>
        <h1 class="title is-3 mb-1 has-text-black">Interazioni con il sito</h1>
        <p class="subtitle is-6 has-text-grey">Panoramica generale delle performance della piattaforma</p>
      </div>
      
      <!-- DOPO (corretto — select dentro un form) -->
<form method="GET" action="/Gallerist/Admin/statistiche">
  <div class="field mb-0">
    <div class="control has-icons-left">
      <div class="select is-info">
        <select name="periodo" onchange="this.form.submit()">
          <option value="7"   {if $giorni == 7}selected{/if}>Ultimi 7 giorni</option>
          <option value="30"  {if $giorni == 30}selected{/if}>Ultimi 30 giorni</option>
          <option value="90"  {if $giorni == 90}selected{/if}>Ultimi 3 mesi</option>
          <option value="365" {if $giorni == 365}selected{/if}>Ultimo anno</option>
        </select>
      </div>
      <span class="icon is-small is-left has-text-info">
        <i class="fas fa-calendar-alt"></i>
      </span>
    </div>
  </div>
</form>

    </div>

    <div class="columns is-multiline is-mobile mb-5">
      
      <div class="column is-2-desktop is-half-tablet">
        <div class="box has-text-centered p-3 h-full">
          <span class="icon is-medium has-text-info mb-1"><i class="fas fa-users fa-lg"></i></span>
          <p class="heading mb-1">Visite Totali</p>
          <p class="title is-4 mb-2">{$stats.visite_totali}</p>
          <p class="is-size-7 has-text-success">
            <i class="fas fa-arrow-up"></i> {$stats.visite_perc}% <span class="has-text-grey">vs prec.</span>
          </p>
        </div>
      </div>

      <div class="column is-2-desktop is-half-tablet">
        <div class="box has-text-centered p-3 h-full">
          <span class="icon is-medium has-text-primary mb-1"><i class="fas fa-user-plus fa-lg"></i></span>
          <p class="heading mb-1">Registrazioni</p>
          <p class="title is-4 mb-2">{$stats.registrazioni}</p>
          <p class="is-size-7 has-text-success">
            <i class="fas fa-arrow-up"></i> {$stats.reg_perc}% <span class="has-text-grey">vs prec.</span>
          </p>
        </div>
      </div>

      <div class="column is-2-desktop is-half-tablet">
        <div class="box has-text-centered p-3 h-full">
          <span class="icon is-medium has-text-link mb-1"><i class="fas fa-eye fa-lg"></i></span>
          <p class="heading mb-1">Vis. Pagina</p>
          <p class="title is-4 mb-2">{$stats.vis_pagina}</p>
          <p class="is-size-7 has-text-danger">
            <i class="fas fa-arrow-down"></i> {$stats.vis_pag_perc}% <span class="has-text-grey">vs prec.</span>
          </p>
        </div>
      </div>

      <div class="column is-2-desktop is-half-tablet">
        <div class="box has-text-centered p-3 h-full">
          <span class="icon is-medium has-text-warning mb-1"><i class="fas fa-clock fa-lg"></i></span>
          <p class="heading mb-1">Tempo Medio</p>
          <p class="title is-4 mb-2">{$stats.tempo_medio}</p>
          <p class="is-size-7 has-text-success">
            <i class="fas fa-arrow-up"></i> {$stats.tempo_perc}% <span class="has-text-grey">vs prec.</span>
          </p>
        </div>
      </div>

      <div class="column is-2-desktop is-half-tablet">
        <div class="box has-text-centered p-3 h-full">
          <span class="icon is-medium has-text-danger mb-1"><i class="fas fa-exchange-alt fa-lg"></i></span>
          <p class="heading mb-1">Movimenti Totali</p>
          <p class="title is-4 mb-2">{$stats.movimenti}</p>
          <p class="is-size-7 has-text-success">
            <i class="fas fa-arrow-up"></i> {$stats.mov_perc}% <span class="has-text-grey">vs prec.</span>
          </p>
        </div>
      </div>

      <div class="column is-2-desktop is-half-tablet">
        <div class="box has-text-centered p-3 has-background-success-light h-full">
          <span class="icon is-medium has-text-success mb-1"><i class="fas fa-coins fa-lg"></i></span>
          <p class="heading mb-1">Guadagni Piattaforma</p>
          <p class="title is-4 mb-2">€ {$stats.guadagni|number_format:2:',':'.'}</p>
          <p class="is-size-7 has-text-success">
            <i class="fas fa-arrow-up"></i> {$stats.guad_perc}% <span class="has-text-grey">vs prec.</span>
          </p>
        </div>
      </div>

    </div>

    <div class="columns is-multiline mb-5">
      
      <div class="column is-6-desktop">
        <div class="box has-text-centered p-3 h-full">
          <h2 class="title is-5 mb-4"><i class="fas fa-chart-line has-text-info mr-2"></i> Andamento Visite</h2>
          <div class="admin-stats-chart-wrapper admin-stats-chart-sm">
            <canvas id="chartVisite"></canvas>
          </div>
        </div>
      </div>

      <div class="column is-6-desktop">
        <div class="box has-text-centered p-3 h-full">
          <h2 class="title is-5 mb-4"><i class="fas fa-chart-area has-text-link mr-2"></i> Visualizzazioni di Pagina</h2>
          <div class="admin-stats-chart-wrapper admin-stats-chart-sm">
            <canvas id="chartPagine"></canvas>
          </div>
        </div>
      </div>

    </div>

    <div class="columns is-multiline">
      
      <div class="column is-6-desktop">
        <div class="box has-text-centered p-3 h-full">
          <h2 class="title is-5 mb-4"><i class="fas fa-euro-sign has-text-success mr-2"></i> Andamento Guadagni</h2>
          <div class="admin-stats-chart-wrapper admin-stats-chart-lg">
            <canvas id="chartGuadagni"></canvas>
          </div>
        </div>
      </div>

      <div class="column is-6-desktop">
        
        <div class="box mb-4">
          <div class="is-flex is-justify-content-space-between is-align-items-center mb-4">
            <h2 class="title is-5 mb-0">Pagine più visitate</h2>
            <a href="admin_pagine.php" class="button is-small is-link is-outlined">Vedi tutte</a>
          </div>
          
          <table class="table is-fullwidth is-narrow is-hoverable mb-0">
            <tbody>
              {foreach from=$top_pagine item=pagina}
                <tr>
                  <td><a href="{$pagina.url}" target="_blank">{$pagina.nome}</a></td>
                  <td class="has-text-right"><strong>{$pagina.visualizzazioni}</strong> vis.</td>
                </tr>
              {/foreach}
            </tbody>
          </table>
        </div>

        <div class="box">
          <div class="is-flex is-justify-content-space-between is-align-items-center mb-4">
            <h2 class="title is-5 mb-0">Azioni principali</h2>
            <a href="admin_log_azioni.php" class="button is-small is-info is-outlined">Vedi tutte le azioni</a>
          </div>

          <div class="content">
            <div class="level is-mobile mb-2">
              <div class="level-left">
                <span class="icon has-text-primary mr-2"><i class="fas fa-user-check"></i></span> Nuove Registrazioni
              </div>
              <div class="level-right has-text-right">
                <strong>{$stats.azioni_reg}</strong> 
                <span class="is-size-7 has-text-success ml-2"><i class="fas fa-arrow-up"></i> 8%</span>
              </div>
            </div>
            
            <div class="level is-mobile mb-2">
              <div class="level-left">
                <span class="icon has-text-info mr-2"><i class="fas fa-palette"></i></span> Opere Pubblicate
              </div>
              <div class="level-right has-text-right">
                <strong>{$stats.azioni_opere}</strong>
                <span class="is-size-7 has-text-success ml-2"><i class="fas fa-arrow-up"></i> 12%</span>
              </div>
            </div>

            <div class="level is-mobile mb-0">
              <div class="level-left">
                <span class="icon has-text-warning mr-2"><i class="fas fa-comments"></i></span> Commenti e Recensioni
              </div>
              <div class="level-right has-text-right">
                <strong>{$stats.azioni_commenti}</strong>
                <span class="is-size-7 has-text-danger ml-2"><i class="fas fa-arrow-down"></i> 3%</span>
              </div>
            </div>
          </div>

        </div>

      </div> </div>

  </div>
</section>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  const labels   = {$label_grafici};
  const visite   = {$dati_visite};
  const pagine   = {$dati_pagine};
  const guadagni = {$dati_guadagni};

  new Chart(document.getElementById('chartVisite'),   { type: 'line', data: { labels, datasets: [{ label: 'Visite', data: visite,   borderColor: '#3273dc', tension: 0.3 }] } });
  new Chart(document.getElementById('chartPagine'),   { type: 'line', data: { labels, datasets: [{ label: 'Pagine', data: pagine,   borderColor: '#3298dc', tension: 0.3 }] } });
  new Chart(document.getElementById('chartGuadagni'), { type: 'bar',  data: { labels, datasets: [{ label: '€',      data: guadagni, backgroundColor: '#48c774' }] } });
</script>
{/block}