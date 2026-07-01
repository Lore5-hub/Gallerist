{extends file='layout.tpl'}
{block name=content}
<section class="section admin-segnalazioni">
  <div class="container is-fluid">

    <div class="is-flex is-justify-content-space-between is-align-items-center mb-6">
      <div>
        <h1 class="title is-3 mb-1">Tutte le Segnalazioni</h1>
        <p class="subtitle is-6 has-text-grey">Elenco completo delle segnalazioni ricevute</p>
      </div>
      <a href="/Gallerist/Admin/dashboard" class="button is-light">
        <span class="icon"><i class="fas fa-arrow-left"></i></span>
        <span>Torna alla Dashboard</span>
      </a>
    </div>

    <div class="box">
      <table class="table is-fullwidth is-striped is-hoverable is-vcentered is-size-7">
        <thead>
          <tr>
            <th>Tipo</th>
            <th>Motivo</th>
            <th>Segnalato da</th>
            <th>Data</th>
            <th>Stato</th>
            <th class="has-text-right">Dettaglio</th>
          </tr>
        </thead>
        <tbody>
          {foreach from=$segnalazioni item=segnalazione}
            <tr>
              <td><span class="tag is-dark">{$segnalazione.tipo}</span></td>
              <td>{$segnalazione.motivo}</td>
              <td>#{$segnalazione.autore}</td>
              <td>{$segnalazione.data|date_format:"%d/%m/%Y"}</td>
              <td>
                {if $segnalazione.stato == 'Aperta'}
                  <span class="tag is-danger is-light">Aperta</span>
                {elseif $segnalazione.stato == 'Archiviata'}
                  <span class="tag is-warning is-light">Archiviata</span>
                {else}
                  <span class="tag is-success is-light">Risolta</span>
                {/if}
              </td>
              <td class="has-text-right">
                <a href="/Gallerist/Admin/mostraSegnalazione?id={$segnalazione.id}" 
                   class="button is-small is-link is-light" title="Vedi Dettaglio">
                  <span class="icon"><i class="fas fa-eye"></i></span>
                </a>
              </td>
            </tr>
          {foreachelse}
            <tr>
              <td colspan="6" class="has-text-centered has-text-grey py-4">
                Nessuna segnalazione presente.
              </td>
            </tr>
          {/foreach}
        </tbody>
      </table>
    </div>

  </div>
</section>
{/block}