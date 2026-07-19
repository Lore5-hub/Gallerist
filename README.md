# 🎨 Gallerist — Marketplace di Arte Online

> Progetto universitario 

---

## 📌 Descrizione

**Gallerist** è una piattaforma web per la compravendita di opere d'arte originali.
Permette agli artisti di pubblicare e vendere le proprie opere, agli utenti di acquistarle o fare offerte, e agli amministratori di moderare la piattaforma.

---

## 👥 Componenti del Gruppo



| Patrick Ranchi 
| Lorenzo Di Zio |  
| Angelo Balint | 

---

## 🚀 Tecnologie Utilizzate

| Layer | Tecnologia |
|-------|-----------|
| Backend | PHP 8+ |
| Template Engine | Smarty |
| Frontend | Bulma CSS + JavaScript |
| Database | MySQL (XAMPP) |
| Email | PHPMailer + Mailtrap |
| Web Service | Frankfurter API (cambio valuta) |
| Versioning | Git + GitHub |

---

## 🏗️ Architettura

Il progetto segue le seguenti convenzioni:

```
CFrontController → Controller (C*) → FPersistentManager → Foundation (F*) → FDataBase
                                                         ↕
                                                    Entity (E*)
                                                         ↕
                                                    View (V*) → Smarty Templates
```

**Pattern utilizzati:**
- **Singleton** — `FDataBase`, `USession`
- **State Pattern** — `EStatoOpera`, `EStatoSegnalazione`
- **Facade** — `FPersistentManager`
- **Front Controller** — `CFrontController`

---

## ✅ Funzionalità Implementate

