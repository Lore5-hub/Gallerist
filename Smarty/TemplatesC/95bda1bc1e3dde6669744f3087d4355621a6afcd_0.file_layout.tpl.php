<?php
/* Smarty version 5.8.0, created on 2026-06-26 11:50:23
  from 'file:layout.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.8.0',
  'unifunc' => 'content_6a3e4b5f22fc53_12122905',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '95bda1bc1e3dde6669744f3087d4355621a6afcd' => 
    array (
      0 => 'layout.tpl',
      1 => 1782467413,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_6a3e4b5f22fc53_12122905 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\Users\\ranch\\Downloads\\xampp\\htdocs\\Gallerist\\Smarty\\Templates';
$_smarty_tpl->getInheritance()->init($_smarty_tpl, false);
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title><?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_11557671236a3e4b5f218874_95761719', 'title');
?>
</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.2/css/bulma.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="/Gallerist/css/main.css"> 
</head>
<body>

    <nav class="navbar is-black" role="navigation" aria-label="main navigation">
        <div class="container">
            <div class="navbar-brand">
                <a class="navbar-item has-text-weight-bold is-size-4" href="/Gallerist/">
                    Gallerist
                </a>
            </div>

            <div class="navbar-menu">
                <div class="navbar-end">
                    <div class="navbar-item has-dropdown is-hoverable">
                        <a class="navbar-link is-arrowless">
                            <span class="icon is-large has-text-grey-light">
                                <i class="fas fa-user-circle fa-2x"></i>
                            </span>
                        </a>

                        <div class="navbar-dropdown is-right">
                            <a href="/Gallerist/utente/login" class="navbar-item has-text-light">
                                Accedi
                            </a>
                            <a href="/Gallerist/utente/registrazione" class="navbar-item has-text-light">
                                Registrati
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <main>
        <?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_15794446006a3e4b5f22dc94_34538980', 'content');
?>

    </main>

    <footer>
        <p>&copy; 2026 Gallerist - Progetto Universitario</p>
    </footer>

</body>
</html><?php }
/* {block 'title'} */
class Block_11557671236a3e4b5f218874_95761719 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\Users\\ranch\\Downloads\\xampp\\htdocs\\Gallerist\\Smarty\\Templates';
?>
Gallerist<?php
}
}
/* {/block 'title'} */
/* {block 'content'} */
class Block_15794446006a3e4b5f22dc94_34538980 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\Users\\ranch\\Downloads\\xampp\\htdocs\\Gallerist\\Smarty\\Templates';
}
}
/* {/block 'content'} */
}
