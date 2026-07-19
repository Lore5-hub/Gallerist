{extends file='layout.tpl'}
{block name=content}
<section class="section admin-bannati">
  <div class="container is-fluid">

    <div class="is-flex is-justify-content-space-between is-align-items-center mb-6">
      <div>
        <h1 class="title is-3 mb-1">Utenti Bannati</h1>
        <p class="subtitle is-6 has-text-grey">Elenco dei provvedimenti disciplinari attivi</p>
      </div>
      <a href="/Admin/dashboard" class="button is-light">
        <span class="icon"><i class="fas fa-arrow-left"></i></span>
        <span>Torna alla Dashboard</span>
      </a>
    </div>

    <div class="box">
      <table class="table is-fullwidth is-striped is-hoverable is-vcentered">
        <thead>
          <tr>
            <th>Utente</th>
            <th>Email</th>
            <th>Tipo Ban</th>
            <th>Inizio</th>
            <th>Fine</th>
            <th>Motivo</th>
          </tr>
        </thead>
        <tbody>
          {foreach from=$provvedimenti item=prov}
            <tr>
              <td><strong>@{$prov.nickname}</strong></td>
              <td>{$prov.email}</td>
              <td>
                {if $prov.tipoBan == 'permanente'}
                  <span class="tag is-danger">Permanente</span>
                {else}
                  <span class="tag is-warning">Temporaneo</span>
                {/if}
              </td>
              <td>{$prov.dataInizio|date_format:"%d/%m/%Y"}</td>
              <td>
                {if $prov.dataFine}
                  {$prov.dataFine|date_format:"%d/%m/%Y"}
                {else}
                  <em>Permanente</em>
                {/if}
              </td>
              <td>{$prov.motivo}</td>
            </tr>
          {foreachelse}
            <tr>
              <td colspan="6" class="has-text-centered has-text-grey py-4">
                Nessun utente bannato al momento.
              </td>
            </tr>
          {/foreach}
        </tbody>
      </table>
    </div>

  </div>
</section>
{/block}