### 👤 Gestione Utenti
- Registrazione utente standard e artista (con upload documento d'identità e portfolio)
- Login con verifica credenziali e controllo ban
- Logout e timeout sessione (30 minuti di inattività)
- Recupero password via email con token sicuro
- Modifica profilo (nickname, biografia, foto profilo)

### 🖼️ Catalogo Opere
- Homepage con opere più apprezzate
- Esplorazione catalogo con filtri (categoria, prezzo massimo, ordinamento)
- Dettaglio opera con immagini multiple, tag, recensioni
- Conversione valuta in tempo reale (EUR, USD, GBP, JPY, CHF) tramite API Frankfurter

### 💰 Compravendita
- Acquisto diretto con transazione PDO e locking pessimistico (SELECT FOR UPDATE)
- Sistema di offerte con validazione prezzo
- Riepilogo ordine con modifica indirizzo di spedizione e scelta metodo di pagamento
- Notifiche email per acquisto, offerta inviata/accettata

### ⭐ Interazioni
- Recensioni con valutazione da 1 a 5 stelle
- Segnalazione di commenti, opere e profili
- Risposta alle offerte ricevute (accetta/rifiuta)

### 🎨 Dashboard Artista
- Gestione portfolio (aggiunta, eliminazione opere con upload immagini)
- Visualizzazione offerte ricevute
- Storico vendite con grafici (Chart.js) e filtro per periodo
- Statistiche guadagni con distinzione vendite dirette/offerte

### 🔧 Pannello Amministratore
- Dashboard con statistiche reali e percentuali di variazione
- Validazione profili artista (con visualizzazione documento e portfolio)
- Moderazione segnalazioni (ban temporaneo/permanente, rimozione contenuti)
- Gestione categorie
- Statistiche piattaforma con grafici visite e guadagni
- Tracking visite con sessioni uniche vs pageviews

---

## 🛠️ Installazione

### Requisiti
- XAMPP (PHP 8.0+, MySQL, Apache)
- Composer

### Passi

1. **Clona la repository:**
   ```bash
   git clone https://github.com/Lore5-hub/Gallerist.git
   cd Gallerist
   ```

2. **Installa le dipendenze:**
   ```bash
   composer install
   ```

3. **Importa il database:**
   - Apri phpMyAdmin (`http://localhost/phpmyadmin`)
   - Crea un nuovo database chiamato `gallerist`
   - Importa il file `gallerist.sql`

4. **Configura il progetto:**
   - Apri il browser e vai su `http://localhost/Gallerist`
   - Segui la procedura di installazione guidata
   - Oppure crea manualmente `config.inc.php` nella root del progetto:
   ```php
   <?php
   define('COOKIE_EXP_TIME', 3600);
   $GLOBALS['database'] = 'gallerist';
   $GLOBALS['username'] = 'root';
   $GLOBALS['password'] = '';
   define('SMTP_HOST', 'sandbox.smtp.mailtrap.io');
   define('SMTP_PORT', 2525);
   define('SMTP_USER', 'YOUR_MAILTRAP_USER');
   define('SMTP_PASS', 'YOUR_MAILTRAP_PASS');
   define('SMTP_SECURE', 'tls');
   define('SMTP_FROM_EMAIL', 'noreply@gallerist.local');
   define('SMTP_FROM_NAME', 'Gallerist');
   define('ADMIN_EMAIL', 'admin@gallerist.local');
   ?>
   ```

5. **Accedi all'applicazione:**
   - URL: `http://localhost/Gallerist`
   - Admin di default: email `admin@gallerist.it` / password `password`
   

---

## 📧 Configurazione Email (Mailtrap)

Il progetto usa **Mailtrap** per intercettare le email in ambiente di sviluppo.

Le email vengono inviate nei seguenti casi:
- Registrazione utente → email di benvenuto
- Registrazione artista → notifica all'amministratore
- Approvazione artista → notifica all'artista
- Acquisto opera → conferma all'acquirente
- Nuova offerta → notifica all'artista
- Offerta accettata → notifica all'acquirente
- Recupero password → link di reset
- Provvedimento disciplinare → notifica all'utente bannato

---

## 🗄️ Schema Database

Le tabelle principali sono:

| Tabella | Descrizione |
|---------|-------------|
| `utente` | Utenti registrati (standard, artisti, admin) |
| `artista` | Profilo esteso degli artisti |
| `opera` | Opere d'arte pubblicate |
| `immagine` | Immagini associate alle opere |
| `categoria` | Categorie delle opere |
| `tecnica` | Tecniche artistiche |
| `tag` / `opera_tag` | Tag e relazione many-to-many con le opere |
| `commento` | Recensioni degli utenti |
| `ordine` | Ordini di acquisto |
| `offerta` | Proposte di offerta |
| `segnalazione` | Segnalazioni di contenuti |
| `provvedimento` | Provvedimenti disciplinari (ban) |
| `visita` | Tracking visite con sessioni |
| `password_reset` | Token per il recupero password |

---

## 📁 Struttura del Progetto

```
Gallerist/
├── Control/          # Controller 
├── Entity/           # Classi di dominio
├── Foundation/       # Layer di persistenza
├── View/             # Classi View
├── Utility/          # Classi di utilità (USession, UEmail, UValutaService)
├── Smarty/
│   ├── Templates/    # Template .tpl
│   └── TemplatesC/   # Template compilati (generati automaticamente)
├── uploads/          # File caricati dagli utenti
├── css/              # Fogli di stile
├── js/               # Script JavaScript
├── vendor/           # Dipendenze Composer (PHPMailer)
├── index.php         # Entry point
├── StartSmarty.php   # Configurazione Smarty
├── Installation.php  # Procedura di installazione
├── config.inc.php    # Configurazione DB e SMTP
└── gallerist.sql     # Script SQL con struttura e dati di esempio
```

---
## 🌐 Sito Online
[https://gallerist.infinityfree.io]
## 📝 Note

- Il progetto è configurato per ambiente locale (XAMPP)
- `config.inc.php` contiene credenziali sensibili
- Le email vengono intercettate da Mailtrap in ambiente di sviluppo
- Il DB viene popolato automaticamente con dati di esempio tramite `gallerist.sql`
