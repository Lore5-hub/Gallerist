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
        {block name=content}{/block}
    </main>

    <footer>
        <p>&copy; 2026 Gallerist - Progetto Universitario</p>
    </footer>

</body>
</html>