{extends file='layout.tpl'}
{block name=content}
<section class="hero is-info is-fullheight auth-hero-bg">
  <div class="hero-body">
    <div class="container">
      <div class="columns is-centered">
        
        <div class="column is-4-desktop is-6-tablet">
          
          {if isset($errore_login)}
          <div class="notification is-danger is-light">
            <button class="delete" onclick="this.parentElement.remove()"></button>
            <span class="icon"><i class="fas fa-exclamation-triangle"></i></span>
            {$errore_login}
          </div>
          {/if}

          <div class="box p-6 auth-box">
            
            <div class="has-text-centered mb-5">
              <h1 class="title has-text-dark">Bentornato!</h1>
              <p class="subtitle is-6 has-text-grey">Inserisci le tue credenziali per accedere</p>
            </div>

            <form method="POST" action="/Gallerist/Utente/verifica">
              
              <div class="field">
                <label class="label">Email</label>
                <div class="control has-icons-left">
                  <input class="input is-medium {if isset($errore_login)}is-danger{/if}" type="email" name="email" value="{if isset($email_inserita)}{$email_inserita}{/if}" placeholder="tua@email.com" required />
                  <span class="icon is-small is-left">
                    <i class="fas fa-envelope"></i>
                  </span>
                </div>
              </div>

              <div class="field mt-4">
                <label class="label">Password</label>
                <div class="control has-icons-left">
                  <input class="input is-medium {if isset($errore_login)}is-danger{/if}" type="password" name="password" placeholder="********" required />
                  <span class="icon is-small is-left">
                    <i class="fas fa-lock"></i>
                  </span>
                </div>
              </div>

              <div class="field mt-5">
                <button type="submit" class="button is-primary is-medium is-fullwidth has-text-weight-bold">
                  Accedi
                </button>
              </div>
              
            </form>

            <hr class="mt-5 mb-4">
            
            <div class="has-text-centered">
              <p class="is-size-6">
                Sei nuovo qui? 
                <a href="/Gallerist/utente/registrazione" class="has-text-info has-text-weight-bold">Registrati ora</a>
              </p>
            </div>

          </div>
          
        </div>
        
      </div>
    </div>
  </div>
</section>
{/block}