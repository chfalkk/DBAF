<?php
    // Zugriffsdaten auf die API
    define('DB_CLIENT_ID', '390d486af3fc9c5c7c240cf89bd66eb4');
    define('DB_SECRET_KEY', '5e8f7211db219325fc4ac3cdeac04060');

    // Programm-Version
    define('DB_VERSION', '1.2');

    /**
     * Basis-Klasse für DB-API-Abfragen
     * Besitzt JSONResult, Fehlernachricht und eine Methode, um Datenabfragen durchzuführen (GetData) zur Vererbung
     */
    class DBAPI_Base {
        protected array $JSONResult = [];
        protected String $errorMessage = ''; // errorMessage wird ausgefüllt, wenn Fehler aufgetreten ist -> JSONResult ist leer
        
        /**
         * @return Array JSON-Ergebnis der vorher ausgeführten Abfrage
         */
        public function GetJSONResult() {
            return $this->JSONResult;
        }

        /**
         * @return String Fehler-Nachricht der vorher ausgeführten Abfrage (falls fehlgeschlagen) - leer, falls kein Fehler aufgetreten ist
         */
        public function GetErrorMessage() {
            return $this->errorMessage;
        }

        /**
         * HTTP-Code einer URL prüfen
         * @param String $URL abzufragende URL
         * @return Integer HTTP-Code
         */
        protected static function GetHTTPCode(String $URL) {
            $httpCode = 0;
            
            $curl = curl_init($URL);
            try {
                curl_setopt($curl,  CURLOPT_RETURNTRANSFER, true);

                $response = curl_exec($curl);
                $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            } finally {
                curl_close($curl);
            }

            return $httpCode;
        }

        /**
         * Daten von der API anhand der URL abholen und im JSON-Result speichern
         * @param String $URL abzufragende URL
         */
        protected function GetData(String $URL) {
            $this->JSONResult = [];
            $this->errorMessage = '';

            try {
                // CURL initialisieren
                $curl = curl_init();
                try {
                    // CURL ausführen mit sURL
                    curl_setopt_array($curl, [
                        CURLOPT_URL => $URL,
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => '',
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 30,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => 'GET',
                        CURLOPT_HTTPHEADER => [
                            'DB-Api-Key: ' . DB_SECRET_KEY,
                            'DB-Client-Id: ' . DB_CLIENT_ID,
                            'accept: application/json'
                        ],
                    ]);

                    $response = curl_exec($curl);
                    $err = curl_error($curl);
                    $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

                    // API-Fehler, z.B. 404
                    if ($httpCode != 200) {
                        throw new Exception('API-Fehler #' . $httpCode);
                    }
                } finally {
                    // CURL schließen
                    curl_close($curl);
                }

                // Auswertung
                if ($err) {
                    // Fehler ausgeben
                    throw new Exception('cURL Error #:' . $err);
                } else {
                    // response (String) zu Array parsen und zurückgeben
                    $JSON = json_decode($response);
                    
                    // alle Objekte in Arrays umwandeln
                    $JSON = $this->JSONtoArray($JSON);

                    // Fehler ausgeben, falls Fehlercode vorhanden ist
                    if (isset($JSON['errorCode']) || isset($JSON['errNo'])) {
                        $errNo = 0;
                        if (isset($JSON['errorCode'])) {
                            $errNo = $JSON['errorCode'];
                        } else if (isset($JSON['errNo'])) {
                            $errNo = $JSON['errNo'];
                        }
                        throw new Exception('API-Fehler #' . $errNo);
                    }

                    // Ergebnis speichern
                    $this->JSONResult = $JSON;
                }
            } catch (Exception $ex) {
                $this->errorMessage = 'Es ist ein Fehler aufgetreten! (' . $ex->getMessage() . ')';
            }
        }

        /**
         * Objekte innerhalb eines JSON-Formates werden zu Arrays ersetzt, wobei alle Attribute übernommen werden
         * @param mixed $data JSON-Daten
         * @return Array formattierte JSON-Daten als Array
         */
        private function JSONtoArray($data) {
            if (is_object($data)) {
                // in Array umwandeln
                $data = json_decode(json_encode($data), true);
            }

            // für jeden Eintrag im Array
            foreach ($data as $name => $value) {
                // falls Eintrag ein Objekt ist
                if (is_object($value)) {
                    // umwandeln und neu einfügen
                    $value = $this->JSONtoArray($value);
                    $data[$name] = $value;
                }
            }
            return $data;
        }

    }