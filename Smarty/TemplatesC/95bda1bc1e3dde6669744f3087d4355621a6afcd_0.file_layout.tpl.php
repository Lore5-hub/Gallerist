<?php
/* Smarty version 5.8.0, created on 2026-06-25 17:36:09
  from 'file:layout.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.8.0',
  'unifunc' => 'content_6a3d4ae9a15194_21921931',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '95bda1bc1e3dde6669744f3087d4355621a6afcd' => 
    array (
      0 => 'layout.tpl',
      1 => 1782401766,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_6a3d4ae9a15194_21921931 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\Users\\ranch\\Downloads\\xampp\\htdocs\\Gallerist\\Smarty\\Templates';
$_smarty_tpl->getInheritance()->init($_smarty_tpl, false);
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title><?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_684318206a3d4ae9a10123_90212784', 'title');
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
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_4042862746a3d4ae9a14313_78095190', 'content');
?>

    </main>

    <footer>
        <p>&copy; 2026 Gallerist - Progetto Universitario</p>
    </footer>

</body>
</html><?php }
/* {block 'title'} */
class Block_684318206a3d4ae9a10123_90212784 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\Users\\ranch\\Downloads\\xampp\\htdocs\\Gallerist\\Smarty\\Templates';
?>
Gallerist<?php
}
}
/* {/block 'title'} */
/* {block 'content'} */
class Block_4042862746a3d4ae9a14313_78095190 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\Users\\ranch\\Downloads\\xampp\\htdocs\\Gallerist\\Smarty\\Templates';
}
}
/* {/block 'content'} */
}
