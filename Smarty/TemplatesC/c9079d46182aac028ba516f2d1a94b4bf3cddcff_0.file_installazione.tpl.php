<?php
/* Smarty version 5.8.0, created on 2026-06-23 18:52:56
  from 'file:installazione.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.8.0',
  'unifunc' => 'content_6a3ab9e8850423_07774116',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'c9079d46182aac028ba516f2d1a94b4bf3cddcff' => 
    array (
      0 => 'installazione.tpl',
      1 => 1782233351,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_6a3ab9e8850423_07774116 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\Users\\ranch\\Downloads\\xampp\\htdocs\\Gallerist\\Smarty\\Templates';
?><!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Installazione - Gallerist</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f6f9;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .install-container {
            background: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 450px;
        }
        h1 {
            font-size: 24px;
            margin-bottom: 10px;
            color: #2c3e50;
            text-align: center;
        }
        p.subtitle {
            text-align: center;
            color: #7f8c8d;
            font-size: 14px;
            margin-bottom: 25px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
            font-size: 14px;
            color: #34495e;
        }
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 14px;
        }
        input:focus {
            border-color: #3498db;
            outline: none;
        }
        button {
            width: 100%;
            padding: 12px;
            background-color: #2ecc71;
            border: none;
            color: white;
            font-size: 16px;
            font-weight: bold;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 15px;
            transition: background 0.2s;
        }
        button:hover {
            background-color: #27ae60;
        }
        .error-box {
            background-color: #f8d7da;
            color: #721c24;
            padding: 12px;
            border-radius: 4px;
            margin-bottom: 20px;
            font-size: 14px;
            border-left: 5px solid #f5c6cb;
        }
    </style>
</head>
<body>

<div class="install-container">
    <h1>Gallerist</h1>
    <p class="subtitle">Pannello di Installazione di Sistema</p>

        <?php if ((true && ($_smarty_tpl->hasVariable('nophpv') && null !== ($_smarty_tpl->getValue('nophpv') ?? null)))) {?>
        <div class="error-box">❌ <strong>Errore:</strong> La versione di PHP è inferiore alla 8.0.0 richiesta.</div>
    <?php }?>
    <?php if ((true && ($_smarty_tpl->hasVariable('nocookie') && null !== ($_smarty_tpl->getValue('nocookie') ?? null)))) {?>
        <div class="error-box">❌ <strong>Errore:</strong> I cookie sembrano essere disabilitati nel tuo browser.</div>
    <?php }?>
    <?php if ((true && ($_smarty_tpl->hasVariable('nojs') && null !== ($_smarty_tpl->getValue('nojs') ?? null)))) {?>
        <div class="error-box">❌ <strong>Errore:</strong> JavaScript non è attivo o il cookie di verifica è mancante.</div>
    <?php }?>

   <form action="" method="POST" onsubmit="document.cookie = 'checkjs=attivo; max-age=3600; path=/Gallerist';">
        <div class="form-group">
            <label for="nomedb">Nome del Database</label>
            <input type="text" id="nomedb" name="nomedb" placeholder="Es. gallerist" required>
        </div>

        <div class="form-group">
            <label for="nomeutente">Username Database (DB User)</label>
            <input type="text" id="nomeutente" name="nomeutente" value="root" required>
        </div>

        <div class="form-group">
            <label for="password">Password Database</label>
            <input type="password" id="password" name="password" placeholder="Lascia vuoto su XAMPP standard">
        </div>

        <button type="submit" name="installa">Avvia Installazione</button>
    </form>
</div>

<?php echo '<script'; ?>
>
    // Crea il cookie specifico per la sottocartella /Gallerist sia al caricamento
    document.cookie = "checkjs=attivo; max-age=3600; path=/Gallerist";
<?php echo '</script'; ?>
>

</body>
</html>
<?php }
}
