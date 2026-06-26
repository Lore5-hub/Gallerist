<?php
/* Smarty version 5.8.0, created on 2026-06-25 17:58:54
  from 'file:homepage.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.8.0',
  'unifunc' => 'content_6a3d503e308604_77980174',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'c0f21ab22a0fc64fe925a8ec432410d37e7510e9' => 
    array (
      0 => 'homepage.tpl',
      1 => 1782399917,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_6a3d503e308604_77980174 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\Users\\ranch\\Downloads\\xampp\\htdocs\\Gallerist\\Smarty\\Templates';
$_smarty_tpl->getInheritance()->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_21094068606a3d503e2fa563_77809570', 'content');
$_smarty_tpl->getInheritance()->endChild($_smarty_tpl, 'layout.tpl', $_smarty_current_dir);
}
/* {block 'content'} */
class Block_21094068606a3d503e2fa563_77809570 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\Users\\ranch\\Downloads\\xampp\\htdocs\\Gallerist\\Smarty\\Templates';
?>


 
<section class="hero is-black is-medium">
  <div class="hero-body">
    <div class="container has-text-centered">
      <h1 class="title is-1 has-text-white">Gallerist</h1>
      <p class="subtitle is-4 mt-3 has-text-grey-light">
        Scopri, acquista e vendi opere d'arte uniche da tutto il mondo
      </p>
      <div class="columns is-centered mt-5">
        <div class="column is-6">
          <form action="catalogo.php" method="GET">
            <div class="field has-addons">
              <div class="control is-expanded has-icons-left">
                <input class="input is-medium" type="text" name="ricerca" placeholder="Cerca un'opera, un artista o una tecnica...">
                <span class="icon is-small is-left">
                  <i class="fas fa-search"></i>
                </span>
              </div>
              <div class="control">
                <button type="submit" class="button is-primary is-medium has-text-weight-bold">Cerca</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="is-flex is-justify-content-space-between is-align-items-flex-end mb-5">
      <h2 class="title is-3 mb-0">Esplora per Categorie</h2>
      <a href="Gallerist/catalogo/esploracatalogo" class="button is-outlined is-link">
        Esplora Catalogo <i class="fas fa-arrow-right ml-2"></i>
      </a>
    </div>

    <div class="tile is-ancestor">
      <!-- Categoria Principale Grande -->
      <div class="tile is-parent is-8">
        <a href="catalogo.php?categoria=pittura" class="tile is-child box p-0 is-clipped home-category-tile is-main">
          <img src="img/categoria-pittura.jpg" alt="Pittura" class="home-category-tile-img">
          <div class="is-overlay is-flex is-align-items-flex-end p-5 home-category-tile-overlay">
            <h3 class="title is-2 has-text-white">Pittura</h3>
          </div>
        </a>
      </div>

      <!-- Colonne Laterali Piccole -->
      <div class="tile is-vertical is-4">
        <div class="tile is-parent">
          <a href="catalogo.php?categoria=scultura" class="tile is-child box p-0 is-clipped home-category-tile is-sub">
            <img src="img/categoria-scultura.jpg" alt="Scultura" class="home-category-tile-img">
            <div class="is-overlay is-flex is-align-items-flex-end p-4 home-category-tile-overlay">
              <h3 class="title is-4 has-text-white">Scultura</h3>
            </div>
          </a>
        </div>
        
        <div class="tile is-parent">
          <a href="catalogo.php?categoria=fotografia" class="tile is-child box p-0 is-clipped home-category-tile is-sub">
            <img src="img/categoria-fotografia.jpg" alt="Fotografia" class="home-category-tile-img">
            <div class="is-overlay is-flex is-align-items-flex-end p-4 home-category-tile-overlay">
              <h3 class="title is-4 has-text-white">Fotografia</h3>
            </div>
          </a>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="section has-background-light">
  <div class="container">
    <div class="has-text-centered mb-6">
      <h2 class="title is-3">Opere più apprezzate</h2>
      <p class="subtitle is-6 has-text-grey">I capolavori più votati dalla nostra community</p>
    </div>

    <div class="columns is-multiline">
      <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('opere_popolari'), 'opera');
$foreach0DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('opera')->value) {
$foreach0DoElse = false;
?>
        <div class="column is-3-desktop is-6-tablet">
          <a href="dettaglio_opera.php?id=<?php echo $_smarty_tpl->getValue('opera')->getId();?>
">
            <div class="card is-shadowless home-popular-card">
              <div class="card-image box p-1 home-popular-img-box">
                <figure class="image is-4by3">
                  <img src="<?php echo $_smarty_tpl->getValue('opera')->getUrlImmagine();?>
" alt="Opera: <?php echo $_smarty_tpl->getValue('opera')->getId();?>
">
                </figure>
              </div>
            </div>
          </a>
        </div>
      <?php
}
if ($foreach0DoElse) {
?>
        <div class="column is-12 has-text-centered">
          <p class="has-text-grey">Al momento non ci sono opere popolari da mostrare.</p>
        </div>
      <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
    </div>
  </div>
</section>
   <?php
}
}
/* {/block 'content'} */
}
