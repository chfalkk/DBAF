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
            $filter = new StationFilter();
            $filter->offset = 5103;
            $filter->limit = 1;
            $request->GetStations($filter);
            $result = $request->GetJSONResult();

            $stations = [];
            $total = $result['total'];

            var_dump($result['result'][0]);


            // stations mit allen Stations-Namen erstellen
            // for ($i = 5103; $i < $total; $i++) {
            //     $station = [];
            //     $station['name'] = $result['result'][$i]['name'];
            //     $station['id'] = $result['result'][$i]['evaNumbers'][0]['number'];

            //     // var_dump($result['result'][$i]['name']);
            //     echo "$i ";
            //     var_dump($result['result'][$i]['evaNumbers'][0]['number']);
            //     echo "<br>";

            //     array_push($stations, $station);
            // }

            // alphabetisch sortieren
            array_multisort($stations);

            return $stations;
        }

    }