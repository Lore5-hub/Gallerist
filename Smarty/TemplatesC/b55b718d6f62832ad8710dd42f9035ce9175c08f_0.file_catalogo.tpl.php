<?php
/* Smarty version 5.8.0, created on 2026-06-25 17:58:56
  from 'file:catalogo.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.8.0',
  'unifunc' => 'content_6a3d5040795ff6_59280683',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'b55b718d6f62832ad8710dd42f9035ce9175c08f' => 
    array (
      0 => 'catalogo.tpl',
      1 => 1782403130,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_6a3d5040795ff6_59280683 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\Users\\ranch\\Downloads\\xampp\\htdocs\\Gallerist\\Smarty\\Templates';
$_smarty_tpl->getInheritance()->init($_smarty_tpl, true);
?>

<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_16881165606a3d5040784434_82776271', 'content');
$_smarty_tpl->getInheritance()->endChild($_smarty_tpl, 'layout.tpl', $_smarty_current_dir);
}
/* {block 'content'} */
class Block_16881165606a3d5040784434_82776271 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\Users\\ranch\\Downloads\\xampp\\htdocs\\Gallerist\\Smarty\\Templates';
?>

<div class="columns is-variable is-5 mt-4 page-catalog">
  
  <div class="column is-3">
    <div class="box filter-sidebar">
      <h3 class="title is-4 mb-4">Filtra Opere</h3>
      
      <form method="GET" action="/Gallerist/catalogo/filtraCatalogo">
        
        <div class="field">
          <label class="label">Categoria</label>
          <div class="control">
            <div class="select is-fullwidth">
              <select name="categoria">
                <option value="">Tutte le categorie</option>
                <option value="pittura">Pittura</option>
                <option value="scultura">Scultura</option>
                <option value="fotografia">Fotografia</option>
              </select>
            </div>
          </div>
        </div>

        <div class="field">
          <label class="label">Prezzo Massimo (€)</label>
          <div class="control">
            <input class="input" type="number" name="prezzo_max" placeholder="Es. 500" min="0">
          </div>
        </div>

        <div class="field">
          <label class="label">Ordina per</label>
          <div class="control">
            <div class="select is-fullwidth">
              <select name="ordine">
                <option value="recenti">Più recenti</option>
                <option value="prezzo_asc">Prezzo: Crescente</option>
                <option value="prezzo_desc">Prezzo: Decrescente</option>
              </select>
            </div>
          </div>
        </div>

        <div class="field mt-5">
          <button type="submit" class="button is-primary is-fullwidth">
            Applica Filtri
          </button>
        </div>
        
      </form>
    </div>
  </div>


  <div class="column is-9">
    <h1 class="title is-3 mb-5">Scopri le opere disponibili</h1>

    <div class="columns is-multiline">
      
      <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('opere'), 'opera');
$foreach0DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('opera')->value) {
$foreach0DoElse = false;
?>
        
        <div class="column is-4">
          <div class="card h-full is-flex is-flex-direction-column artwork-card">
            
            <div class="card-image">
              <figure class="image is-4by3">
                <img src="<?php echo $_smarty_tpl->getValue('opera')->getUrlImmagine();?>
" alt="<?php echo $_smarty_tpl->getValue('opera')->getTitolo();?>
" class="artwork-img">
              </figure>
            </div>
            
            <div class="card-content is-flex-grow-1">
              <p class="title is-5 mb-1"><?php echo $_smarty_tpl->getValue('opera')->getTitolo();?>
</p>
              <p class="subtitle is-6 mb-3">di <a href="profilo.php?id=<?php echo $_smarty_tpl->getValue('opera')->getAutore()->getId();?>
"><?php echo $_smarty_tpl->getValue('opera')->getAutore()->getNome();?>
</a></p>
              
              <div class="tags">
                <span class="tag is-light"><?php echo $_smarty_tpl->getValue('opera')->getDimensioni();?>
</span>
              </div>
              
              <p class="is-size-4 has-text-weight-bold mt-4">
                € <?php echo $_smarty_tpl->getSmarty()->getModifierCallback('number_format')($_smarty_tpl->getValue('opera')->getPrezzo(),2,',','.');?>

              </p>
            </div>
            
            <footer class="card-footer">
              <a href="dettaglio_opera.php?id=<?php echo $_smarty_tpl->getValue('opera')->getId();?>
" class="card-footer-item has-background-light has-text-dark has-text-weight-bold">
                Vedi Dettagli
              </a>
            </footer>
            
          </div>
        </div>
        
      <?php
}
if ($foreach0DoElse) {
?>
        <div class="column is-12">
          <div class="notification is-warning is-light has-text-centered">
            <p>Nessuna opera trovata con questi filtri. Prova a modificare la tua ricerca.</p>
          </div>
        </div>
      <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
      </div>
  </div>
  
</div>
<?php
}
}
/* {/block 'content'} */
}
