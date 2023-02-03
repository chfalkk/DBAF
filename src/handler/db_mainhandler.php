<?php
    require_once 'db_stada.php';

    /**
     * Klasse für alle Funktionen, welche von verschiedenen Unterseiten der gesamten Website gebraucht werden
     */
    class MainHandler {

        /**
         * Abfrage, ob der Client zum Internet verbunden ist
         * @return Boolean Verbindungsstatus
         */
        public function IsInternetConnected() {
            $connection = @fsockopen('https://www.bahn.de/', 80);

            // Prüfen, ob Verbindung existiert
            if ($connection) {
                fclose($connection);
                return true;
            } else {
                return false;
            }
        }

        /**
         * Alle Bahnhofstationen von der StaDa-API abholen
         * @return Array Stationen 
         */
        public function GetAllStations() {
            // Abfrage mit allen Stationsdaten abholen
            $request = new DBAPI_StaDa();
            $request->GetStations(new StationFilter());
            $result = $request->GetJSONResult();

            $stations = [];
            $total = $result['total'];

            // stations mit allen Stations-Namen erstellen
            for ($i = 0; $i < $total; $i++) {
                array_push($stations, $result['result'][$i]['name']);
            }

            // alphabetisch sortieren
            array_multisort($stations);

            return $stations;
        }

    }