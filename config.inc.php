<?php
define('COOKIE_EXP_TIME', 3600);
$GLOBALS['database'] = 'gallerist';
$GLOBALS['username'] = 'root';
$GLOBALS['password'] = '';

// --- Configurazione SMTP (Mailtrap) ---
define('SMTP_HOST', 'sandbox.smtp.mailtrap.io');
define('SMTP_PORT', 2525);
define('SMTP_USER', 'bbb3b62a076d8d');
define('SMTP_PASS', '4f270dd32f84f6');
define('SMTP_SECURE', 'tls');
define('SMTP_FROM_EMAIL', 'noreply@gallerist.local');
define('SMTP_FROM_NAME', 'Gallerist');
define('ADMIN_EMAIL', 'admin@gallerist.local');
?>