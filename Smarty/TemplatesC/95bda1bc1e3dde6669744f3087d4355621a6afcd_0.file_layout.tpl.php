<?php
/* Smarty version 5.8.0, created on 2026-06-24 09:32:23
  from 'file:layout.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.8.0',
  'unifunc' => 'content_6a3b8807793681_98898320',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '95bda1bc1e3dde6669744f3087d4355621a6afcd' => 
    array (
      0 => 'layout.tpl',
      1 => 1782286311,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_6a3b8807793681_98898320 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\Users\\ranch\\Downloads\\xampp\\htdocs\\Gallerist\\Smarty\\Templates';
$_smarty_tpl->getInheritance()->init($_smarty_tpl, false);
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title><?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_828051716a3b8807784d83_59076012', 'title');
?>
</title>
    
    <link rel="stylesheet" href="/Gallerist/css/main.css"> 
</head>
<body>

    <header>
        <h1>Gallerist</h1>
    </header>

    <main>
        <?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_20098207176a3b8807792343_55142989', 'content');
?>

    </main>

    <footer>
        <p>&copy; 2026 Gallerist - Progetto Universitario</p>
    </footer>

</body>
</html><?php }
/* {block 'title'} */
class Block_828051716a3b8807784d83_59076012 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\Users\\ranch\\Downloads\\xampp\\htdocs\\Gallerist\\Smarty\\Templates';
?>
Gallerist<?php
}
}
/* {/block 'title'} */
/* {block 'content'} */
class Block_20098207176a3b8807792343_55142989 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\Users\\ranch\\Downloads\\xampp\\htdocs\\Gallerist\\Smarty\\Templates';
}
}
/* {/block 'content'} */
}
