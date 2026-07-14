<?php

/**
 * Servizio per la conversione delle valute che si interfaccia con un Web Service REST esterno.
 */
class UValutaService {

    /**
     * Converte un oggetto EPrezzo in una nuova valuta interrogando un'API.
     * * @param EPrezzo $prezzo L'oggetto prezzo di partenza
     * @param string $valutaDestinazione La valuta target (es. "USD")
     * @return EPrezzo|null Restituisce il nuovo prezzo convertito o null in caso di errore di rete
     */
    public static function converti(EPrezzo $prezzo, string $valutaDestinazione): ?EPrezzo {
        
        // Se la valuta è la stessa, non sprecare risorse di rete
        if ($prezzo->getValuta() === $valutaDestinazione) {
            return $prezzo;
        }

        // Endpoint dell'API pubblica Frankfurter
        $url = "https://api.frankfurter.app/latest?from=" . $prezzo->getValuta() . "&to=" . $valutaDestinazione;

        // Inizializza la chiamata cURL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5); // Timeout di 5 secondi per non bloccare il sito
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // ← AGGIUNGI questa riga
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        // Esegue la richiesta HTTP GET
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        

        // Se la chiamata è andata a buon fine (codice 200)
        if ($httpCode == 200 && $response !== false) {
            
            // Decodifica il JSON ricevuto dal Web Service in un array PHP
            $data = json_decode($response, true);
            
            if (isset($data['rates'][$valutaDestinazione])) {
                $tassoDiCambio = $data['rates'][$valutaDestinazione];
                
                // Calcola il nuovo valore
                $nuovoValore = $prezzo->getValore() * $tassoDiCambio;
                
                // Restituisce un nuovo Value Object EPrezzo
                return new EPrezzo($nuovoValore, $valutaDestinazione);
            }
        }

        // Se c'è un errore (es. server API giù o senza connessione), fallisce in modo pulito
        return null;
    }
}
?>