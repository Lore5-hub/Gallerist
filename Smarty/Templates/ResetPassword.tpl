{extends file='layout.tpl'}
{block name=content}
<section class="section hero is-info is-fullheight auth-hero-bg">
    <div class="hero-body">
        <div class="container">
            <div class="columns is-centered">
                <div class="column is-4-desktop is-6-tablet">
                    <div class="box p-6 auth-box">
                        <div class="has-text-centered mb-5">
                            <h1 class="title has-text-dark">Nuova Password</h1>
                            <p class="subtitle is-6 has-text-grey">Inserisci la tua nuova password</p>
                        </div>

                        {if isset($errore)}
                            <div class="notification is-danger is-light mb-4">
                                <button class="delete" onclick="this.parentElement.remove()"></button>
                                {$errore}
                            </div>
                        {/if}

                        <form method="POST" action="/Gallerist/utente/resetPassword?token={$token}">
                            <div class="field">
                                <label class="label">Nuova Password</label>
                                <div class="control has-icons-left">
                                    <input class="input is-medium" type="password" name="password" 
                                           minlength="8" placeholder="••••••••" required>
                                    <span class="icon is-small is-left">
                                        <i class="fas fa-lock"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="field mt-4">
                                <label class="label">Conferma Password</label>
                                <div class="control has-icons-left">
                                    <input class="input is-medium" type="password" name="conferma_password" 
                                           minlength="8" placeholder="••••••••" required>
                                    <span class="icon is-small is-left">
                                        <i class="fas fa-lock"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="field mt-5">
                                <button type="submit" class="button is-primary is-medium is-fullwidth">
                                    Aggiorna Password
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
{/block}