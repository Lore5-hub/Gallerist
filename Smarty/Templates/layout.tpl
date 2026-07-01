<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>{block name=title}Gallerist{/block}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.2/css/bulma.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="/Gallerist/css/main.css"> 
</head>
<body>

    <nav class="navbar is-black" role="navigation" aria-label="main navigation">
        <div class="container">
            <div class="navbar-brand">
                <a class="navbar-item has-text-weight-bold is-size-4" href="/Gallerist/">
    <span class="icon mr-2"><i class="fas fa-home"></i></span>
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
    {if isset($utente_loggato) && $utente_loggato !== null}
        {* Utente loggato *}
        <div class="navbar-item has-text-light">
            <strong>@{$utente_loggato->getNickname()}</strong>
        </div>
        <hr class="navbar-divider">
        {if $utente_loggato->getRuolo() == 'Amministratore'}
            <a href="/Gallerist/Admin/dashboard" class="navbar-item has-text-light">
                <span class="icon mr-1"><i class="fas fa-cog"></i></span> Dashboard Admin
            </a>
        {elseif $utente_loggato->getRuolo() == 'Artista'}
    <a href="/Gallerist/utente/profilo" class="navbar-item has-text-light">
        <span class="icon mr-1"><i class="fas fa-palette"></i></span> Il mio profilo
    </a>
        {elseif $utente_loggato->getRuolo() == 'Utente registrato'}
            <a href="/Gallerist/utente/profilo" class="navbar-item has-text-light">
                <span class="icon mr-1"><i class="fas fa-user"></i></span> Il mio profilo
            </a>
        {/if}
        <hr class="navbar-divider">
        <a href="/Gallerist/utente/logout" class="navbar-item has-text-danger">
            <span class="icon mr-1"><i class="fas fa-sign-out-alt"></i></span> Logout
        </a>
    {else}
        {* Utente non loggato *}
        <a href="/Gallerist/utente/login" class="navbar-item has-text-light">
            Accedi
        </a>
        <a href="/Gallerist/utente/registrazione" class="navbar-item has-text-light">
            Registrati
        </a>
    {/if}
</div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <main>
        {block name=content}{/block}
    </main>

    <footer>
        <p>&copy; 2026 Gallerist - Progetto Universitario</p>
    </footer>

</body>
</html>