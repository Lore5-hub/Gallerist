{extends file='layout.tpl'}
{block name=content}
<section class="section hero is-info is-fullheight auth-hero-bg">
    <div class="hero-body">
        <div class="container">
            <div class="columns is-centered">
                <div class="column is-4-desktop is-6-tablet">
                    <div class="box p-6 auth-box">
                        <div class="has-text-centered mb-5">
                            <h1 class="title has-text-dark">Password dimenticata?</h1>
                            <p class="subtitle is-6 has-text-grey">Inserisci la tua email per ricevere il link di reset</p>
                        </div>

                        {if isset($errore)}
                            <div class="notification is-danger is-light mb-4">
                                <button class="delete" onclick="this.parentElement.remove()"></button>
                                {$errore}
                            </div>
                        {/if}

                        {if isset($successo)}
                            <div class="notification is-success is-light mb-4">
                                <button class="delete" onclick="this.parentElement.remove()"></button>
                                {$successo}
                            </div>
                        {/if}

                        <form method="POST" action="/Gallerist/utente/inviaLinkReset">
                            <div class="field">
                                <label class="label">Email</label>
                                <div class="control has-icons-left">
                                    <input class="input is-medium" type="email" name="email" 
                                           placeholder="tua@email.com" required>
                                    <span class="icon is-small is-left">
                                        <i class="fas fa-envelope"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="field mt-5">
                                <button type="submit" class="button is-primary is-medium is-fullwidth">
                                    Invia link di reset
                                </button>
                            </div>
                        </form>

                        <hr class="mt-5 mb-4">
                        <div class="has-text-centered">
                            <a href="/Gallerist/utente/login" class="has-text-info">
                                Torna al login
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
{/block}