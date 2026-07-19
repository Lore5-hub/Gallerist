{extends file='layout.tpl'}
{block name=content}
<section class="section admin-categorie">
  <div class="container is-fluid">

    <div class="is-flex is-justify-content-space-between is-align-items-center mb-6">
      <div>
        <h1 class="title is-3 mb-1">Gestione Categorie</h1>
        <p class="subtitle is-6 has-text-grey">Aggiungi, modifica o rimuovi le categorie del catalogo</p>
      </div>
      <a href="/Admin/dashboard" class="button is-light">
        <span class="icon"><i class="fas fa-arrow-left"></i></span>
        <span>Torna alla Dashboard</span>
      </a>
    </div>

    <div class="columns">

      {* Colonna sinistra: lista categorie *}
      <div class="column is-8">
        <div class="box">
          <h2 class="title is-5 mb-4">Categorie esistenti</h2>
          <table class="table is-fullwidth is-striped is-hoverable is-vcentered">
            <thead>
              <tr>
                <th>Nome</th>
                <th>Descrizione</th>
                <th>Opere</th>
                <th class="has-text-right">Azioni</th>
              </tr>
            </thead>
            <tbody>
              {foreach from=$categorie item=categoria}
                <tr>
                  <td><strong>{$categoria.nome}</strong></td>
                  <td class="has-text-grey">{$categoria.descrizione|default:'—'}</td>
                  <td>{$categoria.num_opere}</td>
                  <td class="has-text-right">
                    <form method="POST" action="/Admin/eliminaCategoria" 
                          onsubmit="return confirm('Sei sicuro di voler eliminare questa categoria?');"
                          style="display:inline;">
                      <input type="hidden" name="nome" value="{$categoria.nome}">
                      <button type="submit" class="button is-small is-danger is-outlined"
                              {if $categoria.num_opere > 0}disabled title="Impossibile eliminare: ha opere associate"{/if}>
                        <span class="icon"><i class="fas fa-trash"></i></span>
                      </button>
                    </form>
                  </td>
                </tr>
              {foreachelse}
                <tr>
                  <td colspan="4" class="has-text-centered has-text-grey py-4">
                    Nessuna categoria presente.
                  </td>
                </tr>
              {/foreach}
            </tbody>
          </table>
        </div>
      </div>

      {* Colonna destra: form aggiungi *}
      <div class="column is-4">
        <div class="box">
          <h2 class="title is-5 mb-4">
            <span class="icon has-text-success mr-1"><i class="fas fa-plus-circle"></i></span>
            Aggiungi Categoria
          </h2>
          <form method="POST" action="/Admin/gestisciCategorie">
            <div class="field">
              <label class="label">Nome <span class="has-text-danger">*</span></label>
              <div class="control">
                <input class="input" type="text" name="nome" 
                       placeholder="Es. Arte Digitale" required>
              </div>
            </div>
            <div class="field">
              <label class="label">Descrizione</label>
              <div class="control">
                <textarea class="textarea" name="descrizione" rows="3"
                          placeholder="Descrizione della categoria..."></textarea>
              </div>
            </div>
            <div class="field mt-4">
              <button type="submit" class="button is-success is-fullwidth">
                <span class="icon"><i class="fas fa-check"></i></span>
                <span>Aggiungi Categoria</span>
              </button>
            </div>
          </form>
        </div>
      </div>

    </div>
  </div>
</section>
{/block}